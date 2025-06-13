<nav class="bg-white shadow-lg relative">
    <!-- Mobile menu overlay -->
    <div id="mobileMenuOverlay" class="fixed inset-0 bg-black opacity-50 z-20 hidden md:hidden"></div>

    <div class="max-w-6xl mx-auto px-4">
        <div class="flex justify-between items-center py-4">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="<?= base_url('/') ?>" class="text-2xl font-bold text-indigo-600 z-30 relative">
                    <i class="fas fa-newspaper mr-2"></i>BookKu
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-6">
                <a href="<?= base_url('/') ?>" class="text-gray-700 hover:text-indigo-600 transition">Home</a>
                <a href="<?= base_url('informasi-booking') ?>" class="text-gray-700 hover:text-indigo-600 transition">Status Booking</a>
                <a href="<?= base_url('Kontak') ?>" class="text-gray-700 hover:text-indigo-600 transition">Kontak</a>
                <?php if (session()->get('logged_in')): ?>
                    <a href="<?= base_url('dashboard') ?>" class="px-4 py-2 text-indigo-600 border border-indigo-600 rounded-md hover:bg-indigo-600 hover:text-white transition">Dashboard</a>
                    <a href="<?= base_url('logout') ?>" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">Logout</a>
                <?php else: ?>
                    <a href="<?= base_url('login') ?>" class="px-4 py-2 text-indigo-600 border border-indigo-600 rounded-md hover:bg-indigo-600 hover:text-white transition">Login</a>
                <?php endif; ?>
            </div>

            <!-- Mobile Navigation Button -->
            <div class="md:hidden flex items-center z-30">
                <button id="mobileMenuButton" class="text-gray-500 hover:text-indigo-600 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobileMenu" class="fixed top-0 right-0 w-64 h-full bg-white shadow-lg transform translate-x-full transition-transform duration-300 ease-in-out z-30 md:hidden">
            <div class="p-6">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-xl font-bold text-indigo-600">Menu</h2>
                    <button id="closeMenuButton" class="text-gray-500 hover:text-indigo-600 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="space-y-4">
                    <a href="<?= base_url('/') ?>" class="block py-2 text-gray-700 hover:text-indigo-600 transition">Home</a>
                    <a href="<?= base_url('informasi-booking') ?>" class="block py-2 text-gray-700 hover:text-indigo-600 transition">Status Booking</a>
                    <a href="<?= base_url('Kontak') ?>" class="block py-2 text-gray-700 hover:text-indigo-600 transition">Kontak</a>
                    <?php if (session()->get('logged_in')): ?>
                        <div class="mt-8 space-y-4">
                            <a href="<?= base_url('dashboard') ?>" class="block w-full px-4 py-2 text-center text-indigo-600 border border-indigo-600 rounded-md hover:bg-indigo-600 hover:text-white transition">Dashboard</a>
                            <a href="<?= base_url('logout') ?>" class="block w-full px-4 py-2 text-center bg-red-600 text-white rounded-md hover:bg-red-700 transition">Logout</a>
                        </div>
                    <?php else: ?>
                        <div class="mt-8">
                            <a href="<?= base_url('login') ?>" class="block w-full px-4 py-2 text-center text-indigo-600 border border-indigo-600 rounded-md hover:bg-indigo-600 hover:text-white transition">Login</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Mobile menu elements
        const mobileMenuButton = document.getElementById('mobileMenuButton');
        const closeMenuButton = document.getElementById('closeMenuButton');
        const mobileMenu = document.getElementById('mobileMenu');
        const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');

        // Open menu function
        function openMenu() {
            mobileMenu.classList.remove('translate-x-full');
            mobileMenuOverlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        // Close menu function
        function closeMenu() {
            mobileMenu.classList.add('translate-x-full');
            mobileMenuOverlay.classList.add('hidden');
            document.body.style.overflow = '';
        }

        // Event listeners
        mobileMenuButton.addEventListener('click', openMenu);
        closeMenuButton.addEventListener('click', closeMenu);
        mobileMenuOverlay.addEventListener('click', closeMenu);

        // Close menu when clicking a link
        document.querySelectorAll('#mobileMenu a').forEach(link => {
            link.addEventListener('click', closeMenu);
        });

        // Close menu on window resize
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768) { // md breakpoint
                closeMenu();
            }
        });
    </script>
</nav>