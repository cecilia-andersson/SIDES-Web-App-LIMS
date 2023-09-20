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
<head>
<title>SIDES</title>
</head>
<body>
<h1> SIDES </h1>
<div class="row">
    <div class="column">
        <h2> Log in </h2>
        <p>
            <?php
            // Database connection parameters
            $servername = "localhost";
            $username = "root";
            $password = "root";
            $dbname = "sides";
            // Create connection
            $link = mysqli_connect($servername, $username, $password, $dbname);

            // Check if connection is established
            if (mysqli_connect_error()) {
                die("Connection failed: " . mysqli_connect_error());
            }
            
            $link->close();

            ?>

            <form action="login.php" method="POST">
                Username: <input type="text" name="username" required> <br>
                Password: <input type="password" name="login_password" required> <br>
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
        <h2> New here? Register an account today! </h2>
        <p>
            <form action="register.php">
                <input type="submit" value="Register">
            </form>
        </p>
    </div>
</div>
</body>
</html>