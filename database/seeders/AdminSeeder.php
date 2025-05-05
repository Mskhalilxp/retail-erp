<?php

namespace Database\Seeders;

use App\Enums\EmployeeRole;
use App\Models\Team;
use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Admin::create([
            'name' => 'employee',
            'email' => 'employee@example.com',
            'password' => 123123123,
            'phone' => '01000000000',
            'role' => EmployeeRole::super_admin->value
        ]);

        Admin::create([
            'name' => 'developer',
            'email' => 'support@erp.com',
            'password' => 123123123,
            'phone' => '01000000001',
            'role' => EmployeeRole::super_admin->value
        ]);

    }
}
