@extends('components.layout')

@section('content')

    <header id="beranda" class="snap-section">
        <div class="slider-container">
            <div class="slider-slide slider-active" style="background-image: url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1400&q=80');"></div>
            <div class="slider-slide" style="background-image: url('https://talirejeki.com/public/image/slideshow/1Zc5EU_banner.jpg');"></div>
            <div class="slider-slide" style="background-image: url('{{ asset('assets/img/landing-page-oke2.png') }}');"></div>
        </div>

        <div class="slider-content">
            <p class="welcome-text">Selamat Datang di PT Tali Rejeki</p>
            <h1 id="slider-title">TALI REJEKI</h1>
            <p id="slider-desc">
                BERDIRI SEJAK 2011. PT. TALI REJEKI DIPERCAYA SEBAGAI DISTRIBUTOR & AGEN UNTUK BERBAGAI PROJECT BESAR PEREDAM SUARA UNTUK RUANG KARAOKE, BALLROOM, DAN AKUSTIK DI SELURUH INDONESIA.
            </p>
            <a href="produk.html" class="cta-btn" style="color: white;">Lihat Produk Kami</a>
        </div>
    </header>
    <br>
    <br>
    <br>
    <br>

    <!-- Bagian Bawah Edit -->
    <!-- sama -->
    <div class="container">
    <!-- Kenapa Harus Tali Rejeki -->
        <section id="profile" class="snap-section fade-up">
            <h2 class="section-title">Kenapa Harus Tali Rejeki?</h2>
            <div class="keunggulan-wrapper">
                <div class="keunggulan-card fade-up">
                    <b>Cepat & Lengkap:</b> Tali Rejeki melayani pengiriman di luar jam kerja ke seluruh Indonesia dengan ongkir murah dan pengiriman cepat. Produk lengkap termasuk insulasi, peredam, dan aksesoris.
                </div>
                <div class="keunggulan-card fade-up">
                    <b>Murah:</b> Semakin besar jumlah pembelian, semakin hemat biaya yang Anda keluarkan.
                </div>
                <div class="keunggulan-card fade-up">
                    <b>Support Tender & Project:</b> Dukungan pembelian dalam jumlah besar dan waktu mendesak dengan stok siap sedia.
                </div>
                <div class="keunggulan-card fade-up">
                    <b>Garansi Keaslian Barang:</b> Semua produk dijamin 100% asli dari segi bahan, merek, dan ukuran.
                </div>
            </div>
        </section>

        <!-- Produk Unggulan -->
        <section id="produk" class="snap-section">
            <h2 class="section-title" id="produk">Produk Unggulan</h2>
            <div class="produk-list">
                <div class="produk-item">
                    <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=400&q=80" alt="Tali Tambang">
                    <h4>Tali Tambang</h4>
                    <p>Tali tambang serbaguna, kuat, dan tahan lama untuk berbagai kebutuhan industri.</p>
                </div>
                <div class="produk-item">
                    <img src="https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=400&q=80" alt="Tali Plastik">
                    <h4>Tali Plastik</h4>
                    <p>Tali plastik berkualitas tinggi, cocok untuk pertanian dan perikanan.</p>
                </div>
                <div class="produk-item">
                    <img src="https://images.unsplash.com/photo-1519125323398-675f0ddb6308?auto=format&fit=crop&w=400&q=80" alt="Tali Nilon">
                    <h4>Tali Nilon</h4>
                    <p>Tali nilon dengan daya tahan tinggi, fleksibel, dan tidak mudah putus.</p>
                </div>
            </div>
        </section>

        <!-- Proyek Kami -->
        <section id="brand" class="snap-section">
            <h2 class="section-title" id="proyek">Proyek Kami</h2>
            <div class="galeri-list">
                <div class="galeri-item">
                    <img src="https://images.unsplash.com/photo-1615873968403-89e1e38c5693?auto=format&fit=crop&w=400&q=80" alt="Proyek Gedung">
                    <p>Pemasangan insulasi akustik pada proyek ballroom hotel di Jakarta.</p>
                </div>
                <div class="galeri-item">
                    <img src="https://images.unsplash.com/photo-1600585154340-be6161c458f9?auto=format&fit=crop&w=400&q=80" alt="Proyek Industri">
                    <p>Instalasi peredam suara untuk ruang karaoke dan studio musik di Surabaya.</p>
                </div>
                <div class="galeri-item">
                    <img src="https://images.unsplash.com/photo-1598300056391-5acb9fc16e25?auto=format&fit=crop&w=400&q=80" alt="Proyek Mall">
                    <p>Distribusi bahan insulasi untuk proyek renovasi pusat perbelanjaan di Bandung.</p>
                </div>
            </div>
        </section>

        <!-- Our Brand -->
        <section id="brand" class="snap-section">
            <h2 class="section-title" id="brand">Our Brand</h2>
            <div class="produk-list">
                <div class="produk-item brand-logo">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/5/55/Logo_Rockwool.svg" alt="Rockwool">
                    <h4>ROCKWOOL</h4>
                    <p>Isolasi termal dan akustik berbahan batuan alami kualitas internasional.</p>
                </div>
                <div class="produk-item brand-logo">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/5/5a/Knauf_logo.svg" alt="Knauf">
                    <h4>KNAUF</h4>
                    <p>Produsen material bangunan global seperti insulasi, drywall, dan akustik.</p>
                </div>
                <div class="produk-item brand-logo">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/6/65/Glasswool_logo.svg" alt="Glasswool">
                    <h4>GLASSWOOL</h4>
                    <p>Solusi isolasi suara dan panas berbahan serat kaca yang tahan api.</p>
                </div>
            </div>
        </section>
    </div>

<div id="live-chat-toggle" style="
    position: fixed;
    bottom: 25px;
    right: 25px;
    z-index: 9999;
    cursor: pointer;
    background-color: #8B0000;
    width: 56px;
    height: 56px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    box-shadow: 0 4px 12px rgba(0,0,0,0.3);
">
    <i class="bi bi-chat-dots-fill" style="font-size: 24px; color: white;"></i>
</div>

<div id="live-chat-widget" style="
    position: fixed;
    bottom: 100px;
    right: 25px;
    width: 320px;
    height: 480px; /* Sedikit diperbesar untuk mengakomodasi konten baru */
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 6px 24px rgba(0,0,0,0.2);
    overflow: hidden;
    display: none;
    flex-direction: column;
    z-index: 10000;
    transition: all 0.3s ease;
">
    <div style="background: #8B0000; color: white; padding: 16px; display: flex; justify-content: space-between; align-items: center; flex-shrink: 0;">
        <strong>Help</strong> <div>
            <button id="minimize-chat" style="background: none; border: none; color: white; font-size: 18px; margin-right: 8px; cursor: pointer;">−</button>
            <button id="close-chat" style="background: none; border: none; color: white; font-size: 18px; cursor: pointer;">×</button>
        </div>
    </div>

    <div id="widget-content" style="flex: 1; overflow-y: auto; display: flex; flex-direction: column;">
        
        <div id="initial-screen" style="padding: 20px; flex: 1; display: flex; flex-direction: column;">
            <div style="position: relative; margin-bottom: 24px;">
                <i class="bi bi-search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #888;"></i>
                <input type="text" placeholder="Cari panduan (cth: deposit)" style="width: 100%; padding: 10px 10px 10px 40px; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box;">
            </div>

            <strong>Top Suggestions</strong>
            <ul style="list-style: none; padding: 0; margin-top: 16px;">
                <li style="margin-bottom: 12px;">❓ Apakah Rockwool tersedia dalam berbagai ukuran dan ketebalan?</li>
                <li style="margin-bottom: 12px;">📦 Berapa lama pengiriman untuk wilayah luar pulau Jawa?</li>
                <li style="margin-bottom: 12px;">💰 Apakah ada diskon untuk pembelian grosir?</li>
                <li style="margin-bottom: 12px;">📋 Bagaimana cara cek stok barang sebelum membeli?</li>
                <li style="margin-bottom: 12px;">🛒 Apakah bisa beli satuan atau hanya per dus?</li>
                <li style="margin-bottom: 12px;">📍 Apakah bisa dikirim ke lokasi proyek saya?</li>
                <li style="margin-bottom: 12px;">💳 Apa saja metode pembayaran yang tersedia?</li>
                <li style="margin-bottom: 12px;">🎧 Rockwool tipe apa yang cocok untuk ruang studio?</li>
                <li style="margin-bottom: 12px;">📞 Apakah bisa konsultasi sebelum membeli?</li>
                <li style="margin-bottom: 12px;">🔄 Apakah bisa retur jika barang tidak sesuai?</li>
                <li style="margin-bottom: 12px;">🧾 Apakah ada invoice resmi untuk keperluan proyek?</li>
                <li style="margin-bottom: 12px;">🕒 Kapan layanan customer service tersedia?</li>
            </ul>

            <div style="margin-top: auto;"> <button id="start-chat-btn" style="width: 100%; background: #8B0000; color: white; border: none; padding: 12px; border-radius: 8px; cursor: pointer; font-size: 16px;">
                    Live chat
                </button>
            </div>
        </div>

        <div id="chat-body" style="flex: 1; padding: 16px; background: #f7f7f7; overflow-y: auto; display: none;">
            <div style="background: #eeeeee; border-radius: 12px; padding: 10px 14px; max-width: 85%; margin-bottom: 12px;">
                👋 Halo! Ada yang bisa kami bantu?
            </div>
        </div>
    </div>

    <div id="chat-footer" style="padding: 12px; background: white; border-top: 1px solid #ddd; display: none; gap: 8px; flex-shrink: 0;">
        <input type="text" id="chat-input" placeholder="Ketik pesan..." style="flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 8px;">
        <button id="send-chat" style="background: #8B0000; color: white; border: none; border-radius: 8px; padding: 10px 14px; cursor: pointer;">
            Kirim
        </button>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Referensi elemen
    const toggleBtn = document.getElementById("live-chat-toggle");
    const chatBox = document.getElementById("live-chat-widget");
    const closeBtn = document.getElementById("close-chat");
    const minimizeBtn = document.getElementById("minimize-chat");
    
    // Elemen tampilan
    const initialScreen = document.getElementById("initial-screen");
    const chatBody = document.getElementById("chat-body");
    const chatFooter = document.getElementById("chat-footer");
    
    // Tombol
    const startChatBtn = document.getElementById("start-chat-btn");
    const sendBtn = document.getElementById("send-chat");
    const chatInput = document.getElementById("chat-input");

    // State management
    let isMinimized = false;
    let chatHasStarted = false;

    // Fungsi untuk beralih ke mode chat
    function switchToChatView() {
        initialScreen.style.display = "none";
        chatBody.style.display = "block";
        chatFooter.style.display = "flex";
        chatHasStarted = true;
    }
    
    // Fungsi untuk reset ke tampilan awal
    function resetToInitialView() {
        chatBody.style.display = "none";
        chatFooter.style.display = "none";
        initialScreen.style.display = "flex";
        chatHasStarted = false;
        
        // Kembalikan posisi jika ditutup saat minimize
        if (isMinimized) {
            chatBox.style.bottom = "100px";
            minimizeBtn.textContent = '−';
            isMinimized = false;
        }
    }

    // Event Listeners
    toggleBtn.addEventListener("click", () => {
        chatBox.style.display = "flex";
        toggleBtn.style.opacity = "0";
        toggleBtn.style.visibility = "hidden";
    });

    closeBtn.addEventListener("click", () => {
        chatBox.style.display = "none";
        toggleBtn.style.opacity = "1";
        toggleBtn.style.visibility = "visible";
        resetToInitialView();
    });

    startChatBtn.addEventListener("click", switchToChatView);

    minimizeBtn.addEventListener("click", () => {
        if (!isMinimized) {
            // Sembunyikan semua konten utama
            initialScreen.style.display = "none";
            chatBody.style.display = "none";
            chatFooter.style.display = "none";
            // Pindahkan ke bawah
            chatBox.style.bottom = "25px";
            chatBox.style.height = "auto";
            minimizeBtn.textContent = '□';
            isMinimized = true;
        } else {
            // Kembalikan posisi & tinggi
            chatBox.style.bottom = "100px";
            chatBox.style.height = "480px";
            minimizeBtn.textContent = '−';
            // Tampilkan kembali view yang sesuai
            if (chatHasStarted) {
                chatBody.style.display = "block";
                chatFooter.style.display = "flex";
            } else {
                initialScreen.style.display = "flex";
            }
            isMinimized = false;
        }
    });

    sendBtn.addEventListener("click", () => {
        const message = chatInput.value.trim();
        if (message !== "") {
            const userBubble = document.createElement("div");
            userBubble.textContent = message;
            userBubble.style.cssText = `background: #8B0000; color: white; border-radius: 12px; padding: 10px 14px; max-width: 85%; margin-left: auto; margin-bottom: 12px;`;
            chatBody.appendChild(userBubble);
            chatInput.value = "";
            chatBody.scrollTop = chatBody.scrollHeight;
        }
    });

    chatInput.addEventListener("keypress", function (e) {
        if (e.key === "Enter") {
            e.preventDefault();
            sendBtn.click();
        }
    });
});
</script>
@endsection

