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
        bottom: 43px;
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
    // === Element Reference ===
    const toggleBtn = document.getElementById("live-chat-toggle");
    const chatBox = document.getElementById("live-chat-widget");
    const closeBtn = document.getElementById("close-chat");
    const minimizeBtn = document.getElementById("minimize-chat");

    const initialScreen = document.getElementById("initial-screen");
    const chatBody = document.getElementById("chat-body");
    const chatFooter = document.getElementById("chat-footer");

    const startChatBtn = document.getElementById("start-chat-btn");
    const sendBtn = document.getElementById("send-chat");
    const chatInput = document.getElementById("chat-input");

    // === State ===
    let isMinimized = false;
    let chatHasStarted = false;
    let currentChatId = null;

    function switchToChatView() {
        initialScreen.style.display = "none";
        chatBody.style.display = "block";
        chatFooter.style.display = "flex";
        chatHasStarted = true;
    }

    function resetToInitialView() {
        chatBody.style.display = "none";
        chatFooter.style.display = "none";
        initialScreen.style.display = "flex";
        chatHasStarted = false;

        if (isMinimized) {
            chatBox.style.bottom = "100px";
            minimizeBtn.textContent = '−';
            isMinimized = false;
        }
    }

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

    minimizeBtn.addEventListener("click", () => {
        if (!isMinimized) {
            chatBody.style.display = "none";
            chatFooter.style.display = "none";
            initialScreen.style.display = "none";
            chatBox.style.bottom = "25px";
            chatBox.style.height = "auto";
            minimizeBtn.textContent = '□';
            isMinimized = true;
        } else {
            chatBox.style.bottom = "100px";
            chatBox.style.height = "480px";
            minimizeBtn.textContent = '−';
            isMinimized = false;

            if (chatHasStarted) {
                chatBody.style.display = "block";
                chatFooter.style.display = "flex";
            } else {
                initialScreen.style.display = "flex";
            }
        }
    });

    startChatBtn.addEventListener("click", async () => {
        switchToChatView();
        try {
            const response = await fetch("/live-chat/start", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                },
            });
            const data = await response.json();
            currentChatId = data.chat_id;
            await loadMessages();
        } catch (error) {
            console.error("Gagal memulai sesi chat:", error);
        }
    });

    async function loadMessages() {
        if (!currentChatId) return;

        try {
            const response = await fetch(`/live-chat/messages/${currentChatId}`);
            const messages = await response.json();

            chatBody.innerHTML = '';

            messages.forEach(msg => {
                const bubble = document.createElement("div");
                const time = new Date(msg.created_at).toLocaleTimeString('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                });

                let checkmark = "";
                if (msg.sender === "user" || msg.sender === "admin") {
                    checkmark = msg.is_read
                        ? `<span class="tick-double"></span>`
                        : `<span class="tick-single"></span>`;
                }

                const isUser = msg.sender === 'user';

                bubble.innerHTML = `
                    <div style="font-size: 14px;">${msg.message}</div>
                    <div style="font-size: 11px; display: flex; justify-content: flex-end; align-items: center; gap: 4px; margin-top: 4px; color: ${isUser ? '#777' : 'rgba(255,255,255,0.7)'}">
                        <span>${time}</span> ${checkmark}
                    </div>
                `;

                bubble.style.cssText = `
                    background: ${isUser ? '#eeeeee' : '#8B0000'};
                    color: ${isUser ? 'black' : 'white'};
                    border-radius: 12px;
                    padding: 10px 14px;
                    max-width: 85%;
                    margin-bottom: 12px;
                    align-self: ${isUser ? 'flex-end' : 'flex-start'};
                `;

                const wrapper = document.createElement("div");
                wrapper.style.display = "flex";
                wrapper.style.flexDirection = "column";
                wrapper.style.alignItems = isUser ? "flex-end" : "flex-start";
                wrapper.appendChild(bubble);

                chatBody.appendChild(wrapper);
            });


            chatBody.scrollTop = chatBody.scrollHeight;

        } catch (error) {
            console.error("Gagal memuat pesan:", error);
        }
    }

    sendBtn.addEventListener("click", async () => {
        const message = chatInput.value.trim();
        if (message === "" || !currentChatId) return;

        try {
            const response = await fetch("/live-chat/send", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                },
                body: JSON.stringify({
                    chat_id: currentChatId,
                    message: message
                })
            });

            const data = await response.json();
            if (data.success) {
                chatInput.value = "";
                await loadMessages();
            }
        } catch (error) {
            console.error("Gagal mengirim pesan:", error);
        }
    });

    chatInput.addEventListener("keypress", function (e) {
        if (e.key === "Enter") {
            e.preventDefault();
            sendBtn.click();
        }
    });

    // Optional polling untuk update centang otomatis
    setInterval(() => {
        if (currentChatId && chatHasStarted) {
            loadMessages();
        }
    }, 3000);
</script>

<style>
    .tick-single {
        display: inline-block;
        width: 16px;
        height: 16px;
        background: url('data:image/svg+xml;utf8,<svg fill="gray" height="20" viewBox="0 0 24 24" width="20" xmlns="http://www.w3.org/2000/svg"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>') no-repeat center center;
        background-size: contain;
    }

    .tick-double {
        display: inline-block;
        width: 20px;
        height: 16px;
        background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="%232196F3" d="M1.41 13.41L0 12l6 6 12-12-1.41-1.41L6 15.17zM7.41 13.41L6 12l6 6 12-12-1.41-1.41L12 15.17z"/></svg>') no-repeat center center;
        background-size: contain;
    }
</style>
