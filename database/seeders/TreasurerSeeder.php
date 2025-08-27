<?php

namespace Database\Seeders;

use App\Models\treasurer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TreasurerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        treasurer::create([
            'trs_name_id' => 4,
            'trs_area_id' => 1
        ]);
        treasurer::create([
            'trs_name_id' => 5,
            'trs_area_id' => 2
        ]);

    }
}
