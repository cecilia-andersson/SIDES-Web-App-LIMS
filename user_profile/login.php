<?php

session_start();
include "../DB_connect.php";
$ip=$_SERVER['REMOTE_ADDR'];

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$block_ip = "SELECT * FROM block_ip WHERE ip = '$ip'";
$result = $link->query($block_ip);
if ($result->num_rows >= 1) { 
    $row = $result->fetch_assoc();

    $expFormat = mktime(date("H"), date("i"), date("s"), date("m") ,date("d"), date("Y"));
    $currentDateTime = date("Y-m-d H:i:s",$expFormat);

    if ($currentDateTime <= $row['expiry']) { // still blocked
        $curr = strtotime($currentDateTime);
        $exp = strtotime($row['expiry']);
        $minutesLeft = abs(round(($exp - $curr) / 60));

        $message = "You are blocked from logging in from too many attempts.\r\n";
        $message.= "Try again in $minutesLeft minutes.";
        $message = urlencode($message);
        header("Location:login_page.php?Message=".$message);
        exit();
    }
    else { // no longer blocked
        $deleteQuery = "DELETE FROM block_ip WHERE ip = '$ip'";
        $result = $link->query($deleteQuery);
        $_SESSION["LoginAttempt"] = 0;
    }    
}

// increase login attempts
if (isset($_SESSION["LoginAttempt"])) {
    $_SESSION["LoginAttempt"] += 1;

    if ($_SESSION["LoginAttempt"] >= 5) {
        $expFormat = mktime(date("H")+1, date("i"), date("s"), date("m") ,date("d"), date("Y"));
        $expiry = date("Y-m-d H:i:s",$expFormat);

        // don't if user already exists
        $sql1 = "INSERT INTO block_ip (ip, expiry) VALUES (?, ?)";
        $stmt1 = $link->prepare($sql1);
        $stmt1->bind_param("ss", $ip, $expiry);
        $result1 = $stmt1->execute();

        $message = urlencode("You exceeded the number of allowed login attempts and will be blocked from logging in for 1 hour.");
        header("Location:login_page.php?Message=".$message);
        exit();
    }
}
else {
    $_SESSION["LoginAttempt"] = 1;
}

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