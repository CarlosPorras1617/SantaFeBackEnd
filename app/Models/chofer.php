<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class chofer extends Model
{
    //insert data
    protected $fillable = [
        'nombre',
        //'apellidoPaterno',
        //'apellidoMaterno',
        'fechaNacimiento',
        'numCelular',
        'noLicencia',
        'noVisa'
    ];
    use HasFactory;
}
