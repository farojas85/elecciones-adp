<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AmbitoJunta extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre', 'es_activo'
    ];
}
