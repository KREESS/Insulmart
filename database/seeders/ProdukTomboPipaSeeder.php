<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produk;
use App\Models\ProdukGambar;
use App\Models\VarianProduk;

class ProdukTomboPipaSeeder extends Seeder
{
    public function run(): void
    {
        $produk = Produk::create([
            'nama_produk' => 'Tombo Pipa / MG Mighty Cover',
            'jenis_produk' => 'isolasi panas',
            'deskripsi' => "✅ Isolasi berbentuk silinder untuk pipa\n✅ Sangat ideal untuk sistem HVAC, plumbing, dan instalasi pipa panas/dingin\n✅ Ringan, mudah dipasang, dan tahan panas tinggi\n✅ Densitas tersedia antara 90 - 150 kg/m³\n✅ Ukuran panjang standar: 1000 mm\n✅ Tersedia berbagai ketebalan: 25 - 100 mm",
        ]);

        $gambarPaths = [
            'produk/mg_pipa_1.jpg',
            'produk/mg_pipa_2.jpg',
            'produk/mg_pipa_3.jpg',
        ];

        foreach ($gambarPaths as $path) {
            ProdukGambar::create([
                'produk_id' => $produk->id,
                'path' => $path,
            ]);
        }

        $ketebalanList = [25, 30, 40, 50, 65, 75, 100];
        $densitasList = [90, 100, 120, 135, 150];

        foreach ($ketebalanList as $ketebalan) {
            foreach ($densitasList as $densitas) {
                VarianProduk::create([
                    'produk_id' => $produk->id,
                    'tipe' => "Tombo Pipa {$ketebalan}mm - {$densitas}kg/m³",
                    'ukuran' => '1000 mm',
                    'ketebalan' => $ketebalan,
                    'densitas' => $densitas,
                    'harga' => rand(60000, 300000),
                    'stok' => rand(10, 100),
                ]);
            }
        }
    }
}
