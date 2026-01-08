<?php
// Database configuration

$host = 'localhost'; // Database host
$user = 'root'; // Database username
$pass = ''; // Database password
$db   = 'print_store'; // Database name

$mysqli = new mysqli($host, $user, $pass, $db); // Create a new MySQLi connection

if ($mysqli->connect_error) {
    die('Database connection failed: ' . $mysqli->connect_error);
}

$mysqli->set_charset('utf8mb4');

return $mysqli; // Return the database connection
