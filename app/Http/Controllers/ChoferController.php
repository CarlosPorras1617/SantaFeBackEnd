<?php

namespace App\Http\Controllers;

use App\Models\chofer;
use Illuminate\Http\Request;

class ChoferController extends Controller
{
    //create client
    public function createChofer(Request $request){
        $data = $request->validate($this->validateChofer());
        $chofer =chofer::create($data);
        return response([
            'Message'=>'Chofer Created',
            'id'=> $chofer('id')
        ], 201);
    }

    public function getChofers(){
        $chofers = chofer::all();
        return response($chofers, 200);
    }

    private function validateChofer(){
        return [
            'nombre'=>'required',
            'apellidoPaterno'=>'required',
            'noLicencia'=>'required'
        ];
    }
}
