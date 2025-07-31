<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArmadaPengirimanSeeder extends Seeder
{
    public function run()
    {
        DB::table('armada_pengiriman')->insert([
            [
                'nama' => 'Pickup',
                'kapasitas_pack' => 20,
                'tarif_per_km' => 7500,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Engkel',
                'kapasitas_pack' => 50,
                'tarif_per_km' => 10000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Cold Diesel',
                'kapasitas_pack' => 60,
                'tarif_per_km' => 12500,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Cold Diesel Long',
                'kapasitas_pack' => 100,
                'tarif_per_km' => 15000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Fuso 6 M',
                'kapasitas_pack' => 160,
                'tarif_per_km' => 17500,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
