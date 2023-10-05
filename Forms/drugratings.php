<!DOCTYPE html>
<html>
    <header>
        <?php
            include "../navigation.php";
            include "../DB_connect.php";
        ?>
    </header>
<?php
if (isset($_SESSION['username'])) {
    $UserID = $_SESSION['id'];
} else {
    echo "didn't work";
}
$drugtorate = $_POST['drug'];
$rating = $_POST['rating'];
$textreview = $_POST['txtreview'];

// Get drug_id for drug to rate and set as local variable $DrugID
$drugIDsql = "SELECT drug_id
FROM drugs
WHERE drug_brand = '$drugtorate'";
$result1 = $link->query($drugIDsql);
$row1= $result1->fetch_assoc();

$DrugID = $row1['drug_id'];

// INSERTING OR CHANGING A REVIEW FOR A DRUG FROM A USER
// Check to see if review already exists
$check_query = "SELECT COUNT(*) AS count FROM review WHERE drug_id = ? AND userid = ?";
$check_statement = $link->prepare($check_query);
if ($check_statement) {
    $check_statement->bind_param("ii", $DrugID, $UserID);
    $check_statement->execute();
    $check_result = $check_statement->get_result();
    $row = $check_result->fetch_assoc();

    if ($row['count'] > 0) {
        // A review entry already exists, so update it
        $update_review = $link->prepare("UPDATE review SET rating = ?, text_review = ? WHERE userid = ? AND drug_id = ?");
        if ($update_review) {
            $update_review->bind_param("issi", $rating, $textreview, $UserID, $DrugID);
            if ($update_review->execute()) {
                echo "Review of $drugtorate successfully updated.";
            } else {
                echo "Error:" . $update_review->error;
            }
            $update_review->close();
        } else {
            "Error preparing the UPDATE statement: " . $link->error;
        }
    } else {
        // A review entry doesn't exist, so inserting one
        $review_first = $link->prepare("INSERT INTO review (userid, drug_id, rating, text_review) VALUES (?, ?, ?, ?)");
        if ($review_first) {
            $review_first->bind_param("iiss", $UserID, $DrugID, $rating, $textreview);
            if($review_first->execute()) {
                echo "Review for $drugtorate inserted successfully.";
            } else {
                echo "Error: " . $review_first->error;
            }
            $review_first->close();
        } else {
            echo "Error preparing INSERT statement: " . $link->error;
        }
    }
}
?>

<p>
<br>
Thanks for your review of <?php echo $drugtorate ?>!
<br>
You rated this medication <?php echo $rating ?> stars, and had this to say about it: <br><br>
" <?php echo $textreview ?> "
<br>
<form action="../user_profile/myprofile.php" method="POST">
    <input type="submit" value="My profile">
</form>

</p>

<?php
mysqli_close($link);
?>
    <footer>
        <?php
            include "../footer.php";
        ?>
    </footer>
</html>