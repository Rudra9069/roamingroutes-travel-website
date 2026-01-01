<!-- email_template.php -->
<?php
include('database/traveldb.php');

?>
<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Inter:wght@400;600&family=Roboto&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <title>Welcome to Roaming Routes</title>
    <style>
        *{
            margin: 0;
            padding: 0;
        }

        body{
            margin: 0;
            padding: 100px 400px 100px 400px;
            display: flex;
        }

        .em-card{
            height: 500px;
            width: 600px;
            background-color:rgb(26, 35, 65);
            color:rgb(209, 173, 114);
            font-family: 'poppins', sans-serif;
            border: 10px solid rgb(109, 119, 150);
            border-radius: 10px;
            padding: 50px 0px 0px 20px;
        }

        .em-card .em-h1{
            position: relative;
            top: 5%;
            color:rgb(209, 173, 114);
        }

        .em-card .em-p1{
            position: relative;
            top: 5%;
            font-size: 18px;
            color: white;
        }

        .em-card .verink{
            position: relative;
            top: 15%;
        }

        .em-card a{
            position: relative;
            top: 17%;
            text-decoration: none;
            font-size: 17px;
            background-color: white;
            color: black;
            padding: 2px 10px 2px 10px;
            border-radius: 10px;
            transition: 0.5s;
        }

        .em-card a:hover{
            background-color: rgba(0, 0, 0, 0.247);
            color: rgba(255, 255, 255, 0.678);
        }

        .em-card .thk{ 
            position: relative;
            top: 25%;
            font-size: 20px;
            font-weight: 800;
        }

        .em-card img{
            position: relative;
            margin-left: 70%;
            top: 34%;
            width: 180px;
        }

        .verink{
            position: relative;
            margin-top: 3%;
        }

    </style>
</head>
<body>
    <div class="em-card">
        <h2 class="em-h2"> Hello, {{name}} </h2>
        <h1 class="em-h1">Welcome to Roaming Routes!</h1>
        <p class="em-p1">
            Get ready to explore amazing destinations with Roaming Routes. <br>
            Your adventure begins now
        </p>
        <p class="verink">Please verify your email address to activate your account</p>
        <a href="{{verify_link}}"> Verify your account</a>
        <p class="thk">Thank you,<br>Roaming Routes</p>
        <img src="img/logo/rr_logo2.png" alt="rr_logo2">
    </div>
</body>
</html>
