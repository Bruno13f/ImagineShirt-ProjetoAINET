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

    public function index(): View{

        $user = Auth::user();
        
        if($user->user_type == 'A'){
            $encomendas = Encomendas::orderByDesc('date')->paginate(15);
        }

        if($user->user_type == 'E'){
            $encomendas = Encomendas::where('status','=','pending')->orwhere('status','=','paid')
            ->orderByDesc('date')->paginate(15);
        }

        if($user->user_type == 'C'){

            $encomendas = Encomendas::where('customer_id', '=', $user->id)->orderByDesc('date')->paginate(15);
        }

        return view('encomendas.index', compact('encomendas','user'));
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
    
