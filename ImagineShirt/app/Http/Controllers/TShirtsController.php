<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TShirts;
use App\Models\Categorias;
use App\Models\Precos;
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
        $ordenarFiltro = $request->ordenar ?? 'padrao';
        if ($ordenarFiltro === 'padrao'){
            $tshirtsQuery->orderBy('created_at','DESC');
        }elseif(str_contains($ordenarFiltro,'name')){
            $ordenarArray = preg_split("/[_\s:]/",$ordenarFiltro);
            $tshirtsQuery->orderBy($ordenarArray[0],$ordenarArray[1]);
        }else{
            // falta fazer para o preço
        }
        
        // ordernar alfabeticamente default
        $tshirts = $tshirtsQuery->whereNull('deleted_at')->paginate(12, ['*'], 'pagina');

        // obter preços
        $precos = self::getPrecosTShirts();
        // obter categorias
        $categorias = self::getCategoriasValidas();

        //logs
        Log::debug('TShirts loaded on TShirtController.', ['$tshirts' => $tshirts]);
        Log::debug('Categorias loaded on TShirtController.', ['$categorias' => $categorias]);
        Log::debug('Prices loaded on TShirtController.', ['$precos' => $precos]);
        
        return view('tshirts.index', compact('tshirts','categorias','precos','categoriaFiltro','ordenarFiltro'));
    }

    private function getCategoriasValidas (): array {
        return Categorias::whereNull('deleted_at')->orderBy('name')->pluck('name')->toArray();  
    }

    private function getPrecosTShirts(): array{
        // apenas necessario preco loja e customer - desconto relacionado com nº artigos
        return Precos::select(array('unit_price_catalog', 'unit_price_own'))->first()->toArray();
    }

    function debug_to_console($data) {
        $output = $data;
        if (is_array($output))
            $output = implode(',', $output);
    
        echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
    }
}
