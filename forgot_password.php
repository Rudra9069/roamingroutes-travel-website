<?php
session_start();
include('database/traveldb.php');
include('config.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

$message = "";
$messageType = "";
$step = 1; // 1: Enter Email, 2: Verify OTP, 3: Reset Password

// Determine current step from session
if (isset($_SESSION['reset_otp_verified']) && $_SESSION['reset_otp_verified'] === true) {
    $step = 3;
} elseif (isset($_SESSION['reset_otp'])) {
    $step = 2;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Step 1: Send OTP to email
    if (isset($_POST['send_otp'])) {
        $email = trim($_POST['email']);

        // Check if email exists in database
        $query = "SELECT * FROM users WHERE email = ? LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            // Generate 6-digit OTP
            $otp = rand(100000, 999999);
            
            // Store OTP and email in session
            $_SESSION['reset_otp'] = $otp;
            $_SESSION['reset_email'] = $email;
            $_SESSION['reset_name'] = $user['name'];
            $_SESSION['otp_time'] = time();

            // Send OTP via email
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'roamingroutes33@gmail.com';
                $mail->Password = 'tsjs igis tazc vazs';
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;

                $mail->setFrom('roamingroutes33@gmail.com', 'Roaming Routes');
                $mail->addAddress($email, $user['name']);

                $mail->isHTML(true);
                $mail->Subject = "Password Reset OTP - Roaming Routes";
                $mail->Body = '
                <!DOCTYPE html>
                <html>
                <head>
                    <style>
                        body { font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 0; background: #f4f4f4; }
                        .container { max-width: 600px; margin: 0 auto; background: #1a2341; border-radius: 12px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.2); }
                        .header { padding: 40px 20px; text-align: center; border-bottom: 2px solid #d1ad72; }
                        .header h2 { color: #d1ad72; margin: 0; letter-spacing: 3px; }
                        .content { padding: 40px 30px; color: #fff; line-height: 1.6; }
                        .content h1 { color: #d1ad72; font-size: 24px; margin-bottom: 20px; }
                        .content p { font-size: 16px; color: #e0e0e0; margin-bottom: 20px; }
                        .otp-box { text-align: center; margin: 30px 0; }
                        .otp-code { display: inline-block; background: #d1ad72; color: #1a2341; font-size: 36px; font-weight: 700; padding: 15px 40px; border-radius: 12px; letter-spacing: 8px; }
                        .footer { padding: 20px; background: #151b33; text-align: center; color: #a5a8b1; font-size: 13px; }
                    </style>
                </head>
                <body>
                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr><td align="center" style="padding: 40px 0;">
                            <table class="container" width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr><td class="header"><h2>ROAMING ROUTES</h2></td></tr>
                                <tr><td class="content">
                                    <h1>Password Reset Request</h1>
                                    <p>Hello, ' . htmlspecialchars($user['name']) . '</p>
                                    <p>We received a request to reset your password. Use the OTP below to verify your identity:</p>
                                    <div class="otp-box"><span class="otp-code">' . $otp . '</span></div>
                                    <p>This OTP is valid for <strong>10 minutes</strong>. Do not share it with anyone.</p>
                                    <p style="margin-top: 30px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 20px;">
                                        If you did not request this, please ignore this email.<br>
                                        <b style="color: #d1ad72;">The Roaming Routes Team</b>
                                    </p>
                                </td></tr>
                                <tr><td class="footer"><p>&copy; 2026 Roaming Routes Pvt Ltd. All rights reserved.</p></td></tr>
                            </table>
                        </td></tr>
                    </table>
                </body>
                </html>';

                $mail->send();
                $step = 2;
                $message = "OTP has been sent to your email address.";
                $messageType = "success";
            } catch (Exception $e) {
                $message = "Failed to send OTP. Please try again. Error: " . $mail->ErrorInfo;
                $messageType = "error";
                $step = 1;
            }
        } else {
            $message = "No account found with this email address.";
            $messageType = "error";
        }
    }

    // Step 2: Verify OTP
    elseif (isset($_POST['verify_otp'])) {
        $entered_otp = trim($_POST['otp']);

        if (isset($_SESSION['reset_otp']) && isset($_SESSION['otp_time'])) {
            $elapsed = time() - $_SESSION['otp_time'];

            if ($elapsed > 600) {
                // OTP expired (10 minutes)
                unset($_SESSION['reset_otp'], $_SESSION['reset_email'], $_SESSION['reset_name'], $_SESSION['otp_time']);
                $message = "OTP has expired. Please request a new one.";
                $messageType = "error";
                $step = 1;
            } elseif ($entered_otp == $_SESSION['reset_otp']) {
                $_SESSION['reset_otp_verified'] = true;
                $step = 3;
                $message = "OTP verified successfully! Set your new password.";
                $messageType = "success";
            } else {
                $message = "Invalid OTP. Please try again.";
                $messageType = "error";
                $step = 2;
            }
        } else {
            $message = "Session expired. Please start over.";
            $messageType = "error";
            $step = 1;
        }
    }

    // Step 3: Reset Password
    elseif (isset($_POST['reset_password'])) {
        $new_pwd = $_POST['new_pwd'];
        $confirm_pwd = $_POST['confirm_pwd'];

        if (isset($_SESSION['reset_otp_verified']) && $_SESSION['reset_otp_verified'] === true && isset($_SESSION['reset_email'])) {
            if (strlen($new_pwd) < 6) {
                $message = "Password must be at least 6 characters.";
                $messageType = "error";
                $step = 3;
            } elseif ($new_pwd === $confirm_pwd) {
                $email = $_SESSION['reset_email'];
                $hashed_pwd = password_hash($new_pwd, PASSWORD_DEFAULT);
                $update_query = "UPDATE users SET pwd = ? WHERE email = ?";
                $update_stmt = $conn->prepare($update_query);
                $update_stmt->bind_param("ss", $hashed_pwd, $email);

                if ($update_stmt->execute()) {
                    // Clear all reset session data
                    unset($_SESSION['reset_otp'], $_SESSION['reset_email'], $_SESSION['reset_name'], $_SESSION['otp_time'], $_SESSION['reset_otp_verified']);
                    $message = "Password reset successfully! You can now log in with your new password.";
                    $messageType = "success";
                    $step = 4; // Done
                } else {
                    $message = "Error resetting password. Please try again.";
                    $messageType = "error";
                    $step = 3;
                }
            } else {
                $message = "Passwords do not match.";
                $messageType = "error";
                $step = 3;
            }
        } else {
            $message = "Session expired. Please start over.";
            $messageType = "error";
            $step = 1;
        }
    }

    // Resend OTP
    elseif (isset($_POST['resend_otp'])) {
        if (isset($_SESSION['reset_email'])) {
            $email = $_SESSION['reset_email'];
            $query = "SELECT * FROM users WHERE email = ? LIMIT 1";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();

            $otp = rand(100000, 999999);
            $_SESSION['reset_otp'] = $otp;
            $_SESSION['otp_time'] = time();

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'roamingroutes33@gmail.com';
                $mail->Password = 'tsjs igis tazc vazs';
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;

                $mail->setFrom('roamingroutes33@gmail.com', 'Roaming Routes');
                $mail->addAddress($email, $user['name']);

                $mail->isHTML(true);
                $mail->Subject = "Password Reset OTP - Roaming Routes";
                $mail->Body = '
                <div style="font-family: Segoe UI, sans-serif; max-width: 600px; margin: auto; background: #1a2341; border-radius: 12px; overflow: hidden;">
                    <div style="padding: 30px; text-align: center; border-bottom: 2px solid #d1ad72;"><h2 style="color: #d1ad72; letter-spacing: 3px;">ROAMING ROUTES</h2></div>
                    <div style="padding: 30px; color: #fff;">
                        <h2 style="color: #d1ad72;">New OTP Request</h2>
                        <p>Hello, ' . htmlspecialchars($user['name']) . '</p>
                        <p>Your new OTP is:</p>
                        <div style="text-align: center; margin: 25px 0;"><span style="display: inline-block; background: #d1ad72; color: #1a2341; font-size: 36px; font-weight: 700; padding: 15px 40px; border-radius: 12px; letter-spacing: 8px;">' . $otp . '</span></div>
                        <p>Valid for <strong>10 minutes</strong>.</p>
                    </div>
                    <div style="padding: 15px; background: #151b33; text-align: center; color: #a5a8b1; font-size: 13px;">&copy; 2026 Roaming Routes Pvt Ltd.</div>
                </div>';

                $mail->send();
                $message = "New OTP has been sent to your email.";
                $messageType = "success";
                $step = 2;
            } catch (Exception $e) {
                $message = "Failed to resend OTP.";
                $messageType = "error";
                $step = 2;
            }
        } else {
            $step = 1;
        }
    }

    // Cancel / Start Over
    elseif (isset($_POST['start_over'])) {
        unset($_SESSION['reset_otp'], $_SESSION['reset_email'], $_SESSION['reset_name'], $_SESSION['otp_time'], $_SESSION['reset_otp_verified']);
        $step = 1;
    }
}
?>

<?php include('includes/header.php'); ?>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        margin: 0;
        padding: 0;
        background-color: #0f0f12;
        font-family: 'Poppins', sans-serif;
        color: white;
        overflow-x: hidden;
    }

    .auth-wrapper {
        position: relative;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: #000;
        overflow: hidden;
    }

    .auth-wrapper img.bg-img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.4;
        filter: blur(5px);
        z-index: 0;
    }

    .card {
        position: relative;
        background-color: rgba(0, 0, 0, 0.45);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(15px);
        width: 100%;
        max-width: 500px;
        padding: 50px 40px;
        border-radius: 30px;
        font-family: 'Poppins', sans-serif;
        border: 1px solid rgba(255, 255, 255, 0.1);
        z-index: 10;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        margin: auto;
        animation: cardFadeIn 0.5s ease-out;
    }

    @keyframes cardFadeIn {
        0% { opacity: 0; transform: translateY(20px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    .card h1 {
        font-size: 28px;
        color: white;
        text-align: center;
        margin-bottom: 10px;
        font-weight: 600;
        background: linear-gradient(90deg, #fff, #aaa);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .card .subtitle {
        text-align: center;
        color: rgba(255,255,255,0.5);
        font-size: 14px;
        margin-bottom: 30px;
    }

    /* Steps indicator */
    .steps {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-bottom: 30px;
    }

    .step-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
        transition: all 0.3s ease;
    }

    .step-dot.active {
        background: #37aed6;
        box-shadow: 0 0 10px rgba(55,174,214,0.5);
        transform: scale(1.3);
    }

    .step-dot.done {
        background: #2ecc71;
    }

    .input-box {
        position: relative;
        width: 100%;
        margin-bottom: 25px;
    }

    .input-box input {
        width: 100%;
        background-color: rgba(255, 255, 255, 0.95);
        border: none;
        outline: none;
        border-radius: 12px;
        font-size: 16px;
        padding: 15px 15px 15px 45px;
        color: #333;
    }

    .input-box i {
        color: #333;
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 18px;
    }

    /* OTP input styling */
    .otp-inputs {
        display: flex;
        gap: 10px;
        justify-content: center;
        margin-bottom: 25px;
    }

    .otp-inputs input {
        width: 50px;
        height: 60px;
        text-align: center;
        font-size: 24px;
        font-weight: 700;
        border: 2px solid rgba(255,255,255,0.2);
        border-radius: 12px;
        background: rgba(255,255,255,0.95);
        color: #333;
        outline: none;
        transition: all 0.3s ease;
    }

    .otp-inputs input:focus {
        border-color: #37aed6;
        box-shadow: 0 0 15px rgba(55,174,214,0.3);
    }

    .btn {
        width: 100%;
        padding: 15px;
        background-color: #fff;
        color: #333;
        border: none;
        outline: none;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, .2);
        cursor: pointer;
        font-size: 18px;
        font-weight: 700;
        margin-top: 10px;
        transition: all 0.3s ease;
    }

    .btn:hover {
        background-color: #05680f;
        color: #ffffff;
        transform: translateY(-2px);
    }

    .btn-secondary {
        background: transparent;
        border: 1px solid rgba(255,255,255,0.3);
        color: white;
        margin-top: 10px;
        font-weight: 500;
        box-shadow: none;
    }

    .btn-secondary:hover {
        background: rgba(255,255,255,0.1);
        color: white;
        transform: translateY(-2px);
    }

    .alert {
        padding: 14px 18px;
        border-radius: 12px;
        margin-bottom: 25px;
        font-size: 14px;
        text-align: center;
        animation: alertSlide 0.3s ease-out;
    }

    @keyframes alertSlide {
        0% { opacity: 0; transform: translateY(-10px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    .alert-success {
        background: rgba(46, 204, 113, 0.15);
        color: #2ecc71;
        border: 1px solid rgba(46, 204, 113, 0.3);
    }

    .alert-error {
        background: rgba(231, 76, 60, 0.15);
        color: #e74c3c;
        border: 1px solid rgba(231, 76, 60, 0.3);
    }

    .resend-link {
        text-align: center;
        margin-top: 20px;
        color: rgba(255,255,255,0.5);
        font-size: 14px;
    }

    .resend-link button {
        background: none;
        border: none;
        color: #37aed6;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        font-family: 'Poppins', sans-serif;
    }

    .resend-link button:hover {
        text-decoration: underline;
    }

    .back-link {
        display: block;
        text-align: center;
        margin-top: 25px;
        color: #37aed6;
        text-decoration: none;
        font-size: 16px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .back-link:hover {
        text-decoration: underline;
    }

    .email-display {
        text-align: center;
        color: rgba(255,255,255,0.7);
        font-size: 14px;
        margin-bottom: 20px;
    }

    .email-display strong {
        color: #37aed6;
    }

    .success-icon {
        text-align: center;
        font-size: 60px;
        margin-bottom: 20px;
        color: #2ecc71;
        animation: scaleIn 0.5s ease-out;
    }

    @keyframes scaleIn {
        0% { transform: scale(0); opacity: 0; }
        100% { transform: scale(1); opacity: 1; }
    }

    /* Responsiveness */
    @media (max-width: 768px) {
        .card { 
            width: 100%; 
            max-width: 420px; 
            padding: 40px 25px; 
            border-radius: 20px;
            margin: 80px 15px 40px;
        }
        .card h1 { font-size: 24px; }
        .otp-inputs input { width: 44px; height: 54px; font-size: 20px; }
    }

    @media (max-width: 480px) {
        .auth-wrapper { padding: 10px; }
        .card { padding: 30px 20px; }
        .card h1 { font-size: 22px; }
        .btn { padding: 12px; }
        .otp-inputs input { width: 40px; height: 50px; font-size: 18px; }
        .otp-inputs { gap: 6px; }
    }
</style>

<body>
    <div class="auth-wrapper">
        <img class="bg-img" alt="img" src="img/login_2.jpg" loading="lazy" decoding="async">
        <div class="card">

            <!-- Step Indicators -->
            <div class="steps">
                <div class="step-dot <?php echo ($step >= 1) ? ($step > 1 ? 'done' : 'active') : ''; ?>"></div>
                <div class="step-dot <?php echo ($step >= 2) ? ($step > 2 ? 'done' : 'active') : ''; ?>"></div>
                <div class="step-dot <?php echo ($step >= 3) ? ($step > 3 ? 'done' : 'active') : ''; ?>"></div>
            </div>

            <?php if ($message): ?>
                <div class="alert alert-<?php echo $messageType; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <!-- Step 1: Enter Email -->
            <?php if ($step == 1): ?>
                <h1>Forgot Password?</h1>
                <p class="subtitle">Enter your email to receive an OTP</p>
                <form action="forgot_password.php" method="POST">
                    <div class="input-box">
                        <input type="email" name="email" placeholder="Email Address" required autofocus>
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <button type="submit" name="send_otp" class="btn">Send OTP</button>
                </form>
                <a href="login.php" class="back-link">Back to Login</a>

            <!-- Step 2: Verify OTP -->
            <?php elseif ($step == 2): ?>
                <h1>Verify OTP</h1>
                <p class="subtitle">Enter the 6-digit code sent to your email</p>
                <div class="email-display">
                    Sent to: <strong><?php echo htmlspecialchars($_SESSION['reset_email'] ?? ''); ?></strong>
                </div>
                <form action="forgot_password.php" method="POST">
                    <div class="otp-inputs">
                        <input type="text" maxlength="1" class="otp-digit" oninput="moveToNext(this, 1)" onkeydown="moveToPrev(event, this, 0)" autofocus>
                        <input type="text" maxlength="1" class="otp-digit" oninput="moveToNext(this, 2)" onkeydown="moveToPrev(event, this, 1)">
                        <input type="text" maxlength="1" class="otp-digit" oninput="moveToNext(this, 3)" onkeydown="moveToPrev(event, this, 2)">
                        <input type="text" maxlength="1" class="otp-digit" oninput="moveToNext(this, 4)" onkeydown="moveToPrev(event, this, 3)">
                        <input type="text" maxlength="1" class="otp-digit" oninput="moveToNext(this, 5)" onkeydown="moveToPrev(event, this, 4)">
                        <input type="text" maxlength="1" class="otp-digit" oninput="moveToNext(this, 6)" onkeydown="moveToPrev(event, this, 5)">
                    </div>
                    <input type="hidden" name="otp" id="otp-hidden">
                    <button type="submit" name="verify_otp" class="btn" onclick="combineOTP()">Verify OTP</button>
                </form>
                <div class="resend-link">
                    Didn't receive the code? 
                    <form action="forgot_password.php" method="POST" style="display:inline;">
                        <button type="submit" name="resend_otp">Resend OTP</button>
                    </form>
                </div>
                <form action="forgot_password.php" method="POST" style="text-align:center; margin-top: 10px;">
                    <button type="submit" name="start_over" class="btn-secondary" style="border:none; background:none; color: rgba(255,255,255,0.5); cursor:pointer; font-size: 14px; font-family: 'Poppins';">← Start Over</button>
                </form>

            <!-- Step 3: Set New Password -->
            <?php elseif ($step == 3): ?>
                <h1>Set New Password</h1>
                <p class="subtitle">Create a strong password for your account</p>
                <form action="forgot_password.php" method="POST">
                    <div class="input-box">
                        <input type="password" name="new_pwd" placeholder="New Password" required autofocus minlength="6">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    <div class="input-box">
                        <input type="password" name="confirm_pwd" placeholder="Confirm Password" required minlength="6">
                        <i class="fa-solid fa-check-double"></i>
                    </div>
                    <button type="submit" name="reset_password" class="btn">Reset Password</button>
                </form>

            <!-- Step 4: Success -->
            <?php elseif ($step == 4): ?>
                <div class="success-icon">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <h1>Password Reset!</h1>
                <p class="subtitle">Your password has been changed successfully</p>
                <a href="login.php" class="btn" style="display:block; text-align:center; text-decoration:none;">Go to Login</a>
            <?php endif; ?>

        </div>
    </div>
</body>

<script>
    // Auto-move to next OTP input
    function moveToNext(current, nextIndex) {
        const inputs = document.querySelectorAll('.otp-digit');
        if (current.value.length === 1 && nextIndex < inputs.length) {
            inputs[nextIndex].focus();
        }
    }

    // Move to previous input on backspace
    function moveToPrev(event, current, prevIndex) {
        const inputs = document.querySelectorAll('.otp-digit');
        if (event.key === 'Backspace' && current.value === '' && prevIndex >= 0) {
            inputs[prevIndex].focus();
        }
    }

    // Combine all OTP digits into hidden field before submit
    function combineOTP() {
        const inputs = document.querySelectorAll('.otp-digit');
        let otp = '';
        inputs.forEach(input => otp += input.value);
        document.getElementById('otp-hidden').value = otp;
    }

    // Allow only numbers in OTP inputs
    document.querySelectorAll('.otp-digit').forEach(input => {
        input.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    });

    // Handle paste for OTP
    document.querySelectorAll('.otp-digit')[0]?.addEventListener('paste', function(e) {
        e.preventDefault();
        const pastedData = e.clipboardData.getData('text').trim();
        if (/^\d{6}$/.test(pastedData)) {
            const inputs = document.querySelectorAll('.otp-digit');
            for (let i = 0; i < 6; i++) {
                inputs[i].value = pastedData[i];
            }
            inputs[5].focus();
        }
    });
</script>

<?php include('includes/footer.php'); ?>
