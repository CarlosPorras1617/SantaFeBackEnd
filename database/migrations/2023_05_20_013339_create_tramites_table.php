<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tramites', function (Blueprint $table) {
            $table->id();
            $table->string('factura');
            $table->integer('pedimentoRT');
            $table->integer('pedimentoA1');
            $table->string('cliente');
            $table->string('chofer');
            $table->bigInteger('cellChofer')->nullable();
            $table->string('noLicenciaChofer');
            $table->string('placa');
            $table->string('economico');
            $table->string('candados');
            $table->integer('numBultos');
            $table->bigInteger('numEntrada');
            $table->integer('status')->default(1);
            $table->bigInteger('barcode');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tramites');
    }
};
