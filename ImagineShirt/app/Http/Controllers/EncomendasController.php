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
    public function generatePDF($encomenda): BinaryFileResponse
    {
        $encomendaData = self::dadosRecibo($encomenda);
        $itemsData = self::itensEncomenda($encomenda);
        $descontos = self::getPrices();

        $html = view('encomendas.pdf', compact('encomendaData', 'itemsData','descontos'))->render();

        $dompdf = new Dompdf();

        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'portrait');

        $dompdf->set_option('isRemoteEnabled', true);
        $dompdf->set_option('isHtml5ParserEnabled', true);
        $dompdf->set_option('enable_css_float', true);
        $dompdf->set_option('enable_font_subsetting', true);
        $dompdf->set_option('enable_javascript', true);

        $dompdf->render();

        $filename = 'encomenda_' . $encomenda . '.pdf';

        $pdfContent = $dompdf->output();

        $pdfPath = 'pdf_receipts/' . $filename;
        Storage::put($pdfPath, $pdfContent);

        return response()->download(storage_path('app/' . $pdfPath));
    }

    private function dadosRecibo($encomenda){
        
        $encomendaData = Encomendas::select('orders.id','orders.status','orders.total_price','orders.nif','orders.payment_type','orders.payment_ref','orders.notes','users.name','orders.address','users.email','orders.date')
        ->leftJoin('customers','customer_id','=','customers.id')
        ->leftJoin('users','customers.id','=','users.id')
        ->findOrFail($encomenda);

        return $encomendaData;
    }

    private function itensEncomenda($encomenda){

        $itemsData = Encomendas::select('tshirt_images.name','order_items.qty','order_items.size','order_items.unit_price','order_items.sub_total','tshirt_images.customer_id','colors.code as code_color','colors.name as color_name','tshirt_images.image_url')
        ->leftJoin('order_items','orders.id','=','order_items.order_id')
        ->leftJoin('tshirt_images','order_items.tshirt_image_id','=','tshirt_images.id')
        ->leftJoin('colors','order_items.color_code','=','colors.code')
        ->where('orders.id', $encomenda)
        ->get();

        return $itemsData;
    }

    public function show($encomenda): View{

        $encomendaData = self::dadosRecibo($encomenda);

        $itemsData = self::itensEncomenda($encomenda);

        $descontos = self::getPrices();

        return view('encomendas.show', compact('encomenda','encomendaData', 'itemsData', 'descontos'));
    }

    public function showRecibo($encomenda): View{

        $encomendaData = self::dadosRecibo($encomenda);
        $itemsData = self::itensEncomenda($encomenda);

        $descontos = self::getPrices();

        return view('encomendas.pdf', compact('encomendaData', 'itemsData','descontos'));
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

     public function changeStatus(Request $request, Encomendas $encomenda): RedirectResponse {

        switch($request->status){
            case 'Pagar':
                $status = 'paid';
                break;
            case 'Fechar':
                $status = 'closed';
                break;
            default:
                $status = $request->status;
        }

        $encomenda->status = $status;
        $encomenda->save();

        Alert::success('Estado da encomenda alterado com sucesso!');

        return redirect()->route('user.encomendas', Auth::user());
    } 

}
