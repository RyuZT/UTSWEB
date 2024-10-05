<?php
// Form data:
$frontname = $_POST['frontname'];
$lastname = $_POST['lastname'];
$lastname = $_POST['lastname'];
$email = $_POST['email'];
$password = $_POST['password'];
$cpassword = $_POST['cpassword'];

if ($frontname && $lastname && $email && $password && $cpassword){

    if($password==$cpassword) {
        $dsn = "mysql:host=localhost;dbname=uts_group_5";
$kunci = new PDO($dsn, "root", "");

// 2. Buat query SQL, pastikan kolom didefinisikan sesuai
$sql = "INSERT INTO ms_user (email, password) VALUES (?, ?)";

// 3. Persiapkan statement dan eksekusi dengan data
$stmt = $kunci->prepare($sql);
$data = [$email, $password];
$stmt->execute($data);

echo "Register Successfully";
    }else{
        echo "Please fill the blank box";
        
    }

}

?>
x