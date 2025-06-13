<?php
$content = ob_start();
?>
<?php if (session()->getFlashdata('success')): ?>
<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
    <p><?= session()->getFlashdata('success') ?></p>
</div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
    <p><?= session()->getFlashdata('error') ?></p>
</div>
<?php endif; ?>

<div class="flex justify-between items-center mb-8">
    <h2 class="text-2xl font-bold text-gray-800">Book Management</h2>
    <button onclick="openModal()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2">
        <i class="fas fa-plus"></i>
        <span>Add New Book</span>
    </button>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
    <?php if (empty($articles)): ?>
        <div class="col-span-1 sm:col-span-2 lg:col-span-3 text-center py-8 md:py-12">
            <i class="fas fa-book-open text-4xl md:text-5xl text-gray-300 mb-3 md:mb-4"></i>
            <h3 class="text-lg md:text-xl font-medium text-gray-500">No Books Found</h3>
            <p class="text-sm md:text-base text-gray-500 mt-2">Click the "Add New Book" button to create your first book</p>
        </div>
    <?php else: ?>
        <?php foreach ($articles as $article): ?>
        <div class="article-card bg-white rounded-lg shadow-md overflow-hidden transition-all duration-300">
            <div class="h-48 overflow-hidden">
                <img src="<?= base_url('uploads/' . $article['gambar']) ?>" 
                     alt="<?= esc($article['judul']) ?>" 
                     class="w-full h-full object-cover">
            </div>
            <div class="p-4">
                <h3 class="font-bold text-lg mb-2 text-gray-800"><?= esc($article['judul']) ?></h3>
                <p class="text-gray-600 text-sm mb-4 line-clamp-3"><?= esc(substr($article['deskripsi'], 0, 150)) ?>...</p>
                <div class="flex justify-between items-center">
                    <span class="text-xs text-gray-500">ID: <?= $article['id'] ?></span>
                    <div class="space-x-2">
                        <button onclick="editArticle(<?= $article['id'] ?>)"
                                class="px-3 py-1 bg-blue-100 text-blue-600 rounded text-sm hover:bg-blue-200">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </button>
                        <button onclick="confirmDelete(<?= $article['id'] ?>)" 
                                class="px-3 py-1 bg-red-100 text-red-600 rounded text-sm hover:bg-red-200">
                            <i class="fas fa-trash mr-1"></i> Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<div id="articleModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl">
        <div class="p-6">
            <div class="flex justify-between items-center border-b pb-4">
                <h3 class="text-xl font-semibold" id="modalTitle">Add New Book</h3>
                <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>   
            </div>
            <form id="articleForm" action="<?= base_url('admin/articles/store') ?>" method="POST" enctype="multipart/form-data" class="mt-4">
                <input type="hidden" name="id" id="articleId">
                
                <div class="mb-4">
                    <label for="judul" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="judul" id="judul" required
                           class="mt-1 w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                
                <div class="mb-4">
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700">Sinopsis atau tentang buku</label>
                    <textarea name="deskripsi" id="deskripsi" rows="5" required
                              class="mt-1 w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                </div>
                
                <div class="mb-4">
                    <label for="gambar" class="block text-sm font-medium text-gray-700">Image</label>
                    <input type="file" name="gambar" id="gambar" accept="image/*"
                           class="mt-1 w-full" onchange="previewImage(this);">
                    
                    <div id="imagePreview" class="mt-3 hidden">
                        <img src="" alt="Preview" class="max-h-48 rounded-lg">
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" onclick="closeModal()" 
                            class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit"
                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                        Save Book
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

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
                <p class="text-gray-700">Are you sure you want to delete this book? This action cannot be undone.</p>
            </div>
            
            <form id="deleteForm" action="" method="POST" class="flex justify-end space-x-3 pt-6">
                <button type="button" onclick="closeDeleteModal()" 
                        class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit"
                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700">
                    Delete Book
                </button>
            </form>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();

$scripts = ob_start();
?>
<script>
function resetForm() {
    document.getElementById('articleForm').reset();
    document.getElementById('articleId').value = '';
    document.getElementById('articleForm').action = '<?= base_url('admin/articles/store') ?>';
    document.getElementById('imagePreview').classList.add('hidden');
    // DIUBAH: Teks diubah menjadi Book
    document.getElementById('modalTitle').textContent = 'Add New Book';
    document.getElementById('gambar').required = true;
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
    resetForm();
}

function confirmDelete(id) {
    document.getElementById('deleteForm').action = `<?= base_url('admin/articles/delete/') ?>/${id}`;
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

async function editArticle(id) {
    try {
        const response = await fetch(`<?= base_url('getArticle/') ?>/${id}`);
        if (!response.ok) throw new Error('Failed to fetch book data'); // Pesan error diubah
        
        const article = await response.json();
        
        // Update form
        document.getElementById('articleId').value = article.id;
        document.getElementById('judul').value = article.judul;
        document.getElementById('deskripsi').value = article.deskripsi;
        document.getElementById('articleForm').action = `<?= base_url('admin/articles/update/') ?>/${article.id}`;
        // DIUBAH: Teks diubah menjadi Book
        document.getElementById('modalTitle').textContent = 'Edit Book';
        document.getElementById('gambar').required = false;
        
        // Open modal
        document.getElementById('articleModal').classList.remove('hidden');
    } catch (error) {
        console.error('Error:', error);
        // DIUBAH: Teks diubah menjadi Book
        alert('Failed to load book data');
    }
}
</script>
<?php
$scripts = ob_get_clean();

// Include the layout
echo view('admin/template/view_layout', [
    'title' => $title,
    'content' => $content,
    'scripts' => $scripts // Perbaikan typo dari 'scripts's' menjadi 'scripts'
]);
?>