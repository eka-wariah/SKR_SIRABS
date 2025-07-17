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
            'nik' => '3271020101010001',
        'usr_scope_id' => 1,
            'password' => bcrypt(123456789)
        ]);
        $rw_leader->assignRole('rw_leader');

        $rt_leader = User::create([
            'name' => 'rt_leader',
            'email' => 'rtleader@gmail.com',
            'nik' => '3271020101010005',
        'usr_scope_id' => 1,
            'password' => bcrypt(123456789)
        ]);
        $rt_leader->assignRole('rt_leader');

        $treasurer = User::create([
            'name' => 'treasurer',
            'email' => 'treasurer@gmail.com',
            'nik' => '3271020101010002',
           'usr_scope_id' => 1,
            'password' => bcrypt(123456789)
        ]);
        $treasurer->assignRole('treasurer');

        $wastebank_officer = User::create([
            'name' => 'wastebank_officer',
            'email' => 'officer@gmail.com',
            'nik' => '3271020101010003',
           'usr_scope_id' => 1,
            'password' => bcrypt(123456789)
        ]);
        $wastebank_officer->assignRole('wastebank_officer');

        $citizen = User::create([
            'name' => 'citizen',
            'email' => 'citizen@gmail.com',
            'nik' => '3271020101010004',
           'usr_scope_id' => 1,
            'password' => bcrypt(123456789)
        ]);
        $citizen->assignRole('citizen');

        $lay = User::create([
            'name' => 'Lay Zhang',
            'email' => 'layzhang@gmail.com',
            'nik' => '3271020101010010',
            'household_id' => 1,
            'usr_scope_id' => 1,
            'password' => bcrypt('123456789')
        ]);
        $lay->assignRole('citizen');

        $eka = User::create([
            'name' => 'Eka Wariah',
            'email' => 'ekawariah@gmail.com',
            'nik' => '3271020101010011',
            'household_id' => 1,
            'usr_scope_id' => 1,
            'password' => bcrypt('123456789')
        ]);
        $eka->assignRole('citizen');

        $chengyi = User::create([
            'name' => 'Chengyi',
            'email' => 'chengyi@gmail.com',
            'nik' => '3271020101010012',
            'household_id' => 2,
            'usr_scope_id' => 1,
            'password' => bcrypt('123456789')
        ]);
        $chengyi->assignRole('citizen');

        $xiao = User::create([
            'name' => 'kaa',
            'email' => 'hkaa87@gmail.com',
            'nik' => '3271020101010013',
            'household_id' => 2,
            'usr_scope_id' => 1,
            'password' => bcrypt('123456789')
        ]);
        $xiao->assignRole('citizen');

    }
}
