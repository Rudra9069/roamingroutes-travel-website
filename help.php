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

<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$successMsg = $errorMsg = "";

if (isset($_POST['send_help'])) {

    $fromEmail = trim($_POST['email']);
    $message   = trim($_POST['message']);

    if (empty($fromEmail) || empty($message)) {
        $errorMsg = "All fields are required.";
    } else {

        // 1️⃣ Save complaint in DB
        $insert = $conn->prepare(
            "INSERT INTO complaints (user_email, message) VALUES (?, ?)"
        );
        $insert->bind_param("ss", $fromEmail, $message);
        $insert->execute();

        // 2️⃣ Send email to website Gmail
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'roamingroutes33@gmail.com';     // WEBSITE EMAIL
            $mail->Password   = 'tsjs igis tazc vazs';         // GMAIL APP PASSWORD
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            // FROM = user email
            $mail->setFrom($fromEmail, 'Roaming Routes User');

            // TO = website Gmail
            $mail->addAddress('roamingroutes33@gmail.com');

            $mail->isHTML(true);
            $mail->Subject = 'New User Complaint';
            $mail->Body = "
                <h3>New Complaint Received</h3>
                <p><strong>From:</strong> {$fromEmail}</p>
                <p><strong>Message:</strong><br>{$message}</p>
            ";

            $mail->send();
            $successMsg = "Your complaint has been sent successfully.";

        } catch (Exception $e) {
            $errorMsg = "Complaint saved, but email could not be sent.";
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

/* Help form */
.help-card {
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(209,173,114,0.3);
    border-radius: 14px;
    padding: 30px;
    max-width: 600px;
}

.help-card label {
    display: block;
    margin-bottom: 6px;
    font-size: 14px;
    color: var(--text-muted);
}

.help-card input,
.help-card textarea {
    width: 100%;
    background: transparent;
    border: 1px solid rgba(255,255,255,0.25);
    border-radius: 8px;
    padding: 12px;
    color: var(--text-light);
    font-size: 14px;
    margin-bottom: 20px;
    outline: none;
}

.help-card textarea {
    resize: none;
    height: 120px;
}

.help-card input:focus,
.help-card textarea:focus {
    border-color: var(--accent);
}

.help-card button {
    background: var(--accent);
    border: none;
    color: #1e2433;
    padding: 10px 26px;
    border-radius: 20px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s;
}

.help-card button:hover {
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
}

@media (max-width: 480px) {
    .profile-content h3 { font-size: 20px; }
    .help-card { padding: 20px; }
    .help-card button { width: 100%; border-radius: 12px; }
}
</style>

<div class="profile-wrapper">

    <!-- Sidebar -->
    <div class="profile-sidebar">
        <h2>My Account</h2>
        <a href="profile.php">Profile</a>
        <a href="history.php">Travel History</a>
        <a href="payment&billing.php">Payment & Billing</a>
        <a href="settings.php">Settings</a>
        <a href="help.php" class="active">Help</a>
        <a href="../index.php">Logout</a>
    </div>

    <!-- Content -->
    <div class="profile-content">
        <h3>Need Help?</h3>
        <p>If you have questions, issues, or feedback, feel free to contact us.</p>
        
        <?php if ($successMsg): ?>
            <p style="color:#22c55e; margin-bottom:15px;">
                <?= $successMsg ?>
            </p>
        <?php endif; ?>

        <?php if ($errorMsg): ?>
            <p style="color:#ef4444; margin-bottom:15px;">
                <?= $errorMsg ?>
            </p>
        <?php endif; ?>

        <div class="help-card">
            <form method="post">
                <label>Email</label>
                <input type="email" name="email"
                    value="<?= htmlspecialchars($user['email']) ?>" required>

                <label>Message</label>
                <textarea name="message" required
                        placeholder="Write your complaint here..."></textarea>

                <button type="submit" name="send_help">Send Message</button>
            </form>
        </div>
    </div>

</div>


<?php include('includes/footer.php'); ?>