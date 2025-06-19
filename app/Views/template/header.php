<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= (isset($title)) ? esc($title) : 'BookKu' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;  
            overflow: hidden;
        }
    </style>
</head>
<body class="bg-gray-100">

<nav class="bg-white shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between">
            <div class="flex space-x-7">
                <div>
                    <a href="<?= base_url('/') ?>" class="flex items-center py-4 px-2">
                        <i class="fas fa-book-open text-indigo-500 mr-2"></i>
                        <span class="font-semibold text-gray-500 text-lg">BookKu</span>
                    </a>
                </div>
                <div class="hidden md:flex items-center space-x-1">
                    <a href="<?= base_url('/') ?>" class="py-4 px-2 text-gray-500 font-semibold hover:text-indigo-500 transition duration-300">Home</a>
                    <a href="<?= base_url('events') ?>" class="py-4 px-2 text-gray-500 font-semibold hover:text-indigo-500 transition duration-300">Event</a>
                    <a href="<?= base_url('kontak') ?>" class="py-4 px-2 text-gray-500 font-semibold hover:text-indigo-500 transition duration-300">Kontak</a>
                </div>
            </div>
            <div class="hidden md:flex items-center space-x-3 ">
                <?php if (session()->get('isLoggedIn')): ?>
                    
                    <?php if(session()->get('role') == 'admin'): ?>
                        <a href="<?= base_url('admin/dashboard') ?>" class="py-2 px-3 font-medium text-white bg-green-500 rounded hover:bg-green-400 transition duration-300 flex items-center">
                            <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                        </a>
                    <?php endif; ?>
                    <span class="py-2 px-2 font-semibold text-gray-500">Halo, <?= esc(session()->get('username')) ?>!</span>

                    <?php if(session()->get('role') == 'user'): ?>
                        <a href="<?= base_url('informasi-booking') ?>" class="py-2 px-2 font-medium text-gray-500 rounded hover:bg-gray-200 hover:text-indigo-500 transition duration-300">Status Booking</a>
                    <?php endif; ?>
                    <a href="<?= base_url('logout') ?>" class="py-2 px-2 font-medium text-white bg-red-500 rounded hover:bg-red-400 transition duration-300">Logout</a>
                <?php else: ?>
                    <a href="<?= base_url('login') ?>" class="py-2 px-2 font-medium text-gray-500 rounded hover:bg-gray-200 hover:text-indigo-500 transition duration-300">Login</a>
                    <a href="<?= base_url('register') ?>" class="py-2 px-4 font-medium text-white bg-indigo-500 rounded hover:bg-indigo-400 transition duration-300">Register</a>
                <?php endif; ?>
            </div>
            <div class="md:hidden flex items-center">
                <button class="outline-none mobile-menu-button">
                <svg class=" w-6 h-6 text-gray-500 hover:text-indigo-500 "
                    x-show="!showMenu"
                    fill="none"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            </div>
        </div>
    </div>
    <div class="hidden mobile-menu">
        <ul class="">
            <li class="active"><a href="<?= base_url('/') ?>" class="block text-sm px-2 py-4 text-white bg-indigo-500 font-semibold">Home</a></li>
            <li><a href="<?= base_url('catalog') ?>" class="block text-sm px-2 py-4 hover:bg-indigo-500 transition duration-300">Katalog</a></li>
            <li><a href="<?= base_url('kontak') ?>" class="block text-sm px-2 py-4 hover:bg-indigo-500 transition duration-300">Kontak</a></li>
            
            <hr class="my-2 border-gray-200">

            <?php if (session()->get('isLoggedIn')): ?>
                <li class="px-2 py-2 font-semibold text-gray-700">Halo, <?= esc(session()->get('username')) ?>!</li>
                
                <?php if(session()->get('role') == 'admin'): ?>
                <li><a href="<?= base_url('admin/dashboard') ?>" class="block text-sm px-2 py-4 bg-green-500 text-white font-semibold">
                    <i class="fas fa-tachometer-alt mr-2"></i>Kembali ke Dashboard
                </a></li>
                <?php endif; ?>
                <?php if(session()->get('role') == 'user'): ?>
                    <li><a href="<?= base_url('informasi-booking') ?>" class="block text-sm px-2 py-4 hover:bg-indigo-500 transition duration-300">Status Booking</a></li>
                <?php endif; ?>
                <li><a href="<?= base_urL('logout') ?>" class="block text-sm px-2 py-4 text-red-500 font-bold hover:bg-red-100 transition duration-300">Logout</a></li>
            <?php else: ?>
                <li><a href="<?= base_url('login') ?>" class="block text-sm px-2 py-4 hover:bg-indigo-500 transition duration-300">Login</a></li>
                <li><a href="<?= base_url('register') ?>" class="block text-sm px-2 py-4 hover:bg-indigo-500 transition duration-300">Register</a></li>
            <?php endif; ?>
        </ul>
    </div>
    <script>
        const btn = document.querySelector("button.mobile-menu-button");
        const menu = document.querySelector(".mobile-menu");

        btn.addEventListener("click", () => {
            menu.classList.toggle("hidden");
        });
    </script>
</nav>

<main class="container mx-auto p-6">
       
    <?php if (session()->getFlashdata('error')): ?>
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md" role="alert">
        <p class="font-bold">Akses Ditolak!</p>
        <p><?= session()->getFlashdata('error') ?></p>
    </div>
    <?php endif; ?>
