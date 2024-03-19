<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create permissions
        $permissions = [
            'create_roles', 'read_roles', 'update_roles', 'delete_roles',
            'create_doctors', 'read_doctors', 'update_doctors', 'delete_doctors',
            'create_users', 'read_users', 'update_users', 'delete_users',
            'create_sections', 'read_sections', 'update_sections', 'delete_sections',
            'create_diseases', 'read_diseases', 'update_diseases', 'delete_diseases',
            'create_diagnoses', 'read_diagnoses', 'update_diagnoses', 'delete_diagnoses',
            'read_complains', 'create_complains', 'update_complains', 'delete_complains',
        ];

        $permissions = collect($permissions)->map(function ($permission) {
            return ['name' => $permission, 'guard_name' => 'doctor'];
        });

        Permission::insert($permissions->toArray());

        // create roles
        $superAdminRole = Role::create([
            'guard_name' => 'doctor',
            'name' => 'super_admin'
        ]);

        Role::create([
            'guard_name' => 'doctor',
            'name' => 'admin'
        ]);

        Role::create([
            'guard_name' => 'doctor',
            'name' => 'doctor'
        ]);

        $createdPermissions = Permission::pluck('id')->all();

        $superAdminRole->syncPermissions($createdPermissions);
    }
}
