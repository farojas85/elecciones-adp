<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EleccionJuntaCandidato extends Model
{
    use HasFactory;

    protected $fillable = [
        'eleccion_junta_id','ministro_id','numero_candidato','es_activo'
    ];

    /**
     * Get the eleccion_junta that owns the EleccionJuntaCandidato
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function eleccion_junta(): BelongsTo
    {
        return $this->belongsTo(EleccionJunta::class);
    }

    /**
     * Get the ministro that owns the EleccionJuntaCandidato
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ministro(): BelongsTo
    {
        return $this->belongsTo(Ministro::class);
    }

    public static function generarNumeroCandidato($elecion_junta)
    {
        $maxId = Self::where('eleccion_junta_id',$elecion_junta)->count();

        return $maxId == 0 ? 1 : $maxId +1;
    }
}
