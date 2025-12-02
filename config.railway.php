<?php
// Konfigurasi Database untuk Railway
// NOTE: This is a standalone example. CodeIgniter uses app/Config/Database.php
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
        // Log error untuk debugging, tapi jangan expose detail ke user
        error_log("Database connection failed: " . $conn->connect_error);
        die("Database connection failed. Please check your configuration.");
    }
    
    // Set charset untuk security (prevent SQL injection via charset)
    $conn->set_charset("utf8mb4");
    
} catch (Exception $e) {
    // Log error untuk debugging, tapi jangan expose detail ke user
    error_log("Database connection error: " . $e->getMessage());
    die("Database connection error. Please check your configuration.");
}
?>
