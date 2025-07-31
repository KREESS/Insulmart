<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Produk;
use App\Models\VarianProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ArmadaPengiriman;

class CartController extends Controller
{
    // Menampilkan keranjang belanja pengguna
    public function index()
    {
        $user = Auth::user();
        $cart = $user->cart;
        $produks = Produk::with(['gambars', 'varians'])->get();
        $armadas = ArmadaPengiriman::orderBy('kapasitas_pack')->get();

        // ambil alamat default lewat relasi
        $defaultAddress = $user
            ->alamatPenggunas()
            ->where('is_default', true)
            ->first();

        return view('pelanggan.cart.index', compact('cart', 'produks', 'defaultAddress', 'armadas'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'varian_id' => 'required|exists:varian_produks,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $varian = VarianProduk::findOrFail($request->varian_id);

        // Ambil atau buat cart
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);

        $item = CartItem::where('cart_id', $cart->id)
            ->where('varian_produk_id', $varian->id)
            ->first();

        $jumlahBaru = $request->jumlah;
        $jumlahLama = $item ? $item->quantity : 0;
        $totalPermintaan = $jumlahLama + $jumlahBaru;

        if ($totalPermintaan > $varian->stok) {
            return back()->with('error', 'Jumlah total melebihi stok tersedia. Maksimal stok: ' . $varian->stok);
        }

        if ($item) {
            $item->quantity = $totalPermintaan;
            $item->subtotal = $item->quantity * $varian->harga;
            $item->save();
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'varian_produk_id' => $varian->id,
                'quantity' => $jumlahBaru,
                'price' => $varian->harga,
                'subtotal' => $jumlahBaru * $varian->harga,
            ]);
        }

        if ($request->beli_sekarang == 1) {
            return redirect()->route('cart.index')->with('success', 'Lanjut ke checkout.');
        }

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function remove($cartItemId)
    {
        $cartItem = CartItem::findOrFail($cartItemId);
        $cartItem->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('cart.index')->with('success', 'Produk berhasil dihapus dari keranjang!');
    }

    public function update(Request $request, $cartItemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = CartItem::findOrFail($cartItemId);

        // Ambil stok varian terkait
        $varian = \App\Models\VarianProduk::find($cartItem->varian_produk_id);
        if (!$varian) {
            return response()->json(['success' => false, 'message' => 'Varian produk tidak ditemukan.'], 404);
        }

        if ($request->quantity > $varian->stok) {
            return response()->json([
                'success' => false,
                'message' => 'Stok tidak mencukupi! Stok tersedia hanya ' . $varian->stok . ' pcs.'
            ], 422);
        }

        $cartItem->update([
            'quantity' => $request->quantity,
            'subtotal' => $cartItem->price * $request->quantity,
        ]);
        $cartItem->refresh();

        // Refresh Cart & Items
        $cart = $cartItem->cart()->with('items')->first();

        return response()->json([
            'success' => true,
            'newSubtotal' => number_format($cartItem->subtotal, 0, ',', '.'),
            'total' => number_format($cart->items->sum('subtotal'), 0, ',', '.')
        ]);
    }
}
