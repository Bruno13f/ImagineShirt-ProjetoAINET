<?php

namespace App\Http\Controllers;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\TShirts;
use App\Models\Categorias;
use App\Models\User;

class PaginaSobreNosController extends Controller
{
    public function index(): View{

        $clientes = User::whereNull('deleted_at')->get();
        $totalClientes = $clientes->count();
        
        $categorias = Categorias::whereNull('deleted_at')->get();
        $totalCategorias = $categorias->count();

        $produtos = TShirts::whereNull('deleted_at')->whereNull('customer_id')->get();
        $totalProdutos = $produtos->count();

        return view('sobrenos.index', compact('totalClientes', 'totalCategorias', 'totalProdutos'));
    }
}
