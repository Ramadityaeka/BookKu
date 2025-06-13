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
    
    // Pastikan semua kolom ini ada di tabel 'booking' Anda
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
    protected $updatedField = ''; // updatedField tidak digunakan

    public function getBookings()
    {
        return $this->select('booking.*, katalog.judul, katalog.gambar')
                    ->join('katalog', 'katalog.id = booking.buku_id')
                    ->orderBy('booking.tanggal_booking', 'DESC')
                    ->findAll();
    }

    public function createBooking($data)
    {
        // Atur status awal
        $data['status'] = 'pending';

        // Atur waktu booking saat ini
        $now = new DateTime();
        $data['tanggal_booking'] = $now->format('Y-m-d H:i:s');

        // Atur batas waktu pengambilan 24 jam dari sekarang
        $now->add(new DateInterval('PT24H')); // PT24H = Periode Waktu 24 Jam
        $data['batas_waktu_pengambilan'] = $now->format('Y-m-d H:i:s');

        return $this->insert($data);
    }

    public function updateStatus($id, $status)
    {
        return $this->update($id, ['status' => $status]);
    }
}