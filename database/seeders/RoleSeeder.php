<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $coordinador = Role::create(['name' => 'coordinador']);
        $secretario = Role::create(['name' => 'secretario']);
        $miembro = Role::create(['name' => 'miembro']);
        $invitado = Role::create(['name' => 'invitado']);
        $estudiante = Role::create(['name' => 'estudiante']);

        // permisos de sesion
        Permission::create(['name' => 'create_session'])->syncRoles([$coordinador, $secretario]);
        Permission::create(['name' => 'read_session'])->syncRoles([$coordinador,$secretario,$miembro,$invitado,$estudiante]);
        Permission::create(['name' => 'update_session'])->syncRoles([$coordinador, $secretario]);
        Permission::create(['name' => 'delete_session'])->syncRoles([$coordinador,$secretario]);

        //permisos de acta
        Permission::create(['name' => 'create_act'])->syncRoles([$coordinador,$secretario]);
        Permission::create(['name' => 'read_act'])->syncRoles([$coordinador,$secretario,$miembro,$invitado,$estudiante]);
        Permission::create(['name' => 'update_act'])->syncRoles([$coordinador,$secretario]);
        Permission::create(['name' => 'delete_act'])->syncRoles([$coordinador,$secretario]);

        //permisos de orde_sesion
        Permission::create(['name' => 'create_session_order'])->syncRoles([$coordinador,$secretario]);
        Permission::create(['name' => 'read_session_order'])->syncRoles([$coordinador,$secretario,$miembro,$invitado]);
        Permission::create(['name' => 'update_session_order'])->syncRoles([$coordinador,$secretario]);
        Permission::create(['name' => 'delete_session_order'])->syncRoles([$coordinador,$secretario]);

        //permisos de invitados
        Permission::create(['name' => 'create_guest'])->syncRoles([$coordinador,$secretario]);
        Permission::create(['name' => 'read_guest'])->syncRoles([$coordinador,$secretario,$miembro,$invitado]);
        Permission::create(['name' => 'update_guest'])->syncRoles([$coordinador,$secretario]);
        Permission::create(['name' => 'delete_guest'])->syncRoles([$coordinador,$secretario]);

        //permisos de miembro
        Permission::create(['name' => 'create_member'])->syncRoles([$coordinador]);
        Permission::create(['name' => 'read_member'])->syncRoles([$coordinador,$secretario,$miembro,$invitado]);
        Permission::create(['name' => 'update_member'])->syncRoles([$coordinador,$secretario]);
        Permission::create(['name' => 'delete_member'])->syncRoles([$coordinador]);

        //permisos de asistencia_invitados
        Permission::create(['name' => 'create_guest_attendance'])->syncRoles([$coordinador]);
        Permission::create(['name' => 'read_guest_attendance'])->syncRoles([$coordinador,$secretario,$miembro,$invitado]);
        Permission::create(['name' => 'update_guest_attendance'])->syncRoles([$coordinador,$secretario]);
        Permission::create(['name' => 'delete_guest_attendance'])->syncRoles([$coordinador]);

        //permisos de asistencia_miembros
        Permission::create(['name' => 'create_member_attendance'])->syncRoles([$coordinador]);
        Permission::create(['name' => 'read_member_attendance'])->syncRoles([$coordinador,$secretario,$miembro]);
        Permission::create(['name' => 'update_member_attendance'])->syncRoles([$coordinador,$secretario,$miembro]);
        Permission::create(['name' => 'delete_member_attendance'])->syncRoles([$coordinador]);

        //permisos de tareas
        Permission::create(['name' => 'create_task'])->syncRoles([$coordinador,$secretario]);
        Permission::create(['name' => 'read_task'])->syncRoles([$coordinador,$secretario,$miembro,$invitado]);
        Permission::create(['name' => 'update_task'])->syncRoles([$coordinador,$secretario]);
        Permission::create(['name' => 'delete_task'])->syncRoles([$coordinador,$secretario]);

        //permisos de encargado_tareas
        Permission::create(['name' => 'create_task_mandated'])->syncRoles([$coordinador,$secretario]);
        Permission::create(['name' => 'read_task_mandated'])->syncRoles([$coordinador,$secretario,$miembro,$invitado]);
        Permission::create(['name' => 'update_task_mandated'])->syncRoles([$coordinador,$secretario]);
        Permission::create(['name' => 'delete_task_mandated'])->syncRoles([$coordinador,$secretario]);

        //permisos de proposiciones
        Permission::create(['name' => 'create_proposal'])->syncRoles([$coordinador,$secretario,$miembro,$invitado]);
        Permission::create(['name' => 'read_proposal'])->syncRoles([$coordinador,$secretario,$miembro,$invitado]);
        Permission::create(['name' => 'update_proposal'])->syncRoles([$coordinador,$secretario,$miembro,$invitado]);
        Permission::create(['name' => 'delete_proposal'])->syncRoles([$coordinador,$secretario,$miembro,$invitado]);

        //permisos de solicitud
        Permission::create(['name' => 'create_petition'])->syncRoles([$coordinador,$secretario,$miembro,$invitado]);
        Permission::create(['name' => 'read_petition'])->syncRoles([$coordinador,$secretario,$miembro,$invitado,$estudiante]);
        Permission::create(['name' => 'update_petition'])->syncRoles([$coordinador,$secretario,$miembro,$invitado]);
        Permission::create(['name' => 'delete_petition'])->syncRoles([$coordinador,$secretario,$miembro,$invitado]);

        // permisos de solicitante
        Permission::create(['name' => 'create_applicants'])->syncRoles([$coordinador,$secretario,$miembro,$invitado]);
        Permission::create(['name' => 'read_applicants'])->syncRoles([$coordinador,$secretario,$miembro,$invitado,$estudiante]);
        Permission::create(['name' => 'update_applicants'])->syncRoles([$coordinador,$secretario,$miembro,$invitado]);
        Permission::create(['name' => 'delete_applicants'])->syncRoles([$coordinador,$secretario,$miembro,$invitado]);

        //permisos de description
        Permission::create(['name' => 'create_description'])->syncRoles([$coordinador,$secretario,$miembro,$invitado]);
        Permission::create(['name' => 'read_description'])->syncRoles([$coordinador,$secretario,$miembro,$invitado,$estudiante]);
        Permission::create(['name' => 'update_description'])->syncRoles([$coordinador,$secretario,$miembro,$invitado]);
        Permission::create(['name' => 'delete_description'])->syncRoles([$coordinador,$secretario,$miembro,$invitado]);

    }
}
