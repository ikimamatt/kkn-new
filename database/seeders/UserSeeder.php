<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\FamilyCard;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Ambil semua kartu keluarga yang ada
        $familyCards = FamilyCard::all();

        // Inisialisasi Faker untuk menghasilkan data acak
        $faker = Faker::create();

        // Menambahkan SuperAdmin dan Administrator
        $superAdminFamilyCard = FamilyCard::create([
            'kk_number' => '0000000000000000', // Nomor KK untuk SuperAdmin
            'house_id' => 1, // Ganti sesuai ID rumah yang relevan
        ]);

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
            'family_card_id' => $superAdminFamilyCard->id, // Mengaitkan dengan FamilyCard
        ]);

        $adminFamilyCard = FamilyCard::create([
            'kk_number' => '0000000000000001', // Nomor KK untuk Administrator
            'house_id' => 2, // Ganti sesuai ID rumah yang relevan
        ]);

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
            'family_card_id' => $adminFamilyCard->id, // Mengaitkan dengan FamilyCard
        ]);

        // Untuk setiap FamilyCard, buat 3 User lainnya
        // foreach ($familyCards as $familyCard) {
        //     // Membuat 3 user untuk setiap FamilyCard
        //     for ($i = 0; $i < 3; $i++) {
        //         User::create([
        //             'name' => $faker->name,
        //             'email' => $faker->unique()->safeEmail,
        //             'password' => Hash::make('password123'),
        //             'role' => 'warga', // Menetapkan role untuk warga
        //             'nik' => $faker->unique()->numerify('##########'),
        //             'tanggal_lahir' => $faker->date,
        //             'jenis_kelamin' => $faker->randomElement(['L', 'P']),
        //             'tempat_lahir' => $faker->city,
        //             'jenis_pekerjaan' => $faker->word,
        //             'golongan_darah' => $faker->randomElement(['A', 'B', 'AB', 'O']),
        //             'status_perkawinan' => $faker->randomElement(['belum_kawin', 'kawin', 'cerai']),
        //             'status_hubungan_keluarga' => $faker->randomElement(['kepala_keluarga', 'istri', 'anak']),
        //             'family_card_id' => $familyCard->id, // Mengaitkan User dengan FamilyCard
        //         ]);
        //     }
        // }
    }
}
