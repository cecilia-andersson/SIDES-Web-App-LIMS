<?php
include "../DB_connect.php";
session_start();

if (isset($_SESSION['username']) && isset($_SESSION["id"])) {
    $userid = $_SESSION['id'];
}

$startdate = $_POST['start'];
$enddate= $_POST['end'];
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

$sql = "INSERT INTO user_drug(userid, drug_id, startdate, enddate) VALUES (?,?,?,?)";
$stmt2 = $link->prepare($sql);
$stmt2->bind_param("iiss", $userid, $drug_id, $startdate, $enddate);
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
<footer>
        <?php
            include "../footer.php";
        ?>
    </footer>
</html>