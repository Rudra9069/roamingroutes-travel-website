<?php

include('database/traveldb.php');

// Get the destination ID from the URL like ?id=3
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch details for the specific destination
$query = "SELECT * FROM destinations WHERE id = $id AND is_deleted = '0'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

$imageString = $row['images'];
$images = explode(',', $imageString);
?>

<?php include('includes/header.php'); ?>

<style>
    *{
        margin: 0; 
        padding: 0;
    } 
    
    body{
        margin: 0; 
        padding: 0;
    }

    .destination-details-container {
        padding: 30px;
    }

    .destination-details-container h2 {
        font-size: 45px;
        text-align: center;
        margin-bottom: 10px;
        font-family: 'Poppins';
    }

    .destination-details-container p {
        font-size: 18px;
        margin: 5px 0;
    }

    .destination-details-container img {
        max-width: 90%;
        height: 300px;
        margin-top: 10px;
        margin-bottom: 20px;
        border-radius: 10px;
    }

    .not-found {
        font-size: 20px;
        padding: 30px;
        color: red;
    }

    .slider-container {
        position: relative;
        text-align: center;
    }

    .slider-container img {
        width: 90%;
        height: 300px;
        border-radius: 10px;
    }

    .prev-btn,.next-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background-color: rgba(0, 0, 0, 0.5);
        color: white;
        border: none;
        font-size: 24px;
        padding: 10px;
        cursor: pointer;
        border-radius: 50%;
    }

    .prev-btn {
        left: 10px;
    }

    .next-btn {
        right: 10px;
    }

    .prev-btn:hover,.next-btn:hover {
        background-color: rgba(0, 0, 0, 0.7);
    }

    .inf-card{
        padding: 25px;
        margin: 80px 30px;
        height: 200px;
        background: linear-gradient(to bottom, rgb(72, 72, 72),rgb(0, 0, 0));
        color: white;
        border-radius: 25px;
        font-family: 'Montserrat';
        display: flex;
        gap: 2%;
    }

    .cards{
        position: relative;
        background-color: rgba(30, 30, 30, 0);
        height: 70px;
        width: 350px;
        padding: 5px 10px 5px 15px;
        border-radius: 10px;
        border: 2px solid rgba(201, 201, 201, 0.3);
        box-shadow: 0px 0px 5px 1px rgb(38, 38, 38);
        transition: 0.5s;
    }

    .cards:hover{
        cursor: pointer;
        background-color: rgba(255, 255, 255, 0.83);
        color: black;
        height: 80px;
        width: 500px;
        border-radius: 5px;
    }

    .btn{
        position: absolute;
        margin-top: 7%;
        margin-left: 33%;
    }

    .proceed-button {
        background-color:rgb(71, 217, 69);
        color: white;
        padding: 15px 35px;
        font-size: 19px;
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s;
    }

    .proceed-button:hover {
        background-color:rgb(83, 216, 103);
    }
</style>

<?php if ($row): ?>
    <div class="destination-details-container">
        <h2><?php echo $row['name']; ?></h2>
        <!-- Images -->
        <div class="slider-container">
            <button class="prev-btn" onclick="changeSlide(-1)">❮</button>
            <img id="destinationImage" src="img/destinations/<?php echo trim($images[0]); ?>" alt="<?php echo $row['name']; ?>">
            <button class="next-btn" onclick="changeSlide(1)">❯</button>
        </div>

        <!-- Information section -->
        <div class="inf-card">

            <div class="cards">
                <p><strong>City</strong> <br><?php echo $row['city']; ?></p>
            </div>

            <div class="cards">
                <p><strong>State</strong><br> <?php echo $row['state']; ?></p>
            </div>

            <div class="cards">
                <p><strong>Starts from</strong><br> ₹<?php echo $row['price_range']; ?></p>
            </div>

            <div class="cards">
                <p><strong>Description</strong><br> <?php echo $row['description']; ?></p>
            </div>
                
            <div class="btn">
                <a class="proceed-button" href="payment.php?id=<?php echo $row['id']; ?>">Proceed to Payment</a>    
            </div>
        </div>    
    </div>
<?php else: ?>
    <p class="not-found">Destination not found.</p>
<?php endif; ?>

<script>
    const images = <?php echo json_encode($images); ?>;
    let currentIndex = 0;

    function changeSlide(direction) {
        currentIndex += direction;
        if (currentIndex < 0) currentIndex = images.length - 1;
        if (currentIndex >= images.length) currentIndex = 0;

        document.getElementById("destinationImage").src = "img/destinations/" + images[currentIndex].trim();
    }
</script>


<?php include('includes/footer.php'); ?>