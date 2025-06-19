<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EventModel;

class EventController extends BaseController
{
    // Menampilkan halaman daftar event
    public function index()
    {
        $eventModel = new EventModel();
        $data = [
            'title'  => 'Daftar Event',
            'events' => $eventModel->orderBy('tanggal_event', 'DESC')->findAll(),
        ];
        return view('event_list_view', $data);
    }

    // Menampilkan halaman detail satu event
    public function detail($id)
    {
        $eventModel = new EventModel();
        $event = $eventModel->find($id);

        if (empty($event)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Event tidak ditemukan.');
        }

        $data = [
            'title' => $event['nama_event'],
            'event' => $event,
        ];
        return view('event_detail_view', $data);
    }
}