<link rel="stylesheet" type="text/css" href="../stylesheet/styles.css"> <!-- Link to CSS file -->
<nav style="border-radius: 5px;">
    <a href="../index.php" style="margin-left: 10px;">
        <img src="../images/SIDES_head.png" alt="Home" style="width: 15px;">
        <h3 style="color: #9510AC; display: inline;">SID</h3><h3 style="color: #246F8A; display: inline;">ES</h3>
    </a>
    <a href="../Drug_profile/s_p.php" style="text-decoration: none;">
        <img src="../images/search.png" alt="Search Drugs" style="width: 15px;">
    </a>
    <a href="../user_profile/forum.php">Forum</a>
    <?php
    session_start();
    if (isset($_SESSION['username']) && isset($_SESSION["id"])) {
        echo '<a href="../user_profile/myprofile.php">My profile</a>';
        echo '<a href="../user_profile/logout.php" style="margin-right:20px">Log out</a>';
    } else {
        echo '<a href="../user_profile/login_page.php">My profile</a>';
        echo '<a href="../user_profile/login_page.php">Login</a>';
        echo '<a href="../user_profile/register.php" style="margin-right:20px">Register</a>';
    }
    ?>
</nav>