<?php
include 'configevent.php';  // Koneksi database
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Event Management</title>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Event Management</h1>

        <div class="text-end mb-3">
            <a href="input.php" class="btn btn-primary">Tambah Event Baru</a>
        </div>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID Event</th>
                    <th>Nama Event</th>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Lokasi</th>
                    <th>Deskripsi</th>
                    <th>Max Participant</th>
                    <th>Banner</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Ambil data dari tabel msevent_detail
                $sql = "SELECT * FROM msevent_detail";
                $stmt = $kunci->query($sql);

                // Tampilkan data
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>{$row['ID']}</td>";
                    echo "<td>{$row['Nama_Event']}</td>";
                    echo "<td>{$row['Tanggal']}</td>";
                    echo "<td>{$row['Waktu']}</td>";
                    echo "<td>{$row['Lokasi']}</td>";
                    echo "<td>{$row['Deskripsi']}</td>";
                    echo "<td>{$row['Max_participant']}</td>";
                    echo "<td><img src='banner/{$row['Banner']}' width='100'></td>";
                    echo "<td>
                            <a href='edit.php?event_id={$row['ID']}' class='btn btn-warning btn-sm'>Edit</a>
                            <a href='delete.php?event_id={$row['ID']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Apakah Anda yakin ingin menghapus event ini?\")'>Delete</a>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
