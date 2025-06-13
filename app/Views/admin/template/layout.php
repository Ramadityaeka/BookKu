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
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="sidebar fixed inset-y-0 left-0 bg-white w-64 shadow-lg z-50">
            <div class="flex items-center justify-center h-16 px-4 bg-primary text-white">
                <h1 class="text-xl font-bold">Library Admin</h1>
                <button class="ml-auto md:hidden" id="closeSidebar">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <nav class="mt-6">
                <div class="px-4">
                    <a href="<?= base_url('admin/dashboard') ?>" class="flex items-center px-4 py-3 <?= url_is('admin/dashboard') ? 'bg-indigo-50 text-primary' : 'text-gray-500 hover:bg-indigo-50 hover:text-primary' ?> rounded-lg">
                        <i class="fas fa-tachometer-alt w-5 mr-3"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="<?= base_url('admin/bookings') ?>" class="flex items-center px-4 py-3 <?= url_is('admin/bookings') ? 'bg-indigo-50 text-primary' : 'text-gray-500 hover:bg-indigo-50 hover:text-primary' ?> rounded-lg">
                        <i class="fas fa-calendar-check w-5 mr-3"></i>
                        <span>Bookings</span>
                    </a>
                </div>
            </nav>
            <div class="absolute bottom-0 w-full px-4 py-3 border-t">
                <a href="<?= base_url('logout') ?>" class="flex items-center text-gray-500 hover:text-primary">
                    <i class="fas fa-sign-out-alt w-5 mr-3"></i>
                    <span>Logout</span>
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 ml-64">
            <!-- Top Navigation Bar -->
            <div class="bg-white shadow-md">
                <div class="flex items-center justify-between h-16 px-8">
                    <h2 class="text-xl font-semibold text-gray-800"><?= $title ?? 'Admin Dashboard' ?></h2>
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-600">Welcome, <?= session()->get('username') ?></span>
                        <button class="md:hidden" id="openSidebar">
                            <i class="fas fa-bars text-gray-600 text-xl"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <div class="p-8">
                <?= $this->renderSection('content') ?>
            </div>
        </div>
    </div>

    <script>
        // Mobile menu toggle
        document.getElementById('openSidebar')?.addEventListener('click', () => {
            document.querySelector('.sidebar').classList.add('active');
        });

        document.getElementById('closeSidebar')?.addEventListener('click', () => {
            document.querySelector('.sidebar').classList.remove('active');
        });
    </script>

    <?= $this->renderSection('scripts') ?>
</body>
</html>
