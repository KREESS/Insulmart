    document.addEventListener("DOMContentLoaded", function () {
        // === 1. Fade-Up Animation ===
        const fadeElements = document.querySelectorAll('.fade-up');
        const fadeOptions = {
            threshold: 0.2
        };

        const fadeObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('show');
                    fadeObserver.unobserve(entry.target);
                }
            });
        }, fadeOptions);

        fadeElements.forEach(el => {
            fadeObserver.observe(el);
        });

        // === 2. Slider Functionality ===
        const slides = document.querySelectorAll('.slider-slide');
        const title = document.getElementById('slider-title');
        const desc = document.getElementById('slider-desc');
        const sliderContent = document.querySelector('.slider-content');
        const ctaButton = document.querySelector('.cta-btn');
        const welcomeText = document.querySelector('.welcome-text');

        const texts = [
            {
                title: "",
                desc: "",
                position: 'text-center' // Ini untuk slide pertama (tanpa teks)
            },
            {
                title: "E-COMMERCE MATERIAL INSULASI TERLENGKAP",
                desc: "Insulmart menyediakan berbagai jenis rockwool, glasswool, dan material insulasi lainnya untuk kebutuhan rumah, industri, dan proyek.",
                position: 'text-right'
            },
            {
                title: "BELANJA MUDAH & CEPAT DI INSULMART",
                desc: "Cek stok, harga, dan lakukan transaksi langsung melalui website kami dengan pengiriman ke seluruh Indonesia.",
                position: 'text-left'
            }
        ];

        let slideIndex = 0;

        function showSlides() {
            // Reset semua slide
            slides.forEach(slide => slide.classList.remove('slider-active'));

            // Ganti slide aktif
            slideIndex = (slideIndex + 1) % slides.length;
            slides[slideIndex].classList.add('slider-active');

            // Ambil posisi sekarang
            const posClass = texts[slideIndex].position;

            // Update teks
            title.textContent = texts[slideIndex].title;
            desc.textContent = texts[slideIndex].desc;

            // Tampilkan / sembunyikan elemen jika slide tengah
            if (posClass === 'text-center') {
                title.style.display = 'none';
                desc.style.display = 'none';
                ctaButton.style.display = 'none';
                welcomeText.style.display = 'none';
            } else {
                title.style.display = 'block';
                desc.style.display = 'block';
                ctaButton.style.display = 'inline-block';
                welcomeText.style.display = 'block';
            }

            // Reset posisi & animasi
            sliderContent.classList.remove('text-left', 'text-center', 'text-right');
            sliderContent.classList.remove('animate-left', 'animate-right', 'animate-center');

            sliderContent.classList.add(posClass);

            // Restart animasi (trik reflow)
            void sliderContent.offsetWidth;

            if (posClass === 'text-left') {
                sliderContent.classList.add('animate-left');
            } else if (posClass === 'text-right') {
                sliderContent.classList.add('animate-right');
            } else {
                sliderContent.classList.add('animate-center');
            }

            // Lanjutkan ke slide berikutnya setiap 3 detik
            setTimeout(showSlides, 3000);
        }

        if (slides.length) showSlides();

        // === 3. Update Tahun Otomatis
        const yearSpan = document.getElementById("current-year");
        if (yearSpan) {
            yearSpan.textContent = new Date().getFullYear();
        }

        // === 4. Navbar Toggle (Gabungan dari script ke-2)
        const toggle = document.getElementById("navbar-toggle");
        const menu = document.getElementById("navbar-menu");

        if (toggle && menu) {
            toggle.addEventListener("click", function (e) {
                e.stopPropagation();
                menu.classList.toggle("show");
            });

            document.addEventListener("click", function (e) {
                if (!menu.contains(e.target) && !toggle.contains(e.target)) {
                    menu.classList.remove("show");
                }
            });

            const links = menu.querySelectorAll("a");
            links.forEach(link => {
                link.addEventListener("click", () => {
                    menu.classList.remove("show");
                });
            });
        }
        // === 5. Scroll to Top Button
        // Scroll listener untuk navbar transparan
        const navbar = document.querySelector('nav');

        window.addEventListener('scroll', function () {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // === 6. Live Chat Widget ===
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

        let isMinimized = false;
        let chatHasStarted = false;

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

        startChatBtn.addEventListener("click", switchToChatView);

        minimizeBtn.addEventListener("click", () => {
            if (!isMinimized) {
                initialScreen.style.display = "none";
                chatBody.style.display = "none";
                chatFooter.style.display = "none";
                chatBox.style.bottom = "25px";
                chatBox.style.height = "auto";
                minimizeBtn.textContent = '□';
                isMinimized = true;
            } else {
                chatBox.style.bottom = "100px";
                chatBox.style.height = "480px";
                minimizeBtn.textContent = '−';
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
