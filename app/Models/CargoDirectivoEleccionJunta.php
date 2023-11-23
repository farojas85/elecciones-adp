<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CargoDirectivoEleccionJunta extends Pivot
{
    use HasFactory;

    protected $table = 'cargo_directivo_eleccion_junta';

    protected $fillable = [
        'id', 'cargo_directivo_id', 'eleccion_junta_id'
    ];

    /**
     * Get all of the proceso_electorales for the CargoDirectivoEleccionJunta
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function proceso_electorales(): HasMany
    {
        return $this->hasMany(ProcesoElectoral::class, 'proceso_electoral_id', 'id');
    }
}
