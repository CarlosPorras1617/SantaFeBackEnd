<?php

namespace App\Http\Controllers;

use App\Models\PedimentoA1;
use Illuminate\Http\Request;

class PedimentoA1Controller extends Controller
{
    //create pedimentoA1
    public function createPedimentoA1(Request $request){
        $data = $request->validate($this->validatePedimento());
        $pedimento = PedimentoA1::create($data);
        return response([
            'Message'=>'Declaration created',
            'id'=>$pedimento['id']
        ], 201);
    }

    public function getPedimentosA1(){
        $pedimentos = PedimentoA1::all();
        return response($pedimentos, 200);
    }

    private function validatePedimento(){
        return[
            'semana'=>'required',
            'patente'=>'required'
        ];
    }
}
