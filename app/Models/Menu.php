<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable =[
        'id','nombre','slug','icono','padre_id','orden','es_activo'
    ];

    /**
     * The roles that belong to the Menu
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    /**
     * Get the padre that owns the Menu
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function padre(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'padre_id', 'id');
    }

    /**
     * Get all of the menus for the Menu
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function menus(): HasMany
    {
        return $this->hasMany(Menu::class,'padre_id','id');
    }

    public static function maximoPadreId()
    {
        $maxOrden = Menu::whereNull('padre_id')->max('orden');

        return ($maxOrden == null && $maxOrden == '') ? 0 : ($maxOrden + 1);
    }

    public static function maximoHijoId($padre_id)
    {
        $maxOrden = Menu::where('padre_id',$padre_id)->max('orden');
        return ($maxOrden == null || $maxOrden == '') ? 0 : ($maxOrden + 1);
    }

}
