<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rw_leader = User::create([
            'name' => 'Ketua_RW',
            'first_name' => 'Jodi',
            'last_name'=> 'Sanjaya',
            'phone' => '81394946264',
            'email' => 'rwleader@gmail.com',
            'nik' => '3271020101010001',
        'usr_scope_id' => 1,
            'password' => bcrypt(123456789)
        ]);
        $rw_leader->assignRole('rw_leader');


        $rt_leader = User::create([
            'name' => 'Ketua_RT',
            'first_name' => 'Sri',
            'last_name'=> 'Wahyuni',
            'email' => 'sri123@gmail.com',
            'nik' => '3271020101010005',
            'phone' => '89677854016',
        'usr_scope_id' => 1,
            'password' => bcrypt(123456789)
        ]);
        $rt_leader->assignRole('rt_leader');

        $rt_leader = User::create([
            'name' => 'Ketua_RT2',
            'first_name' => 'Diki',
            'last_name'=> '-',
            'email' => 'diki123@gmail.com',
            'nik' => '32710201010100052',
            'phone' => '89516085820',
        'usr_scope_id' => 2,
            'password' => bcrypt(123456789)
        ]);
        $rt_leader->assignRole('rt_leader');

        // $treasurer = User::create([
        //     'name' => 'treasurer',
        //     'email' => 'treasurer@gmail.com',
        //     'nik' => '3271020101010002',
        //    'usr_scope_id' => 1,
        //     'password' => bcrypt(123456789)
        // ]);
        // $rt_leader->assignRole('rt_leader');

        $treasurer = User::create([
            'name' => 'Bendahara',
            'first_name' => 'Tika',
            'last_name'=> '-',
            'email' => 'treasurer@gmail.com',
            'nik' => '3271020101010002',
           'usr_scope_id' => 1,
            'password' => bcrypt(123456789)
        ]);
        $treasurer->assignRole('treasurer');

        $treasurer = User::create([
            'name' => 'zahraa12',
            'first_name' => 'Zahra',
            'last_name'=> 'Auliya',
            'email' => 'zahra123@gmail.com',
            'nik' => '32710201010100036',
           'usr_scope_id' => 2,
            'password' => bcrypt(123456789)
        ]);
        $treasurer->assignRole('treasurer');

        $wastebank_officer = User::create([
            'name' => 'Petugas_BankSampah',
            'first_name' => 'Petugas',
            'last_name'=> 'Bank Sampah',
            'email' => 'officer@gmail.com',
            'nik' => '3271020101010003',
           'usr_scope_id' => 1,
            'password' => bcrypt(123456789)
        ]);
        $wastebank_officer->assignRole('wastebank_officer');

        $citizen = User::create([
            'name' => 'warga',
            'first_name' => 'Warga',
            'last_name'=> '-',
            'email' => 'citizen@gmail.com',
            'nik' => '3271020101010004',
           'usr_scope_id' => 1,
            'password' => bcrypt(123456789)
        ]);
        $citizen->assignRole('citizen');

        $lay = User::create([
            'name' => 'Dellaa12',
            'first_name' => 'Della',
            'last_name'=> 'Novia',
            'email' => 'della123@gmail.com',
            'nik' => '3271020101010010',
            'household_id' => 1,
            'usr_scope_id' => 1,
            'password' => bcrypt('123456789')
        ]);
        $lay->assignRole('citizen');

        $eka = User::create([
            'name' => 'Arvynn12',
            'first_name' => 'Arvin',
            'last_name'=> 'Juliansyah',
            'email' => 'vyn@gmail.com',
            'nik' => '3271020101010011',
            'household_id' => 1,
            'usr_scope_id' => 1,
            'password' => bcrypt('123456789')
        ]);
        $eka->assignRole('citizen');

        $chengyi = User::create([
            'name' => 'inggri_123',
            'first_name' => 'Inggri',
            'last_name'=> 'Anti',
            'email' => 'gamesskaa@gmail.com',
            'nik' => '3271020101010012',
            'household_id' => 2,
            'usr_scope_id' => 2,
            'password' => bcrypt('123456789')
        ]);
        $chengyi->assignRole('citizen');

        $xiao = User::create([
            'name' => 'kaaa',
            'first_name' => 'Eka',
            'last_name'=> 'Wariah',
            'email' => 'hkaa87@gmail.com',
            'nik' => '3271020101010013',
            'household_id' => 2,
            'status' => 1,
            'usr_scope_id' => 2,
            'password' => bcrypt('123456789')
        ]);
        $xiao->assignRole('citizen');

        

        // $firstNames = ['Eka', 'Budi', 'Siti', 'Ahmad', 'Nurul', 'Agus', 'Dewi', 'Rizki', 'Ani', 'Yudi', 'Rina', 'Joko', 'Lina', 'Dian', 'Fajar'];
        // $lastNames = ['Wariah', 'Saputra', 'Lestari', 'Hidayat', 'Suryani', 'Ramadhan', 'Maulana', 'Putri', 'Santoso', 'Wibowo'];

        // for ($i = 1; $i <= 20; $i++) {
        //     $first = $firstNames[array_rand($firstNames)];
        //     $last = $lastNames[array_rand($lastNames)];

        //     $user = User::create([
        //         'name' => "$first $last",
        //         'first_name' => $first,
        //         'last_name' => $last,
        //         'email' => strtolower($first . $last . $i . '@example.com'),
        //         'nik' => '32710' . str_pad($i, 9, '0', STR_PAD_LEFT),
        //         'household_id' => rand(1, 10),
        //         'usr_scope_id' => $i <= 10 ? 1 : 2,
        //         'status' => 1,
        //         'password' => Hash::make('123456789'),
        //     ]);

        //     $user->assignRole('citizen');
        // }

    }
}
