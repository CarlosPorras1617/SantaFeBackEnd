<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedimentoA1 extends Model
{
    protected $fillable = [
        'semana',
        'patente',
        'noPedimento'
    ];
    use HasFactory;
}
