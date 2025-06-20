<?php


namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KatalogModel; 

class DashboardController extends BaseController
{
    protected $katalogModel;

    public function __construct()
    {
        $this->katalogModel = new KatalogModel();
    }

    public function index()
    {
        return view('admin/dashboard_view', [
            'title' => 'Admin Dashboard',
            'articles' => $this->katalogModel->orderBy('created_at', 'DESC')->findAll()
        ]);
    }

    public function storeArticle()
    {
        $rules = [
            'judul' => ['rules' => 'required|min_length[3]', 'errors' => ['required' => 'Judul harus diisi.']],
            'genre' => ['rules' => 'required|max_length[100]', 'errors' => ['required' => 'Genre harus diisi.']],
            'deskripsi' => ['rules' => 'required', 'errors' => ['required' => 'Deskripsi singkat harus diisi.']],
            'tentang_buku' => ['rules' => 'required', 'errors' => ['required' => 'Tentang buku harus diisi.']],
            'sinopsis' => ['rules' => 'required', 'errors' => ['required' => 'Sinopsis harus diisi.']],
            'gambar' => [
                'rules' => 'uploaded[gambar]|max_size[gambar,2048]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Anda harus memilih gambar cover.',
                    'max_size' => 'Ukuran gambar maksimal 2MB.',
                    'is_image' => 'File harus berupa gambar.',
                    'mime_in' => 'Format gambar harus JPG, JPEG, atau PNG.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $img = $this->request->getFile('gambar');
        $newName = $img->getRandomName();
        $img->move(FCPATH . 'uploads', $newName);

        $data = [
            'judul'        => $this->request->getPost('judul'),
            'deskripsi'    => $this->request->getPost('deskripsi'),
            'gambar'       => $newName,
            'genre'        => $this->request->getPost('genre'),
            'tentang_buku' => $this->request->getPost('tentang_buku'),
            'sinopsis'     => $this->request->getPost('sinopsis'),
        ];

        $this->katalogModel->insert($data);
        return redirect()->to('admin/dashboard')->with('success', 'Buku baru berhasil ditambahkan.');
    }

    public function updateArticle($id)
    {
        $rules = [
            'judul' => ['rules' => 'required|min_length[3]', 'errors' => ['required' => 'Judul harus diisi.']],
            'genre' => ['rules' => 'required|max_length[100]', 'errors' => ['required' => 'Genre harus diisi.']],
            'deskripsi' => ['rules' => 'required', 'errors' => ['required' => 'Deskripsi singkat harus diisi.']],
            'tentang_buku' => ['rules' => 'required', 'errors' => ['required' => 'Tentang buku harus diisi.']],
            'sinopsis' => ['rules' => 'required', 'errors' => ['required' => 'Sinopsis harus diisi.']]
        ];

        if ($this->request->getFile('gambar')->isValid()) {
            $rules['gambar'] = 'max_size[gambar,2048]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'judul'        => $this->request->getPost('judul'),
            'deskripsi'    => $this->request->getPost('deskripsi'),
            'genre'        => $this->request->getPost('genre'),
            'tentang_buku' => $this->request->getPost('tentang_buku'),
            'sinopsis'     => $this->request->getPost('sinopsis'),
        ];
        
        $img = $this->request->getFile('gambar');
        if ($img->isValid() && !$img->hasMoved()) {
            $oldImage = $this->katalogModel->find($id)['gambar'];
            if ($oldImage && file_exists(FCPATH . 'uploads/' . $oldImage)) {
                unlink(FCPATH . 'uploads/' . $oldImage);
            }
            $newName = $img->getRandomName();
            $img->move(FCPATH . 'uploads', $newName);
            $data['gambar'] = $newName;
        }

        $this->katalogModel->update($id, $data);
        return redirect()->to('admin/dashboard')->with('success', 'Buku berhasil diperbarui.');
    }

    public function deleteArticle($id)
    {
        $article = $this->katalogModel->find($id);
        if ($article && !empty($article['gambar']) && file_exists(FCPATH . 'uploads/' . $article['gambar'])) {
            unlink(FCPATH . 'uploads/' . $article['gambar']);
        }

        $this->katalogModel->delete($id);
        return redirect()->to('admin/dashboard')->with('success', 'Buku berhasil dihapus.');
    }


     public function getArticle($id)
    {
        $article = $this->katalogModel->find($id);
        if ($article) {
            // Tambahkan URL gambar lengkap ke dalam respons
            $article['gambar_url'] = base_url('uploads/' . $article['gambar']);
            return $this->response->setJSON($article);
        }

        // Jika buku tidak ditemukan, kirim status 404
        return $this->response->setStatusCode(404, 'Article not found');
    }
}
