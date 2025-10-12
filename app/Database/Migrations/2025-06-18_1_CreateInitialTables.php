<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInitialTables extends Migration
{
    public function up()
    {
        // Tabel Users
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'username' => ['type' => 'VARCHAR', 'constraint' => 100],
            'password' => ['type' => 'VARCHAR', 'constraint' => 255],
            'role' => ['type' => 'VARCHAR', 'constraint' => 50, 'default' => 'user'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('username');
        $this->forge->createTable('users');

        // Tabel Katalog (disesuaikan dengan SQL asli Anda)
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'judul' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'deskripsi' => ['type' => 'TEXT', 'null' => true],
            'gambar' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'genre' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'tentang_buku' => ['type' => 'TEXT', 'null' => true],
            'sinopsis' => ['type' => 'TEXT', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('katalog');

        // Tabel Booking (disesuaikan dengan SQL asli Anda + relasi)
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'buku_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'nama_user' => ['type' => 'VARCHAR', 'constraint' => 100],
            'no_hp' => ['type' => 'VARCHAR', 'constraint' => 20],
            'tanggal_booking' => ['type' => 'DATETIME', 'null' => true],
            'batas_waktu_pengambilan' => ['type' => 'DATETIME', 'null' => true],
            'status' => ['type' => 'ENUM', 'constraint' => ['pending', 'approved', 'denied'], 'default' => 'pending'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('buku_id', 'katalog', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('booking');
    }

    public function down()
    {
        $this->forge->dropTable('booking');
        $this->forge->dropTable('katalog');
        $this->forge->dropTable('users');
    }
}