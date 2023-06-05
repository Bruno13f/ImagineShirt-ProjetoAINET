<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TShirts;
use App\Models\Precos;

class PaginaInicialController extends Controller
{
    
    public function index()
    {        
        // preco sempre 10.00€ - produtos loja
        $recentes = TShirts::whereNull('deleted_at')->whereNull('customer_id')->orderBy('created_at', 'desc')->take(8)->get();
        $populares = TShirts::inRandomOrder()->whereNull('deleted_at')->whereNull('customer_id')->take(8)->get();
        $maisVendidos = TShirts::inRandomOrder()->whereNull('deleted_at')->whereNull('customer_id')->take(4)->get();
        $precoLoja = Precos::select('unit_price_catalog')->first();

        return view('home', compact('recentes', 'populares', 'maisVendidos', 'precoLoja'));
    }
}
