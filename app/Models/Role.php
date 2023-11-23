<?php

namespace App\Models;

use App\Http\Traits\MenuFacadeTrait;
use App\Http\Traits\PermisoFacadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Role extends Model
{
    use HasFactory, SoftDeletes, MenuFacadeTrait, PermisoFacadeTrait;

    protected $fillable = [
        'nombre', 'slug', 'tipo_acceso_id', 'es_activo'
    ];

    /**
     * Get the tipoo_acceso that owns the Role
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipo_acceso(): BelongsTo
    {
        return $this->belongsTo(TipoAcceso::class);
    }

    /**
     * The users that belong to the Role
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    /**
     * The menus that belong to the Role
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function menus(): BelongsToMany
    {
        return $this->belongsToMany(Menu::class)->withTimestamps();
    }

    /**
     * The permisos that belong to the Role
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permisos(): BelongsToMany
    {
        return $this->belongsToMany(Permiso::class)->withTimestamps();
    }
}
