<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Prestamo extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id', 'cliente_id', 'user_id', 'fecha_prestamo', 'moneda_id',
        'tipo_cambio', 'tasa_interes_id', 'monto', 'interes', 'tipo_cuota_id',
        'numero_cuotas', 'forma_pago_id', 'periodo_gracia', 'dias_morosos',
        'incluye_feriados', 'incluye_sabdom', 'estad_operacion_id',
        'deleted_at'
    ];

    /**
     * Get the cliente that owns the Prestamo
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    /**
     * Get the moneda that owns the Prestamo
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function moneda(): BelongsTo
    {
        return $this->belongsTo(Moneda::class);
    }

    /**
     * Get the tasa_interes that owns the Prestamo
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tasa_interes(): BelongsTo
    {
        return $this->belongsTo(TasaInteres::class);
    }

    /**
     * Get the tipo_cuota that owns the Prestamo
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipo_cuota(): BelongsTo
    {
        return $this->belongsTo(TipoCuota::class);
    }
    /**
     * Get the forma_pago that owns the Prestamo
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function forma_pago(): BelongsTo
    {
        return $this->belongsTo(FormaPago::class);
    }
    /**
     * Get the estado_operacion that owns the Prestamo
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function estado_operacion(): BelongsTo
    {
        return $this->belongsTo(EstadoOperacion::class);
    }
    /**
     * Get all of the cuotas for the Prestamo
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cuotas(): HasMany
    {
        return $this->hasMany(Cuota::class);
    }


}
