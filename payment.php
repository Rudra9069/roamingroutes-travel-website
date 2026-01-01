<?php 
include('database/traveldb.php'); 

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch destination info
$query = "SELECT * FROM destinations WHERE id = $id AND is_deleted = '0'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

if (!$row) 
{
    die("Invalid destination selected.");
}

require('vendor/autoload.php'); // Composer autoload
require('config.php');

use Razorpay\Api\Api;

if ($_SERVER["REQUEST_METHOD"] === "POST") 
{
    $payment_id = $_POST['payment_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $amount = $_POST['amount'];

    $api = new Api($RAZORPAY_KEY_ID, $RAZORPAY_KEY_SECRET);

    try 
    {
        $payment = $api->payment->fetch($payment_id);

        if ($payment->status === 'captured' || $payment->status === 'authorized') 
        {
            $stmt = $conn->prepare("INSERT INTO payments (payment_id, name, email, amount, status) VALUES (?, ?, ?, ?, ?)");
            $status = $payment->status;
            $stmt->bind_param("sssds", $payment_id, $name, $email, $amount, $status);
            $stmt->execute();
            $stmt->close();
            $conn->close();

            echo "success";
        } 
        else 
        {
            echo "payment failed";
        }
    } 
    catch (Exception $e) 
    {
        echo "error: " . $e->getMessage();
    }
}


?>
<?php include('includes/header.php'); ?>
<style>
    /* section 1 */
    .image-container {
        position: relative;
        width: 100%;
        height: 650px;
        overflow: hidden;
    }

    .pay-img {
        position: relative;
        display: flex;
        width: 100%;
        height: 100%;
    }

    .overlay {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        background-color: rgba(0, 0, 0, 0.18);
        display: flex;
        color: white;
        padding: 20px;
    }

    .card {
        position: absolute;
        top: 10%;
        left: 19%;
        background-color: rgba(255, 255, 255, 0.89);
        color: black;
        padding: 30px 0px;
        border-radius: 30px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        height: 100%;
        max-height: 500px;
        width: 100%;
        max-width: 1000px;
    }

    .ch{
        position: relative;
        top: -3%;
        left: 2%;
        font-size: 40px;
        font-family: 'Poppins';
        color: rgb(0, 0, 0);
    }

    .cp{
        position: relative;
        top: 10%;
        left: 2%;
        font-size: 25px;
        font-family: 'Poppins'; 
    }

    .cpt{
        position: relative;
        top: 25%;
        left: 2%;
        font-size: 25px;
        font-family: 'Poppins'; 
    }

    .input-box{
        display: flex;
        font-family: 'Poppins';
        font-size: 25px;
        position: relative;
        top: 8.5%;
        margin-left: 12%;
        width: 150px;
        height: 25px;
        background-color: rgba(0, 0, 0, 0);
        border: none;
    }

    /* Card2 */
    .card2{
        position: absolute;
        top: 5%;
        left: 58%;
        background-color: rgba(163, 163, 163, 0.67);
        border-radius: 10px;
        width: 400px;
        height: 450px;        
    }

    .payment-form-container {
        font-family: 'Montserrat';
        padding: 20px 40px;
    }

    .payment-form-group {
        margin-bottom: 15px;
    }

    .payment-input {
        width: 100%;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    .payment-button {
        background-color: #28a745;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 16px;
    }

    .payment-button:hover {
        background-color: #218838;
    }
</style>

<body>

    <!-- Sec-1 -->
    <section class="sec1">

        <!-- Image -->
        <div class="image-container">
            <img src="img/payment.jpg" alt="Background" class="pay-img">

            <!-- Overlay text -->
            <div class="overlay">

                <!-- Contact us form -->
                <div class="card">
                        <h4 class="ch"> Invoice </h4>
                        <p class="cp"> <strong> Package: </strong> <?php echo $row['name']; ?></p>
                        <p class="cp"> <strong> Flights: </strong> <?php echo "none" ?></p>
                        <p class="cp"> <strong> Extra activities: </strong> <?php echo "none"; ?></p>
                        <p class="cpt"> <strong> Total: ₹</strong> </p> <br>
                        <input class="input-box" type="text" value="<?php echo $row['price_range']?>">

                    <div class="card2">
                        <form action="payment.php" method="post">
                            <input type="hidden" name="destination_id"
                                value="<?php echo isset($_GET['id']) ? intval($_GET['id']) : 0; ?>">

                            <div class="payment-form-container">

                                <div class="payment-form-group">
                                    <label for="email">Email</label><br>
                                    <input type="email" name="email" id="email" placeholder="email address" required
                                        class="payment-input">
                                </div>

                                <div class="payment-form-group">
                                    <label for="email"> INR:</label><br>
                                    <input type="number" id="amount" class="payment-input" value="<?php echo $row['price_range']?>">
                                </div>

                                <button class="payment-button" type="button" onclick="payNow()">
                                    Pay Now
                                </button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
  <script>
    function payNow() 
    {
      var email = document.getElementById("email").value;
      var amount = document.getElementById("amount").value * 100; // convert to paise

      var options = 
      {
        "key": "rzp_test_qYgM6sOFZFS3Qs", 
        "amount": amount,
        "currency": "INR",
        "name": "Roaming Routes",
        "description": "Travel Booking",
        "handler": function (response) 
        {
          // Post to backend
          var xhr = new XMLHttpRequest();
          xhr.open("POST", "payment_verification.php", true);
          xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
          xhr.send("payment_id=" + response.razorpay_payment_id + "&email=" + email + "&amount=" + amount);
          xhr.onload = function () 
          {
            if (xhr.status === 200) 
            {
              window.location.href = "success.php";
            }
          };
        },
        "prefill": 
        {
          "name": name,
          "email": email
        },
        "method": 
        {
          "upi": true
        }
      };
      var rzp = new Razorpay(options);
      rzp.open();
    }
  </script>
<?php include('includes/footer.php'); ?>