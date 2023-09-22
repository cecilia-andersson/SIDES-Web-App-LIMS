<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="../stylesheet/styles.css"> <!-- Link to CSS file -->
    <style>
        body{

        }

        .register-button{

        }
    
    </style>
</head>
<h2> Create your SIDES account right now baby </h2>


<body>
<!-- POST / PUT? Urlencode? -->
<form action="insertdata.php" method="POST">
    Username: <input type="text" name="username" required> <br>
    Password: <input type="password" name="pwd" pattern="^(?=.*[A-Z])(?=.*\d).+$" title="Password must contain at least one capital letter and one number." required> <br>
    Personal Identity Number: <input type="text" name="personnmr" placeholder="YYYYMMDDXXXX" pattern="(1999|2000)[0-9]{8}" required> <br>
    <input type="submit" value="Add" class="register-button"><br>

</form>
<?php
    if(isset($_GET['Message'])){
        echo $_GET['Message'];
    }
    ?>
</body>
</html>