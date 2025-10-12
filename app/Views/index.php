<?= $this->include('template/header') ?>

<body class="bg-gray-50">
    <div class="relative bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
                <svg class="hidden lg:block absolute right-0 inset-y-0 h-full w-48 text-white transform translate-x-1/2" fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
                    <polygon points="50,0 100,0 50,100 0,100" />
                </svg>

                <div class="relative pt-6 px-4 sm:px-6 lg:px-8">
                    </div>

                <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                    <div class="sm:text-center lg:text-left">
                        <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                            <span class="block">Selamat Datang di</span>
                            <span class="block text-indigo-600">BookKu</span>
                        </h1>
                        <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                            Jelajahi dunia tanpa batas melalui koleksi buku dan event literasi kami. Pinjam buku favoritmu atau ikuti event menarik berikutnya.
                        </p>
                        <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                            <div class="rounded-md shadow">
                                <a href="<?= base_url('events') ?>" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg md:px-10">
                                    Lihat Event
                                </a>
                            </div>
                            <div class="mt-3 sm:mt-0 sm:ml-3">
                                <a href="<?= base_url('login') ?>" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 md:py-4 md:text-lg md:px-10">
                                    Login User
                                </a>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
            <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full" src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80" alt="Library">
        </div>
    </div>

    <div class="bg-gray-50 py-12">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-2">Koleksi Buku Terbaru</h2>
            <p class="text-center text-gray-500 mb-10">Buku-buku pilihan yang baru saja kami tambahkan ke dalam koleksi.</p>
            
            <div class="max-w-2xl mx-auto mb-12">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" id="searchInput" placeholder="Cari buku berdasarkan judul atau deskripsi..." class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8" id="booksContainer">
                <?php if (empty($articles)): ?>
                    <div class="lg:col-span-4 md:col-span-2 col-span-1 text-center py-12">
                        <i class="fas fa-book-open text-gray-400 text-5xl mb-4"></i>
                        <h3 class="text-xl font-medium text-gray-900">Koleksi Masih Kosong</h3>
                        <p class="text-gray-500 mt-2">Belum ada buku yang ditambahkan. Silakan cek kembali nanti.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($articles as $book): ?>
                    <div class="book-card bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300 flex flex-col">
                        <a href="<?= base_url('detail/' . $book['id']) ?>" class="block">
                            <div class="relative h-64">
                                <img src="<?= base_url('uploads/' . $book['gambar']) ?>" alt="<?= esc($book['judul']) ?>" class="w-full h-full object-cover" onerror="this.onerror=null; this.src='https://via.placeholder.com/400x600.png?text=BookKu';">
                            </div>
                        </a>
                        <div class="p-5 flex-grow flex flex-col">
                            <h3 class="book-title text-lg font-bold text-gray-800 mb-2 line-clamp-2">
                                <a href="<?= base_url('detail/' . $book['id']) ?>" class="hover:text-indigo-600"><?= esc($book['judul']) ?></a>
                            </h3>
                            <p class="book-description text-sm text-gray-600 mb-4 flex-grow line-clamp-3"><?= esc($book['deskripsi']) ?></p>
                            <div class="mt-auto pt-4 border-t border-gray-100 flex justify-between items-center text-xs text-gray-500">
                                <span>
                                    <i class="fas fa-tag mr-1"></i>
                                    <?= esc($book['genre'] ?? 'Umum') ?>
                                </span>
                                <span class="text-green-600 font-semibold">
                                    <i class="fas fa-check-circle mr-1"></i> Tersedia
                                </span>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <div id="searchEmptyState" class="hidden lg:col-span-4 md:col-span-2 col-span-1 text-center py-12">
                    <i class="fas fa-search text-gray-400 text-5xl mb-4"></i>
                    <h3 class="text-xl font-medium text-gray-900">Tidak ada buku yang ditemukan</h3>
                    <p class="text-gray-500 mt-2">Coba gunakan kata kunci pencarian yang lain.</p>
                </div>
            </div>
        </div>
    </div>


    
    <script>
    // --- SCRIPT PENCARIAN (DEBOUNCE) ---
    const searchInput = document.getElementById('searchInput');
    const booksContainer = document.getElementById('booksContainer');
    const allBooks = Array.from(booksContainer.getElementsByClassName('book-card'));
    const emptyState = document.getElementById('searchEmptyState');
    let debounceTimeout;

    searchInput.addEventListener('input', function(e) {
        clearTimeout(debounceTimeout);
        debounceTimeout = setTimeout(() => {
            const searchText = e.target.value.toLowerCase().trim();
            let visibleBooksCount = 0;

            allBooks.forEach(book => {
                const title = book.querySelector('.book-title').textContent.toLowerCase();
                const description = book.querySelector('.book-description').textContent.toLowerCase();
                
                if (title.includes(searchText) || description.includes(searchText)) {
                    book.style.display = '';
                    visibleBooksCount++;
                } else {
                    book.style.display = 'none';
                }
            });

            if (visibleBooksCount === 0 && allBooks.length > 0) {
                emptyState.classList.remove('hidden');
            } else {
                emptyState.classList.add('hidden');
            }
        }, 300); 
    });
    </script>
</body>

<?= $this->include('template/footer') ?>
</html>