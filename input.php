<?php
include 'configevent.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Debugging: Menampilkan data yang diterima dari form
    var_dump($_POST);

    // Mengambil data dari form
    $event_name = $_POST['Nama_Event'] ?? null;
    $event_date = $_POST['Tanggal'] ?? null;
    $event_time = $_POST['Waktu'] ?? null;
    $location = $_POST['Lokasi'] ?? null;
    $description = $_POST['Deskripsi'] ?? null;
    $max_participant = $_POST['Max_participant'] ?? null;

    // Memastikan file banner ada sebelum mencoba mengupload
    $filename = $_FILES['banner']['name'] ?? null;
    $temp_file = $_FILES['banner']['tmp_name'] ?? null;

    // Upload banner
    if ($temp_file) {
        move_uploaded_file($temp_file, "banner/{$filename}");
    }

    // Insert data ke database jika semua data ada
    if ($event_name && $event_date && $event_time && $location && $description && $max_participant) {
        $sql = "INSERT INTO msevent_detail (Nama_event, Tanggal, Waktu, Lokasi, Deskripsi, Max_participant, Banner) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $kunci->prepare($sql);
        $stmt->execute([$event_name, $event_date, $event_time, $location, $description, $max_participant, $filename]);

        header("Location: event_management.php");
        exit; // Pastikan untuk menghentikan eksekusi setelah redirect
    } else {
        echo "Semua field harus diisi.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Tambah Event Baru</title>
</head>
<body>
    <div class="container mt-5">
        <h1>Tambah Event Baru</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="Nama_Event" class="form-label">Nama Event</label>
                <input type="text" name="Nama_Event" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="Tanggal" class="form-label">Tanggal</label>
                <input type="date" name="Tanggal" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="Waktu" class="form-label">Waktu</label>
                <input type="time" name="Waktu" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="Lokasi" class="form-label">Lokasi</label>
                <input type="text" name="Lokasi" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="Deskripsi" class="form-label">Deskripsi</label>
                <textarea name="Deskripsi" class="form-control" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="Max_participant" class="form-label">Max Participant</label>
                <input type="number" name="Max_participant" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="banner" class="form-label">Banner</label>
                <input type="file" name="banner" class="form-control" required>
            </div>
            <input type="submit" class="btn btn-primary" value="Tambah Event">
        </form>
    </div>
</body>
</html>
