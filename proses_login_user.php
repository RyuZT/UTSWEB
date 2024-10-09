<?php
session_start(); // Make sure this is at the top of the file

// Form data
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

// Check if all fields are filled
if (empty($username) || empty($email) || empty($password)) {
    $_SESSION['error'] = 'Please fill all fields.';
    header('Location: form_login_user.php'); // Redirect back to the form
    exit(); // Stop further execution
}

try {
    // Database connection
    $dsn = "mysql:host=localhost;dbname=uts_group_5";
    $kunci = new PDO($dsn, "root", "");
    
    // SQL query to check if the user exists
    $sql = "SELECT password FROM users WHERE username = ? AND email = ?";
    $stmt = $kunci->prepare($sql);
    $stmt->execute([$username, $email]);
    
    // Fetch the user record
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the user exists
    if (!$user) {
        $_SESSION['error'] = 'Username or email does not exist.';
        header('Location: form_login_user.php'); // Redirect back to the form
        exit(); // Stop further execution
    }

    // Check if the password is correct
    if (!password_verify($password, $user['password'])) {
        $_SESSION['error'] = 'Incorrect password.';
        header('Location: form_login_user.php'); // Redirect back to the form
        exit(); // Stop further execution
    }

    // If login is successful, you can set session variables or proceed as needed
    $_SESSION['username'] = $username; // Example of setting a session variable
    // Redirect to a protected page (e.g., dashboard)
    header('Location: dashboard.php'); // Change this to your actual protected page
    exit(); // Stop further execution

} catch (PDOException $e) {
    $_SESSION['error'] = "Silahkan register Terlebih dahulu " . $e->getMessage();
    header('Location: form_login_user.php'); // Redirect back to the form on error
    exit(); // Stop further execution
}
?>
