<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;

class PaymentCategorySeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('payment_categories')->insert([
            [
                'pym_name' => 'Retribusi Air',
                'pym_total' => 15000,
            ],
            [
                'pym_name' => 'Retribusi Sampah',
                'pym_total' => 20000,
            ]
        ]);
    }
}
