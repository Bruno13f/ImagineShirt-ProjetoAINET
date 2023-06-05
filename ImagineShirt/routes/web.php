<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TShirtsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaginaInicialController;
use App\Models\TShirts;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::view('/', 'home')->name('root');
Route::get('/', [PaginaInicialController::class, 'index'])->name('root');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::resource('t-shirts', TShirtsController::class, [
    'names' => [
        'index' => 't-shirts'
        // adicionar outro nomnes para rotas
    ]
]);
//permitir logout com metodo GET no href
Route::get('logout', function (){
    auth()->logout();
    Session()->flush();
    return Redirect::to('/');
})->name('logout');
Auth::routes(['verify' => true]);