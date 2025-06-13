<?php

namespace App\Controllers;

use App\Models\KatalogModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Session\Session;

class Home extends BaseController
{
    protected $katalogModel;
    protected $userModel;
    protected $session;

    public function __construct()
    {
        $this->katalogModel = new KatalogModel();
        $this->userModel = new UserModel();
        $this->session = session();
    }

    public function index(): string
    {
        $data = [
            'title' => 'Home',
            'articles' => $this->katalogModel->getAllArticles()
        ];
        return view('index', $data); // Asumsi header/footer di-handle oleh layout
    }

    public function login(): string
    {
        return view('login');
    }

    public function authenticate(): RedirectResponse
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        
        $user = $this->userModel->verifyLogin($username, $password);

        if ($user) {
            $this->session->set([
                'user_id'   => $user['id'],
                'username'  => $user['username'],
                'logged_in' => true
            ]);
            return redirect()->to(base_url('admin/dashboard'));
        }

        return redirect()->back()->with('error', 'Invalid login credentials');
    }

    public function logout(): RedirectResponse
    {
        $this->session->destroy();
        return redirect()->to('/');
    }

    // Fungsi dashboard dipindahkan ke Admin/DashboardController.php
    // public function dashboard() { ... }

    public function detail(int $id): string
    {
        $data = [
            'title' => 'Book Detail',
            'article' => $this->katalogModel->getArticle($id)
        ];

        if (empty($data['article'])) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Book not found');
        }

        return view('detail', $data);
    }
    
    // Fungsi CRUD dipindahkan ke Admin/DashboardController.php
    // storeArticle(), editArticle(), updateArticle(), deleteArticle()

    public function getArticle($id)
    {
        if (!$this->session->get('logged_in')) {
             return $this->response->setJSON(['error' => 'Unauthorized'])->setStatusCode(401);
        }

        $article = $this->katalogModel->getArticle($id);
        if ($article) {
            $article['gambar_url'] = base_url('uploads/' . $article['gambar']);
            return $this->response->setJSON($article);
        }
        return $this->response->setJSON(['error' => 'Article not found'])->setStatusCode(404);
    }

    public function kontak(): string
    {
        $data = ['title' => 'Contact Us'];
        return view('kontak', $data);
    }
}