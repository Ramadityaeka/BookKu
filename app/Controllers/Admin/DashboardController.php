<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    protected $jwpModel;
    protected $bookingModel;

    public function __construct()
    {
        $this->jwpModel = new \App\Models\Jwp_model();
        $this->bookingModel = new \App\Models\BookingModel();
    }    public function index()
    {
        return view('admin/dashboard_view', [
            'title' => 'Admin Dashboard',
            'articles' => $this->jwpModel->findAll()
        ]);
    }

    public function createArticle()
    {
        return view('admin/create_article', [
            'title' => 'Create Article'
        ]);
    }

    public function storeArticle()
    {
        // Validate input
        $rules = [
            'judul' => 'required|min_length[3]|max_length[255]',
            'deskripsi' => 'required',
            'gambar' => [
                'uploaded[gambar]',
                'mime_in[gambar,image/jpg,image/jpeg,image/png]',
                'max_size[gambar,2048]',
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                           ->withInput()
                           ->with('errors', $this->validator->getErrors());
        }

        $img = $this->request->getFile('gambar');
        $newName = $img->getRandomName();
        $img->move(WRITEPATH . 'uploads', $newName);

        $data = [
            'judul' => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'gambar' => $newName,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->jwpModel->insert($data);
        return redirect()->to('/admin/dashboard')
                        ->with('success', 'Article added successfully');
    }

    public function editArticle($id)
    {
        $article = $this->jwpModel->find($id);

        if (!$article) {
            return redirect()->back()
                           ->with('error', 'Article not found');
        }

        return view('admin/edit_article', [
            'title' => 'Edit Article',
            'article' => $article
        ]);
    }

    public function updateArticle($id)
    {
        $rules = [
            'judul' => 'required|min_length[3]|max_length[255]',
            'deskripsi' => 'required'
        ];

        // Only validate image if one was uploaded
        if ($this->request->getFile('gambar')->isValid()) {
            $rules['gambar'] = [
                'uploaded[gambar]',
                'mime_in[gambar,image/jpg,image/jpeg,image/png]',
                'max_size[gambar,2048]'
            ];
        }

        if (!$this->validate($rules)) {
            return redirect()->back()
                           ->withInput()
                           ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'judul' => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Handle image upload if a new image was provided
        if ($this->request->getFile('gambar')->isValid()) {
            $img = $this->request->getFile('gambar');
            $newName = $img->getRandomName();
            $img->move(WRITEPATH . 'uploads', $newName);
            $data['gambar'] = $newName;

            // Delete old image
            $oldImage = $this->jwpModel->find($id)['gambar'];
            if ($oldImage && file_exists(WRITEPATH . 'uploads/' . $oldImage)) {
                unlink(WRITEPATH . 'uploads/' . $oldImage);
            }
        }

        $this->jwpModel->update($id, $data);
        return redirect()->to('/admin/dashboard')
                        ->with('success', 'Article updated successfully');
    }

    public function deleteArticle($id)
    {
        $article = $this->jwpModel->find($id);

        if ($article) {
            // Delete image file if it exists
            if ($article['gambar'] && file_exists(WRITEPATH . 'uploads/' . $article['gambar'])) {
                unlink(WRITEPATH . 'uploads/' . $article['gambar']);
            }

            $this->jwpModel->delete($id);
            return redirect()->to('/admin/dashboard')
                           ->with('success', 'Article deleted successfully');
        }

        return redirect()->back()
                       ->with('error', 'Article not found');
    }
}
