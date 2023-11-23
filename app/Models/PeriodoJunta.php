<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PeriodoJunta extends Model
{
    use HasFactory;

    protected $fillable = [
        'anio_inicio', 'anio_fin', 'es-activo'
    ];

    /**
     * Get all of the eleccion_juntas for the PeriodoJunta
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function eleccion_juntas(): HasMany
    {
        return $this->hasMany(EleccionJunta::class);
    }

    // public static function maxOrdenMinistro(int $periodo)
    // {
    //     $max = DB::table('ministro_periodo_junta')
    //                 ->where('periodo_junta_id',$periodo)
    //                 ->max('orden');

    //     return ($max ?? 0 ) + 1;
    // }

    // public static function modificarOrden(int $periodo,int $ministro)
    // {
    //     $ministro_orden = DB::table('ministro_periodo_junta')
    //                 ->where('periodo_junta_id',$periodo)
    //                 ->where('ministro_id',$ministro)
    //                 ->select('id','orden')
    //                 ->first();

    //     DB::table('ministro_periodo_junta')
    //                 ->where('periodo_junta_id',$periodo)
    //                 ->where('orden','>',$ministro_orden->orden)
    //                 ->update([ 'orden' => DB::Raw("orden -1 ")]);
    // }
}
