<?= $this->include('template/header') ?>

<div class="container mx-auto px-6 py-8">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg overflow-hidden">
        <img src="<?= base_url('uploads/events/' . $event['gambar_event']) ?>" alt="<?= esc($event['nama_event']) ?>" class="w-full h-80 object-cover">
        <div class="p-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-4"><?= esc($event['nama_event']) ?></h1>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-600 mb-6">
                <div class="flex items-center">
                    <i class="fas fa-calendar-alt fa-2x text-indigo-500 mr-4"></i>
                    <div>
                        <p class="font-semibold">Tanggal & Waktu</p>
                        <p><?= date('l, d F Y, H:i', strtotime($event['tanggal_event'])) ?> WIB</p>
                    </div>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-map-marker-alt fa-2x text-indigo-500 mr-4"></i>
                    <div>
                        <p class="font-semibold">Lokasi</p>
                        <p><?= esc($event['lokasi_event']) ?></p>
                    </div>
                </div>
            </div>
            <hr class="my-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 mb-3">Deskripsi Event</h2>
                <div class="prose max-w-none text-gray-700 leading-relaxed">
                    <?= nl2br(esc($event['deskripsi_event'])) ?>
                </div>
            </div>
             <div class="mt-8">
                <a href="<?= base_url('events') ?>" class="text-indigo-600 hover:text-indigo-800 font-semibold">← Kembali ke Daftar Event</a>
            </div>
        </div>
    </div>
</div>

<?= $this->include('template/footer') ?>