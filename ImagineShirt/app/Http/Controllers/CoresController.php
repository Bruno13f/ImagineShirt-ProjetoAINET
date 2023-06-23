<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Cores;
use App\Http\Requests\CorRequest;
use RealRashid\SweetAlert\Facades\Alert;

class CoresController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class, 'cor');
    }

    public function edit(Cores $cor): View{

        $user = Auth::user();

        return view('cores.edit', compact('cor', 'user'));
    }

    public function update(CorRequest $request, Cores $cor): RedirectResponse{

        if ($request->name == $cor->name && $request->code == $cor->code){
            Alert::info('Cor não foi alterada!', 'Parâmetros da categoria são os mesmos!');
            return redirect()->route('user.gerirCores', Auth::user());
        }

        // NAO FUNCIONA - PERGUNTAR SE E ASSIM - REQUEST FEITO
        if (count($cor->itensEncomenda) != 0){
            foreach($cor->itensEncomenda as $itemEncomenda){
                $itemEncomenda->color_code = $request->code;
                $itemEncomenda->save();
            }
        }

        $cor->name = $request->name;
        $cor->code = $request->code;
        $cor->save();

        Alert::success('Editada com sucesso!', 'A cor foi alterado!');
        return redirect()->route('user.gerirCores', Auth::user());
    }

    public function destroy(Cores $cor): RedirectResponse{

        // soft delete - continua-se a poder aceder
        $cor->delete();

        Alert::success('Eliminada com sucesso!', 'A cor foi eliminada!');
        return redirect()->route('user.gerirCores', Auth::user());
    }
}
