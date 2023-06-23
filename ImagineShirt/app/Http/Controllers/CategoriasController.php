<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Categorias;
use App\Http\Requests\CategoriaRequest;
use RealRashid\SweetAlert\Facades\Alert;

class CategoriasController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class, 'categoria');
    }

    public function index(): View{

        $categorias = Categorias::whereNull('deleted_at')->orderBy('name')->paginate(15);
        $user = Auth::user();

        return view('categorias.index', compact('categorias','user'));
    }

    public function create(): View{
        
        $user = Auth::user();
        $categoria = new Categorias();

        return view('categorias.create', compact('categoria','user'));
    }

    public function store(CategoriaRequest $request): RedirectResponse{
        
        $novaCategoria = new Categorias();
        $novaCategoria->name = $request->name;
        $novaCategoria->timestamps = false;
        $novaCategoria->save();

        Alert::success('Criada com sucesso!', 'A categoria '.$request->name.' foi criada!');
        return redirect()->route('categorias');
    }

    public function edit(Categorias $categoria): View{

        $user = Auth::user();

        return view('categorias.edit', compact('categoria', 'user'));
    }

    public function update(CategoriaRequest $request, Categorias $categoria): RedirectResponse{
        
        if ($request->name == $categoria->name){
            Alert::info('Categoria não foi alterada!', 'O nome da categoria é o mesmo!');
            return redirect()->route('categorias');
        }

        $categoria->name = $request->name;
        $categoria->save();

        Alert::success('Editada com sucesso!', 'O nome da categoria foi alterado!');
        return redirect()->route('categorias');
    }

    public function destroy(Categorias $categoria): RedirectResponse{
        
        $nome = $categoria->name;

        // colocar campo null todas t-shirts com o mesmo id
        if (count($categoria->tshirts) != 0){
            $categoria->delete();
        }else{
            $categoroia->forceDelete();
        }

        Alert::success('Eliminada com sucesso!', 'A categoria '.$nome.' foi eliminada!');
        return redirect()->route('categorias');
    }
}
