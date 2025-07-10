<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produk;
use App\Models\ProdukGambar;
use App\Models\VarianProduk;

class ProdukRockwoolBlanketSeeder extends Seeder
{
    public function run(): void
    {
        $produk = Produk::create([
            'nama_produk' => 'Rockwool Blanket (Roll)',
            'jenis_produk' => 'isolasi panas',
            'deskripsi' => "✅ Isolasi dalam bentuk roll, fleksibel & mudah dipasang\n✅ Tahan panas hingga 750°C\n✅ Cocok untuk ducting, pipa besar, atap, dan ruang tertutup\n✅ Tersedia berbagai ketebalan & ukuran",
        ]);

        $gambarPaths = [
            'produk/rockwool_blanket_1.jpg',
            'produk/rockwool_blanket_2.jpg',
            'produk/rockwool_blanket_3.jpg',
        ];

        foreach ($gambarPaths as $path) {
            ProdukGambar::create([
                'produk_id' => $produk->id,
                'path' => $path,
            ]);
        }

        $varians = [
            ['tipe' => 'B40/50', 'densitas' => 40, 'ketebalan' => 50, 'ukuran' => '5 m x 1.2 m'],
            ['tipe' => 'B60/50', 'densitas' => 60, 'ketebalan' => 50, 'ukuran' => '5 m x 1.2 m'],
            ['tipe' => 'B80/50', 'densitas' => 80, 'ketebalan' => 50, 'ukuran' => '5 m x 1.2 m'],
            ['tipe' => 'B100/50', 'densitas' => 100, 'ketebalan' => 50, 'ukuran' => '5 m x 1.2 m'],
            ['tipe' => 'B100/25', 'densitas' => 100, 'ketebalan' => 25, 'ukuran' => '6 m x 0.6 m'],
        ];

        foreach ($varians as $v) {
            VarianProduk::create([
                'produk_id' => $produk->id,
                'tipe' => 'Rockwool Blanket Type ' . $v['tipe'],
                'ukuran' => $v['ukuran'],
                'ketebalan' => $v['ketebalan'],
                'densitas' => $v['densitas'],
                'harga' => rand(85000, 300000),
                'stok' => rand(10, 100),
            ]);
        }
    }
}
