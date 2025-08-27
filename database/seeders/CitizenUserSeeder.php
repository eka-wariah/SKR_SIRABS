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

            // ---------- RT 1 (usr_scope_id = 1, 10 warga, 4 KK) ----------
            ['name' => 'Lay Zhang', 'email' => 'layzhang@example.com', 'nik' => '3201010101010001', 'household_id' => 1, 'gender' => 'Laki-laki', 'usr_scope_id' => 1, 'phone' => '081200000001', 'address' => 'Jl. Sakura 1', 'village' => 'Desa A', 'subdistrict' => 'Kec. A', 'regency' => 'Kab. Bandung', 'birth_date' => '1991-10-07'],
            ['name' => 'Eka Wariah', 'email' => 'eka1@example.com', 'nik' => '3201010101010002', 'household_id' => 1, 'gender' => 'Perempuan', 'usr_scope_id' => 1, 'phone' => '081200000002', 'address' => 'Jl. Sakura 2', 'village' => 'Desa A', 'subdistrict' => 'Kec. A', 'regency' => 'Kab. Bandung', 'birth_date' => '1992-11-05'],
            ['name' => 'Minho', 'email' => 'minho@example.com', 'nik' => '3201010101010003', 'household_id' => 2, 'gender' => 'Laki-laki', 'usr_scope_id' => 1, 'phone' => '081200000003', 'address' => 'Jl. Sakura 3', 'village' => 'Desa A', 'subdistrict' => 'Kec. A', 'regency' => 'Kab. Bandung', 'birth_date' => '1993-07-10'],
            ['name' => 'Wendy', 'email' => 'wendy@example.com', 'nik' => '3201010101010004', 'household_id' => 2, 'gender' => 'Perempuan', 'usr_scope_id' => 1, 'phone' => '081200000004', 'address' => 'Jl. Sakura 4', 'village' => 'Desa A', 'subdistrict' => 'Kec. A', 'regency' => 'Kab. Bandung', 'birth_date' => '1994-01-12'],
            ['name' => 'Kai', 'email' => 'kai@example.com', 'nik' => '3201010101010005', 'household_id' => 3, 'gender' => 'Laki-laki', 'usr_scope_id' => 1, 'phone' => '081200000005', 'address' => 'Jl. Sakura 5', 'village' => 'Desa A', 'subdistrict' => 'Kec. A', 'regency' => 'Kab. Bandung', 'birth_date' => '1993-01-14'],
            ['name' => 'Joy', 'email' => 'joy@example.com', 'nik' => '3201010101010006', 'household_id' => 3, 'gender' => 'Perempuan', 'usr_scope_id' => 1, 'phone' => '081200000006', 'address' => 'Jl. Sakura 6', 'village' => 'Desa A', 'subdistrict' => 'Kec. A', 'regency' => 'Kab. Bandung', 'birth_date' => '1994-09-03'],
            ['name' => 'Mark', 'email' => 'mark@example.com', 'nik' => '3201010101010007', 'household_id' => 4, 'gender' => 'Laki-laki', 'usr_scope_id' => 1, 'phone' => '081200000007', 'address' => 'Jl. Sakura 7', 'village' => 'Desa A', 'subdistrict' => 'Kec. A', 'regency' => 'Kab. Bandung', 'birth_date' => '1999-08-02'],
            ['name' => 'Seulgi', 'email' => 'seulgi@example.com', 'nik' => '3201010101010008', 'household_id' => 4, 'gender' => 'Perempuan', 'usr_scope_id' => 1, 'phone' => '081200000008', 'address' => 'Jl. Sakura 8', 'village' => 'Desa A', 'subdistrict' => 'Kec. A', 'regency' => 'Kab. Bandung', 'birth_date' => '1994-02-10'],
            ['name' => 'Doyoung', 'email' => 'doyoung@example.com', 'nik' => '3201010101010009', 'household_id' => 4, 'gender' => 'Laki-laki', 'usr_scope_id' => 1, 'phone' => '081200000009', 'address' => 'Jl. Sakura 9', 'village' => 'Desa A', 'subdistrict' => 'Kec. A', 'regency' => 'Kab. Bandung', 'birth_date' => '1996-02-01'],
            ['name' => 'Yeri', 'email' => 'yeri@example.com', 'nik' => '3201010101010010', 'household_id' => 4, 'gender' => 'Perempuan', 'usr_scope_id' => 1, 'phone' => '081200000010', 'address' => 'Jl. Sakura 10', 'village' => 'Desa A', 'subdistrict' => 'Kec. A', 'regency' => 'Kab. Bandung', 'birth_date' => '1999-03-05'],

            // ---------- RT 2 (8 warga, 3 KK) ----------
            ['name' => 'Baekhyun', 'email' => 'baekhyun@example.com', 'nik' => '3201020202020011', 'household_id' => 5, 'gender' => 'Laki-laki', 'usr_scope_id' => 2, 'phone' => '081200000011', 'address' => 'Jl. Kenanga 1', 'village' => 'Desa B', 'subdistrict' => 'Kec. B', 'regency' => 'Kab. Bandung', 'birth_date' => '1992-05-06'],
            ['name' => 'Irene', 'email' => 'irene@example.com', 'nik' => '3201020202020012', 'household_id' => 5, 'gender' => 'Perempuan', 'usr_scope_id' => 2, 'phone' => '081200000012', 'address' => 'Jl. Kenanga 2', 'village' => 'Desa B', 'subdistrict' => 'Kec. B', 'regency' => 'Kab. Bandung', 'birth_date' => '1991-03-29'],
            ['name' => 'Jisoo', 'email' => 'jisoo@example.com', 'nik' => '3201020202020013', 'household_id' => 6, 'gender' => 'Perempuan', 'usr_scope_id' => 2, 'phone' => '081200000013', 'address' => 'Jl. Kenanga 3', 'village' => 'Desa B', 'subdistrict' => 'Kec. B', 'regency' => 'Kab. Bandung', 'birth_date' => '1995-01-03'],
            ['name' => 'Jennie', 'email' => 'jennie@example.com', 'nik' => '3201020202020014', 'household_id' => 6, 'gender' => 'Perempuan', 'usr_scope_id' => 2, 'phone' => '081200000014', 'address' => 'Jl. Kenanga 4', 'village' => 'Desa B', 'subdistrict' => 'Kec. B', 'regency' => 'Kab. Bandung', 'birth_date' => '1996-01-16'],
            ['name' => 'Rose', 'email' => 'rose@example.com', 'nik' => '3201020202020015', 'household_id' => 7, 'gender' => 'Perempuan', 'usr_scope_id' => 2, 'phone' => '081200000015', 'address' => 'Jl. Kenanga 5', 'village' => 'Desa B', 'subdistrict' => 'Kec. B', 'regency' => 'Kab. Bandung', 'birth_date' => '1997-02-11'],
            ['name' => 'Lisa', 'email' => 'lisa@example.com', 'nik' => '3201020202020016', 'household_id' => 7, 'gender' => 'Perempuan', 'usr_scope_id' => 2, 'phone' => '081200000016', 'address' => 'Jl. Kenanga 6', 'village' => 'Desa B', 'subdistrict' => 'Kec. B', 'regency' => 'Kab. Bandung', 'birth_date' => '1997-03-27'],
            ['name' => 'Jungkook', 'email' => 'jungkook@example.com', 'nik' => '3201020202020017', 'household_id' => 7, 'gender' => 'Laki-laki', 'usr_scope_id' => 2, 'phone' => '081200000017', 'address' => 'Jl. Kenanga 7', 'village' => 'Desa B', 'subdistrict' => 'Kec. B', 'regency' => 'Kab. Bandung', 'birth_date' => '1997-09-01'],
            ['name' => 'RM', 'email' => 'rm@example.com', 'nik' => '3201020202020018', 'household_id' => 7, 'gender' => 'Laki-laki', 'usr_scope_id' => 2, 'phone' => '081200000018', 'address' => 'Jl. Kenanga 8', 'village' => 'Desa B', 'subdistrict' => 'Kec. B', 'regency' => 'Kab. Bandung', 'birth_date' => '1994-09-12'],

            // ---------- lanjut RT 3 & RT 4 (lanjut di balasan berikutnya) ----------
            // ---------- RT 3 (usr_scope_id = 3, 6 warga, 2 KK) ----------
            ['name' => 'Taeyeon', 'email' => 'taeyeon@example.com', 'nik' => '3201030303030019', 'household_id' => 8, 'gender' => 'Perempuan', 'usr_scope_id' => 3, 'phone' => '081200000019', 'address' => 'Jl. Melati 1', 'village' => 'Desa C', 'subdistrict' => 'Kec. C', 'regency' => 'Kab. Bandung', 'birth_date' => '1989-03-09'],
            ['name' => 'Baekho', 'email' => 'baekho@example.com', 'nik' => '3201030303030020', 'household_id' => 8, 'gender' => 'Laki-laki', 'usr_scope_id' => 3, 'phone' => '081200000020', 'address' => 'Jl. Melati 2', 'village' => 'Desa C', 'subdistrict' => 'Kec. C', 'regency' => 'Kab. Bandung', 'birth_date' => '1995-07-21'],
            ['name' => 'Sana', 'email' => 'sana@example.com', 'nik' => '3201030303030021', 'household_id' => 8, 'gender' => 'Perempuan', 'usr_scope_id' => 3, 'phone' => '081200000021', 'address' => 'Jl. Melati 3', 'village' => 'Desa C', 'subdistrict' => 'Kec. C', 'regency' => 'Kab. Bandung', 'birth_date' => '1996-12-29'],
            ['name' => 'Tzuyu', 'email' => 'tzuyu@example.com', 'nik' => '3201030303030022', 'household_id' => 9, 'gender' => 'Perempuan', 'usr_scope_id' => 3, 'phone' => '081200000022', 'address' => 'Jl. Melati 4', 'village' => 'Desa C', 'subdistrict' => 'Kec. C', 'regency' => 'Kab. Bandung', 'birth_date' => '1999-06-14'],
            ['name' => 'Jeno', 'email' => 'jeno@example.com', 'nik' => '3201030303030023', 'household_id' => 9, 'gender' => 'Laki-laki', 'usr_scope_id' => 3, 'phone' => '081200000023', 'address' => 'Jl. Melati 5', 'village' => 'Desa C', 'subdistrict' => 'Kec. C', 'regency' => 'Kab. Bandung', 'birth_date' => '2000-04-23'],
            ['name' => 'Karina', 'email' => 'karina@example.com', 'nik' => '3201030303030024', 'household_id' => 9, 'gender' => 'Perempuan', 'usr_scope_id' => 3, 'phone' => '081200000024', 'address' => 'Jl. Melati 6', 'village' => 'Desa C', 'subdistrict' => 'Kec. C', 'regency' => 'Kab. Bandung', 'birth_date' => '2000-04-11'],
            
            // ---------- RT 4 (usr_scope_id = 4, 5 warga, 2 KK) ----------
            ['name' => 'Winter', 'email' => 'winter@example.com', 'nik' => '3201040404040025', 'household_id' => 10, 'gender' => 'Perempuan', 'usr_scope_id' => 4, 'phone' => '081200000025', 'address' => 'Jl. Anggrek 1', 'village' => 'Desa D', 'subdistrict' => 'Kec. D', 'regency' => 'Kab. Bandung', 'birth_date' => '2001-01-01'],
            ['name' => 'Giselle', 'email' => 'giselle@example.com', 'nik' => '3201040404040026', 'household_id' => 10, 'gender' => 'Perempuan', 'usr_scope_id' => 4, 'phone' => '081200000026', 'address' => 'Jl. Anggrek 2', 'village' => 'Desa D', 'subdistrict' => 'Kec. D', 'regency' => 'Kab. Bandung', 'birth_date' => '2000-10-30'],
            ['name' => 'Ningning', 'email' => 'ningning@example.com', 'nik' => '3201040404040027', 'household_id' => 11, 'gender' => 'Perempuan', 'usr_scope_id' => 4, 'phone' => '081200000027', 'address' => 'Jl. Anggrek 3', 'village' => 'Desa D', 'subdistrict' => 'Kec. D', 'regency' => 'Kab. Bandung', 'birth_date' => '2002-10-23'],
            ['name' => 'Jaemin', 'email' => 'jaemin@example.com', 'nik' => '3201040404040028', 'household_id' => 11, 'gender' => 'Laki-laki', 'usr_scope_id' => 4, 'phone' => '081200000028', 'address' => 'Jl. Anggrek 4', 'village' => 'Desa D', 'subdistrict' => 'Kec. D', 'regency' => 'Kab. Bandung', 'birth_date' => '2000-08-13'],
            ['name' => 'Haechan', 'email' => 'haechan@example.com', 'nik' => '3201040404040029', 'household_id' => 11, 'gender' => 'Laki-laki', 'usr_scope_id' => 4, 'phone' => '081200000029', 'address' => 'Jl. Anggrek 5', 'village' => 'Desa D', 'subdistrict' => 'Kec. D', 'regency' => 'Kab. Bandung', 'birth_date' => '2000-06-06'],
            
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
