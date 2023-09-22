<?php

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "sides";

$link = mysqli_connect($servername, $username, $password, $dbname);

if (mysqli_connect_error()) {
    die("Connection failed: " . mysqli_connect_error()); 
}

$inputUsername = $_POST['username'];
$inputPassword = $_POST['login_password'];
$sql = "SELECT pwd FROM users WHERE username = '$inputUsername'";
$result = $link->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        if (password_verify($inputPassword, $row["pwd"])) {
            $message = urlencode("You are now logged in");
            header("Location:../index.php?Message=".$message);
            die;
        }
        else {
            $message = urlencode("Wrong password. Please try again.");
            header("Location:login_page.php?Message=".$message);
            die;
        }
    }
} else {
    $message = urlencode("No matching username in database");
            header("Location:login_page.php?Message=".$message);
            die;
}


$link->close();
?>