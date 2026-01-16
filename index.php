<?php

session_start();
include('database/traveldb.php');
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
if (!empty($search)) 
    {
    $query = "SELECT * FROM destinations 
            WHERE (name LIKE '%$search%' OR city LIKE '%$search%' OR state LIKE '%$search%')";
} 
else 
    {
    $query = "SELECT * FROM destinations WHERE reviews = 'top'";
}

$result = mysqli_query($conn, $query); 

?>

<?php include('includes/header.php'); ?>

<style>
    body {
        padding: 0;
        margin: 0;
        background-color: rgb(255, 255, 255);
    }

    /* Section1 */
    .sec1 {
        position: relative;
        width: 100%;
        max-width: 100%;
        overflow: hidden;
        text-align: center;
    }

    .main-img {
        width: 100%;
        height: 650px;
        display: flex;
        filter: blur(0.7px);
    }

    .overlay-text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: white;
        font-size: 58px;
        font-weight: bold;
        z-index: 1;
        text-shadow: 0px 0px 14px rgba(234, 247, 255, 0.28);
        font-family: 'Poppins', sans-serif;
    }

    .welcome-user {
        position: absolute;
        top: 15%;
        left: 1%;
        transform: none;
        color: #ffffffe4;
        font-family: 'Poppins';
        font-size: 22px;
        z-index: 2;
    }

    .typing-effect {
        width: fit-content;
        white-space: nowrap;
        overflow: hidden;
        font-family: 'Poppins';
        font-size: 55px;
        width: 0%;
        animation: typing 3.5s steps(1000, end) 2.2s forwards;
    }

    .plane-icon {
        width: fit-content;
        white-space: nowrap;
        overflow: hidden;
        position: absolute;
        top: 46.5%;
        animation: fly 1.5s steps(1000, end) 1.8s forwards;
        color: rgba(255, 255, 255, 0.9);
        font-size: 40px;
    }

    /* Typing animation: steps() simulates typing each letter */
    @keyframes typing {
        from {
            width: 0%;
        }

        to {
            width: 100%;
        }
    }

    @keyframes fly {
        from {
            left: 43%;
        }

        to {
            left: 67%;
        }
    }


    /* Section2 */
    .sec2 {
        background-color: rgb(255, 255, 255);
        margin-top: -2px;
    }

    .sec2-h2 {
        position: relative;
        top: 50px;
        margin-left: 3%;
        color: black;
        font-size: 50px;
        font-family: 'Montserrat';
        font-weight: 0;
        line-height: 1.1;
    }

    .dest-btn {
        position: relative;
        margin-left: 80%;
        top: -20px;
        height: 35px;
        border: 1px solid rgba(37, 37, 37, 0.22);
        border-radius: 20px;
        outline: none;
        background-color: white;
        padding: 0px 20px 0px 50px;
        box-shadow: 0px 0px 5px 0px rgb(255, 255, 255);
        transition: 0.4s;
    }

    .dest-btn a {
        text-decoration: none;
        font-family: 'Poppins', sans-serif;
        color: black;
    }

    .dest-btn:hover {
        background-color: rgba(222, 222, 222, 0.33);
        box-shadow: 0px 0px 5px 0px rgba(169, 169, 169, 0.28);
    }

    /* Secttion 3 */
    .sec3 {
        margin-top: 3%;
        margin-bottom: 3%;
        background-color: rgb(255, 255, 255);
    }

    .fadeInUp {
        animation: fadeInUp 0.9s ease-out forwards;
        animation-timeline: view();
        animation-range: entry 0% cover 50%;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
            scale: 0.8;
        }

        to {
            opacity: 1;
            transform: translateY(0px);
            scale: 1;
        }
    }

    .main-places {
        display: flex;
        flex-wrap: wrap;
        gap: 30px;
        justify-content: center;
        padding: 20px;
    }

    .card {
        position: relative;
        width: 460px;
        height: 300px;
        background-color: #f2f2f2;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        cursor: pointer;
    }

    .overlay-places {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: rgba(241, 237, 237, 0.87);
        font-size: 45px;
        font-weight: bold;
        z-index: 2;
        font-family: 'Poppins', sans-serif;
        opacity: 0;
        text-shadow: 0 0 10px rgba(0, 0, 0, 0.7);
        transition: opacity 0.3s ease;
    }

    .card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: filter 0.3s ease;
    }

    .card::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.14);
        color: white;
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: 1;
    }

    .card:hover img {
        filter: blur(1px);
    }

    .card:hover::after {
        opacity: 1;
    }

    .card:hover .overlay-places {
        opacity: 1;
    }

    /* Section4 */
    .sec4 {
        background-color: rgb(50, 76, 205);
        padding: 0;
        margin: 0;
        width: 100%;
        height: 600px;
    }

    .sec4-h2 {
        position: relative;
        top: 15%;
        margin-left: 2%;
        color: white;
        font-family: 'Poppins';
        font-size: 55px;
        font-weight: 600;
    }

    .sec4-p {
        position: relative;
        top: 4%;
        margin-left: 70%;
        color: white;
        font-family: 'Poppins';
        font-size: 22px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    .gallery {
        position: relative;
        top: 14%;
        display: flex;
        overflow-x: auto;
        background: #000;
    }

    .gallery-item {
        position: relative;
        max-width: 253px;
        width: 100%;
        height: 315px;
        flex-shrink: 0;
    }

    .gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.43);
        transition: 0.7s;
    }

    .gallery-item:hover .overlay {
        background-color: rgba(0, 0, 0, 0);
        cursor: pointer;
    }

    .caption {
        position: absolute;
        bottom: 10px;
        left: 10px;
        color: white;
        font-family: 'Montserrat';
        font-weight: 500;
        padding: 5px 10px;
        z-index: 2;
    }

    /* Seciton5 */
    .video-wrapper {
        position: relative;
        width: 100%;
        max-height: 700px;
        overflow: hidden;
    }

    .sec5-video {
        position: relative;
        width: 100%;
        border: none;
    }

    .sec5 .overlay-video {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.33);
        /* Adjust opacity for darkness */
        z-index: 1;
    }

    .h1-vid {
        position: absolute;
        top: 30%;
        margin-left: 27%;
        color: white;
        font-size: 70px;
        font-family: 'Great Vibes', cursive;
        letter-spacing: 10px;
    }

    .h1_2-vid {
        position: absolute;
        top: 50%;
        margin-left: 55%;
        color: white;
        font-size: 70px;
        font-family: 'Great Vibes', cursive;
        letter-spacing: 10px;
    }
</style>

<!-- Popup css -->
<style>
    /* Popup overlay background */
    .popup-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    /* Popup content box */
    .popup-content {
        position: relative;
        background: white;
        padding: 25px;
        border-radius: 10px;
        width: 100%;
        max-width: 1000px;
        height: 100%;
        max-height: 95%;
    }

    /* Title */
    .popup-title {
        position: relative;
        font-family: 'Poppins', sans-serif;
        text-align: center;
    }

    /* Image inside popup */
    .popup-image {
        position: relative;
        margin: 5% auto 0 auto;
        width: 80%;
        height: 70%;
        display: block;
        object-fit: cover;
        border-radius: 8px;
    }

    /* Close button */
    .popup-close {
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 25px;
        cursor: pointer;
    }

    /* Popup-city */
    .popup-city {
        position: relative;
        margin-top: 2%;
        margin-left: 10%;
        font-family: 'Poppins', sans-serif;
    }

    /* Pop-up btn */
    .popup-d-btn {
        position: relative;
        left: 25%;
        margin-left: 1%;
        text-decoration: none;
        height: 40px;
        width: 200px;
        outline: none;
        border: none;
        border-radius: 5px;
        background-color: rgb(26, 84, 143);
    }

    .popup-d-btn a {
        position: relative;
        text-decoration: none;
        color: rgb(244, 244, 244);
        font-family: 'Poppins', sans-serif;
        text-transform: lowercase;
    }

    .popup-d-btn:hover {
        background-color: rgb(11, 78, 145);
        box-shadow: 0px 0px 5px 0px rgb(0, 0, 0);
    }

    .popup-p-btn {
        position: relative;
        left: 25%;
        margin-left: 1%;
        text-decoration: none;
        height: 40px;
        width: 200px;
        outline: none;
        border: none;
        border-radius: 5px;
        background-color: rgb(205, 166, 104);
    }

    .popup-p-btn a {
        position: relative;
        text-decoration: none;
        color: rgb(35, 35, 35);
        text-transform: lowercase;
        font-family: 'Poppins', sans-serif;
    }

    .popup-p-btn:hover {
        background-color: rgb(203, 145, 52);
        box-shadow: 0px 0px 5px 0px rgb(0, 0, 0);
    }

    /* Popup Guest */
    .popup-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    /* Popup content guest */
    .popup-content-guest {
        position: relative;
        background-color: #00203FFF;
        color: white;
        padding: 25px;
        border-radius: 10px;
        width: 100%;
        max-width: 1000px;
        height: 100%;
        max-height: 95%;
    }

    /* Title */
    .popup-title-guest {
        position: relative;
        text-align: center;
        margin-top: 10%;
        font-size: 25px;
    }

    /* Close Button */
    .popup-close-guest {
        position: absolute;
        color: rgb(207, 160, 85);
        top: 10px;
        right: 15px;
        font-size: 25px;
        cursor: pointer;
    }

    .popup-close-guest:hover {
        color: rgb(211, 210, 210);
    }

    /* Text */
    .popup-title-guest {
        font-family: 'Poppins', sans-serif;
    }

    .popup-content-guest .p-imp {
        text-align: center;
        margin-top: 20px;
        text-decoration: underline;
        font-family: 'Poppins', sans-serif;
    }

    /* Buttons */
    .popup-l-btn,
    .popup-r-btn {
        position: relative;
        left: 32%;
        margin-top: 5%;
        margin-left: 1%;
        text-decoration: none;
        height: 40px;
        width: 150px;
        outline: none;
        border: none;
        border-radius: 5px;
        text-align: center;
        display: inline-block;
        font-family: 'Poppins', sans-serif;
        font-size: 18px;
        font-weight: 500;
    }

    /* Login Button */
    .popup-l-btn {
        background-color: rgb(205, 166, 104);
        color: black;
        padding: 6px 0px;
    }

    /* Register Button */
    .popup-r-btn {
        background-color: black;
        color: white;
        padding: 6px 0px;
    }

    /* Thank You Text */
    .popup-content-guest .thankyou-text {
        text-align: center;
        margin-top: 5%;
        font-size: 30px;
        font-family: 'Poppins', sans-serif;
        font-weight: 500;
    }

    /* Logo */
    .popup-g-logo {
        position: relative;
        height: 55px;
        margin-left: 85%;
        margin-top: 15%;
    }
</style>
<body>

    <!-- Splash Screen -->
    <div id="splash-screen" class="splash-screen">
        <div class="splash-logo-container">
            <img src="img/logo/ss_2.png" alt="Roaming Routes" class="splash-logo-2">
            <img src="img/logo/ss_1.png" alt="Roaming Routes" class="splash-logo-1">
        </div>
    </div>

    <style>
        /* Splash Screen Styles */
        .splash-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #0a0a0a 0%, #1a1a2e 50%, #0a0a0a 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            animation: splashFadeOut 0.5s ease-out 1.7s forwards;
        }

        .splash-logo-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
        }

        /* First logo part - blur to clear */
        .splash-logo-1 {
            width: 400px;
            height: auto;
            animation: logoBlurToClear 0.8s ease-out forwards;
        }

        /* Second logo part - slide up from below */
        .splash-logo-2 {
            width: 300px;
            height: auto;
            opacity: 0;
            animation: logoSlideUp 0.5s ease-out 0.8s forwards;
        }

        @keyframes logoBlurToClear {
            0% {
                opacity: 0;
                transform: scale(0.3);
                filter: blur(20px);
            }
            100% {
                opacity: 1;
                transform: scale(1);
                filter: blur(0px);
            }
        }

        @keyframes logoSlideUp {
            0% {
                opacity: 0;
                transform: translateY(50px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes splashFadeOut {
            0% {
                opacity: 1;
                visibility: visible;
            }
            100% {
                opacity: 0;
                visibility: hidden;
            }
        }

        .splash-hidden {
            display: none !important;
        }
    </style>

    <script>
        (function() {
            var splash = document.getElementById('splash-screen');
            var referrer = document.referrer;
            var currentHost = window.location.host;
            var currentPath = window.location.pathname;
            
            // Detect if this is a page refresh
            var isReload = false;
            if (window.performance && window.performance.navigation) {
                isReload = window.performance.navigation.type === 1;
            } else if (window.performance && performance.getEntriesByType) {
                var navEntries = performance.getEntriesByType('navigation');
                if (navEntries.length > 0) {
                    isReload = navEntries[0].type === 'reload';
                }
            }
            
            // Check if coming from a DIFFERENT page on the same site
            var isFromOtherPage = referrer && 
                                  referrer.indexOf(currentHost) !== -1 && 
                                  referrer.indexOf(currentPath) === -1;
            
            // Show splash on: first visit, direct URL access, or refresh
            // Hide splash on: navigation from other pages on the site
            if (isFromOtherPage && !isReload) {
                // Coming from another page on the site - hide splash immediately
                if (splash) {
                    splash.classList.add('splash-hidden');
                }
            } else {
                // First visit, direct access, or refresh - show splash animation
                setTimeout(function() {
                    if (splash) {
                        splash.classList.add('splash-hidden');
                    }
                }, 3000);
            }
        })();
    </script>

    <!-- Section-1 -->
    <section class="sec1">
        <img class="main-img" src="img/main-bg_2.jpg" alt="bg-img">
        <?php if (!empty($_SESSION['name'])): ?>
            <div class="welcome-user"> Welcome, <?= htmlspecialchars($_SESSION['name']) ?> </div>

        <?php endif; ?>
        <div class="overlay-text typing-effect"> Explore the World! </div>
        <div class="typing-wrapper"> <i class="fas fa-plane plane-icon"></i> </div>
    </section>

    <!-- Section-2 -->
    <section class="sec2">
        <h3 class="sec2-h2"> Our Top <br>Destinations : </h3>
        <button class="dest-btn">
            <a href="destinations.php">
                < view all destinations </a>
        </button>
    </section>

    <!-- Section-3 -->
    <section class="sec3 fadeInUp">
        <div class="main-places">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php

                while ($row = mysqli_fetch_assoc($result)) {
                    $allImages = explode(',', $row['images']);
                    $firstImage = trim($allImages[0]);

                    ?>
                    <div class="card" onclick="showPopup('<?php echo $firstImage; ?>', 
                                                     '<?php echo $row['name']; ?>',
                                                     '<?php echo $row['city']; ?>', 
                                                     '<?php echo $row['price_range']; ?>')">
                        <p class="overlay-places"> <?php echo $row['state']; ?> </p>
                        <img src="img/destinations/<?php echo $firstImage; ?>"
                            alt="<?php echo htmlspecialchars($row['name']); ?>">
                    </div>
                    <?php

                }

                ?>
            <?php else: ?>
                <p style="color: black; font-size: 20px; font-weight: 500;">No destinations found for your search.</p>
            <?php endif; ?>
        </div>
    </section> 

    <!-- Section 4 -->
    <section class="sec4">

        <h2 class="sec4-h2"> #roamingroutes </h2>
        <p class="sec4-p">
            Follow Roaming Routes:
            <i class="fa-brands fa-instagram"></i>
            <i class="fa-brands fa-square-facebook"></i>
            <i class="fa-brands fa-x-twitter"></i>
        </p>

        <!-- Gallery imgs -->
        <div class="gallery">

            <div class="gallery-item">
                <img src="img/mountain.jpg" alt="Mountain">
                <div class="overlay"></div>
                <div class="caption">mountains</div>
            </div>

            <div class="gallery-item">
                <img src="img/lake.jpg" alt="Lake">
                <div class="overlay"></div>
                <div class="caption">lake</div>
            </div>

            <div class="gallery-item">
                <img src="img/street.jpg" alt="Street">
                <div class="overlay"></div>
                <div class="caption">streets</div>
            </div>

            <div class="gallery-item">
                <img src="img/citynight.jpg" alt="City Night">
                <div class="overlay"></div>
                <div class="caption">citynights</div>
            </div>

            <div class="gallery-item">
                <img src="img/coast.jpg" alt="Coast">
                <div class="overlay"></div>
                <div class="caption">coast</div>
            </div>

            <div class="gallery-item">
                <img src="img/oldtown.jpg" alt="Old Town">
                <div class="overlay"></div>
                <div class="caption">old-town</div>
            </div>

        </div>
    </section>

    <!-- Section 5 -->
    <section class="sec5">

        <div class="video-wrapper">
            <video autoplay muted loop class="sec5-video">
                <source src="img/video.mp4" type="video/mp4">
            </video>
            <div class="overlay-video">
                <h1 class="h1-vid"> your journey </h1>
                <h1 class="h1_2-vid"> begins here </h1>
            </div>
        </div>

    </section>

    <!-- POP-UP box -->
    <div id="popup" class="popup-overlay" onclick="closePopup()">
        <div class="popup-content" onclick="event.stopPropagation()">
            <span class="popup-close" onclick="closePopup()"><i class="fa-solid fa-xmark"></i></span>
            <h2 id="popupName" class="popup-title"> </h2>
            <img id="popupImage" class="popup-image">
            <p class="popup-city"> <strong> City: </strong> <span id="popupCity"> </span> </p>
            <button class="popup-d-btn"> <a href="destinations.php"> View more details </a> </button>
            <button class="popup-p-btn"> <a href="payment.php" id="popupPriceBtn"> Starting from ₹0 </a> </button>


            <!-- POP-UP for non-registered users -->
            <div id="popup-guest" class="popup-overlay" onclick="closePopup()">
                <div class="popup-content-guest" onclick="event.stopPropagation()">
                    <span class="popup-close-guest" onclick="closePopup()"><i class="fa-solid fa-xmark"></i></span>
                    <h2 class="popup-title-guest">Please log in or create an account <br> to view destination
                        details or
                        payment procedure.</h2>
                    <p class="p-imp">You must have an account to access this feature.</p>
                    <div>
                        <a href="login.php" class="popup-l-btn">Login</a>
                        <a href="register.php" class="popup-r-btn">Register</a>
                    </div>
                    <p class="thankyou-text">Thankyou, Roaming Routes :) </p>
                    <img class="popup-g-logo" alt="popup-logo" src="img/logo/rr_logo.png"></img>
                </div>
            </div>
        </div>
    </div>

    <?php $u_id = isset($_SESSION['u_id']); ?>

    <!-- script for pop-up -->
    <script>
        function showPopup(images, name, city, price_range) {
            document.getElementById("popupImage").src = "img/destinations/" + images;
            document.getElementById("popupName").innerText = name;
            document.getElementById("popupCity").innerText = city;
            document.getElementById("popupPriceBtn").innerText = "Starting from ₹" + price_range;
            document.getElementById("popup").style.display = "flex";

            const non_registered = <?php echo $u_id ? 'false' : 'true'; ?>;

            document.querySelector(".popup-d-btn a").addEventListener("click", function (event) {
                event.preventDefault();
                if (non_registered) {
                    showGuestPopup();
                }
                else {
                    window.location.href = "destinations.php";
                }
            });

            document.querySelector(".popup-p-btn a").addEventListener("click", function (event) {
                event.preventDefault();
                if (non_registered) {
                    showGuestPopup();
                }
                else {
                    window.location.href = "payment.php";
                }
            });
        }


        function showGuestPopup() {
            document.getElementById("popup-guest").style.display = "flex";
        }

        function closePopup() {
            document.getElementById("popup").style.display = "none";
            document.getElementById("popup-guest").style.display = "none";
        }
    </script>

</body>
<?php include('includes/footer.php'); ?>