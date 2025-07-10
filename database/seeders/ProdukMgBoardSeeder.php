<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produk;
use App\Models\ProdukGambar;
use App\Models\VarianProduk;

class ProdukMgBoardSeeder extends Seeder
{
    public function run(): void
    {
        $produk = Produk::create([
            'nama_produk' => 'Tombo / MG Board (Lembaran)',
            'jenis_produk' => 'isolasi panas',
            'deskripsi' => "✅ Papan insulasi tahan panas dan api\n✅ Ringan namun padat, cocok untuk berbagai aplikasi industri\n✅ Tersedia berbagai densitas dan ketebalan\n✅ Ukuran praktis: 1,2 m x 0,6 m",
        ]);

        $gambarPaths = [
            'produk/mg_board_1.jpg',
            'produk/mg_board_2.jpg',
            'produk/mg_board_3.jpg',
        ];

        foreach ($gambarPaths as $path) {
            ProdukGambar::create([
                'produk_id' => $produk->id,
                'path' => $path,
            ]);
        }

        $varians = [
            ['tipe' => 'MG BOARD 040/25', 'densitas' => 40, 'ketebalan' => 25],
            ['tipe' => 'MG BOARD 060/25', 'densitas' => 60, 'ketebalan' => 25],
            ['tipe' => 'MG BOARD 80/25', 'densitas' => 80, 'ketebalan' => 25],
            ['tipe' => 'MG BOARD 100/25', 'densitas' => 100, 'ketebalan' => 25],
            ['tipe' => 'MG BOARD 040/50', 'densitas' => 40, 'ketebalan' => 50],
            ['tipe' => 'MG BOARD 060/50', 'densitas' => 60, 'ketebalan' => 50],
            ['tipe' => 'MG BOARD 80/50', 'densitas' => 80, 'ketebalan' => 50],
            ['tipe' => 'MG BOARD 100/50', 'densitas' => 100, 'ketebalan' => 50],
            ['tipe' => 'MG BOARD 120/50', 'densitas' => 120, 'ketebalan' => 50],
            ['tipe' => 'MG BOARD 140/50', 'densitas' => 140, 'ketebalan' => 50],
            ['tipe' => 'MG BOARD 150/50', 'densitas' => 150, 'ketebalan' => 50],
        ];

        foreach ($varians as $v) {
            VarianProduk::create([
                'produk_id' => $produk->id,
                'tipe' => $v['tipe'],
                'ukuran' => '1,2 m x 0,6 m',
                'ketebalan' => $v['ketebalan'],
                'densitas' => $v['densitas'],
                'harga' => rand(75000, 350000),
                'stok' => rand(10, 100),
            ]);
        }
    }
}
