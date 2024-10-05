<?php
session_start(); // Make sure this is at the top of the file
?>

<!DOCTYPE html>
<html>
<head>
    <title>OVENT</title>
</head>
<body>
    <div class="container">
        <h1>OVENT</h1>

        <!-- Display error messages if they exist -->
        <?php
        if (isset($_SESSION['error'])) {
            echo '<div style="color: red;">' . $_SESSION['error'] . '</div>';
            unset($_SESSION['error']); // Clear the error message after displaying it
        }
        ?>
        <form action="proses_register_admin.php" method="post">
            <label for="username">Username</label><br>
            <input type="text" name="username" /><br />
            <label for="email">Email</label><br>
            <input type="email" name="email" /><br />
            <label for="password">Password</label><br>
            <input type="password" name="password" /><br />
            <input type="submit" value="Register" /> 
        </form>

   
    </div>
</body>
</html>
