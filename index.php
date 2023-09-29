<!DOCTYPE html>
<html>

<head>
    <title>SIDES</title>
    <link href="images/SIDES_head_icon.png" rel="icon">
</head>

<body>
    <header>
        <link rel="stylesheet" type="text/css" href="stylesheet/styles.css"> <!-- Link to CSS file -->
        <nav>
            <a href="index.php" style="margin-left: 0em;">
                <img src="images/SIDES_head.png" alt="Home" style="width: 15px;">
                <h3 style="color: #9510AC; display: inline;">SID</h3><h3 style="color: #246F8A; display: inline;">ES</h3>
            </a>
            <a href="Drug_profile/s_p.php" style="text-decoration: none;">
                <img src="images/search.png" alt="Search Drugs" style="width: 15px;">
            </a>
            <a href="user_profile/forum.php">Forum</a>
            <?php
            session_start();
            if (isset($_SESSION['username']) && isset($_SESSION["id"])) {
                echo '<a href="user_profile/myprofile.php">My profile</a>';
                echo '<a href="user_profile/logout.php">Log out</a>';
            } else {
                echo '<a href="user_profile/login_page.php">My profile</a>';
                echo '<a href="user_profile/login_page.php">Login</a>';
                echo '<a href="user_profile/register.php">Register</a>';
            }
            ?>
        </nav>
    </header>
    <?php
    if (isset($_GET['Message'])) {
        echo $_GET['Message'];
    }
    ?>

    <img src="images/SIDES_head.png" alt="SIDES logo" style="width: 15vw; margin-right: 9vw; margin-top: 5vh;"
        align="right">

    <h1 style="color: #1A3038; margin-top:6%; margin-bottom: 0"> Real people </h1>
    <h1 style="color: #9510AC; margin-top:2%;">Real side effects </h1>

    <p style="color: #757CB3; font-size: 18px; line-height: 26px;"> We keep track of how your medications affect
        you. <br> Share experiences anonymously with
        others to <b>collectively feel better</b>.</p>

    <section style="margin-top: 10vh;">
        <h4 style="font-size: 16px; margin-bottom: 0;"> Looking for contraceptives..? </h4>
        <p>
        <form action="Drug_profile/s_p.php" method="POST">
            <input type="text" name="search_query" placeholder="Search">
        </form>
        </p>
    </section>

    <footer>
        <a href="user_profile/contact.php">Contact</a>
        <a href="user_profile/aboutus.php">About us</a>
    </footer>

</body>

</html>