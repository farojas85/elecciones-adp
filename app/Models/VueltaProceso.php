<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VueltaProceso extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre', 'abreviatura'
    ];

    /**
     * Get all of the proceso_electorales for the VueltaProceso
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function proceso_electorales(): HasMany
    {
        return $this->hasMany(ProcesoElectoral::class, 'proceso_electoral_id', 'id');
    }
}
