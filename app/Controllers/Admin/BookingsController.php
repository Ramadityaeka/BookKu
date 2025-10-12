<?php namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BookingModel;

class BookingsController extends BaseController
{
    public function index()
    {
        $bookingModel = new BookingModel();
        return view('admin/bookings_view', [
            'title' => 'Manajemen Booking',
            // Ganti di sini untuk memanggil fungsi yang namanya sudah diubah
            'bookings' => $bookingModel->getAllBookings()
        ]);
    }

    public function statusUpdate($id)
    {
        $bookingModel = new BookingModel();
        $status = $this->request->getPost('status');
        $bookingModel->updateStatus($id, $status);
        return redirect()->to('admin/bookings')->with('success', 'Status booking berhasil diperbarui.');
    }

    public function delete($id)
    {
        $bookingModel = new BookingModel();
        $bookingModel->delete($id);
        return redirect()->to('admin/bookings')->with('success', 'Booking berhasil dihapus.');
    }
}