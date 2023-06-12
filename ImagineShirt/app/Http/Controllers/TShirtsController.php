<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TShirts;
use App\Models\Categorias;
use App\Models\Precos;
use App\Models\Cores;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class TShirtsController extends Controller
{
    public function index(Request $request): View
    {
        //obter tshirts
        $tshirtsQuery = TShirts::query();
        
        //filtar categoria
        $categoriaFiltro = $request->categoria ?? '';
        
        if ($categoriaFiltro !== ''){
            $idCategoriaFiltro = Categorias::where('name','LIKE',$categoriaFiltro)->pluck('id');
            $tshirtsQuery->where('category_id',$idCategoriaFiltro);
        }

        // ordernar entradas - Padrao: data descendente
        $ordenarFiltro = $request->ordenar ?? 'rec_desc';

        if (str_contains($ordenarFiltro,'rec')){
            $ordenarArray = preg_split("/[_\s:]/",$ordenarFiltro);
            $tshirtsQuery->orderBy('created_at',$ordenarArray[1]);
        }elseif(str_contains($ordenarFiltro,'name')){
            $ordenarArray = preg_split("/[_\s:]/",$ordenarFiltro);
            $tshirtsQuery->orderBy($ordenarArray[0],$ordenarArray[1]);
        }

        // string pesquisa
        $pesquisaFiltro = $request->pesquisa ?? '';

        if ($pesquisaFiltro !== ''){
            //primeiro procurar nome -> descrição
            $pesquisaFiltro = strtoupper($pesquisaFiltro);

            // para adicionar os (query)

            $tshirtsQuery->where(function ($query) use ($pesquisaFiltro){
                $query->where('name', 'LIKE', "%$pesquisaFiltro%")
                      ->orWhere('description', 'LIKE', "%$pesquisaFiltro%");
            });

        }
        
        // ordernar alfabeticamente default - t-shirts loja
        $tshirts = $tshirtsQuery->whereNull('deleted_at')->whereNull('customer_id')->paginate(12, ['*'], 'pagina');

        // obter preços - apenas necessario preco loja e customer - desconto relacionado com nº artigos
        $precos = Precos::select(array('unit_price_catalog', 'unit_price_own'))->first()->toArray();
        // obter categorias
        $categorias = Categorias::whereNull('deleted_at')->orderBy('name')->pluck('name')->toArray();  

        //logs
        Log::debug('TShirts loaded on TShirtController.', ['$tshirts' => $tshirts]);
        Log::debug('Categorias loaded on TShirtController.', ['$categorias' => $categorias]);
        Log::debug('Prices loaded on TShirtController.', ['$precos' => $precos]);
        
        return view('tshirts.index', compact('tshirts','categorias','precos','categoriaFiltro','ordenarFiltro','pesquisaFiltro'));
    }

    public function show(String $str_tshirt): View
    {
        $idTShirt = strtok($str_tshirt, '-');
        $tshirt = TShirts::findOrFail($idTShirt);
        $categoria = Categorias::where('id',$tshirt->category_id)->pluck('name');
        $cores = Cores::whereNull('deleted_at')->orderBy('name')->get();
        return view('tshirts.show', compact('tshirt', 'categoria', 'cores'));
    }

}
