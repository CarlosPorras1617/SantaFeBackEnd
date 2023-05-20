<?php

namespace App\Http\Controllers;

use App\Models\Tramite;
use Illuminate\Http\Request;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class TramiteController extends Controller
{
    public function createTramite(Request $request){
        //$data = $request ->validate($this->validateTramite());
        $factura = $request->input('factura');
        $placa = $request->input('placa');
        $economico = $request->input('economico');
        $candados = $request->input('candados');
        $numBultos = $request->input('numBultos');
        $numEntrada = $request->input('numEntrada');
        $barcode = $this->generateBarcodeNumber();
        $data = array('factura'=>$factura,"placa"=>$placa,"economico"=>$economico,"candados"=>$candados,"numBultos"=>$numBultos,"numEntrada"=>$numEntrada,"barcode"=>$barcode);
        while($barcode = Tramite::where('barcode', '=', $barcode)->first()) {
            $barcode = $this->generateBarcodeNumber();

        }
        Tramite::create($data);
        $connector = new WindowsPrintConnector("POS-58");; // Ruta de archivo o nombre de dispositivo de la impresora
        $printer = new Printer($connector);

        $printer = new Printer($connector);
        $printer -> text("Numero Unico Codigo Barras\n");
        $printer -> text($data['barcode']);
        $printer -> cut();
        $printer->feed(5);
    /* Close printer */
        $printer -> close();
        return response([
            'Message'=>$data['barcode']
        ], 201);
    }

    function generateBarcodeNumber(){
        $randomNumber = random_int(100000000000, 999999999999);
        return $randomNumber;
    }

}
