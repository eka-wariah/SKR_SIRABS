<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WasteBankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('waste_banks')->insert([
            [
                'wtb_name_id' => 6, // Lay Zhang
                'wtb_total_money' => 5000,
                'wtb_deposit_type' => 'tabung',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'wtb_name_id' => 7, // Eka Wariah
                'wtb_total_money' => 7500,
                'wtb_deposit_type' => 'tabung',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'wtb_name_id' => 8, // Chengyi
                'wtb_total_money' => 10000,
                'wtb_deposit_type' => 'tabung',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'wtb_name_id' => 9, // Xiao Zhan
                'wtb_total_money' => 8200,
                'wtb_deposit_type' => 'tabung',
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);
    }
}
