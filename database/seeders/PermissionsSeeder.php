<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $role = Role::firstOrCreate(['name' => 'manager']);

        Permission::firstOrCreate(['name' => 'store book'])->assignRole($role);
        Permission::firstOrCreate(['name' => 'update book'])->assignRole($role);
        Permission::firstOrCreate(['name' => 'delete book'])->assignRole($role);
    }
}
