<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\ChatMessage;
use Illuminate\Support\Facades\View;
use App\Models\Pemesanan;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('admin.*', function ($view) {
            $unreadCount = ChatMessage::where('is_read', false)->count();
            $view->with('unreadCount', $unreadCount);
        });

        // Share ke semua view dengan prefix admin.*
        View::composer('admin.*', function ($view) {
            // Hitung chat belum dibaca
            $unreadCount = ChatMessage::where('is_read', false)->count();

            // Hitung pesanan dengan status "menunggu"
            $waitingOrdersCount = Pemesanan::where('status_pemesanan', 'menunggu')->count();

            // Kirim ke semua view admin.*
            $view->with([
                'unreadCount' => $unreadCount,
                'waitingOrdersCount' => $waitingOrdersCount,
            ]);
        });
    }
}
