<?php

namespace App\Http\Controllers;

use App\Models\chofer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChoferController extends Controller
{
    //create chofer
    public function createChofer(Request $request){
        $data = $request->all();
        $data['apellidoMaterno'] = filled($data['apellidoMaterno']) ? $data['apellidoMaterno'] : 'NA';
        $data['fechaNacimiento'] = filled($data['fechaNacimiento']) ? $data['fechaNacimiento'] : '1900/01/01';
        $data['numCelular'] = filled($data['numCelular']) ? $data['numCelular'] : 'NA';
        $data['noVisa'] = filled($data['noVisa']) ? $data['noVisa'] : 'NA';
        $rules = [
            'nombre'=>'required',
            'apellidoPaterno'=>'required',
            'noLicencia'=>'required'
        ];
        $validation = $this->validateChofer($data, $rules);
        if ($validation['error']) {
            return response([
                'message' => $validation['message']
            ], 422);
        }else{
            $chofer = chofer::create($data);
            return response([
                'Message'=>'Chofer Created',
                'Chofer'=>$chofer
            ], 201);
        }
    }

    //get all chofer
    public function getChofers(){
        $chofers = chofer::all();
        $chofers = chofer::paginate(20);
        return response($chofers, 200);
    }

    //get active chofers
    public function getChofersActivos(){
        $chofers = chofer::where('status', '=', 1)->paginate(20);
        return response($chofers, 200);
    }

    //get inactive chofers
    public function getChofersInactivos(){
        $chofers = chofer::where('status', '=', 0)->paginate(20);
        return response($chofers, 200);
    }

    //updateChofer
    public function updateChofer($id, Request $request){
        $chofer = chofer::find($id);
        $data = $request->all();
        $data['apellidoMaterno'] = filled($data['apellidoMaterno']) ? $data['apellidoMaterno'] : 'NA';
        $data['fechaNacimiento'] = filled($data['fechaNacimiento']) ? $data['fechaNacimiento'] : '1900/01/01';
        $data['numCelular'] = filled($data['numCelular']) ? $data['numCelular'] : 'NA';
        $data['noVisa'] = filled($data['noVisa']) ? $data['noVisa'] : 'NA';

        $rules = [
            'nombre'=>'required',
            'apellidoPaterno'=>'required',
            'noLicencia'=>'required'
        ];

        $validation = $this->validateChofer($data, $rules);

        if ($validation['error']) {
            return response([
                'message' => $validation['message']
            ], 422);
        }

        $chofer->update($data);

        return response([
            'message'=> 'Chofer updated'
        ],201);
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

    //hide a chofer
    public function hideChofer($id){
        $chofer = chofer::find($id);
        if (!$chofer) {
            return response ([
                'message'=>'Chofer with the ID: ' . $id . 'could not be found'
            ], 404);
        }
        $chofer->status = 0;
        if (!$chofer->save()) {
            return response ([
                'message'=> 'Unexpected error'
            ], 500);
        }else{
            return response([
                'message'=> 'Chofer eliminated'
            ],200);
        }
    }

    //eliminates a chofer
    public function eliminateChofer($id){
        $chofer = chofer::find($id);
        if (!$chofer) {
            return response([
                'message' => 'Chofer with ID ' . $id . ' could not be found'
            ], 404);
        }
        $chofer->delete();
        return response([
            'message' => 'Chofer eliminated'
        ]);
    }



    //validates chofers
    private function validateChofer($data, $rules){
        $validator = Validator::make($data, $rules);
        if ($validator -> fails()) {
            return[
                'error'=> true,
                'message'=>$validator->errors()
            ];
        }
        return [
            'error' => false
        ];
    }
}
