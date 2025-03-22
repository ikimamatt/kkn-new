<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // SuperAdmin
        User::create([
            'name' => 'SuperAdmin User',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password123'),
            'role' => 'superadmin',
            'nik' => '1234567890123456',
            'tanggal_lahir' => '1985-01-01',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Jakarta',
            'jenis_pekerjaan' => 'Pengusaha',
            'golongan_darah' => 'O',
            'status_perkawinan' => 'kawin',
            'tanggal_perkawinan_atau_perceraian' => '2010-06-10',
            'status_hubungan_keluarga' => 'kepala_keluarga',
        ]);

        // Administrator
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role' => 'administrator',
            'nik' => '9876543210123456',
            'tanggal_lahir' => '1990-02-02',
            'jenis_kelamin' => 'P',
            'tempat_lahir' => 'Bandung',
            'jenis_pekerjaan' => 'Pegawai Negeri',
            'golongan_darah' => 'A',
            'status_perkawinan' => 'belum_kawin',
            'tanggal_perkawinan_atau_perceraian' => null,
            'status_hubungan_keluarga' => 'anak',
        ]);

        // Warga
        User::create([
            'name' => 'Warga User',
            'email' => 'warga@example.com',
            'password' => Hash::make('password123'),
            'role' => 'warga',
            'nik' => '1234567890123457',
            'tanggal_lahir' => '1995-03-03',
            'jenis_kelamin' => 'P',
            'tempat_lahir' => 'Surabaya',
            'jenis_pekerjaan' => 'Guru',
            'golongan_darah' => 'B',
            'status_perkawinan' => 'kawin',
            'tanggal_perkawinan_atau_perceraian' => '2018-12-12',
            'status_hubungan_keluarga' => 'istri',
        ]);
    }
}
