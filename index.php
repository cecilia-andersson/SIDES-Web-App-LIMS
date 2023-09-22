<!DOCTYPE html>
<html>

<head>
    <title>SIDES</title>
    <link rel="stylesheet" type="text/css" href="stylesheet/styles.css"> <!-- Link to CSS file -->
    <h3 style="color: #9510AC; display: inline;">SID</h3><h3 style="color: #246F8A; display: inline;">ES</h3>
    <nav style="display: inline;">
        <a href="Drug_profile/nice_search_page.php">Search</a>
        <a href="index.php">Home</a>
        <a href="#">Contact</a>
        <a href="#">About us</a>
        <a href="#">My profile</a>
        <a href="#">Forum</a>
    </nav>
    <form action="user_profile/login_page.php" style="display: inline">
        <input type="submit" value="Log in">
    </form>
    <form action="user_profile/register.php" style="display: inline">
        <input type="submit" value="Register">
    </form>
</head>

<body>
<?php
if (isset($_GET['Message'])) {
    echo $_GET['Message'];
}
?>

    <h1 style="color: #1A3038; margin-bottom: 3%;"> Real people </h1>
    <h1 style="color: #9510AC; margin-top: 3%;">Real side effects </h1>

    <p style="color: #757CB3;"> We keep track of how your medications affect you. Share experiences anonymously with
        others to collectively feel better. </p>


</body>

</html>