<?php

session_start();

include "../DB_connect.php";

if (isset($_POST['username']) && isset($_POST['login_password'])) {
    function validate($data){
        $data = trim($data);
        $data = htmlspecialchars($data);
        return $data;
}
}

$inputUsername = validate($_POST['username']);
$inputPassword = validate($_POST['login_password']);

$sql = "SELECT * FROM users WHERE username = '$inputUsername'";
$result = $link->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();

    if (password_verify($inputPassword, $row["pwd"])) {
        $_SESSION['username'] = $inputUsername;
        $_SESSION['id'] = $row['userid'];
        $_SESSION['personalnumber'] = $row['birthdate'];
        header("Location:myprofile.php");
        die;
    }
    else {
        $message = urlencode("Incorrect username or password. Please try again.");
        header("Location:login_page.php?Message=".$message);
        die;
    }
    
} else {
    $message = urlencode("Incorrect username or password. Please try again.");
            header("Location:login_page.php?Message=".$message);
            die;
}

?>