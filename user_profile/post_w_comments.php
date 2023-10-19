<!DOCTYPE html>
<html>
    
<head>
    <title>Forum</title>
    <link href="../images/SIDES_head_icon.png" rel="icon">
    <style>
        .forum-post{
            border: 5px solid #256e8a;
            padding: 5px;
            margin-bottom: 5px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }
        </style>
</head>
<body>
<header>
    <?php
    include "../DB_connect.php";
    include "../navigation.php";
    ?>
</header>


<?php
    include "../footer.php";
?>

<?php

session_start();

if (isset($_SESSION['username']) && isset($_SESSION["id"]) && isset($_GET['postID'])) {
    echo 'Comment:';
    $postID = $_GET['postID'];

    echo '<form action="insertcomment.php?postID=' . $postID . '" method="POST">';
    echo '<p>';
    echo '<input type="text" name="comment_text" placeholder="Write here:" required>';
    echo '</p>';
    echo '<input type="submit" value="Submit"><br>';
    echo '<br>';
    echo '</form>';

}

?>

<?php



if (isset($_GET['postID'])) {
    $postID = $_GET['postID'];


    $postQuery = "SELECT forum_posts.*, users.username, drugs.drug_brand
                  FROM forum_posts
                  INNER JOIN users ON forum_posts.userid = users.userid
                  INNER JOIN user_drug ON forum_posts.user_drug_id = user_drug.user_drug_id
                  INNER JOIN drugs ON user_drug.drug_id = drugs.drug_id
                  WHERE forum_posts.post_id = $postID";

    $postResult = $link->query($postQuery);



    if (!$postResult) {
        trigger_error('Invalid query: ' . $link->error);
    }

    if ($postResult->num_rows > 0) {
        while ($postRow = $postResult->fetch_assoc()){
        $post_likes = $postRow['post_likes'];
        $postID = $postRow['post_id'];
        $userID = $_SESSION["id"];
        echo '<div class="forum-post">';
        echo '<div>';
        echo '<p><strong>User:</strong> ' . $postRow['username'] . '</p>';
        echo '<p><strong>Post Text:</strong> ' . $postRow['post_text'] . '</p>';
        echo '</div>';
        echo '<div>';
        echo '<p><strong>Drug:</strong> ' . $postRow['drug_brand'] . '</p>';
        echo '</div>';
        echo '<p><strong>Post Date:</strong> ' . $postRow['post_date'] . '</p>';
        echo '</div>';

        if (isset($_SESSION['username']) && isset($_SESSION["id"])) {
            echo '<form action="/LIMS-Flubber/user_profile/likes_post.php" method="POST">'; /*?postID=' . $postID . '*/
            echo '<input type="hidden" name="postID" value="' . $postID . '">';
            echo '<input type="hidden" name="userID" value="' . $userID . '">';
            echo '<input type="submit" value="&#x1F44D" />' . " " . $post_likes . " " . "likes" . '' ;
            echo '</form>'; }
            else{
            echo '<form action="/LIMS-Flubber/user_profile/login_page.php" method = "POST">';
            echo '<input type="submit" value="&#x1F44D" />' . " " . $post_likes . " " . "likes" . '' ;
            echo '</form>';
            }
        }

        $commentsQuery = "SELECT comments.*, users.username as comment_username
                          FROM comments
                          INNER JOIN users ON comments.user_id = users.userid
                          WHERE comments.post_id = $postID";

        $commentsResult = $link->query($commentsQuery);


        if ($commentsResult->num_rows > 0) {
            while ($commentRow = $commentsResult->fetch_assoc()) {
                $comment_likes = $commentRow['comment_likes'];
                $commentID = $commentRow['commentid'];
                $userID = $_SESSION["id"];
                
                echo '<div class="forum-post">';
                echo '<div>';
                echo '<p><strong>User:</strong> ' . $commentRow['comment_username'] . '</p>';
                echo '<p><strong>Comment Text:</strong> ' . $commentRow['comment_text'] . '</p>';
                echo '</div>';
                echo '<p><strong>Comment Date:</strong> ' . $commentRow['comment_date'] . '</p>';
                echo '</div>';

                if (isset($_SESSION['username']) && isset($_SESSION["id"])) {
                    echo '<form action="/LIMS-Flubber/user_profile/likes_comments.php" method="POST">'; /*?postID=' . $postID . '*/
                    echo '<input type="hidden" name="commentID" value="' . $commentID . '">';
                    echo '<input type="hidden" name="userID" value="' . $userID . '">';
                    echo '<input type="submit" value="&#x1F44D" />' . " " . $comment_likes . " " . "likes" . '' ;
                    echo '</form>'; }
                    else{
                    echo '<form action="/LIMS-Flubber/user_profile/login_page.php" method = "POST">';
                    echo '<input type="submit" value="&#x1F44D" />' . " " . $comment_likes . " " . "likes" . '' ;
                    echo '</form>';
                    }
            }
        } else {
            echo '<p>No comments yet.</p>';
        }
    } else {
        echo '<p>Post not found.</p>';
    }
}
?>
</body>
</html>