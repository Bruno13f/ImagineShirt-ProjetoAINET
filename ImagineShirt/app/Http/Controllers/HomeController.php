<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TShirts;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {        
        // preco sempre 10.00€ - produtos loja
        $recentes = TShirts::whereNull('deleted_at')->whereNull('customer_id')->orderBy('created_at', 'desc')->take(8)->get();
        $populares = TShirts::inRandomOrder()->whereNull('deleted_at')->whereNull('customer_id')->take(4)->get();

        return view('home');
    }
}
