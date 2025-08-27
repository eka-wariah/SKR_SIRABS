<?php

namespace Database\Seeders;

use App\Models\households;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HouseholdRepresentativeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        households::chunk(50, function ($households) {
            foreach ($households as $household) {
                // Ambil anggota pertama berdasarkan created_at
                $firstMember = User::where('household_id', $household->id)
                    ->orderBy('created_at', 'asc')
                    ->first();

                if ($firstMember) {
                    $household->update([
                        'representative_user_id' => $firstMember->usr_id
                    ]);
                }
            }
        });
    }
}
