<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Akun Baru - BookKu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<section class="flex flex-col md:flex-row h-screen items-center">

  <div class="bg-indigo-600 hidden lg:block w-full md:w-1/2 xl:w-2/3 h-screen">
    <img src="https://images.unsplash.com/photo-1481627834876-b7833e8f5570?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=628&q=80" alt="Library" class="w-full h-full object-cover">
  </div>

  <div class="bg-white w-full md:max-w-md lg:max-w-full md:w-1/2 xl:w-1/3 h-screen px-6 lg:px-16 xl:px-12
        flex items-center justify-center">

    <div class="w-full">

        <div class="text-center mb-8">
             <a href="<?= base_url('/') ?>" class="flex items-center justify-center py-2">
                <i class="fas fa-book-open text-indigo-500 mr-2 text-2xl"></i>
                <span class="font-bold text-gray-700 text-3xl">BookKu</span>
            </a>
        </div>


      <h1 class="text-xl md:text-2xl font-bold leading-tight">Buat akun baru</h1>

      <?php if (session()->getFlashdata('error')): ?>
        <div class="mt-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
            <p class="font-bold">Error</p>
            <p><?= session()->getFlashdata('error') ?></p>
        </div>
      <?php endif; ?>

      <?php if (session()->getFlashdata('errors')): ?>
        <div class="mt-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
            <p class="font-bold">Mohon periksa error berikut:</p>
            <ul class="list-disc pl-5 mt-2">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach ?>
            </ul>
        </div>
      <?php endif; ?>

      <form class="mt-6" action="<?= base_url('register/process') ?>" method="POST">
        <?= csrf_field() ?>
        <div>
          <label class="block text-gray-700">Username</label>
          <input type="text" name="username" id="username" placeholder="Masukkan Username" class="w-full px-4 py-3 rounded-lg bg-gray-200 mt-2 border focus:border-indigo-500 focus:bg-white focus:outline-none" autofocus autocomplete="off" required value="<?= old('username') ?>">
        </div>
        
        <div class="mt-4">
            <label class="block text-gray-700">Nomor Telepon</label>
            <input type="text" name="no_hp" id="no_hp" placeholder="Masukkan Nomor Telepon (Contoh: 08123...)" class="w-full px-4 py-3 rounded-lg bg-gray-200 mt-2 border focus:border-indigo-500 focus:bg-white focus:outline-none" autocomplete="off" required value="<?= old('no_hp') ?>">
        </div>

        <div class="mt-4">
          <label class="block text-gray-700">Password</label>
          <input type="password" name="password" id="password" placeholder="Minimal 6 karakter" minlength="6" class="w-full px-4 py-3 rounded-lg bg-gray-200 mt-2 border focus:border-indigo-500 focus:bg-white focus:outline-none" required>
        </div>
        
        <div class="mt-4">
          <label class="block text-gray-700">Konfirmasi Password</label>
          <input type="password" name="password_confirm" id="password_confirm" placeholder="Ketik ulang password" minlength="6" class="w-full px-4 py-3 rounded-lg bg-gray-200 mt-2 border focus:border-indigo-500 focus:bg-white focus:outline-none" required>
        </div>

        <button type="submit" class="w-full block bg-indigo-600 hover:bg-indigo-700 focus:bg-indigo-400 text-white font-semibold rounded-lg px-4 py-3 mt-6">Daftar Akun</button>
      </form>

      <hr class="my-6 border-gray-300 w-full">
      
      <p class="mt-6 text-center">
        Sudah punya akun?
        <a href="<?= base_url('login') ?>" class="text-indigo-500 hover:text-indigo-700 font-semibold">
          Masuk di sini
        </a>
      </p>

    </div>
  </div>

</section>

</body>
</html>