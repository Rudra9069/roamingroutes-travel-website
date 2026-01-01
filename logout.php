<?php
session_start();

$_SESSION = [];        // Clear session array
session_unset();       // Unset all session variables
session_destroy();     // Destroy the session

header("Location: /4_Travel/index.php");
exit;
