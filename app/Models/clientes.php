<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class clientes extends Model
{
    //insert data
    protected $fillable = [
        'nombre',
        'rfc',
        'status'
    ];
    use HasFactory;
}
