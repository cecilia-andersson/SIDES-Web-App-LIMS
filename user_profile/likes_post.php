<?php


include "../DB_connect.php";

session_start();

$postID = $_POST['postID'];
$userID = $_POST['userID']; // Assuming you have the user ID available

// Check if the user has already liked the post
$checkQuery = "SELECT * FROM forum_likes WHERE userid = $userID AND post_id = $postID";
$checkResult = $conn->query($checkQuery);

if ($checkResult->num_rows === 0) {
    // The user has not liked the post yet, proceed to update likes

    // Insert a record into the forum_likes table
    $insertQuery = "INSERT INTO forum_likes (userid, post_id) VALUES ($userID, $postID)";
    $conn->query($insertQuery);

    // Update the likes for the post
    $updateQuery = "UPDATE forum_posts SET post_likes = post_likes + 1 WHERE post_id = $postID";
    $conn->query($updateQuery);
    header("Location:/LIMS-Flubber/user_profile/forum.php"); /*?postID=$postID*/
    exit();

} else {
    header("Location:/LIMS-Flubber/user_profile/forum.php");
}

?>