<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TrashCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('trash_categories')->insert([
            [
                'trc_name' => 'Plastik',
                'trc_price' => 2000,
                'trc_created_at' => $now,
                'trc_updated_at' => $now,
                'trc_created_by' => 1,
                'trc_updated_by' => 1,
                'trc_sys_note' => 'Kategori sampah plastik'
            ],
            [
                'trc_name' => 'Kertas',
                'trc_price' => 1500,
                'trc_created_at' => $now,
                'trc_updated_at' => $now,
                'trc_created_by' => 1,
                'trc_updated_by' => 1,
                'trc_sys_note' => 'Kategori sampah kertas'
            ],
            [
                'trc_name' => 'Logam',
                'trc_price' => 3000,
                'trc_created_at' => $now,
                'trc_updated_at' => $now,
                'trc_created_by' => 1,
                'trc_updated_by' => 1,
                'trc_sys_note' => 'Kategori sampah logam'
            ],
            [
                'trc_name' => 'Botol Kaca',
                'trc_price' => 2500,
                'trc_created_at' => $now,
                'trc_updated_at' => $now,
                'trc_created_by' => 1,
                'trc_updated_by' => 1,
                'trc_sys_note' => 'Kategori sampah botol kaca'
            ]
        ]);
    }
}
