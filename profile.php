<?php
session_start();
include('database/traveldb.php');

if (!isset($_SESSION['u_id'])) {
    header("Location: login.php");
    exit;
}

$u_id = $_SESSION['u_id'];
$email = $_SESSION['email'];

$query = "SELECT * FROM users WHERE u_id = '$u_id' LIMIT 1";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) !== 1) {
    die("User not found.");
}

$user = mysqli_fetch_assoc($result);

if (isset($_POST['update'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $contactno = $_POST['contactno'];
    $dob = $_POST['dob'];

    $update = "UPDATE users 
               SET name='$name', email='$email', contactno='$contactno', dob='$dob' 
               WHERE u_id='$u_id'";

    if (mysqli_query($conn, $update)) {
        echo "<script>alert('Profile updated successfully'); window.location='profile.php';</script>";
        exit;
    } else {
        echo "<script>alert('Update failed');</script>";
    }
}
?>

<?php include('includes/header.php'); ?>

<style>
:root {
    --bg-dark: #1e2433; 
    --bg-card: #262d40;
    --accent: #d1ad72;
    --text-light: #eaeaea;
    --text-muted: #a5a8b1;
}

body {
    background: #040d22ff;
    font-family: 'Poppins', sans-serif;
}

.profile-wrapper {
    position: relative;
    max-width: 1200px;
    margin: 100px 10px 50px 90px;
    background: var(--bg-card);
    border-radius: 16px;
    display: grid;
    grid-template-columns: 260px 1fr;
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(0,0,0,0.25);
}

/* Sidebar */
.profile-sidebar {
    background: var(--bg-dark);
    padding: 30px 20px;
}

.profile-sidebar h2 {
    color: var(--accent);
    font-size: 22px;
    margin-bottom: 30px;
}

.profile-sidebar a {
    display: block;
    color: var(--text-light);
    text-decoration: none;
    padding: 12px 10px;
    border-radius: 8px;
    margin-bottom: 10px;
    transition: 0.3s;
}

.profile-sidebar a:hover,
.profile-sidebar a.active {
    background: rgba(209,173,114,0.15);
    color: var(--accent);
}

/* Content */
.profile-content {
    padding: 40px;
    color: var(--text-light);
}

.profile-content h3 {
    margin-bottom: 25px;
    color: var(--accent);
}

.form-group {
    display: grid;
    grid-template-columns: 140px 1fr;
    gap: 20px;
    margin-bottom: 20px;
    align-items: center;
}

.form-group label {
    color: var(--text-muted);
}

.form-group input {
    background: transparent;
    border: none;
    border-bottom: 1px solid var(--text-muted);
    color: var(--text-light);
    padding: 8px;
    font-size: 16px;
}

.form-group input:focus {
    outline: none;
    border-color: var(--accent);
}

.update-btn {
    margin-top: 30px;
    background: var(--accent);
    color: #1e2433;
    border: none;
    padding: 12px 30px;
    border-radius: 30px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s;
}

.update-btn:hover {
    background: #c29a5c;
}

/* Responsiveness Media Queries */
@media (max-width: 992px) {
    .profile-wrapper {
        grid-template-columns: 1fr;
        margin: 80px 15px 40px 15px;
    }
    .profile-sidebar {
        display: flex;
        overflow-x: auto;
        gap: 10px;
        padding: 20px;
        scrollbar-width: none;
    }
    .profile-sidebar::-webkit-scrollbar { display: none; }
    .profile-sidebar h2 { display: none; }
    .profile-sidebar a {
        flex-shrink: 0;
        margin-bottom: 0;
        padding: 8px 15px;
        white-space: nowrap;
    }
    .profile-content { padding: 30px 20px; }
    .form-group { grid-template-columns: 1fr; gap: 8px; }
}

@media (max-width: 480px) {
    .profile-content h3 { font-size: 20px; }
    .update-btn { width: 100%; border-radius: 12px; }
}
</style>

<div class="profile-wrapper">

    <!-- Sidebar -->
    <div class="profile-sidebar">
        <h2>My Account</h2>
        <a href="profile.php" class="active">Profile</a>
        <a href="history.php">Travel History</a>
        <a href="payment&billing.php">Payment & Billing</a>
        <a href="settings.php">Settings</a>
        <a href="help.php">Help</a>
        <a href="logout.php">Logout</a>
    </div>

    <!-- Content -->
    <div class="profile-content">
        <h3>Profile Details</h3>

        <form method="post">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>">
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>">
            </div>

            <div class="form-group">
                <label>Contact</label>
                <input type="text" name="contactno" value="<?= htmlspecialchars($user['contactno']) ?>">
            </div>

            <div class="form-group">
                <label>Date of Birth</label>
                <input type="date" name="dob" value="<?= htmlspecialchars($user['dob']) ?>">
            </div>

            <button class="update-btn" type="submit" name="update">Update Profile</button>
        </form>
    </div>

</div>

<?php include('includes/footer.php'); ?>
