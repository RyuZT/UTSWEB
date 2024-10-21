<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['Eproposal']) && $_FILES['Eproposal']['error'] === UPLOAD_ERR_OK) {
        $filename = $_FILES['Eproposal']['name'];
        $temp_file = $_FILES['Eproposal']['tmp_name'];
        $file_ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $upload_dir = "proposal/";

        if ($file_ext === 'pdf') {
            $new_filename = uniqid() . '.' . $file_ext;

            if (move_uploaded_file($temp_file, $upload_dir . $new_filename)) {
                // Ambil data dari form
                $Ename = $_POST['Ename'];
                $cname = $_POST['cname'];
                $Epurpose = $_POST['Epurpose'];
                $Elocation = $_POST['Elocation'];
                $Edate = $_POST['Edate'];
                $Eproposal = $new_filename;

                try {
                    // Koneksi ke database
                    $dsn = "mysql:host=localhost;dbname=uts_group_5";
                    $pdo = new PDO($dsn, "root", "");

                    // Insert data ke database
                    $sql = "INSERT INTO admin (nama_Event, Company_name, Event_purpose, Event_location, Event_date, Proposal) 
                            VALUES (?, ?, ?, ?, ?, ?)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([$Ename, $cname, $Epurpose, $Elocation, $Edate, $Eproposal]);

                    // Tandai sesi sebagai telah disubmit
                    $_SESSION['is_submitted'] = true;

                    // Redirect ke halaman master.php
                    header('Location: master.php');
                    exit();
                } catch (PDOException $e) {
                    $_SESSION['error'] = "Database error: " . $e->getMessage();
                }
            } else {
                $_SESSION['error'] = "Error: File gagal di-upload.";
            }
        } else {
            $_SESSION['error'] = "Error: Hanya file PDF yang diperbolehkan.";
        }
    } else {
        $_SESSION['error'] = "Error: File tidak di-upload dengan benar.";
    }

    // Redirect ke form_request_admin.php jika ada error
    header('Location: form_request_admin.php');
    exit();
}
