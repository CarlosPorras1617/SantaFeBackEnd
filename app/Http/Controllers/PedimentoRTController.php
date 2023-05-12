<?php

namespace App\Http\Controllers;

use App\Models\PedimentoRT;
use Illuminate\Http\Request;

class PedimentoRTController extends Controller
{
    //create pedimentoRT
    public function createPedimentoRT(Request $request){
        $data = $request ->validate($this->validatePedimento());
        $pedimento = PedimentoRT::create($data);
        return response([
            'Message'=>'Declaration created',
            'id'=>$pedimento['id']
        ], 201);
    }

    public function getPedimentosRT(){
        $pedimentos = PedimentoRT::all();
        return response($pedimentos, 200);
    }

    private function validatePedimento(){
        return [
            'semana'=>'required',
            'patente'=>'required',
        ];
    }
}
