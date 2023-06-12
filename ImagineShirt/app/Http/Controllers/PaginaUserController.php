<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class PaginaUserController extends Controller
{
    public function index()
    {   
        if(Auth::user()->user_type == 'A')
            dd("ADMIN");
        if(Auth::user()->user_type == 'C')
            return view('clientes.index');
    }
}
