<?php

use App\Http\Controllers\ChoferController;
use App\Http\Controllers\cliente;
use App\Http\Controllers\PedimentoA1Controller;
use App\Http\Controllers\PedimentoRTController;
use App\Http\Controllers\TramiteController;
use App\Models\chofer;
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

//Clients routes
Route::get('/clientes',[cliente::class,'getClients']);
Route::get('/clientes/activos',[cliente::class,'getClientesActivos']);
Route::get('/clientes/inactivos',[cliente::class,'getClientesInactivos']);
Route::get('/cliente/{id}', [cliente::class, 'getClient']);
Route::get('/likeClientes/{input}', [cliente::class, 'lookForName']);
Route::put('/cliente/{id}', [cliente::class, 'updateClient']);
Route::put('/eliminar/{id}', [cliente::class, 'hideClient']);
Route::delete('/eliminar/{id}', [cliente::class, 'eliminateClient']);
Route::post('/clientes', [cliente::class, 'createClient']);

//Chofer routes
Route::get('/choferes',[ChoferController::class,'getChofers']);
Route::get('/choferes/activos',[ChoferController::class,'getChofersActivos']);
Route::get('/choferes/inactivos',[ChoferController::class,'getChofersInactivos']);
Route::get('/chofer/{id}', [ChoferController::class, 'getChofer']);
Route::get('/likeChofer', [ChoferController::class, 'lookForNameChofer']);
Route::post('/chofer', [ChoferController::class, 'createChofer']);
Route::put('chofer/{id}', [ChoferController::class, 'updateChofer']);
Route::put('eliminar/{id}', [ChoferController::class, 'hideChofer']);
Route::delete('/eliminar/{id}', [ChoferController::class, 'eliminateChofer']);

Route::post('/tramites',[TramiteController::class, 'createTramite']);
Route::get('/imprimirBarcode',[TramiteController::class, 'imprimirBarcode']);
Route::get('/pedimentosa1',[PedimentoA1Controller::class,'getPedimentosA1']);
Route::post('/pedimentosa1',[PedimentoA1Controller::class, 'createPedimentoA1']);
Route::get('/pedimentosrt',[PedimentoRTController::class,'getPedimentosRT']);
Route::post('/pedimentosrt', [PedimentoRTController::class, 'createPedimentoRT']);


