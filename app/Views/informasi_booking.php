<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi Booking - Bookku</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .status-badge {
            padding: 0.25rem 0.75rem; border-radius: 9999px; font-weight: 600;
            font-size: 0.875rem; color: white;
        }
        .status-pending { background-color: #3B82F6; animation: pulse 2s infinite; }
        .status-approved { background-color: #10B981; }
        .status-denied, .status-expired { background-color: #EF4444; }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
        .book-card:hover {
            transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <?php include(APPPATH . 'Views/template/header.php'); ?>

    <div class="container mx-auto px-4 py-8">
        <div class="mb-10 text-center">
            <h1 class="text-3xl md:text-4xl font-bold text-indigo-700 mb-2">Status Booking Anda</h1>
            <p class="text-gray-600 max-w-2xl mx-auto">Lihat status peminjaman buku Anda. Ambil buku sebelum batas waktu berakhir.</p>
        </div>

        <?php if(session()->getFlashdata('success')): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p><?= session()->getFlashdata('success') ?></p>
            </div>
        <?php endif; ?>

        <?php
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
                <i class="fas fa-book-open text-gray-400 text-5xl mb-4"></i>
                <h3 class="text-xl font-medium text-gray-900">Belum ada booking</h3>
                <p class="text-gray-500 mt-2">Silakan kembali ke katalog untuk melakukan booking buku.</p>
                <a href="<?= base_url('/') ?>" class="inline-block mt-4 px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                    Lihat Katalog
                </a>
            </div>
        <?php else: ?>
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
                <div class="relative w-full md:w-64">
                    <input type="text" id="searchInput" placeholder="Cari judul buku..." class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500">
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
                        <img class="w-full h-full object-cover" src="<?= base_url('uploads/' . $booking['gambar']) ?>" alt="<?= esc($booking['judul']) ?>" onerror="this.onerror=null; this.src='<?= base_url('uploads/default-book.jpg') ?>'; this.classList.add('object-contain', 'p-4', 'bg-gray-50');">
                    </div>
                    <div class="p-4 flex flex-col">
                        <h3 class="book-title text-xl font-semibold text-gray-900 truncate"><?= esc($booking['judul']) ?></h3>
                        <p class="text-gray-500 text-sm mt-1">Dipesan oleh: <?= esc($booking['nama_user']) ?></p>
                        
                        <div class="mt-4 border-t pt-4 space-y-2">
                             <div class="text-sm text-gray-600 flex justify-between">
                                <span>Status:</span>
                                <span class="status-badge status-<?= $booking['status'] ?>" data-status="<?= $booking['status'] ?>">
                                    <?php 
                                        $statusText = ['pending' => 'Menunggu', 'approved' => 'Disetujui', 'denied' => 'Ditolak'];
                                        echo $statusText[$booking['status']] ?? ucfirst($booking['status']);
                                    ?>
                                </span>
                            </div>
                            <div class="text-sm text-gray-600 flex justify-between items-center">
                                <span>Batas Waktu:</span>
                                <div class="countdown-timer text-right font-medium" data-deadline="<?= $booking['batas_waktu_pengambilan'] ?>" data-status="<?= $booking['status'] ?>">
                                    <i class="fas fa-spinner fa-spin mr-1"></i>Menghitung...
                                </div>
                            </div>
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
        // Fungsi Countdown Timer
        const countdownTimers = document.querySelectorAll('.countdown-timer');

        const updateCountdowns = () => {
            countdownTimers.forEach(timer => {
                const deadline = new Date(timer.dataset.deadline).getTime();
                const now = new Date().getTime();
                const distance = deadline - now;
                const status = timer.dataset.status;

                // Hanya jalankan countdown jika status masih 'pending'
                if (status === 'pending' && distance > 0) {
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                    
                    timer.innerHTML = `<i class="fas fa-clock text-blue-500 mr-1"></i> Sisa Waktu: ${hours}j ${minutes}m ${seconds}d`;
                    timer.classList.add('text-blue-600');

                } else if (status === 'pending' && distance <= 0) {
                    timer.innerHTML = `<i class="fas fa-times-circle text-red-500 mr-1"></i> Waktu Habis`;
                    timer.classList.add('text-red-600');
                    // Ganti status badge menjadi expired
                    const badge = timer.closest('.booking-card').querySelector('.status-badge');
                    if(badge) {
                        badge.classList.remove('status-pending');
                        badge.classList.add('status-expired');
                        badge.textContent = 'Kedaluwarsa';
                    }
                } else {
                    // Jika status sudah approved atau denied
                    const deadlineDate = new Date(timer.dataset.deadline);
                    const formattedDeadline = deadlineDate.toLocaleString('id-ID', { day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit'});
                    timer.innerHTML = `<i class="fas fa-calendar-check text-gray-500 mr-1"></i> ${formattedDeadline}`;
                    timer.classList.remove('text-blue-600');
                }
            });
        };

        // Jalankan countdown setiap detik
        setInterval(updateCountdowns, 1000);
        updateCountdowns(); // Panggil sekali saat load

        // --- Fungsi Filter & Search (tetap sama) ---
        const searchInput = document.getElementById('searchInput');
        if (!searchInput) return;

        const statusFilter = document.getElementById('statusFilter');
        const bookingCards = document.querySelectorAll('.booking-card');
        const emptyState = document.getElementById('searchEmptyState');
        let debounceTimeout;

        function filterBookings() {
            // ... (logika filter dan search Anda yang sudah bagus tetap di sini)
            const searchText = searchInput.value.toLowerCase().trim();
            const statusValue = statusFilter.value;
            let visibleCount = 0;

            bookingCards.forEach(card => {
                const title = card.querySelector('.book-title').textContent.toLowerCase();
                const status = card.querySelector('.status-badge').dataset.status;
                const matchesSearch = title.includes(searchText);
                const matchesStatus = statusValue === 'all' || status === status;

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