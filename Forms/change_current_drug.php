<?php
include "../DB_connect.php";
session_start();

if (isset($_SESSION['username']) && isset($_SESSION["id"])) {
    $userid = $_SESSION['id'];
}

$startdate = $_POST['start'];
$enddate = $_POST['end'];
$contraceptive = $_POST['drug'];

$sql_drug = "SELECT drug_id FROM drugs WHERE drug_brand = '$contraceptive'";
$result = $link->query($sql_drug);

if ($result->num_rows >= 0) {
    $row = $result->fetch_assoc();
    $drug_id = $row["drug_id"];
} else {
    $message = urlencode("Error:No such drug found");
    header("Location:change_current_drug.php?Message=" . $message);
    die;
}

//fetch most recent drug

$current_drug = "SELECT user_drug_id FROM user_drug WHERE userid = '$userid' ORDER BY user_drug_id DESC";
$stmt1 = $link->query($current_drug);
$trial1 = $stmt1->fetch_assoc();
$trial = $trial1["user_drug_id"];


//make prepared statement!
$sql2 = "UPDATE user_drug SET enddate = '$enddate' WHERE userid = '$userid' AND user_drug_id = '$trial'";
$result2 = $link->query($sql2);

$sql = "INSERT INTO user_drug(userid, drug_id, startdate) VALUES (?,?,?)";
$stmt2 = $link->prepare($sql);
$stmt2->bind_param("iis", $userid, $drug_id, $startdate);
$result = $stmt2->execute();



if ($result) {
    $message = urlencode("Contraceptive updated successfully");
    header("Location:change_current_drug.php?Message=" . $message);
    die;
}
?>

<!DOCTYPE html>
<html>
<header>
    <?php
    include "../navigation.php";
    include "../DB_connect.php";
    ?>
</header>
<h3>Contraceptive updated successfully!</h3>

<form action="../user_profile/myprofile.php" method="POST">
<input type="submit" value="My Profile">
</form>

<footer>
    <?php
    include "../footer.php";
    include "../Logging_and_posts/process_form.php";
    ?>
</footer>

</html>