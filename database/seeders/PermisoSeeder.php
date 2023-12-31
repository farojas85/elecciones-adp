<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permiso;

class PermisoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role1 = Role::select('id')->where('slug','super-usuario')->first();
        //Tipo Acceso
        $permiso1 = Permiso::firstOrCreate([
            'nombre' => 'Vista Tipo Acceso','slug' => 'tipo-accesos.inicio'
        ])
        ;
        $permiso2 = Permiso::firstOrCreate([
            'nombre' => 'Crear Tipo Acceso','slug' => 'tipo-accesos.crear'
        ])
        ;
        $permiso3 = Permiso::firstOrCreate([
            'nombre' => 'Editar Tipo Acceso','slug' => 'tipo-accesos.editar'
        ])
        ;
        $permiso4 = Permiso::firstOrCreate([
            'nombre' => 'Eliminar Tipo Acceso','slug' => 'tipo-accesos.eliminar'
        ])
        ;
        $permiso5 = Permiso::firstOrCreate([
            'nombre' => 'Restaurar Tipo Acceso','slug' => 'tipo-accesos.restaurar'
        ])
        ;
        //Role
        $permiso6 = Permiso::firstOrCreate([
            'nombre' => 'Vista Rol','slug' => 'roles.inicio'
        ])
        ;
        $permiso7 = Permiso::firstOrCreate([
            'nombre' => 'Crear Rol','slug' => 'roles.crear'
        ])
        ;
        $permiso8 = Permiso::firstOrCreate([
            'nombre' => 'Editar Rol','slug' => 'roles.editar'
        ])
        ;
        $permiso9 = Permiso::firstOrCreate([
            'nombre' => 'Eliminar Rol','slug' => 'roles.eliminar'
        ])
        ;
        $permiso10 = Permiso::firstOrCreate([
            'nombre' => 'Restaurar Rol','slug' => 'roles.restaurar'
        ])
        ;
        //Usuario
        $permiso11 = Permiso::firstOrCreate([
            'nombre' => 'Vista Usuario','slug' => 'usuarios.inicio'
        ])
        ;
        $permiso12 = Permiso::firstOrCreate([
            'nombre' => 'Crear Usuario','slug' => 'usuarios.crear'
        ])
        ;
        $permiso13 = Permiso::firstOrCreate([
            'nombre' => 'Editar Usuario','slug' => 'usuarios.editar'
        ])
        ;
        $permiso14 = Permiso::firstOrCreate([
            'nombre' => 'Eliminar Usuario','slug' => 'usuarios.eliminar'
        ])
        ;
        $permiso15 = Permiso::firstOrCreate([
            'nombre' => 'Restaurar Usuario','slug' => 'usuarios.restaurar'
        ])
        ;
        //Permiso
        $permiso16 = Permiso::firstOrCreate([
            'nombre' => 'Vista Permiso','slug' => 'permisos.inicio'
        ])
        ;
        $permiso17 = Permiso::firstOrCreate([
            'nombre' => 'Crear Permiso','slug' => 'permisos.crear'
        ])
        ;
        $permiso18 = Permiso::firstOrCreate([
            'nombre' => 'Editar Permiso','slug' => 'permisos.editar'
        ])
        ;
        $permiso19 = Permiso::firstOrCreate([
            'nombre' => 'Eliminar Permiso','slug' => 'permisos.eliminar'
        ])
        ;
        $permiso20 = Permiso::firstOrCreate([
            'nombre' => 'Restaurar Permiso','slug' => 'permisos.restaurar'
        ])
        ;
        //Permiso Role
        $permiso21 = Permiso::firstOrCreate([
            'nombre' => 'Vista Permiso/Role','slug' => 'permiso-role.inicio'
        ])
        ;
        $permiso22 = Permiso::firstOrCreate([
            'nombre' => 'Guardar Permiso/Role','slug' => 'permiso-role.guardar'
        ])
        ;
        //Menú
        $permiso23 = Permiso::firstOrCreate([
            'nombre' => 'Vista Menú','slug' => 'menus.inicio'
        ])
        ;
        $permiso24 = Permiso::firstOrCreate([
            'nombre' => 'Crear Menú','slug' => 'menus.crear'
        ])
        ;
        $permiso25 = Permiso::firstOrCreate([
            'nombre' => 'Editar Menú','slug' => 'menus.editar'
        ])
        ;
        $permiso26 = Permiso::firstOrCreate([
            'nombre' => 'Eliminar Menú','slug' => 'menus.eliminar'
        ])
        ;
        $permiso27 = Permiso::firstOrCreate([
            'nombre' => 'Restaurar Menú','slug' => 'menus.restaurar'
        ])
        ;
        //Menú - Role
        $permiso28 = Permiso::firstOrCreate([
            'nombre' => 'Vista Menú/Roles','slug' => 'menu-role.inicio'
        ])
        ;
        $permiso29 = Permiso::firstOrCreate([
            'nombre' => 'Guardar Menú/Roles','slug' => 'menu-role.guardar'
        ])
        ;

        $role1->permisos()->sync([
            $permiso1->id, $permiso2->id,$permiso3->id,$permiso4->id,$permiso5->id,$permiso6->id,$permiso7->id,$permiso8->id,$permiso9->id,$permiso10->id,
            $permiso11->id, $permiso12->id,$permiso13->id,$permiso14->id,$permiso15->id,$permiso16->id,$permiso17->id,$permiso18->id,$permiso19->id,$permiso20->id,
            $permiso21->id, $permiso22->id,$permiso23->id,$permiso24->id,$permiso25->id,$permiso26->id,$permiso27->id,$permiso28->id,$permiso29->id
        ]);
    }
}
