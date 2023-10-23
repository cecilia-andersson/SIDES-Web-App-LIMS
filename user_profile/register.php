<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
    <link href="../images/SIDES_head_icon.png" rel="icon">
    <style>
        body {}

        .register-button {}

        /* START PRESENTATION SLIDES STYLE */
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
        /* END PRESENTATION SLIDES STYLE */
    </style>
</head>


<body>
    <header>
        <?php
        include "../navigation.php";
        ?>
    </header>
    <div class="white">

        <h2> Register </h2>

        <form action="insertdata.php" method="POST">
            <p>
                <input type="text" name="username" placeholder="Username" required>
            </p>
            <p>
                <input type="password" name="pwd" pattern="^(?=.*[A-Z])(?=.*\d).+$"
                    title="Password must contain at least one capital letter and one number." placeholder="Password"
                    required>
            </p>
            <p>
                <input type="text" name="personnmr" placeholder="Personal Identity Number (YYYYMMDDXXXX)"
                    pattern="(19[0-9]{2}|20[0-9][0-9])[0-9]{8}" required>
            </p>
            <p>
                <input size="50" type="email" name="email" placeholder="E-mail (example@email.com)" required>
            </p>
            <?php echo 'I have read and accept SIDES <a href="http://localhost:443/user_profile/privacypolicy.php">privacy policy</a>.'; ?>
            <p>
                <input type="checkbox" name="acceptGDPR" value="I accept" required>
            </p>
            <input type="submit" value="Submit"><br>
        </form>
        <?php
        if (isset($_GET['Message'])) {
            echo $_GET['Message'];
        }
        ?>

        <!-- start stuff for the presentation -->
        <div id="overlay">
            <div id="outerContainer">
                <h4> Registering an account </h4>
                <ul>
                    <li> Client-side validation </li>
                    <li> Username </li>
                    <li> Password (>=1 capital letter, >=1 number, >= 8 characters) </li>
                    <ul>
                        <li> Hashing is one-way </li>
                        <li> Salting </li>
                        <li> Built-in php function and bcrypt algorithm </li>
                    </ul>
                    <li> Personal security number</li>
                    <ul>
                        <li> birthdate → get age of user </li>
                        <li> Verify that the user is unique </li>
                        <li> Can't use BankID </li>
                    </ul>
                    <li> Email address (unique) </li>
                    <li> Need to accept privacy policy </li>
                </ul>
            </div>
        </div>
        <div id="overlay2">
            <div id="outerContainer">
                <h4> Form security </h4>
                <ul>
                    <li> Server-side validation </li>
                    <li> Prevent cross-site scripting </li>
                    <ul>
                        <li> htmlspecialchars </li>
                    </ul>
                    <li> Prevent SQL injection</li>
                    <ul>
                        <li> Prepared SQL statements </li>
                        <li> Validate and sanitize </li>
                    </ul>
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
    </div>
    <!-- end stuff for the presentation -->

    <?php
    include "../footer.php";
    ?>
</body>

</html>