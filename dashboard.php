<?php 
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

try {
    $dsn = "mysql:host=localhost;dbname=uts_group_5";
    $pdo = new PDO($dsn, "root", "");

    $userId = $_SESSION['user_id']; // Ambil ID user dari sesi
    $searchQuery = '';

    if (isset($_POST['search'])) {
        $searchQuery = $_POST['search'];
    }

    // Ambil event yang terkait dengan user yang sedang login
    $sql = "SELECT * FROM admin WHERE user_id = :user_id AND nama_Event LIKE :search";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'user_id' => $userId,
        'search' => "%$searchQuery%"
    ]);
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
    <link rel="stylesheet" href="dashboard.css">
    <title>Event Organizer WEB</title>
</head>
<body>

    <h1>OVENT</h1>

    <div class="top-buttons">
        <button type="button" onclick="window.location.href='form_request_admin.php'">Request</button>
    </div>

    <div class="search-bar">
        <form action="" method="POST">
            <input type="text" name="search" placeholder="Search by event name" value="<?php echo htmlspecialchars($searchQuery); ?>" required>
            <input type="submit" value="Search">
        </form>
    </div>

    <h2 style="text-align:center;">Event List</h2>
    <div class="container">
        <?php if (count($events) > 0): ?>
            <?php foreach ($events as $event): ?>
                <div class="card">
                    <h3><?php echo htmlspecialchars($event['nama_Event']); ?></h3>
                    <p><strong>Company:</strong> <?php echo htmlspecialchars($event['Company_name']); ?></p>
                    <p><strong>Purpose:</strong> <?php echo htmlspecialchars($event['Event_Purpose']); ?></p>
                    <p><strong>Location:</strong> <?php echo htmlspecialchars($event['Event_location']); ?></p>
                    <p><strong>Date:</strong> <?php echo htmlspecialchars($event['Event_date']); ?></p>
                    <a href="proposal/<?php echo htmlspecialchars($event['Proposal']); ?>" target="_blank">View Proposal</a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="text-align:center;">No events found.</p>
        <?php endif; ?>
    </div>
    <form action="logout.php" method="post">
        <button type="submit">Logout</button>
    </form>
</body>
</html>
