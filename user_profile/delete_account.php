<!DOCTYPE html>
<html>

<head>
    <title>Delete account</title>
    <link href="../images/SIDES_head_icon.png" rel="icon">
</head>
<body>
    <header>
        <?php
        include "../navigation.php";
        include "../DB_connect.php";
        ?>
    </header>
    <p>
    <?php

    if (isset($_SESSION['username'])) {
        $loggedInUser = $_SESSION['username'];
        $userid = $_SESSION['id'];

        $sql_likes_comments = "DELETE FROM likes_comments WHERE user_id=$userid";
        $result_likes_comments = $link->query($sql_likes_comments);

        $sql_post_likes = "DELETE FROM post_likes WHERE user_id=$userid";
        $result_post_likes = $link->query($sql_post_likes);

        $sql_comments = "DELETE FROM comments WHERE user_id=$userid";
        $result_comments = $link->query($sql_comments);

        $sql_posts = "DELETE FROM forum_posts WHERE userid=$userid";
        $result_posts = $link->query($sql_posts);
        
        $sql_reviews = "DELETE FROM review WHERE userid=$userid";
        $result_reviews = $link->query($sql_reviews);
        
        $sql_reports = "DELETE FROM report WHERE userid=$userid";
        $result_reports = $link->query($sql_reports);

        $sql_user_drug = "DELETE FROM user_drug WHERE userid=$userid";
        $result_user_drug = $link->query($sql_user_drug);

        $sql_user = "DELETE FROM users WHERE userid=$userid";
        $result_user = $link->query($sql_user);


        if ($result_likes_comments && $result_post_likes && $result_comments && $result_posts && $result_reviews && $result_reports && $result_user_drug && $result_user) {
            $message = urlencode("Your account was successfully deleted");
            //log out
            session_start();
            session_unset();
            session_destroy();
            header("Location:register.php?Message=".$message);
            die;
        } 
        else {
            echo "Your account could not be deleted";
        }
    }
    else {
        echo "Your account could not be deleted";
    }
    ?>
    </p>
</body>
</html>