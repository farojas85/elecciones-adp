<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Model;

class GradoMinisterialMinistro extends Pivot
{
    use HasFactory;

    protected $table = 'grado_ministerial_ministro';

    protected $fillable = [
        'id', 'grado_ministerial', 'ministro_id', 'fecha_inicio',
        'fecha_fin', 'es_activo'
    ];
}
