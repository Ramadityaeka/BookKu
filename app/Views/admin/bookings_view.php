<?= $this->extend('admin/template/view_layout.php') ?>

<?= $this->section('content') ?>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-4 border-b">
        <h3 class="text-lg font-medium text-gray-900">Manajemen Booking</h3>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Booking ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Buku</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kontak</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Booking</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if (empty($bookings)): ?>
                <tr><td colspan="7" class="px-6 py-4 text-center text-gray-500">Belum ada booking.</td></tr>
                <?php else: ?>
                <?php foreach ($bookings as $booking): ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#BK-<?= str_pad($booking['id'], 4, '0', STR_PAD_LEFT) ?></td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <?php if ($booking['gambar']): ?>
                            <div class="flex-shrink-0 h-10 w-10">
                                <img class="h-10 w-10 rounded-sm object-cover" src="<?= base_url('uploads/' . $booking['gambar']) ?>" alt="<?= esc($booking['judul']) ?>">
                            </div>
                            <?php endif; ?>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900"><?= esc($booking['judul']) ?></div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= esc($booking['nama_user']) ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= esc($booking['no_hp']) ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= date('d M Y, H:i', strtotime($booking['tanggal_booking'])) ?></td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="status-badge px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            <?php 
                            switch($booking['status']) {
                                case 'approved': echo 'bg-green-100 text-green-800'; break;
                                case 'pending': echo 'bg-yellow-100 text-yellow-800'; break;
                                case 'denied': echo 'bg-red-100 text-red-800'; break;
                            } 
                            ?>">
                            <?= ucfirst($booking['status']) ?>
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex items-center space-x-2">
                            <select onchange="updateStatus(this, <?= $booking['id'] ?>)" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="pending" <?= $booking['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                                <option value="approved" <?= $booking['status'] == 'approved' ? 'selected' : '' ?>>Approved</option>
                                <option value="denied" <?= $booking['status'] == 'denied' ? 'selected' : '' ?>>Denied</option>
                            </select>
                            <form action="<?= base_url('admin/bookings/delete/' . $booking['id']) ?>" method="post" onsubmit="return confirm('Yakin ingin menghapus booking ini?');">
                                <button type="submit" class="text-red-600 hover:text-red-900 px-2"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
async function updateStatus(select, id) {
    // Diperbarui untuk mengirim data sebagai form, bukan JSON, dan menyertakan CSRF
    const formData = new FormData();
    formData.append('status', select.value);
    formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

    try {
        const response = await fetch(`<?= base_url('admin/bookings/status-update/') ?>/${id}`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (!response.ok) {
            const errorText = await response.text();
            throw new Error('Gagal memperbarui status. Server merespon: ' + errorText);
        }
        
        const result = await response.json();
        
        if (result.success) {
            window.location.reload();
        } else {
            throw new Error(result.message || 'Gagal memperbarui status dari server.');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Terjadi kesalahan: ' + error.message);
    }
}
</script>
<?= $this->endSection() ?>