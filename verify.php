<?php include('database/traveldb.php'); ?>
<?php

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $query = "SELECT * FROM users WHERE verify_token = '$token' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) 
    {
        $update = "UPDATE users SET is_verified = 1, verify_token = NULL WHERE verify_token = '$token'";
        mysqli_query($conn, $update);

        echo "<script>
            alert('Your email has been successfully verified! You can now login.');
            window.location.href='login.php';
        </script>";
    } 
    else 
    {
        echo "<script>
            alert('Invalid or expired verification link.');
            window.location.href='login.php';
        </script>";
    }
}
?>
