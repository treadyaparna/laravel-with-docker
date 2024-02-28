<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::factory()->create(['name' => 'admin']);
        $userRole = Role::factory()->create(['name' => 'user']);
        $superAdminRole = Role::factory()->create(['name' => 'super admin']);
    }
}
