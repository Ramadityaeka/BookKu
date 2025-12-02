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
        // Don't expose detailed error messages in production
        $health['checks']['database'] = 'unhealthy';
        $health['status'] = 'degraded';
        
        // Log detailed error for debugging (not exposed to client)
        error_log('Database health check failed: ' . $conn->connect_error);
    } else {
        $health['checks']['database'] = 'connected';
        $dbHealthy = true;
        $conn->close();
    }
} catch (Exception $e) {
    // Don't expose detailed error messages in production
    $health['checks']['database'] = 'unhealthy';
    $health['status'] = 'degraded';
    
    // Log detailed error for debugging (not exposed to client)
    error_log('Database health check exception: ' . $e->getMessage());
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
