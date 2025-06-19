<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin Dashboard' ?> - BookKu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sidebar { transition: all 0.3s ease; }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.active { transform: translateX(0); }
        }
        .article-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1); }
    </style>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <aside class="sidebar fixed inset-y-0 left-0 bg-white w-64 shadow-lg z-50 transform -translate-x-full md:translate-x-0">
            <div class="flex items-center justify-between h-16 px-4 bg-indigo-600 text-white">
                <h1 class="text-xl font-bold">Admin Panel</h1>
                <button class="md:hidden focus:outline-none" id="closeSidebarBtn">&times;</button>
            </div>
            <nav class="mt-6 px-4 space-y-2">
                <?php $uri_path = service('request')->uri->getPath(); ?>

                <a href="<?= base_url('admin/dashboard') ?>" class="flex items-center px-4 py-3 rounded-lg <?= str_contains($uri_path, 'admin/dashboard') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-gray-500 hover:bg-indigo-50 hover:text-indigo-600' ?>">
                    <i class="fas fa-book w-5 mr-3"></i><span>Manajemen Buku</span>
                </a>
                
                <a href="<?= base_url('admin/events') ?>" class="flex items-center px-4 py-3 rounded-lg <?= str_contains($uri_path, 'admin/events') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-gray-500 hover:bg-indigo-50 hover:text-indigo-600' ?>">
                    <i class="fas fa-calendar-alt w-5 mr-3"></i><span>Manajemen Event</span>
                </a>

                <a href="<?= base_url('admin/bookings') ?>" class="flex items-center px-4 py-3 rounded-lg <?= str_contains($uri_path, 'admin/bookings') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-gray-500 hover:bg-indigo-50 hover:text-indigo-600' ?>">
                    <i class="fas fa-calendar-check w-5 mr-3"></i><span>Manajemen Booking</span>
                </a>
                
                <hr class="my-4">

                <a href="<?= base_url('/') ?>" target="_blank" class="flex items-center px-4 py-3 text-gray-500 hover:bg-indigo-50 hover:text-indigo-600 rounded-lg">
                    <i class="fas fa-external-link-alt w-5 mr-3"></i><span>Lihat Situs Publik</span>
                </a>
            </nav>
            <div class="absolute bottom-0 w-full px-4 py-3 border-t">
                <a href="<?= base_url('logout') ?>" class="flex items-center px-4 py-3 text-gray-500 hover:bg-red-50 hover:text-red-600 rounded-lg">
                    <i class="fas fa-sign-out-alt w-5 mr-3"></i><span>Logout</span>
                </a>
            </div>
        </aside>

        <div class="flex-1 md:ml-64">
            <header class="bg-white shadow-md sticky top-0 z-30">
                <div class="flex items-center justify-between h-16 px-4 md:px-8">
                    <button class="mr-4 md:hidden focus:outline-none" id="openSidebarBtn"><i class="fas fa-bars text-gray-600 text-xl"></i></button>
                    <h2 class="text-xl font-semibold text-gray-800"><?= $title ?? 'Admin Dashboard' ?></h2>
                    <span class="text-gray-600">Welcome, <?= esc(session()->get('username')) ?></span>
                </div>
            </header>
            <main class="p-8">
                <?= $this->renderSection('content') ?>
            </main>
        </div>
    </div>

    <script>
        const sidebar = document.querySelector('.sidebar');
        const openBtn = document.getElementById('openSidebarBtn');
        const closeBtn = document.getElementById('closeSidebarBtn');
        openBtn?.addEventListener('click', () => sidebar.classList.add('active'));
        closeBtn?.addEventListener('click', () => sidebar.classList.remove('active'));
    </script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>