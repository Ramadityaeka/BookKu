<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class HealthController extends Controller
{
    public function index()
    {
        return $this->response->setStatusCode(200)->setJSON(['status' => 'healthy']);
    }
}