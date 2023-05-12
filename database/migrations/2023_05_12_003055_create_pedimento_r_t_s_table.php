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
        Schema::create('pedimento_r_t_s', function (Blueprint $table) {
            $noPedimento = 'El trámite es operación A1';
            $table->id();
            $table->integer('semana');
            $table->integer('patente');
            $table->string('noPedimento')->nullable()->default($noPedimento);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedimento_r_t_s');
    }
};
