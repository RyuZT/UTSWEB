<!-- PHP -->
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
        echo "<script>alert('$confirmPasswordErr');</script>";
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
            echo "<script>alert('Registration successful!');</script>";
        } else {
            echo "<script>alert('Something went wrong. Please try again later.');</script>";
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

<!-- HTML -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="user_regis.css">
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
                <a href="form_login_user.php" class="tabLogin">
                    Sign In
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

        <!-- Bagian Kanan -->
        <div class="Kanan">
            <div class="bungkusKanan">
                <div class="titleRegis">
                    <p class="titleForm">
                        <span class="fontHitam">Create New<br>Account</span><span class="fontCokelat">.</span>
                    </p>
                    <p class="descForm">
                        <span class="fontHitam">Start your journey with OVENT</span>
                    </p>
                </div>

                <!-- Formulir -->
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <!-- Name -->
                    <div class="regisName list-data">
                        <div>
                            <span class="fontHitam Font_Size">First Name<br></span>
                            <div class="group">                                
                                <input class="input-nama" type="text" name="firstname" required value="<?php echo $firstname;?>">
                                <span><?php echo $firstnameErr;?></span>
                            </div>
                        </div>   
                        <div>
                            <span class="fontHitam Font_Size">Last Name<br></span>
                            <div class="group">                                
                                <input class="input-nama" type="text" name="lastname" required value="<?php echo $lastname;?>">
                                <span><?php echo $lastnameErr;?></span>
                            </div>
                        </div>
                    </div>

                    <!-- UserName -->
                    <div class="list-data">       
                        <span class="fontHitam Font_Size">Username<br></span>
                        <div class="group">
                            <i class="fa-solid fa-user icon"></i>
                            <input class="input-data" type="text" name="username" required value="<?php echo $username;?>">
                            <span><?php echo $usernameErr;?></span> 
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="list-data">
                        <span class="fontHitam Font_Size">Email<br></span>
                        <div class="group">   
                            <i class="fa-regular fa-envelope icon"></i>                             
                            <input class="input-data" type="email" name="email" required value="<?php echo $email;?>">
                            <span><?php echo $emailErr;?></span>
                        </div>
                    </div>

                    <!-- Password + Confirm -->
                    <div class="list-data">
                        <span class="fontHitam Font_Size">Password<br></span>
                        <div class="group">
                            <i class="fa-solid fa-lock icon"></i>
                            <input class="input-data" type="password" name="password" required>
                            <span><?php echo $passwordErr;?></span>
                        </div>
                        
                    </div>
                    <div class="list-data">
                        <span class="fontHitam Font_Size">Confirm Password<br></span>
                        <div class="group">    
                            <i class="fa-solid fa-lock icon"></i>                        
                            <input class="input-data" type="password" name="confirm_password" required>
                        </div>                       
                    </div>
                    <input class="buttonRegis" type="submit" value="Create Account">
                </form>
                <p class="info Font_Size">
                    <span>Alredy have an account? </span><span><a href="form_login_user.php">Sign In</a></span>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
