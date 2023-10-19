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
echo '<div style = "text-align:center;">';
echo '<h1  a </h1>';
echo '<form method="GET" action="searchpost.php">';
echo    '<input type="text" name="keyword", placeholder="Search for a username or a drug name" required>';
echo    '<input type="submit" value="Search">';
echo '<br>';
echo '</form>';
echo '</div>';

if (isset($_SESSION['username']) && isset($_SESSION["id"])) {
    echo 'Submit your post here:';

    echo '<form action="insertpost.php" method="POST">';
    echo '<p>';
    echo '<input type="text" name="post_text" placeholder="Write here:" required>';
    echo '</p>';
    echo '<input type="submit" value="Submit"><br>';
    echo '<br>';
    echo '</form>';

}

?>


<?php

$sql = "SELECT forum_posts.*, users.username, drugs.drug_brand
        FROM forum_posts
        INNER JOIN users ON forum_posts.userid = users.userid
        INNER JOIN user_drug ON forum_posts.user_drug_id = user_drug.user_drug_id
        INNER JOIN drugs ON user_drug.drug_id = drugs.drug_id
        ORDER BY forum_posts.post_date DESC";

$result = $link->query($sql);

if($result->num_rows > 0){
    while ($row = $result->fetch_assoc()){
        $post_likes = $row['post_likes'];
        $postID = $row['post_id'];
        $userID = $_SESSION["id"];
        $isCurrentUserPost = ($_SESSION["id"] == $row['userid']);
            echo '<a href ="post_w_comments.php?postID=' . $postID . '">';
            echo '<div class="forum-post">';
            echo '<div>';
            echo '<p><strong>User:</strong> ' . $row['username'] . '</p>';
            echo '<p><strong>Post Text:</strong> ' . $row['post_text'] . '</p>';
            echo '</div>';
            echo '<div>';
            echo '<p><strong>Drug:</strong> ' .  $row['drug_brand'] . '</p>';
            echo '</div>';
            echo '<p><strong>Post Date:</strong> ' . $row['post_date'] . '</p>';

            echo '</div>';
            
        
            echo '</a>';

            

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
            
            //echo '</div>';
            /*echo '<a href="/LIMS-Flubber/likes.php?postID=' . $postID . '">&#x1F44D; Like</a>';*/

    }
}

?>
</body>
</html>

