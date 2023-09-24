<?php
session_start();

unset($_SESSION['username']); 

header("Location: login_page.php");
exit; 
?>