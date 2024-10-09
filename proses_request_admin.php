<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengecek apakah file di-upload dengan benar
    if (isset($_FILES['Eproposal']) && $_FILES['Eproposal']['error'] === UPLOAD_ERR_OK) {
        // Mengambil nama file dan file sementara
        $filename = $_FILES['Eproposal']['name'];
        $temp_file = $_FILES['Eproposal']['tmp_name'];

        // Mendapatkan ekstensi file
        $file_ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        // Tentukan folder upload
        $upload_dir = "proposal/";

        // Validasi ekstensi file, hanya mengizinkan PDF
        if ($file_ext === 'pdf') {
            // Membuat nama file baru yang unik untuk menghindari bentrokan nama
            $new_filename = uniqid() . '.' . $file_ext;

            // Pindahkan file yang di-upload ke direktori tujuan
            if (move_uploaded_file($temp_file, $upload_dir . $new_filename)) {
                // Ambil data dari form input
                $Ename = $_POST['Ename'];
                $cname = $_POST['cname'];
                $Epurpose = $_POST['Epurpose'];
                $Elocation = $_POST['Elocation'];
                $Edate = $_POST['Edate'];
                $Eproposal = $new_filename; // Nama file baru yang unik

                // Koneksi ke database
                $dsn = "mysql:host=localhost;dbname=uts_group_5";
                $kunci = new PDO($dsn, "root", "");

                // Query untuk memasukkan data ke database
                $sql = "INSERT INTO admin (nama_Event, Company_name, Event_purpose, Event_location, Event_date, Proposal) 
                        VALUES (?, ?, ?, ?, ?, ?)";

                // Eksekusi query
                $stmt = $kunci->prepare($sql);
                $data = [$Ename, $cname, $Epurpose, $Elocation, $Edate, $Eproposal];
                $stmt->execute($data);

                // Redirect atau menampilkan pesan sukses
                $_SESSION['success'] = "Data dan file PDF berhasil di-upload.";
                header('Location: index.php'); // Ganti dengan halaman yang diinginkan
                exit();
            } else {
                $_SESSION['error'] = "Error: File gagal di-upload.";
                header('Location: index.php');
                exit();
            }
        } else {
            $_SESSION['error'] = "Error: Hanya file dengan format PDF yang diperbolehkan.";
            header('Location: index.php');
            exit();
        }
    } else {
        $_SESSION['error'] = "Error: File tidak di-upload dengan benar.";
        header('Location: index.php');
        exit();
    }
} else {
    header('Location: index.php');
    exit();
}
?>
