<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class PaginaUserController extends Controller
{
    public function index()
    {   
        $user = Auth::user();

        if($user->user_type == 'A'){
            $tipoUser = 'Administrador';
            dd("ADMIN");
        }

        if($user->user_type == 'F'){
            $tipoUser = 'Funcionário';
            dd("ADMIN");
        }

        if($user->user_type == 'C'){
            $tipoUser = 'Cliente';
            return view('clientes.index',compact('user','tipoUser'));
        }
    }
}
