<?php

namespace App\Models;

use CodeIgniter\Model;

class KatalogModel extends Model
{
    protected $table = 'katalog';
    protected $primaryKey = 'id';
    
    // DIUBAH: Field baru ditambahkan di sini
    protected $allowedFields = ['judul', 'deskripsi', 'gambar', 'genre', 'tentang_buku', 'sinopsis'];
    
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Get all articles/books
    public function getAllArticles()
    {
        return $this->orderBy('created_at', 'DESC')->findAll();
    }

    // Get single article/book
    public function getArticle($id)
    {
        return $this->find($id);
    }

    // Search articles/books
    public function searchArticles($keyword)
    {
        return $this->like('judul', $keyword)
                    ->orLike('deskripsi', $keyword)
                    ->findAll();
    }

    // Get book by ID (bisa disederhanakan/dihapus jika tidak dipakai khusus)
    public function getBookById($id)
    {
        return $this->select('id, judul, deskripsi, gambar, genre, tentang_buku, sinopsis')
                    ->where('id', $id)
                    ->first();
    }
}