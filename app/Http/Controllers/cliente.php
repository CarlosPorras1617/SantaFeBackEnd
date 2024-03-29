<?php

namespace App\Http\Controllers;

use App\Models\clientes;
use Illuminate\Http\Request;

class cliente extends Controller
{
    //create client
    public function createClient(Request $request)
    {
        $data = $request->validate($this->validateClient());
        $client = clientes::create($data);
        return response([
            'Message'=> 'Client Created',
            'id'=>$client['id']
        ],201);
    }

    //get all clients
    public function getClients(){
        $clients = clientes::all();
        //$clients = clientes::paginate(10);
        return response($clients, 200);
    }

    //get only one client
    public function getClient($id){
        $client = clientes::find($id);
        if($client != null){
            return response($client, 200);
        }
        return response(['message' => "'Client not found'"], 404);
    }

    //get active chofers
    public function getClientesActivos(){
        $clientes = clientes::where('status', '=', 1)->paginate(10);
        return response($clientes, 200);
    }

    //get inactive chofers
    public function getClientesInactivos(){
        $clientes = clientes::where('status', '=', 0)->paginate(10);
        return response($clientes, 200);
    }

    //search like query
    public function lookForName($input){
        $client = clientes::where('nombre', 'like', '%'.$input.'%')->paginate(10);
        if($client != null){
            return response($client, 200);
        }
        return response(['message' => 'Clients not found'], 404);
    }

    //update a client
    public function updateClient($id, Request $request){
        $client = clientes::find($id);
        if (!$client) {
            return response ([
                'message' => 'Client not found'
            ], 404);
        }
        $data = $request->validate($this->validateClient());
        $client->update($data);
        return response([
            'message' => 'Client updated'
        ], 201);
    }

    //"eliminates" a client
    public function hideClient($id){
        $client = clientes::find($id);
        if (!$client) {
            return response([
                'message' => 'Client with ID ' . $id . ' could not be found'
            ], 404);
        }
        $client->status = 0;
        if (!$client->save()) {
            return response ([
                'message' => 'Unexpected error'
            ], 500);
        }else{
            return response([
                'message' => 'Client eliminated'
            ], 200);
        }

    }

    //real client elimination
    public function eliminateClient($id){
        $client = clientes::find($id);
        if (!$client) {
            return response([
                'message' => 'Client with ID ' . $id . ' could not be found'
            ], 404);
        }
        $client->delete();
        return response([
            'message' => 'Client eliminated'
        ]);
    }

    //client validation
    private function validateClient(){
        return [
            'nombre'=>'required',
            'rfc'=>'required'
        ];
    }
}
