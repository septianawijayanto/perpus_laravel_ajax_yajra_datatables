<?php

namespace Database\Seeders;

use App\Models\Model\Admin;
use App\Models\Model\Anggota;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AnggotaSeeder::class);
        // Admin::create([
        //     'nama' => 'Admin',
        //     'username' => 'admin',
        //     'password' => \bcrypt('admin')
        // ]);
        Anggota::create([
            'nama' => 'Anggota',
            'username' => 'anggota',
            'password' => \bcrypt('anggota'),
            'level' => 'siswa',
            'tgl_lahir' => today(),
            'alamat' => 'jambi',
            'agama' => 'islam',

        ]);
    }
}
