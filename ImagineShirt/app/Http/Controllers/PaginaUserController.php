<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Models\Encomendas;
use Auth;

class PaginaUserController extends Controller
{
    public function index()
    {   
        $user = Auth::user();

        if($user->user_type == 'A'){
            $tipoUser = 'Administrador';
            $encomendas = Encomendas::orderByDesc('date')->paginate(15);
            $numencomendas = Encomendas::orderByDesc('date')->count();
            return view('administradores.index',compact('user','tipoUser','encomendas','numencomendas'));
        }

        if($user->user_type == 'E'){
            $tipoUser = 'Funcionário';
            $encomendas = Encomendas::where('status','=','pending')->orwhere('status','=','paid')->orderByDesc('date')->paginate(15);
            $numencomendas = Encomendas::where('status','=','pending')->orwhere('status','=','paid')->orderByDesc('date')->count();
            return view('funcionarios.index',compact('user','tipoUser','encomendas','numencomendas'));
        }

        if($user->user_type == 'C'){
            $tipoUser = 'Cliente';
            return view('clientes.index',compact('user','tipoUser'));
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

}
