<?php
session_start();
include('database/traveldb.php');

$message = "";
$messageType = "";
$step = 1; // 1: Verify Email/DOB, 2: Reset Password
$user_email = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['verify_account'])) {
        $email = $_POST['email'];
        $dob = $_POST['dob'];

        $query = "SELECT * FROM users WHERE email = ? AND dob = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $email, $dob);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $step = 2;
            $user_email = $email;
        } else {
            $message = "Account details not found. Please check your Email and Date of Birth.";
            $messageType = "error";
        }
    } elseif (isset($_POST['reset_password'])) {
        $email = $_POST['email'];
        $new_pwd = $_POST['new_pwd'];
        $confirm_pwd = $_POST['confirm_pwd'];

        if ($new_pwd === $confirm_pwd) {
            $hashed_pwd = password_hash($new_pwd, PASSWORD_DEFAULT);
            $update_query = "UPDATE users SET pwd = ? WHERE email = ?";
            $update_stmt = $conn->prepare($update_query);
            $update_stmt->bind_param("ss", $hashed_pwd, $email);
            if ($update_stmt->execute()) {
                $message = "Password reset successfully! You can now log in with your new password.";
                $messageType = "success";
                $step = 3; // Finished
            } else {
                $message = "Error resetting password.";
                $messageType = "error";
                $step = 2;
                $user_email = $email;
            }
        } else {
            $message = "Passwords do not match.";
            $messageType = "error";
            $step = 2;
            $user_email = $email;
        }
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
    --success: #2ecc71;
    --error: #e74c3c;
}

body {
    background: #040d22ff;
    font-family: 'Poppins', sans-serif;
}

.profile-wrapper {
    max-width: 1200px;
    margin: 100px 10px 50px 90px;
    background: var(--bg-card);
    border-radius: 16px;
    display: grid;
    grid-template-columns: 260px 1fr;
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(0,0,0,0.25);
}

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

.profile-content {
    padding: 40px;
    color: var(--text-light);
}

.profile-content h3 {
    color: var(--accent);
    margin-bottom: 20px;
}

.alert {
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 30px;
    font-size: 14px;
}
.alert-success {
    background: rgba(46, 204, 113, 0.1);
    color: var(--success);
    border: 1px solid var(--success);
}
.alert-error {
    background: rgba(231, 76, 60, 0.1);
    color: var(--error);
    border: 1px solid var(--error);
}

.form-group {
    margin-bottom: 25px;
    max-width: 400px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    color: var(--text-muted);
    font-size: 14px;
}

.form-control {
    width: 100%;
    padding: 12px 15px;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(209, 173, 114, 0.2);
    border-radius: 8px;
    color: var(--text-light);
    font-family: 'Poppins';
    transition: 0.3s;
}

.btn-primary {
    background: var(--accent);
    color: #1e2433;
    border: none;
    padding: 12px 30px;
    border-radius: 30px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(209, 173, 114, 0.3);
}

.back-link {
    display: inline-block;
    margin-top: 20px;
    color: var(--text-muted);
    text-decoration: none;
    font-size: 14px;
}
.back-link:hover {
    color: var(--accent);
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
    .form-group { max-width: 100%; }
}

@media (max-width: 480px) {
    .profile-content h3 { font-size: 20px; }
    .btn-primary { width: 100%; border-radius: 12px; }
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
        <h3>Reset Password</h3>
        <p>Verify your account to set a new password.</p>

        <?php if ($message): ?>
            <div class="alert alert-<?php echo $messageType; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <?php if ($step == 1): ?>
            <form action="forgot_password.php" method="POST">
                <div class="form-group">
                    <label>Account Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Date of Birth</label>
                    <input type="date" name="dob" class="form-control" required>
                </div>
                <button type="submit" name="verify_account" class="btn-primary">Verify Account</button>
            </form>
        <?php elseif ($step == 2): ?>
            <form action="forgot_password.php" method="POST">
                <input type="hidden" name="email" value="<?php echo $user_email; ?>">
                <div class="form-group">
                    <label>New Password</label>
                    <input type="password" name="new_pwd" class="form-control" required autofocus>
                </div>
                <div class="form-group">
                    <label>Confirm New Password</label>
                    <input type="password" name="confirm_pwd" class="form-control" required>
                </div>
                <button type="submit" name="reset_password" class="btn-primary">Set New Password</button>
            </form>
        <?php elseif ($step == 3): ?>
            <a href="login.php" class="btn-primary" style="text-decoration: none;">Go to Login</a>
        <?php endif; ?>

        <a href="settings.php" class="back-link"><i class="fas fa-arrow-left"></i> Back to Settings ?</a>
    </div>
</div>

<?php include('includes/footer.php'); ?>
