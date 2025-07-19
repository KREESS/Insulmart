<footer class="footer fade-up">
    <div class="footer-container fade-up">

        <!-- Info Perusahaan -->
        <div class="footer-column fade-up">
            <h3 class="footer-title">Insulmart</h3>
            <p>
                JL. RAYA TARUMAJAYA NO. 11 RT 001 RW 029 DUSUN III DESA SETIA ASIH<br>
                Kec. Tarumajaya, Kab. Bekasi 17215
            </p>
            <h4>Jam Operasional</h4>
            <p>Senin - Jumat<br>Pukul 08.00 - 17.00 WIB</p>
            <p>
                <strong>Telp:</strong><br>021-29470622<br>021-22889956<br>
                <strong>Fax:</strong><br>021-29470622<br>
                <strong>Email:</strong><br>
                <a href="mailto:insulmartindonesia@gmail.com">insulmartindonesia@gmail.com</a>
            </p>
        </div>

        <!-- Kontak Person -->
        <div class="footer-column fade-up">
            <h4 class="footer-title">Contact Person</h4>
            <p><strong>Mobile & WhatsApp:</strong></p>
            <ul class="contact-list">
                <li><strong>Siti:</strong>
                    <a href="https://wa.me/6281382523722" target="_blank">0813 8252 3722</a>
                </li>
                <li><strong>Kurnia:</strong>
                    <a href="https://wa.me/6281384808218" target="_blank">0813 8480 8218</a>
                    <span class="wa-only">(WA Only)</span>
                </li>
                <li><strong>Sari:</strong>
                    <a href="https://wa.me/6281316826959" target="_blank">0813 1682 6959</a>
                </li>
                <li><strong>Edy Purwanto:</strong>
                    <a href="https://wa.me/6281514515990" target="_blank">0815 1451 5990</a>
                </li>
            </ul>
        </div>

        <!-- Produk Kami -->
        <div class="footer-column fade-up">
            <h4 class="footer-title">Produk Kami</h4>
            <ul class="product-list">
                @forelse ($produks ?? [] as $item)
                    <li><a href="{{ route('produk.detail', $item->slugified_nama) }}">{{ $item->nama_produk }}</a></li>
                @empty
                    <li>Produk belum tersedia</li>
                @endforelse
            </ul>
        </div>

        <!-- Sosial Media dan Lokasi -->
        <div class="footer-column fade-up">
            <h4 class="footer-title">Temui Kami</h4>
            <div class="social-icons">
                <a href="https://facebook.com/PTTaliRejeki" target="_blank"><img src="https://cdn-icons-png.flaticon.com/512/733/733547.png" alt="Facebook"></a>
                <a href="https://instagram.com/PTTaliRejeki" target="_blank"><img src="https://cdn-icons-png.flaticon.com/512/2111/2111463.png" alt="Instagram"></a>
                <a href="https://wa.me/6281382523722" target="_blank"><img src="https://cdn-icons-png.flaticon.com/512/733/733585.png" alt="WhatsApp"></a>
                <a href="mailto:insulmart@gmail.com"><img src="https://cdn-icons-png.flaticon.com/512/561/561127.png" alt="Email"></a>
                <a href="https://youtube.com/@PTTaliRejeki" target="_blank"><img src="https://cdn-icons-png.flaticon.com/512/1384/1384060.png" alt="YouTube"></a>
            </div>

            <h4 style="margin-top: 20px;">Lokasi Kami</h4>
            <div class="map-embed">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.7412287494103!2d106.98775101450218!3d-6.165398595536295!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e698a315b1926f3%3A0x15898fadc067eab7!2sPT.Tali+Rejeki!5e0!3m2!1sid!2sid!4v1502347306751" 
                    width="100%" height="200" style="border:0;" allowfullscreen="" loading="lazy">
                </iframe>
            </div>
        </div>
    </div>

    <div class="footer-bottom fade-up">
        &copy; <span id="current-year"></span> Insulmart. All rights reserved.
    </div>
</footer>

<!-- Tahun Otomatis -->
<script>
    document.getElementById("current-year").textContent = new Date().getFullYear();
</script>

<!-- Styling Merah Tua -->
<style>
    .footer {
        background-color: #8B0000; /* Merah Tua */
        color: #fffaf0; /* Warna teks putih krem */
        padding: 40px 20px;
        font-family: 'Arial', sans-serif;
    }

    .footer-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 30px;
        max-width: 1200px;
        margin: auto;
    }

    .footer-column h3, .footer-column h4 {
        color: #ffffff;
        margin-bottom: 10px;
    }

    .footer-column p, .footer-column a, .footer-column li {
        color: #f5f5f5;
        font-size: 14px;
        line-height: 1.6;
    }

    .footer-column a:hover {
        color: #ffe082;
        text-decoration: underline;
    }

    .contact-list, .product-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .contact-list li, .product-list li {
        margin-bottom: 8px;
    }

    .wa-only {
        color: #ffd700;
        font-size: 13px;
        margin-left: 5px;
    }

    .social-icons {
        display: flex;
        gap: 10px;
        margin-top: 10px;
    }

    .social-icons img {
        width: 24px;
        height: 24px;
        transition: transform 0.2s ease-in-out;
    }

    .social-icons img:hover {
        transform: scale(1.1);
    }

    .map-embed {
        border-radius: 12px;
        overflow: hidden;
        margin-top: 10px;
    }

    .footer-bottom {
        text-align: center;
        padding-top: 20px;
        font-size: 13px;
        color: #ffdddd;
        border-top: 1px solid #e9967a;
        margin-top: 30px;
    }
</style>
