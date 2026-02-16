<?php

include('database/traveldb.php'); 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer files
require 'vendor/autoload.php';

if (isset($_POST['send']))
{
  $email = $_POST['email'];

  //Checking if user has registered.
  $check_email = " SELECT * FROM users WHERE email = '$email' ";
  $check_sql = mysqli_query($conn,$check_email);

  if (mysqli_num_rows($check_sql) > 0) 
  {
    $mail = new PHPMailer(true);

    try
    {
      //Server settings
      $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com';
      $mail->SMTPAuth = true;
      $mail->Username = 'roamingroutes33@gmail.com';
      $mail->Password = 'tsjs igis tazc vazs';
      $mail->SMTPSecure = 'ssl';
      $mail->Port = 465;

      //Recipients
      $mail->setFrom('roamingroutes33@gmail.com', 'Roaming Routes');
      $mail->addAddress($email);

      //Content
      $mail->isHTML(true);
      $mail->Subject = "Thank you for Subscribing";
      $mail->Body = "<h3> Congratulations," .$email. "</h3><br>
                      <p> Discount of 20% coupon will be credited in your account. <br> 
                          It is only for the first travel package.</p>
                      <h5> Thankyou, Roaming Routes :) </h5>  ";

      $mail->send();
      echo "<script> alert('Thanks for Subscribing. email has been sent to $email'); </script>";
    }
    catch (Exception $e) 
    {
      echo "Email could not be sent. Error: {$mail->ErrorInfo}";
    }
  }
}
?>

<section class="last-sec">
  <!-- Brand Section -->
  <div class="footer-col brand-col">
    <h3> Roaming Routes </h3>
    <p> For Every Explorers Enthusiasts </p>
    <h4> FOLLOW US </h4>
    <div class="icons">
      <a class="insta" href="https://www.instagram.com/"> <i class="fa-brands fa-instagram"></i> </a>
      <a class="facebk" href="https://www.facebook.com/"> <i class="fa-brands fa-square-facebook"></i> </a>
      <a class="xt" href="https://x.com/?lang=en"> <i class="fa-brands fa-x-twitter"></i> </a>
      <a class="ytube" href="https://www.youtube.com/"> <i class="fa-brands fa-youtube"></i> </a>
      <a class="pint" href="https://in.pinterest.com/"> <i class="fa-brands fa-pinterest"></i> </a>
    </div>

    <!-- Subscribe Now -->
    <div class="subs">
      <h4> SUBSCRIBE </h4>
      <form action="#" method="post">
        <input type="email" id="email" name="email" placeholder="Email address">
        <button class="em-btn" type="submit" name="send"> <i class="fa-solid fa-envelope"></i> </button>
      </form>
      <p class="sub-p"> Subscribe to Roaming Routes for more updates and promotions.</p>
    </div>
  </div>

  <!-- Features Section -->
  <div class="footer-col features">
    <h5> Features </h5>
    <div class="our-features">
      <a href="index.php">Home</a>
      <a href="destinations.php">Destinations</a>
      <a href="aboutus.php">About us</a>
      <a href="contact.php">Contact</a>
      <a href="login.php">Login</a>
    </div>
  </div>

  <!-- Destinations Section -->
  <div class="footer-col top-destinations">
    <h5> Top Destinations </h5>
    <div class="top-dest">
      <a href="#">California</a>
      <a href="#">Greece</a>
      <a href="#">France</a>
      <a href="#">India</a>
      <a href="#">New Zealand</a>
      <a href="#">United States</a>
      <a href="#">China</a>
      <a href="#">Italy</a>
      <a href="#">Turkey</a>
    </div>
  </div>

  <!-- Contact Section -->
  <div class="footer-col contact-us">
    <h5> Contact us </h5>
    <div class="contact-icons">
      <div class="contact-item">
        <i style="color:rgba(20, 111, 168, 0.87);" class="fa-regular fa-envelope"> </i>
        <p class="cont-details"> roamingroutes33@gmail.com </p>
      </div>
      <div class="contact-item">
        <i style="color: white;" class="fa-solid fa-mobile-screen-button"></i>
        <p class="cont-details"> +91 8200214115 </p>
      </div>
      <div class="contact-item">
        <i style="color: lightcoral;" class="fa-solid fa-map-pin"></i>
        <p class="cont-details"> G-1 Krishna Sadan, Pranami Street, Moti-Chhipwad, Valsad - 396001</p>
      </div>
    </div>  
  </div>
</section>

<!-- Footer -->
<footer class="custom-footer">
  <div class="container">
    <p class="footer">© <?php echo date("Y"); ?> Roaming Routes. All rights reserved.</p>
  </div>
</footer>

</body>
</html>