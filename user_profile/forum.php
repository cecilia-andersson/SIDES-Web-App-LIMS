<!DOCTYPE html>
<html>

<head>
    <title>Forum</title>
    <link href="../images/SIDES_head_icon.png" rel="icon">
    <style>
        .forum-post {
            color: #1a3038;
            display: flex;
            justify-content: space-between;
            margin-top: 2%;
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
    <div class="white" style="margin-bottom:4%;">
        <h2> Forum </h2>
        <div>
            <h3 style="margin-bottom: 0; margin-top:6vh; color:#757CB3;"> Search forum posts</h3>
            <form method="GET" action="searchpost.php">
                <input type="text" name="keyword" placeholder="Search for a username or a drug name" required>
                <input type="submit" value="Search">
            </form>
        </div>

        <?php

        if (isset($_SESSION['username']) && isset($_SESSION["id"])) { ?>
            <h3 style="margin-bottom: 0;margin-top:4vh;color:#757CB3;"> Submit new post</h3>
            <form action="insertpost.php" method="POST">
                <input type="text" name="post_text" placeholder="Share your thoughts" required>
                <input type="submit" value="Submit">
            </form>
        </div>
        <?php
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

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            ?>
            <div class="white">
                <?php
                $post_likes = $row['post_likes'];
                $postID = $row['post_id'];
                $userID = $_SESSION["id"];
                $isCurrentUserPost = ($_SESSION["id"] == $row['userid']);
                echo '<a href ="post_w_comments.php?postID=' . $postID . '">';
                echo '<div class="forum-post">';
                echo '<div>';
                echo '<p style="font-size:20px; color:#757CB3;"><strong> User: ' . $row['username'] . '</strong></p>';
                echo '<p style="color:#246f8a;"><strong> Drug: </strong> ' . $row['drug_brand'] . '</p>';
                echo '<p style="font-size: 18px;">' . $row['post_text'] . '</p>';
                echo '</div>';
                echo '<div>';
                echo $row['post_date'];
                echo '</div>';
                echo '</div>';

                echo '</a>';
                if (isset($_SESSION['username']) && isset($_SESSION["id"])) {
                    echo '<form action="/LIMS-Flubber/user_profile/likes_post.php" method="POST">'; /*?postID=' . $postID . '*/
                    echo '<input type="hidden" name="postID" value="' . $postID . '">';
                    echo '<input type="hidden" name="userID" value="' . $userID . '">';
                    echo '<input type="submit" value="&#x1F44D" />' . " " . $post_likes . " " . "likes" . '';
                    echo '</form>';
                } else {
                    echo '<form action="/LIMS-Flubber/user_profile/login_page.php" method = "POST">';
                    echo '<input type="submit" value="&#x1F44D" />' . " " . $post_likes . " " . "likes" . '';
                    echo '</form>';
                }
                ?>
            </div>
            <?php
            echo '<br>';


            //echo '</div>';
            /*echo '<a href="/LIMS-Flubber/likes.php?postID=' . $postID . '">&#x1F44D; Like</a>';*/

        }
    }

    ?>

</body>

</html>