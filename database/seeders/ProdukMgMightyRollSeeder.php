<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produk;
use App\Models\ProdukGambar;
use App\Models\VarianProduk;

class ProdukMgMightyRollSeeder extends Seeder
{
    public function run(): void
    {
        $produk = Produk::create([
            'nama_produk' => 'Tombo MG Mighty Roll',
            'jenis_produk' => 'isolasi panas',
            'deskripsi' => "✅ Isolasi MG Roll fleksibel dan ringan\n✅ Cocok untuk area luas seperti dinding, ducting, plafon\n✅ Tahan panas hingga suhu tinggi\n✅ Tersedia dalam berbagai ketebalan dan densitas\n✅ Ideal untuk aplikasi bangunan dan industri",
        ]);

        $gambarPaths = [
            'produk/mg_mighty_1.jpg',
            'produk/mg_mighty_2.jpg',
            'produk/mg_mighty_3.jpg',
        ];

        foreach ($gambarPaths as $path) {
            ProdukGambar::create([
                'produk_id' => $produk->id,
                'path' => $path,
            ]);
        }

        $varians = [
            ['tipe' => 'MG MIGHTY ROLL 40/50', 'densitas' => 40, 'ketebalan' => 50, 'ukuran' => '4 m x 0,6 m'],
            ['tipe' => 'MG MIGHTY ROLL 60/50', 'densitas' => 60, 'ketebalan' => 50, 'ukuran' => '4 m x 0,6 m'],
            ['tipe' => 'MG MIGHTY ROLL 80/50', 'densitas' => 80, 'ketebalan' => 50, 'ukuran' => '4 m x 0,6 m'],
            ['tipe' => 'MG MIGHTY ROLL 100/50', 'densitas' => 100, 'ketebalan' => 50, 'ukuran' => '4 m x 0,6 m'],
        ];

        foreach ($varians as $v) {
            VarianProduk::create([
                'produk_id' => $produk->id,
                'tipe' => $v['tipe'],
                'ukuran' => $v['ukuran'],
                'ketebalan' => $v['ketebalan'],
                'densitas' => $v['densitas'],
                'harga' => rand(85000, 300000),
                'stok' => rand(10, 100),
            ]);
        }
    }
}
