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

        $sql_comments = "DELETE FROM comments WHERE user_id=$userid";
        $result_comments = $link->query($sql_comments);

        $sql_posts = "DELETE FROM forum_posts WHERE userid=$userid";
        $result_posts = $link->query($sql_posts);
        
        $sql_reviews = "DELETE FROM review WHERE userid=$userid";
        $result_reviews = $link->query($sql_reviews);
        
        $sql_reports = "DELETE FROM report WHERE userid=$userid";
        $result_reports = $link->query($sql_reports);

        $sql_drug_association_reports = "DELETE FROM drug_association_report WHERE R_user_fk_id=$userid";
        $result_drug_association_reports = $link->query($sql_drug_association_reports);

        $sql_user_drug = "DELETE FROM user_drug WHERE userid=$userid";
        $result_user_drug = $link->query($sql_user_drug);

        $sql_user = "DELETE FROM users WHERE userid=$userid";
        $result_user = $link->query($sql_user);


        if ($result_comments && $result_posts && $result_reviews && $result_reports && $result_drug_association_reports && $result_user_drug && $result_user) {
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