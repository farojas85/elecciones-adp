<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProcesoElectoralVoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'proceso_electoral_id', 'ministro_id', 'orden', 'cantidad_votos',
        'no_continua', 'pasa_vuelta', 'es_ganador'
    ];

    /**
     * Get the proceso_electoral that owns the ProcesoElectoralVoto
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proceso_electoral(): BelongsTo
    {
        return $this->belongsTo(ProcesoElectoral::class);
    }

    /**
     * Get the ministro that owns the ProcesoElectoralVoto
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ministro(): BelongsTo
    {
        return $this->belongsTo(Ministro::class);
    }
}
