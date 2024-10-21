<?php
session_start();

if (isset($_SESSION['username'])) {
    // Simpan data dalam cookie saat logout (berlaku 1 hari)
    setcookie('user_data', json_encode($_SESSION), time() + 86400, '/');
}

// Hapus dan hancurkan sesi
session_unset();
session_destroy();
header('Location: index.php');
exit();
?>
