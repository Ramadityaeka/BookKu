<?php

namespace App\Controllers;

use App\Models\KatalogModel;

class Pages extends BaseController
{
    protected $katalogModel;

    public function __construct()
    {
        $this->katalogModel = new KatalogModel();
    }

    // Halaman Katalog Buku
    public function book()
    {
        $data = [
            'title' => 'Katalog Buku',
            'buku' => $this->katalogModel->findAll()
        ];
        return view('book', $data);
    }

    // Halaman Detail Buku
    public function detail($id)
    {
        $data = [
            'title' => 'Detail Buku',
            'buku' => $this->katalogModel->find($id)
        ];

        // jika buku tidak ditemukan
        if (empty($data['buku'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Buku dengan ID ' . $id . ' tidak ditemukan.');
        }

        return view('detail', $data);
    }

    // Halaman Kontak
    public function kontak()
    {
        $data = [
            'title' => 'Kontak Kami'
        ];
        return view('kontak', $data);
    }
}