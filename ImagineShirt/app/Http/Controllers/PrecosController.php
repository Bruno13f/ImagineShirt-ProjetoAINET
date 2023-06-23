<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Precos;
use App\Http\Requests\PrecosRequest;
use RealRashid\SweetAlert\Facades\Alert;

class PrecosController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class, 'precos');
    }

    public function index(): View{

        $user = Auth::user();
        $precos = Precos::get()->toArray();
        
        return view('precos.index', compact('precos','user'));
    }

    public function edit(Precos $precos): View{

        $user = Auth::user();

        return view('precos.edit', compact('precos', 'user'));
    }

    public function update(PrecosRequest $request, Precos $precos): RedirectResponse{

        $precos['unit_price_catalog'] = $request->precoCatalogo;
        $precos['unit_price_catalog_discount'] = $request->precoCatalogoDisc;
        $precos['unit_price_own'] = $request->precoCliente;
        $precos['unit_price_own_discount'] = $request->precoClienteDisc;
        $precos['qty_discount'] = $request->quantDesc;
        
        $precos->save();
        
        Alert::success('Editado com sucesso!', 'Os precos foram alterados!');
        return redirect()->route('precos');
    }
}
