<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - BookKu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .search-box {
            transition: all 0.3s ease;
        }
        .search-box:focus-within {
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }
    </style>
</head>
        <?php include(APPPATH . 'Views/template/header.php'); ?>
<body class="gradient-bg min-h-screen">
    <div class="container mx-auto px-4 py-16">
        <div class="flex flex-col md:flex-row items-center">
            <div class="md:w-1/2 mb-8 md:mb-0">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">Explore Our Book Catalog</h1>
                <p class="text-lg text-gray-600 mb-6">Discover, create and share amazing content with our community. Find the latest posts from your school or organization.</p>
            </div>
            <div class="md:w-1/2">
                <img src="https://images.unsplash.com/photo-1501504905252-473c47e087f8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=774&q=80" alt="Book Catalog" class="rounded-lg shadow-xl w-full h-auto">
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div class="max-w-3xl mx-auto">
            <div class="search-box bg-white p-4 rounded-lg shadow-md">
                <div class="flex">
                    <input type="text" id="searchInput" placeholder="Cari judul buku..." 
                           class="w-full px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-indigo-600">
                    <button type="button" class="px-6 py-2 bg-indigo-600 text-white rounded-r-md hover:bg-indigo-700">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-12">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">Koleksi Buku Terbaru</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="booksContainer">
            <?php if (empty($articles)): ?>
                <div class="lg:col-span-3 md:col-span-2 col-span-1 text-center py-12">
                     <i class="fas fa-book-open text-gray-400 text-5xl mb-4"></i>
                     <h3 class="text-xl font-medium text-gray-900">Belum Ada Buku</h3>
                     <p class="text-gray-500 mt-2">Koleksi kami masih kosong, silakan cek kembali nanti.</p>
                </div>
            <?php else: ?>
                <?php foreach ($articles as $book): ?>
                <div class="book-card bg-white rounded-lg overflow-hidden shadow-md card-hover transition duration-300">
                    <div class="relative h-64">
                        <img src="<?= base_url('uploads/' . $book['gambar']) ?>" 
                             alt="<?= esc($book['judul']) ?>" 
                             class="w-full h-full object-cover"
                             onerror="this.onerror=null; this.src='<?= base_url('uploads/default-book.jpg') ?>'; this.classList.add('object-contain', 'p-4', 'bg-gray-50');">
                        <div class="absolute top-0 right-0 m-2">
                            <span class="px-2 py-1 bg-indigo-100 text-indigo-800 text-xs font-medium rounded">
                                <i class="fas fa-book mr-1"></i> Novel
                            </span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="book-title text-xl font-bold text-gray-800 mb-2"><?= esc($book['judul']) ?></h3>
                        <p class="book-description text-gray-600 mb-4"><?= substr(esc($book['deskripsi']), 0, 150) ?>...</p>
                        <a href="<?= base_url('detail/' . $book['id']) ?>" 
                           class="inline-block px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
                            <i class="fas fa-info-circle mr-1"></i> Detail Buku
                        </a>
                    </div>
                    <div class="px-6 py-4 bg-gray-50 flex justify-between items-center">
                        <span class="text-sm text-gray-600">
                            <i class="far fa-calendar-alt mr-2"></i>
                            Ditambahkan: <?= date('d M Y', strtotime($book['created_at'])) ?>
                        </span>
                        <span class="text-sm text-green-600">
                            <i class="fas fa-check-circle mr-1"></i> Tersedia
                        </span>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <div id="searchEmptyState" class="hidden lg:col-span-3 md:col-span-2 col-span-1 text-center py-12">
                <i class="fas fa-search text-gray-400 text-5xl mb-4"></i>
                <h3 class="text-xl font-medium text-gray-900">Tidak ada buku yang ditemukan</h3>
                <p class="text-gray-500 mt-2">Coba kata kunci pencarian yang lain.</p>
            </div>
        </div>
    </div>

        header

    <script>
    // --- SCRIPT PENCARIAN YANG DISEMPURNAKAN ---
    const searchInput = document.getElementById('searchInput');
    const booksContainer = document.getElementById('booksContainer');
    const allBooks = Array.from(booksContainer.getElementsByClassName('book-card'));
    const emptyState = document.getElementById('searchEmptyState');
    let debounceTimeout;

    searchInput.addEventListener('input', function(e) {
        // Hapus timeout sebelumnya untuk me-reset timer
        clearTimeout(debounceTimeout);

        // Atur timeout baru. Kode di dalamnya hanya akan berjalan setelah 300ms tanpa ketikan baru.
        debounceTimeout = setTimeout(() => {
            const searchText = e.target.value.toLowerCase().trim();
            let visibleBooksCount = 0;

            allBooks.forEach(book => {
                const title = book.querySelector('.book-title').textContent.toLowerCase();
                const description = book.querySelector('.book-description').textContent.toLowerCase();
                
                // Cek apakah judul atau deskripsi mengandung teks pencarian
                if (title.includes(searchText) || description.includes(searchText)) {
                    book.style.display = ''; // Tampilkan kartu buku
                    visibleBooksCount++;
                } else {
                    book.style.display = 'none'; // Sembunyikan kartu buku
                }
            });

            // Tampilkan pesan jika tidak ada buku yang cocok DAN ada buku di halaman
            if (visibleBooksCount === 0 && allBooks.length > 0) {
                emptyState.classList.remove('hidden');
            } else {
                emptyState.classList.add('hidden');
            }
        }, 300); // Waktu tunggu dalam milidetik
    });
    </script>
</body>
</html>