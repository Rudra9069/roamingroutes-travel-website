<?php
session_start(); 

include('database/traveldb.php');

$userLoggedIn = isset($_SESSION['u_id']);

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

if (!empty($search)) 
{
    $query = "SELECT * FROM destinations 
            WHERE is_deleted = '0' 
            AND (name LIKE '%$search%' OR city LIKE '%$search%' OR state LIKE '%$search%')";
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
        height: 530px;
        display: flex;
        filter: blur(0px);
    }

    .overlay-text {
        position: absolute;
        top: 65%;
        left: 84%;
        font-family: 'Popins', sans-serif;
        transform: translate(-75%, 120%);
        color: rgb(255, 255, 255);
        font-size: 55px;
        font-weight: bold;
        z-index: 1;
        text-shadow: 0 0 10px rgba(0, 0, 0, 0.7);
        white-space: nowrap;
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
        gap: 50px;
        justify-content: center;
        padding: 15px;
        font-family: 'Popins', sans-serif;  
    }

    .cards {
        width: 450px;
        height: 410px;
        border: none;
        outline: none;
        overflow: hidden;
        border-radius: 20px;
        background-color: rgb(39, 39, 39);
        color: white;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.33);
        cursor: pointer;
    }

    .cards img {
        width: 100%;
        height: 300px;
        object-fit: cover;
    }

    .cards h5 {
        position: relative;
        top: 10px;
        margin-left: 3%;
        font-weight: 0;
    }

    .price {
        text-decoration: none;
        color: white;
        font-size: 25px;
        margin-left: 3%;
        margin-top: 9%;
    }

    .cards:hover {
        position: relative;
        background-color: rgba(0, 0, 0, 0.95);
        box-shadow: 0px 0px 20px 5px rgba(0, 0, 0, 0.52);
    }

    /* search result null */
    .no-results {
        color: black;
        font-size: 20px;
        font-weight: 500;
    }
</style>

<body>
    
    <!-- search bar -->
    <div id="searchContainer" class="search-container hidden">
        <form action="destinations.php" method="get">
            <input type="text" placeholder="Search for destinations" name="search">
            <button class="i-btn" type="submit"><i class="fa fa-search"></i></button>
        </form>
    </div> 
    <!-- Section1 -->
    <section class="sec1">
        <img class="dest-img" src="img/dest-img_2.jpg" alt="dest-img">
        <div class="overlay-text"> Explore places on Roaming Routes </div>
    </section>

    <!-- Section2 -->
    <section class="sec2">
        <div class="main-places">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                        $images = explode(',', $row['images']);
                        $firstImage = trim($images[0]); 
                ?>
                    <a href="destination-details.php?id=<?php echo $row['id']; ?>" target="_blank"
                        style="text-decoration: none;">
                        <div class="cards">
                            <img src="img/destinations/<?php echo $firstImage; ?>" alt="<?php echo $row['name']; ?>">
                            <h5> <?php echo $row['name']; ?> </h5>
                            <p class="price"> From: <?php echo "₹" . $row['price_range']; ?> </p>
                        </div>
                    </a>
                    <?php
                } ?>
            <?php else: ?>
                <p class="no-results"> No destinations found for your search.</p>
            <?php endif; ?>
        </div>
    </section>

</body>
<?php include('includes/footer.php'); ?>