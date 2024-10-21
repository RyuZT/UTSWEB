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

    // Get the event ID from the URL
    $eventId = $_GET['event_id'];

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $userId = $_SESSION['user_id']; // Get user ID from session

        // Check if the user has already registered for this event
        $checkSql = "SELECT COUNT(*) FROM event_participants WHERE user_id = :user_id AND event_id = :event_id";
        $checkStmt = $pdo->prepare($checkSql);
        $checkStmt->execute([
            'user_id' => $userId,
            'event_id' => $eventId
        ]);

        if ($checkStmt->fetchColumn() > 0) {
            echo "You have already registered for this event.";
        } else {
            // Insert the registration into the database
            $sql = "INSERT INTO event_participants (user_id, event_id) VALUES (:user_id, :event_id)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'user_id' => $userId,
                'event_id' => $eventId
            ]);

            echo "Registration successful!";
            // Redirect to dashboard after registration
            header("Location: dashboard.php");
            exit();
        }
    }
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register for Event</title>
</head>
<body>
    <div class="container">
        <h2>Register for Event</h2>
        <form action="" method="post">
            <label for="Ename">Username</label><br>
            <input type="text" name="Ename" required/><br />

            <label for="cname">Email</label><br>
            <input type="text" name="cname" required/><br />

            <input type="submit" value="Submit"/>
        </form>
    </div>
</body>
</html>
