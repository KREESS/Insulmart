<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produk;
use App\Models\ProdukGambar;
use App\Models\VarianProduk;

class ProdukFirerockSeeder extends Seeder
{
    public function run(): void
    {
        // Tambah produk utama
        $produk = Produk::create([
            'nama_produk' => 'Firerock Board/Slab (Lembaran)',
            'jenis_produk' => 'isolasi panas',
            'deskripsi' => "🔥 Solusi Aman & Efisien untuk Perlindungan Suhu Tinggi!

✅ Tahan suhu ekstrem hingga 1000°C  
✅ Kepadatan tinggi, kokoh, dan tidak mudah rusak  
✅ Efektif sebagai peredam panas & suara  
✅ Ramah lingkungan, bebas asbes & non-toksik  
✅ Ideal untuk dinding tahan api, oven, cerobong, genset & banyak lagi!

🧾 Spesifikasi Produk  
📐 Ukuran: 1200 x 600 mm  
📏 Ketebalan: 25 / 50 / 100 mm  
🪨 Material: Rockwool  
🔥 Tahan Suhu: Hingga 1000°C  
⚖️ Kepadatan: 80–150 kg/m³

📦 Ready stock! Bisa kirim ke seluruh Indonesia 🚚",
        ]);

        // Tambah 3 gambar produk
        $gambarPaths = [
            'produk/firerock_1.jpg',
            'produk/firerock_2.jpg',
            'produk/firerock_3.jpg',
        ];

        foreach ($gambarPaths as $path) {
            ProdukGambar::create([
                'produk_id' => $produk->id,
                'path' => $path,
            ]);
        }

        // Tambah variannya
        $varians = [
            ['tipe' => 'S60/25', 'densitas' => 60, 'ketebalan' => 25],
            ['tipe' => 'S80/25', 'densitas' => 80, 'ketebalan' => 25],
            ['tipe' => 'S100/25', 'densitas' => 100, 'ketebalan' => 25],
            ['tipe' => 'S40/50', 'densitas' => 40, 'ketebalan' => 50],
            ['tipe' => 'S60/50', 'densitas' => 60, 'ketebalan' => 50],
            ['tipe' => 'S80/50', 'densitas' => 80, 'ketebalan' => 50],
            ['tipe' => 'S100/50', 'densitas' => 100, 'ketebalan' => 50],
            ['tipe' => 'S120/50', 'densitas' => 120, 'ketebalan' => 50],
            ['tipe' => 'S120/75', 'densitas' => 120, 'ketebalan' => 75],
            ['tipe' => 'S100/100', 'densitas' => 100, 'ketebalan' => 100],
        ];

        foreach ($varians as $varian) {
            VarianProduk::create([
                'produk_id' => $produk->id,
                'tipe' => 'Firerock Tipe ' . $varian['tipe'],
                'ukuran' => '1,2 m x 0,6 m',
                'ketebalan' => $varian['ketebalan'],
                'densitas' => $varian['densitas'],
                'harga' => rand(75000, 300000), // harga acak
                'stok' => rand(10, 100), // stok acak
            ]);
        }
    }
}
