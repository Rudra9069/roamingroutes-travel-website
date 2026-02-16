<?php include('database/traveldb.php'); ?>
<?php include('config.php'); ?>

<?php
// Email
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer files
require 'vendor/autoload.php';

    session_start();
    if(isset($_POST['signup']))
    {   
        $name = $_POST['name'];
        $email = $_POST['email'];
        $contactno = $_POST['contactno'];
        $pwd = password_hash($_POST['pwd'], PASSWORD_DEFAULT);
        $c_pwd = $_POST['c_pwd'];
        $dob = $_POST['dob'];
        $verify_token = md5(rand());
        $verify_link = $SITE_URL . "verify.php?token=$verify_token";

        $checkemail = "SELECT 1 FROM users WHERE email = '$email' LIMIT 1";
        $result = mysqli_query($conn , $checkemail);

        if(mysqli_num_rows ($result) > 0 )
        {
            echo "<script> alert('Email already exist!'); </script>";
        }
        else
        {
            $sql = "INSERT INTO users(`name`, `email`, `contactno`, `pwd`,`dob`,`verify_token`) 
                    VALUES ('$name','$email','$contactno','$pwd','$dob','$verify_token')";

                if (mysqli_query($conn,$sql)) 
                {
                    $mail = new PHPMailer(true);

                        try
                        {
                        //Server settings
                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com';
                        $mail->SMTPAuth = true;
                        $mail->Username = 'roamingroutes33@gmail.com';
                        $mail->Password = 'tsjs igis tazc vazs';
                        $mail->SMTPSecure = 'ssl';
                        $mail->Port = 465;

                        //Recipients
                        $mail->setFrom('roamingroutes33@gmail.com', 'Roaming Routes');
                        $mail->addAddress($email, $name);

                        //Content
                        $mail->isHTML(true);
                        $template = file_get_contents('welcome_email.php');
                        $body = str_replace( ['{{name}}', '{{verify_link}}'],
                                             [$name, $verify_link], 
                                             $template);

                        $mail->Subject = "Your Roaming Routes Account Has Been Created Successfully.";
                        $mail->Body = $body;

                        $mail->send();
                        echo "<script> alert('Email has been sent to $email to verify your account')
                                window.location.href = 'login.php';  
                                </script>";
                        }
                            catch (Exception $e) 
                        {
                            echo "Email could not be sent. Error: {$mail->ErrorInfo}";
                        }
                }
        }    
    }

?>

<?php include('includes/header.php'); ?>
<script>
        function validation()
        {
        var a = document.getElementById("name").value;
        var b = document.getElementById("email").value;
        var c = document.getElementById("contactno").value;
        var d = document.getElementById("pwd").value;
        var e = document.getElementById("c_pwd").value;
        var checkem = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (a=="" ||b=="" ||c=="" ||d=="" ||e=="")
        {
            alert("Please fill all the informations");
            return false;
        }
        else if(!checkem.test(b))
        {
            alert("Enter a valid email address");
            return false;
        }
        else if(c.length<10 || c.length>10)
        {
            alert("Contact number invalid");
            return false;
        }
        else if(isNaN(c))
        {
            alert("Alphabets not allowed.!");
            return false;
        }
        else if(d!=e)
        {
            alert("Please enter the same password")
            return false;
        }
        else
        {
            return true;
        }
        }
    </script>
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
        background: linear-gradient(135deg, #0f0f12 0%, #1a1a24 100%);
        padding: 20px;
    }

    /* Background image with blur for depth */
    .bg-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.3;
        filter: blur(8px);
        z-index: 0;
    }

    .main-container {
        position: relative;
        margin: 80px auto 40px;
        display: flex;
        min-height: 600px;
        width: 100%;
        max-width: 1000px;
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 30px;
        overflow: hidden;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        z-index: 1;
        animation: containerFadeIn 0.8s ease-out;
    }

    @keyframes containerFadeIn {
        0% { opacity: 0; transform: scale(0.95); }
        100% { opacity: 1; transform: scale(1); }
    }

    /* Left Image Section */
    .image-section {
        flex: 1;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .image-section img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .main-container:hover .image-section img {
        transform: scale(1.05);
    }

    .image-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        padding: 40px;
        background: linear-gradient(transparent, rgba(0,0,0,0.8));
    }

    .image-overlay h2 {
        font-family: 'Cinzel', serif;
        font-size: 28px;
        margin-bottom: 10px;
        color: #fff;
    }

    .image-overlay p {
        font-size: 14px;
        color: rgba(255,255,255,0.7);
    }

    /* Right Form Section */
    .form-section {
        flex: 1;
        padding: 40px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        background: rgba(255, 255, 255, 0.02);
    }

    .form-section h1 {
        font-size: 32px;
        margin-bottom: 30px;
        text-align: center;
        font-weight: 600;
        background: linear-gradient(90deg, #fff, #aaa);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .input-box {
        position: relative;
        margin-bottom: 20px;
    }

    .input-box input {
        width: 100%;
        padding: 15px 15px 15px 45px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        color: white;
        font-size: 15px;
        outline: none;
        transition: all 0.3s ease;
    }

    .input-box input:focus {
        background: rgba(255, 255, 255, 0.1);
        border-color: rgba(255, 255, 255, 0.3);
        box-shadow: 0 0 15px rgba(255, 255, 255, 0.05);
    }

    .input-box i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: rgba(255, 255, 255, 0.5);
        font-size: 18px;
    }

    .dob-container {
        margin-bottom: 20px;
    }

    .dob-container label {
        display: block;
        margin-bottom: 8px;
        font-size: 13px;
        color: rgba(255, 255, 255, 0.5);
        margin-left: 5px;
    }

    input[type="date"] {
        width: 100%;
        padding: 12px 15px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        color: white;
        outline: none;
        font-family: inherit;
    }

    .btn {
        width: 100%;
        padding: 15px;
        background: white;
        color: black;
        border: none;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 10px;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        background: #f0f0f0;
        color: rgb(0,0,0);
    }

    .btn:active {
        transform: translateY(0);
    }

    .login-link {
        margin-top: 25px;
        text-align: center;
        font-size: 14px;
        color: rgba(255, 255, 255, 0.6);
    }

    .login-link a {
        color: white;
        text-decoration: none;
        font-weight: 600;
        margin-left: 5px;
    }

    .login-link a:hover {
        text-decoration: underline;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .main-container {
            flex-direction: column;
            max-width: 450px;
            min-height: auto;
            border-radius: 20px;
            margin: 100px 15px 40px;
        }
        .image-section {
            height: 200px;
        }
        .image-overlay { padding: 20px; }
        .image-overlay h2 { font-size: 22px; }
        .form-section {
            padding: 30px 20px;
        }
        .form-section h1 { font-size: 28px; margin-bottom: 20px; }
    }

    @media (max-width: 480px) {
        .auth-wrapper { padding: 10px; }
        .main-container { margin: 80px 5px 30px; }
        .form-section { padding: 25px 15px; }
        .form-section h1 { font-size: 24px; }
        .btn { padding: 12px; }
    }
</style>

<body>
    <div class="auth-wrapper">
        <img class="bg-image" src="img/register.jpg" alt="background">
        
        <div class="main-container">
            <!-- Left Card: Image -->
            <div class="image-section">
                <img src="img/register.jpg" alt="Register">
                <div class="image-overlay">
                    <h2>Join Roaming Routes</h2>
                    <p>Start your journey with us and explore the world's most beautiful destinations.</p>
                </div>
            </div>

            <!-- Right Card: Form -->
            <div class="form-section">
                <h1> Register </h1>
                <form onsubmit="return validation()" action="" method="post">
                    <div class="input-box">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" id="name" name="name" placeholder="Full Name" required>
                    </div>
                    <div class="input-box">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="email" id="email" name="email" placeholder="Email Address" required>
                    </div>
                    <div class="input-box">
                        <i class="fa-solid fa-phone"></i>
                        <input type="text" id="contactno" name="contactno" placeholder="Contact Number" required>
                    </div>
                    <div class="input-box">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" id="pwd" name="pwd" placeholder="Password" required>
                    </div>
                    <div class="input-box">
                        <i class="fa-solid fa-check-double"></i>
                        <input type="password" id="c_pwd" name="c_pwd" placeholder="Confirm Password" required>
                    </div>
                    <div class="dob-container">
                        <label for="dob">Date of Birth</label>
                        <input type="date" id="dob" name="dob" max="2025-04-15" required>
                    </div>
                    <button type="submit" class="btn" name="signup"> Create Account </button>
                    <div class="login-link">
                        <p> Already a member? <a href="login.php">Login</a> </p>
                    </div>
                </form>
            </div> 
        </div>
    </div>
</body>

<?php include('includes/footer.php'); ?>
