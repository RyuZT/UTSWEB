<?php
include 'configevent.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil data dari form
    $event_id = $_POST['event_id'] ?? null;
    $event_name = $_POST['Nama_Event'] ?? null;
    $event_date = $_POST['Tanggal'] ?? null;
    $event_time = $_POST['Waktu'] ?? null;
    $location = $_POST['Lokasi'] ?? null;
    $description = $_POST['Deskripsi'] ?? null;
    $max_participant = $_POST['Max_participant'] ?? null;

    // Memastikan file banner ada sebelum mencoba mengupload
    $filename = $_FILES['banner']['name'] ?? null;
    $temp_file = $_FILES['banner']['tmp_name'] ?? null;

    // Jika ada file banner yang diupload, upload file
    if ($temp_file) {
        move_uploaded_file($temp_file, "banner/{$filename}");
    } else {
        // Jika tidak ada file baru, gunakan filename lama
        $sql = "SELECT Banner FROM msevent_detail WHERE ID = ?";
        $stmt = $kunci->prepare($sql);
        $stmt->execute([$event_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $filename = $row['Banner'];
    }

    // Update data ke database jika semua data ada
    if ($event_id && $event_name && $event_date && $event_time && $location && $description && $max_participant) {
        $sql = "UPDATE msevent_detail SET Nama_event = ?, Tanggal = ?, Waktu = ?, Lokasi = ?, Deskripsi = ?, Max_participant = ?, Banner = ? WHERE ID = ?";
        $stmt = $kunci->prepare($sql);
        $stmt->execute([$event_name, $event_date, $event_time, $location, $description, $max_participant, $filename, $event_id]);

        header("Location: event_management.php");
        exit; // Pastikan untuk menghentikan eksekusi setelah redirect
    } else {
        echo "Semua field harus diisi.";
    }
} else {
    // Ambil data event berdasarkan ID untuk ditampilkan di form
    $event_id = $_GET['event_id'] ?? null;
    if ($event_id) {
        $sql = "SELECT * FROM msevent_detail WHERE ID = ?";
        $stmt = $kunci->prepare($sql);
        $stmt->execute([$event_id]);
        $event = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Edit Event</title>
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Event</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="event_id" value="<?php echo $event['ID']; ?>">
            <div class="mb-3">
                <label for="Nama_Event" class="form-label">Nama Event</label>
                <input type="text" name="Nama_Event" class="form-control" value="<?php echo htmlspecialchars($event['Nama_Event']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="Tanggal" class="form-label">Tanggal</label>
                <input type="date" name="Tanggal" class="form-control" value="<?php echo htmlspecialchars($event['Tanggal']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="Waktu" class="form-label">Waktu</label>
                <input type="time" name="Waktu" class="form-control" value="<?php echo htmlspecialchars($event['Waktu']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="Lokasi" class="form-label">Lokasi</label>
                <input type="text" name="Lokasi" class="form-control" value="<?php echo htmlspecialchars($event['Lokasi']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="Deskripsi" class="form-label">Deskripsi</label>
                <textarea name="Deskripsi" class="form-control" rows="3" required><?php echo htmlspecialchars($event['Deskripsi']); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="Max_participant" class="form-label">Max Participant</label>
                <input type="number" name="Max_participant" class="form-control" value="<?php echo htmlspecialchars($event['Max_participant']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="banner" class="form-label">Banner (Kosongkan jika tidak ingin mengubah)</label>
                <input type="file" name="banner" class="form-control">
                <img src="banner/<?php echo $event['Banner']; ?>" width="100" class="mt-2" alt="Banner Event">
            </div>
            <input type="submit" class="btn btn-primary" value="Update Event">
        </form>
    </div>
</body>
</html>
