<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminFilter implements FilterInterface // <-- Nama kelas diubah
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // 1. Cek apakah sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        // 2. Cek apakah perannya adalah 'admin'
        if (session()->get('role') !== 'admin') {
            // Jika bukan admin, lempar ke halaman utama
            return redirect()->to(base_url('/'))->with('error', 'Anda tidak memiliki hak akses untuk mengunjungi halaman ini.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak ada aksi
    }
}