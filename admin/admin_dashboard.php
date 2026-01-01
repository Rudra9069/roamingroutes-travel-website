<?php 
include 'includes/auth.php'; 
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="sidebar">
        <h2>Roaming Routes</h2>
        <ul>
            <li><a href="admin_dashboard.php">Dashboard</a></li>
            <li><a href="admin_users.php">Manage Users</a></li>
            <li><a href="admin_destinations.php">Manage Destinations</a></li>
            <li><a href="admin_bookings.php">Manage Bookings</a></li>
            <li><a href="admin_payments.php">Manage Payments</a></li>
            <li><a href="admin_messages.php">View Messages</a></li>
            <li><a href="admin_logout.php">Logout</a></li>
        </ul>
    </div>
    <div class="main-content">
        <h1>Welcome, Admin!</h1>
    </div>
</body>
</html>
