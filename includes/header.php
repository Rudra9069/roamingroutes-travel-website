<?php include('database/traveldb.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!--Bootsrap-->
    <!--Google fonts-->
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Inter:wght@400;600&family=Roboto&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
     <!--Favicon-->
    <link rel="icon" href="img/icon/Icon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!--Font Awesome-->
    <link rel="stylesheet" href="https://cdn.fontisto.com/latest/fontisto.css"> <!--Icons-->
    <title> Roaming Routes </title>
    <link rel="stylesheet">
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

        /* Navbar Base Styles */
        .custom-navbar {
            background-color: rgb(26, 35, 65);
            height: 55px;
            padding: 0 0.5rem;
            position: sticky;
            top: 0;
            z-index: 999;
        }


        /* Container */
        .custom-navbar .container {
            width: 100%;
            max-width: 1450px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Title */
        .custom-navbar .logo {
            position: relative;
            height: 50px;
            width: auto;
            margin: 0;
            padding: 0;
        }

        /* search-bar */
        .search-container {
            position: absolute;
            transform: translateX(-50%);
            z-index: 10;
            display: none;
            align-items: center;
            gap: 5px;
            margin-top: 0.2%;
            left: 85%;
        }

        .search-container input[type=text] {
            width: 300px;
            padding: 6px 12px;
            font-size: 16px;
            border: 1px solid rgb(0,0,0);
            border-radius: 8px;
            outline: none;
            font-family: 'Poppins';
        }

        .i-btn{
            position: absolute;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 18px;
            color: rgb(0, 0, 0);
            top: 5px;
            right: 15px;
        }

        .search-container input:hover {
            background-color: rgba(223, 223, 223, 0.7);
        }

        /* Nav Links */
        .nav-links {
            list-style: none;
            display: flex;
            gap: 1.5rem;
            margin: 0;
            padding: 0;
        }

        .nav-links li {
            list-style: none;
            display: flex;
            margin: 0;
            padding: 0;
        }

        /* Nav Items */
        .nav-links li a {
            position: relative;
            color:rgb(209, 173, 114);
            top: 4px;
            text-decoration: none;
            font-size: 16px;
            font-family: 'Montserrat';
            font-weight: 0;
            transition: color 0.5s;
            line-height: 1;
        }

        .slash{
            position: static;
            font-size: 18px;
            line-height: 1;
            color: white;
        }

        .nav-links li a:hover {
            color: rgb(197, 197, 197);
        }

        /* Nav btn */
        .nav-btn {
            display: flex;
            margin: 0;
            padding: 0;
        }

        .nav-btn .loginbtn {
            position: relative;
            top: 4px;
            height: 34px;
            width: 90px;
            margin-left: 5%;
            font-size: 13px;
            background-color: rgb(209, 173, 114);
            color: rgb(46, 46, 46);
            padding: 0 14px;
            border: 2px solid rgb(24, 24, 24);
            outline: none;
            border-radius: 5px;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
        }

        .loginbtn:hover {
            background-color:rgb(0, 0, 0);
            border: 2px solid rgb(209, 173, 114);
            color: rgb(225, 225, 225);
            transition: 0.5s;
        }

        /* search btn */
        .nav-btn .s-btn {
            position: relative;
            top: 4px;
            margin-left: 10%;
            height: 34px;
            width: 90px;
            font-size: 13px;
            background-color: rgb(255, 255, 255);
            color: rgb(0, 0, 0);
            padding: 0 14px;
            border: 2px solid rgb(17, 17, 17);
            outline: none;
            border-radius: 5px;
            font-weight: 600;
            text-transform: lowercase;
            font-family: 'Poppins', sans-serif;
        }

        .s-btn:hover{
            border: 2px solid rgb(255, 255, 255);
            background-color: rgb(33, 33, 33);
            color:rgb(209, 173, 114);
            transition: 0.4s;
        }

        /* Hamburger Menu */
        .hamburger {
            display: none;
            flex-direction: column;
            cursor: pointer;
            gap: 5px;
        }

        .hamburger span {
            height: 3px;
            width: 25px;
            background: #D2B68A;
            border-radius: 2px;
        }

        /* Last-section */
        .last-sec {
            width: 100%;
            height: 500px;
            background-color: rgba(16, 16, 16, 0.94);
            color: white;
            font-family: 'Poppins', sans-serif;
        }

        h3 {
            position: relative;
            top: 4%;
            margin-left: 2%;
            color: white;
        }

        .last-sec p {
            position: relative;
            top: 20px;
            margin-left: 2%;
            font-weight: 100;
        }

        .last-sec h4 {
            position: relative;
            top: 9%;
            margin-left: 30px;
        }

        .icons {
            position: relative;
            top: 50px;
            margin-left: 1%;
        }

        .icons i {
            font-size: 28px;
            margin-left: 1%;
            color: white;
            transition: 0.5s;
        }

        .icons a {
            text-decoration: none;
            border: none;
            outline: none;
        }

        .insta i:hover {
            background: linear-gradient(45deg, #feda75, #d62976, #962fbf, #4f5bd5);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .facebk i:hover {
            color: rgb(46, 89, 230);
        }

        .xt i:hover {
            color: gray;
        }

        .ytube i:hover {
            color: #FF0000;
        }

        .pint i:hover {
            color: #BD081C;
        }

        .subs h4 {
            position: relative;
            margin-top: 90px;
        }

        .subs input {
            position: relative;
            margin-left: 2%;
            margin-top: 1%;
            width: 300px;
            height: 40px;
            background-color: #fff;
            border: none;
            outline: none;
            border-radius: 40px;
            font-size: 17px;
            padding: 20px 15px 20px 20px;
        }

        .subs input::placeholder {
            color: black;
        }

        .subs .em-btn {
            position: relative;
            margin-top: 1%;
            margin-left: 16.2%;
            width: 70px;
            height: 30px;
            border-radius: 30px;
            border: none;
            outline: none;
        }

        .subs .em-btn i {
            font-size: 25px;
        }

        .subs input:hover {
            background-color: rgb(235, 235, 235);
        }

        .subs .em-btn:hover {
            color: rgba(0, 0, 0, 0.81);
            background-color: #D2B68A;
            box-shadow: 0px 0px 8px 0.3px #D2B68A;
        }

        .subs .sub-p {
            font-family: 'Poppins', sans-serif;
        }

        /* Features */
        .features {
            position: relative;
            margin-top: -25%;
            margin-left: 40%;
        }

        .features h5 {
            font-size: 30px;
        }

        .features .our-features {
            font-size: 18px;
        }

        .features .our-features a {
            display: block;
            text-decoration: none;
            color: whitesmoke;
            margin-bottom: 2%;

        }

        .features .our-features a:hover {
            color: rgb(205, 183, 148);
        }

        /* Top destinations */
        .top-destinations {
            position: relative;
            margin-top: -17.7%;
            margin-left: 60%;
        }

        .top-destinations h5 {
            font-size: 25px;
        }

        .top-destinations .top-dest {
            margin-top: 20px;
            font-size: 18px;
        }

        .top-destinations .top-dest a {
            display: block;
            text-decoration: none;
            color: whitesmoke;
            margin-bottom: 2%;
        }

        .top-destinations .top-dest a:hover {
            color: rgb(126, 182, 214);
        }

        /* Contact us */
        .contact-us {
            position: relative;
            margin-top: -26.4%;
            margin-left: 88%;
        }

        .contact-us h5 {
            font-size: 25px;
        }

        .contact-us .contact-icons {
            position: relative;
            margin-left: -60%;
            margin-top: 50%;
        }

        .contact-us .contact-icons i {
            font-size: 23px;
            margin-bottom: 25px;
        }

        .contact-us .contact-icons .cont-details {
            position: relative;
            margin-top: -24%;
            margin-left: 10%;
            color: rgb(220, 220, 220);
        }

        /* footer */
        .custom-footer {
            color: #222D52;
            height: 30px;
            background-color: rgb(209, 173, 114);
            text-align: center;
            font-size: 20px;
            font-family: 'Poppins', sans-serif;
        }

    @media (max-width: 992px) {
    .custom-navbar .container {
        flex-direction: column;
        align-items: flex-start;
    }

    .nav-links {
        flex-direction: column;
        gap: 0.75rem;
        margin-top: 10px;
    }

    .nav-btn {
        flex-direction: column;
        gap: 0.5rem;
        margin-top: 10px;
    }

    .search-container {
        position: static;
        transform: none;
        margin-left: 0;
        width: 100%;
        justify-content: center;
        margin-top: 1rem;
    }

    .search-container input[type="text"] {
        width: 90%;
    }

    .features, .top-destinations, .contact-us {
        margin: 2rem auto 0;
        text-align: center;
    }

    .features,
    .top-destinations,
    .contact-us {
        margin-top: 2rem;
        margin-left: 0;
    }

    .last-sec {
        height: auto;
        padding: 2rem 1rem;
    }

    .subs input {
        width: 100%;
    }

    .subs .em-btn {
        margin-left: 0;
        display: block;
        margin: 1rem auto;
    }

    .contact-us .contact-icons {
        margin-left: 0;
        margin-top: 1rem;
    }

    .contact-us .contact-icons .cont-details {
        margin-left: 1rem;
    }
}

@media (max-width: 576px) {
    .custom-navbar .title {
        font-size: 1.2rem;
    }

    .nav-links li a,
    .nav-btn .loginbtn,
    .nav-btn .s-btn {
        font-size: 14px;
    }

    .subs input {
        font-size: 14px;
    }

    .subs .em-btn i {
        font-size: 20px;
    }

    .features h5,
    .top-destinations h5,
    .contact-us h5 {
        font-size: 20px;
    }
}

    </style>
</head>

<body>
    <nav class="custom-navbar">
        <div class="container">

            <!-- Title -->
            <img class="logo" src="img/logo/rr_logo.png" alt="RR_logo"></img>

            <!-- nav bar -->
            <ul class="nav-links">
                <li><a href="index.php">HOME</a></li>
                <li><a href="destinations.php">DESTINATIONS</a></li>
                <li><a href="aboutus.php">ABOUT</a></li>
                <li><a href="contact.php">CONTACT US</a></li>
                <?php if (isset($_SESSION['u_id'])): ?>
                <li><a href="profile.php">PROFILE</a></li>
                <?php else: ?>
                <li><a href="login.php">LOGIN</a></li>
                <?php endif; ?>
            </ul>

            <!-- nav bar 2 -->
            <div class="nav-btn">
                <button type="button" class="s-btn" id="toggleSearch">Search</button>
            </div>


            <!-- hamburger menu -->
            <div class="hamburger" onclick="toggleMenu()">
                <span></span>
                <span></span>
                <span></span>
            </div>

        </div>
    </nav>


    <!-- JavaScripts -->
    <script>

        // Hamburger menu 
        function toggleMenu() {
            document.getElementById("navLinks").classList.toggle("show");
        }

        // Search-btn 
        document.getElementById("toggleSearch").addEventListener("click", function () 
        {
            const box = document.getElementById("searchContainer");
            if (box.style.display === "none") 
            {
                box.style.display = "block";
            } 
            else 
            {
                box.style.display = "none";
            }
        });

    </script>