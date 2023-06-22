<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TShirts;
use App\Models\Precos;
use App\Models\ItensEncomenda;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class PaginaInicialController extends Controller
{
    
    public function index(): View
    {        
        // preco sempre 10.00€ - produtos loja
        $recentes = TShirts::whereNull('deleted_at')->whereNull('customer_id')->orderBy('created_at', 'desc')->take(8)->get();
        $populares = TShirts::inRandomOrder()->whereNull('deleted_at')->whereNull('customer_id')->take(8)->get();
        $maisVendidos = ItensEncomenda::select('tshirt_image_id')
                    ->join('tshirt_images', 'order_items.tshirt_image_id', '=', 'tshirt_images.id')
                    ->whereNull('tshirt_images.deleted_at')
                    ->whereNull('tshirt_images.customer_id')
                    ->groupBy('tshirt_image_id')
                    ->orderByRaw('SUM(qty) DESC')
                    ->take(4)
                    ->get();

        $tshirtsmaisVendidas = TShirts::whereIn('id',[$maisVendidos[0]->tshirt_image_id,
                                                    $maisVendidos[1]->tshirt_image_id,
                                                    $maisVendidos[2]->tshirt_image_id,
                                                    $maisVendidos[3]->tshirt_image_id,
                                                    ])->get();

        $precoLoja = Precos::select('unit_price_catalog')->first();        
        return view('home', compact('recentes', 'populares', 'tshirtsmaisVendidas', 'precoLoja'));
    }
}
