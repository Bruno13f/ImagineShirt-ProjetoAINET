<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Response;
use App\Models\Encomendas;
use App\Models\Precos;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\Http\RedirectResponse;
use RealRashid\SweetAlert\Facades\Alert;
use Auth;

class EncomendasController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(User::class, 'encomenda');
    }

    public function index(Request $request): View{

        $user = Auth::user();

        $queryEncomendas = Encomendas::query();

        $pesquisaFiltro = $request->pesquisa ?? '';

        $flag = false;

        if ($pesquisaFiltro !== ''){

            // como customer id = user id faz se logo o join

            if(preg_match('/^([0-9]+)$/', $pesquisaFiltro)){
                
                $queryEncomendas->where('id','=',$pesquisaFiltro);

            }else{
                $flag = true;
                $queryEncomendas->select('orders.id as order_id', 'status', 'customer_id', 'total_price', 'orders.created_at as created','users.name as name', 'users.email as email')->join('users','users.id','orders.customer_id')
                ->where(function ($query) use ($pesquisaFiltro) {
                    $query->where('users.name', 'LIKE', '%' . $pesquisaFiltro . '%')
                        ->orWhere('users.email', 'LIKE', '%' . $pesquisaFiltro . '%');
                });
            }
        }

        $selecionarFiltro = $request->selecionar ?? 'todas';

        if ($selecionarFiltro != 'todas'){
            $queryEncomendas->where('status','LIKE',$selecionarFiltro);
        }

        $ordenarFiltro = $request->ordenar ?? 'date_desc';

        if (str_contains($ordenarFiltro,'date')){
            $ordenarArray = preg_split("/[_\s:]/",$ordenarFiltro);
            $queryEncomendas->orderBy('orders.created_at',$ordenarArray[1]);
        }elseif(str_contains($ordenarFiltro,'prec')){
            $ordenarArray = preg_split("/[_\s:]/",$ordenarFiltro);
            $queryEncomendas->orderBy('total_price',$ordenarArray[1]);
        }

        // Devido à consulta pelo nome/email cliente necessário dar select - devido a colunas ambíguas

        if($user->user_type == 'A'){

            if ($flag){
                $encomendas = $queryEncomendas->paginate(15);
            }else{
                $encomendas = $queryEncomendas->select('orders.id as order_id', 'status', 'customer_id', 'total_price', 'orders.created_at as created','users.name as name', 'users.email as email')->join('users','users.id','orders.customer_id')->paginate(15);
            }
        
        }

        if($user->user_type == 'E'){

            if (!$flag){
                $queryEncomendas->select('orders.id as order_id', 'status', 'customer_id', 'total_price', 'orders.created_at as created','users.name as name', 'users.email as email')->join('users','users.id','orders.customer_id');
            }

            $encomendas = $queryEncomendas->whereIn('status', ['pending', 'paid'])->paginate(15);
        }

        if($user->user_type == 'C'){

            $queryEncomendas->where('customer_id', '=', $user->id);

            if ($flag){
                $encomendas = $queryEncomendas->paginate(15);
            }else{
                $encomendas = $queryEncomendas->select('orders.id as order_id', 'status', 'customer_id', 'total_price', 'orders.created_at as created','users.name as name', 'users.email as email')->join('users','users.id','orders.customer_id')->paginate(15);
            }

            
        }

        return view('encomendas.index', compact('encomendas','user','pesquisaFiltro','ordenarFiltro','selecionarFiltro'));
    }

    public function generatePDF(Encomendas $encomenda): BinaryFileResponse
    {

        $pdfContent = self::getPdf($encomenda);
        
        $filename = 'encomenda_' . $encomenda->id . '.pdf';

        $pdfPath = 'pdf_receipts/' . $filename;
        Storage::put($pdfPath, $pdfContent);

        return response()->download(storage_path('app/' . $pdfPath));
    }

    public function show(Encomendas $encomenda): View{

        $descontos = self::getPrices();

        return view('encomendas.show', compact('encomenda', 'descontos'));
    }

    public function showRecibo(Encomendas $encomenda): View{

        $descontos = self::getPrices();

        return view('encomendas.pdf', compact('encomenda', 'descontos'));
    }

     public function changeStatus(Request $request, Encomendas $encomenda): RedirectResponse {

        $htmlMessage = "";

        switch($request->status){
            case 'Pagar':
                $status = 'paid';
                break;
            case 'Fechar':
                $encomenda->receipt_url = 'pdf_receipts/encomenda_' . $encomenda->id . '.pdf';
                $pdfContent = self::getPdf($encomenda);
                Storage::put($encomenda->receipt_url, $pdfContent);
                $htmlMessage = 'PDF da encomenda criado!';
                $status = 'closed';
                break;
            default:
                $status = $request->status;
        }

        $encomenda->status = $status;
        $encomenda->save();

        Alert::success('Estado da encomenda alterado com sucesso!',$htmlMessage);

        return redirect()->route('encomendas');
    } 

    private function getPDF(Encomendas $encomenda): String
    {
        $descontos = self::getPrices();

        $html = view('encomendas.pdf', compact('encomenda', 'descontos'))->render();

        $dompdf = new Dompdf();

        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'portrait');

        $dompdf->set_option('isRemoteEnabled', true);
        $dompdf->set_option('isHtml5ParserEnabled', true);
        $dompdf->set_option('enable_css_float', true);
        $dompdf->set_option('enable_font_subsetting', true);
        $dompdf->set_option('enable_javascript', true);

        $dompdf->render();

        $pdfContent = $dompdf->output();

        return $pdfContent;
    }


    private function getPrices (){

        $precocatalogo = Precos::select('unit_price_catalog')->first()->unit_price_catalog;
        $precocatalogodisc = Precos::select('unit_price_catalog_discount')->first()->unit_price_catalog_discount;
        $precoown = Precos::select('unit_price_own')->first()->unit_price_own;
        $precoowndisc = Precos::select('unit_price_own_discount')->first()->unit_price_own_discount;
        $quantdesconto = Precos::select('qty_discount')->first()->qty_discount;

        $descontocatalogo = $precocatalogo - $precocatalogodisc;
        $descontoown = $precoown - $precoowndisc;

        return compact('descontocatalogo','descontoown','quantdesconto');
    }
        
}
    
