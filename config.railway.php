<?php
// Konfigurasi Database untuk Railway
// Railway akan provide environment variables

// Cek apakah di Railway (production) atau local
if (getenv('RAILWAY_ENVIRONMENT') || getenv('MYSQLHOST')) {
    // Production - Railway
    $host = getenv('MYSQLHOST') ?: 'localhost';
    $port = getenv('MYSQLPORT') ?: '3306';
    $dbname = getenv('MYSQLDATABASE') ?: 'bookku';
    $user = getenv('MYSQLUSER') ?: 'root';
    $pass = getenv('MYSQLPASSWORD') ?: '';
} else {
    // Local development
    $host = 'localhost';
    $port = '3306';
    $dbname = 'bookku';
    $user = 'root';
    $pass = '';
}

// Koneksi database
try {
    $conn = new mysqli($host, $user, $pass, $dbname, $port);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Set charset
    $conn->set_charset("utf8mb4");
    
} catch (Exception $e) {
    die("Database connection error: " . $e->getMessage());
}
?>
