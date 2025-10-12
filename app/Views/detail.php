<?= $this->include('template/header') ?>

<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-12">
        <div class="max-w-5xl mx-auto">
            
            <div class="mb-6">
                <a href="<?= base_url('/') ?>" class="text-gray-500 hover:text-indigo-600 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali ke Koleksi
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="grid grid-cols-1 md:grid-cols-3">
                    
                    <div class="md:col-span-1 p-6">
                        <div class="sticky top-28">
                            <img src="<?= base_url('uploads/' . $article['gambar']) ?>" 
                                 alt="<?= esc($article['judul']) ?>" 
                                 class="w-full h-auto object-cover rounded-lg shadow-lg"
                                 onerror="this.onerror=null; this.src='https://via.placeholder.com/400x600.png/f3f4f6/9ca3af?text=No+Image';">
                        </div>
                    </div>

                    <div class="md:col-span-2 p-8 md:p-10">
                        <span class="inline-block px-3 py-1 bg-indigo-100 text-indigo-800 text-xs font-semibold rounded-full mb-3">
                           <?= esc($article['genre'] ?? 'Umum') ?>
                        </span>
                        <h1 class="text-4xl lg:text-5xl font-extrabold text-gray-900 mb-4"><?= esc($article['judul']) ?></h1>
                        <p class="text-gray-500 mb-8 leading-relaxed"><?= esc($article['deskripsi'] ?? 'Tidak ada deskripsi singkat.') ?></p>
                        
                        <div class="grid grid-cols-2 gap-4 mb-8 text-sm">
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-calendar-alt w-5 text-gray-400 mr-2"></i>
                                <span>Ditambahkan: <?= date('d M Y', strtotime($article['created_at'])) ?></span>
                            </div>
                            <div class="flex items-center text-green-600 font-semibold">
                                <i class="fas fa-check-circle w-5 mr-2"></i>
                                <span>Tersedia untuk Dibooking</span>
                            </div>
                        </div>

                        <div class="mt-8">
                            <?php if (session()->get('isLoggedIn')): ?>
                                <?php if(session()->get('role') == 'user'): ?>
                                    <form action="<?= base_url('booking/store') ?>" method="post">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="buku_id" value="<?= $article['id'] ?>">
                                        <button type="submit" class="w-full bg-indigo-600 text-white py-4 rounded-lg font-semibold hover:bg-indigo-700 transition-transform transform hover:-translate-y-1 shadow-lg hover:shadow-2xl flex items-center justify-center space-x-2">
                                            <i class="fas fa-bookmark"></i>
                                            <span>Booking Buku Ini Sekarang</span>
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <div class="p-4 bg-yellow-100 text-yellow-800 rounded-lg text-center">
                                        <p>Admin tidak dapat melakukan booking.</p>
                                    </div>
                                <?php endif; ?>
                            <?php else: ?>
                                <a href="<?= base_url('login') ?>" class="block w-full text-center bg-gray-800 text-white py-4 rounded-lg font-semibold hover:bg-gray-900 transition-transform transform hover:-translate-y-1 shadow-lg">
                                    Login untuk Melakukan Booking
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-10 grid grid-cols-1 lg:grid-cols-2 gap-10">
                <div class="bg-white p-8 rounded-xl shadow-lg">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Sinopsis</h2>
                    <div class="prose prose-sm max-w-none text-gray-600 leading-relaxed">
                        <?= nl2br(esc($article['sinopsis'] ?? 'Sinopsis untuk buku ini belum tersedia.')) ?>
                    </div>
                </div>
                <div class="bg-white p-8 rounded-xl shadow-lg">
                     <h2 class="text-2xl font-bold text-gray-800 mb-4">Tentang Buku Ini</h2>
                    <div class="prose prose-sm max-w-none text-gray-600 leading-relaxed">
                        <?= nl2br(esc($article['tentang_buku'] ?? 'Informasi lebih lanjut mengenai buku ini belum tersedia.')) ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>

<?= $this->include('template/footer') ?>
</html>