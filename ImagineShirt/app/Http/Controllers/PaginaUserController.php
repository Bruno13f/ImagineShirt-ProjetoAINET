<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Models\Encomendas;

class PaginaUserController extends Controller
{
    public function index()
    {   
        $user = Auth::user();

        if($user->user_type == 'A'){
            $tipoUser = 'Administrador';
            $queryEncomendas = Encomendas::query();
            $numencomendas = $queryEncomendas->count();
            $encomendas = $queryEncomendas->orderByDesc('date')->paginate(15);
            return view('administradores.index',compact('user','tipoUser','encomendas','numencomendas'));
        }

        if($user->user_type == 'E'){
            $tipoUser = 'Funcionário';
            $queryEncomendas = Encomendas::where('status','=','pending')->orwhere('status','=','paid');
            $numencomendas = $queryEncomendas->count();
            $encomendas = $queryEncomendas->paginate(15);
            return view('funcionarios.index',compact('user','tipoUser','encomendas','numencomendas'));
        }

        if($user->user_type == 'C'){
            $tipoUser = 'Cliente';
            $queryEncomendas = Encomendas::where('customer_id', '=', $user->id);
            $numencomendas = $queryEncomendas->count();
            $encomendas = $queryEncomendas->paginate(15);
            return view('clientes.index',compact('user','tipoUser','encomendas','numencomendas'));
        }
    }

    public function edit(){

        $user = Auth::user();

        if($user->user_type == 'A'){
            $tipoUser = 'Administrador';
            return view('administradores.edit',compact('user','tipoUser'));
        }

        if($user->user_type == 'E'){
            $tipoUser = 'Funcionário';
            return view('funcionarios.edit',compact('user','tipoUser'));
        }

        if($user->user_type == 'C'){
            $tipoUser = 'Cliente';
            return view('clientes.edit',compact('user','tipoUser'));
        }
        
    }

    public function update(UserRequest $request, User $user): RedirectResponse{
        
        $formData = $request->validated();
        $user = DB::transaction(function () use ($formData, $user, $request) {

            $user->name = $formData['name'];
            $user->email = $formData['email'];
            $user->save();
            if ($user->user_type === 'C'){
                $cliente = $user->cliente;
                $cliente->nif = $formData['nif'];
                $cliente->address = $formData['name'];
                $cliente->default_payment_type = $formData['default_payment_type'];
                $cliente->default_payment_ref = $formData['default_payment_ref'];
                $cliente->save();
            }

            if ($request->hasFile('image')) {
                if ($user->photo_url) {
                    Storage::delete('public/photos' . $user->photo_url);
                }
                $path = $request->image->store('public/photos');
                $user->photo_url = basename($path);
                $user->save();
            }

            return $user;
        });

        $url = route('user', $user);

        switch($user->user_type){
            case 'C': 
                $tipoUser = "Cliente"; 
                break;
            case 'A':
                $tipoUser = "Administrador";
                break;
        }

        $htmlMessage = "O $tipoUser $user->name foi alterado com sucesso!";

        return redirect()->route('user', $user)
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');

    }

    public function destroy_foto(User $user): RedirectResponse
    {
        if ($user->photo_url) {
            Storage::delete('public/photos' . $user->photo_url);
            $user->photo_url = null;
            $user->save();
        }

        switch($user->user_type){
            case 'C': 
                $tipoUser = "Cliente"; 
                break;
            case 'A':
                $tipoUser = "Administrador";
                break;
        }

        return redirect()->route('user.edit', $user)
        ->with('alert-msg', 'Foto do '.$tipoUser.' "' . $user->name .
        '" foi removida!')
        ->with('alert-type', 'success');
    }
}
