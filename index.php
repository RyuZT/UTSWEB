<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Contoh validasi login (ganti dengan logika database)
    if ($username === 'test@example.com' && $password === 'password123') {
        
        // Jika cookie ada dan cocok dengan username
        if (isset($_COOKIE['user_data'])) {
            $savedData = json_decode($_COOKIE['user_data'], true);
            if ($savedData['username'] === $username) {
                $_SESSION = $savedData;  // Pulihkan data dari cookie
            } else {
                $_SESSION['username'] = $username;
                $_SESSION['is_submitted'] = false;  // Reset untuk user baru
                $_SESSION['is_accepted'] = false;
            }
        } else {
            // Jika tidak ada cookie, buat sesi baru
            $_SESSION['username'] = $username;
            $_SESSION['is_submitted'] = false;
            $_SESSION['is_accepted'] = false;
        }

        header('Location: dashboard.php');  // Redirect ke dashboard
        exit();
    } else {
        echo 'Invalid login credentials';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OVENT</title>
    <link rel="stylesheet" href="user_relog.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <!-- Overlay -->
    <div class="overlay"></div>

    <!-- Container -->
    <div class="container">
        <!-- Bagian Kiri -->
        <div class="Kiri">
            <div class="bungkusKiri">                
                <a href="form_register_user.php" class="tabLogin">
                    Sign Up
                </a>
                <p class="tema fontPutih">
                    Event Organizer
                </p>
                <p class="logo">
                    <span class="fontCokelat">O</span><span class="fontPutih">VENT</span>
                </p>
                <p class="moto fontPutih">
                    Your favorite event organizer @Ovent
                </p>
            </div>
        </div>

        <?php
        if (isset($_SESSION['error'])) {
            echo '<div style="color: red;">' . $_SESSION['error'] . '</div>';
            unset($_SESSION['error']); // Clear the error message after displaying it
        }
        ?>

        <!-- Bagian Kanan -->
        <div class="Kanan">
            <div class="bungkusKanan">
                <div class="titleRelog">
                    <p class="titleForm">
                        <span class="fontHitam">Let's<br>Organized</span><span class="fontCokelat">.</span>
                    </p>
                    <p class="descForm">
                        <span class="fontHitam">Hello! Welcome back to OVENT</span>
                    </p>
                </div>                
                <!-- Formulir -->
                <form action="proses_login_user.php" method="post">
                    <!-- Username -->
                    <div class="list-data">
                        <label for="username" class="fontHitam Font_Size">Username</label><br>
                        <div class="group">  
                            <i class="fa-solid fa-user icon"></i>                  
                            <input class="input-data" type="text" name="username" required/><br />
                        </div>
                    </div>
                    <!-- Email -->
                    <div class="list-data">                        
                        <label for="email" class="fontHitam Font_Size">Email</label><br>
                        <div class="group"> 
                            <i class="fa-regular fa-envelope icon"></i>                           
                            <input class="input-data" type="email" name="email" required/><br />
                        </div>
                    </div>
        
                    <!-- Password -->
                    <div class="list-data">                        
                        <label for="password">Password</label><br>
                        <div class="group">            
                            <i class="fa-solid fa-lock icon"></i>                
                            <input class="input-data" type="password" name="password" required/><br />
                        </div>
                    </div>
                    <!-- Tombol Sign In -->
                    <button class="buttonRelog" type="submit">Sign In</button>
                </form>
                <p class="info Font_Size">
                    <span>Don't have an account? </span><span><a href="form_register_user.php">Sign Up</a></span>
                </p>
            </div>
        </div>

    </div>
</body>
</html>
