<!-- components/back-to-top.blade.php -->
<button onclick="scrollToTop()" id="backToTop" title="Kembali ke atas">
  <i class="bi bi-arrow-up-short me-1"></i> Back to Top
</button>

<style>
#backToTop {
  display: none;
  position: fixed;
  bottom: 100px;
  right: 20px;
  z-index: 999;
  background: var(--maroon, #800000);
  color: white;
  border: none;
  padding: 10px 20px;
  font-size: 0.95rem;
  font-weight: 500;
  border-radius: 50px;
  box-shadow: 0 8px 20px rgba(0,0,0,0.2);
  cursor: pointer;
  transition: all 0.3s ease;
  align-items: center;
  gap: 6px;
}
#backToTop:hover {
  background: var(--maroon-hover, #660000);
  transform: translateY(-3px);
}
</style>

  @push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const backToTopBtn = document.getElementById("backToTop");

      const toggleBackToTop = () => {
        if (window.scrollY > 300) {
          backToTopBtn.style.display = "flex";
        } else {
          backToTopBtn.style.display = "none";
        }
      };

      // Check saat pertama kali halaman diload
      toggleBackToTop();

      // Check saat scroll
      window.addEventListener("scroll", toggleBackToTop);

      // Scroll smooth ke atas saat tombol diklik
      window.scrollToTop = function () {
        window.scrollTo({ top: 0, behavior: 'smooth' });
      };
    });
  </script>
@endpush
