<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {


        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Membuat company
        $companies = [
            'PT. XYZ',
            'PT. XYZ-1',
            'PT. XYZ-2'
        ];

        foreach ($companies as $company_name) {
            Company::create(['company_name' => $company_name]);
        }

        // Mendefinisikan peran
        $roles = ['ADMIN', 'MANAGER', 'SUPERVISOR'];

        // Mendapatkan semua ID company
        $companies_id = Company::pluck('id')->all();

        // Membuat peran untuk setiap company
        foreach ($roles as $role_name) {
            Role::create(['role_name' => $role_name,]);
        }

        // Membuiat user seeder
        User::factory(50)->create();
    }
}
