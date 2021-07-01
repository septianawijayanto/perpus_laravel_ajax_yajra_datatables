<?php

namespace Database\Seeders;

use App\Models\Model\Anggota;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class AnggotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        foreach (range(1, 15) as $value) {
            Anggota::insert([
                'username' => $faker->name,
                'nama' => $faker->name,
                'password' => \bcrypt('123'),
                'alamat' => $faker->secondaryAddress,
                'level' => $faker->randomElement(['siswa', 'guru']),
                'agama' => $faker->randomElement(['Islam', 'Protestan', 'Katolik', 'Hindu', 'Budha']),
                'tgl_lahir' => $faker->date($format = 'Y-m-d', $max = 'now'),
            ]);
        }
        // $anggota = Anggota::factory()->count(3)->make();
    }
}
