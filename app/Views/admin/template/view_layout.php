<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin Dashboard' ?> - BookKu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#4F46E5',
                        secondary: '#10B981',
                        danger: '#EF4444'
                    }
                }
            }
        }
    </script>
    <style>
        .sidebar {
            transition: all 0.3s ease;
        }
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.active {
                transform: translateX(0);
            }
        }
        .modal {
            transition: opacity 0.3s ease;
        }
        .article-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        .image-preview {
            max-height: 200px;
            object-fit: contain;
        }
    </style>
</head>
<body class="bg-gray-100">    <div class="min-h-screen flex">
        <!-- Mobile Overlay -->
        <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden md:hidden"></div>
        
        <!-- Sidebar -->
        <div class="sidebar fixed inset-y-0 left-0 bg-white w-64 shadow-lg z-50 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out">
            <div class="flex items-center justify-between h-16 px-4 bg-primary text-white">
                <h1 class="text-xl font-bold">Library Admin</h1>
                <button class="md:hidden focus:outline-none" id="closeSidebar">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <nav class="mt-6">                <div class="px-4">
                    <a href="<?= base_url('admin/dashboard') ?>" class="flex items-center px-4 py-3 <?= service('request')->uri->getPath() === 'admin/dashboard' ? 'bg-indigo-50 text-primary' : 'text-gray-500 hover:bg-indigo-50 hover:text-primary' ?> rounded-lg">
                        <i class="fas fa-tachometer-alt w-5 mr-3"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="<?= base_url('admin/bookings') ?>" class="flex items-center px-4 py-3 <?= service('request')->uri->getPath() === 'admin/bookings' ? 'bg-indigo-50 text-primary' : 'text-gray-500 hover:bg-indigo-50 hover:text-primary' ?> rounded-lg">
                        <i class="fas fa-calendar-check w-5 mr-3"></i>
                        <span>Bookings</span>
                    </a>
                    <a href="<?= base_url('/') ?>" class="flex items-center px-4 py-3 text-gray-500 hover:bg-indigo-50 hover:text-primary rounded-lg">
                        <i class="fas fa-users w-5 mr-3"></i>
                        <span>View Site</span>
                    </a>
                </div>
            </nav>
            <div class="absolute bottom-0 w-full px-4 py-3 border-t">
                <a href="<?= base_url('logout') ?>" class="flex items-center text-gray-500 hover:text-primary">
                    <i class="fas fa-sign-out-alt w-5 mr-3"></i>
                    <span>Logout</span>
                </a>            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 md:ml-64 transition-margin duration-300 ease-in-out">
            <!-- Top Navigation Bar -->
            <div class="bg-white shadow-md sticky top-0 z-30">
                <div class="flex items-center justify-between h-16 px-4 md:px-8">
                    <div class="flex items-center">
                        <button class="mr-4 md:hidden focus:outline-none" id="openSidebar">
                            <i class="fas fa-bars text-gray-600 text-xl"></i>
                        </button>
                        <h2 class="text-xl font-semibold text-gray-800"><?= $title ?? 'Admin Dashboard' ?></h2>
                    </div>
                    <div class="flex items-center">
                        <span class="hidden md:inline text-gray-600 mr-4">Welcome, <?= session()->get('username') ?></span>
                        <div class="relative group">
                            <button class="md:hidden focus:outline-none">
                                <i class="fas fa-user-circle text-gray-600 text-xl"></i>
                            </button>
                            <div class="md:hidden absolute right-0 mt-2 py-2 w-48 bg-white rounded-md shadow-lg hidden group-focus-within:block">
                                <div class="px-4 py-2 text-sm text-gray-700">Welcome, <?= session()->get('username') ?></div>
                                <a href="<?= base_url('logout') ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <div class="p-8">
                <?= $content ?? '' ?>
            </div>
        </div>
    </div>    <script>
        // Mobile menu toggle
        const sidebar = document.querySelector('.sidebar');
        const overlay = document.getElementById('sidebarOverlay');

        document.getElementById('openSidebar')?.addEventListener('click', () => {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        });

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        document.getElementById('closeSidebar')?.addEventListener('click', closeSidebar);
        overlay?.addEventListener('click', closeSidebar);

        // Handle window resize
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768) { // md breakpoint
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
            }
        });
    </script>

    <?= $scripts ?? '' ?>
</body>
</html>
