<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rw_leader = User::create([
            'name' => 'rw_leader',
            'email' => 'rwleader@gmail.com',
        'usr_scope_id' => 1,
            'password' => bcrypt(12345678)
        ]);
        $rw_leader->assignRole('rw_leader');

        $treasurer = User::create([
            'name' => 'treasurer',
            'email' => 'treasurer@gmail.com',
           'usr_scope_id' => 1,
            'password' => bcrypt(12345678)
        ]);
        $treasurer->assignRole('treasurer');

        $wastebank_officer = User::create([
            'name' => 'wastebank_officer',
            'email' => 'officer@gmail.com',
           'usr_scope_id' => 1,
            'password' => bcrypt(12345678)
        ]);
        $wastebank_officer->assignRole('wastebank_officer');

        $citizen = User::create([
            'name' => 'citizen',
            'email' => 'citizen@gmail.com',
           'usr_scope_id' => 1,
            'password' => bcrypt(12345678)
        ]);
        $citizen->assignRole('citizen');
    }
}
