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

    $searchQuery = '';
    // Check if search query is set
    if (isset($_POST['search'])) {
        $searchQuery = $_POST['search'];
    }

    // Ambil event dengan pencarian berdasarkan nama event
    $sql = "SELECT e.*, COUNT(p.user_id) AS participant_count 
            FROM msevent_detail e 
            LEFT JOIN event_participants p ON e.ID = p.event_id 
            WHERE e.Nama_Event LIKE :search 
            GROUP BY e.ID";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
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
                    <h3><?php echo htmlspecialchars($event['Nama_Event']); ?></h3>
                    <p><strong>Tanggal:</strong> <?php echo htmlspecialchars($event['Tanggal']); ?></p>
                    <p><strong>Waktu:</strong> <?php echo htmlspecialchars($event['Waktu']); ?></p>
                    <p><strong>Lokasi:</strong> <?php echo htmlspecialchars($event['Lokasi']); ?></p>
                    <p><strong>Deskripsi:</strong> <?php echo htmlspecialchars($event['Deskripsi']); ?></p>
                    <p><strong>Max Participant:</strong> <?php echo htmlspecialchars($event['Max_participant']); ?></p>
                    <p><strong>Current Participants:</strong> <?php echo htmlspecialchars($event['participant_count'] ?? 0); ?> / <?php echo htmlspecialchars($event['Max_participant']); ?></p>
                    <p><strong>Banner:</strong> <img src='banner/<?php echo htmlspecialchars($event['Banner']); ?>' width='100'></p>
                    
                    <?php 
                    $currentParticipants = $event['participant_count'] ?? 0; 
                    $maxParticipants = $event['Max_participant'];
                    ?>
                    
                    <?php if ($currentParticipants < $maxParticipants): ?>
                        <button type="button" onclick="window.location.href='register_event.php?event_id=<?php echo $event['ID']; ?>'">Register</button>
                    <?php else: ?>
                        <button type="button" disabled>Event Penuh</button>
                    <?php endif; ?>
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
