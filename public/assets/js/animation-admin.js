document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.getElementById('toggleSidebar');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const navLinks = document.querySelectorAll('#navLinks .nav-link');
    
    // Create overlay element
    const overlay = document.createElement('div');
    overlay.classList.add('overlay');
    document.body.appendChild(overlay);

    // Function to close sidebar
    function closeSidebar() {
        sidebar.classList.add('collapsed');
        mainContent.classList.remove('expanded');
        overlay.classList.remove('show');
        if (window.innerWidth <= 768) {
            sidebar.classList.remove('show');
        }
    }

    // Function to toggle sidebar
    function toggleSidebar() {
        sidebar.classList.toggle('collapsed');
        mainContent.classList.toggle('expanded');
        
        if (window.innerWidth <= 768) {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        }
    }

    // Toggle button click handler
    toggleBtn.addEventListener('click', toggleSidebar);

    // Overlay click handler (closes sidebar)
    overlay.addEventListener('click', closeSidebar);

    // Handle window resize
    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            if (window.innerWidth > 768) {
                overlay.classList.remove('show');
                sidebar.classList.remove('show');
            }
        }, 250);
    });

    // Navigation links click handler
    navLinks.forEach(link => {
        link.addEventListener('click', function () {
            navLinks.forEach(l => l.classList.remove('active'));
            this.classList.add('active');
            
            // Close sidebar on mobile when a link is clicked
            if (window.innerWidth <= 768) {
                closeSidebar();
            }
        });
    });

    // Handle escape key to close sidebar on mobile
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && window.innerWidth <= 768) {
            closeSidebar();
        }
    });
});