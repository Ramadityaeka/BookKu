<?php

/**
 * File: Home.php
 * 
 * Controller utama yang menangani semua fitur aplikasi BookKu
 * Termasuk manajemen artikel, autentikasi, dan tampilan halaman
 */

namespace App\Controllers;

use App\Models\Jwp_model;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Session\Session;

class Home extends BaseController
{
    /**
     * @var Jwp_model Model untuk operasi database terkait artikel
     */
    protected $jwpModel;

    /**
     * @var Session Instance dari session untuk manajemen state user
     */
    protected $session;

    /**
     * Constructor untuk inisialisasi model dan session
     */
    public function __construct()
    {
        $this->jwpModel = new Jwp_model();
        $this->session = session();
    }

    /**
     * Menampilkan halaman utama dengan daftar artikel
     * 
     * @return string View yang sudah dirender
     */
    public function index(): string
    {
        $data = [
            'title' => 'Home',
            'articles' => $this->jwpModel->getAllArticles()
        ];

        return view('template/header', $data)
             . view('index', $data)
             . view('template/footer');
    }

    /**
     * Menampilkan halaman login
     * 
     * @return string View halaman login
     */
    public function login(): string
    {
        return view('login');
    }

    /**
     * Memproses autentikasi user
     * 
     * @return RedirectResponse Redirect ke dashboard jika sukses, kembali ke login jika gagal
     */
    public function authenticate(): RedirectResponse
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        
        $db = \Config\Database::connect();
        $user = $db->table('users')
                   ->where('username', $username)
                   ->get()
                   ->getRow();

        if ($user && password_verify($password, $user->password)) {
            $this->session->set([
                'user_id' => $user->id,
                'username' => $user->username,
                'logged_in' => true
            ]);
            return redirect()->to(base_url('admin/dashboard'));
        }

        return redirect()->back()->with('error', 'Invalid login credentials');
    }

    /**
     * Logout dan destroy session
     * 
     * @return RedirectResponse Redirect ke halaman utama
     */
    public function logout(): RedirectResponse
    {
        $this->session->destroy();
        return redirect()->to('/');
    }

    /**
     * Menampilkan dashboard admin
     * 
     * @return string|RedirectResponse View dashboard atau redirect ke login
     */
    public function dashboard()
    {
        if (!$this->session->get('logged_in')) {
            return redirect()->to('login');
        }

        $data = [
            'title' => 'Dashboard',
            'articles' => $this->jwpModel->getAllArticles()
        ];

        return view('admin/dashboard', $data)
             . view('template/footer');
    }

    /**
     * Menampilkan detail artikel
     * 
     * @param int $id ID artikel yang akan ditampilkan
     * @return string View detail artikel
     */
    public function article(int $id): string
    {
        $data = [
            'title' => 'Article Details',
            'article' => $this->jwpModel->getArticle($id)
        ];

        return view('template/header', $data)
             . view('article', $data)
             . view('template/footer');
    }

    /**
     * Menampilkan detail buku
     * 
     * @param int $id ID buku yang akan ditampilkan
     * @return string View detail buku
     */
    public function detail(int $id): string
    {
        $data = [
            'title' => 'Book Detail',
            'article' => $this->jwpModel->getArticle($id)
        ];

        if (empty($data['article'])) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Book not found');
        }

        return view('template/header', $data)
             . view('detail', $data)
             . view('template/footer');
    }

    /**
     * Mencari artikel berdasarkan keyword
     * 
     * @return string|RedirectResponse View hasil pencarian atau redirect dengan error
     */
    public function search()
    {
        $keyword = $this->request->getPost('keyword');
        
        if (empty($keyword)) {
            return redirect()->to('/')->with('error', 'Please enter a search keyword');
        }

        $data = [
            'title' => 'Search Results',
            'articles' => $this->jwpModel->searchArticles($keyword),
            'keyword' => $keyword
        ];

        return view('template/header', $data)
             . view('search_results', $data)
             . view('template/footer');
    }

    /**
     * Menyimpan artikel baru
     * 
     * @return RedirectResponse Redirect dengan status sukses atau error
     */
    public function storeArticle(): RedirectResponse
    {
        if (!$this->session->get('logged_in')) {
            return redirect()->to('login');
        }

        $rules = [
            'judul' => [
                'rules' => 'required|min_length[3]',
                'errors' => [
                    'required' => 'Title is required',
                    'min_length' => 'Title must be at least 3 characters long'
                ]
            ],
            'deskripsi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Content is required'
                ]
            ],
            'gambar' => [
                'rules' => 'uploaded[gambar]|max_size[gambar,2048]|mime_in[gambar,image/jpg,image/jpeg,image/png]|is_image[gambar]',
                'errors' => [
                    'uploaded' => 'Please select an image to upload',
                    'max_size' => 'Image size cannot exceed 2MB',
                    'mime_in' => 'File must be a valid image (JPG/PNG)',
                    'is_image' => 'File must be a valid image'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                           ->withInput()
                           ->with('validation', $this->validator);
        }

        $img = $this->request->getFile('gambar');
        
        if ($img->isValid() && !$img->hasMoved()) {
            $newName = $img->getRandomName();
            $img->move(WRITEPATH . 'uploads', $newName);

            $data = [
                'judul' => $this->request->getPost('judul'),
                'deskripsi' => $this->request->getPost('deskripsi'),
                'gambar' => $newName,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $this->jwpModel->insertArticle($data);
            return redirect()->to('/admin/dashboard')->with('success', 'Article added successfully');
        }

        return redirect()->back()
                       ->withInput()
                       ->with('error', 'Failed to upload image');
    }

    public function editArticle($id)
    {
        if (!$this->session->get('logged_in')) {
            return redirect()->to('login');
        }

        $article = $this->jwpModel->getArticle($id);
        if (!$article) {
            return redirect()->to('dashboard')->with('error', 'Article not found');
        }

        $data = [
            'title' => 'Edit Article',
            'article' => $article
        ];

        return view('admin/dashboard', $data);
    }

    /**
     * Mengupdate artikel yang sudah ada
     * Menangani perubahan data dan upload gambar baru
     * 
     * @param int $id ID artikel yang akan diupdate
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function updateArticle($id)
    {
        // Cek status login
        if (!$this->session->get('logged_in')) {
            return redirect()->to('login');
        }

        // Aturan validasi untuk update artikel
        $rules = [
            'judul' => [
                'rules' => 'required|min_length[3]',
                'errors' => [
                    'required' => 'Title is required',
                    'min_length' => 'Title must be at least 3 characters long'
                ]
            ],
            'deskripsi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Content is required'
                ]
            ]
        ];

        $img = $this->request->getFile('gambar');
        if ($img->isValid() && !$img->hasMoved()) {
            $rules['gambar'] = [
                'rules' => 'max_size[gambar,2048]|mime_in[gambar,image/jpg,image/jpeg,image/png]|is_image[gambar]',
                'errors' => [
                    'max_size' => 'The image size is too large. Maximum size is 2MB',
                    'mime_in' => 'Only JPG, JPEG, and PNG files are allowed',
                    'is_image' => 'The uploaded file is not a valid image'
                ]
            ];
        }

        if (!$this->validate($rules)) {
            return redirect()->back()
                   ->withInput()
                   ->with('errors', $this->validator->getErrors());
        }

        try {
            // Start transaction
            $this->jwpModel->db->transStart();

            $data = [
                'judul' => $this->request->getPost('judul'),
                'deskripsi' => $this->request->getPost('deskripsi')
            ];

            // Handle image upload if new image is provided
            if ($img && $img->isValid()) {
                // Delete old image first
                $article = $this->jwpModel->getArticle($id);
                if ($article && $article['gambar']) {
                    $oldImagePath = WRITEPATH . 'uploads/' . $article['gambar'];
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                // Upload new image
                $newName = $img->getRandomName();
                if (!$img->move(WRITEPATH . 'uploads', $newName)) {
                    throw new \RuntimeException('Failed to upload new image');
                }
                $data['gambar'] = $newName;
            }

            // Update database
            if (!$this->jwpModel->update($id, $data)) {
                throw new \RuntimeException('Failed to update article in database');
            }

            // Complete transaction
            $this->jwpModel->db->transComplete();

            if ($this->jwpModel->db->transStatus() === false) {
                throw new \RuntimeException('Database transaction failed');
            }

            return redirect()->to('dashboard')->with('success', 'Article updated successfully');
        } catch (\Exception $e) {
            log_message('error', '[Article Update] ' . $e->getMessage());
            return redirect()->to('dashboard')->with('error', 'Failed to update article. Please try again.');
        }
    }

    /**
     * Menghapus artikel beserta gambarnya
     * Menggunakan transaksi database untuk memastikan konsistensi data
     * 
     * @param int $id ID artikel yang akan dihapus
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function deleteArticle($id)
    {
        // Cek status login
        if (!$this->session->get('logged_in')) {
            return redirect()->to('login');
        }

        // Verifikasi metode request
        if ($this->request->getMethod() !== 'post') {
            return redirect()->to('dashboard')->with('error', 'Invalid request method');
        }

        // Get the article
        $article = $this->jwpModel->getArticle($id);
        if (!$article) {
            return redirect()->to('dashboard')->with('error', 'Article not found');
        }

        try {
            // Start transaction
            $this->jwpModel->db->transStart();

            // Delete the image file if it exists
            $imagePath = WRITEPATH . 'uploads/' . $article['gambar'];
            if (file_exists($imagePath)) {
                if (!unlink($imagePath)) {
                    throw new \RuntimeException('Failed to delete image file');
                }
            }
            
            // Delete from database
            if (!$this->jwpModel->delete($id)) {
                throw new \RuntimeException('Failed to delete article from database');
            }

            // Complete transaction
            $this->jwpModel->db->transComplete();

            if ($this->jwpModel->db->transStatus() === false) {
                throw new \RuntimeException('Database transaction failed');
            }

            return redirect()->to('dashboard')->with('success', 'Article deleted successfully');
        } catch (\Exception $e) {
            log_message('error', '[Article Deletion] ' . $e->getMessage());
            return redirect()->to('dashboard')->with('error', 'Failed to delete article. Please try again.');
        }
    }

    /**
     * Mengambil data artikel dalam format JSON
     * Digunakan untuk AJAX request pada fitur edit artikel
     * 
     * @param int $id ID artikel yang akan diambil
     * @return \CodeIgniter\HTTP\Response
     */
    public function getArticle($id)
    {
        $article = $this->jwpModel->getArticle($id);
        if ($article) {
            // Tambahkan URL gambar untuk preview
            $article['gambar_url'] = base_url('uploads/' . $article['gambar']);
            return $this->response->setJSON($article);
        }
        return $this->response->setJSON(['error' => 'Article not found'])->setStatusCode(404);
    }
}
