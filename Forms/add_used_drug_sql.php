<?php
include "../DB_connect.php";
session_start();

if (isset($_SESSION['username']) && isset($_SESSION["id"])) {
    $userid = $_SESSION['id'];
}

$startdate = $_POST['start'];
$contraceptive = $_POST['drug'];

$sql_drug = "SELECT drug_id FROM drugs WHERE drug_brand = '$contraceptive'";
$result = $link->query($sql_drug);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $drug_id = $row["drug_id"];
} else {
    $message = urlencode("Error:No such drug found");
    header("Location:add_drug_form.php?Message=" . $message);
    die;
}

$sql = "INSERT INTO user_drug(userid, drug_id, startdate) VALUES (?,?,?)";
$stmt2 = $link->prepare($sql);
$stmt2->bind_param("iis", $userid, $drug_id, $startdate);
$result = $stmt2->execute();

if ($result) {
    $message = urlencode("Contraceptive added successfully");
    header("Location:add_drug_form.php?Message=" . $message);
    die;
} else {
    $message = urlencode("Error: Contraceptive could not be added");
    header("Location:add_drug_form.php?Message=" . $message);
    die;
}

?>