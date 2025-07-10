<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produk;
use App\Models\ProdukGambar;
use App\Models\VarianProduk;

class ProdukMgWiredBlanketSeeder extends Seeder
{
    public function run(): void
    {
        $produk = Produk::create([
            'nama_produk' => 'Tombo MG Wired Blanket (Roll)',
            'jenis_produk' => 'isolasi panas',
            'deskripsi' => "✅ MG Blanket dilapisi kawat galvanis, cocok untuk area luas dan kondisi ekstrem\n✅ Kuat, tahan panas tinggi, tidak mudah sobek\n✅ Cocok untuk boiler, ducting, cerobong, tangki besar dan industri\n✅ Tersedia dalam berbagai ketebalan dan ukuran",
        ]);

        $gambarPaths = [
            'produk/mg_wired_1.jpg',
            'produk/mg_wired_2.jpg',
            'produk/mg_wired_3.jpg',
        ];

        foreach ($gambarPaths as $path) {
            ProdukGambar::create([
                'produk_id' => $produk->id,
                'path' => $path,
            ]);
        }

        $varians = [
            ['tipe' => 'MG WIRED BLANKET 40/50', 'densitas' => 40, 'ketebalan' => 50, 'ukuran' => '4 m x 0,6 m'],
            ['tipe' => 'MG WIRED BLANKET 60/50', 'densitas' => 60, 'ketebalan' => 50, 'ukuran' => '4 m x 0,6 m'],
            ['tipe' => 'MG WIRED BLANKET 80/50', 'densitas' => 80, 'ketebalan' => 50, 'ukuran' => '4 m x 0,6 m'],
            ['tipe' => 'MG WIRED BLANKET 100/50', 'densitas' => 100, 'ketebalan' => 50, 'ukuran' => '4 m x 0,6 m'],
            ['tipe' => 'MG WIRED BLANKET 120/50', 'densitas' => 120, 'ketebalan' => 50, 'ukuran' => '4 m x 0,6 m'],
            ['tipe' => 'MG WIRED BLANKET 80/100', 'densitas' => 80, 'ketebalan' => 100, 'ukuran' => '3 m x 0,9 m'],
            ['tipe' => 'MG WIRED BLANKET 100/100', 'densitas' => 100, 'ketebalan' => 100, 'ukuran' => '3 m x 0,9 m'],
            ['tipe' => 'MG WIRED BLANKET 120/100', 'densitas' => 120, 'ketebalan' => 100, 'ukuran' => '3 m x 0,9 m'],
        ];

        foreach ($varians as $v) {
            VarianProduk::create([
                'produk_id' => $produk->id,
                'tipe' => $v['tipe'],
                'ukuran' => $v['ukuran'],
                'ketebalan' => $v['ketebalan'],
                'densitas' => $v['densitas'],
                'harga' => rand(100000, 400000),
                'stok' => rand(10, 100),
            ]);
        }
    }
}
