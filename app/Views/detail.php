<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $article['judul'] ?> - Bookku</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <!-- Book Details Card -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="md:flex">
                    <!-- Book Cover -->
                    <div class="md:w-1/3">
                        <div class="relative h-96 md:h-full">
                            <img src="<?= base_url('uploads/' . $article['gambar']) ?>" 
                                 alt="<?= esc($article['judul']) ?>" 
                                 class="w-full h-full object-cover md:object-contain"
                                 onerror="this.onerror=null; this.src='<?= base_url('uploads/default-book.jpg') ?>'; this.classList.add('object-contain', 'p-4', 'bg-gray-50');">
                            <div class="absolute top-4 right-4">
                                <span class="px-3 py-1 bg-green-100 text-green-800 text-sm font-medium rounded-full">
                                    <i class="fas fa-check-circle mr-1"></i> Tersedia
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Book Information -->
                    <div class="md:w-2/3 p-6">
                        <div class="mb-4">
                            <h1 class="text-3xl font-bold text-gray-900 mb-2"><?= esc($article['judul']) ?></h1>
                            <div class="flex items-center text-gray-600 text-sm">
                                <span class="mr-4">
                                    <i class="fas fa-calendar-alt mr-1"></i>
                                    Ditambahkan: <?= date('d M Y', strtotime($article['created_at'])) ?>
                                </span>
                                <span>
                                    <i class="fas fa-book mr-1"></i>
                                    Novel
                                </span>
                            </div>
                        </div>

                        <div class="prose max-w-none mb-8">
                            <h2 class="text-xl font-semibold mb-3">Sinopsis</h2>
                            <?= nl2br(esc($article['deskripsi'])) ?>
                        </div>                        <!-- Book Details Grid -->
                        <div class="grid grid-cols-2 gap-4 mb-6 text-sm">
                            <div>
                                <p class="text-gray-600">Kode Buku</p>
                                <p class="font-medium">BK-<?= str_pad($article['id'], 4, '0', STR_PAD_LEFT) ?></p>
                            </div>
                            <div>
                                <p class="text-gray-600">Kategori</p>
                                <p class="font-medium">Novel</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Status</p>
                                <p class="font-medium text-green-600">
                                    <i class="fas fa-check-circle mr-1"></i> Tersedia
                                </p>
                            </div>
                            <div>
                                <p class="text-gray-600">Lokasi Rak</p>
                                <p class="font-medium">Lantai 1 - Rak A3</p>
                            </div>
                        </div>

                        <!-- Booking Button -->
                        <button onclick="openBookingModal()" 
                                class="w-full md:w-auto flex items-center justify-center space-x-2 px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition duration-200">
                            <i class="fas fa-bookmark"></i>
                            <span>Pinjam Buku Ini</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Book Synopsis Card -->
            <div class="mt-6 bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="p-6">
                    <h2 class="text-2xl font-bold mb-4">Tentang Buku Ini</h2>
                    <div class="prose prose-indigo max-w-none">
                        <?= nl2br(esc($article['deskripsi'])) ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking Modal -->
        <div id="bookingModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background overlay -->
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeBookingModal()"></div>

                <!-- Modal panel -->
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                <div class="flex justify-between items-center mb-6">
                                    <h3 class="text-2xl leading-6 font-bold text-gray-900" id="modal-title">
                                        Form Peminjaman Buku
                                    </h3>
                                    <button onclick="closeBookingModal()" class="text-gray-400 hover:text-gray-500">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>

                                <?php if (session()->getFlashdata('error')): ?>
                                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                                        <?php 
                                        $error = session()->getFlashdata('error');
                                        if (is_array($error)) {
                                            echo '<ul class="list-disc list-inside">';
                                            foreach ($error as $e) {
                                                echo '<li>' . esc($e) . '</li>';
                                            }
                                            echo '</ul>';
                                        } else {
                                            echo esc($error);
                                        }
                                        ?>
                                    </div>
                                <?php endif; ?>                                <!-- Book Info Preview -->
                                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                                    <div class="flex items-center space-x-4">
                                        <img src="<?= base_url('uploads/' . $article['gambar']) ?>" 
                                             alt="<?= esc($article['judul']) ?>"
                                             class="w-16 h-20 object-cover rounded"
                                             onerror="this.onerror=null; this.src='<?= base_url('uploads/default-book.jpg') ?>';">
                                        <div>
                                            <h4 class="font-medium text-gray-900"><?= esc($article['judul']) ?></h4>
                                            <p class="text-sm text-gray-500">Kode: BK-<?= str_pad($article['id'], 4, '0', STR_PAD_LEFT) ?></p>
                                        </div>
                                    </div>
                                </div>

                                <form action="<?= base_url('booking/store') ?>" method="POST" class="space-y-6">
                                    <input type="hidden" name="buku_id" value="<?= $article['id'] ?>">
                                    
                                    <div>
                                        <label for="nama_user" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                                        <input type="text" name="nama_user" id="nama_user" required
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                               placeholder="Masukkan nama lengkap anda">
                                    </div>

                                    <div>
                                        <label for="no_hp" class="block text-sm font-medium text-gray-700">Nomor HP</label>
                                        <div class="mt-1 relative rounded-md shadow-sm">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fas fa-phone text-gray-400"></i>
                                            </div>
                                            <input type="tel" name="no_hp" id="no_hp" required
                                                   pattern="[0-9]{10,15}"
                                                   title="Nomor HP harus berisi 10-15 digit angka"
                                                   placeholder="08xxxxxxxxxx"
                                                   class="block w-full pl-10 rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>
                                        <p class="mt-1 text-sm text-gray-500">
                                            <i class="fas fa-info-circle mr-1"></i>
                                            Nomor HP aktif untuk konfirmasi peminjaman
                                        </p>
                                    </div>

                                    <div class="mt-6 flex flex-col sm:flex-row-reverse gap-3">
                                        <button type="submit"
                                                class="w-full sm:w-auto flex justify-center items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            <i class="fas fa-check mr-2"></i>
                                            Ajukan Peminjaman
                                        </button>
                                        <button type="button" onclick="closeBookingModal()"
                                                class="w-full sm:w-auto flex justify-center items-center px-6 py-3 border border-gray-300 rounded-md shadow-sm text-base font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            <i class="fas fa-times mr-2"></i>
                                            Batal
                                        </button>
                                    </div>
                                </form>

                                <div class="mt-6 border-t pt-4">
                                    <p class="text-sm text-gray-500 flex items-center">
                                        <i class="fas fa-info-circle mr-2 text-indigo-500"></i>
                                        Pengajuan peminjaman akan diproses dalam 1x24 jam
                                    </p>
                                </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    function openBookingModal() {
                        document.getElementById('bookingModal').classList.remove('hidden');
                        document.body.style.overflow = 'hidden';
                    }

                    function closeBookingModal() {
                        document.getElementById('bookingModal').classList.add('hidden');
                        document.body.style.overflow = 'auto';
                    }

                    // Close modal when clicking outside
                    document.getElementById('bookingModal').addEventListener('click', function(e) {
                        if (e.target === this) {
                            closeBookingModal();
                        }
                    });

                    // Close modal with Escape key
                    document.addEventListener('keydown', function(e) {
                        if (e.key === 'Escape' && !document.getElementById('bookingModal').classList.contains('hidden')) {
                            closeBookingModal();
                        }
                    });
                </script>
            </div>
              <!-- Navigation Footer -->
            <div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
                <a href="<?= base_url('/') ?>" 
                   class="w-full sm:w-auto flex items-center justify-center px-6 py-3 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 transition-colors">
                    <i class="fas fa-arrow-left mr-2 text-gray-600"></i>
                    <span>Kembali ke Katalog</span>
                </a>
                <a href="<?= base_url('informasi-booking') ?>" 
                   class="w-full sm:w-auto flex items-center justify-center px-6 py-3 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 transition-colors">
                    <i class="fas fa-history mr-2 text-gray-600"></i>
                    <span>Cek Status Peminjaman</span>
                </a>
            </div>
        </div>
    </div>

    <style>
        /* Add smooth transitions */
        .modal-enter {
            opacity: 0;
            transform: scale(0.9);
        }
        .modal-enter-active {
            opacity: 1;
            transform: scale(1);
            transition: opacity 300ms, transform 300ms;
        }
        .modal-exit {
            opacity: 1;
            transform: scale(1);
        }
        .modal-exit-active {
            opacity: 0;
            transform: scale(0.9);
            transition: opacity 300ms, transform 300ms;
        }
    </style>

    <script>
        // Enable form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const phoneInput = document.getElementById('no_hp');
            const phonePattern = /^08[0-9]{8,13}$/;
            
            if (!phonePattern.test(phoneInput.value)) {
                e.preventDefault();
                alert('Nomor HP harus dimulai dengan 08 dan berisi 10-15 digit angka');
            }
        });
    </script>
</body>
</html>
