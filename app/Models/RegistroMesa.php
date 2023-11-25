<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RegistroMesa extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','proceso_electoral_id', 'eleccion_junta_candidato_id',
        'cantidad_votos'
    ];

    /**
     * Get the user that owns the RegistroMesa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the proceso_electoral that owns the RegistroMesa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proceso_electoral(): BelongsTo
    {
        return $this->belongsTo(ProcesoElectoral::class);
    }

    /**
     * Get the eleccion_junta_candidato that owns the RegistroMesa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function eleccion_junta_candidato(): BelongsTo
    {
        return $this->belongsTo(EleccionJuntaCandidato::class);
    }
}
