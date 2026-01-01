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
        height: 680px;
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
        top: 3%;
        left: 65%;
        background-color: white;
        color: black;
        padding: 30px 20px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        height: 100%;
        max-height: 630px;
        width: 100%;
        max-width: 450px;
    }

    .ch2 {
        position: relative;
        text-align: center;
        font-family: 'Poppins';
        font-size: 35px;
        font-weight: 700;
    }

    .card input[type="text"] {
        position: relative;
        top: 25%;
        left: 9%;
        margin-right: 25px;
        padding: 10px;
        width: 150px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
    }

    .card input[type="email"],
    input[type="number"] {
        position: relative;
        top: 30%;
        left: 9%;
        padding: 10px;
        width: 330px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
    }

    .card textarea {
        position: relative;
        top: 30.5%;
        left: 9%;
        padding: 10px;
        width: 330px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
    }

    .card .c-em-btn {
        position: relative;
        top: 30%;
        left: 9%;
        padding: 10px;
        width: 330px;
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
        background-color: white;
    }

    .sec2-p {
        position: relative;
        font-family: 'Popins', sans-serif;
        font-size: 55px;
        font-weight: 700;
        margin-top: 2%;
        text-align: center;
    }

    .sec2-d {
        padding: 10px 0px 50px 0px;
    }

    .cards {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        margin: 20px 35px;
    }

    .card1,
    .card2,
    .card3 {
        position: relative;
        height: 200px;
        width: 450px;
        background-color: rgb(40, 40, 40);
        border-radius: 15px;
        border: none;
        box-shadow: 0px 0px 18px 2px rgba(0, 0, 0, 0.33);
    }

    .cards .cp-h {
        position: absolute;
        margin-top: 20px;
        margin-left: 10%;
        font-family: 'Poppins';
        font-size: 25px;
        font-weight: 700;
        color: white;
    }

    .cards .cp {
        position: absolute;
        margin-top: -20px;
        font-family: 'Poppins';
        font-size: 18px;
        padding: 10px 25px;
        color: white;
    }

    .cards i {
        position: absolute;
        margin-top: 5%;
        margin-left: 10%;
    }

    /* Map */
    .map-container {
        position: relative;
        margin-left: 4%;
        max-width: 1400px;
        box-shadow: 0 0 15px 0px rgba(0, 0, 0, 0.83);
        border-radius: 12px;
        overflow: hidden;
    }

    iframe {
        width: 100%;
        height: 500px;
        border: 15px solid rgba(0, 0, 0, 0.82);
    }
</style>

<body>

    <!-- Sec-1 -->
    <section class="sec1">

        <!-- Image -->
        <div class="image-container">
            <img src="img/contus.jpg" alt="Background" class="background-image">

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
                    <input type="text" id="fname" name="fname" placeholder="First Name" required>
                    <input type="text" id="lname" name="lname" placeholder="Last Name" required>
                    <input type="email" id="email" name="email" placeholder="Email Address" required>
                    <input type="number" id="email" name="number" placeholder="Contact no." required>
                    <textarea id="message" name="message" rows="5" cols="30"
                        placeholder="Type your message here..."></textarea>
                    <button class="c-em-btn" type="submit"> Submit </button>
                </form>
            </div>

        </div>
    </section>

    <!-- Sec-2 -->
    <section class="sec2">
        <p class="sec2-p"> Get in Touch: </p>
        <div class="sec2-d">
            <div class="cards">
                <div class="card1">
                    <p class="cp-h"> Contact No <i style="color: lightgreen;" class="fa-solid fa-mobile"></i> </p>
                    <p class="cp">
                        +91 8200214115 <br>
                        +91 9998007563
                    </p>
                </div>

                <div class="card2">
                    <p class="cp-h"> Location <i style="color: lightcoral;" class="fa-solid fa-location-dot"></i></p>
                    <p class="cp">
                        G-1 Krishna Sadan, <br>
                        Pranami Street Moti Chhipwad, <br>
                        Valsad - 396001
                    </p>
                </div>

                <div class="card3">
                    <p class="cp-h"> Email <i style="color: goldenrod;" class="fa-solid fa-paper-plane"></i> </p>
                    <p class="cp"> roamingroutes33@gmail.com </p>
                </div>
            </div>
        </div>
    </section>

    <!-- section 3 -->
    <div class="map-container">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3719.934723957472!2d72.92810951481642!3d20.610109386261235!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be0cdac90a07e1d%3A0x9e8c3fa423fa4cbb!2sValsad%2C%20Gujarat!5e0!3m2!1sen!2sin!4v1715327112345!5m2!1sen!2sin"
            allowfullscreen="" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>

</body>

<?php include('includes/footer.php'); ?>