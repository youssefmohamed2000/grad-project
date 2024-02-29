<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\Section;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sections = Section::pluck('id')->all();

        $superAdmin = Doctor::create([
            'section_id' => $sections[rand(0, count($sections) - 1)],
            'name' => fake()->firstName . fake()->lastName,
            'email' => 'super@admin.com',
            'password' => Hash::make('12345678'),
            'phone' => fake()->phoneNumber
        ]);

        $admin = Doctor::create([
            'section_id' => $sections[rand(0, count($sections) - 1)],
            'name' => fake()->firstName . fake()->lastName,
            'email' => 'admin@admin.com',
            'password' => Hash::make('12345678'),
            'phone' => fake()->phoneNumber
        ]);

        Doctor::create([
            'section_id' => $sections[rand(0, count($sections) - 1)],
            'name' => fake()->firstName . fake()->lastName,
            'email' => 'doctor@doctor.com',
            'password' => Hash::make('12345678'),
            'phone' => fake()->phoneNumber
        ]);

        $superAdminRole = Role::where('name', '=', 'super_admin')->pluck('id');
        $superAdmin->assignRole($superAdminRole);

        $adminRole = Role::where('name', '=', 'admin')->pluck('id');
        $admin->assignRole($adminRole);
    }
}
