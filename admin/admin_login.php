<?php
session_start();
require_once 'database/traveldb.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $email = $_POST['email'];
    $pwd = $_POST['pwd'];

    $sql = "SELECT * FROM users WHERE email = '$email' AND pwd = '$pwd'"; 
    $result = mysqli_query($conn , $sql);

    if($result && mysqli_num_rows($result) > 0)
    {
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin_dashboard.php");
        exit;
    } 
    else 
    {
        $error = "Invalid credentials.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="login-body">
    <div class="login-container">
        <h2>Admin Login</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="post">
            <input type="text" name="email" placeholder="Admin Username" required>
            <input type="password" name="pwd" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
