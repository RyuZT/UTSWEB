<?php
session_start(); 
?>

<!DOCTYPE html>
<html>
<head>
    <title>OVENT</title>
</head>
<body>
    <div class="container">
        <h1>OVENT</h1>

        <?php
        if (isset($_SESSION['error'])) {
            echo '<div style="color: red;">' . $_SESSION['error'] . '</div>';
            unset($_SESSION['error']); // Clear the error message after displaying it
        }
        ?>
        
        <form action="proses_login_user.php" method="post">
            <label for="username">Username</label><br>
            <input type="text" name="username" required/><br />
            <label for="email">Email</label><br>
            <input type="email" name="email" required/><br />
            <label for="password">Password</label><br>
            <input type="password" name="password" required/><br />
            <button type="button" onclick="window.location.href='index.php'">Login</button>
        </form>
    </div>
</body>
</html>
