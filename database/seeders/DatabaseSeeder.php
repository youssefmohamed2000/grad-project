<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\ChronicDiseases;
use App\Models\Complain;
use App\Models\Diagnose;
use App\Models\Operation;
use App\Models\Section;
use App\Models\User;
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

        User::factory(5)->create();
        Complain::factory(10)->create();
        Diagnose::factory(10)->create();
        Operation::factory(10)->create();
        ChronicDiseases::factory(10)->create();
    }
}
