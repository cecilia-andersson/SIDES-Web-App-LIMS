<?php
include "../DB_connect.php";

session_start();

if (isset($_POST['commentID']) && isset($_POST['userID'])) {
    
    $commentID = $_POST['commentID'];
    $userID = $_POST['userID'];


   

    // Prepare the SELECT query to check if the user has already liked the post
    $checkLikedQuery = "SELECT * FROM likes_comments WHERE comment_id = ? AND user_id = ?";
    $checkLikedStmt = $link->prepare($checkLikedQuery);
    $checkLikedStmt->bind_param("ii", $commentID, $userID);
    $checkLikedStmt->execute();
    $checkLikedResult = $checkLikedStmt->get_result();

    echo 'hej';

    if ($checkLikedResult->num_rows == 0) {
        // User has not liked the post, insert a new like
        echo 'hej';
        $insertLikeQuery = "INSERT INTO likes_comments (comment_id, user_id) VALUES (?, ?)";
        $insertLikeStmt = $link->prepare($insertLikeQuery);
        $insertLikeStmt->bind_param("ii", $commentID, $userID);
        

        if (!$insertLikeStmt->execute()) {
            echo "Error inserting like: " . $insertLikeStmt->error;
        } else {
            echo 'Like inserted successfully.';
        }
        
        echo 'bla';

        // Update the likes count in the forum_posts table
        $updateLikesQuery = "UPDATE comments SET comment_likes = comment_likes + 1 WHERE commentid = ?";
        $updateLikesStmt = $link->prepare($updateLikesQuery);
        $updateLikesStmt->bind_param("i", $commentID);
        echo 'Update Query: ' . $updateLikesQuery;
        

        if (!$updateLikesStmt->execute()) {
            echo "Error updating likes count: " . $updateLikesStmt->error;
        } else {
            echo 'Likes count updated successfully.';
        }



        // Close the prepared statements
        $insertLikeStmt->close();
        $updateLikesStmt->close();

    }

    else{
        $deleteLikeQuery = "DELETE FROM likes_comments WHERE comment_id = ? AND user_id = ?";
        $deleteLikeStmt = $link->prepare($deleteLikeQuery);
        $deleteLikeStmt->bind_param("ii", $commentID, $userID);
        $deleteLikeStmt->execute();

        $updateLikesQuery = "UPDATE comments SET comment_likes = comment_likes - 1 WHERE commentid = ?";
        $updateLikesStmt = $link->prepare($updateLikesQuery);
        $updateLikesStmt->bind_param("i", $commentID);
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