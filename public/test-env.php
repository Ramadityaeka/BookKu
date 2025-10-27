<?php
header('Content-Type: text/plain');

echo "=== Environment Variables Test ===\n\n";

echo "CI_ENVIRONMENT: " . (getenv('CI_ENVIRONMENT') ?: 'NOT SET') . "\n";
echo "MYSQLHOST: " . (getenv('MYSQLHOST') ?: 'NOT SET') . "\n";
echo "MYSQLPORT: " . (getenv('MYSQLPORT') ?: 'NOT SET') . "\n";
echo "MYSQLDATABASE: " . (getenv('MYSQLDATABASE') ?: 'NOT SET') . "\n";
echo "MYSQLUSER: " . (getenv('MYSQLUSER') ?: 'NOT SET') . "\n";
echo "MYSQLPASSWORD: " . (getenv('MYSQLPASSWORD') ? '***SET***' : 'NOT SET') . "\n\n";

echo "=== PHP Info ===\n";
echo "PHP Version: " . phpversion() . "\n";
echo "mysqli extension: " . (extension_loaded('mysqli') ? 'LOADED' : 'NOT LOADED') . "\n";
echo "pdo_mysql extension: " . (extension_loaded('pdo_mysql') ? 'LOADED' : 'NOT LOADED') . "\n";
echo "pdo extension: " . (extension_loaded('pdo') ? 'LOADED' : 'NOT LOADED') . "\n\n";

echo "=== Server Info ===\n";
echo "Document Root: " . ($_SERVER['DOCUMENT_ROOT'] ?? 'NOT SET') . "\n";
echo "Script Filename: " . (__FILE__ ?? 'NOT SET') . "\n";
echo "Server Software: " . ($_SERVER['SERVER_SOFTWARE'] ?? 'NOT SET') . "\n";
echo "PORT: " . (getenv('PORT') ?: 'NOT SET') . "\n\n";

echo "=== Test MySQL Connection ===\n";
$mysqlhost = getenv('MYSQLHOST');
$mysqlport = getenv('MYSQLPORT');
$mysqluser = getenv('MYSQLUSER');
$mysqlpass = getenv('MYSQLPASSWORD');
$mysqldb = getenv('MYSQLDATABASE');

if ($mysqlhost && $mysqluser && $mysqldb) {
    try {
        $mysqli = new mysqli($mysqlhost, $mysqluser, $mysqlpass, $mysqldb, $mysqlport);
        if ($mysqli->connect_error) {
            echo "Connection FAILED: " . $mysqli->connect_error . "\n";
        } else {
            echo "Connection SUCCESS!\n";
            echo "MySQL Server Version: " . $mysqli->server_info . "\n";
            
            // Test query
            $result = $mysqli->query("SELECT COUNT(*) as count FROM katalog");
            if ($result) {
                $row = $result->fetch_assoc();
                echo "Books in katalog table: " . $row['count'] . "\n";
            }
            $mysqli->close();
        }
    } catch (Exception $e) {
        echo "Connection ERROR: " . $e->getMessage() . "\n";
    }
} else {
    echo "MySQL variables NOT SET - Cannot test connection\n";
}

echo "\n=== All Environment Variables ===\n";
foreach ($_ENV as $key => $value) {
    if (strpos(strtolower($key), 'password') !== false || strpos(strtolower($key), 'secret') !== false) {
        echo "$key: ***HIDDEN***\n";
    } else {
        echo "$key: $value\n";
    }
}