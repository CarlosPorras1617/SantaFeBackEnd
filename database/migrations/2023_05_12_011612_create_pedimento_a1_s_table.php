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
        Schema::create('pedimento_a1_s', function (Blueprint $table) {
            $noPedimento = 'El trámite es operación RT';
            $table->id();
            $table->integer('semana')->unique();
            $table->integer('patente');
            $table->string('noPedimento')->nullable()->default($noPedimento);
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedimento_a1_s');
    }
};
