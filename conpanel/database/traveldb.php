<?php

$server = "localhost";
$username = "root";
$password = "";
$dbname = "travel";

$conn = mysqli_connect($server,$username,$password,$dbname);

if(!$conn)
{
    echo "<script> alert('Not Connected') </script>";
}

?>
