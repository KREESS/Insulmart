<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produk;
use App\Models\ProdukGambar;
use App\Models\VarianProduk;

class ProdukRockwoolBoardSeeder extends Seeder
{
    public function run(): void
    {
        $produk = Produk::create([
            'nama_produk' => 'Rockwool Board/Slab (Lembaran)',
            'jenis_produk' => 'isolasi panas',
            'deskripsi' => "✅ Isolasi tahan panas hingga 750°C\n✅ Ideal untuk dinding, oven, boiler, panel, dan lainnya\n✅ Tersedia berbagai varian densitas dan ketebalan\n✅ Efektif sebagai peredam panas dan suara",
        ]);

        $gambarPaths = [
            'produk/rockwool_board_1.jpg',
            'produk/rockwool_board_2.jpg',
            'produk/rockwool_board_3.jpg',
        ];

        foreach ($gambarPaths as $path) {
            ProdukGambar::create([
                'produk_id' => $produk->id,
                'path' => $path,
            ]);
        }

        $varians = [
            ['tipe' => 'S40/25', 'densitas' => 40, 'ketebalan' => 25],
            ['tipe' => 'S60/25', 'densitas' => 60, 'ketebalan' => 25],
            ['tipe' => 'S80/25', 'densitas' => 80, 'ketebalan' => 25],
            ['tipe' => 'S100/25', 'densitas' => 100, 'ketebalan' => 25],
            ['tipe' => 'S120/25', 'densitas' => 120, 'ketebalan' => 25],
            ['tipe' => 'S40/50', 'densitas' => 40, 'ketebalan' => 50],
            ['tipe' => 'S60/50', 'densitas' => 60, 'ketebalan' => 50],
            ['tipe' => 'S80/50', 'densitas' => 80, 'ketebalan' => 50],
            ['tipe' => 'S100/50', 'densitas' => 100, 'ketebalan' => 50],
            ['tipe' => 'S120/50', 'densitas' => 120, 'ketebalan' => 50],
            ['tipe' => 'S140/50', 'densitas' => 140, 'ketebalan' => 50],
        ];

        foreach ($varians as $v) {
            VarianProduk::create([
                'produk_id' => $produk->id,
                'tipe' => 'Rockwool Tipe ' . $v['tipe'],
                'ukuran' => '1,2 m x 0,6 m',
                'ketebalan' => $v['ketebalan'],
                'densitas' => $v['densitas'],
                'harga' => rand(75000, 300000),
                'stok' => rand(10, 100),
            ]);
        }
    }
}
