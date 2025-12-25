<?php
// db.php
$DB_HOST = '127.0.0.1';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'neat_db2'; 

$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// mulai session jika belum
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

