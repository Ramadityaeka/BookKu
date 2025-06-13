<?= $this->extend('admin/template/layout') ?>

<?= $this->section('content') ?>
<!-- Bookings Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-4 border-b">
        <h3 class="text-lg font-medium text-gray-900">Recent Bookings</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Booking ID</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Book</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Booking Date</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if (empty($bookings)): ?>
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">No bookings found</td>
                </tr>
                <?php else: ?>
                <?php foreach ($bookings as $booking): ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        #BK-<?= str_pad($booking['id'], 4, '0', STR_PAD_LEFT) ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <?php if ($booking['gambar']): ?>
                            <div class="flex-shrink-0 h-10 w-10">
                                <img class="h-10 w-10 rounded-sm object-cover" 
                                     src="<?= base_url('uploads/' . $booking['gambar']) ?>" 
                                     alt="<?= esc($booking['judul']) ?>">
                            </div>
                            <?php endif; ?>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900"><?= esc($booking['judul']) ?></div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900"><?= esc($booking['nama_user']) ?></div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <?= esc($booking['no_hp']) ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <?= date('Y-m-d\nH:i', strtotime($booking['tanggal_booking'])) ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            <?php switch($booking['status']) {
                                case 'approved':
                                    echo 'bg-green-100 text-green-800';
                                    break;
                                case 'pending':
                                    echo 'bg-yellow-100 text-yellow-800';
                                    break;
                                case 'denied':
                                    echo 'bg-red-100 text-red-800';
                                    break;
                                default:
                                    echo 'bg-blue-100 text-blue-800';
                            } ?>">
                            <?= ucfirst($booking['status']) ?>
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <select onchange="updateStatus(this, <?= $booking['id'] ?>)" 
                                    class="rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary text-sm">
                                <option value="pending" <?= $booking['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                                <option value="approved" <?= $booking['status'] == 'approved' ? 'selected' : '' ?>>Approved</option>
                                <option value="denied" <?= $booking['status'] == 'denied' ? 'selected' : '' ?>>Denied</option>
                            </select>
                            <button onclick="confirmDelete(<?= $booking['id'] ?>)" 
                                    class="text-red-600 hover:text-red-900">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
        <div class="p-6">
            <div class="flex justify-between items-center border-b pb-4">
                <h3 class="text-xl font-semibold">Confirm Deletion</h3>
                <button onclick="closeDeleteModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="mt-4">
                <p class="text-gray-700">Are you sure you want to delete this booking? This action cannot be undone.</p>
            </div>
            
            <form id="deleteForm" action="" method="POST" class="flex justify-end space-x-3 pt-6">
                <button type="button" onclick="closeDeleteModal()" 
                        class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit"
                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700">
                    Delete Booking
                </button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
async function updateStatus(select, id) {
    try {
        const response = await fetch(`<?= base_url('admin/bookings/status-update/') ?>/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                status: select.value
            })
        });

        if (!response.ok) throw new Error('Failed to update status');

        const result = await response.json();
        if (result.success) {
            // Refresh the page to show updated status
            location.reload();
        } else {
            throw new Error(result.message || 'Failed to update status');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Failed to update booking status');
    }
}

function confirmDelete(id) {
    document.getElementById('deleteForm').action = `<?= base_url('admin/bookings/delete/') ?>/${id}`;
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}
</script>
<?= $this->endSection() ?>