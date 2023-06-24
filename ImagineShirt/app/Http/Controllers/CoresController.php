<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Cores;
use App\Http\Requests\CorRequest;
use RealRashid\SweetAlert\Facades\Alert;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Color;

class CoresController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class, 'cor');
    }

    public function index(): View{

        $cores = Cores::whereNull('deleted_at')->orderBy('name')->paginate(15);
        $user = Auth::user();

        return view('cores.index', compact('cores', 'user'));
    }

    public function create (): View{
        
        $cor = new Cores();
        $user = Auth::user();

        return view('cores.create', compact('cor', 'user'));
    }

    public function store(CorRequest $request): RedirectResponse{

        Storage::putFileAs('public/tshirt_base', $request->image, $request->code.'.jpg');
        $novaCor = new Cores();
        $novaCor->name = $request->name;
        $novaCor->code = $request->code;
        $novaCor->save();

        Alert::success('Criada com sucesso!', 'A cor foi criada!');
        return redirect()->route('cores');
    }

    public function edit(Cores $cor): View{

        $user = Auth::user();

        return view('cores.edit', compact('cor', 'user'));
    }

    public function update(CorRequest $request, Cores $cor): RedirectResponse{

        if ($request->name == $cor->name && $request->code == $cor->code && Storage::exists('public/tshirt_base/'.$request->code.'.jpg')){
            Alert::info('Cor não foi alterada!', 'Parâmetros da categoria são os mesmos!');
            return redirect()->route('cores');
        }

        if (count($cor->itensEncomenda) != 0){
            Alert::error('Cor não pode ser alterada!', 'Encomendas feitas com camisolas desta cor!');
            return redirect()->route('cores');
        }

        Storage::delete('public/tshirt_base/'.$cor->code.'.jpg');
        Storage::putFileAs('public/tshirt_base', $request->image, $request->code.'.jpg');

        $cor->name = $request->name;
        $cor->code = $request->code;
        $cor->save();

        Alert::success('Editada com sucesso!', 'A cor foi alterado!');
        return redirect()->route('cores');
    }

    public function destroy(Cores $cor): RedirectResponse{

        // soft delete - continua-se a poder aceder

        if (count($cor->itensEncomenda) != 0){
            $cor->delete();
        }else{
            Storage::delete('public/tshirt_base/'.$cor->code.'.jpg');
            $cor->forceDelete();
        }
        

        Alert::success('Eliminada com sucesso!', 'A cor foi eliminada!');
        return redirect()->route('cores');
    }
}
