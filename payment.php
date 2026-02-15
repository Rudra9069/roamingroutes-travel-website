<?php 
session_start();
include('database/traveldb.php'); 

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (!$id) {
    header("Location: destinations.php");
    exit();
}

$query = "SELECT * FROM destinations WHERE id = $id AND is_deleted = '0'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    die("Invalid destination selected.");
}

$imageString = $row['images'];
$images = explode(',', $imageString);
$firstImage = trim($images[0]);

require('vendor/autoload.php'); 
require('config.php');

use Razorpay\Api\Api;

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['payment_id'])) 
{
    $payment_id = $_POST['payment_id'];
    $email = $_POST['email'];
    $amount = $_POST['amount'] / 100;

    $api = new Api($RAZORPAY_KEY_ID, $RAZORPAY_KEY_SECRET);

    try 
    {
        $payment = $api->payment->fetch($payment_id);

        if ($payment->status === 'captured' || $payment->status === 'authorized') 
        {
            $name = isset($_SESSION['name']) ? $_SESSION['name'] : 'Guest';
            $u_id = isset($_SESSION['u_id']) ? $_SESSION['u_id'] : 0;
            
            // Record payment with user and destination association
            $stmt = $conn->prepare("INSERT INTO payments (u_id, destination_id, razorpay_id, name, email, amount, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $status = $payment->status;
            $stmt->bind_param("iisssds", $u_id, $id, $payment_id, $name, $email, $amount, $status);
            
            if ($stmt->execute()) {
                $stmt->close();
                echo "success";
            } else {
                error_log("Database Insertion Error: " . $stmt->error);
                echo "db_error: " . $stmt->error;
            }
            exit();
        } else {
            echo "payment_status_error: " . $payment->status;
            exit();
        }
    } 
    catch (Exception $e) 
    {
        error_log("Razorpay Error: " . $e->getMessage());
        echo "razor_error: " . $e->getMessage();
        exit();
    }
}
?>

<?php include('includes/header.php'); ?>

<style>
    :root {
        --brand-blue: #002347;
        --brand-gold: #c5a059;
        --soft-white: #fcfcfc;
        --glass-bg: rgba(255, 255, 255, 0.9);
    }

    body {
        margin: 0;
        padding: 0;
        background-color: var(--brand-blue);
        font-family: 'Poppins', sans-serif;
        overflow-x: hidden;
    }

    /* Background Wrapper */
    .bg-wrapper {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        z-index: -1;
        overflow: hidden;
    }

    .bg-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        filter: brightness(0.4) blur(3px);
        transform: scale(1.1);
        animation: subtleZoom 20s infinite alternate ease-in-out;
    }

    @keyframes subtleZoom {
        from { transform: scale(1.1); }
        to { transform: scale(1.2); }
    }

    .main-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        padding: 100px 20px 40px 20px;
    }

    .checkout-card {
        background: var(--glass-bg);
        backdrop-filter: blur(15px);
        width: 100%;
        max-width: 950px;
        border-radius: 40px;
        box-shadow: 0 30px 60px rgba(0,0,0,0.4);
        overflow: hidden;
        display: grid;
        grid-template-columns: 1fr 1fr;
    }

    /* Trip Info Section */
    .trip-info {
        background: rgba(0, 35, 71, 0.03);
        padding: 60px 50px;
        border-right: 1px solid rgba(0,0,0,0.05);
    }

    .trip-header {
        margin-bottom: 40px;
    }

    .trip-header h2 {
        font-size: 2.4rem;
        color: var(--brand-blue);
        margin: 0;
        font-weight: 800;
        line-height: 1.2;
    }

    .trip-header .location {
        color: var(--brand-gold);
        font-family: 'Montserrat';
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 0.9rem;
    }

    .trip-highlights {
        display: flex;
        flex-direction: column;
        gap: 20px;
        margin-bottom: 40px;
    }

    .highlight-item {
        display: flex;
        align-items: center;
        gap: 15px;
        color: #555;
    }

    .highlight-item i {
        color: var(--brand-gold);
        font-size: 1.2rem;
    }

    .price-summary {
        margin-top: auto;
        padding-top: 30px;
        border-top: 2px solid rgba(197, 160, 89, 0.2);
    }

    .price-summary .total-label {
        font-size: 0.9rem;
        color: #888;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .price-summary .total-amount {
        font-size: 3rem;
        font-weight: 800;
        color: var(--brand-blue);
    }

    /* Checkout Form Section */
    .checkout-side {
        padding: 60px 50px;
        display: flex;
        flex-direction: column;
    }

    .side-header {
        margin-bottom: 35px;
    }

    .side-header h3 {
        font-size: 1.6rem;
        color: var(--brand-blue);
        font-weight: 700;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-group label {
        display: block;
        font-size: 0.85rem;
        font-weight: 600;
        color: #777;
        margin-bottom: 8px;
        margin-left: 5px;
    }

    .form-control {
        width: 100%;
        padding: 16px 20px;
        border-radius: 15px;
        border: 2px solid #eee;
        background: #fdfdfd;
        font-family: 'Poppins';
        font-size: 1rem;
        transition: 0.3s;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--brand-gold);
        background: white;
        box-shadow: 0 10px 20px rgba(197, 160, 89, 0.1);
    }

    .pay-button {
        background: var(--brand-blue);
        color: white;
        padding: 22px;
        border-radius: 20px;
        font-size: 1.2rem;
        font-weight: 700;
        border: none;
        cursor: pointer;
        transition: 0.3s;
        margin-top: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        box-shadow: 0 15px 30px rgba(0, 35, 71, 0.2);
    }

    .pay-button:hover {
        background: #003366;
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0, 35, 71, 0.3);
    }

    .footer-note {
        margin-top: auto;
        text-align: center;
        color: #aaa;
        font-size: 0.75rem;
        display: flex;
        justify-content: center;
        gap: 15px;
    }

    .footer-note span i {
        color: var(--brand-gold);
    }

    @media (max-width: 900px) {
        .checkout-card { grid-template-columns: 1fr; }
        .trip-info { border-right: none; border-bottom: 1px solid #eee; padding: 40px; }
        .checkout-side { padding: 40px; }
        .main-container { padding-top: 80px; }
    }
</style>

<div class="bg-wrapper">
    <img src="img/destinations/<?php echo $firstImage; ?>" class="bg-image" alt="Background">
</div>

<div class="main-container">
    <div class="checkout-card">
        <!-- Summary Side -->
        <div class="trip-info">
            <div class="trip-header">
                <span class="location"><?php echo htmlspecialchars($row['city']); ?>, <?php echo htmlspecialchars($row['state']); ?></span>
                <h2><?php echo htmlspecialchars($row['name']); ?></h2>
            </div>

            <div class="trip-highlights">
                <div class="highlight-item">
                    <i class="fas fa-calendar-alt"></i>
                    <span>All-Inclusive Travel Package</span>
                </div>
                <div class="highlight-item">
                    <i class="fas fa-hotel"></i>
                    <span>Premium Accommodation Included</span>
                </div>
                <div class="highlight-item">
                    <i class="fas fa-plane-departure"></i>
                    <span>Optional Flight Assistance</span>
                </div>
            </div>

            <div class="price-summary">
                <span class="total-label">Payable Amount</span>
                <div class="total-amount">₹<?php echo number_format($row['price_range']); ?></div>
            </div>
        </div>

        <!-- Payment Side -->
        <div class="checkout-side">
            <div class="side-header">
                <h3>Passenger Details</h3>
            </div>

            <form id="paymentForm">
                <div class="form-group">
                    <label>YOUR NAME</label>
                    <input type="text" id="name" class="form-control" placeholder="e.g. John Doe" value="<?php echo isset($_SESSION['name']) ? $_SESSION['name'] : ''; ?>">
                </div>

                <div class="form-group">
                    <label>EMAIL ADDRESS</label>
                    <input type="email" id="email" class="form-control" placeholder="e.g. john@example.com" value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>">
                </div>

                <div class="form-group">
                    <label>CURRENCY</label>
                    <input type="text" class="form-control" value="Indian Rupee (INR)" readonly style="opacity: 0.7;">
                </div>

                <button type="button" class="pay-button" onclick="payNow()">
                    Confirm & Pay Now <i class="fas fa-arrow-right"></i>
                </button>
            </form>

        </div>
    </div>
</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    function payNow() 
    {
        const email = document.getElementById("email").value;
        const name = document.getElementById("name").value;
        const amount = <?php echo $row['price_range']; ?> * 100;

        if(!email || !name) {
            alert("Please provide name and email to proceed.");
            return;
        }

        const options = 
        {
            "key": "<?php echo $RAZORPAY_KEY_ID; ?>", 
            "amount": amount,
            "currency": "INR",
            "name": "Roaming Routes",
            "description": "Destination: <?php echo $row['name']; ?>",
            "handler": function (response) 
            {
                const formData = new FormData();
                formData.append('payment_id', response.razorpay_payment_id);
                formData.append('email', email);
                formData.append('amount', amount);

                fetch('payment.php?id=<?php echo $id; ?>', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.text())
                .then(data => {
                    if (data.trim() === "success") {
                        window.location.href = "success.php?razorpay_id=" + response.razorpay_payment_id;
                    } else {
                        alert("Verification Error: " + data);
                        console.error("Payment Error:", data);
                    }
                });
            },
            "prefill": { "name": name, "email": email },
            "theme": { "color": "#002347" }
        };
        const rzp = new Razorpay(options);
        rzp.open();
    }
</script>

<?php include('includes/footer.php'); ?>