</main> <footer class="bg-gray-800 text-white">
    <div class="container mx-auto px-6 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            
            <div class="md:col-span-1">
                <h3 class="text-lg font-bold mb-4">Tentang BookKu</h3>
                <p class="text-gray-400 text-sm leading-relaxed">
                    BookKu adalah platform digital untuk menjelajahi dunia literasi. Temukan buku terbaru, ikuti event menarik, dan jadilah bagian dari komunitas kami.
                </p>
            </div>

            <div>
                <h3 class="text-lg font-bold mb-4">Tautan Cepat</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="<?= base_url('/') ?>" class="text-gray-400 hover:text-white transition-colors">Home</a></li>
                    <li><a href="<?= base_url('events') ?>" class="text-gray-400 hover:text-white transition-colors">Event</a></li>
                    <li><a href="<?= base_url('kontak') ?>" class="text-gray-400 hover:text-white transition-colors">Kontak</a></li>
                    <li><a href="<?= base_url('login') ?>" class="text-gray-400 hover:text-white transition-colors">Login</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-lg font-bold mb-4">Hubungi Kami</h3>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-start">
                        <i class="fas fa-map-marker-alt mt-1 w-5 text-gray-400"></i>
                        <span class="ml-2 text-gray-400">Jl. Literasi No. 123, Jakarta, Indonesia</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-phone mt-1 w-5 text-gray-400"></i>
                        <span class="ml-2 text-gray-400">(021) 123-4567</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-envelope mt-1 w-5 text-gray-400"></i>
                        <span class="ml-2 text-gray-400">kontak@bookku.com</span>
                    </li>
                </ul>
            </div>

            <div>
                <h3 class="text-lg font-bold mb-4">Ikuti Kami</h3>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white transition-colors text-2xl"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors text-2xl"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors text-2xl"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors text-2xl"><i class="fab fa-youtube"></i></a>
                </div>
            </div>

        </div>

        <div class="mt-12 border-t border-gray-700 pt-6 text-center text-sm">
            <p class="text-gray-400">&copy; <?= date('Y') ?> BookKu. Semua Hak Cipta Dilindungi.</p>
        </div>
    </div>
</footer>

</body>
</html>