<?php

$server = "localhost";
$username = "root";
$password = "Rudra$2004";
$dbname = "travel";

$conn = mysqli_connect($server,$username,$password,$dbname);

if(!$conn)
{
    echo "<script> alert('Not Connected') </script>";
}

?>
