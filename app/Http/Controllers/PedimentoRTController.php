<?php

namespace App\Http\Controllers;

use App\Models\PedimentoRT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PedimentoRTController extends Controller
{
     //create PedimentoRT
     public function createPedimentoRT(Request $request){
        $data = $request->all();
        //$data['noPedimento'] = filled($data['noPedimento']) ? $data['noPedimento'] : 'El trámite es operación A1';
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
            $PedimentoRT = PedimentoRT::create($data);
            return response ([
                'message' => 'PedimentoRT created',
                'pedimento RT' => $PedimentoRT
            ], 201);
        }
    }

    //Get all pedimentos RT
    public function getPedimentosRT(){
        $pedimentos = PedimentoRT::all();
        return response($pedimentos, 200);
    }

    //get a Pedimento RT
    public function getPedimentoRT($id){
        $PedimentoRT = PedimentoRT::find($id);
        if($PedimentoRT != null){
            return response($PedimentoRT, 200);
        }
        return response(['message' => 'Pedimento RT not found'], 404);
    }

    //Get pedimentos RT activos
    public function getPedimentosRTActivos(){
        $pedimentosRT = PedimentoRT::where('status', '=', 1)->paginate(20);
        return response($pedimentosRT, 200);
    }

    //get inactive perdimentos RT
    public function getPedimentosRTInactivos(){
        $pedimentosRT = PedimentoRT::where('status', '=', 0)->paginate(20);
        return response($pedimentosRT, 200);
    }

    //get for semana
    public function lookForSemanaPedimentoRT(Request $request){
        try {
            $semana = $request->input('semana');
            $pedimentosRT = PedimentoRT::where('semana', 'like', '%' . $semana . '%');
            $pedimentos = $pedimentosRT->orderBy('semana','desc')->get();
            return response($pedimentos, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    //update Pedimento RT
    public function updatePedimentoRT($id, Request $request){
        $PedimentoRT = PedimentoRT::find($id);
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
            $PedimentoRT->update($data);
            return response ([
                'message' => 'PedimentoRT updated',
                'pedimento RT' => $PedimentoRT
            ], 201);
        }
    }

    //hide Pedimento RT
    public function hidePedimentoRT($id){
        $PedimentoRT = PedimentoRT::find($id);
        if (!$PedimentoRT) {
            return response ([
                'message'=>'Pedimento RT with the ID: ' . $id . ' could not be found'
            ], 404);
        }
        $PedimentoRT->status = 0;
        if (!$PedimentoRT->save()) {
            return response ([
                'message'=> 'Unexpected error'
            ], 500);
        }else{
            return response([
                'message'=> 'Pedimento RT eliminated'
            ],200);
        }
    }

    //eliminates Pedimento RT
    public function eliminatePedimentoRT($id){
        $PedimentoRT = PedimentoRT::find($id);
        if (!$PedimentoRT) {
            return response([
                'message' => 'Pedimento RT with ID ' . $id . ' could not be found'
            ], 404);
        }
        $PedimentoRT->delete();
        return response([
            'message' => 'Pedimento RT eliminated'
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
