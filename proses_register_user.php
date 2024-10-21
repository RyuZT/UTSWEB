<?php
$firstnameErr = $lastnameErr = $usernameErr = $emailErr = $passwordErr = $confirmPasswordErr = "";
$firstname = $lastname = $username = $email = $password = $confirmPassword = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "config.php";

    $firstname = test_input($_POST["firstname"]);
    $lastname = test_input($_POST["lastname"]);
    $username = test_input($_POST["username"]);
    $email = test_input($_POST["email"]);
    $password = $_POST["password"]; // Don't use test_input for password
    $confirmPassword = $_POST["confirm_password"];

    $valid = true;

    // Check if username already exists
    $check_sql = "SELECT * FROM users WHERE username = ?";
    $check_stmt = mysqli_prepare($conn, $check_sql);
    mysqli_stmt_bind_param($check_stmt, "s", $username);
    mysqli_stmt_execute($check_stmt);
    $check_result = mysqli_stmt_get_result($check_stmt);
    
    if (mysqli_num_rows($check_result) > 0) {
        $usernameErr = "Username already exists";
        $valid = false;
        echo "<script>alert('Username already exists');</script>";
    }

    // Check if email already exists
    $check_sql = "SELECT * FROM users WHERE email = ?";
    $check_stmt = mysqli_prepare($conn, $check_sql);
    mysqli_stmt_bind_param($check_stmt, "s", $email);
    mysqli_stmt_execute($check_stmt);
    $check_result = mysqli_stmt_get_result($check_stmt);
    
    if (mysqli_num_rows($check_result) > 0) {
        $emailErr = "Email already exists";
        $valid = false;
        echo "<script>alert('Email already exists');</script>";
    }

    if ($password !== $confirmPassword) {
        $confirmPasswordErr = "Passwords do not match";
        $valid = false;
        echo "<script>alert('Passwords do not match');</script>";
    }

    if ($valid) {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare SQL query
        $sql = "INSERT INTO users (firstname, lastname, username, email, password) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        
        // Bind parameters and execute
        mysqli_stmt_bind_param($stmt, "sssss", $firstname, $lastname, $username, $email, $hashed_password);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>
                alert('Registration successful!');
                window.location.href = 'index.php';
            </script>";
        } else {
            echo "<script>alert('Something went wrong. Please try again later.');</script>";
        }

        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>