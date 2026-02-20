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

            /* Glassmorphism Navbar - Global Style */
            .custom-navbar {
                position: absolute;
                background-color: transparent;
                box-shadow: none;
                height: 55px;
                padding: 0 0.5rem;
                top: 0;
                left: 0;
                right: 0;
                z-index: 1000;
                transition: background-color 0.3s ease;
            }

            .custom-navbar.scrolled {
                background-color: rgb(0,0,0);
                backdrop-filter: none;
            }

            #navLinks.nav-links {
                display: flex;
                align-items: center;
                background: rgba(183, 183, 183, 0.08);
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(5px);
                border: 1px solid rgba(255, 255, 255, 0.2);
                padding: 6px 18px;
                border-radius: 50px;
                box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3);
                gap: 0.6rem;
                position: fixed;
                left: 50%;
                transform: translateX(-50%);
                top: 15px;
                margin: 0;
                list-style: none;
                transition: all 0.3s ease;
            }

            #navLinks.nav-links li {
                margin: 0;
                list-style: none;
            }

            #navLinks.nav-links li a {
                display: flex;
                align-items: center;
                justify-content: center;
                color: rgba(255, 255, 255, 0.82);
                text-decoration: none;
                font-size: 14px;
                font-family: 'Montserrat', sans-serif;
                font-weight: 500;
                padding: 5px 12px;
                border-radius: 25px;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                text-transform: uppercase;
                letter-spacing: 1px;
            }

            #navLinks.nav-links li a:hover {
                background-color: transparent !important;
                color: #fff;
                transform: translateY(-1px);
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            }

            /* Nav btn */
            .nav-btn {
                display: flex;
                margin: 0;
                padding: 0;
            }

            /* Mobile Glassmorphism Overrides */
            @media (max-width: 992px) {
                #navLinks.nav-links {
                    position: fixed;
                    top: 60px;
                    right: -100%;
                    height: auto;
                    max-height: calc(100vh - 80px);
                    width: 55%;
                    max-width: 300px;
                    background: rgba(62, 62, 62, 0.57);
                    backdrop-filter: blur(15px);
                    flex-direction: column;
                    align-items: flex-start;
                    padding: 20px 15px;
                    border-radius: 20px;
                    transform: none;
                    left: auto;
                    overflow-y: auto;
                    gap: 0.3rem;
                }
                
                #navLinks.nav-links.show {
                    right: 15px;
                }
                
                #navLinks.nav-links li {
                    width: 100%;
                }
                
                #navLinks.nav-links li a {
                    width: 100%;
                    padding: 10px 5px;
                    border-radius: 12px;
                    font-size: 13px;
                    display: flex;
                    align-items: center; 
                    justify-content: flex-start; 
                }

                #navLinks.nav-links li a:hover {
                    background: rgba(255, 255, 255, 0.1);
                }
            }
            .custom-navbar .container {
                width: 100%;
                max-width: 1450px;
                margin: 0 auto;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .custom-navbar .logo {
                position: relative;
                height: 55px;
                width: auto;
                z-index: 1001;
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
            .hamburger-v2 {
                display: none;
                flex-direction: column;
                cursor: pointer;
                gap: 5px;
            }

            .hamburger-v2 span {
                height: 3px;
                width: 25px;
                background-color: #ffffff !important;
                border-radius: 2px;
            }

            /* Last-section */
            .last-sec {
                width: 100%;
                background-color: rgba(16, 16, 16, 0.94);
                color: white;
                font-family: 'Poppins', sans-serif;
                padding: 60px 40px;
                display: grid;
                grid-template-columns: 1.5fr 1fr 1fr 1.2fr;
                gap: 50px;
            }

            .footer-col {
                display: flex;
                flex-direction: column;
            }

            .last-sec h3 {
                color: white;
                margin-bottom: 15px;
                font-size: 28px;
            }

            .last-sec p {
                font-weight: 300;
                margin-bottom: 25px;
                color: rgba(255,255,255,0.7);
            }

            .last-sec h4 {
                margin-bottom: 20px;
                font-size: 18px;
                letter-spacing: 1px;
            }

            .icons {
                display: flex;
                gap: 15px;
                margin-top: 20px;
            }

            .icons i {
                font-size: 24px;
                color: white;
                transition: 0.3s;
            }

            .icons a {
                color: inherit;
                text-decoration: none;
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

            .subs {
                margin-top: 30px;
            }

            .subs form {
                display: flex;
                align-items: center;
                flex-wrap: wrap;
                gap: 15px;
                margin: 20px 0;
            }

            .subs input {
                flex: 1;
                min-width: 200px;
                max-width: 300px;
                height: 45px;
                background-color: #f8f8f8;
                border: 1px solid rgba(255,255,255,0.1);
                outline: none;
                border-radius: 50px;
                font-size: 16px;
                padding: 0 25px;
                transition: 0.3s;
                color: #333;
            }

            .subs .em-btn {
                width: 45px;
                height: 45px;
                border-radius: 50%;
                border: none;
                background: white;
                color: #333;
                cursor: pointer;
                transition: 0.3s;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .subs .em-btn i {
                font-size: 18px;
            }

            .subs input:hover {
                background-color: #f0f0f0;
            }

            .subs .em-btn:hover {
                color: white;
                background-color: #d2983b;
            }

            .subs .sub-p {
                font-size: 14px;
                color: rgba(255,255,255,0.6);
                line-height: 1.5;
            }

            /* Features */
            .features h5 {
                font-size: 22px;
                margin-bottom: 25px;
                color: white;
            }

            .features .our-features a {
                display: block;
                text-decoration: none;
                color: rgba(255,255,255,0.7);
                margin-bottom: 12px;
                transition: color 0.3s;
            }

            .features .our-features a:hover {
                color: #d2983b;
            }

            /* Top destinations */
            .top-destinations h5 {
                font-size: 22px;
                margin-bottom: 25px;
                color: white;
            }

            .top-destinations .top-dest a {
                display: block;
                text-decoration: none;
                color: rgba(255,255,255,0.7);
                margin-bottom: 10px;
                transition: color 0.3s;
            }

            .top-destinations .top-dest a:hover {
                color: #7eb6d6;
            }

            /* Contact us */
            .contact-us h5 {
                font-size: 22px;
                margin-bottom: 25px;
                color: white;
            }

            .contact-us .contact-icons {
                display: flex;
                flex-direction: column;
                gap: 20px;
            }

            .contact-item {
                display: flex;
                align-items: flex-start;
                gap: 15px;
            }

            .contact-item i {
                font-size: 18px;
                margin-top: 4px;
                width: 20px;
                text-align: center;
            }

            .contact-us .contact-icons .cont-details {
                color: rgba(255,255,255,0.7);
                font-size: 14px;
                line-height: 1.6;
                margin: 0;
                word-break: break-word;
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

        .hamburger-v2 {
            display: flex;
            z-index: 1001;
        }

        .last-sec {
            grid-template-columns: repeat(2, 1fr);
            padding: 50px 30px;
        }

        .features, .top-destinations, .contact-us {
            margin: 0;
            text-align: left;
        }

        .subs input {
            max-width: 100%;
        }
    }

    @media (max-width: 576px) {
        .last-sec {
            grid-template-columns: 1fr;
            gap: 40px;
            text-align: center;
            padding: 40px 15px;
        }

        .features, .top-destinations, .contact-us {
            text-align: center;
        }

        .contact-us .contact-icons {
            align-items: flex-start;
            display: inline-flex;
            flex-direction: column;
            text-align: left;
            max-width: 100%;
            margin: 0 auto;
        }

        .contact-item {
            justify-content: flex-start;
            width: 100%;
            margin-bottom: 15px;
        }

        .subs form {
            justify-content: center;
            flex-direction: column;
            align-items: center;
        }

        .subs input {
            font-size: 18px;
            width: 100%;
            max-width: 300px;
            height: 70px;
            margin-bottom: 20px;
            padding: 5px 30px;
        }

        .subs .em-btn {
            width: 70px;
            height: 30px;
            border-radius: 20px;
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


        /* Mobile Fixes for iPhone 15 and similar small screens */
        @media (max-width: 768px) {
            .last-sec {
                display: flex !important;
                flex-direction: column !important;
                align-items: center !important;
                text-align: center !important;
                padding: 40px 15px !important;
                width: 100% !important;
                gap: 40px !important;
                overflow-x: hidden !important;
            }

            .footer-col {
                display: flex !important;
                flex-direction: column !important;
                align-items: center !important;
                text-align: center !important;
                width: 100% !important;
                margin-bottom: 0 !important;
            }

            /* Centering specific containers that were missed */
            .icons, .subs form, .guest-btn-container {
                justify-content: center !important;
                width: 100% !important;
            }

            .subs {
                margin-top: 40px !important; /* Move subscribe section further downwards */
            }

            .sub-p {
                max-width: 280px !important; /* Forces text to span two lines */
                margin: 5px auto !important;
                line-height: 1.4 !important;
            }

            .footer-col h5, .footer-col h3, .footer-col h4 {
                width: 100% !important;
                text-align: center !important;
                margin-left: 0 !important;
            }

            .brand-col p {
                margin-top: -10px !important; /* Move the slogan upwards */
                margin-bottom: 10px !important;
            }

            .brand-col h4 {
                margin-top: 25px !important; /* Move 'FOLLOW US' and icons downwards */
                margin-bottom: 5px !important;
            }

            .brand-col .icons {
                margin-top: 10px !important; /* Move icons downwards */
            }

            .contact-icons {
                display: block !important;
                width: 100% !important;
                padding-left: 10% !important; /* Move away from edge */
                margin: 0 !important;
            }

            .contact-item {
                display: -webkit-box !important;
                display: -ms-flexbox !important;
                display: flex !important;
                flex-direction: row !important;
                -webkit-box-orient: horizontal !important;
                -webkit-box-direction: normal !important;
                -ms-flex-direction: row !important;
                flex-wrap: nowrap !important;
                justify-content: flex-start !important;
                align-items: flex-start !important; /* Align icon with first line */
                width: 100% !important;
                gap: 15px !important;
                margin-bottom: 20px !important;
            }

            .contact-item i {
                width: 24px !important;
                font-size: 18px !important;
                text-align: center !important;
                flex-shrink: 0 !important;
                margin-top: 4px !important; /* Perfect vertical alignment with text */
            }

            .cont-details {
                display: block !important; /* Ensure it stays on its own "cell" */
                margin: 0 !important;
                padding: 0 !important;
                text-align: left !important;
                font-size: 14px !important;
                line-height: 1.5 !important;
                color: white !important;
                word-break: break-word !important;
            }

            /* Footer text size fix */
            .custom-footer {
                height: auto !important;
                padding: 15px 0 !important;
            }
            .custom-footer p {
                font-size: 14px !important;
                line-height: 1.4 !important;
            }

            /* Aggressive hiding for mobile footer sections to ensure it works on physical devices */
            .last-sec .features, 
            .last-sec .top-destinations,
            .footer-col.features, 
            .footer-col.top-destinations {
                display: none !important;
                visibility: hidden !important;
                opacity: 0 !important;
                height: 0 !important;
                margin: 0 !important;
                padding: 0 !important;
                pointer-events: none !important;
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
                <div class="hamburger-v2" onclick="toggleMenu()">
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