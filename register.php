<?php include('database/traveldb.php'); ?>

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
        $verify_link = "http://localhost/4_Travel/verify.php?token=$verify_token";

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
        /* background-image: url("img/login.jpg"); */
    }

    .auth-wrapper {
        position: relative;
        min-height: 100vh;
    }

    img {
        display: block;
        width: 100%;
        height: auto;
    }

    .card {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: rgba(238, 238, 238, 0.52);
        width: 600px;
        height: 630px;
    }


    .card h1 {
        position: relative;
        top: 50px;
        font-size: 40px;
        text-align: center;
        font-family: 'Poppins';
    }

    .card .input-box {
        position: relative;
        top: 60px;
        width: 100%;
        height: 25px;
        margin: 30px 100px;
        font-family: 'Poppins';
    }

    .input-box input {
        width: 400px;
        height: 10px;
        background-color: #fff;
        border: none;
        outline: none;
        border-radius: 40px;
        font-size: 17px;
        padding: 20px 15px 20px 40px;
    }

    .input-box input::placeholder {
        color: rgb(30, 29, 29);
    }

    .input-box i {
        color: black;
        position: absolute;
        left: 4%;
        top: 45%;
        transform: translate(-50%);
        font-size: 20px;

    }

    .dob {
        position: relative;
        top: 30px;
        width: 400px;
        height: 40px;
        border-radius: 40px;
        margin: -10px 30px;
        padding: 20px 20px 20px 40px;
        border: none;
        outline: none;
        font-family: 'Poppins';
    }

    .card .btn {
        position: relative;
        top: 100px;
        width: 100px;
        height: 45px;
        background-color: #fff;
        color: black;
        border: none;
        outline: none;
        border-radius: 40px;
        box-shadow: 0 0 10px rgba(0, 0, 0, .1);
        cursor: pointer;
        font-size: 16px;
        color: #333;
        font-weight: 600;
        margin: 10px 250px;
        font-family: 'Poppins';
        transition: 0.8s;
    }

    .card .btn:hover {
        background-color: rgb(43, 42, 42);
        color: #fff;
    }

    .card .login-link {
        position: relative;
        color: black;
        top: 120px;
        font-size: 17px;
        text-align: center;
    }

    .login-link p a {
        color: rgb(36, 49, 188);
        text-decoration: none;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-weight: 600;
    }

    .login-link p a:hover {
        text-decoration: underline;
    }
</style>

<body>
    <div class="auth-wrapper">
        <img alt="img" src="img/login.jpg">
        <div class="card">
            <h1> Register Here </h1>
            <form onsubmit="return validation()" action="" method="post">
                <div class="input-box">
                    <input type="text" id="name" name="name" placeholder="Full Name">
                    <i class="fa-solid fa-user"></i>
                </div>
                <div class="input-box">
                    <input type="text" id="email" name="email" placeholder="Email Address">
                    <i class="fa-solid fa-envelope"></i>
                </div>
                <div class="input-box">
                    <input type="number" id="contactno" name="contactno" placeholder="Contact Number">
                    <i class="fa-solid fa-phone"></i>
                </div>
                <div class="input-box">
                    <input type="password" id="pwd" name="pwd" placeholder="Password">
                    <i class="fa-solid fa-lock-open"></i>
                </div>
                <div class="input-box">
                    <input type="password" id="c_pwd" name="c_pwd" placeholder="Confirm password">
                    <i class="fa-solid fa-lock"></i>
                </div>
                <div class="dob">
                    <input type="date" class="dob" id="dob" name="dob" value="date" max="2025-04-15">
                </div>
                <button type="submit" class="btn" value="submit" name="signup"> Done </button>
                <div class="login-link">
                    <p> Already a user? <a href="login.php"> login </a> </p>
                </div>
            </form>
        </div> 
    </div>
</body>

<?php include('includes/footer.php'); ?>
