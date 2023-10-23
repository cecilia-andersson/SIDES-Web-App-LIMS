<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link href="../images/SIDES_head_icon.png" rel="icon">
    <style>
        /* START STYLE PRESENTATION SLIDES */
        .slides_button {
            background-color: #9510AC;
            border: none;
            color: white;
            position: absolute;
            top: 40%;
            border-radius: 50%;
            padding: 25px;
            width: 100px;
            height: 100px;
        }

        /* Start slide overlay */
        #overlay {
            position: fixed;
            display: none;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 10, 0.5);
            /*this is 757CB3 */
            z-index: 2;
            cursor: pointer;
        }

        #overlay2 {
            position: fixed;
            display: none;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 10, 0.5);
            /*this is 757CB3 */
            z-index: 2;
            cursor: pointer;
        }

        #outerContainer {
            background-color: #ffffff;
            border: 2px solid #256e8a;
            border-radius: 15px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
            padding: 20px;

            max-height: 95vh;
            /* Set maximum height for the container */
            overflow-y: auto;
            /* Enable vertical scrolling if content overflows */

            position: absolute;
            top: 50%;
            left: 50%;

            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
        }

        /* End slide overlay */
        /* END STYLE PRESENTATION SLIDES */
    </style>
</head>

<body>
    <header>
        <?php
        include "../navigation.php";
        ?>
    </header>
    <div class="white">

        <h2> Sign in </h2>
        <p>
        <form action="login.php" method="POST">
            <p>
                <input type="text" name="username" placeholder="Username" required> <br>
            </p>
            <p>
                <input type="password" name="login_password" placeholder="Password" required> <br>
            </p>
            <input type="submit" value="Sign in"> <br>
        </form>
        <p>
            <a href="forgot_pwd.php">I forgot my password</a> <br><br>
        </p>
        <?php
        if (isset($_GET['Message'])) {
            echo $_GET['Message'];
        }
        ?>
        </p>

        <!-- start stuff for the presentation -->
        <div id="overlay">
            <div id="outerContainer">
                <h4> Signing in </h4>
                <ul>
                    <li> Password verified against the stored salted and hashed one connected to the username </li>
                    <li> Block user 5 failed login attempts </li>
                    <ul>
                        <li> Blocked IP address </li>
                        <li> Blocked for 1 hour </li>
                        <li> Message with time left </li>
                    </ul>
                    <li> Sent to My profile-page </li>
                    <li> User ID, birthdate and username are stored in sessions variables after sign in </li>
                </ul>
            </div>
        </div>
        <div id="overlay2">
            <div id="outerContainer">
                <h4> Resetting password </h4>
                <ul>
                    <li> Email with token in link sent to user </li>
                    <li> Token is a string of 16 random bytes → hexadecimal </li>
                    <li> Token, email and expiry stored in temporary table </li>
                    <li> Token deleted after use or renewed if reset is requested again </li>
                </ul>
            </div>
        </div>
        <button type="button" class="slides_button" style="right:30%" onclick="overlay_on()">SLIDE 1</button>
        <button type="button" class="slides_button" style="right:20%" onclick="overlay2_on()">SLIDE 2</button>

        <script>
            function overlay_on() {
                document.getElementById("overlay").style.display = "block";
            }

            function overlay_off() {
                document.getElementById("overlay").style.display = "none";
            }

            function overlay2_on() {
                document.getElementById("overlay2").style.display = "block";
            }

            function overlay2_off() {
                document.getElementById("overlay2").style.display = "none";
            }

            document.addEventListener("keydown", function (event) {// to allow for esc closing 
                if (event.key === "Escape") {
                    overlay_off();
                    overlay2_off(); y
                }
            });

        </script>
        <!-- end stuff for the presentation -->
    </div>

    <?php
    include "../footer.php";
    ?>
</body>

</html>