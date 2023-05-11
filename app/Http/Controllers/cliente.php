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

    public function getClients(){
        $clients = clientes::all();
        return response($clients, 200);
    }

    private function validateClient(){
        return [
            'nombre'=>'required',
            'rfc'=>'required'
        ];
    }
}
