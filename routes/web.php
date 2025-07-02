<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/produk', function () {
    return view('produk');
});

Route::get('/katalog-produk', function () {
    return view('katalog_produk');
});

Route::get('/galeri', function () {
    return view('galeri');
});

Route::get('/hubungi-kami', function () {
    return view('hubungi_kami');
});
