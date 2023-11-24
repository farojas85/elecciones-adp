<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ministro extends Model
{
    use HasFactory;

    protected $fillable = [
        'persona_id', 'es_activo'
    ];

    /**
     * Get the persona that owns the Ministro
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function persona(): BelongsTo
    {
        return $this->belongsTo(Persona::class);
    }

    /**
     * Get the grado_ministerial that owns the Ministro
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function grado_ministerial(): BelongsTo
    {
        return $this->belongsTo(GradoMinisterial::class);
    }

    /**
     * Get all of the eleccion_junta_candidatos for the Ministro
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function eleccion_junta_candidatos(): HasMany
    {
        return $this->hasMany(EleccionJuntaCandidato::class);
    }
    // /**
    //  * The grado_ministeriales that belong to the Ministro
    //  *
    //  * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
    //  */
    // public function grado_ministeriales(): BelongsToMany
    // {
    //     return $this->belongsToMany(Ministro::class, 'grado_ministerial_ministro', 'grado_ministerial_id', 'ministro_id')
    //                 ->using(GradoMinisterialMinistro::class)
    //                 ->withTimestamps()->withPivot(['fecha_inicio','ficha_fin', 'es_activo']);
    // }

    /**
     * Get all of the proceso_electoral_votos for the Ministro
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function proceso_electoral_votos(): HasMany
    {
        return $this->hasMany(ProcesoElectoralVoto::class);
    }
}
