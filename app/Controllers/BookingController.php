<?php

namespace App\Controllers;

use App\Models\BookingModel;

class BookingController extends BaseController
{
    protected $bookingModel;

    public function __construct()
    {
        $this->bookingModel = new BookingModel();
    }

    // Method ini sekarang mengambil data berdasarkan user yang login
    public function info()
    {
        // Pastikan user sudah login dan rolenya 'user'
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'user') {
            return redirect()->to('/login')->with('error', 'Anda harus login untuk melihat halaman ini.');
        }

        $userId = session()->get('user_id');
        $data = [
            'title' => 'Status Booking Saya',
            // Panggil fungsi baru dari model
            'bookings' => $this->bookingModel->getBookingsByUser($userId)
        ];

        return view('informasi_booking', $data);
    }

    // Method ini sekarang membuat booking menggunakan data dari session
    public function store()
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'user') {
            return redirect()->to('/login')->with('error', 'Anda harus login untuk melakukan booking.');
        }
        
        $buku_id = $this->request->getPost('buku_id');

        // Mengambil data user dari session, bukan dari form lagi
        $user_id = session()->get('user_id');
        $nama_user = session()->get('username'); // Nama user diambil dari username
        $no_hp = session()->get('no_hp');

        $data = [
            'buku_id'   => $buku_id,
            'user_id'   => $user_id,
            'nama_user' => $nama_user,
            'no_hp'     => $no_hp,
        ];

        if ($this->bookingModel->createBooking($data)) {
            return redirect()->to('informasi-booking')->with('success', 'Buku berhasil di-booking! Silakan ambil sebelum batas waktu.');
        } else {
            return redirect()->back()->with('error', 'Gagal melakukan booking.');
        }
    }
}