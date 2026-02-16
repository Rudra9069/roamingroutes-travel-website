<?php

session_start();
include('database/traveldb.php');

if(isset($_POST['login']))
{
    $email = $_POST['email'];
    $pwd = $_POST['pwd'];

    $sql = "SELECT * FROM users WHERE email = '$email' LIMIT 1"; 
    $result = mysqli_query($conn , $sql);

    if($result && mysqli_num_rows($result) === 1)
    {
        $user = mysqli_fetch_assoc($result); 
        
        if($user['is_verified'] != 1)
        {
            echo "<script>alert('Please verify your email first');</script>";
            exit;
        }
        
        if(password_verify($pwd, $user['pwd']))
        {
            $_SESSION['u_id']  = $user['u_id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['name']  = $user['name']; 

            header("Location: index.php");
            exit;
        }
        else
        {
            echo "<script>alert('Incorrect password');</script>";
        }
    }
    else
    {
        echo "<script> alert('Incorrect Email or Password or Account has not been verified.'); </script>";
    }
    
}

?>

<script>
    function validation()
    {
        var a = document.getElementById("email").value;
        var b = document.getElementById("pwd").value;
        var checkem = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if(a=="")
        {
            alert("Enter your email address");
            return false;
        }
        else if(!checkem.test(a))
        {
            alert("Enter a valid email address");
            return false;
        }
        else if(b=="")
        {
            alert("Please enter your password");
            return false;
        }
        else if (a=="" ||b=="")
        {
            alert("Please fill all the informations");
            return false;
        }
        else
        {
            return true;
        }
        }
</script>

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

    .auth-wrapper img {
        display: flex;
        margin: auto;
        width: 100%;
    }

    .auth-wrapper {
        position: relative;
        min-height: 100vh;
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
    }

    .card h1 {
        font-size: 32px;
        color: white;
        text-align: center;
        margin-bottom: 35px;
        font-weight: 600;
        background: linear-gradient(90deg, #fff, #aaa);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .card .input-box {
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
    }

    .input-box i {
        color: #333;
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 18px;
    }

    .card .btn {
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
        margin-top: 20px;
        transition: all 0.3s ease;
    }

    .card .btn:hover {
        background-color: #000;
        color: #fff;
        transform: translateY(-2px);
    }

    .card .register-link {
        margin-top: 30px;
        text-align: center;
        color: white;
        font-size: 15px;
    }

    .register-link p a {
        color: #0bd9f5;
        text-decoration: none;
        font-weight: 700;
    }

    .register-link p a:hover {
        text-decoration: underline;
    }

    /* Background Setup */
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

    /* Responsiveness Media Queries */
    @media (max-width: 768px) {
        .card { 
            width: 100%; 
            max-width: 420px; 
            padding: 40px 25px; 
            border-radius: 20px;
            margin: 80px 15px 40px;
        }
        .card h1 { font-size: 28px; margin-bottom: 25px; }
    }

    @media (max-width: 480px) {
        .auth-wrapper { padding: 10px; }
        .card { padding: 30px 20px; }
        .card h1 { font-size: 24px; }
        .btn { padding: 12px; }
    }

</style>

<body>
    <div class="auth-wrapper">
        <img class="bg-img" alt="img" src="img/login_2.jpg">
        <div class="card">
            <h1> Login | Sign-In </h1>
            <form onsubmit="return validation()" action="login.php"  method="post">
                <div class="input-box">
                    <input type="text" id="email" name="email" placeholder="Email Address">
                    <i class="fa-solid fa-envelope"></i>
                </div>
                <div class="input-box">
                    <input type="password" id="pwd" name="pwd" placeholder="Password">
                    <i class="fa-solid fa-lock-open"></i>
                </div>
                <button type="submit" class="btn" value="submit" name="login"> Login </button>
                <div class="register-link">
                    <p> Don't have an account? <a href="register.php"> Register here </a> </p>
                </div>
            </form>
        </div>
    </div>
</body>

<?php include('includes/footer.php'); ?>