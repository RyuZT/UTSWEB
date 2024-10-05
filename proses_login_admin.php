<?php
session_start(); // Make sure this is at the top of the file

// Form data
$frontname = $_POST['frontname'];
$lastname = $_POST['lastname'];
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$cpassword = $_POST['cpassword'];

// Check if all fields are filled
if (empty($frontname) && empty($lastname) && empty($username) && empty($email) && empty($password) && empty($cpassword)) {
    $_SESSION['error'] = 'Please fill all fields.';
    header('Location: form_register.php'); // Redirect back to the form
    exit(); // Stop further execution
}

// Check if the passwords match
if ($password != $cpassword) {
    $_SESSION['error'] = 'Passwords do not match.';
    header('Location: form_register.php'); // Redirect back to the form
    exit(); // Stop further execution
}

try {
    // Database connection
    $dsn = "mysql:host=localhost;dbname=uts_group_5";
    $kunci = new PDO($dsn, "root", "");

    // SQL query
    $sql = "INSERT INTO ms_user (email, password) VALUES (?, ?)";

    // Prepare and execute statement
    $stmt = $kunci->prepare($sql);
    $data = [$email, $password];
    $stmt->execute($data);

    // Registration successful
    echo "Register Successfully";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
