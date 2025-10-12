<?= $this->extend('admin/template/view_layout.php') ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>
<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r-md" role="alert">
    <p><?= session()->getFlashdata('success') ?></p>
</div>
<?php endif; ?>

<div class="bg-white rounded-lg shadow-lg overflow-hidden">
    <div class="p-6 border-b">
        <h3 class="text-2xl font-bold text-gray-800">Manajemen Booking</h3>
        <p class="text-sm text-gray-500 mt-1">Kelola semua permintaan peminjaman buku dari user.</p>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Booking ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Buku</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Booking</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Batas Pengambilan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if (empty($bookings)): ?>
                    <tr><td colspan="7" class="px-6 py-12 text-center text-gray-500">
                        <div class="flex flex-col items-center">
                            <i class="fas fa-folder-open text-4xl text-gray-300 mb-3"></i>
                            <span>Belum ada data booking.</span>
                        </div>
                    </td></tr>
                <?php else: ?>
                    <?php foreach ($bookings as $booking): ?>
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#BK-<?= str_pad($booking['id'], 4, '0', STR_PAD_LEFT) ?></td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-12 w-10">
                                    <img class="h-12 w-10 rounded-sm object-cover" src="<?= base_url('uploads/' . $booking['gambar']) ?>" alt="<?= esc($booking['judul']) ?>">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900 line-clamp-2"><?= esc($booking['judul']) ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-semibold"><?= esc($booking['username'] ?? $booking['nama_user']) ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= date('d M Y, H:i', strtotime($booking['tanggal_booking'])) ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600 font-medium"><?= date('d M Y, H:i', strtotime($booking['batas_waktu_pengambilan'])) ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <form action="<?= base_url('admin/bookings/status-update/' . $booking['id']) ?>" method="POST" class="m-0">
                                <?= csrf_field() ?>
                                <?php
                                    $status_classes = [
                                        'approved' => 'bg-green-100 text-green-800',
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'denied' => 'bg-red-100 text-red-800'
                                    ];
                                    $current_class = $status_classes[$booking['status']] ?? 'bg-gray-100 text-gray-800';
                                ?>
                                <select name="status" onchange="this.form.submit()" class="px-3 py-1 text-xs font-semibold rounded-full appearance-none <?= $current_class ?>" style="text-align: center;">
                                    <option value="pending" <?= $booking['status'] == 'pending' ? 'selected' : '' ?> class="font-bold bg-yellow-100 text-yellow-800">Pending</option>
                                    <option value="approved" <?= $booking['status'] == 'approved' ? 'selected' : '' ?> class="font-bold bg-green-100 text-green-800">Approved</option>
                                    <option value="denied" <?= $booking['status'] == 'denied' ? 'selected' : '' ?> class="font-bold bg-red-100 text-red-800">Denied</option>
                                </select>
                            </form>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <form action="<?= base_url('admin/bookings/delete/' . $booking['id']) ?>" method="post" onsubmit="return confirm('Anda yakin ingin menghapus booking ini?');" class="inline">
                                <?= csrf_field() ?>
                                <button type="submit" class="text-gray-400 hover:text-red-600 transition-colors duration-200" title="Hapus Booking">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>