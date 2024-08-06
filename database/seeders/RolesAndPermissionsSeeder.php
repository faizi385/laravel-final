<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Create roles
        $superadmin = Role::create(['name' => 'superadmin']);
        $user = Role::create(['name' => 'user']);

        // Optionally, create permissions
        // $managePostsPermission = Permission::create(['name' => 'manage posts']);

        // Assign permissions to roles
        // $superadmin->givePermissionTo($managePostsPermission);
    }
}
