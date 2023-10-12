<?php

include "../DB_connect.php";
session_start();


if (isset($_SESSION['id']) && isset($_POST['post_text'])) {
    $post_text = $_POST['post_text'];
    $userid = $_SESSION['id'];
    $user_drug_id = getUserDrugIdForUser($link, $userid);
    $post_date = date("Y-m-d H:i:s");
    $post_likes = 0;





    $sql = "INSERT INTO forum_posts (userid, user_drug_id, post_text, post_date, post_likes) VALUES (?, ?, ?, ?, ?)";
    $stmt1 = $link->prepare($sql);
    $stmt1->bind_param("iissi", $userid, $user_drug_id, $post_text, $post_date, $post_likes);
    $result1 = $stmt1->execute();

    if ($result1){
        header("Location:/LIMS-Flubber/user_profile/forum.php");
    die;
    }else{
        header("Location:/LIMS-Flubber/user_profile/forum.php");
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