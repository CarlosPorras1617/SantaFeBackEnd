<?php

namespace App\Http\Controllers;

use App\Models\Tramite;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class TramiteController extends Controller
{
    //get tramites
    public function getTramites()
    {
        //shows recients tramites
        $tramites = Tramite::orderBy('id', 'desc')->get();
        return response($tramites, 200);
    }

    //get active tramites
    public function getTramitesActivos()
    {
        $tramites = Tramite::where('status', '=', 1)->paginate(7);
        return response($tramites, 200);
    }

    //get only one tramite
    public function getTramite($id)
    {
        $tramite = Tramite::find($id);
        if ($tramite != null) {
            return response($tramite, 200);
        }
        return response(['message' => 'tramite not found'], 404);
    }

    //get inactive tramites
    public function getTramitesInactivos()
    {
        $tramites = Tramite::where('status', '=', 0)->paginate(7);
        return response($tramites, 200);
    }

    //get inactives all tramites
    public function getActiveAllTramites()
    {
        //shows recients tramites
        $tramites = Tramite::where('status', '=', 1)->get();
        return response($tramites, 200);
    }

    //get inactives all tramites
    public function getInactiveAllTramites()
    {
        //shows recients tramites
        $tramites = Tramite::where('status', '=', 0)->get();
        return response($tramites, 200);
    }

    //get by numero de entrada only
    public function obtenerNumEntradaOnly($numEntrada)
    {
        $tramite = Tramite::where('numEntrada', '=', $numEntrada)->first();
        if (!$tramite) {
            return response([
                'message' => 'Tramite with the numEntrada:  ' . $numEntrada . ' could not be found'
            ], 404);
        } else {
            return response($tramite, 200);
        }
    }

    //capture tramite
    public function capturarTramite($barcode)
    {
        //$codigo = strval($barcode);
        $tramite = Tramite::where('barcode', '=', $barcode)->first();
        if (!$tramite) {
            return response([
                'message' => 'Tramite with the Barcode ' . $barcode . ' could not be found'
            ], 404);
        }
        $tramite->status = 0;
        if (!$tramite->save()) {
            return response([
                'message' => 'Unexpected error'
            ], 500);
        } else {
            return response([
                'message' => 'Tramite Capturado'
            ], 200);
        }
    }

    //hide a tramite
    public function hideTramite($id)
    {
        $tramite = Tramite::find($id);
        if (!$tramite) {
            return response([
                'message' => 'Tramite with the ID: ' . $id . 'could not be found'
            ], 404);
        }
        $tramite->status = 0;
        if (!$tramite->save()) {
            return response([
                'message' => 'Unexpected error'
            ], 500);
        } else {
            return response([
                'message' => 'Tramite eliminated'
            ], 200);
        }
    }

    //eliminate a tramite
    public function eliminateTramite($id)
    {
        $tramite = Tramite::find($id);
        if (!$tramite) {
            return response([
                'message' => 'Tramite with ID ' . $id . ' could not be found'
            ], 404);
        }
        $tramite->delete();
        return response([
            'message' => 'Tramite eliminated'
        ]);
    }

    //update a tramite
    public function updateTramite(Request $request, $id)
    {
        $tramite = Tramite::find($id);
        $data = $request->all();

        //rules to validate
        $rules = [
            'pedimentoRT' => 'required|numeric|digits:7',
            'pedimentoA1' => 'required|numeric|digits:7',
            'factura' => 'required',
            'cliente' => 'required',
            'chofer' => 'required',
            'placa' => 'required',
            'economico' => 'required',
            'candados' => 'required',
            'numBultos' => 'required|numeric|max:99',
            'numEntrada' => 'required|numeric|digits:11'
        ];

        $validation = $this->validateTramite($data, $rules);

        if ($validation['error']) {
            return response([
                'message' => $validation['message']
            ], 422);
        }

        $tramite->update($data);

        return response([
            'message' => 'Tramite updated'
        ], 201);
    }

    //find by numero entrada
    public function lookForNumeroEntrada(Request $request)
    {
        try {
            $numEntrada = $request->input('numEntrada');
            $tramite = Tramite::where('numEntrada', 'like', '%' . $numEntrada . '%');
            $tramites = $tramite->paginate(10);
            return response($tramites, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    //print barcode
    public function imprimirCodigo($id)
    {
        $tramite = Tramite::find($id);
        if ($tramite != null) {

            //prepare the thermal printer
            $connector = new WindowsPrintConnector("GTP582");
            $printer = new Printer($connector);
            $printer->selectPrintMode(Printer::MODE_DOUBLE_HEIGHT | Printer::MODE_DOUBLE_WIDTH);

            //image
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $image = EscposImage::load('images/AgenciaSantaFeIcon.png', false);
            $printer->bitImage($image);
            $printer->feed();


            //text
            $printer->setTextSize(1, 1);
            $printer->setEmphasis(true);
            $printer->text("Economico: " . $tramite['economico'] . "\n");
            $printer->text("Creacion: " . $tramite['created_at'] . "\n");
            $printer->text("Impresión: " . Carbon::now()->toDateString());
            $printer->feed();

            //barcode
            $printer->setBarcodeTextPosition(Printer::BARCODE_TEXT_BELOW);
            $printer->barcode($tramite['barcode'], Printer::BARCODE_ITF);
            $printer->feed(4);

            //cut the paper
            $printer->cut();

            //close the printer
            $printer->close();

            return response([
                'economico' => $tramite['economico'],
                'fecha' => $tramite['created_at'],
                'barcode' => $tramite['barcode']
            ]);
        }
        return response(['message' => 'tramite not found'], 404);
    }

    public function createTramite(Request $request)
    {
        //Get the data from the body
        $factura = $request->input('factura');
        $pedimentoRT = $request->input('pedimentoRT');
        $pedimentoA1 = $request->input('pedimentoA1');
        $cliente = $request->input('cliente');
        $chofer = $request->input('chofer');
        $noLicenciaChofer = $request->input('noLicenciaChofer');
        $cellChofer = $request->input('cellChofer');
        $placa = $request->input('placa');
        $economico = $request->input('economico');
        $candados = $request->input('candados');
        $numBultos = $request->input('numBultos');
        $numEntrada = $request->input('numEntrada');

        //rules to valdiate
        $rules = [
            'pedimentoRT' => 'required|numeric|digits:7',
            'pedimentoA1' => 'required|numeric|digits:7',
            'factura' => 'required',
            'cliente' => 'required',
            'chofer' => 'required',
            'placa' => 'required',
            'economico' => 'required',
            'candados' => 'required',
            'numBultos' => 'required|numeric|max:99',
            'numEntrada' => 'required|numeric|digits:11'
        ];

        //pick a randon number for the barcode value
        $barcode = $this->generateBarcodeNumber();

        //makes an array with the data that will be insert on DB
        $data = array(
            "factura" => $factura,
            "pedimentoRT" => $pedimentoRT,
            "pedimentoA1" => $pedimentoA1,
            "cliente" => $cliente,
            "chofer" => $chofer,
            "noLicenciaChofer" => $noLicenciaChofer,
            "cellChofer" => $cellChofer,
            "placa" => $placa,
            "economico" => $economico,
            "candados" => $candados,
            "numBultos" => $numBultos,
            "numEntrada" => $numEntrada,
            "barcode" => $barcode
        );

        //validation
        $validation = $this->validateTramite($data, $rules);
        if ($validation['error']) {
            return response([
                'message' => $validation['message']
            ], 422);
        } else {
            //to ensure that barcode is an unique number
            while ($barcode = Tramite::where('barcode', '=', $barcode)->first()) {
                $barcode = $this->generateBarcodeNumber();
            }
            //get the value of the barcode
            $barcode = $data['barcode'];
            //create the tramite after validation of the data
            Tramite::create($data);

            //prepare the thermal printer
            /*$connector = new WindowsPrintConnector("GTP582");
            $printer = new Printer($connector);
            $printer->selectPrintMode(Printer::MODE_DOUBLE_HEIGHT | Printer::MODE_DOUBLE_WIDTH);

            //image
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $image = EscposImage::load('images/AgenciaSantaFeIcon.png', false);
            $printer->bitImage($image);
            $printer->feed();


            //text
            $printer->setTextSize(1, 1);
            $printer->setEmphasis(true);
            $printer->text("Economico: " . $data['economico']. "\n");
            $printer->text("Impresión: " . Carbon::now()->toDateString());
            $printer->feed();

            //barcode
            $printer->setBarcodeTextPosition(Printer::BARCODE_TEXT_BELOW);
            $printer->barcode($barcode, Printer::BARCODE_ITF);
            $printer->feed(4);

            //cut the paper
            $printer->cut();

            //close the printer
            $printer -> close();*/

            return response([
                'message' => 'Tramite created',
                'barcode' => $data['barcode']
            ], 201);
        }
    }

    //generates the barcode ID number
    function generateBarcodeNumber()
    {
        $randomNumber = random_int(100000000000, 999999999999);
        return $randomNumber;
    }

    //validates Tramites
    private function validateTramite($data, $rules)
    {
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return [
                'error' => true,
                'message' => $validator->errors()
            ];
        }
        return [
            'error' => false
        ];
    }
}
