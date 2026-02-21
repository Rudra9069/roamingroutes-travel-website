<?php
session_start(); 

include('database/traveldb.php');

$userLoggedIn = isset($_SESSION['u_id']);

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

if (!empty($search)) 
{
    $query = "SELECT * FROM destinations 
            WHERE is_deleted = '0' 
            AND (name LIKE '%$search%' OR city LIKE '%$search%' OR state LIKE '%$search%' or country LIKE '%$search%')";
} 
else 
{
    $query = "select * from destinations where is_deleted = '0'";
}

$result = mysqli_query($conn, $query);

?>

<?php include('includes/header.php'); ?>
<style>
    /* Section1 */
    .sec1 {
        position: relative;
        width: 100%;
        max-width: 100%;
        overflow: hidden;
        text-align: center;
    }

    .dest-img {
        width: 100%;
        height: 631px;
        display: flex;
        filter: blur(0px);
    }

    .overlay-text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: rgb(255, 255, 255);
        font-family: 'Great Vibes', cursive;
        font-size: 65px;
        letter-spacing: 3px;
        z-index: 1;
        text-shadow: 0 0 10px rgba(0, 0, 0, 0.7);
        white-space: nowrap;
        animation: slideUp 1.4s ease-out forwards;
        width: 100%;
        text-align: center;
    }

    @keyframes slideUp {
        0% {
            opacity: 0;
            transform: translate(-50%, 50%);
        }
        100% {
            opacity: 1;
            transform: translate(-50%, -50%);
        }
    }


    /* Destination Heading */
    .dest-heading {
        position: relative;
        margin-top: 3.5%;
        text-align: center;
        color: black;
        font-family: 'Cinzel', serif;
        font-size: 45px;
        padding: 0 15px;
    }

    /* section2 */
    .sec2 {
        margin-bottom: 3%;
    }

    .main-places {
        position: relative;
        margin-top: 60px;
        display: flex;
        flex-wrap: wrap;
        gap: 30px;
        justify-content: center;
        padding: 15px;
        font-family: 'Popins', sans-serif;  
    }

    .cards {
        width: 100%;
        max-width: 420px;
        min-height: 420px;
        border: none;
        outline: none;
        overflow: hidden;
        border-radius: 20px;
        background-color: rgba(252, 252, 252, 1);
        color: black;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.33);
        cursor: pointer;
        /* Scroll animation - GPU accelerated for smooth performance */
        opacity: 0;
        transform: translate3d(0, 60px, 0);
        transition: opacity 0.5s ease-out, transform 0.5s ease-out, background-color 0.3s;
        will-change: opacity, transform;
        backface-visibility: hidden;
        display: flex;
        flex-direction: column;
    }

    .cards.visible {
        opacity: 1;
        transform: translate3d(0, 0, 0);
    }

    .cards:hover {
        transform: translate3d(0, -5px, 0);
        box-shadow: 0px 0px 20px 5px rgba(0, 0, 0, 0.28);
    }

    .cards img {
        width: 100%;
        height: 250px;
        object-fit: cover;
    }

    .cards h5 {
        position: relative;
        top: 10px;
        margin-left: 3%;
        font-weight: 0;
    }

    /* Dest-Reviews */
    .reviews {
        margin-left: 3%;
        margin-top: 15px;
        font-size: 10px;
    }

    .reviews i {
        margin-right: 2px;
    }   

    /* Description */
    .description {
        position: relative;
        margin-left: 3%;
        color: rgba(85, 85, 85, 0.84);
        font-family: 'Montserrat', serif;
        font-size: 14px;
        margin-top: -3%;
    }

    /* Dest-View Details */
    .vd-a {
        text-decoration: none;
        color: black;
        transition: all 0.3s ease-in;
    }

    .vd-a:hover {
        color: white;
    }
    .view-details {
        position: relative;
        background-color: rgba(255, 255, 255, 1);
        padding: 5px 8px;
        border-radius: 40px;
        border: 1px solid rgba(0, 0, 0, 0.91);    
        color: black;
        font-size: 15px;
        margin-left: 3%;
        margin-top: -5%;
        transition: all 0.3s ease-in;
    }

    .view-details:hover {
        background-color: rgba(30, 30, 30, 0.95);
        color:white;
    }   

    /* Dest-Price */
    .price {
        position: relative;
        background-color: rgba(0, 138, 9, 1);
        color:white;
        padding: 8px 15px;
        border-radius: 40px;
        border: 1px solid;    
        font-size: 15px;
        margin-left: auto;
        margin-right: 15px;
        margin-top: auto;
        margin-bottom: 20px;
        transition: all 0.3s ease-in;
        width: fit-content;
    }

    .view-details {
        position: relative;
        background-color: rgba(255, 255, 255, 1);
        padding: 8px 15px;
        border-radius: 40px;
        border: 1px solid rgba(0, 0, 0, 0.91);    
        color: black;
        font-size: 15px;
        margin-left: 15px;
        margin-top: auto;
        margin-bottom: 20px;
        transition: all 0.3s ease-in;
        width: fit-content;
    }

    .card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: auto;
        padding-bottom: 10px;
    }

    .price:hover {
        background-color: rgba(46, 182, 55, 1);
        color: rgb(255, 255, 255);
    }

    .cards:hover {
        position: relative;
        background-color: rgba(255, 255, 255, 0.95);
        box-shadow: 0px 0px 20px 5px rgba(0, 0, 0, 0.28);
    }

    /* search result null */
    .no-results {
        color: black;
        font-size: 20px;
        font-weight: 500;
    }

    /* Responsiveness Media Queries */
    @media (max-width: 992px) {
        .overlay-text { font-size: 42px; left: 50%; transform: translate(-50%, -50%); top: 50%; width: 90%; white-space: normal; }
        .dest-heading { font-size: 35px; }
        .price { margin-left: auto; }
        @keyframes slideUp {
            0% { opacity: 0; transform: translate(-50%, 50%); }
            100% { opacity: 1; transform: translate(-50%, -50%); }
        }
    }

    @media (max-width: 768px) {
        .dest-img { height: 400px; }
        .overlay-text { font-size: 30px; }
        .dest-heading { font-size: 28px; margin-top: 40px; }
        .cards { width: 95%; max-width: 400px; height: auto; min-height: auto; padding-bottom: 20px; margin: 0 auto; }
        .main-places { padding: 10px; gap: 20px; }
        .price { margin-right: 15px; font-size: 14px; }
        .view-details { margin-left: 15px; font-size: 14px; }
    }

    @media (max-width: 480px) {
        .dest-img { height: 300px; }
        .overlay-text { font-size: 24px; }
        .dest-heading { font-size: 22px; }
        .price, .view-details { padding: 6px 12px; font-size: 13px; }
    }
</style>

<body>
    
    <!-- Section1 -->
    <section class="sec1">
        <img class="dest-img" src="img/dest-img_3.jpg" alt="dest-img" loading="lazy" decoding="async">
        <div class="overlay-text"> Explore places on Roaming Routes </div>
    </section>

    <!-- Destination Heading -->
    <section>
        <p class="dest-heading"> Pick your destination </p>
    <section>
    <!-- Section2 -->
    <section class="sec2">
        <div class="main-places">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                        $images = explode(',', $row['images']);
                        $firstImage = trim($images[0]); 
                ?>

                        <div class="cards">
                            <img src="img/destinations/<?php echo $firstImage; ?>" alt="<?php echo $row['name']; ?>" loading="lazy" decoding="async">
                            <h5> <?php echo $row['name']; ?> </h5>
                            <!-- Reviews -->
                            <p class="reviews"> 
                                <?php 
                                    $rating = (int)$row['ratings'];
                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($i <= $rating) {
                                            echo '<i class="fa-solid fa-star" style="color: #ffd500ff;"></i>';
                                        } else {
                                            echo '<i class="fa-regular fa-star" style="color: #ffd500ff;"></i>';
                                        }
                                    }
                                ?>
                            </p>  
                            <!-- Description -->
                            <p class="description"> <?php echo $row['description']; ?> </p>

                            <div class="card-footer">
                                <!-- View Details -->
                                <button class="view-details">                    
                                    <a class="vd-a" href="destination-details.php?id=<?php echo $row['id']; ?>" target="_blank"> View more </a>
                                </button>
                                <!-- Price -->
                                <button class="price"> Price: <?php echo "₹" . $row['price_range']; ?> </button>
                            </div>
                        </div>
                    <?php
                } ?>
            <?php else: ?>
                <p class="no-results"> No destinations found for your search.</p>
            <?php endif; ?>
        </div>
    </section>

<script>
    // Scroll-triggered animation for cards
    const cards = document.querySelectorAll('.cards');
    
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.15  // Trigger when 15% of card is visible
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // Card is coming into view - animate in
                entry.target.classList.add('visible');
            } else {
                // Card is going out of view - animate out
                entry.target.classList.remove('visible');
            }
        });
    }, observerOptions);

    // Observe all cards
    cards.forEach(card => {
        observer.observe(card);
    });
</script>

</body>
<?php include('includes/footer.php'); ?>