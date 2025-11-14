<?php
// Railway healthcheck endpoint
header('Content-Type: application/json');

$health = [
    'status' => 'healthy',
    'timestamp' => date('Y-m-d H:i:s'),
    'php_version' => phpversion(),
    'checks' => []
];

// Check database connection
$dbHealthy = false;
try {
    $host = getenv('MYSQLHOST') ?: 'localhost';
    $port = getenv('MYSQLPORT') ?: '3306';
    $dbname = getenv('MYSQLDATABASE') ?: getenv('MYSQL_DATABASE') ?: 'bookku';
    $user = getenv('MYSQLUSER') ?: getenv('MYSQL_USER') ?: 'root';
    $pass = getenv('MYSQLPASSWORD') ?: getenv('MYSQL_PASSWORD') ?: '';
    
    $conn = new mysqli($host, $user, $pass, $dbname, $port);
    
    if ($conn->connect_error) {
        $health['checks']['database'] = 'unhealthy: ' . $conn->connect_error;
        $health['status'] = 'degraded';
    } else {
        $health['checks']['database'] = 'connected';
        $dbHealthy = true;
        $conn->close();
    }
} catch (Exception $e) {
    $health['checks']['database'] = 'unhealthy: ' . $e->getMessage();
    $health['status'] = 'degraded';
}

// Check writable directory
if (is_writable(__DIR__ . '/writable')) {
    $health['checks']['writable_dir'] = 'writable';
} else {
    $health['checks']['writable_dir'] = 'not writable';
    $health['status'] = 'degraded';
}

// Set appropriate response code
http_response_code($health['status'] === 'healthy' ? 200 : 503);

echo json_encode($health, JSON_PRETTY_PRINT);
exit;
