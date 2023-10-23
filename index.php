<!DOCTYPE html>
<html>

<head>
    <title>SIDES</title>
    <link href="images/SIDES_head_icon.png" rel="icon">
    <style>
        p {
            color: #757CB3;
            font-size: 20px;
            line-height: 35px;
        }

        .headers {
            margin: auto;
            max-width: fit-content;
            padding: 8%;
            background-color: white;
            border-radius: 270px;
            text-align: center;
            margin-top: 5vh;
        }

        .part {
            
            margin: auto;
            margin-top: 5vh;
            margin-bottom: 5vh;
            background-color: white;
            padding: 8%;
            padding-top: 2%;
            padding-bottom: 4%;
            background-color: white;
            border-radius: 8px;
            text-align: center;
            max-width: fit-content;
        }
    </style>
</head>

<body style="background-color: rgba(100,167,172,0.15)">
    <header>
        <link rel="stylesheet" type="text/css" href="stylesheet/styles.css"> <!-- Link to CSS file -->
        <nav style="border-radius: 5px;">
            <a href="index.php" style="margin-left: 10px;">
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
                echo '<a href="user_profile/logout.php" style="margin-right:20px;">Log out</a>';
            } else {
                echo '<a href="user_profile/login_page.php">My profile</a>';
                echo '<a href="user_profile/login_page.php">Login</a>';
                echo '<a href="user_profile/register.php" style="margin-right:20px;">Register</a>';
            }
            ?>
        </nav>
    </header>
    <div class="headers">
        <img src="images/SIDES_head.png" style="width: 100px;">
        <h1 style="color: #1A3038; font-size: 60px;"> Real people</h1>
        <h1 style="color: #9510AC; font-size: 60px; line-height: 50px;">Real side effects </h1>

        <p> We keep track of how your
            contraceptives <br> affect
            you. <br> Share experiences anonymously with
            others to <br><b>collectively feel better</b>.</p>
    </div>

    <div class="part">
        <h2> Search for a contraceptive </h2>
        <p> ..to see our user's
            experienced side effects and ratings, <br>as well as FASS official side effects</p>
        <form action="Drug_profile/s_p.php" method="GET">
            <input type="text" name="search_query" placeholder="Search" style="min-width:50%;">
        </form>
    </div>
    <div class="part">
        <h2> About us </h2>
        <p>
            We are a group of students at Uppsala University that has
            developed <b>SIDES</b> to help <br>individuals 
            that
            are using
            or considering to use contraceptives, with a focus on side
            effects. </p>
    </div>

    <footer>
        <a href="user_profile/contact.php">Contact</a>
        <a href="user_profile/aboutus.php">About us</a>
        <a href="user_profile/privacypolicy.php">Privacy policy</a>
    </footer>

</body>

</html>