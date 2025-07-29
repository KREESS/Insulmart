@extends('admin.components.app')
<head>
    <title>@yield('title', 'Live Chat Admin | Insulmart')</title>
    <style>
        :root {
            --maroon-dark: #8B0000;
            --maroon-hover: #a41515;
            --gradient-maroon: linear-gradient(90deg,#8B0000 0%,#a41515 100%);
            --light-bg: #faf9f8;
            --soft-divider: #f2e9e9;
        }
        body, .bg-light {
            background: var(--light-bg) !important;
        }
        .gradient-header {
            background: var(--gradient-maroon);
            color: #fff;
        }
        .table-chat th, .table-chat td {
            vertical-align: middle !important;
        }
        .table-chat tr {
            transition: background 0.14s;
        }
        .table-chat tr:hover {
            background: #fbeaec !important;
        }
        .avatar-circle {
            width: 34px; height: 34px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;
            font-weight: bold; color: #fff; background: var(--gradient-maroon); font-size: 1.1em; box-shadow: 0 2px 10px #8b000014;
        }
        .badge-gradient {
            background: var(--gradient-maroon); color: #fff;
        }
        .badge-online {
            background: linear-gradient(90deg, #28a745 50%, #218838 100%) !important; color: #fff;
        }
        .badge-offline {
            background: linear-gradient(90deg, #bbb 0%, #999 100%) !important; color: #fff;
        }
        .card-info-summary {
            background: var(--gradient-maroon);
            border: none; border-radius: 1.1rem;
            color: #fff;
            box-shadow: 0 4px 18px 0 rgba(139,0,0,.06);
            padding: 1.1rem 1.8rem;
            display: flex; align-items: center; gap: 2.5rem;
            font-size: 1.07rem;
        }
        .card-info-summary .info-stat {
            display: flex; align-items: center; gap: .8em;
        }
        .btn-maroon {
            background: var(--gradient-maroon);
            color: #fff; border: none; border-radius: 2em; font-weight: 600;
        }
        .btn-maroon:hover, .btn-maroon:focus {
            background: linear-gradient(90deg,#a41515,#8B0000 80%);
            color: #fff;
        }
        .status-divider {
            border-bottom: 1.5px dashed var(--soft-divider);
            margin: 1.1rem 0 .8rem 0;
        }
        .btn-maroon, .btn-maroon * {
            color: #fff !important;
        }
        @media (max-width: 800px) {
            .card-info-summary { flex-direction: column; gap: 1.2rem; }
            .table-responsive { font-size: .97rem; }
        }
    </style>
</head>

@section('content')
<main class="main-content p-4 bg-light" id="mainContent">
    <div class="container py-4">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-semibold" style="color: var(--maroon-dark);letter-spacing:.2px">
                <i class="bi bi-chat-dots me-2"></i> Layanan Live Chat Pengunjung
            </h4>
        </div>

        {{-- Info ringkas statistik chat --}}
        <div class="card-info-summary mb-4">
            <div class="info-stat">
                <i class="bi bi-inboxes fs-5"></i>
                <span>Total Sesi: <b>{{ $chats->count() }}</b></span>
            </div>
            <div class="info-stat">
                <i class="bi bi-envelope-paper fs-5"></i>
                <span>Pesan Belum Dibaca:
                    <b>
                        {{
                            $chats->sum(fn($chat) =>
                                $chat->messages()->where('is_read', false)->where('sender', 'user')->count()
                            )
                        }}
                    </b>
                </span>
            </div>
            <div class="info-stat">
                <i class="bi bi-people fs-5"></i>
                <span>Pengguna Terdaftar: <b>{{ $chats->whereNotNull('user_id')->count() }}</b></span>
            </div>
            <div class="info-stat">
                <i class="bi bi-person fs-5"></i>
                <span>Guest: <b>{{ $chats->whereNull('user_id')->count() }}</b></span>
            </div>
        </div>

        <div class="card shadow border-0">
            <div class="card-header gradient-header">
                <strong>
                    <i class="bi bi-list-ul"></i> Daftar Semua Sesi Chat
                </strong>
            </div>
            <div class="card-body table-responsive p-0" style="border-radius:0 0 1.1rem 1.1rem">
                <table class="table table-hover mb-0 align-middle table-chat">
                    <thead style="background-color: #f8e7ea;" class="text-dark">
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
                                $isOnline = $chat->user && optional($chat->user)->last_online && now()->diffInMinutes($chat->user->last_online) <= 5;
                            @endphp
                            <tr>
                                <td class="text-center fw-bold" style="color:var(--maroon-dark)">{{ $index + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        @if($chat->user)
                                            <span class="avatar-circle me-1">
                                                {{ strtoupper(substr($chat->user->name,0,1)) }}
                                            </span>
                                            <span>
                                                <span class="badge badge-gradient shadow-sm mb-1" style="font-size:.98em;">
                                                    <i class="bi bi-person-circle"></i> {{ $chat->user->name }}
                                                </span>
                                                <br>
                                                <span class="badge badge-online" style="font-size:.8em;">
                                                    <i class="bi bi-circle-fill"></i>
                                                    Online
                                                </span>
                                            </span>
                                        @else
                                            <span class="avatar-circle bg-secondary me-1"><i class="bi bi-person"></i></span>
                                            <span>
                                                <span class="badge bg-secondary mb-1" style="font-size:.98em;">
                                                    Guest
                                                </span>
                                                <br>
                                                <span class="badge badge-offline" style="font-size:.8em;">
                                                    <i class="bi bi-circle"></i>
                                                    Offline
                                                </span>
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="text-center">{{ $chat->guest_id ?? '-' }}</td>
                                <td>
                                    <span>
                                        <i class="bi bi-clock-history me-1"></i>
                                        {{ \Carbon\Carbon::parse($chat->created_at)->format('d M Y H:i') }}
                                    </span>
                                </td>
                                <td>
                                    @if($unreadCount > 0)
                                        <span class="badge text-bg-danger rounded-pill" style="background: var(--maroon-hover);">
                                            <i class="bi bi-exclamation-circle"></i>
                                            {{ $unreadCount }} belum dibaca
                                        </span>
                                    @else
                                        <span class="text-success fw-semibold">
                                            <i class="bi bi-check2-all" style="color: #007bff;"></i> Terbaca
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.chat.show', $chat->id) }}"
                                        class="btn btn-sm btn-maroon px-3 shadow"
                                        title="Buka chat ini">
                                        <i class="bi bi-chat-dots-fill"></i> Buka
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    <i class="bi bi-info-circle me-1"></i> Tidak ada sesi chat ditemukan.
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
