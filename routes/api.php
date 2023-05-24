<?php

use App\Http\Controllers\ChoferController;
use App\Http\Controllers\cliente;
use App\Http\Controllers\PedimentoA1Controller;
use App\Http\Controllers\PedimentoRTController;
use App\Http\Controllers\TramiteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/tramites',[TramiteController::class, 'createTramite']);
Route::get('/imprimirBarcode',[TramiteController::class, 'imprimirBarcode']);
Route::get('/pedimentosa1',[PedimentoA1Controller::class,'getPedimentosA1']);
Route::post('/pedimentosa1',[PedimentoA1Controller::class, 'createPedimentoA1']);
Route::get('/pedimentosrt',[PedimentoRTController::class,'getPedimentosRT']);
Route::post('/pedimentosrt', [PedimentoRTController::class, 'createPedimentoRT']);
Route::get('/clientes',[cliente::class,'getClients']);
Route::get('/choferes',[ChoferController::class,'getChofers']);
Route::post('/clientes', [cliente::class, 'createClient']);
