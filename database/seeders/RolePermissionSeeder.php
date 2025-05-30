<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name'=>'rw_leader']);
        Role::create(['name'=>'treasurer']);
        Role::create(['name'=>'wastebank_officer']);
        Role::create(['name'=>'citizen']);
    }
}
