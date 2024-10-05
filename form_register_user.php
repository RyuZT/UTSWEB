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
    $valid = true;

    // Validasi input
    if (empty($_POST["firstname"])) {
        $firstnameErr = "First name is required";
        $valid = false;
    } else {
        $firstname = test_input($_POST["firstname"]);
    }

    if (empty($_POST["lastname"])) {
        $lastnameErr = "Last name is required";
        $valid = false;
    } else {
        $lastname = test_input($_POST["lastname"]);
    }

    if (empty($_POST["username"])) {
        $usernameErr = "Username is required";
        $valid = false;
    } else {
        $username = test_input($_POST["username"]);
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
        $valid = false;
    } else {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
            $valid = false;
        }
    }

    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
        $valid = false;
    } else {
        $password = test_input($_POST["password"]);
    }

    if (empty($_POST["confirm_password"])) {
        $confirmPasswordErr = "Please confirm your password";
        $valid = false;
    } else {
        $confirmPassword = test_input($_POST["confirm_password"]);
        if ($password !== $confirmPassword) {
            $confirmPasswordErr = "Passwords do not match";
            $valid = false;
        }
    }

    // Jika validasi berhasil
    if ($valid) {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Masukkan data ke database
        require_once "proses_register_user.php";

        try {
            $sql = "INSERT INTO users (firstname, lastname, username, email, password) VALUES (:firstname, :lastname, :username, :email, :password)";
            $stmt = $pdo->prepare($sql);

            // Bind parameters
            $stmt->bindParam(':firstname', $firstname);
            $stmt->bindParam(':lastname', $lastname);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashed_password);

            // Execute statement
            if ($stmt->execute()) {
                echo "Registration successful!";
            } else {
                echo "Something went wrong. Please try again later.";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        // Tutup koneksi
        $pdo = null;
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
    First Name: <input type="text" name="firstname" value="<?php echo $firstname;?>">
    <span><?php echo $firstnameErr;?></span>
    <br><br>

    Last Name: <input type="text" name="lastname" value="<?php echo $lastname;?>">
    <span><?php echo $lastnameErr;?></span>
    <br><br>

    Username: <input type="text" name="username" value="<?php echo $username;?>">
    <span><?php echo $usernameErr;?></span>
    <br><br>

    Email: <input type="text" name="email" value="<?php echo $email;?>">
    <span><?php echo $emailErr;?></span>
    <br><br>

    Password: <input type="password" name="password">
    <span><?php echo $passwordErr;?></span>
    <br><br>

    Confirm Password: <input type="password" name="confirm_password">
    <span><?php echo $confirmPasswordErr;?></span>
    <br><br>

    <input type="submit" value="Register">
</form>
<a href="form_login_user.php">Login As User</a>
</body>
</html>
