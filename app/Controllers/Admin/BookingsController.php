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
    }    public function index()
    {
        return view('admin/bookings_view', [
            'title' => 'Booking Management',
            'bookings' => $this->bookingModel->getBookings()
        ]);
    }

    public function statusUpdate($id)
    {
        $status = $this->request->getJSON()->status;
        
        try {
            $this->bookingModel->updateStatus($id, $status);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Status updated successfully'
            ]);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)
                                ->setJSON([
                                    'success' => false,
                                    'message' => 'Failed to update status'
                                ]);
        }
    }

    public function delete($id)
    {
        try {
            $this->bookingModel->delete($id);
            return redirect()->back()
                           ->with('success', 'Booking deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Failed to delete booking');
        }
    }
}
