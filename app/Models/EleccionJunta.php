<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EleccionJunta extends Model
{
    use HasFactory;

    protected $fillable = [
        'periodo_junta_id', 'junta_directiva_id', 'fecha',
        'hora', 'es_activo'
    ];

    /**
     * Get the periodo_junta that owns the EleccionJunta
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function periodo_junta(): BelongsTo
    {
        return $this->belongsTo(PeriodoJunta::class);
    }

    /**
     * Get the junta_directiva that owns the EleccionJunta
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function junta_directiva(): BelongsTo
    {
        return $this->belongsTo(JuntaDirectiva::class);
    }

    /**
     * The cargo_directivos that belong to the EleccionJunta
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function cargo_directivos(): BelongsToMany
    {
        return $this->belongsToMany(CargoDirectivo::class)->withTimestamps();
    }

    /**
     * Get all of the eleccion_junta_candidatos for the EleccionJunta
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function eleccion_junta_candidatos(): HasMany
    {
        return $this->hasMany(EleccionJuntaCandidato::class);
    }
}
