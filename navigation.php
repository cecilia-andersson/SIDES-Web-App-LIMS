<link rel="stylesheet" type="text/css" href="../stylesheet/styles.css"> <!-- Link to CSS file -->
<h3 style="color: #9510AC; display: inline;">SID</h3><h3 style="color: #246F8A; display: inline; margin-right: 2em;">ES</h3>
<nav style="display: inline;">
    <a href="../Drug_profile/nice_search_page.php">Search</a>
    <a href="../index.php">Home</a>
    <a href="../user_profile/contact.php">Contact</a>
    <a href="../user_profile/aboutus.php">About us</a>
    <a href="../user_profile/forum.php">Forum</a>
    <?php
    session_start();
    if (isset($_SESSION['username']) && isset($_SESSION["id"])) {
        echo '<a href="../user_profile/myprofile.php">My profile</a>';
        echo '<a href="../user_profile/logout.php">Log out</a>';
    } else {
        echo '<a href="../user_profile/login_page.php">My profile</a>';
        echo '<a href="../user_profile/login_page.php">Login</a>';
        echo '<a href="../user_profile/register.php">Register</a>';
    }
    ?>
</nav>