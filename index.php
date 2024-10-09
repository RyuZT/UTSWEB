<?php
session_start();
try {
    // Database connection
    $dsn = "mysql:host=localhost;dbname=uts_group_5"; // Update with your actual database name
    $pdo = new PDO($dsn, "root", ""); // Update with your actual database credentials

    // Handle search query
    $searchQuery = '';
    if (isset($_POST['search'])) {
        $searchQuery = $_POST['search'];
    }

    // Prepare SQL query to fetch events
    $sql = "SELECT * FROM admin WHERE nama_Event LIKE :search";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['search' => "%$searchQuery%"]);
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Orginizer WEB</title>

</head>
<body>
    <h1>OVENT</h1>
    <a href="form_login_user.php"> Login As User</a>
    <a href="form_register_user.php">Register As User</a>
    <button type="button" onclick="window.location.href='form_request_admin.php'">Request</button>

    <h1>Event List</h1>

<form action="" method="POST">
    <input type="text" name="search" placeholder="Search by event name" value="<?php echo htmlspecialchars($searchQuery); ?>" required>
    <input type="submit" value="Search">
</form>

<h2>Events</h2>
<?php if (count($events) > 0): ?>
    <ul>
        <?php foreach ($events as $event): ?>
            <li><?php echo htmlspecialchars($event['nama_Event']); ?></li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No events found.</p>
<?php endif; ?>
