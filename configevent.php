<?php
// Konfigurasi koneksi database
$dsn = "mysql:host=localhost;dbname=uts_group_5";
$username = "root";
$password = "";

try {
    $kunci = new PDO($dsn, $username, $password);
    $kunci->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi Gagal: " . $e->getMessage());
}
?>
