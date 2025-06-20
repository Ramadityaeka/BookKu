<?= $this->extend('admin/template/view_layout') ?>

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

<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
    <h2 class="text-2xl font-bold text-gray-800">Manajemen Buku</h2>
    <button onclick="openModal()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 w-full sm:w-auto">
        <i class="fas fa-plus"></i>
        <span>Tambah Buku Baru</span>
    </button>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php if (empty($articles)): ?>
        <div class="col-span-full text-center py-12">
            <i class="fas fa-book-open text-5xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-medium text-gray-500">Belum Ada Buku</h3>
            <p class="text-gray-500 mt-2">Klik "Tambah Buku Baru" untuk membuat data buku pertama Anda.</p>
        </div>
    <?php else: ?>
        <?php foreach ($articles as $article): ?>
        <div class="article-card bg-white rounded-lg shadow-md overflow-hidden transition-all duration-300 flex flex-col">
            <div class="h-48 overflow-hidden">
                <img src="<?= base_url('uploads/' . $article['gambar']) ?>" alt="<?= esc($article['judul']) ?>" class="w-full h-full object-cover">
            </div>
            <div class="p-4 flex-grow flex flex-col">
                <h3 class="font-bold text-lg mb-2 text-gray-800"><?= esc($article['judul']) ?></h3>
                <p class="text-gray-600 text-sm mb-4 line-clamp-3"><?= esc($article['deskripsi']) ?></p>
                <div class="flex justify-between items-center mt-auto pt-2 border-t">
                    <span class="text-xs text-gray-500">ID: <?= $article['id'] ?></span>
                    <div class="space-x-2">
                        <button onclick="editArticle(<?= $article['id'] ?>)" class="px-3 py-1 bg-blue-100 text-blue-600 rounded text-sm hover:bg-blue-200">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </button>
                        <form action="<?= base_url('admin/articles/delete/' . $article['id']) ?>" method="post" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?');">
                            <?= csrf_field() ?>
                            <button type="submit" class="px-3 py-1 bg-red-100 text-red-600 rounded text-sm hover:bg-red-200">
                                <i class="fas fa-trash mr-1"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<div id="articleModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-start justify-center p-4 z-50 hidden overflow-y-auto">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl my-8">
        <div class="sticky top-0 bg-white border-b px-6 py-4 flex justify-between items-center z-10">
            <h3 class="text-xl font-semibold" id="modalTitle">Tambah Buku Baru</h3>
            <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700 text-2xl leading-none">&times;</button>
        </div>
        <div class="p-6">            
            <form id="articleForm" action="" method="POST" enctype="multipart/form-data" class="space-y-6">
                <?= csrf_field() ?>
                <input type="hidden" name="id" id="articleId">
                
                <!-- Basic Information Section -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-info-circle text-indigo-500 mr-2"></i>
                        Informasi Dasar
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="judul" class="block text-sm font-medium text-gray-700">Judul Buku</label>
                            <input type="text" name="judul" id="judul" required 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="genre" class="block text-sm font-medium text-gray-700">Genre</label>
                            <select name="genre" id="genre" required 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Pilih Genre</option>
                                <option value="Fiksi">Fiksi</option>
                                <option value="Non-Fiksi">Non-Fiksi</option>
                                <option value="Misteri">Misteri</option>
                                <option value="Romance">Romance</option>
                                <option value="Sejarah">Sejarah</option>
                                <option value="Pendidikan">Pendidikan</option>
                                <option value="Anak-anak">Anak-anak</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Description Section -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-file-alt text-indigo-500 mr-2"></i>
                        Deskripsi Buku
                    </h4>
                    <div class="space-y-4">
                        <div>
                            <label for="deskripsi" class="block text-sm font-medium text-gray-700">
                                Deskripsi Singkat
                                <span class="text-gray-500 text-xs ml-1">(Tampil di halaman katalog)</span>
                            </label>
                            <textarea name="deskripsi" id="deskripsi" rows="2" required 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                placeholder="Tuliskan deskripsi singkat untuk ditampilkan di halaman katalog..."></textarea>
                        </div>
                        <div>
                            <label for="tentang_buku" class="block text-sm font-medium text-gray-700">
                                Tentang Buku
                                <span class="text-gray-500 text-xs ml-1">(Informasi detail tentang buku)</span>
                            </label>
                            <textarea name="tentang_buku" id="tentang_buku" rows="4" required 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                placeholder="Jelaskan secara detail mengenai buku ini, termasuk informasi penting seperti penulis, penerbit, tahun terbit, dll..."></textarea>
                        </div>
                        <div>
                            <label for="sinopsis" class="block text-sm font-medium text-gray-700">
                                Sinopsis
                                <span class="text-gray-500 text-xs ml-1">(Ringkasan cerita)</span>
                            </label>
                            <textarea name="sinopsis" id="sinopsis" rows="6" required 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                placeholder="Tuliskan ringkasan cerita atau isi buku..."></textarea>
                        </div>
                    </div>
                </div>

                <!-- Cover Image Section -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-image text-indigo-500 mr-2"></i>
                        Cover Buku
                    </h4>
                    <div class="space-y-4">
                        <div class="flex items-center justify-center w-full">
                            <label for="gambar" class="relative flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <i class="fas fa-cloud-upload-alt text-4xl text-gray-500 mb-4"></i>
                                    <p class="mb-2 text-sm text-gray-500">
                                        <span class="font-semibold">Klik untuk upload</span> atau drag and drop
                                    </p>
                                    <p class="text-xs text-gray-500">PNG, JPG atau JPEG (MAX. 2MB)</p>
                                </div>
                                <input type="file" name="gambar" id="gambar" accept="image/*" class="hidden" onchange="previewImage(this)">
                            </label>
                        </div>
                        <div id="imagePreview" class="hidden">
                            <p class="text-sm text-gray-500 mb-2">Preview Cover:</p>
                            <div class="relative w-40 h-56 mx-auto">
                                <img src="" alt="Preview" class="w-full h-full object-cover rounded-lg shadow-md">
                                <button type="button" onclick="removeImage()" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 shadow-md hover:bg-red-600">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="pt-4 flex justify-end space-x-3 border-t">
                    <button type="button" onclick="closeModal()" 
                        class="px-4 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium hover:bg-gray-50 transition-colors">
                        <i class="fas fa-times mr-2"></i>
                        Batal
                    </button>
                    <button type="submit" 
                        class="px-4 py-2 bg-indigo-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-indigo-700 transition-colors">
                        <i class="fas fa-save mr-2"></i>
                        Simpan Buku
                    </button>
                </div>
            </form>

            <script>
            function removeImage() {
                document.getElementById('gambar').value = '';
                document.getElementById('imagePreview').classList.add('hidden');
                document.getElementById('imagePreview').querySelector('img').src = '';
            }
            
            // Enable custom file input styling
            const fileInput = document.getElementById('gambar');
            const fileLabel = document.querySelector('[for="gambar"]');
            
            fileInput.addEventListener('dragenter', function() {
                fileLabel.classList.add('border-indigo-500');
            });
            
            fileInput.addEventListener('dragleave', function() {
                fileLabel.classList.remove('border-indigo-500');
            });
            </script>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function resetForm() {
    const form = document.getElementById('articleForm');
    form.reset();
    document.getElementById('articleId').value = '';
    document.getElementById('genre').value = '';
    document.getElementById('tentang_buku').value = '';
    document.getElementById('sinopsis').value = '';
    document.getElementById('imagePreview').classList.add('hidden');
    document.getElementById('modalTitle').textContent = 'Tambah Buku Baru';
    document.getElementById('gambar').required = true;
    form.action = "<?= base_url('admin/articles/store') ?>"; 
}

function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('imagePreview');
            preview.querySelector('img').src = e.target.result;
            preview.classList.remove('hidden');
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function openModal() {
    resetForm();
    document.getElementById('articleModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('articleModal').classList.add('hidden');
}

async function editArticle(id) {
    resetForm();
    try {
        const response = await fetch(`<?= base_url('admin/articles/get/') ?>/${id}`); // <-- URL BARU
        if (!response.ok) throw new Error('Gagal mengambil data buku');
        
        const article = await response.json();
        
        document.getElementById('articleId').value = article.id;
        document.getElementById('judul').value = article.judul;
        document.getElementById('deskripsi').value = article.deskripsi;
        document.getElementById('genre').value = article.genre || '';
        document.getElementById('tentang_buku').value = article.tentang_buku || '';
        document.getElementById('sinopsis').value = article.sinopsis || '';
        document.getElementById('modalTitle').textContent = 'Edit Buku';
        document.getElementById('gambar').required = false;

        const preview = document.getElementById('imagePreview');
        if (article.gambar_url) {
            preview.querySelector('img').src = article.gambar_url;
            preview.classList.remove('hidden');
        }
        
        document.getElementById('articleForm').action = `<?= base_url('admin/articles/update/') ?>/${article.id}`; 
        document.getElementById('articleModal').classList.remove('hidden');
    } catch (error) {
        console.error('Error:', error);
        alert('Gagal memuat data buku untuk diedit.');
    }
}
</script>
<?= $this->endSection() ?>