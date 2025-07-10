@extends('admin.components.app')

@section('content')
<main class="main-content p-4 bg-light" id="mainContent">
    <div class="container py-4">
        <a href="{{ url('/') }}" class="btn btn-outline-secondary mt-4">
            ← Kembali ke Beranda
        </a>
        <br><br>
        <h4 class="mb-4 text-dark fw-semibold">
            💬 Detail Chat - 
            @if($chat->user)
                {{ $chat->user->name }}
            @else
                Guest ({{ Str::limit($chat->guest_id, 8) }})
            @endif
        </h4>

        <div class="card shadow border-0">
            <div class="card-header text-white" style="background-color: #8B0000;">
                <strong>Riwayat Percakapan</strong>
            </div>

            <div class="card-body px-3 bg-white" style="max-height: 500px; overflow-y: auto;" id="chatScrollArea">
                <style>
                    .chat-bubble {
                        padding: 10px 14px;
                        border-radius: 16px;
                        max-width: 70%;
                        box-shadow: 0 1px 4px rgba(0,0,0,0.1);
                        animation: fadeIn 0.3s ease;
                    }

                    .chat-meta {
                        font-size: 11px;
                        display: flex;
                        justify-content: flex-end;
                        align-items: center;
                        gap: 6px;
                        margin-top: 4px;
                    }

                    @keyframes fadeIn {
                        from { opacity: 0; transform: translateY(8px); }
                        to { opacity: 1; transform: translateY(0); }
                    }

                    .chat-avatar {
                        width: 32px;
                        height: 32px;
                        background: #ccc;
                        border-radius: 50%;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        font-size: 14px;
                        color: white;
                        font-weight: bold;
                    }
                </style>

                @forelse ($messages as $msg)
                    <div class="d-flex mb-3 {{ $msg->sender === 'admin' ? 'justify-content-end' : 'justify-content-start' }}">
                        @if ($msg->sender !== 'admin')
                            <div class="me-2 chat-avatar bg-secondary">
                                {{ $chat->user ? substr($chat->user->name, 0, 1) : 'G' }}
                            </div>
                        @endif

                        <div class="chat-bubble" style="
                            background-color: {{ $msg->sender === 'admin' ? '#8B0000' : '#f1f1f1' }};
                            color: {{ $msg->sender === 'admin' ? '#fff' : '#000' }};
                        ">
                            <div>{{ $msg->message }}</div>
                            <div class="chat-meta" style="color: {{ $msg->sender === 'admin' ? '#eee' : '#666' }}">
                                <span>{{ \Carbon\Carbon::parse($msg->created_at)->format('H:i') }}</span>
                                {!! $msg->is_read
                                    ? '<i class="bi bi-check2-all text-primary"></i>'
                                    : '<i class="bi bi-check2 text-secondary"></i>' !!}
                            </div>
                        </div>

                        @if ($msg->sender === 'admin')
                            <div class="ms-2 chat-avatar bg-danger">
                                A
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="text-center text-muted py-4">Belum ada pesan.</div>
                @endforelse
            </div>


            {{-- Form Kirim Pesan --}}
            <form action="{{ route('admin.chat.reply', $chat->id) }}" method="POST" class="border-top d-flex gap-2 p-3 align-items-center">
                @csrf
                <input type="text" name="message" class="form-control" placeholder="Tulis pesan..." required autofocus>
                <button type="submit" class="btn text-white" style="background-color: #8B0000;">
                    <i class="bi bi-send-fill"></i>
                </button>
            </form>
        </div>
    </div>
</main>

<script>
    window.onload = function () {
        const area = document.getElementById("chatScrollArea");
        area.scrollTop = area.scrollHeight;
    };
</script>

<script>
    const area = document.getElementById("chatScrollArea");

    // Scroll to bottom saat load
    window.onload = () => {
        area.scrollTop = area.scrollHeight;
    };

    let lastMessageCount = {{ count($messages) }};
    const chatId = {{ $chat->id }};

    function renderMessages(messages) {
        const container = area;
        container.innerHTML = '';

        messages.forEach(msg => {
            const isAdmin = msg.sender === 'admin';

            const bubble = document.createElement('div');
            bubble.className = 'd-flex mb-3 ' + (isAdmin ? 'justify-content-end' : 'justify-content-start');

            bubble.innerHTML = `
                <div style="
                    background-color: ${isAdmin ? '#8B0000' : '#e6e6e6'};
                    color: ${isAdmin ? '#fff' : '#000'};
                    padding: 10px 14px;
                    border-radius: 16px;
                    max-width: 75%;
                    box-shadow: 0 1px 4px rgba(0,0,0,0.1);
                ">
                    <div>${msg.message}</div>
                    <div class="d-flex justify-content-end align-items-center gap-1 mt-1" style="font-size: 11px; color: ${isAdmin ? '#eee' : '#777'}">
                        <span>${new Date(msg.created_at).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' })}</span>
                        ${msg.is_read
                            ? '<i class="bi bi-check2-all text-primary"></i>'
                            : '<i class="bi bi-check2 text-secondary"></i>'
                        }
                    </div>
                </div>
            `;

            container.appendChild(bubble);
        });

        area.scrollTop = area.scrollHeight;
    }

    async function checkForNewMessages() {
        try {
            const response = await fetch(`/admin/live-chat/messages/${chatId}`);
            const data = await response.json();

            if (data.messages.length !== lastMessageCount) {
                lastMessageCount = data.messages.length;
                renderMessages(data.messages);
            }
        } catch (error) {
            console.error('Gagal mengambil pesan:', error);
        }
    }

    setInterval(checkForNewMessages, 5000); // Cek tiap 5 detik
</script>

@endsection
