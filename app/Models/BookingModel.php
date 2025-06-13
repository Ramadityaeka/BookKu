<?php

namespace App\Models;

use CodeIgniter\Model;

class BookingModel extends Model
{
    protected $table = 'booking';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['user_id', 'buku_id', 'nama_user', 'no_hp', 'status'];
    protected $useTimestamps = true;
    protected $createdField = 'tanggal_booking';
    protected $updatedField = '';

    public function getBookings()
    {
        return $this->select('booking.*, katalog.judul, katalog.gambar')
                    ->join('katalog', 'katalog.id = booking.buku_id')
                    ->orderBy('booking.tanggal_booking', 'DESC')
                    ->findAll();
    }

    public function createBooking($data)
    {
        $data['status'] = 'pending';
        return $this->insert($data);
    }

    public function updateStatus($id, $status)
    {
        return $this->update($id, ['status' => $status]);
    }
}
