<?php
// Database connection settings
$conn = mysqli_connect('localhost', 'root', '', 'uts_group_5');

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
