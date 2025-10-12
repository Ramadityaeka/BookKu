<?= $this->extend('template/header'); ?>
<?= $this->section('content'); ?>
<div class="container my-5">
    <h1 class="mb-4"><?= esc($title); ?></h1>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
        <?php foreach ($buku as $b) : ?>
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <img src="/img/<?= esc($b['gambar']); ?>" class="card-img-top" alt="<?= esc($b['judul']); ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= esc($b['judul']); ?></h5>
                        <p class="card-text"><small class="text-muted"><?= esc($b['genre']); ?></small></p>
                        <p class="card-text"><?= esc(word_limiter($b['deskripsi'], 15)); ?></p>
                    </div>
                    <div class="card-footer">
                        <a href="/book/detail/<?= $b['id']; ?>" class="btn btn-primary w-100">Lihat Detail</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?= $this->endSection(); ?>