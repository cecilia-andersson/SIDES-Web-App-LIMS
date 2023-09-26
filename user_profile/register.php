<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
    <link href="../images/S.png" rel="icon">
    <style>
        body {}

        .register-button {}
    </style>
</head>


<body>
    <header>
        <?php
        include "../navigation.php";
        ?>
    </header>
    <h3> Create your SIDES account right now baby </h3>

    <!-- POST / PUT? Urlencode? -->
    <form action="insertdata.php" method="POST">
        Username: <input type="text" name="username" required> <br>
        Password: <input type="password" name="pwd" pattern="^(?=.*[A-Z])(?=.*\d).+$"
            title="Password must contain at least one capital letter and one number." required> <br>
        Personal Identity Number: <input type="text" name="personnmr" placeholder="YYYYMMDDXXXX"
            pattern="(19[0-9]{2}|20[0-1][0-5])[0-9]{8}" required> <br>
        Email: <input size="50" type="email" name="email" placeholder="example@email.com" required> <br>
        <input type="submit" value="Add" class="register-button"><br>
    </form>
    <?php
    if (isset($_GET['Message'])) {
        echo $_GET['Message'];
    }
    ?>
</body>

</html>