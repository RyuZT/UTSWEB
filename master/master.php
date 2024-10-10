<?php
session_start();

try {
    // Koneksi ke database
    $dsn = "mysql:host=localhost;dbname=uts_group_5"; // Sesuaikan dengan nama database Anda
    $pdo = new PDO($dsn, "root", ""); // Sesuaikan dengan kredensial Anda

    // Query untuk mengambil semua data dari tabel admin
    $sql = "SELECT * FROM admin";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    // Mendapatkan semua data sebagai array asosiatif
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Koneksi database gagal: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Master Event List</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .btn-accept {
            background-color: green;
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn-reject {
            background-color: red;
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h2>Master Event List</h2>

    <?php if (count($events) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Event Name</th>
                    <th>Company Name</th>
                    <th>Event Purpose</th>
                    <th>Event Location</th>
                    <th>Event Date</th>
                    <th>Proposal</th>
                    <th>Action</th> <!-- New column for buttons -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($events as $index => $event): ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td><?php echo htmlspecialchars($event['nama_Event']); ?></td>
                    <td><?php echo htmlspecialchars($event['Company_name']); ?></td>
                    <td><?php echo htmlspecialchars($event['Event_Purpose']); ?></td>
                    <td><?php echo htmlspecialchars($event['Event_location']); ?></td>
                    <td><?php echo htmlspecialchars($event['Event_date']); ?></td>
                    <td><a href="proposal/<?php echo htmlspecialchars($event['Proposal']); ?>" target="_blank">View Proposal</a></td>
                    <td>
                        <!-- Accept and Reject buttons with links -->
                        <a href="Landing_admin_page.php" class="btn-accept">Accept</a>
                        <a href="UTSWEB/index.php" class="btn-reject">Reject</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No events found.</p>
    <?php endif; ?>
</body>
</html>
