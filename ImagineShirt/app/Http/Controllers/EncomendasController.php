<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Response;
use App\Models\Encomendas;
use Illuminate\Support\Facades\Storage;

class EncomendasController extends Controller
{
    public function generatePDF($encomenda)
    {
        $encomendaData = self::dadosRecibo($encomenda);
        $itemsData = self::itensEncomenda($encomenda);

        $html = view('encomendas.pdf', compact('encomendaData', 'itemsData'))->render();

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
    public function showPDF($encomenda){

        $encomendaData = self::dadosRecibo($encomenda);

        $itemsData = self::itensEncomenda($encomenda);

        return view('encomendas.show', compact('encomendaData','itemsData'));
    }

    private function dadosRecibo($encomenda){
        
        $encomendaData = Encomendas::select('orders.id','orders.status','orders.total_price','orders.nif','orders.payment_type','orders.payment_ref','orders.notes','users.name','orders.address','users.email','orders.date')
        ->leftJoin('customers','customer_id','=','customers.id')
        ->leftJoin('users','customers.id','=','users.id')
        ->findOrFail($encomenda);

        return $encomendaData;
    }

    private function itensEncomenda($encomenda){

        $itemsData = Encomendas::select('tshirt_images.name','order_items.qty','order_items.size','order_items.unit_price','order_items.sub_total','tshirt_images.customer_id')
        ->leftJoin('order_items','orders.id','=','order_items.order_id')
        ->leftJoin('tshirt_images','order_items.tshirt_image_id','=','tshirt_images.id')
        ->where('orders.id', $encomenda)
        ->get();

        return $itemsData;
    }

}
