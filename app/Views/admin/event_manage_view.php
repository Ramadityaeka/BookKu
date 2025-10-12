<?= $this->extend('admin/template/view_layout.php') ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>
<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r-md" role="alert">
    <p><?= session()->getFlashdata('success') ?></p>
</div>
<?php endif; ?>
<?php if (session()->getFlashdata('errors')): ?>
<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r-md" role="alert">
    <h4 class="font-bold">Gagal! Mohon periksa error berikut:</h4>
    <ul class="list-disc pl-5 mt-2">
    <?php foreach (session()->getFlashdata('errors') as $error): ?>
        <li><?= esc($error) ?></li>
    <?php endforeach ?>
    </ul>
</div>
<?php endif; ?>

<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Manajemen Event</h2>
    <button onclick="openModal()" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
        <i class="fas fa-plus"></i> Tambah Event Baru
    </button>
</div>

<div class="bg-white rounded-lg shadow overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Event</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Lokasi</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <?php if (empty($events)): ?>
                <tr><td colspan="4" class="px-6 py-12 text-center text-gray-500">Belum ada data event.</td></tr>
            <?php else: ?>
                <?php foreach ($events as $event): ?>
                <tr>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-16 w-24">
                                <img class="h-16 w-24 rounded-md object-cover" src="<?= base_url('uploads/events/' . $event['gambar_event']) ?>" alt="">
                            </div>
                            <div class="ml-4 font-medium text-gray-900"><?= esc($event['nama_event']) ?></div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500"><?= date('d M Y, H:i', strtotime($event['tanggal_event'])) ?></td>
                    <td class="px-6 py-4 text-sm text-gray-500"><?= esc($event['lokasi_event']) ?></td>
                    <td class="px-6 py-4 text-center text-sm font-medium">
                        <button onclick="editEvent(<?= $event['id'] ?>)" class="text-indigo-600 hover:text-indigo-900">Edit</button>
                        <form action="<?= base_url('admin/events/delete/' . $event['id']) ?>" method="post" class="inline ml-4" onsubmit="return confirm('Anda yakin ingin menghapus event ini?');">
                            <?= csrf_field() ?>
                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>


<div id="eventModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl max-h-screen overflow-y-auto">
        <div class="sticky top-0 bg-white p-6 border-b flex justify-between items-center">
            <h3 class="text-xl font-semibold" id="modalTitle">Tambah Event Baru</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">&times;</button>
        </div>
        <form id="eventForm" action="" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
            <?= csrf_field() ?>
            <input type="hidden" name="id" id="eventId">
            <div>
                <label for="nama_event" class="block text-sm font-medium text-gray-700">Nama Event</label>
                <input type="text" name="nama_event" id="nama_event" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div>
                <label for="tanggal_event" class="block text-sm font-medium text-gray-700">Waktu & Tanggal</label>
                <input type="datetime-local" name="tanggal_event" id="tanggal_event" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div>
                <label for="lokasi_event" class="block text-sm font-medium text-gray-700">Lokasi</label>
                <input type="text" name="lokasi_event" id="lokasi_event" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div>
                <label for="deskripsi_event" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="deskripsi_event" id="deskripsi_event" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required></textarea>
            </div>
            <div>
                <label for="gambar_event" class="block text-sm font-medium text-gray-700">Gambar/Poster Event</label>
                <input type="file" name="gambar_event" id="gambar_event" class="mt-1 block w-full text-sm">
                <img id="imagePreview" src="" alt="Preview" class="mt-2 h-40 hidden rounded">
            </div>
            <div class="pt-4 flex justify-end space-x-2">
                <button type="button" onclick="closeModal()" class="bg-gray-200 px-4 py-2 rounded">Batal</button>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Simpan</button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function resetForm() {
    const form = document.getElementById('eventForm');
    form.reset();
    document.getElementById('eventId').value = '';
    document.getElementById('modalTitle').textContent = 'Tambah Event Baru';
    document.getElementById('imagePreview').classList.add('hidden');
    document.getElementById('gambar_event').required = true;
    form.action = "<?= base_url('admin/events/store') ?>";
}

function openModal() {
    resetForm();
    document.getElementById('eventModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('eventModal').classList.add('hidden');
}

async function editEvent(id) {
    resetForm();
    try {
        const response = await fetch(`<?= base_url('admin/events/get/') ?>/${id}`);
        if (!response.ok) throw new Error('Gagal mengambil data event');
        
        const event = await response.json();
        
        document.getElementById('eventId').value = event.id;
        document.getElementById('nama_event').value = event.nama_event;
        document.getElementById('tanggal_event').value = event.tanggal_event.slice(0, 16); // Format untuk datetime-local
        document.getElementById('lokasi_event').value = event.lokasi_event;
        document.getElementById('deskripsi_event').value = event.deskripsi_event;
        
        const preview = document.getElementById('imagePreview');
        if (event.gambar_url) {
            preview.src = event.gambar_url;
            preview.classList.remove('hidden');
        }
        
        document.getElementById('modalTitle').textContent = 'Edit Event';
        document.getElementById('gambar_event').required = false;
        document.getElementById('eventForm').action = `<?= base_url('admin/events/update/') ?>/${event.id}`;
        document.getElementById('eventModal').classList.remove('hidden');
    } catch (error) {
        console.error('Error:', error);
        alert('Gagal memuat data event untuk diedit.');
    }
}
</script>
<?= $this->endSection() ?>