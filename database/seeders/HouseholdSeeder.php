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
                'no_kk' => '3201010101010002',
            ],
            [
                'no_kk' => '3273010100010001', 
            ],
            [
                'no_kk' => '3273010100010002',
            ],
            [
                'no_kk' => '3273010100010003', 
            ],
            [
                'no_kk' => '3273010100010004', 
            ],
            [
                'no_kk' => '3273010100010005', 
            ],
            [
                'no_kk' => '3273010100010006', 
            ],
            [
                'no_kk' => '3273010100010007', 
            ],
            [
                'no_kk' => '3273010100010008', 
            ],
            [
                'no_kk' => '3273010100010009', 
            ],
            [
                'no_kk' => '3273010100010010',
            ],
            [
                'no_kk' => '3273010100010011',
            ],
        ];

        foreach ($households as $data) {
            households::create($data);
        }
    }
}
