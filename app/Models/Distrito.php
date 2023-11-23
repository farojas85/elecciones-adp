<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Distrito extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'codigo', 'nombre' ,'propvincia_id'
    ];

    /**
     * Get the provincia that owns the Distrito
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function provincia(): BelongsTo
    {
        return $this->belongsTo(Provincia::class);
    }
}
