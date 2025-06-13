<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi Booking - Bookku</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#4F46E5',
                        secondary: '#10B981',
                        danger: '#EF4444'
                    }
                }
            }
        }
    </script>
    <style>
        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-weight: 600;
            font-size: 0.875rem;
            color: white;
        }
        .status-pending {
            background-color: #3B82F6; /* Biru */
            animation: pulse 2s infinite;
        }
        .status-approved {
            background-color: #10B981; /* Hijau */
        }
        .status-denied {
            background-color: #EF4444; /* Merah */
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
        .book-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <?php include(APPPATH . 'Views/template/header.php'); ?>

    <div class="container mx-auto px-4 py-8">
        <div class="mb-10 text-center">
            <h1 class="text-3xl md:text-4xl font-bold text-indigo-700 mb-2">Status Booking Anda</h1>
            <p class="text-gray-600 max-w-2xl mx-auto">Lihat status peminjaman buku Anda. Kami akan mengirim notifikasi ketika status berubah.</p>
        </div>

        <?php if(session()->getFlashdata('success')): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p><?= session()->getFlashdata('success') ?></p>
            </div>
        <?php endif; ?>

        <?php
        // DIKEMBALIKAN: Menggunakan query database asli Anda
        $db = \Config\Database::connect();
        $query = $db->query("
            SELECT b.*, k.judul, k.gambar 
            FROM booking b 
            JOIN katalog k ON b.buku_id = k.id 
            ORDER BY b.tanggal_booking DESC
        ");
        $bookings = $query->getResultArray();
        ?>

        <?php if (empty($bookings)): ?>
            <div class="text-center py-8">
                <div class="mb-4">
                    <i class="fas fa-book-open text-gray-400 text-5xl"></i>
                </div>
                <h3 class="text-xl font-medium text-gray-900">Belum ada booking</h3>
                <p class="text-gray-500 mt-2">Silakan kembali ke katalog untuk melakukan booking buku.</p>
                <a href="<?= base_url('catalog') ?>" class="inline-block mt-4 px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                    Lihat Katalog
                </a>
            </div>
        <?php else: ?>
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
                <div class="relative w-full md:w-64">
                    <input type="text" id="searchInput" placeholder="Cari judul buku..." 
                           class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
                <div>
                    <select id="statusFilter" class="w-full md:w-auto px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="all">Semua Status</option>
                        <option value="pending">Menunggu</option>
                        <option value="approved">Disetujui</option>
                        <option value="denied">Ditolak</option>
                    </select>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($bookings as $booking): ?>
                <div class="booking-card bg-white rounded-lg shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl">
                    <div class="relative h-48">
                        <?php if ($booking['gambar']): ?>
                            <img class="w-full h-full object-cover" 
                                 src="<?= base_url('uploads/' . $booking['gambar']) ?>" 
                                 alt="<?= esc($booking['judul']) ?>"
                                 onerror="this.onerror=null; this.src='<?= base_url('uploads/default-book.jpg') ?>'; this.classList.add('object-contain', 'p-4', 'bg-gray-50');">
                        <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center bg-gray-50">
                                <i class="fas fa-book text-gray-300 text-5xl"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="p-4">
                        <h3 class="book-title text-xl font-semibold text-gray-900 truncate"><?= esc($booking['judul']) ?></h3>
                        <p class="text-gray-600 text-sm mt-2">Dipesan oleh: <?= esc($booking['nama_user']) ?></p>
                        <p class="text-gray-600 text-sm">Kontak: <?= esc($booking['no_hp']) ?></p>
                        <p class="text-gray-600 text-sm">Tanggal Booking: <?= date('d M Y H:i', strtotime($booking['tanggal_booking'])) ?> WIB</p>
                        <div class="mt-4">
                            <span class="status-badge status-<?= $booking['status'] ?>" data-status="<?= $booking['status'] ?>">
                                <?php 
                                    $statusText = [
                                        'pending' => 'Menunggu',
                                        'approved' => 'Disetujui',
                                        'denied' => 'Ditolak'
                                    ];
                                    echo $statusText[$booking['status']] ?? ucfirst($booking['status']);
                                ?>
                            </span>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                
                <div id="searchEmptyState" class="hidden col-span-full text-center py-12">
                     <i class="fas fa-search text-gray-400 text-5xl mb-4"></i>
                     <h3 class="text-xl font-medium text-gray-900">Tidak ada booking yang cocok</h3>
                     <p class="text-gray-500 mt-2">Coba ubah filter atau kata kunci pencarian Anda.</p>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Cek jika elemen filter ada di halaman
        const searchInput = document.getElementById('searchInput');
        if (!searchInput) return; // Hentikan jika tidak ada elemen filter

        const statusFilter = document.getElementById('statusFilter');
        const bookingCards = document.querySelectorAll('.booking-card');
        const emptyState = document.getElementById('searchEmptyState');
        let debounceTimeout;

        function filterBookings() {
            const searchText = searchInput.value.toLowerCase().trim();
            const statusValue = statusFilter.value;
            let visibleCount = 0;

            bookingCards.forEach(card => {
                const title = card.querySelector('.book-title').textContent.toLowerCase();
                const status = card.querySelector('.status-badge').dataset.status;
                
                const matchesSearch = title.includes(searchText);
                const matchesStatus = statusValue === 'all' || status === statusValue;

                if (matchesSearch && matchesStatus) {
                    card.style.display = '';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            if (visibleCount === 0 && bookingCards.length > 0) {
                emptyState.classList.remove('hidden');
            } else {
                emptyState.classList.add('hidden');
            }
        }

        searchInput.addEventListener('input', () => {
            clearTimeout(debounceTimeout);
            debounceTimeout = setTimeout(filterBookings, 300);
        });

        statusFilter.addEventListener('change', filterBookings);
    });
    </script>
</body>
</html>