<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Provincia extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'codigo', 'nombre' ,'departamento_id'
    ];

    /**
     * Get the departamento that owns the Provincia
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function departamento(): BelongsTo
    {
        return $this->belongsTo(Departamento::class);
    }

    /**
     * Get all of the distritos for the Provincia
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function distritos(): HasMany
    {
        return $this->hasMany(Distrito::class);
    }
}
