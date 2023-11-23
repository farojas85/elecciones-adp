<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JuntaDirectiva extends Model
{
    use HasFactory;

    protected $fillable = [
        'ambito_junta_id', 'nombre', 'ubigeo',
        'es_activo', 'deleted_at'
    ];

    /**
     * Get all of the eleccion_juntas for the JuntaDirectiva
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function eleccion_juntas(): HasMany
    {
        return $this->hasMany(EleccionJunta::class);
    }
}
