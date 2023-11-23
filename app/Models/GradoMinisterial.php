<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GradoMinisterial extends Model
{
    use HasFactory;

    protected $table = 'grado_ministeriales';

    protected $fillable = ['id', 'nombre', 'es_activo'];

    // /**
    //  * The ministros that belong to the GradoMinisterial
    //  *
    //  * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
    //  */
    // public function ministros(): BelongsToMany
    // {
    //     return $this->belongsToMany(Ministro::class, 'grado_ministerial_ministro', 'grado_ministerial_id', 'ministro_id')
    //                 ->using(GradoMinisterialMinistro::class)
    //                 ->withTimestamps()->withPivot(['fecha_inicio','ficha_fin', 'es_activo']);
    // }

    /**
     * Get all of the ministros for the GradoMinisterial
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ministros(): HasMany
    {
        return $this->hasMany(Ministro::class);
    }
}
