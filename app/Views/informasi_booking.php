<?= $this->include('template/header') ?>

<body class="bg-gray-50">
    <div class="container mx-auto px-6 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Status Booking Saya</h1>

        <?php if (session()->getFlashdata('success')): ?>
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md" role="alert">
            <p><?= session()->getFlashdata('success') ?></p>
        </div>
        <?php endif; ?>

        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Buku</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Booking</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Batas Pengambilan</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php if (empty($bookings)): ?>
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                    <i class="fas fa-folder-open fa-3x mb-3"></i>
                                    <p>Anda belum memiliki riwayat booking.</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($bookings as $booking): ?>
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <img src="<?= base_url('uploads/' . $booking['gambar']) ?>" alt="<?= esc($booking['judul']) ?>" class="w-12 h-16 object-cover rounded-md mr-4">
                                            <span class="font-medium text-gray-900"><?= esc($booking['judul']) ?></span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500"><?= date('d M Y, H:i', strtotime($booking['tanggal_booking'])) ?></td>
                                    <td class="px-6 py-4 text-sm text-red-600 font-semibold"><?= date('d M Y, H:i', strtotime($booking['batas_waktu_pengambilan'])) ?></td>
                                    <td class="px-6 py-4 text-center">
                                        <?php
                                            $status_color = 'bg-gray-100 text-gray-800'; // Default
                                            if ($booking['status'] == 'approved') $status_color = 'font-bold bg-green-100 text-green-800';
                                            if ($booking['status'] == 'pending') $status_color = 'font-bold bg-yellow-100 text-yellow-800';
                                            if ($booking['status'] == 'denied') $status_color = 'font-bold bg-red-100 text-red-800';
                                        ?>
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full <?= $status_color ?>">
                                            <?= ucfirst($booking['status']) ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

<?= $this->include('template/footer') ?>