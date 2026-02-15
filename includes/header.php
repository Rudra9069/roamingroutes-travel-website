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
                background-color: transparent;
                height: 55px;
                padding: 0 0.5rem;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                z-index: 999;
                transition: background-color 0.3s ease;
            }

            /* Navbar scrolled state */
            .custom-navbar.scrolled {
                background-color: rgb(26, 35, 65);
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
                height: 55px;
                width: auto;
                margin: 0;
                padding: 0;
            }

            /* Nav Links */
            .nav-links {
                position: absolute;
                left: 50%;
                transform: translateX(-50%);
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
                color: rgba(255, 255, 255, 0.72);
                text-decoration: none;
                font-size: 16px;
                font-family: 'Montserrat';
                font-weight: 0;
                transition: color 0.5s;
                line-height: 1;
            }

            .nav-links li a:hover {
                color: rgba(255, 255, 255, 1);
            }

            /* Nav btn */
            .nav-btn {
                display: flex;
                margin: 0;
                padding: 0;
            }

            /* search-bar */
            .search-container {
                position: relative;
                left: 10%;
                display: flex;
                align-items: center;
                background: transparent;
                border-radius: 50px;
            }

            .search-container input[type=text] {
                width: 300px;
                height: 40px;
                padding: 5px 12px;
                background-color: rgba(253, 253, 253, 0);
                font-size: 15.2px;
                border-radius: 50px;
                border: 1px solid rgba(255, 255, 255, 0.42);
                outline: none;
                font-family: 'Montserrat';
            }


            .search-container input[type=text]::placeholder {
                color:  rgba(255, 255, 255, 1);
                font-size: 15px;
            }

            .search-container form {
                position: relative;
                display: flex;
                align-items: center;
            }

            .i-btn{
                position: absolute;
                background: none;
                border: none;
                cursor: pointer;
                font-size: 20px;
                color: rgba(255, 255, 255, 0.83);
                top: 50%;
                transform: translateY(-50%);
                right: 15px;
            }

            .search-container input:hover {
                background-color: rgba(223, 223, 223, 0.16);
                color:  rgba(0,0,0,1);
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
                background-color:rgba(16, 16, 16, 0.94);
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
                margin-left: 2%;
                width: 70px;
                height: 30px;
                border-radius: 30px;
                border: none;
                outline: none;
                transition: 0.4s all ease-in;
            }

            .subs .em-btn i {
                font-size: 25px;
                margin-top: 3px;
            }

            .subs input:hover {
                background-color: rgb(235, 235, 235);
            }

            .subs .em-btn:hover {
                color: rgba(255, 255, 255, 1);
                background-color: #d2983bff;
                
            }

            .subs .sub-p {
                font-family: 'Poppins', sans-serif;
            }

            /* Features */
            .features {
                position: relative;
                margin-top: -27.7%;
                margin-left: 40%;
            }

            .features h5 {
                font-size: 30px;
            }

            .features .our-features {
                font-size: 18px;
                position: relative; 
                margin-top: 3%;
            }

            .features .our-features a {
                position: relative;
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
                margin-top: -18.9%;
                margin-left: 58%;
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
                margin-top: -26.8%;
                margin-left: 86%;
            }

            .contact-us h5 {
                font-size: 25px;
                margin-left: 20%;
            }

            .contact-us .contact-icons {
                position: relative;
                margin-left: -35%;
                margin-top: 40%;
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
                color: rgb(16,16,16,0.94);
                height: 35px;
                background-color: rgb(26, 35, 65);
                color: rgba(255, 255, 255, 0.72);
                text-align: center;
                font-size: 22px;
                font-family: 'Montserrat', sans-serif;
            }

        @media (max-width: 992px) {
        .custom-navbar .container {
            flex-direction: row; /* Keep logo and hamburger on same row */
            justify-content: space-between;
            padding: 0 1rem;
        }

        .nav-links {
            position: fixed;
            top: 55px;
            right: -100%;
            height: calc(100vh - 55px);
            width: 70%;
            max-width: 300px;
            background: rgb(26, 35, 65);
            flex-direction: column;
            justify-content: flex-start;
            align-items: flex-start;
            padding: 40px 20px;
            gap: 1.5rem;
            transition: 0.4s ease-in-out;
            box-shadow: -5px 0 15px rgba(0,0,0,0.5);
            z-index: 1000;
            transform: none; /* Override desktop centering */
            left: auto;
        }

        .nav-links.show {
            right: 0;
        }

        .nav-links li a {
            font-size: 18px;
            color: white;
        }

        .nav-btn {
            display: none; /* Hide search in main navbar row on mobile */
        }

        .hamburger {
            display: flex;
            z-index: 1001;
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
            max-width: 300px;
        }

        .subs .em-btn {
            margin-left: 0;
            display: inline-block;
            margin-top: 10px;
        }

        .contact-us .contact-icons {
            margin-left: 0;
            margin-top: 1rem;
        }

        .contact-us .contact-icons .cont-details {
            margin-left: 10px;
            display: inline;
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
                <img class="logo" src="img/logo/rr_logo_white.png" alt="RR_logo"></img>

                <!-- nav bar -->
                <ul class="nav-links" id="navLinks">
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

                <!-- search bar -->
                <div class="nav-btn">
                    <div class="search-container">
                        <form action="destinations.php" method="get">
                            <input type="text" placeholder="Search for destinations" name="search">
                            <button class="i-btn" type="submit"><i class="fa fa-search"></i></button>
                        </form>
                    </div>
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
                const navLinks = document.getElementById("navLinks");
                if (navLinks) {
                    navLinks.classList.toggle("show");
                }
            }



            // Navbar scroll effect - change background on scroll
            window.addEventListener('scroll', function() {
                const navbar = document.querySelector('.custom-navbar');
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            });

        </script>