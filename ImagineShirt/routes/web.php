<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TShirtsController;
use App\Http\Controllers\HomeController;

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

Route::view('/', 'home')->name('root');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('t-shirts', [TShirtsController::class, 'index'])->name('t-shirts');
//permitir logout com metodo GET no href
Route::get('logout', function (){
    auth()->logout();
    Session()->flush();
    return Redirect::to('/');
})->name('logout');
Auth::routes(['verify' => true]);