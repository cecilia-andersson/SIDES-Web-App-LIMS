<!DOCTYPE html>
<html>

<head>
    <title>Update Contraceptive</title>
    <link href="../images/SIDES_head_icon.png" rel="icon">
</head>

<body>
    <header>
    <?php
    include "../navigation.php";
    ?>
    </header>

<?php
// Connect to database
include "../DB_connect.php";
?>

<p> Form to update current contraceptive in database will go here. <br>
Action should: <br>
1. Add current drug_id, current start date, and current timestamp (by default,
or inputted date preferrably) to the user's "past drugs" table (not yet created).

<strong>2. Replace current drug_id with newly selected drug_id, record inputted date (mandatory field?) </p>
</strong>

<!-- DROPDOWN FORM -->
<?php
session_start();
//this works to get userid!
if(isset($_SESSION['username'])) {
    $userid = $_SESSION['id'];
    echo $userid; 
} else {
    echo "didnt work";
}


?>

<?php
// Print current drug

// Use input from form to update current drug; add change to change log
$sql_first = "UPDATE users(current_drug)
SET current_drug = $FETCHEDFROMDROPDOWN ,
WHERE userid = userid";

//$sql_second = "INSERT INTO change_drug_tracker(userid, drug_id, operation, datestamp)
//VALUES ($USERID, $NEWDRUG, 'Update', CURDATE() ),
//";


// Footer
include "../footer.php";

// Close the database connection
mysqli_close($link);
?>
</body>
</html>