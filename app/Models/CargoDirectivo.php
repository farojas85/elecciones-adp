<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CargoDirectivo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre' , 'es_activo'
    ];

    /**
     * The eleccion_juntas that belong to the CargoDirectivo
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function eleccion_juntas(): BelongsToMany
    {
        return $this->belongsToMany(EleccionJunta::class)->withTimestamps();
    }
}
