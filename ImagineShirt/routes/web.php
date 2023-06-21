<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TShirtsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaginaInicialController;
use App\Http\Controllers\PaginaSobreNosController;
use App\Http\Controllers\PaginaUserController;
use App\Http\Controllers\Auth\ChangePasswordController;
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
         // adicionar outro nomes para rotas
    ]
]);
Route::get('/t-shirts/{t_shirt}', [TShirtsController::class, 'show'])->name('t-shirts.show');

//permitir logout com metodo GET no href
Route::get('logout', function (){
    auth()->logout();
    Session()->flush();
    return Redirect::back();
})->name('logout');
Route::view('/contactos', 'contactos.index')->name('contactos');
Route::get('/sobreNos', [PaginaSobreNosController::class, 'index'])->name('sobreNos');

Route::middleware('auth')->group(function (){
    // rotas para todos os users
    Route::get('/user/{user}', [PaginaUserController::class, 'index'])->middleware('verified')->name('user');
    Route::get('tshirt-images-user/{nome_tshirt}-{user_id}/{image_url}',[TShirtsController::class, 'imagemCliente'])->name('imagem_user');
    Route::get('/user/{user}/encomendas', [PaginaUserController::class, 'showEncomendas'])->middleware('verified')->name('user.encomendas');
});

Route::middleware('adminOrCustomer')->group(function (){
    // rotas para admin e cliente
    Route::middleware('verified')->group(function (){
        // rotas que necessitam confirmação email
        Route::get('/user/{user}/edit', [PaginaUserController::class, 'edit'])->name('user.edit');
        Route::put('/user/{user}/update', [PaginaUserController::class, 'update'])->name('user.update');
        Route::delete('/user/{user}/foto', [PaginaUserController::class, 'destroy_foto'])->name('user.foto.destroy');
        Route::post('/password/change', [ChangePasswordController::class, 'store'])->name('password.change.store');
        Route::get('/password/change', [ChangePasswordController::class, 'show'])->name('password.change.show');
    });
});


Route::middleware('admin')->group(function (){
    // rotas para admin - dashboard etc
});

Auth::routes(['verify' => true]);