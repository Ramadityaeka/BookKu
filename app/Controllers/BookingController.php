<?php

namespace App\Controllers;

class BookingController extends BaseController
{
    protected $bookingModel;

    public function __construct()
    {
        $this->bookingModel = new \App\Models\BookingModel();
    }

    public function store()
    {
        $rules = [
            'buku_id' => 'required|numeric',
            'nama_user' => 'required|min_length[3]|max_length[100]',
            'no_hp' => 'required|min_length[10]|max_length[15]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                           ->with('error', $this->validator->getErrors());
        }

        $data = [
            'buku_id' => $this->request->getPost('buku_id'),
            'nama_user' => $this->request->getPost('nama_user'),
            'no_hp' => $this->request->getPost('no_hp')
        ];

        // If user is logged in, associate the booking with their account
        if (session()->get('user_id')) {
            $data['user_id'] = session()->get('user_id');
        }

        try {
            $this->bookingModel->createBooking($data);
            return redirect()->to('/informasi-booking')
                           ->with('success', 'Booking berhasil dibuat! Silahkan tunggu konfirmasi dari admin.');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Terjadi kesalahan saat membuat booking. Silahkan coba lagi.');
        }
    }

    public function info()
    {
        return view('informasi_booking');
    }
}
