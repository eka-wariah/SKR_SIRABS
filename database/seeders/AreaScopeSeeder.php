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
        $data = [
            ['asc_level' => 'RT', 'asc_number' => 1],
            ['asc_level' => 'RT', 'asc_number' => 2],
        ];

        area_scope::insert($data);
    }
}
