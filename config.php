<?php

define('DB_HOST', 'localhost'); // Or your DB host
define('DB_NAME', 'chuckle_hub_db'); // Your database name
define('DB_USER', 'your_db_user'); // Your database username
define('DB_PASS', 'your_db_password'); // Your database password

// --- Use PDO for database interaction (Recommended for security) ---
$dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Throw exceptions on errors
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Fetch associative arrays
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Use native prepared statements
];

try {
     $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (\PDOException $e) {
     // In production, log the error instead of showing it to the user
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
     // Or display a generic error message:
     // die("Database connection failed. Please try again later.");
}

// --- Start Session ---
// Should be called on every page that needs session access
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
