<?php

namespace App\Models;

use CodeIgniter\Model;

class Jwp_model extends Model
{
    protected $table = 'katalog';
    protected $primaryKey = 'id';
    protected $allowedFields = ['judul', 'deskripsi', 'gambar'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Get all articles
    public function getAllArticles()
    {
        return $this->findAll();
    }

    // Get single article
    public function getArticle($id)
    {
        return $this->find($id);
    }

    // Search articles
    public function searchArticles($keyword)
    {
        return $this->like('judul', $keyword)
                    ->orLike('deskripsi', $keyword)
                    ->findAll();
    }

    // Count articles
    public function countArticles()
    {
        return $this->countAll();
    }    // Get book by ID
    public function getBookById($id)
    {
        return $this->select('id, judul as title, deskripsi as description, gambar as image')
                    ->where('id', $id)
                    ->first();
    }
}
