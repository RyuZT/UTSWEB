<?php 
session_start();

// Memastikan pengguna sudah login
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

// Koneksi ke database
try {
    $dsn = "mysql:host=localhost;dbname=uts_group_5";
    $pdo = new PDO($dsn, "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Koneksi database gagal: " . $e->getMessage();
    exit();
}

// Inisialisasi variabel $is_submitted dan $is_accepted jika belum ada di sesi
$is_submitted = isset($_SESSION['is_submitted']) ? $_SESSION['is_submitted'] : false;
$is_accepted = isset($_SESSION['is_accepted']) ? $_SESSION['is_accepted'] : false;

// Jika formulir sudah disubmit, set sesi untuk menandai status
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_SESSION['user_id']; // Ambil ID user dari sesi
    $ename = $_POST['Ename'];
    $cname = $_POST['cname'];
    $epurpose = $_POST['Epurpose'];
    $elocation = $_POST['Elocation'];
    $edate = $_POST['Edate'];
    $proposal = $_FILES['Eproposal']['name'];

    // Simpan file proposal
    move_uploaded_file($_FILES['Eproposal']['tmp_name'], "proposal/$proposal");

    // Simpan request ke database
    $sql = "INSERT INTO admin (user_id, nama_Event, Company_name, Event_Purpose, Event_location, Event_date, Proposal, status) 
            VALUES (:user_id, :ename, :cname, :epurpose, :elocation, :edate, :proposal, 'pending')";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'user_id' => $userId,
        'ename' => $ename,
        'cname' => $cname,
        'epurpose' => $epurpose,
        'elocation' => $elocation,
        'edate' => $edate,
        'proposal' => $proposal
    ]);

    // Set sesi setelah berhasil submit
    $_SESSION['is_submitted'] = true;

    // Redirect untuk mencegah resubmission
    header('Location: form_request_admin.php');
    exit();
}

// Ambil status dari database untuk ditampilkan
$sql = "SELECT status FROM admin WHERE user_id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['user_id' => $_SESSION['user_id']]);
$status = $stmt->fetchColumn();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Request To Become Admin</title>
</head>
<body>
    <div class="container">
        <h2>Request To Become Admin</h2>

        <?php if ($status === 'rejected'): ?>
            <p style="color: red;">Sorry, your event is not approved.</p>
        <?php elseif ($status === 'accepted'): ?>
            <p style="color: green;">Your event has been accepted!</p>
            <a href="Admin_page.php">
             <button>Go to Admin Page</button>
            </a>
        <?php else: ?>
            <form action="form_request_admin.php" method="post" enctype="multipart/form-data">
                <label for="Ename">Event Name</label><br>
                <input type="text" name="Ename" required/><br />

                <label for="cname">Company Name</label><br>
                <input type="text" name="cname" required/><br />

                <label for="Epurpose">Event Purpose</label><br>
                <input type="text" name="Epurpose" required/><br />

                <label for="Elocation">Event Location</label><br>
                <input type="text" name="Elocation" required/><br />

                <label for="Edate">Event Date</label><br>
                <input type="date" name="Edate" required/><br />

                <label for="Eproposal">Event Proposal (PDF only)</label><br>
                <input type="file" name="Eproposal" accept=".pdf" required/><br />
                <input type="submit" value="Submit" onclick="window.location.href='dashboard.php';"/>

            </form>
        <?php endif; ?>
    </div>
</body>
</html>
