<?php session_start();
include('database/traveldb.php');
$search =isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

if ( !empty($search)) {
    $query ="SELECT * FROM destinations 
 WHERE (name LIKE '%$search%' OR city LIKE '%$search%' OR state LIKE '%$search%')";

}

else {
    $query ="SELECT * FROM destinations WHERE reviews = 'top'";
}

$result =mysqli_query($conn, $query);

?>
<?php include('includes/header.php'); ?>


<style> 

    :root {
        --anim-delay: 2.2s;
        /* Default delay */
    }

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
        width: 100%;
        padding: 0 20px;
    }

    .welcome-user {
        position: absolute;
        top: 15%;
        left: 5%;
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
        animation: typing 3.5s steps(1000, end) var(--anim-delay) forwards;
    }

    .plane-icon {
        width: fit-content;
        white-space: nowrap;
        overflow: hidden;
        position: absolute;
        top: 46.5%;
        animation: fly 1.5s steps(1000, end) var(--anim-delay) forwards;
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

    @keyframes fly-mobile {
        from {
            left: 35%;
        }

        to {
            left: 75%;
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
        margin: 0 auto;
        display: block;
        width: fit-content;
        height: 35px;
        border: 1px solid rgba(37, 37, 37, 0.22);
        border-radius: 20px;
        outline: none;
        background-color: white;
        padding: 0px 20px 0px 50px;
        box-shadow: 0px 0px 5px 0px rgb(255, 255, 255);
        transition: 0.4s;
    }

    @media (min-width: 992px) {
        .dest-btn {
            margin-left: 80%;
            top: -20px;
        }
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
        width: 100%;
        max-width: 460px;
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

    /* Responsiveness Media Queries */
    @media (max-width: 1200px) {

        .h1-vid,
        .h1_2-vid {
            font-size: 55px;
        }
    }

    @media (max-width: 992px) {
        .overlay-text {
            font-size: 38px;
            width: 100%;
            padding: 0 20px;
        }

        .sec2-h2 {
            font-size: 38px;
            text-align: center;
            margin-left: 0;
            top: 20px;
        }

        .dest-btn {
            top: 40px;
            margin-bottom: 60px;
        }

        .typing-effect {
            font-size: 36px;
        }

        .main-img {
            height: 500px;
        }

        .sec4 {
            height: auto;
            padding: 60px 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .sec4-h2 {
            font-size: 42px;
            text-align: center;
            top: 0;
            margin: 0;
        }

        .sec4-p {
            text-align: center;
            margin-left: 0;
            top: 10px;
            margin-bottom: 40px;
        }

        .gallery {
            top: 0;
            width: 100%;
        }

        .h1-vid,
        .h1_2-vid {
            font-size: 45px;
            letter-spacing: 5px;
            text-align: center;
            width: 100%;
            margin-left: 0;
        }

        .h1_2-vid {
            top: 45%;
        }
    }

    @media (max-width: 768px) {
        .overlay-text {
            font-size: 30px;
        }

        .welcome-user {
            top: auto;
            bottom: 15%;
            font-size: 16px;
            width: 100%;
            text-align: center;
            left: 0;
        }

        .typing-effect {
            font-size: 26px;
        }

        .card {
            max-width: 380px;
            height: 240px;
            margin: 0 auto;
        }

        .h1-vid,
        .h1_2-vid {
            font-size: 32px;
            position: relative;
            top: 0;
            margin: 15px 0;
            display: block;
            letter-spacing: 4px;
        }

        .overlay-video {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .sec5-video {
            height: 400px;
            object-fit: cover;
        }
    }

    @media (max-width: 480px) {
        .overlay-text {
            font-size: 22px;
        }

        .sec4-h2 {
            font-size: 28px;
        }

        .sec4-p {
            font-size: 16px;
            margin-bottom: 20px;
        }

        .gallery-item {
            width: 150px !important;
            height: 200px !important;
        }

        .typing-effect {
            font-size: 20px;
            animation-duration: 2s;
            animation-delay: var(--anim-delay);
        }

        .plane-icon {
            font-size: 20px;
            top: 48.5%;
            animation-name: fly-mobile;
            animation-duration: 2s;
            animation-delay: var(--anim-delay);
        }
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
        width: 90%;
        max-width: 800px;
        height: auto;
        max-height: 90vh;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    /* Title */
    .popup-title {
        font-family: 'Poppins', sans-serif;
        text-align: center;
        margin-bottom: 20px;
        width: 100%;
    }

    /* Image inside popup */
    .popup-image {
        width: 100%;
        max-height: 400px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    /* Close button */
    .popup-close {
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 25px;
        cursor: pointer;
        z-index: 10;
    }

    /* Popup-city */
    .popup-city {
        font-family: 'Poppins', sans-serif;
        margin-bottom: 20px;
        text-align: center;
    }

    /* Popup buttons container */
    .popup-btn-container {
        display: flex;
        gap: 15px;
        justify-content: center;
        width: 100%;
        flex-wrap: wrap;
    }

    /* Pop-up btn */
    .popup-d-btn,
    .popup-p-btn {
        text-decoration: none;
        height: 40px;
        width: 200px;
        outline: none;
        border: none;
        border-radius: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: 0.3s;
    }

    .popup-d-btn {
        background-color: rgb(26, 84, 143);
    }

    .popup-p-btn {
        background-color: rgb(205, 166, 104);
    }

    .popup-d-btn a,
    .popup-p-btn a {
        text-decoration: none;
        font-family: 'Poppins', sans-serif;
        text-transform: lowercase;
        font-size: 14px;
        width: 100%;
        text-align: center;
    }

    .popup-d-btn a {
        color: rgb(244, 244, 244);
    }

    .popup-p-btn a {
        color: rgb(35, 35, 35);
    }

    .popup-d-btn:hover {
        background-color: rgb(11, 78, 145);
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
    }

    .popup-p-btn:hover {
        background-color: rgb(203, 145, 52);
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
    }

    /* Guest Popup */
    .popup-content-guest {
        position: relative;
        background-color: #00203FFF;
        color: white;
        padding: 30px;
        border-radius: 10px;
        width: 90%;
        max-width: 600px;
        height: auto;
        max-height: 90vh;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .popup-title-guest {
        font-family: 'Poppins', sans-serif;
        font-size: 22px;
        margin-top: 20px;
        margin-bottom: 15px;
    }

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

    .p-imp {
        text-decoration: underline;
        font-family: 'Poppins', sans-serif;
        margin-bottom: 25px;
        font-size: 14px;
    }

    .guest-btn-container {
        display: flex;
        gap: 15px;
        justify-content: center;
        margin-bottom: 25px;
    }

    .popup-l-btn,
    .popup-r-btn {
        height: 40px;
        width: 120px;
        border-radius: 5px;
        text-align: center;
        font-family: 'Poppins', sans-serif;
        font-size: 16px;
        font-weight: 500;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }

    .popup-l-btn {
        background-color: rgb(205, 166, 104);
        color: black;
    }

    .popup-r-btn {
        background-color: black;
        color: white;
        border: 1px solid white;
    }

    .thankyou-text {
        font-size: 20px;
        font-family: 'Poppins', sans-serif;
        font-weight: 500;
        margin-bottom: 20px;
    }

    .popup-g-logo {
        height: 40px;
        width: auto;
    }

    /* Mobile specific popup adjustments */
    @media (max-width: 768px) {

        .popup-content,
        .popup-content-guest {
            padding: 20px;
        }

        .popup-title {
            font-size: 20px;
        }

        .popup-image {
            max-height: 250px;
        }

        .popup-title-guest {
            font-size: 18px;
        }

        .popup-d-btn,
        .popup-p-btn {
            width: 100%;
        }

        .popup-btn-container {
            flex-direction: column;
            gap: 10px;
        }

        .guest-btn-container {
            flex-direction: column;
            gap: 10px;
            align-items: center;
        }

        .popup-l-btn,
        .popup-r-btn {
            width: 150px;
        }

        .thankyou-text {
            font-size: 16px;
        }
    }

</style>

<style>
/* Gallery Smooth Scroll Animation */
.gallery {
    overflow: hidden !important;
    white-space: nowrap !important;
    background: #cbcbcbff !important;
    position: relative !important;
    padding: 0 !important;
    height: auto !important; /* Ensure it wraps the items */
}

.gallery-track {
    display: flex !important;
    width: max-content !important;
    animation: galleryScroll 40s linear infinite !important;
}

@keyframes galleryScroll {
    0% {
        transform: translateX(-50%);
    }
    100% {
        transform: translateX(0);
    }
}

.gallery-item {
    flex-shrink: 0 !important;
    width: 250px !important;
    height: 350px !important;
    margin-right: 0 !important;
    position: relative !important;
    top: 0 !important; /* Reset position */
}

@media (max-width: 768px) {
    .gallery-item {
        width: 200px !important;
        height: 280px !important;
    }
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

/* Responsive Splash Logo */
@media (max-width: 768px) {
    .splash-logo-1 {
        width: 250px;
    }

    .splash-logo-2 {
        width: 200px;
    }
}

</style>

<script>
    (function() {
        var splash=document.getElementById('splash-screen');
        var referrer=document.referrer;
        var currentHost=window.location.host;
        var currentPath=window.location.pathname;

        // Detect if this is a page refresh
        var isReload=false;

        if (window.performance && window.performance.navigation) {
            isReload=window.performance.navigation.type===1;
        }

        else if (window.performance && performance.getEntriesByType) {
            var navEntries=performance.getEntriesByType('navigation');

            if (navEntries.length > 0) {
                isReload=navEntries[0].type==='reload';
            }
        }

        // Get the project base path (e.g., /4_Travel/ or /)
        var projectBase=currentPath.substring(0, currentPath.lastIndexOf('/') + 1);

        // Detailed internal navigation check
        // isInternal: Coming from another page within the same project directory
        var isInternal=referrer && referrer.indexOf(currentHost) !==-1 && referrer.indexOf(projectBase) !==-1;

        // First visit from outside, or direct access, or refresh - show splash
        if ( !isInternal || isReload) {
            document.documentElement.style.setProperty('--anim-delay', '1.8s');

            setTimeout(function() {
                    if (splash) {
                        splash.classList.add('splash-hidden');
                    }
                }

                , 3000);
        }

        else {
            // Internal navigation - hide splash immediately and start animation fast
            document.documentElement.style.setProperty('--anim-delay', '0.2s');

            if (splash) {
                splash.classList.add('splash-hidden');
            }
        }
    })();
</script>

<!-- Section-1 -->
<section class="sec1">
    <img class="main-img" src="img/main-bg_2.jpg" alt="bg-img" decoding="async">
    <?php if ( !empty($_SESSION['name'])): ?>
        <div class="welcome-user">Welcome, <?=htmlspecialchars($_SESSION['name']) ?></div><?php endif; ?>
        <div class="overlay-text typing-effect">Explore the World ! </div>
        <div class="typing-wrapper"><i class="fas fa-plane plane-icon"></i>
        </div>
</section>
        
<!-- Section-2 -->
<section class="sec2">
    <h3 class="sec2-h2">Our Top <br>Destinations : </h3>
    <button class="dest-btn"><a href="destinations.php">< view all destinations </a></button>
</section>

<!-- Section-3 -->
<section class="sec3 fadeInUp">
    <div class="main-places"><?php if (mysqli_num_rows($result) > 0): ?>
    <?php while ($row =mysqli_fetch_assoc($result)) {
    $allImages =explode(',', $row['images']);
    $firstImage =trim($allImages[0]); ?>
    
    <div class="card" onclick="showPopup('<?php echo $firstImage; ?>', 
    '<?php echo $row['name']; ?>',
    '<?php echo $row['city']; ?>',
    '<?php echo $row['price_range']; ?>')">
 <p class="overlay-places"><?php echo $row['state']; ?></p>
 <img src="img/destinations/<?php echo $firstImage; ?>"
    alt="<?php echo htmlspecialchars($row['name']); ?>"
    loading="lazy" decoding="async"></div><?php
}

?>
<?php else: ?>
<p style="color: black; font-size: 20px; font-weight: 500;">No destinations found for your search.</p><?php endif;?>
</div>
</section>
<!-- Section 4 -->

<section class="sec4">
    <h2 class="sec4-h2">#roamingroutes </h2>
    <p class="sec4-p">Follow Roaming Routes: 
        <i class="fa-brands fa-instagram"></i>
        <i class="fa-brands fa-square-facebook"></i>
        <i class="fa-brands fa-x-twitter"></i></p>
    <!-- Gallery imgs -->
     <div class="gallery">
        <div class="gallery-track">
            <!-- First set of images -->
            <div class="gallery-item">
                <img src="img/mountain.jpg" alt="Mountain" loading="lazy" decoding="async">
                <div class="overlay"></div>
                <div class="caption">mountains</div>
            </div>

            <div class="gallery-item">
                <img src="img/lake.jpg" alt="Lake" loading="lazy" decoding="async">
                <div class="overlay"></div>
                <div class="caption">lake</div>
            </div>

            <div class="gallery-item">
                <img src="img/street.jpg" alt="Street" loading="lazy" decoding="async">
                <div class="overlay"></div>
                <div class="caption">streets</div>
            </div>
            
            <div class="gallery-item">
                <img src="img/citynight.jpg" alt="City Night" loading="lazy" decoding="async">
                <div class="overlay"></div>
                <div class="caption">citynights</div>
            </div>
            
            <div class="gallery-item">
                <img src="img/coast.jpg" alt="Coast" loading="lazy" decoding="async">
                <div class="overlay"></div>
                <div class="caption">coast</div>
            </div>
            
            <div class="gallery-item">
                <img src="img/oldtown.jpg" alt="Old Town" loading="lazy" decoding="async">
                <div class="overlay"></div>
                <div class="caption">old-town</div>
            </div>

            <!-- Duplicated set for seamless looping -->
            <div class="gallery-item">
                <img src="img/mountain.jpg" alt="Mountain" loading="lazy" decoding="async">
                <div class="overlay"></div>
                <div class="caption">mountains</div>
            </div>

            <div class="gallery-item">
                <img src="img/lake.jpg" alt="Lake" loading="lazy" decoding="async">
                <div class="overlay"></div>
                <div class="caption">lake</div>
            </div>

            <div class="gallery-item">
                <img src="img/street.jpg" alt="Street" loading="lazy" decoding="async">
                <div class="overlay"></div>
                <div class="caption">streets</div>
            </div>
            
            <div class="gallery-item">
                <img src="img/citynight.jpg" alt="City Night" loading="lazy" decoding="async">
                <div class="overlay"></div>
                <div class="caption">citynights</div>
            </div>
            
            <div class="gallery-item">
                <img src="img/coast.jpg" alt="Coast" loading="lazy" decoding="async">
                <div class="overlay"></div>
                <div class="caption">coast</div>
            </div>
            
            <div class="gallery-item">
                <img src="img/oldtown.jpg" alt="Old Town" loading="lazy" decoding="async">
                <div class="overlay"></div>
                <div class="caption">old-town</div>
            </div>
        </div>
    </div>
</section>

<!-- Section 5 -->
<section class="sec5">
    <div class="video-wrapper">
        <video autoplay muted loop class="sec5-video" preload="metadata">
            <source src="img/video.mp4" type="video/mp4"></video>
        <div class="overlay-video">
            <h1 class="h1-vid">your journey </h1>
            <h1 class="h1_2-vid">begins here </h1>
        </div>
    </div>
</section>

<!-- POP-UP box -->
<div id="popup" class="popup-overlay" onclick="closePopup()">
    <div class="popup-content" onclick="event.stopPropagation()">
        <span class="popup-close" onclick="closePopup()"><i class="fa-solid fa-xmark"></i></span>
        <h2 id="popupName" class="popup-title"></h2>
        <img id="popupImage" class="popup-image">
        <p class="popup-city"><strong>City: </strong><span id="popupCity"></span></p>
        <div class="popup-btn-container">
            <button class="popup-d-btn"><a href="destinations.php">View more details </a></button>
            <button class="popup-p-btn"><a href="payment.php" id="popupPriceBtn">Starting from ₹0 </a></button>
        </div>
    </div>
</div>

<!-- POP-UP for non-registered users -->
<div id="popup-guest" class="popup-overlay" onclick="closePopup()">
    <div class="popup-content-guest" onclick="event.stopPropagation()">
        <span class="popup-close-guest" onclick="closePopup()"><i class="fa-solid fa-xmark"></i></span>
        <h2 class="popup-title-guest">Please log in or create an account <br>to view destination details or payment procedure.</h2>
        <p class="p-imp">You must have an account to access this feature.</p>
        <div class="guest-btn-container">
            <a href="login.php" class="popup-l-btn">Login</a>
            <a href="register.php" class="popup-r-btn">Register</a>
        </div>
        <p class="thankyou-text">Thankyou, Roaming Routes :) </p>
        <img class="popup-g-logo" alt="popup-logo" src="img/logo/rr_logo_2.png"></img>
    </div>
</div>
</div>
<?php $u_id =isset($_SESSION['u_id']);?>


<!-- script for pop-up -->
 
<script>
    function showPopup(images, name, city, price_range) {
    document.getElementById("popupImage").src="img/destinations/"+images;
    document.getElementById("popupName").innerText=name;
    document.getElementById("popupCity").innerText=city;
    document.getElementById("popupPriceBtn").innerText="Starting from ₹"+price_range;
    document.getElementById("popup").style.display="flex";

    const non_registered=<?php echo $u_id ? 'false': 'true';
    ?>;

    document.querySelector(".popup-d-btn a").addEventListener("click", function (event) {
            event.preventDefault();

            if (non_registered) {
                showGuestPopup();
            }

            else {
                window.location.href="destinations.php";
            }
        });

    document.querySelector(".popup-p-btn a").addEventListener("click", function (event) {
            event.preventDefault();

            if (non_registered) {
                showGuestPopup();
            }

            else {
                window.location.href="payment.php";
            }
        });
}


function showGuestPopup() {
    document.getElementById("popup-guest").style.display="flex";
}

function closePopup() {
    document.getElementById("popup").style.display="none";
    document.getElementById("popup-guest").style.display="none";
}

</script>
<?php include('includes/footer.php'); ?>