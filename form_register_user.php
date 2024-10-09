<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>

<?php
$firstnameErr = $lastnameErr = $usernameErr = $emailErr = $passwordErr = $confirmPasswordErr = "";
$firstname = $lastname = $username = $email = $password = $confirmPassword = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "config.php"; // Include config for database connection

    $firstname = test_input($_POST["firstname"]);
    $lastname = test_input($_POST["lastname"]);
    $username = test_input($_POST["username"]);
    $email = test_input($_POST["email"]);
    $password = test_input($_POST["password"]);
    $confirmPassword = test_input($_POST["confirm_password"]);

    $valid = true;

    if ($password !== $confirmPassword) {
        $confirmPasswordErr = "Passwords do not match";
        $valid = false;
    }

    if ($valid) {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare SQL query using mysqli
        $sql = "INSERT INTO users (firstname, lastname, username, email, password) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);

        // Bind parameters and execute the statement
        mysqli_stmt_bind_param($stmt, "sssss", $firstname, $lastname, $username, $email, $hashed_password);

        if (mysqli_stmt_execute($stmt)) {
            echo "Registration successful!";
        } else {
            echo "Something went wrong. Please try again later.";
        }

        // Close the statement and connection
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

<h2>Register</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    First Name: <input type="text" name="firstname" required value="<?php echo $firstname;?>">
    <span><?php echo $firstnameErr;?></span>
    <br><br>

    Last Name: <input type="text" name="lastname" required value="<?php echo $lastname;?>">
    <span><?php echo $lastnameErr;?></span>
    <br><br>

    Username: <input type="text" name="username" required value="<?php echo $username;?>">
    <span><?php echo $usernameErr;?></span>
    <br><br>

    Email: <input type="email" name="email" required value="<?php echo $email;?>">
    <span><?php echo $emailErr;?></span>
    <br><br>

    Password: <input type="password" name="password" required>
    <span><?php echo $passwordErr;?></span>
    <br><br>

    Confirm Password: <input type="password" name="confirm_password" required>
    <span><?php echo $confirmPasswordErr;?></span>
    <br><br>

    <input type="submit" value="Register">
</form>
<a href="form_login_user.php">Login As User</a>
</body>
</html>
