<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';

    /**
     * Memverifikasi username dan password.
     * Mengembalikan data user jika valid, atau false jika tidak.
     */
    public function verifyLogin(string $username, string $password)
    {
        // Cari user berdasarkan username
        $user = $this->where('username', $username)->first();

        // Jika user ditemukan dan password cocok
        if ($user && password_verify($password, $user['password'])) {
            // Jangan kembalikan password hash
            unset($user['password']); 
            return $user;
        }

        return false;
    }
}