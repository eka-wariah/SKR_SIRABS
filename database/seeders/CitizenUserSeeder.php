<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class CitizenUserSeeder extends Seeder
{
    public function run(): void
    {
        $citizenRole = Role::firstOrCreate(['name' => 'citizen']);

        $users = [
            [
                'name' => 'Lay Zhang',
                'email' => 'layzhang@example.com',
                'nik' => '3201010101011111',
                'household_id' => 1,
                'gender' => 'Laki-laki',
                'usr_scope_id' => 1,
                'phone' => '081200000001',
                'address' => 'Jl. Sakura 1',
                'village' => 'Desa Sukamaju',
                'subdistrict' => 'Kec. Cibiru',
                'regency' => 'Kab. Bandung',
                'birth_date' => '1991-10-07',
            ],
            [
                'name' => 'Eka Wariah',
                'email' => 'ekawrh11@example.com',
                'nik' => '3201010101012222',
                'household_id' => 1,
                'gender' => 'Perempuan',
                'usr_scope_id' => 1,
                'phone' => '081200000002',
                'address' => 'Jl. Sakura 2',
                'village' => 'Desa Sukamaju',
                'subdistrict' => 'Kec. Cibiru',
                'regency' => 'Kab. Bandung',
                'birth_date' => '1992-11-05',
            ],
            [
                'name' => 'Chengyi',
                'email' => 'chengyi@example.com',
                'nik' => '3201010101013333',
                'household_id' => 2,
                'gender' => 'Laki-laki',
                'usr_scope_id' => 2,
                'phone' => '081200000003',
                'address' => 'Jl. Kenanga 1',
                'village' => 'Desa Mekarwangi',
                'subdistrict' => 'Kec. Majalaya',
                'regency' => 'Kab. Bandung',
                'birth_date' => '1995-02-15',
            ],
            [
                'name' => 'Xiao Zhan',
                'email' => 'xiaozhan@example.com',
                'nik' => '3201010101014444',
                'household_id' => 2,
                'gender' => 'Laki-laki',
                'usr_scope_id' => 2,
                'phone' => '081200000004',
                'address' => 'Jl. Kenanga 2',
                'village' => 'Desa Mekarwangi',
                'subdistrict' => 'Kec. Majalaya',
                'regency' => 'Kab. Bandung',
                'birth_date' => '1991-10-05',
            ],
        ];

        foreach ($users as $data) {
            $user = User::create(array_merge($data, [
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]));

            $user->assignRole($citizenRole);
        }
    }
}
