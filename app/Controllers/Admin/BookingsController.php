<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class BookingsController extends BaseController
{
    protected $bookingModel;

    public function __construct()
    {
        $this->bookingModel = new \App\Models\BookingModel();
    }

    public function index()
    {
        return view('admin/bookings_view', [
            'title' => 'Booking Management',
            'bookings' => $this->bookingModel->getBookings()
        ]);
    }

    public function statusUpdate($id)
    {
        // DIUBAH: Mengambil data dari request POST biasa, bukan JSON
        $status = $this->request->getPost('status');
        
        // Validasi sederhana untuk keamanan
        if (!in_array($status, ['pending', 'approved', 'denied'])) {
            return $this->response->setStatusCode(400)->setJSON([
                'success' => false, 'message' => 'Invalid status value.'
            ]);
        }
        
        try {
            $this->bookingModel->updateStatus($id, $status);

            // Mengirim kembali respons sukses
            return $this->response->setJSON([
                'success'   => true,
                'message'   => 'Status updated successfully'
            ]);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false, 'message' => 'Failed to update status'
            ]);
        }
    }

    public function delete($id)
    {
        try {
            $this->bookingModel->delete($id);
            return redirect()->back()->with('success', 'Booking deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete booking');
        }
    }
}