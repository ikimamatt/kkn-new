<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\House;
use App\Models\User;
use App\Models\FamilyCard;

class FamilyCardUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Ambil semua rumah dari blok F1 hingga F4
        $houses = House::whereIn('block_id', [1, 2, 3, 4, 5, 6])->get();

        // Loop untuk setiap rumah
        foreach ($houses as $house) {
            // Buat 1 Kartu Keluarga untuk setiap rumah
            $familyCard = FamilyCard::create([
                'house_id' => $house->id,  // Menyambungkan kartu keluarga dengan rumah
                'kk_number' => $this->generateKKNumber(), // Nomor Kartu Keluarga
            ]);

            // Menambahkan 4 anggota keluarga pada setiap kartu keluarga
            $this->createUsersForFamilyCard($familyCard);
        }
    }

    /**
     * Fungsi untuk menghasilkan nomor Kartu Keluarga (16 digit)
     *
     * @return string
     */
    private function generateKKNumber()
    {
        return str_pad(rand(0, 9999999999999999), 16, '0', STR_PAD_LEFT);
    }

    /**
     * Fungsi untuk membuat 4 user untuk setiap Kartu Keluarga
     *
     * @param FamilyCard $familyCard
     * @return void
     */
    private function createUsersForFamilyCard(FamilyCard $familyCard)
    {
        // Data anggota keluarga yang akan ditambahkan
        $usersData = [
            [
                'name' => 'Kepala Keluarga',
                'email' => 'kepala_' . $familyCard->kk_number . '@example.com',
                'password' => bcrypt('password'),
                'nik' => $this->generateKKNumber(),
                'tanggal_lahir' => '1980-01-01',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Jakarta',
                'jenis_pekerjaan' => 'PNS',
                'golongan_darah' => 'O',
                'status_perkawinan' => 'kawin',
                'status_hubungan_keluarga' => 'kepala_keluarga',
            ],
            [
                'name' => 'Istri',
                'email' => 'istri_' . $familyCard->kk_number . '@example.com',
                'password' => bcrypt('password'),
                'nik' => $this->generateKKNumber(),
                'tanggal_lahir' => '1982-05-15',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'Bandung',
                'jenis_pekerjaan' => 'Rumah Tangga',
                'golongan_darah' => 'A',
                'status_perkawinan' => 'kawin',
                'status_hubungan_keluarga' => 'istri',
            ],
            [
                'name' => 'Anak 1',
                'email' => 'anak1_' . $familyCard->kk_number . '@example.com',
                'password' => bcrypt('password'),
                'nik' => $this->generateKKNumber(),
                'tanggal_lahir' => '2005-03-25',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Surabaya',
                'jenis_pekerjaan' => 'Pelajar',
                'golongan_darah' => 'B',
                'status_perkawinan' => 'belum_kawin',
                'status_hubungan_keluarga' => 'anak',
            ],
            [
                'name' => 'Anak 2',
                'email' => 'anak2_' . $familyCard->kk_number . '@example.com',
                'password' => bcrypt('password'),
                'nik' => $this->generateKKNumber(),
                'tanggal_lahir' => '2008-07-10',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'Medan',
                'jenis_pekerjaan' => 'Pelajar',
                'golongan_darah' => 'AB',
                'status_perkawinan' => 'belum_kawin',
                'status_hubungan_keluarga' => 'anak',
            ],
        ];

        // Buat 4 user dan hubungkan ke FamilyCard
        foreach ($usersData as $userData) {
            $user = User::create($userData);
            // Menghubungkan user dengan kartu keluarga
            $familyCard->users()->attach($user->id);
        }
    }
}
