<?php

namespace App\Controllers;

use App\Models\KatalogModel;

class Home extends BaseController
{
    protected $katalogModel;

    public function __construct()
    {
        $this->katalogModel = new KatalogModel();
    }

    public function index()
    {
        // Data untuk view
        $data = [
            'title' => 'Selamat Datang di BookKu', // <--- TAMBAHKAN BARIS INI
            'articles' => $this->katalogModel->orderBy('created_at', 'DESC')->findAll(6)
        ];
        
        return view('index', $data);
    }

    public function catalog()
    {
        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $articles = $this->katalogModel->like('judul', $keyword)->orderBy('created_at', 'DESC')->findAll();
        } else {
            $articles = $this->katalogModel->orderBy('created_at', 'DESC')->findAll();
        }
        
        $data = [
            'title' => 'Katalog Buku', // Title untuk halaman katalog
            'articles' => $articles
        ];
        return view('book', $data);
    }
    
    public function detail($id)
    {
        $data['article'] = $this->katalogModel->find($id);

        if (empty($data['article'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Buku tidak ditemukan');
        }

        // Menambahkan title dinamis untuk halaman detail
        $data['title'] = $data['article']['judul']; 

        return view('detail', $data);
    }

    public function kontak()
    {
        $data['title'] = 'Hubungi Kami'; // Title untuk halaman kontak
        return view('kontak', $data);
    }

    // Fungsi ini mungkin masih dibutuhkan oleh dashboard admin
    public function getArticle($id)
    {
        $article = $this->katalogModel->find($id);
        if ($article) {
            $article['gambar_url'] = base_url('uploads/' . $article['gambar']);
            return $this->response->setJSON($article);
        }
        return $this->response->setStatusCode(404, 'Article not found');
    }
}