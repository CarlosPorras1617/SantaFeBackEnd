<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tramite extends Model
{
    protected $fillable = [
            'factura',
            'chofer',
            'cliente',
            'pedimentoRT',
            'pedimentoA1',
            'placa',
            'economico',
            'candados',
            'numBultos',
            'numEntrada',
            'status',
            'barcode'

    ];
    use HasFactory;
}
