<!DOCTYPE html>
<html>

<head>
    <title>Forgot password</title>
    <link href="../images/SIDES_head_icon.png" rel="icon">
</head>
<body>
    <header>
        <?php
        include "../navigation.php";
        include "../DB_connect.php";
        
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\SMTP;
        use PHPMailer\PHPMailer\Exception;
        
        require '../vendor/PHPMailer/PHPMailer/src/Exception.php';
        require '../vendor/PHPMailer/PHPMailer/src/PHPMailer.php';
        require '../vendor/PHPMailer/PHPMailer/src/SMTP.php';
        require '../vendor/autoload.php';
        ?>
    </header>
    <h3> Forgot password </h3>
    <p>
    <?php
    if (isset($_POST["email"])){ // if an email should be sent
        $recipient = $_POST["email"];
        $recipient = filter_var($recipient, FILTER_SANITIZE_EMAIL);
        $recipient = filter_var($recipient, FILTER_VALIDATE_EMAIL);

        // Create an instance of PHPMailer
        $mail = new PHPMailer(true);

        // Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF; // Disable debug output
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'sideslims@gmail.com';
        $mail->Password = 'uqle yvky zmwz zych';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;
        // $mail->SMTPSecure = "ssl"; // not necessary?

        $mail->setFrom('sideslims@gmail.com', 'SIDES');
        $mail->addAddress($recipient);

        if (!$recipient) {
            $message = urlencode("Invalid email address.");
            header("Location:forgot_pwd.php?Message=".$message);
            die;
        }
        else { // there is a recipient
            $sql = "SELECT * FROM users WHERE email='$recipient'";
            $result = $link->query($sql);
            if ($result->num_rows == 1) { // there is an account with this address
                $row = $result->fetch_assoc();
                
                // expiry time 1 hour later
                $expFormat = mktime(date("H")+1, date("i"), date("s"), date("m") ,date("d"), date("Y"));
                $expiry = date("Y-m-d H:i:s",$expFormat);

                // generate token
                $length = 16;
                $token = bin2hex(random_bytes($length));
                

                // Check if email is already in temporary table
                $sql1 = "SELECT * FROM password_reset_temp WHERE email = '$recipient'";
                $result1 = $link->query($sql1);

                if ($result1) {
                    // delete previous user token
                    $sql2 = "DELETE FROM password_reset_temp WHERE email = '$recipient'";
                    $result2 = $link->query($sql2);
                }

                // Insert expiry and token into temporary table
                $sql3 = "INSERT INTO password_reset_temp (email, token, expiry) VALUES (?, ?, ?)";
                $stmt3 = $link->prepare($sql3);
                $stmt3->bind_param("sss", $recipient, $token, $expiry);
                $result3 = $stmt3->execute();
                if ($result3) {
                    $mail->isHTML(true);
                    $mail->Subject = "SIDES - Reset password";

                    $message = "<p>Hello SIDES user,</p>";
                    $message.= "<p>Please click on the following link to reset your password: </p>";
                    $message.= "<p><a href='http://localhost:443/user_profile/reset_pwd.php?token=$token'>http://localhost:443/user_profile/reset_pwd.php?token=$token</a></p>";
                    $message.= "<p>The link is valid for 1 hour.</p>";
                    $message.= "<p>If you did not request to reset your password you can ignore this email.</p>";
                    $message.= "<p>Best regards, the SIDES team.</p>";

                    $mail->Body = $message;
                    echo $message;

                    try {
                        $mail->send();
                        $message = urlencode("An email has been sent to the given address.");
                        header("Location:forgot_pwd.php?Message=".$message);
                        die;
                    } catch (Exception $e) {
                        $message = urlencode("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
                        header("Location:forgot_pwd.php?Message=".$message);
                    }
                }
                else {
                    $message = urlencode("Not successful.");
                    header("Location:forgot_pwd.php?Message=".$message);
                }

            }
            else {
                $message = urlencode("There is no account with this email address.");
                header("Location:forgot_pwd.php?Message=".$message);
            }   
        }     
    } 
            
    else {
    ?>
    <form action="forgot_pwd.php" method="POST">
        <p>
            <input size="50" type="email" name="email" placeholder="example@email.com" required> <br>
        </p>
        <input type="submit" value="Send new password"> <br>
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