<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\EventModel;

class EventController extends BaseController
{
    protected $eventModel;

    public function __construct()
    {
        $this->eventModel = new EventModel();
    }

    public function index()
    {
        $data = [
            'title'  => 'Manajemen Event',
            'events' => $this->eventModel->orderBy('tanggal_event', 'DESC')->findAll(),
        ];
        return view('admin/event_manage_view', $data);
    }

    public function store()
    {
        $rules = [
            'nama_event'      => 'required|min_length[5]',
            'deskripsi_event' => 'required|min_length[10]',
            'lokasi_event'    => 'required',
            'tanggal_event'   => 'required',
            'gambar_event'    => 'uploaded[gambar_event]|max_size[gambar_event,2048]|is_image[gambar_event]|mime_in[gambar_event,image/jpg,image/jpeg,image/png]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $img = $this->request->getFile('gambar_event');
        $newName = $img->getRandomName();
        // Buat folder 'events' di dalam 'uploads' untuk menyimpan gambar
        $img->move(FCPATH . 'uploads/events', $newName);

        $this->eventModel->save([
            'nama_event'      => $this->request->getPost('nama_event'),
            'deskripsi_event' => $this->request->getPost('deskripsi_event'),
            'lokasi_event'    => $this->request->getPost('lokasi_event'),
            'tanggal_event'   => $this->request->getPost('tanggal_event'),
            'gambar_event'    => $newName,
        ]);

        return redirect()->to('admin/events')->with('success', 'Event baru berhasil ditambahkan.');
    }
    
    public function update($id)
    {
        $rules = [
            'nama_event'      => 'required|min_length[5]',
            'deskripsi_event' => 'required|min_length[10]',
            'lokasi_event'    => 'required',
            'tanggal_event'   => 'required',
        ];
        if ($this->request->getFile('gambar_event')->isValid()) {
            $rules['gambar_event'] = 'max_size[gambar_event,2048]|is_image[gambar_event]|mime_in[gambar_event,image/jpg,image/jpeg,image/png]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $data = [
            'nama_event'      => $this->request->getPost('nama_event'),
            'deskripsi_event' => $this->request->getPost('deskripsi_event'),
            'lokasi_event'    => $this->request->getPost('lokasi_event'),
            'tanggal_event'   => $this->request->getPost('tanggal_event'),
        ];
        
        $img = $this->request->getFile('gambar_event');
        if ($img->isValid() && !$img->hasMoved()) {
            $oldImage = $this->eventModel->find($id)['gambar_event'];
            if ($oldImage && file_exists(FCPATH . 'uploads/events/' . $oldImage)) {
                unlink(FCPATH . 'uploads/events/' . $oldImage);
            }
            $newName = $img->getRandomName();
            $img->move(FCPATH . 'uploads/events', $newName);
            $data['gambar_event'] = $newName;
        }

        $this->eventModel->update($id, $data);
        return redirect()->to('admin/events')->with('success', 'Event berhasil diperbarui.');
    }

    public function delete($id)
    {
        $event = $this->eventModel->find($id);
        if ($event && !empty($event['gambar_event']) && file_exists(FCPATH . 'uploads/events/' . $event['gambar_event'])) {
            unlink(FCPATH . 'uploads/events/' . $event['gambar_event']);
        }

        $this->eventModel->delete($id);
        return redirect()->to('admin/events')->with('success', 'Event berhasil dihapus.');
    }

    public function getEvent($id)
    {
        $event = $this->eventModel->find($id);
        if ($event) {
            $event['gambar_url'] = base_url('uploads/events/' . $event['gambar_event']);
            return $this->response->setJSON($event);
        }
        return $this->response->setStatusCode(404, 'Event not found');
    }
}