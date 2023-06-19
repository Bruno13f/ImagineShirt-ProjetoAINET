<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TShirtsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaginaInicialController;
use App\Http\Controllers\PaginaSobreNosController;
use App\Http\Controllers\PaginaUserController;
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
Route::get('/t-shirts/{tshirt}', [TShirtsController::class, 'show'])->name('t-shirts.show');
//permitir logout com metodo GET no href
Route::get('logout', function (){
    auth()->logout();
    Session()->flush();
    return Redirect::back();
})->name('logout');
Route::view('/contactos', 'contactos.index')->name('contactos');
Route::get('/sobreNos', [PaginaSobreNosController::class, 'index'])->name('sobreNos');
Route::middleware('auth')->group(function (){
    Route::get('/user/{user}', [PaginaUserController::class, 'index'])->name('pagUser')->middleware('verified');

    Route::get('tshirt-images-user/{tshirt}-{user_id}/{image_url}',[TShirtsController::class, 'imagemCliente'])->name('imagem_user');
});

Auth::routes(['verify' => true]);