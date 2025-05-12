<?php

namespace Database\Seeders;

use App\Models\area_scope;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AreaScopeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        area_scope::create([
            'asc_level' => 'RT',
            'asc_number' => 0
        ]);
    }
}
