<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Section;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Section::factory(10)->create();

        $this->call([
            RolesAndPermissionsSeeder::class,
            DoctorSeeder::class
        ]);
    }
}
