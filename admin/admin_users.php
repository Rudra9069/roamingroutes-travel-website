<?php   
    // include 'includes/auth.php'; 
    include 'database/traveldb.php'; 
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php 
include 'admin_dashboard.php'; 
?>
<div class="main-content">
    <h2>Registered Users</h2>
    <table>
        <tr>
            <th> ID </th>
            <th> Name </th>
            <th> Email </th>
            <th> Contact no </th>
            <th> Dob </th>
            <th> is_verified </th>
            <th> Password </th>
            <th> Actions </th>
        </tr>
        <?php

            $query = "SELECT u_id, name, email, contactno, dob, is_verified, pwd FROM users";
            $result = mysqli_query($conn,$query);

            while ($row = $result->fetch_assoc()) 
            {
                echo "<tr>
                        <td>{$row['u_id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['contactno']}</td>
                        <td>{$row['dob']}</td>
                        <td>{$row['is_verified']}</td>
                        <td>{$row['pwd']}</td>\
                        <td>
                            <a href='edit_user.php?id={$row['u_id']}' class='btn btn-edit'>Update</a>
                            <a href='delete_user.php?id={$row['u_id']}' class='btn btn-delete' onclick=\"return confirm('Are you sure you want to delete this user?');\">Delete</a>
                        </td>
                    </tr>";
            }

        ?>
    </table>
</div>
</body>
</html>
