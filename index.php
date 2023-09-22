<style>
.column {
  float: left;
  width: 50%;
}

.row:after {
    content: "";
    display: table;
    clear: both;
}
</style>

<html>
<link rel="stylesheet" type="text/css" href="../stylesheet/styles.css"> <!-- Link to CSS file -->

<head>
<title>SIDES</title>
<h3 style="color: #9510AC; display: inline;">SID</h3><h3 style="color: #246F8A; display: inline;">ES</h3>
<nav style="display: inline;">
    <a href="index.php">Home</a>
    <a href="#">Contact</a>
    <a href="#">About us</a>
    <a href="#">My profile</a>
    <a href="#">Forum</a>
</nav>
</head>
<body>
<h1 style="color: 1A3038; margin-bottom: 3%;"> Real people </h1>
<h1 style="color: 9510AC; margin-top: 3%;">Real side effects </h1> 

<p style="color: 757CB3;"> We keep track of how your medications affect you. Share experiences anonymously with others to collectively feel better. </p>

<div class="row">
    <div class="column">
        <h3> Log in </h3>
        <p>
            <form action="user_profile/login_page.php">
                <input type="submit" value="Login"> <br>
            </form>

            <?php
            if(isset($_GET['Message'])){
                echo $_GET['Message'];
            }
            ?>
        </p>
    </div>

    <div class="column">
        <h3> New here? Register an account today! </h3>
        <p>
            <form action="user_profile/register.php">
                <input type="submit" value="Register">
            </form>
        </p>
    </div>
</div>
</body>
</html>