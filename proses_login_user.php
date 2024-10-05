<?php
// Form data:
$email = $_POST['email'];
$password = $_POST['password'];

// 1. Buat koneksi ke database
$dsn = "mysql:host=localhost;dbname=uts_group_5";
$kunci = new PDO($dsn, "root", "");

// 2. Buat query SQL, pastikan kolom didefinisikan sesuai
$sql = "INSERT INTO ms_user (email, password) VALUES (?, ?)";

// 3. Persiapkan statement dan eksekusi dengan data
$stmt = $kunci->prepare($sql);
$data = [$email, $password];
$stmt->execute($data);

echo "Data berhasil di input";
?>
x