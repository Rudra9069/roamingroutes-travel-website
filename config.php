<?php

$RAZORPAY_KEY_ID = "rzp_test_qYgM6sOFZFS3Qs";
$RAZORPAY_KEY_SECRET = "7C5r7u798RxpiXNTMgXLTx8V";

// Dynamically determine the site URL for redirects and links
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];
$script = $_SERVER['SCRIPT_NAME'];
$dir = dirname($script);
// Ensure we don't have double slashes if in root
$path = ($dir == DIRECTORY_SEPARATOR || $dir == '/') ? "" : $dir;
$SITE_URL = $protocol . "://" . $host . $path . "/";

?>
