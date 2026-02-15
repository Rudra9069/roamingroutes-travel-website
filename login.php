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
        position: absolute;
        top: 45%;
        left: 52%;
        transform: translate(-50%, -50%);
        background-color: rgba(0, 0, 0, 0.28);
        backdrop-filter: blur(2px);
        -webkit-backdrop-filter: blur(15px);
        width: 600px;
        height: 450px;
        border-radius: 50px;
        font-family: 'Poppins', sans-serif;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .card h1 {
        position: relative;
        top: 50px;
        font-size: 36px;
        color: white;
        text-align: center;
    }

    .card .input-box {
        position: relative;
        top: 80px;
        width: 100%;
        height: 25px;
        margin: 30px 100px;
    }

    .input-box input {
        width: 400px;
        height: 10px;
        background-color: #fff;
        border: none;
        outline: none;
        border-radius: 50px;
        font-size: 17px;
        padding: 20px 15px 20px 45px;
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

    .card .btn {
        position: relative;
        top: 100px;
        width: 100px;
        height: 45px;
        background-color: #fff;
        color: black;
        border: none;
        outline: none;
        border-radius: 50px;
        box-shadow: 0 0 10px rgba(0, 0, 0, .1);
        cursor: pointer;
        font-size: 16px;
        color: #333;
        font-weight: 600;
        margin: 10px 250px;
        transition: all 0.4s ease-in;
    }

    .card .btn:hover {
        background-color: rgb(43, 42, 42);
        color: #fff;
    }

    .card .register-link {
        position: relative;
        color: black;
        top: 44%;
        font-size: 19px;
        text-align: center;
    }

    .register-link p{
        position: relative; 
        margin-top: 5%;
        color: white;
    }
    .register-link p a {
        color: rgba(7, 201, 226, 1);
        text-decoration: none;
        font-weight: 600;
    }

    .register-link p a:hover {
        text-decoration: underline;
    }

    /* Responsiveness Media Queries */
    @media (max-width: 768px) {
        .auth-wrapper img { height: 100vh; object-fit: cover; }
        .card { width: 90%; max-width: 450px; left: 50%; height: auto; padding: 40px 20px; border-radius: 30px; }
        .card h1 { top: 0; font-size: 28px; margin-bottom: 30px; }
        .card .input-box { top: 0; margin: 20px 0; width: 100%; height: auto; }
        .input-box input { width: 100%; position: static; }
        .input-box i { left: 40px; }
        .card .btn { top: 10px; margin: 20px auto; display: block; }
        .card .register-link { top: 20px; position: static; margin-top: 20px; font-size: 16px; }
    }

    @media (max-width: 480px) {
        .card h1 { font-size: 24px; }
        .card { padding: 30px 15px; }
    }

</style>

<body>
    <div class="auth-wrapper">
        <img alt="img" src="img/login_2.jpg">
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