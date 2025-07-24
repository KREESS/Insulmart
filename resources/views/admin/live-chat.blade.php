@extends('admin.components.app')
    <head>
        <title>@yield('title', 'Live Chat Admin | Insulmart')</title>
        <!-- Tag lain seperti meta, link CSS, dll -->
    </head>
@section('content')
<main class="main-content p-4 bg-light" id="mainContent">
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="text-dark fw-semibold" style="color: #8B0000;">💬 Layanan Live Chat Pengunjung</h4>
        </div>
        <div class="card shadow border-0">
            <div class="card-header text-white" style="background-color: #8B0000;">
                <strong>Daftar Semua Sesi Chat</strong>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover mb-0 align-middle">
                    <thead style="background-color: #f5f5f5;" class="text-dark">
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th>Pengguna</th>
                            <th>Guest ID</th>
                            <th>Waktu Mulai</th>
                            <th>Status Pesan</th>
                            <th style="width: 120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($chats as $index => $chat)
                            @php
                                $unreadCount = $chat->messages()->where('is_read', false)->where('sender', 'user')->count();
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if($chat->user)
                                        <span class="badge bg-success">{{ $chat->user->name }}</span>
                                    @else
                                        <span class="badge bg-secondary">Guest</span>
                                    @endif
                                </td>
                                <td>{{ $chat->guest_id ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($chat->created_at)->format('d M Y H:i') }}</td>
                                <td>
                                    @if($unreadCount > 0)
                                        <span class="badge text-bg-danger rounded-pill" style="background-color: #B22222;">
                                            {{ $unreadCount }} belum dibaca
                                        </span>
                                    @else
                                        <span class="text-success">
                                            <i class="bi bi-check2-all" style="color: #007bff;"></i> Terbaca
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.chat.show', $chat->id) }}"
                                        class="btn btn-sm text-white"
                                        style="background-color: #8B0000;">
                                        <i class="bi bi-chat-dots-fill"></i> Buka
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    Tidak ada sesi chat ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection
