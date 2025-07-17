<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\households;

class HouseholdSeeder extends Seeder
{
    public function run(): void
    {
        $households = [
            [
                'no_kk' => '3201010101010001', // KK untuk Lay Zhang & Eka Wariah
            ],
            [
                'no_kk' => '3201010101010002', // KK untuk Chengyi & Xiao Zhan
            ],
        ];

        foreach ($households as $data) {
            households::create($data);
        }
    }
}
