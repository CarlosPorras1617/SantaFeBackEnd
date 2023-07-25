<?php

use App\Http\Controllers\ChoferController;
use App\Http\Controllers\cliente;
use App\Http\Controllers\PedimentoA1Controller;
use App\Http\Controllers\PedimentoRTController;
use App\Http\Controllers\TramiteController;
use App\Models\Tramite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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
Route::put('/clientes/eliminar/{id}', [cliente::class, 'hideClient']);
Route::delete('/clientes/eliminar/{id}', [cliente::class, 'eliminateClient']);
Route::post('/clientes', [cliente::class, 'createClient']);

//Chofer routes
Route::get('/choferes',[ChoferController::class,'getChofers']);
Route::get('/choferes/activos',[ChoferController::class,'getChofersActivos']);
Route::get('/choferes/inactivos',[ChoferController::class,'getChofersInactivos']);
Route::get('/chofer/{id}', [ChoferController::class, 'getChofer']);
Route::get('/likeChofer', [ChoferController::class, 'lookForNameChofer']);
Route::post('/chofer', [ChoferController::class, 'createChofer']);
Route::put('/chofer/{id}', [ChoferController::class, 'updateChofer']);
Route::put('/chofer/eliminar/{id}', [ChoferController::class, 'hideChofer']);
Route::delete('/chofer/eliminar/{id}', [ChoferController::class, 'eliminateChofer']);

//Pedimento A1 routes
Route::get('/pedimentosa1',[PedimentoA1Controller::class,'getPedimentosA1']);
Route::get('/pedimentosa1/activos',[PedimentoA1Controller::class, 'getPedimentosA1Activos']);
Route::get('/pedimentosa1/inactivos',[PedimentoA1Controller::class, 'getPedimentosA1Inactivos']);
Route::get('/pedimentoa1/{id}', [PedimentoA1Controller::class, 'getPedimentoA1']);
Route::get('/likePedimentoa1', [PedimentoA1Controller::class, 'lookForSemanaPedimentoA1']);
Route::post('/pedimentoa1',[PedimentoA1Controller::class, 'createPedimentoA1']);
Route::put('/pedimentoa1/{id}', [PedimentoA1Controller::class, 'updatePedimentoA1']);
Route::put('/pedimentoa1/eliminar/{id}', [PedimentoA1Controller::class, 'hidePedimentoA1']);
Route::delete('/pedimentoa1/eliminar/{id}', [PedimentoA1Controller::class, 'eliminatePedimentoA1']);

//Pedimento Rt routes
Route::get('/pedimentosrt',[PedimentoRTController::class,'getPedimentosRT']);
Route::get('/pedimentosrt/activos',[PedimentoRTController::class, 'getPedimentosRTActivos']);
Route::get('/pedimentosrt/inactivos',[PedimentoRTController::class, 'getPedimentosRTInactivos']);
Route::get('/pedimentort/{id}', [PedimentoRTController::class, 'getPedimentoRT']);
Route::get('/likePedimentort', [PedimentoRTController::class, 'lookForSemanaPedimentoRT']);
Route::post('/pedimentort',[PedimentoRTController::class, 'createPedimentoRT']);
Route::put('/pedimentort/{id}', [PedimentoRTController::class, 'updatePedimentoRT']);
Route::put('/pedimentort/eliminar/{id}', [PedimentoRTController::class, 'hidePedimentoRT']);
Route::delete('/pedimentort/eliminar/{id}', [PedimentoRTController::class, 'eliminatePedimentoRT']);

//Tramites routes
Route::get('/tramites',[TramiteController::class,'getTramites']);
Route::get('/tramites/imprimircodigo/{id}',[TramiteController::class,'imprimirCodigo']);
Route::get('/tramites/activos',[TramiteController::class, 'getTramitesActivos']);
Route::get('/tramites/inactivos',[TramiteController::class, 'getTramitesInactivos']);
Route::get('/tramites/todosActivos',[TramiteController::class, 'getActiveAllTramites']);
Route::get('/tramites/todosInactivos',[TramiteController::class, 'getInactiveAllTramites']);
Route::get('/tramite/{id}', [TramiteController::class, 'getTramite']);
Route::get('/likeTramite', [TramiteController::class, 'lookForNumeroEntrada']);
Route::post('/tramites',[TramiteController::class, 'createTramite']);
Route::put('/tramite/{id}', [TramiteController::class, 'updateTramite']);
Route::put('/tramite/eliminar/{id}', [TramiteController::class, 'hideTramite']);
Route::delete('/tramite/eliminar/{id}', [TramiteController::class, 'eliminateTramite']);
Route::put('/tramite/capturar/{barcode}', [TramiteController::class, 'capturarTramite']);
Route::get('/tramite/numEntrada/{numEntrada}', [TramiteController::class, 'obtenerNumEntradaOnly']);


