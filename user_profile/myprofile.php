<!DOCTYPE html>
<html>

<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "sides";

// Create connection
$link = mysqli_connect($servername, $username, $password, $dbname);

if (mysqli_connect_error()) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

<head>
    <title>My Profile</title>
    <link href="../images/SIDES_head_icon.png" rel="icon">
    <style>
        body section {
            border: 2px solid #757CB3;
            display: block;
            position: fixed;
            right: 8vw;
            top: 15vh;
            padding: 1rem;
            text-align: left;
        }

        ul {
            list-style-type: none;
        }

        .container{
            position: fixed;
            right:8vw;
            bottom:13vh;
        }

        .month {
            background: #F5733A;
            width: 20vw;
            text-align: center;
        }

        .month ul {
            margin: 0;
            padding: 0;
        }

        .month ul li {
            color: white;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 3px;
        }

        /* Previous button inside month header */
        .month .prev {
            float: left;
            margin-top: 10px;
        }

        /* Next button */
        .month .next {
            float: right;
            margin-top: 10px;
        }

        /* Weekdays (Mon-Sun) */
        .weekdays {
            margin: 0;
            background-color: #ddd;
            width: 20vw;
            padding: 0;
            text-align: center;
            display: grid;
            grid-template-columns: repeat(7, 1fr);
        }

        .weekdays li {
            color: #666;
            margin-left: 4px;
            margin-right: 3px;
        }

        /* Days (1-31) */
        .days {
            background: #eee;
            margin: 0;
            width: 20vw;
            padding: 0;
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            grid-row-gap: 10px;
            height:auto;
        }

        .days li {
            list-style-type: none;
            color: #777;
            font-size: 16px;
            margin: 0px;
            text-align: center;

        }

        .days li .active {
            background: #1abc9c;
            border-radius: 5px;
            color: white !important
        }
    </style>
</head>

<body>
    <header>
        <?php
        include "../navigation.php";
        include "../DB_connect.php";
        ?>
    </header>

    <h2>My profile</h2>
    <?php
    if (isset($_SESSION['username'])) {
        $loggedInUser = $_SESSION['username'];
        $personalnumber = $_SESSION['personalnumber'];
        $yearnow = date("Y");
        $useryear = substr($personalnumber, 0, 4);
        $age = $yearnow - $useryear;

        if (substr($age, 1, 2) > 5) {
            $agerange = substr($age, 0, 1) . "6" . "-" . substr(($age + 1), 0, 1) . "0";
        } else {
            $agerange = substr($age, 0, 1) . "0" . "-" . substr(($age + 1), 0, 1) . "5";
        }
        $sql = "SELECT * FROM users WHERE username = '$loggedInUser'";
        $result = $link->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $email = $row['email'];
        }

        echo "
        <section>
        <p> <b> About me </b> </p>
        <p> Username: $loggedInUser </p>
        <p> Age: $agerange </p>
        <p> Email: $email </p>
        "; // this cannot be displayed if salted and hashed
    }

    ?>
    <form action="edit_myprofile.php">
        <input type="submit" value="Edit profile" />
    </form>
    </section>
    <div class='container'>
        <div class="month">
            <ul>
                <li class="prev">&#10094;</li>
                <li class="next">&#10095;</li>
                <li>October<br><span>2023</span></li>
            </ul>
        </div>

        <ul class="weekdays">
            <li>Mo</li>
            <li>Tu</li>
            <li>We</li>
            <li>Th</li>
            <li>Fr</li>
            <li>Sa</li>
            <li>Su</li>
        </ul>

        <ul class="days">
            <li>1</li>
            <li>2</li>
            <li>3</li>
            <li>4</li>
            <li>5</li>
            <li>6</li>
            <li>7</li>
            <li>8</li>
            <li>9</li>
            <li><span class="active">10</span></li>
            <li>11</li>
            <li>12</li>
            <li>13</li>
            <li>14</li>
            <li>15</li>
            <li>16</li>
            <li>17</li>
            <li>18</li>
            <li>19</li>
            <li>20</li>
            <li>21</li>
            <li>22</li>
            <li>23</li>
            <li>24</li>
            <li>25</li>
            <li>26</li>
            <li>27</li>
            <li>28</li>
            <li>29</li>
            <li>30</li>
            <li>31</li>
        </ul>
    </div>

    <p>
        <b>Currently using:</b><br>
        <?php
        $sql = "SELECT userid FROM users WHERE username = '$loggedInUser'";
        $result = $link->query($sql);
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $userid = $row["userid"];
        }

        $sql = "SELECT drug_id FROM user_drug WHERE userid = $userid";
        $result = $link->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $drug_id = $row["drug_id"];
                $sql1 = "SELECT drug_brand FROM drugs WHERE drug_id = $drug_id";
                $result1 = $link->query($sql1);
                if ($result1->num_rows > 0) {
                    $row = $result1->fetch_assoc();
                    $drug_brand = $row["drug_brand"];
                    echo "<a href='../Drug_profile/nice_drug_page.php?drug_id=$drug_id'>$drug_brand</a><br>";
                } else {
                    echo "Drug_id does not exist in the drug table";
                }
            }
        } else {
            echo "<p> No reported contraceptives </p> ";
        }
        ?>
    </p>
    </main>
</body>

<?php
include "../footer.php";
?>

</html>