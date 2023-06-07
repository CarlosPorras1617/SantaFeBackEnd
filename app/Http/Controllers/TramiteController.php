<?php

namespace App\Http\Controllers;

use App\Models\Tramite;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class TramiteController extends Controller
{
    public function createTramite(Request $request){
        //validate the data (in progress)
        //$data = $request ->validate($this->validateTramite());

        //Get the data from the body
        $factura = $request->input('factura');
        $placa = $request->input('placa');
        $economico = $request->input('economico');
        $candados = $request->input('candados');
        $numBultos = $request->input('numBultos');
        $numEntrada = $request->input('numEntrada');

        //pick a randon number for the barcode value
        $barcode = $this->generateBarcodeNumber();

        //makes an array with the data that will be insert on DB
        $data = array('factura'=>$factura,"placa"=>$placa,"economico"=>$economico,"candados"=>$candados,"numBultos"=>$numBultos,"numEntrada"=>$numEntrada,"barcode"=>$barcode);

        //to ensure that barcode is an unique number
        while($barcode = Tramite::where('barcode', '=', $barcode)->first()) {
            $barcode = $this->generateBarcodeNumber();

        }

        //get the value of the barcode
        $barcode = $data['barcode'];

        //create the tramite after validation of the data
        Tramite::create($data);

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
        $printer -> close();

        //json response
        return response([
            'Message'=>$data['barcode']
        ], 201);
    }

    //generates the barcode ID number
    function generateBarcodeNumber(){
        $randomNumber = random_int(100000000000, 999999999999);
        return $randomNumber;
    }

}
