<?php

namespace App\Http\Controllers;

use App\Models\PedimentoA1;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PedimentoA1Controller extends Controller
{
    //create pedimentoA1
    public function createPedimentoA1(Request $request){
        $data = $request->all();
        //$data['noPedimento'] = filled($data['noPedimento']) ? $data['noPedimento'] : 'El trámite es operación RT';
        $rules = [
            'semana' => 'required|numeric|min:1',
            'patente' => 'required|numeric|digits:4',
            'noPedimento' => 'required|numeric|digits:7'
        ];
        $validation = $this->validatePedimento($data, $rules);
        if ($validation['error']) {
            return response([
                'message' => $validation['message']
            ], 422);
        }else{
            $pedimentoA1 = PedimentoA1::create($data);
            return response ([
                'message' => 'PedimentoA1 created',
                'pedimento A1' => $pedimentoA1
            ], 201);
        }
    }

    //Get all pedimentos A1
    public function getPedimentosA1(){
        $pedimentos = PedimentoA1::all();
        return response($pedimentos, 200);
    }

    //get a Pedimento A1
    public function getPedimentoA1($id){
        $pedimentoA1 = PedimentoA1::find($id);
        if($pedimentoA1 != null){
            return response($pedimentoA1, 200);
        }
        return response(['message' => 'Pedimento A1 not found'], 404);
    }

    //Get pedimentos A1 activos
    public function getPedimentosA1Activos(){
        $pedimentosA1 = PedimentoA1::where('status', '=', 1)->paginate(20);
        return response($pedimentosA1, 200);
    }

    //get inactive perdimentos A1
    public function getPedimentosA1Inactivos(){
        $pedimentosA1 = PedimentoA1::where('status', '=', 0)->paginate(20);
        return response($pedimentosA1, 200);
    }

    //get for semana
    public function lookForSemanaPedimentoA1(Request $request){
        try {
            $semana = $request->input('semana');
            $pedimentosA1 = PedimentoA1::where('semana', 'like', '%' . $semana . '%');
            $pedimentos = $pedimentosA1->orderBy('semana','desc')->get();
            return response($pedimentos, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    //update Pedimento A1
    public function updatePedimentoA1($id, Request $request){
        $pedimentoA1 = PedimentoA1::find($id);
        $data = $request->all();
        //$data['noPedimento'] = filled($data['noPedimento']) ? $data['noPedimento'] : 'El trámite es operación RT';
        $rules = [
            'semana' => 'required|numeric|min:1',
            'patente' => 'required|numeric|digits:4',
            'noPedimento' => 'required|numeric|digits:7'
        ];
        $validation = $this->validatePedimento($data, $rules);
        if ($validation['error']) {
            return response([
                'message' => $validation['message']
            ], 422);
        }else{
            $pedimentoA1->update($data);
            return response ([
                'message' => 'PedimentoA1 updated',
                'pedimento A1' => $pedimentoA1
            ], 201);
        }
    }

    //hide Pedimento A1
    public function hidePedimentoA1($id){
        $pedimentoA1 = PedimentoA1::find($id);
        if (!$pedimentoA1) {
            return response ([
                'message'=>'Pedimento A1 with the ID: ' . $id . ' could not be found'
            ], 404);
        }
        $pedimentoA1->status = 0;
        if (!$pedimentoA1->save()) {
            return response ([
                'message'=> 'Unexpected error'
            ], 500);
        }else{
            return response([
                'message'=> 'Pedimento A1 eliminated'
            ],200);
        }
    }

    //eliminates Pedimento A1
    public function eliminatePedimentoA1($id){
        $pedimentoA1 = PedimentoA1::find($id);
        if (!$pedimentoA1) {
            return response([
                'message' => 'Pedimento A1 with ID ' . $id . ' could not be found'
            ], 404);
        }
        $pedimentoA1->delete();
        return response([
            'message' => 'Pedimento A1 eliminated'
        ]);
    }

    //validates Pedimentos
    private function validatePedimento($data, $rules){
        $validator = Validator::make($data, $rules);
        if ($validator -> fails()) {
            return [
                'error' => true,
                'message'=>$validator->errors()
            ];
        }
        return [
            'error' => false
        ];
    }
}
