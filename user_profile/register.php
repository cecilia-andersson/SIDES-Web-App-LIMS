<!DOCTYPE html>
<html>


<head>
    <style>
        body{

        }

        .register-button{

        }
    
    </style>
</head>
<h1 style="text-align:center;"> Create your SIDES account right now baby </h1>


<body>
<!-- POST / PUT? Urlencode? -->
<form action="insertdata.php" method="POST">
    Username: <input type="text" name="username" required> <br>
    Password: <input type="password" name="pwd" pattern="^(?=.*[A-Z])(?=.*\d).+$" title="Password must contain at least one capital letter and one number." required> <br>
    Personal Identity Number: <input type="text" name="personnmr" placeholder="YYYYMMDDXXXX" pattern="(1999|2000)[0-9]{8}" required> <br>
    <input type="submit" value="Add" class="register-button"><br>

</form>
</body>
</html>