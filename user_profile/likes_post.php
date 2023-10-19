<?php
include "../DB_connect.php";

session_start();

if (isset($_POST['postID']) && isset($_POST['userID'])) {
    // Get data from the form
    $postID = $_POST['postID'];
    $userID = $_POST['userID'];

   

    // Prepare the SELECT query to check if the user has already liked the post
    $checkLikedQuery = "SELECT * FROM post_likes WHERE post_id = ? AND user_id = ?";
    $checkLikedStmt = $link->prepare($checkLikedQuery);
    $checkLikedStmt->bind_param("ii", $postID, $userID);
    $checkLikedStmt->execute();
    $checkLikedResult = $checkLikedStmt->get_result();

    if ($checkLikedResult->num_rows == 0) {
        // User has not liked the post, insert a new like
        $insertLikeQuery = "INSERT INTO post_likes (post_id, user_id) VALUES (?, ?)";
        $insertLikeStmt = $link->prepare($insertLikeQuery);
        $insertLikeStmt->bind_param("ii", $postID, $userID);
        $insertLikeStmt->execute();
        //if ($insertLikeStmt->error) {
        //    echo "Error inserting like: " . $insertLikeStmt->error;
       // }

        // Update the likes count in the forum_posts table
        $updateLikesQuery = "UPDATE forum_posts SET post_likes = post_likes + 1 WHERE post_id = ?";
        $updateLikesStmt = $link->prepare($updateLikesQuery);
        $updateLikesStmt->bind_param("i", $postID);
        $updateLikesStmt->execute();

        

        // Close the prepared statements
        $insertLikeStmt->close();
        $updateLikesStmt->close();

    }

    else{
        $deleteLikeQuery = "DELETE FROM post_likes WHERE post_id = ? AND user_id = ?";
        $deleteLikeStmt = $link->prepare($deleteLikeQuery);
        $deleteLikeStmt->bind_param("ii", $postID, $userID);
        $deleteLikeStmt->execute();

        $updateLikesQuery = "UPDATE forum_posts SET post_likes = post_likes - 1 WHERE post_id = ?";
        $updateLikesStmt = $link->prepare($updateLikesQuery);
        $updateLikesStmt->bind_param("i", $postID);
        $updateLikesStmt->execute();

        $deleteLikeStmt->close();
        $updateLikesStmt->close();
        
    }

    // Close the prepared statement
    $checkLikedStmt->close();

    // Close the database connection
    $link->close();
}

$previousPage = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'default_page.php';
header("Location: $previousPage");

exit();
?>