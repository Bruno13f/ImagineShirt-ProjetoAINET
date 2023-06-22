<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Models\Categorias;
use App\Models\Precos;
use App\Models\Cores;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Models\Encomendas;
use RealRashid\SweetAlert\Facades\Alert;

class PaginaUserController extends Controller
{

    public function __construct()
    {
        //$this->authorizeResource(User::class, 'user');
    }

    public function index()
    {   
        $user = Auth::user();

        if($user->user_type == 'A'){

            $tipoUser = 'Administrador';

            $numencomendas = Encomendas::count();

            $numutilizadores = User::whereNull('deleted_at')->count();

            $numCategorias = Categorias::whereNull('deleted_at')->count();

            $precos = Precos::get()->toArray();

            $numCores = Cores::whereNull('deleted_at')->count();
            
            return view('administradores.index',compact('user','tipoUser','numencomendas','numutilizadores','numCategorias','precos','numCores'));
        }

        if($user->user_type == 'E'){
            $tipoUser = 'Funcionário';

            $numencomendas = Encomendas::where('status','=','pending')->orwhere('status','=','paid')->count();

            return view('funcionarios.index',compact('user','tipoUser','numencomendas'));
        }

        if($user->user_type == 'C'){
            $tipoUser = 'Cliente';

            $numencomendas = Encomendas::where('customer_id', '=', $user->id)->count();
            
            return view('clientes.index',compact('user','tipoUser','numencomendas'));
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

        switch($user->user_type){
            case 'C': 
                $tipoUser = "Cliente"; 
                break;
            case 'A':
                $tipoUser = "Administrador";
                break;
        }

        $htmlMessage = "O $tipoUser $user->name foi alterado com sucesso!";

        Alert::success('Editado com sucesso!', $htmlMessage);

        return redirect()->route('user', $user);

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

        $htmlMessage = "A foto do $tipoUser $user->name foi eliminada!";

        Alert::success('Eliminada com sucesso!', $htmlMessage);

        return redirect()->route('user.edit', $user);
    }

    public function showEncomendas(){

        $user = Auth::user();
        
        if($user->user_type == 'A'){

            $encomendas = Encomendas::select('orders.id','orders.status','orders.date','orders.total_price','users.name','users.email')
            ->leftJoin('customers','customer_id','=','customers.id')
            ->leftJoin('users','customers.id','=','users.id')
            ->orderByDesc('date')->paginate(15);
            
            return view('users.shared.fields_encomendas',compact('user','encomendas'));
        }

        if($user->user_type == 'E'){

            $encomendas = Encomendas::where('status','=','pending')->orwhere('status','=','paid')->join('customers','orders.customer_id','=','customers.id')
            ->join('users','customers.id','=','users.id')
            ->orderByDesc('date')->paginate(15);

            return view('users.shared.fields_encomendas',compact('user','encomendas'));
        }

        if($user->user_type == 'C'){

            $encomendas = Encomendas::where('customer_id', '=', $user->id)->orderByDesc('date')->paginate(15);

            return view('users.shared.fields_encomendas',compact('user','encomendas'));
        }
    }

    public function showUsers(){

        $user = Auth::user();
        $utilizadores = User::whereNull('deleted_at')->paginate(15);

        return view('administradores.users', compact('user','utilizadores'));
    }

    public function showCategorias(){

        $user = Auth::user();
        $categorias = Categorias::whereNull('deleted_at')->paginate(15);

        return view('administradores.categorias', compact('user','categorias'));
    }

    public function showCores(){
        
        $user = Auth::user();
        $cores = Cores::whereNull('deleted_at')->paginate(15);

        return view('administradores.cores', compact('user','cores'));
    }

}
