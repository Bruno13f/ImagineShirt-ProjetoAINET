<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TShirtsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaginaInicialController;
use App\Http\Controllers\PaginaSobreNosController;
use App\Http\Controllers\PaginaUserController;
use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\CoresController;
use App\Http\Controllers\PrecosController;
use App\Http\Controllers\EncomendasController;
use App\Http\Controllers\EstatisticasController;
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

Route::middleware('admin')->group(function (){
    // rotas para admin - dashboard etc
    Route::middleware('verified')->group(function (){
        Route::get('/user/{user}/gerirUsers', [PaginaUserController::class, 'showUsers'])->name('user.gerirUsers');
        
        Route::patch('/user/{user}/blocked', [PaginaUserController::class, 'updateStatusBlock'])->name('user.updateStatusBlock');
        Route::delete('/user/{user}/delete', [PaginaUserController::class, 'destroy_user'])->name('user.destroy');
        Route::get('/user/create', [PaginaUserController::class, 'create'])->name('user.create');
        Route::post('/user/store', [PaginaUserController::class, 'store'])->name('user.store');

        Route::get('/estatisticas', [EstatisticasController::class, 'index'])->name('estatisticas');

        Route::get('/categorias', [CategoriasController::class, 'index'])->name('categorias');
        Route::get('/categorias/create', [CategoriasController::class, 'create'])->name('categorias.create');
        Route::post('/categorias/store', [CategoriasController::class, 'store'])->name('categorias.store');
        Route::get('/categorias/{categoria}/edit', [CategoriasController::class, 'edit'])->name('categorias.edit');
        Route::put('/categorias/{categoria}/update', [CategoriasController::class, 'update'])->name('categorias.update');
        Route::delete('/categorias/{categoria}/delete', [CategoriasController::class, 'destroy'])->name('categorias.destroy');

        Route::get('/cores', [CoresController::class, 'index'])->name('cores');
        Route::get('/cores/create', [CoresController::class, 'create'])->name('cores.create');
        Route::post('/cores/store', [CoresController::class, 'store'])->name('cores.store');
        Route::get('/cores/{cor}/edit', [CoresController::class, 'edit'])->name('cores.edit');
        Route::put('/cores/{cor}/update', [CoresController::class, 'update'])->name('cores.update');
        Route::delete('/cores/{cor}/delete', [CoresController::class, 'destroy'])->name('cores.destroy');

        Route::get('/precos', [PrecosController::class, 'index'])->name('precos');
        Route::get('/precos/{precos}/edit', [PrecosController::class, 'edit'])->name('precos.edit');
        Route::put('/precos/{precos}/update', [PrecosController::class, 'update'])->name('precos.update');
        
    });
});

Route::middleware('auth')->group(function (){
    // rotas para todos os users
    Route::middleware('verified')->group(function (){
        Route::get('/user/{user}', [PaginaUserController::class, 'index'])->name('user');
        
        Route::get('/encomendas', [EncomendasController::class, 'index'])->name('encomendas');
        Route::get('/encomendas/{encomenda}/pdf', [EncomendasController::class, 'generatePDF'])->name('encomendas.pdf');
        Route::get('/encomendas/{encomenda}/detalhes', [EncomendasController::class, 'show'])->name('encomendas.show');
        Route::get('/encomendas/{encomenda}/recibo', [EncomendasController::class, 'showRecibo'])->name('encomendas.recibo');
        Route::patch('/encomendas/{encomenda}/status', [EncomendasController::class, 'changeStatus'])->name('encomendas.changeStatus');

        Route::get('tshirt-images-user/{nome_tshirt}-{user_id}/{image_url}',[TShirtsController::class, 'imagemCliente'])->name('imagem_user');
    });
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

        Route::get('t-shirts/create', [TShirtsController::class, 'create'])->name('t-shirts.create');
        Route::post('/t-shirts/store', [TShirtsController::class, 'store'])->name('t-shirts.store');
        Route::get('/t-shirts/{t_shirt}/edit', [TShirtsController::class, 'edit'])->name('t-shirts.edit');
        Route::put('/t-shirts/{t_shirt}/update', [TShirtsController::class, 'update'])->name('t-shirts.update');
        Route::delete('/t-shirts/{t_shirt}/delete', [TShirtsController::class, 'destroy'])->name('t-shirts.destroy');
    });
});


Route::middleware('cliente')->group(function (){
    Route::get('/user/{user}/minhasTShirts', [PaginaUserController::class, 'showMinhasTShirts'])->name('user.gerirMinhasTShirts');
});


Auth::routes(['verify' => true]);