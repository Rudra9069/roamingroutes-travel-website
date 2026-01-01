<?php

session_start();
include('database/traveldb.php');

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    echo "<h3>Please log in to view your profile.</h3>";
    exit;
}

// Get email from session
$email = $_SESSION['email'];

// Fetch user info from database
$query = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
} else {
    echo "<script> alert('User not found') </script>";
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
    background: #f4f6fb;
    font-family: 'Poppins', sans-serif;
}

.profile-wrapper {
    max-width: 1200px;
    margin: 50px auto;
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
    color: var(--accent);
    margin-bottom: 20px;
}

.profile-content p {
    color: var(--text-muted);
    margin-bottom: 30px;
}

/* Settings cards */
.setting-card {
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(209,173,114,0.25);
    border-radius: 14px;
    padding: 25px 30px;
    margin-bottom: 20px;
}

.setting-card h4 {
    margin-bottom: 8px;
    color: var(--text-light);
}

.setting-card span {
    font-size: 14px;
    color: var(--text-muted);
}

.setting-actions {
    margin-top: 15px;
}

.setting-actions a {
    display: inline-block;
    text-decoration: none;
    background: transparent;
    border: 1px solid var(--accent);
    color: var(--accent);
    padding: 8px 18px;
    border-radius: 20px;
    font-size: 14px;
    margin-right: 10px;
    transition: 0.3s;
}

.setting-actions a:hover {
    background: var(--accent);
    color: #1e2433;
}
</style>

<div class="profile-wrapper">

    <!-- Sidebar -->
    <div class="profile-sidebar">
        <h2>My Account</h2>
        <a href="profile.php">Profile</a>
        <a href="history.php">Travel History</a>
        <a href="payment&billing.php">Payment & Billing</a>
        <a href="settings.php" class="active">Settings</a>
        <a href="help.php">Help</a>
        <a href="../index.php">Logout</a>
    </div>

    <!-- Content -->
    <div class="profile-content">
        <h3>Account Settings</h3>
        <p>Manage your account security, preferences, and recovery options.</p>

        <!-- Change Password -->
        <div class="setting-card">
            <h4>Change Password</h4>
            <span>Update your account password regularly to keep your account secure.</span>
            <div class="setting-actions">
                <a href="#">Change Password</a>
            </div>
        </div>

        <!-- Forgot Password -->
        <div class="setting-card">
            <h4>Forgot Password</h4>
            <span>Reset your password if you are unable to remember your current one.</span>
            <div class="setting-actions">
                <a href="#">Reset Password</a>
            </div>
        </div>

    </div>

</div>


<?php include('includes/footer.php'); ?>