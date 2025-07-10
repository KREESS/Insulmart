<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produk;
use App\Models\ProdukGambar;
use App\Models\VarianProduk;

class ProdukRockwoolWiredBlanketSeeder extends Seeder
{
    public function run(): void
    {
        $produk = Produk::create([
            'nama_produk' => 'Rockwool Wired Blanket (Roll pakai Kawat)',
            'jenis_produk' => 'isolasi panas',
            'deskripsi' => "✅ Rockwool dilapisi kawat galvanis untuk instalasi vertikal dan horizontal\n✅ Tahan suhu tinggi, kuat & tidak mudah robek\n✅ Cocok untuk boiler, cerobong, ducting besar, dan tangki\n✅ Digunakan untuk kebutuhan industri berat",
        ]);

        $gambarPaths = [
            'produk/rockwool_wired_1.jpg',
            'produk/rockwool_wired_2.jpg',
            'produk/rockwool_wired_3.jpg',
        ];

        foreach ($gambarPaths as $path) {
            ProdukGambar::create([
                'produk_id' => $produk->id,
                'path' => $path,
            ]);
        }

        $varians = [
            ['tipe' => 'WM80/50', 'densitas' => 80, 'ketebalan' => 50, 'ukuran' => '5 m x 0,6 m'],
            ['tipe' => 'WM80/75', 'densitas' => 80, 'ketebalan' => 75, 'ukuran' => '3 m x 0,6 m'],
            ['tipe' => 'WM80/100', 'densitas' => 80, 'ketebalan' => 100, 'ukuran' => '3 m x 0,6 m'],
            ['tipe' => 'WM100/50', 'densitas' => 100, 'ketebalan' => 50, 'ukuran' => '5 m x 0,6 m'],
            ['tipe' => 'WM100/75', 'densitas' => 100, 'ketebalan' => 75, 'ukuran' => '3 m x 0,6 m'],
            ['tipe' => 'WM100/100', 'densitas' => 100, 'ketebalan' => 100, 'ukuran' => '3 m x 0,6 m'],
        ];

        foreach ($varians as $v) {
            VarianProduk::create([
                'produk_id' => $produk->id,
                'tipe' => 'Rockwool Wired Blanket ' . $v['tipe'],
                'ukuran' => $v['ukuran'],
                'ketebalan' => $v['ketebalan'],
                'densitas' => $v['densitas'],
                'harga' => rand(100000, 350000),
                'stok' => rand(10, 100),
            ]);
        }
    }
}
