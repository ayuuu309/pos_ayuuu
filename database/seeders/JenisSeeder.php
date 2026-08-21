<?php

namespace Database\Seeders;

use App\Models\Jenis; // Sesuaikan dengan nama Model Jenis kamu
use Illuminate\Database\Seeder;

class JenisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Contoh memasukkan data jenis / kategori
        Jenis::create(['nama' => 'Makanan']);
        Jenis::create(['nama' => 'Minuman']);
        Jenis::create(['nama' => 'Sembako']);
    }
}