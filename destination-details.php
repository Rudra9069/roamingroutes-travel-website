<?php
session_start();
include('database/traveldb.php');

// Get the destination ID from the URL like ?id=3
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch details for the specific destination
$query = "SELECT * FROM destinations WHERE id = $id AND is_deleted = '0'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    echo "<script>alert('Destination not found!'); window.location.href='destinations.php';</script>";
    exit();
}

$imageString = $row['images'];
$images = explode(',', $imageString);
$firstImage = trim($images[0]);
?>

<?php include('includes/header.php'); ?>

<style>
    :root {
        --primary-color: #1a548f;
        --secondary-color: #00203f;
        --accent-color: #d2b68a;
        --text-dark: #2c3e50;
        --text-light: #5f6769;
        --bg-light: #f4f7f9;
        --white: #ffffff;
        --shadow-sm: 0 4px 6px rgba(0, 0, 0, 0.05);
        --shadow-md: 0 10px 30px rgba(0, 0, 0, 0.08);
        --radius: 15px;
        --navbar-height: 55px;
    }

    body {
        background-color: var(--bg-light);
        font-family: 'Poppins', sans-serif;
        color: var(--text-dark);
        line-height: 1.6;
        margin: 0;
        padding: 0;
    }

    /* Hero Section */
    .hero-section {
        position: relative;
        height: 55vh;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        margin-top: 0;
    }

    .hero-img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        filter: brightness(0.6);
    }

    .hero-content {
        position: relative;
        z-index: 2;
        text-align: center;
        color: var(--white);
        max-width: 900px;
        padding: 0 20px;
    }

    .hero-content h1 {
        font-size: clamp(2.5rem, 6vw, 4.5rem);
        font-weight: 800;
        letter-spacing: -1px;
        margin-bottom: 12px;
        text-transform: capitalize;
        text-shadow: 0 4px 15px rgba(0,0,0,0.3);
    }

    .hero-content p {
        font-size: clamp(1rem, 2vw, 1.4rem);
        font-family: 'Montserrat', sans-serif;
        font-weight: 400;
        opacity: 0.95;
        text-shadow: 0 2px 8px rgba(0,0,0,0.3);
    }

    .breadcrumb-custom {
        position: absolute;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 2;
        color: rgba(255, 255, 255, 0.9);
        font-size: 0.85rem;
        background: rgba(0, 0, 0, 0.4);
        padding: 10px 25px;
        border-radius: 50px;
        backdrop-filter: blur(8px);
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .breadcrumb-custom a {
        color: var(--accent-color);
        text-decoration: none;
        transition: 0.3s;
    }
    .breadcrumb-custom a:hover { color: var(--white); }

    /* Main Content Layout */
    .details-wrapper {
        max-width: 1400px;
        margin: -80px auto 80px auto;
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: 40px;
        padding: 0 40px;
        position: relative;
        z-index: 20;
    }

    /* Left Column */
    .main-content {
        background: var(--white);
        padding: 50px;
        border-radius: var(--radius);
        box-shadow: var(--shadow-md);
    }

    .image-gallery {
        margin-bottom: 50px;
    }

    .main-slider {
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        aspect-ratio: 16 / 9;
        margin-bottom: 20px;
        background: #f0f0f0;
        box-shadow: var(--shadow-sm);
    }

    .main-slider img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: opacity 0.4s ease;
    }

    .slider-nav {
        display: flex;
        gap: 15px;
        overflow-x: auto;
        padding: 5px 0 15px 0;
        scrollbar-width: thin;
    }

    .slider-nav::-webkit-scrollbar { height: 6px; }
    .slider-nav::-webkit-scrollbar-thumb { background: #ddd; border-radius: 10px; }

    .slider-nav img {
        width: 120px;
        height: 80px;
        object-fit: cover;
        border-radius: 10px;
        cursor: pointer;
        opacity: 0.6;
        transition: 0.3s ease;
        border: 3px solid transparent;
        flex-shrink: 0;
    }

    .slider-nav img:hover, .slider-nav img.active {
        opacity: 1;
        border-color: var(--primary-color);
        transform: translateY(-3px);
    }

    /* Info Sections */
    .content-section {
        margin-bottom: 50px;
    }

    .section-title {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 30px;
        color: var(--secondary-color);
        display: flex;
        align-items: center;
        gap: 15px;
        border-bottom: 2px solid #f1f5f9;
        padding-bottom: 15px;
    }

    .section-title i {
        color: var(--primary-color);
        font-size: 1.4rem;
    }

    .description-text {
        font-size: 1.1rem;
        color: var(--text-light);
        margin-bottom: 40px;
        line-height: 1.8;
        text-align: justify;
    }

    .highlights-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 25px;
    }

    .highlight-item {
        display: flex;
        align-items: center;
        gap: 20px;
        background: #f8fafc;
        padding: 25px;
        border-radius: 15px;
        transition: 0.3s;
        border: 1px solid #eef2f6;
    }

    .highlight-item:hover {
        background: var(--white);
        box-shadow: var(--shadow-md);
        transform: translateY(-5px);
        border-color: var(--primary-color);
    }

    .highlight-item i {
        background: rgba(26, 84, 143, 0.1);
        color: var(--primary-color);
        width: 55px;
        height: 55px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-size: 1.2rem;
    }

    .highlight-text h4 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--secondary-color);
    }

    .highlight-text p {
        margin: 5px 0 0 0;
        font-size: 0.85rem;
        color: var(--text-light);
    }

    /* Sticky Sidebar */
    .sidebar {
        position: sticky;
        top: 85px;
        height: fit-content;
    }

    .booking-card {
        background: var(--white);
        padding: 40px;
        border-radius: var(--radius);
        box-shadow: var(--shadow-md);
        border: 1px solid #eef2f6;
    }

    .price-tag {
        text-align: center;
        margin-bottom: 35px;
        padding-bottom: 25px;
        border-bottom: 1px dashed #e2e8f0;
    }

    .price-label {
        color: var(--text-light);
        font-size: 0.95rem;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        margin-bottom: 8px;
    }

    .price-amount {
        font-size: 2.8rem;
        font-weight: 800;
        color: var(--primary-color);
        display: block;
    }

    .price-amount span {
        font-size: 1rem;
        color: var(--text-light);
        font-weight: 500;
    }

    .booking-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        width: 100%;
        background: linear-gradient(135deg, var(--primary-color), #2980b9);
        color: var(--white);
        padding: 22px;
        border-radius: 15px;
        font-weight: 700;
        font-size: 1.1rem;
        text-decoration: none;
        transition: 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 0 10px 25px rgba(26, 84, 143, 0.3);
        margin-bottom: 30px;
        border: none;
        cursor: pointer;
    }

    .booking-btn:hover {
        transform: translateY(-4px);
        box-shadow: 0 15px 30px rgba(26, 84, 143, 0.4);
        color: var(--white);
    }

    .feature-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .feature-item {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 18px;
        font-size: 0.95rem;
        color: var(--text-dark);
        padding: 8px 0;
    }

    .feature-item i {
        color: #2ecc71;
        font-size: 1.2rem;
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .details-wrapper {
            grid-template-columns: 1fr;
            max-width: 900px;
            margin-top: -60px;
            padding: 0 20px;
        }
        .sidebar {
            position: static;
            width: 100%;
        }
    }

    @media (max-width: 768px) {
        .main-content { padding: 30px; }
        .hero-section { height: 40vh; }
        .section-title { font-size: 1.5rem; }
        .price-amount { font-size: 2.22rem; }
    }
</style>

<!-- Hero Section -->
<section class="hero-section">
    <img src="img/destinations/<?php echo $firstImage; ?>" class="hero-img" alt="<?php echo $row['name']; ?>" loading="lazy" decoding="async">
    <div class="hero-content">
        <h1><?php echo htmlspecialchars($row['country']); ?></h1>
        <p><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($row['city']); ?>, <?php echo htmlspecialchars($row['state']); ?></p>
    </div>
    <div class="breadcrumb-custom">
        <a href="index.php">Home</a> <i class="fas fa-chevron-right" style="font-size: 0.7rem; opacity: 0.6;"></i> 
        <a href="destinations.php">Destinations</a> <i class="fas fa-chevron-right" style="font-size: 0.7rem; opacity: 0.6;"></i> 
        <span><?php echo htmlspecialchars($row['name']); ?></span>
    </div>
</section>

<div class="details-wrapper">
    <!-- Left: Main Content -->
    <main class="main-content">
        <!-- Image Gallery Slider -->
        <div class="image-gallery">
            <div class="main-slider">
                <img id="activeImage" src="img/destinations/<?php echo $firstImage; ?>" alt="<?php echo $row['name']; ?>" loading="lazy" decoding="async">
            </div>
            <div class="slider-nav">
                <?php foreach ($images as $index => $img): 
                    $img = trim($img);
                    if (!$img) continue;
                ?>
                    <img src="img/destinations/<?php echo $img; ?>" 
                         class="<?php echo $index === 0 ? 'active' : ''; ?>"
                         onclick="updateMainImage(this.src, this)"
                         alt="Thumbnail"
                         loading="lazy" decoding="async">
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Description Section -->
        <section class="content-section">
            <h3 class="section-title"><i class="fas fa-quote-left"></i> Experience The Grandeur</h3>
            <div class="description-text">
                <?php echo nl2br(htmlspecialchars($row['description'])); ?>
            </div>
        </section>

        <!-- Highlights Section -->
        <section class="content-section">
            <h3 class="section-title"><i class="fas fa-concierge-bell"></i> Luxury Amenities & Perks</h3>
            <div class="highlights-grid">
                <div class="highlight-item">
                    <i class="fas fa-plane-arrival"></i>
                    <div class="highlight-text">
                        <h4>Airport Pickup</h4>
                        <p>Seamless transition to your stay</p>
                    </div>
                </div>
                <div class="highlight-item">
                    <i class="fas fa-utensils"></i>
                    <div class="highlight-text">
                        <h4>Gourmet Buffet</h4>
                        <p>Daily breakfast & dinner included</p>
                    </div>
                </div>
                <div class="highlight-item">
                    <i class="fas fa-user-tie"></i>
                    <div class="highlight-text">
                        <h4>Personal Concierge</h4>
                        <p>24/7 dedicated travel assistant</p>
                    </div>
                </div>
                <div class="highlight-item">
                    <i class="fas fa-shield-alt"></i>
                    <div class="highlight-text">
                        <h4>Travel Insurance</h4>
                        <p>Comprehensive coverage included</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Right: Sticky Sidebar -->
    <aside class="sidebar">
        <div class="booking-card">
            <div class="price-tag">
                <p class="price-label">Excl. Premium Package</p>
                <span class="price-amount">₹<?php echo number_format($row['price_range']); ?> <span>/ Person</span></span>
            </div>

            <a href="payment.php?id=<?php echo $row['id']; ?>" class="booking-btn">
                <i class="fas fa-paper-plane"></i> Book This Experience
            </a>

            <div class="feature-list">
                <div class="feature-item"><i class="fas fa-check-circle"></i> <span>No hidden service fees</span></div>
                <div class="feature-item"><i class="fas fa-check-circle"></i> <span>Secure reservation system</span></div>
                <div class="feature-item"><i class="fas fa-check-circle"></i> <span>Price match guarantee</span></div>
                <div class="feature-item"><i class="fas fa-check-circle"></i> <span>Easy monthly EMI available</span></div>
            </div>
        </div>
    </aside>
</div>

<script>
    function updateMainImage(src, element) {
        const mainImg = document.getElementById('activeImage');
        mainImg.style.opacity = '0.4';
        
        setTimeout(() => {
            mainImg.src = src;
            mainImg.style.opacity = '1';
        }, 150);
        
        // Update active class on thumbnails
        document.querySelectorAll('.slider-nav img').forEach(img => {
            img.classList.remove('active');
        });
        element.classList.add('active');
    }

    // Scroll effect for header
    window.addEventListener('scroll', function() {
        const nav = document.querySelector('.custom-navbar');
        if (window.scrollY > 50) {
            nav.classList.add('scrolled');
        } else {
            nav.classList.remove('scrolled');
        }
    });
</script>

<?php include('includes/footer.php'); ?>