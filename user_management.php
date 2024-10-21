<?php
include 'configevent.php';  // Koneksi database

// Function to export user data to Excel
if (isset($_POST['export'])) {
    $filename = "users_" . date('Ymd') . ".xls";  // Create filename based on the date
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header("Pragma: no-cache");
    header("Expires: 0");
    
    // Fetch user data
    $sql = "SELECT * FROM manage_user";  // Fetching data from manage_user table
    $stmt = $kunci->query($sql);
    
    // Output column headers
    echo "ID\tUsername\tEmail\tEvents Attended\n";  // Adjust according to your user data structure
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Fetch events attended by the user
        $userId = $row['ID'];  // Use the correct column name
        $eventSql = "SELECT Nama_Event FROM event_participants WHERE User_ID = :user_id";  // Adjust accordingly
        $eventStmt = $kunci->prepare($eventSql);
        $eventStmt->execute(['user_id' => $userId]);  // This should match the placeholder
        $events = $eventStmt->fetchAll(PDO::FETCH_COLUMN);
        $eventList = implode(", ", $events);  // Convert array to comma-separated string

        // Output user data
        echo "{$row['ID']}\t{$row['Username']}\t{$row['Email']}\t$eventList\n";
    }
    exit;  // Stop further script execution
}

// Delete user functionality
if (isset($_GET['delete_user'])) {
    $userId = $_GET['delete_user'];
    $deleteSql = "DELETE FROM manage_user WHERE ID = :user_id";  // Adjust the table name as necessary
    $deleteStmt = $kunci->prepare($deleteSql);
    $deleteStmt->execute(['user_id' => $userId]);  // Ensure the parameter matches
    header("Location: user_management.php");  // Redirect after deletion
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>User Management</title>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">User Management</h1>

        <div class="text-end mb-3">
            <form method="post" class="d-inline">
                <button type="submit" name="export" class="btn btn-success">Export to Excel</button>
            </form>
        </div>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID User</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Events Attended</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Ambil data dari tabel manage_user
                $sql = "SELECT * FROM manage_user";  // Fetching data from manage_user table
                $stmt = $kunci->query($sql);

                // Tampilkan data
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    // Fetch events attended by the user
                    $userId = $row['ID'];  // Ensure this is the correct column name
                    $eventSql = "SELECT Nama_Event FROM event_participants WHERE User_ID = :user_id";  // Adjust accordingly
                    $eventStmt = $kunci->prepare($eventSql);
                    $eventStmt->execute(['user_id' => $userId]);  // Ensure this matches
                    $events = $eventStmt->fetchAll(PDO::FETCH_COLUMN);
                    $eventList = implode(", ", $events);  // Convert array to comma-separated string

                    echo "<tr>";
                    echo "<td>{$row['ID']}</td>";
                    echo "<td>{$row['Username']}</td>";
                    echo "<td>{$row['Email']}</td>";
                    echo "<td>$eventList</td>";
                    echo "<td>
                            <a href='user_management.php?delete_user={$row['ID']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Apakah Anda yakin ingin menghapus akun ini?\")'>Delete</a>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
