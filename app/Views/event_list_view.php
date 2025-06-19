<?= $this->include('template/header') ?>

<div class="container mx-auto px-6 py-8">
    <h1 class="text-4xl font-bold text-center text-gray-800 mb-10">Jadwal Event</h1>

    <?php if (empty($events)): ?>
        <div class="text-center text-gray-500 py-16">
            <i class="fas fa-calendar-times fa-3x mb-4"></i>
            <p>Belum ada event yang dijadwalkan untuk saat ini.</p>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach($events as $event): ?>
            <div class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col transition-transform transform hover:-translate-y-2">
                <a href="<?= base_url('events/detail/' . $event['id']) ?>">
                    <img src="<?= base_url('uploads/events/' . $event['gambar_event']) ?>" alt="<?= esc($event['nama_event']) ?>" class="w-full h-56 object-cover">
                </a>
                <div class="p-6 flex-grow flex flex-col">
                    <h2 class="text-xl font-bold text-gray-900 mb-2">
                        <a href="<?= base_url('events/detail/' . $event['id']) ?>" class="hover:text-indigo-600"><?= esc($event['nama_event']) ?></a>
                    </h2>
                    <div class="text-sm text-gray-600 space-y-2 mb-4">
                        <p><i class="fas fa-calendar-alt w-5 mr-1"></i> <?= date('d F Y', strtotime($event['tanggal_event'])) ?></p>
                        <p><i class="fas fa-clock w-5 mr-1"></i> <?= date('H:i', strtotime($event['tanggal_event'])) ?> WIB</p>
                        <p><i class="fas fa-map-marker-alt w-5 mr-1"></i> <?= esc($event['lokasi_event']) ?></p>
                    </div>
                    <div class="mt-auto">
                         <a href="<?= base_url('events/detail/' . $event['id']) ?>" class="font-semibold text-indigo-600 hover:text-indigo-800">Lihat Detail →</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?= $this->include('template/footer') ?>