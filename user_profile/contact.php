<!DOCTYPE html>
<html>

<head>
    <title>SIDES</title>
    <link rel="stylesheet" type="text/css" href="../stylesheet/styles.css"> <!-- Link to CSS file -->
    <h3 style="color: #9510AC; display: inline;">SID</h3><h3 style="color: #246F8A; display: inline;">ES</h3>
    <nav style="display: inline;">
        <a href="Drug_profile/nice_search_page.php">Search</a>
        <a href="../index.php">Home</a>
        <a href="#">Contact</a>
        <a href="aboutus.php">About us</a>
        <?php
        session_start();
        if (isset($_SESSION['username'])){
            echo '<a href="myprofile.php">My profile</a>';
        }else {
            echo '<a href="login_page.php">My profile</a>';

        }
        ?>
        <a href="forum.php">Forum</a>
    </nav>
    <?php
    if (isset($_SESSION['username'])) {
            $loggedInUser = $_SESSION['username'];
            echo '<a href="logout.php">Log out</a>';
        } else {
            echo '<a href="login_page.php">Login</a>&nbsp;&nbsp;';
            echo '<a href="register.php">Register</a>';
            /*echo '<form action="login_page.php" style="display: inline">
                    <input type="submit" value="Log in">
                  </form>';
            echo '<form action="register.php" style="display: inline">
                    <input type="submit" value="Register">
                  </form>';*/
        }
    ?>
</head>

<p> Call me at 0765557476 </p>