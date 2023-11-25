<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProcesoElectoral extends Model
{
    use HasFactory;

    protected $fillable = [
        'cargo_directivo_eleccion_junta_id', 'vuelta_proceso_id',
        'votos_validos', 'votos_emitidos', 'votos_blancos',
        'fecha', 'hora', 'es_activo', 'finalizado'
    ];

    /**
     * Get the cargo_directo_eleccion_junta that owns the ProcesoElectoral
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cargo_directo_eleccion_junta(): BelongsTo
    {
        return $this->belongsTo(CargoDirectivoEleccionJunta::class, 'cargo_directivo_eleccion_junta_id', 'id');
    }

    /**
     * Get the vuelta_proceso that owns the ProcesoElectoral
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vuelta_proceso(): BelongsTo
    {
        return $this->belongsTo(VueltaProceso::class);
    }

    /**
     * Get all of the proceso_electoral_votos for the ProcesoElectoral
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function proceso_electoral_votos(): HasMany
    {
        return $this->hasMany(ProcesoElectoralVoto::class);
    }

    /**
     * Get all of the registro_mesas for the ProcesoElectoral
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function registro_mesas(): HasMany
    {
        return $this->hasMany(RegistroMesa::class);
    }
}
