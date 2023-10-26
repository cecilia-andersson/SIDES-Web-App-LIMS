<?php

include "../DB_connect.php";
session_start();

if (isset($_SESSION['id']) && isset($_POST['comment_text'])) {
    $comment_text = $_POST['comment_text'];
    $user_id = $_SESSION['id'];
    $user_drug_id = getUserDrugIdForUser($link, $user_id);
    $comment_date = date("Y-m-d H:i:s");
    $comment_likes = 0;
    $post_id = $_GET['postID'];

    $sql = "INSERT INTO comments (user_id, post_id, comment_text, comment_likes, comment_date) VALUES (?, ?, ?, ?, ?)";
    $stmt1 = $link->prepare($sql);
    $stmt1->bind_param("iisis", $user_id, $post_id, $comment_text, $comment_likes, $comment_date);
    $result1 = $stmt1->execute();

    if ($result1){
        header("Location:/user_profile/post_w_comments.php?postID=$post_id");
    die;
    }else{
        header("Location:/user_profile/post_w_comments.php?postID=$post_id");
    die;
    }


}


function getUserDrugIdForUser($link, $userid) {
    $sql = "SELECT user_drug_id FROM user_drug WHERE userid = $userid";
    $result = $link->query($sql);

    if ($result ->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row) {
            return $row['user_drug_id'];
        } else {
            return null;
        }
    } else {
        return null;
    }
}

?>