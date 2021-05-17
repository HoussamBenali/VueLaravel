<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/', [App\Http\Controller\Web\WebController::class,'index']);


Route::get('/', [App\Http\Controllers\web\WebController::class, 'index'])->name('index');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/starting', [App\Http\Controllers\HomeController::class, 'index'])->name('starting');
Route::get('/tutorial/{pokemon}', [App\Http\Controllers\HomeController::class, 'index'])->name('tutorial');
Route::get('/adventure', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/wildMap/{area}', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/pokemons', [App\Http\Controllers\web\WebController::class, 'index'])->name('pokemons');
Route::get('/profile', [App\Http\Controllers\web\WebController::class, 'index'])->name('profile');
Route::get('/shop', [App\Http\Controllers\web\WebController::class, 'index'])->name('shop');
Route::get('/changePass', [App\Http\Controllers\web\WebController::class, 'index'])->name('changePass');
Route::get('/changeProfile', [App\Http\Controllers\web\WebController::class, 'index'])->name('changeProfile');
Route::get('/shop', [App\Http\Controllers\web\WebController::class, 'index'])->name('shop');

Auth::routes();

Route::get('register', [App\Http\Controllers\web\WebController::class, 'index'])->name('register');
Route::get('login', [App\Http\Controllers\web\WebController::class, 'index'])->name('login');
Route::post('forgot', [App\Http\Controllers\ForgotController::class, 'forgot'])->name('forgot');
Route::get('forgot', [App\Http\Controllers\ForgotController::class, 'forgot'])->name('forgot');

Route::post('/reset', [App\Http\Controllers\ForgotController::class, 'reset'])->name('reset');
Route::get('reset/{token?}', [App\Http\Controllers\web\WebController::class, 'index'])->name('reset');
