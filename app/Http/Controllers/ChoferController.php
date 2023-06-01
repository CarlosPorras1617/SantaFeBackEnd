<?php

namespace App\Http\Controllers;

use App\Models\chofer;
use Illuminate\Http\Request;

class ChoferController extends Controller
{
    //create chofer
    public function createChofer(Request $request){
        $data = $request->validate($this->validateChofer());
        $chofer =chofer::create($data);
        return response([
            'Message'=>'Chofer Created',
            'id'=> $chofer('id')
        ], 201);
    }

    //get all chofer
    public function getChofers(){
        $chofers = chofer::all();
        $chofers = chofer::paginate(20);
        return response($chofers, 200);
    }

    //get only one chofer
    public function getChofer($id){
        $chofer = chofer::find($id);
        if($chofer != null){
            return response($chofer, 200);
        }
        return response(['message' => 'Chofer not found'], 404);
    }

    //search like query
    public function lookForNameChofer(Request $request){
        try {
            $nombre = $request->input('nombre');
            $apellidoPaterno = $request->input('apellidoPaterno');
            $apellidoMaterno = $request->input('apellidoMaterno');
            $chofer = Chofer::where('nombre', 'like', '%' . $nombre . '%');

            if ($apellidoPaterno) {
                $chofer->where('apellidoPaterno', 'like', '%' . $apellidoPaterno . '%');
            }

            if ($apellidoMaterno) {
                $chofer->where('apellidoMaterno', 'like', '%' . $apellidoMaterno . '%');
            }

            $choferes = $chofer->get();

            return response($choferes, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function validateChofer(){
        return [
            'nombre'=>'required',
            'apellidoPaterno'=>'required',
            'noLicencia'=>'required'
        ];
    }
}
