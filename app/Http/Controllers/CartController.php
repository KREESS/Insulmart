<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\VarianProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Menampilkan keranjang belanja pengguna
    public function index()
    {
        // Ambil cart milik user yang sedang login
        $cart = Auth::user()->cart;

        return view('pelanggan.cart.index', compact('cart')); // Tampilkan halaman cart
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'varian_id' => 'required|exists:varian_produks,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $varian = VarianProduk::findOrFail($request->varian_id);

        if ($varian->stok < $request->jumlah) {
            return back()->with('error', 'Stok tidak mencukupi.');
        }

        // Ambil cart user, atau buat baru
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);

        // Cek jika varian sudah ada di cart
        $item = CartItem::where('cart_id', $cart->id)
            ->where('varian_produk_id', $varian->id)
            ->first();

        if ($item) {
            // Update quantity dan subtotal
            $item->quantity += $request->jumlah;
            $item->subtotal = $item->quantity * $varian->harga;
            $item->save();
        } else {
            // Tambah item baru ke cart
            CartItem::create([
                'cart_id' => $cart->id,
                'varian_produk_id' => $varian->id,
                'quantity' => $request->jumlah,
                'price' => $varian->harga,
                'subtotal' => $request->jumlah * $varian->harga,
            ]);
        }

        // Cek jika beli_sekarang == 1
        if ($request->beli_sekarang == 1) {
            return redirect()->route('keranjang.checkout')->with('success', 'Lanjut ke checkout.');
        }

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }



    // Menghapus item dari keranjang
    public function remove($cartItemId)
    {
        // Cari item di dalam keranjang berdasarkan ID
        $cartItem = CartItem::findOrFail($cartItemId);

        // Hapus item dari keranjang
        $cartItem->delete();

        // Redirect kembali ke halaman keranjang dengan pesan sukses
        return redirect()->route('cart.index')->with('success', 'Produk berhasil dihapus dari keranjang!');
    }

    // Mengupdate jumlah produk dalam keranjang
    public function update(Request $request, $cartItemId)
    {
        // Validasi input jumlah
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Cari item di dalam keranjang berdasarkan ID
        $cartItem = CartItem::findOrFail($cartItemId);

        // Update jumlah dan subtotal
        $cartItem->update([
            'quantity' => $request->quantity,
            'subtotal' => $cartItem->price * $request->quantity,
        ]);

        // Redirect kembali ke halaman keranjang dengan pesan sukses
        return redirect()->route('cart.index')->with('success', 'Jumlah produk berhasil diperbarui!');
    }
}
