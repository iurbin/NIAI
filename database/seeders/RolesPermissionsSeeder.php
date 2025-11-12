<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Creating a roles
        $admin = Role::create(['name' => 'admin']);
        $publisher = Role::create(['name' => 'publisher']);
        $viewer = Role::create(['name' => 'viewer']);

        // Creating a permissions
        $manage_users = Permission::create(['name' => 'manage_users']);
        $manage_notes = Permission::create(['name' => 'manage_notes']);
        $view_dashboard = Permission::create(['name' => 'view_dashboard']);
        

        // Assigning a permission to a role
        $admin->givePermissionTo($view_dashboard);
        $admin->givePermissionTo($manage_notes);
        $admin->givePermissionTo($manage_users);
        
        $publisher->givePermissionTo($view_dashboard);
        $publisher->givePermissionTo($manage_notes);

    }
}
