<?php

namespace App\Models;

use CodeIgniter\Model;
use DateTime;
use DateInterval;

class BookingModel extends Model
{
    protected $table = 'booking';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    
    protected $allowedFields = [
        'user_id', 
        'buku_id', 
        'nama_user', 
        'no_hp', 
        'status', 
        'tanggal_booking', 
        'batas_waktu_pengambilan'
    ];
    
    protected $useTimestamps = true;
    protected $createdField = 'tanggal_booking';
    protected $updatedField = '';

    /**
     * FUNGSI INI UNTUK ADMIN: Mengambil semua data booking.
     */
    public function getAllBookings()
    {
        return $this->select('booking.*, katalog.judul, katalog.gambar, users.username')
                    ->join('katalog', 'katalog.id = booking.buku_id')
                    ->join('users', 'users.id = booking.user_id', 'left')
                    ->orderBy('booking.tanggal_booking', 'DESC')
                    ->findAll();
    }

    /**
     * FUNGSI INI UNTUK USER: Mengambil data booking berdasarkan ID user yang login.
     * Ini adalah fungsi kunci untuk solusi kita.
     */
    public function getBookingsByUser($userId)
    {
        return $this->select('booking.*, katalog.judul, katalog.gambar')
                    ->join('katalog', 'katalog.id = booking.buku_id')
                    ->where('booking.user_id', $userId)
                    ->orderBy('booking.tanggal_booking', 'DESC')
                    ->findAll();
    }

    public function createBooking($data)
    {
        // ... (fungsi createBooking tidak berubah) ...
        $data['status'] = 'pending';
        $now = new DateTime();
        $data['tanggal_booking'] = $now->format('Y-m-d H:i:s');
        $now->add(new DateInterval('PT24H'));
        $data['batas_waktu_pengambilan'] = $now->format('Y-m-d H:i:s');
        return $this->insert($data);
    }

    public function updateStatus($id, $status)
    {
        return $this->update($id, ['status' => $status]);
    }
}