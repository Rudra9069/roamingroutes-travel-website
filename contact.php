<?php 
session_start();
include('database/traveldb.php'); 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $fname   = htmlspecialchars($_POST['fname']);
    $lname   = htmlspecialchars($_POST['lname']);
    $email   = htmlspecialchars($_POST['email']);
    $number  = htmlspecialchars($_POST['number']);
    $message = htmlspecialchars($_POST['message']);

    // Check if user is registered
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User is registered, send email
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'roamingroutes33@gmail.com'; // your email
            $mail->Password   = 'tsjs igis tazc vazs';        // app password
            $mail->SMTPSecure = 'ssl';
            $mail->Port       = 465;

            // Recipients
            $mail->setFrom($email, $fname . ' ' . $lname);
            $mail->addAddress('roamingroutes33@gmail.com');

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'New Contact Form Submission';
            $mail->Body    = "
                <h3>Contact Form Details</h3>
                <p><strong>Name:</strong> $fname $lname</p>
                <p><strong>Email:</strong> $email</p>
                <p><strong>Contact Number:</strong> $number</p>
                <p><strong>Message:</strong><br>$message</p>
            ";

            $mail->send();
            echo "<script> alert('Your mail has been sent to Roaming Routes. Thankyou! '); 
                window.location.href='contact.php';</script>";
        } catch (Exception $e) {
            echo "<script>alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}'); 
                window.location.href='contact.php';</script>";
        }
    } else {
        // User not registered
        echo "<script>alert('Your email does not exist, please login or create an account to send mail.'); 
            window.location.href='contact.php';</script>";
    }

    $stmt->close();
    $conn->close();
}

?>
<?php include('includes/header.php'); ?>
<style>
    /* section 1 */
    .image-container {
        position: relative;
        width: 100%;
        height: 750px;
        overflow: hidden;
    }

    .background-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .overlay {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        background-color: rgba(0, 0, 0, 0.41);
        /* Slight black overlay */
        display: flex;
        color: white;
        padding: 20px;
    }

    .ch {
        position: absolute;
        top: 30%;
        left: 5%;
        font-size: 65px;
        font-weight: 750;
        font-family: 'Popins', sans-serif;
    }

    .cp {
        position: absolute;
        top: 45%;
        left: 5%;
        font-size: 18px;
        font-weight: 500;
        line-height: normal;
        color: rgb(228, 228, 228);
        font-family: 'Popins', sans-serif;
    }

    .card {
        position: absolute;
        top: 12%;
        left: 65%;
        background-color: white;
        color: black;
        padding: 30px 20px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        min-height: 100%;
        max-height: 630px;
        width: 100%;
        max-width: 450px;
        z-index: 10;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .ch2 {
        position: relative;
        text-align: center;
        font-family: 'Poppins';
        font-size: 35px;
        font-weight: 700;
        margin-bottom: 30px;
    }

    .card .form-row {
        display: flex;
        gap: 15px;
        margin-bottom: 15px;
    }

    .card input[type="text"],
    .card input[type="email"],
    .card input[type="number"],
    .card textarea {
        width: 100%;
        padding: 12px 15px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
        outline: none;
    }

    .card .c-em-btn {
        width: 100%;
        padding: 12px;
        background-color: rgb(30, 30, 30);
        border: none;
        color: white;
        border-radius: 5px;
        font-family: 'Popins', sans-serif;
        font-weight: 700;
        font-size: 18px;
        cursor: pointer;
        transition: 0.5s;
    }

    .card button:hover {
        background-color: #0056b3;
    }

    /* section 2 */
    .sec2 {
        background: #111827;
        padding: 60px 20px;
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .sec2-p {
        position: relative;
        font-family: 'Poppins', sans-serif;
        font-size: 36px;
        font-weight: 700;
        text-align: center;
        color: #ffffff;
        margin-bottom: 6px;
    }

    .sec2-p::after {
        content: '';
        display: block;
        width: 50px;
        height: 3px;
        background: #d2983b;
        margin: 12px auto 0;
        border-radius: 2px;
    }

    .sec2-sub {
        text-align: center;
        font-family: 'Poppins', sans-serif;
        font-size: 18px;
        color: rgba(255, 255, 255, 0.55);
        margin-bottom: 45px;
        margin-top: 28px;
    }

    .sec2-d {
        padding: 0;
        width: 100%;
        display: flex;
        justify-content: center;
    }

    .cards {
        display: flex;
        justify-content: center;
        align-items: stretch;
        flex-wrap: nowrap;
        gap: 50px;
        margin: 0 auto;
        max-width: 900px;
        width: 90%;
    }

    .card1, .card2, .card3 {
        flex: 1 1 0;
        padding: 45px 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        position: relative;
        transition: all 0.3s ease;
    }

    /* Vertical dividers between items */
    .card1::after, .card2::after {
        content: '';
        position: absolute;
        right: 0;
        top: 20%;
        height: 60%;
        width: 1px;
        background: rgba(255, 255, 255, 0.15);
    }

    .card1:hover, .card2:hover, .card3:hover {
        transform: scale(1.05);
    }

    .c-icon {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 30px;
        font-size: 22px;
        position: relative;
        background: rgba(210, 152, 59, 0.12);
        color: #d2983b;
        transition: all 0.3s ease;
    }

    .c-icon::after {
        content: '';
        position: absolute;
        inset: -4px;
        border-radius: 50%;
        border: 1.5px dashed rgba(210, 152, 59, 0.3);
        animation: iconSpin 12s linear infinite;
    }

    @keyframes iconSpin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .card1:hover .c-icon, .card2:hover .c-icon, .card3:hover .c-icon {
        background: rgba(210, 152, 59, 0.2);
        box-shadow: 0 0 18px rgba(210, 152, 59, 0.2);
    }

    .cards .cp-h {
        font-family: 'Poppins', sans-serif;
        font-size: 16px;
        font-weight: 600;
        color: #ffffff;
        margin-top: 30px;
        margin-bottom: 10px;
        letter-spacing: 0.5px;
    }

    .cards .cp-h i { display: none; }

    .cards .cp {
        font-family: 'Poppins', sans-serif;
        font-size: 15px;
        color: rgba(255, 255, 255, 0.5);
        line-height: 1.5;
        margin-top: 20px;
        padding: 0;
    }

    .cards i {
        position: static !important;
        margin: 0 !important;
    }

    /* Map */
    .map-container {
        position: relative;
        width: 100%;
        max-width: 1200px;
        margin: 40px auto;
        box-shadow: 0 0 15px 0px rgba(0, 0, 0, 0.83);
        border-radius: 12px;
        overflow: hidden;
    }

    iframe {
        width: 100%;
        height: 500px;
        border: 8px solid rgba(25, 25, 25, 1);
    }

    /* Responsiveness Media Queries */
    @media (max-width: 992px) {
        .ch { font-size: 45px; }
        .sec2 .cp { font-size: 14px; }
        .card { left: 50%; transform: translateX(-50%); top: 50%; max-height: none; height: auto; padding: 20px; }
        .card input[type="text"], .card input[type="email"], .card input[type="number"], .card textarea, .card .c-em-btn { width: 100%; position: static; margin-top: 15px; }
        .sec2-p { font-size: 30px; }
        .sec2 .cards { width: 95%; }
        .map-container { width: 95%; margin: 20px auto; }
    }

    @media (max-width: 768px) {
        .image-container { 
            height: auto; 
            min-height: 100vh; /* Allow it to cover the full screen */
            display: flex; 
            flex-direction: column; 
            background-color: #000;
        }
        .background-image { 
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%; /* Cover the entire container including the form area */
            object-fit: cover;
            opacity: 0.7; /* Keep it visible but subtle */
            z-index: 1;
        }
        .overlay { 
            position: relative; 
            flex-direction: column; 
            background: rgba(0, 0, 0, 0.4); 
            padding: 140px 20px 40px; 
            align-items: center; 
            height: auto; 
            z-index: 2;
        }
        .ch { 
            position: static; 
            font-size: 42px; 
            text-align: center; 
            margin-bottom: 15px; 
            text-shadow: 0 0 10px rgba(0,0,0,0.5);
        }
        .cp { 
            position: static; 
            font-size: 16px; 
            text-align: center; 
            margin-top: 0; 
            width: 100%; 
            color: #efefef; 
            line-height: 1.8;
        }
        .cp br { display: none; }
        .card { 
            position: relative; 
            left: auto !important; /* Force reset of desktop offset */
            transform: none; 
            margin: 0 auto 60px; 
            box-shadow: 0 8px 32px rgba(0,0,0,0.4); 
            width: 90%; 
            background: #fff; 
            z-index: 10; 
            padding: 25px;
        }
        .sec2-p { font-size: 26px; }
        .sec2-sub { margin-top: 16px; margin-bottom: 25px; font-size: 16px; }
        .sec2 { padding: 30px 15px; }
        .sec2 .cards { flex-direction: column; align-items: center; gap: 5px; flex-wrap: wrap; width: 100%; }
        .card1::after, .card2::after { display: none; }
        .sec2 .card1, .sec2 .card2, .sec2 .card3 { width: 100%; flex: none; padding: 15px 15px; }
        .sec2 .c-icon { margin-bottom: 15px; }
        .sec2 .cards .cp-h { margin-top: 12px; margin-bottom: 5px; }
        .sec2 .cards .cp { margin-top: 8px; }
        .map-container { width: 100%; border-radius: 0; margin-top: 0; }
        iframe { border: none; height: 350px; }
    }

    @media (max-width: 480px) {
        .ch { font-size: 28px; }
        .ch2 { font-size: 22px; margin-bottom: 20px; }
        .card { 
            width: 88%; 
            padding: 20px 15px; 
        }
        .card input[type="text"], 
        .card input[type="email"], 
        .card input[type="number"], 
        .card textarea {
            padding: 10px;
            font-size: 15px;
            margin-bottom: 12px;
        }
        .card .c-em-btn {
            padding: 10px;
            font-size: 16px;
        }
    }
</style>

<body>

    <!-- Sec-1 -->
    <section class="sec1">

        <!-- Image -->
        <div class="image-container">
            <img src="img/contus.jpg" alt="Background" class="background-image" loading="lazy" decoding="async">

            <!-- Overlay text -->
            <div class="overlay">
                <div class="c-text">
                    <h1 class="ch"> Contact Us </h1>
                    <p class="cp"> Feel free to contact us and share your thoughts, questions, <br>
                        or suggestions with Roaming Routes we're here to listen and <br>
                        constantly improve your travel experience.
                    </p>
                </div>
            </div>

            <!-- Contact us form -->
            <div class="card">
                <h4 class="ch2"> Have a query? </h4>
                <form action="contact.php" method="post">
                    <div class="form-row">
                        <input type="text" id="fname" name="fname" placeholder="First Name" required>
                        <input type="text" id="lname" name="lname" placeholder="Last Name" required>
                    </div>
                    <input type="email" id="email" name="email" placeholder="Email Address" required>
                    <input type="number" id="email" name="number" placeholder="Contact no." required>
                    <textarea id="message" name="message" rows="5"
                        placeholder="Type your message here..."></textarea>
                    <button class="c-em-btn" type="submit"> Submit </button>
                </form>
            </div>

        </div>
    </section>

    <!-- Sec-2 -->
    <section class="sec2">
        <p class="sec2-p">Get in Touch</p>
        <p class="sec2-sub">We're here to help with your travel plans</p>
        <div class="sec2-d">
            <div class="cards">
                <div class="card1">
                    <div class="c-icon">
                        <i class="fa-solid fa-phone"></i>
                    </div>
                    <p class="cp-h">Contact No</p>
                    <p class="cp">+91 8200214115</p>
                </div>

                <div class="card2">
                    <div class="c-icon">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <p class="cp-h">Location</p>
                    <p class="cp">Ahmedabad, Gujarat - 380001</p>
                </div>

                <div class="card3">
                    <div class="c-icon">
                        <i class="fa-solid fa-paper-plane"></i>
                    </div>
                    <p class="cp-h">Email</p>
                    <p class="cp">roamingroutes33@gmail.com</p>
                </div>
            </div>
        </div>
    </section>

    <!-- section 3 -->
    <div class="map-container">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d117176.06498498498!2d72.50991562812502!3d23.020474199999996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395e848aba5bd449%3A0x4fcedd11614f6516!2sAhmedabad%2C%20Gujarat!5e0!3m2!1sen!2sin!4v1715327112345!5m2!1sen!2sin"
            allowfullscreen="" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>

</body>

<?php include('includes/footer.php'); ?>