<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link href="../images/SIDES_head_icon.png" rel="icon">
</head>
<body>
    <header>
        <?php
        include "../navigation.php";
        include "../DB_connect.php";
        ?>
    </header>
    <h3> Forgot password </h3>
    <p>
    <?php
    if (isset($_POST['email']) && isset($_POST['pwd'])) {
        $email = $_POST['email'];
        $sql1 = "SELECT * FROM users WHERE email='$email'";
        $result1 = $link->query($sql1);

        $row = $result1->fetch_assoc();
        
        if (!password_verify($_POST['pwd'], $row["pwd"])) { // new pwd
            $newpwd = password_hash($_POST['pwd'], $PASSWORD_BCRYPT);
            $sql2 = "UPDATE users SET pwd='$newpwd' WHERE email='$email'";
            
            if ($link->query($sql2)) {
                $message = urlencode("Password updated successfully");
            } else {
                $message = urlencode("Error updating password: " . $link->error);
            }

            header("Location:login_page.php?Message=".$message); 
            die;
        }
        else {
            $message = urlencode("Cannot change to the same password."); 
            header("Location:reset_pwd.php?Message=".$message);
            die;
        }
    }
    elseif (!isset($_GET["token"])) {
        $message = urlencode("You do not have a password token.");
        header("Location:reset_pwd.php?Message=".$message);
        die; // shouldn't be able to reset pwd
    }
    else { // if token is ok
        $token = $_GET["token"];
        $sql = "SELECT * FROM password_reset_temp WHERE token='$token'";
        $result = $link->query($sql);
        
        if ($result) { // token in table
            $row = $result->fetch_assoc();

            // check that the token is valid
            $dateTimeFormat = mktime(date("H"), date("i"), date("s"), date("m") ,date("d"), date("Y"));
            $currentDateTime = date("Y-m-d H:i:s", $dateTimeFormat);
            $email = $row["email"];

            if ($currentDateTime <= $row['expiry']) { // valid token
                // remove token
                $sql = "DELETE FROM password_reset_temp WHERE email = '$email'";
                $result = $link->query($sql);
            }
            else { // expired token
                // remove token
                $sql = "DELETE FROM password_reset_temp WHERE email = '$email'";
                $result = $link->query($sql);

                $message = urlencode("Invalid token."); 
                header("Location:reset_pwd.php?Message=".$message);
                die;
            }
        }
        else { // token not in table
            $message = urlencode("Invalid token."); 
            header("Location:reset_pwd.php?Message=".$message);
            die; //should it die?
        }

    ?>
    <form action="reset_pwd.php" method="POST">
        <p>
            <input size="50" type="email" name="email" value="<?= $email ?>" readonly> <br>
        </p>
        <p>
            <input type="password" name="pwd" placeholder="New password" 
            pattern="^(?=.*[A-Z])(?=.*\d).+$" 
            title="Password must contain at least one capital letter and one number." required> <br>
        </p>
        <input type="submit" value="Save new password"> <br>
    </form> 
    <?php
    }
    if (isset($_GET['Message'])) {
        echo $_GET['Message'];
    }   
    ?>
    </p>
    <?php
    include "../footer.php";
    ?>
</body>

</html>