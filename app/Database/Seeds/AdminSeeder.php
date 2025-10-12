<?php

/**
 * File: AdminSeeder.php
 * 
 * Class AdminSeeder digunakan untuk membuat data awal (seed) untuk tabel users.
 * Seeder ini akan membuat akun admin dan akun pengguna lainnya untuk keperluan testing atau inisialisasi sistem.
 */

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{    
    /**
     * Method run() akan dijalankan ketika seeder dieksekusi
     * Method ini berisi logika untuk membuat data awal users
     */
    public function run()
    {
        // Bersihkan tabel users terlebih dahulu untuk menghindari duplikasi data
        // PERINGATAN: Ini akan menghapus semua data yang ada di tabel users
        $this->db->table('users')->truncate();

        // Array berisi data users yang akan ditambahkan ke database
        // Setiap user memiliki username, email, dan password yang sudah di-hash
        $data = [
            [
                'username' => 'rama',                                  // Username untuk akun pertama
                'email'    => 'ramadityaekaprasetyo@gmail.com',       // Email untuk akun pertama
                'password' => password_hash('rama123', PASSWORD_DEFAULT), // Password yang sudah di-hash
                'created_at' => date('Y-m-d H:i:s'),                  // Timestamp pembuatan akun
                'updated_at' => date('Y-m-d H:i:s'),                  // Timestamp terakhir update
            ],
            [
                'username' => 'admin',                                 // Username untuk akun admin
                'email'    => 'admin@gmail.com',                      // Email untuk akun admin
                'password' => password_hash('admin123', PASSWORD_DEFAULT), // Password admin yang sudah di-hash
                'created_at'=> date('Y-m-d H:i:s'),                   // Timestamp pembuatan akun
                'updated_at'=> date('Y-m-d H:i:s'),                   // Timestamp terakhir update
            ],
        ];

        // Loop through setiap data user untuk dimasukkan ke database
        foreach ($data as $user) {
            // Cek apakah email sudah ada di database untuk menghindari duplikasi
            $exists = $this->db->table('users')
                              ->where('email', $user['email'])
                              ->get()
                              ->getRow();
            
            // Jika email belum ada, masukkan data user baru ke database
            if (!$exists) {
                $this->db->table('users')->insert($user);
            }
        }
    }
}

