<?php 
session_start();
session_unset();
session_destroy();
$message = urlencode("Session erased"); // placeholder to check that it works -- change
header("Location: login_page.php?Message=".$message);
exit();
?>