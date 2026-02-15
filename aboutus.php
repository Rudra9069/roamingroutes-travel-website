<?php 

session_start();
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

    if($check_sql == true)
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
    else
    {
        echo "<script> alert('Please Login or create an account to get email.') </script>";
        exit();
    }
    // catch (Exception $e) 
    // {
    //   echo "Email could not be sent. Error: {$mail->ErrorInfo}";
    // }
  }
}

?>
<?php include('includes/header.php'); ?>
<style>
    /* Section-1 */
    .sec1 {
        position: relative;
        width: 100%;
        max-width: 100%;
        overflow: hidden;
        text-align: center;
    }

    .abt-img-wrapper {
        position: relative;
        width: 100%;
        height: 530px;
    }

    .abt-img {
        width: 100%;
        height: 530px;
        object-fit: cover;
        display: block;
        filter: blur(0.7px);
    }

    .abt-img-wrapper::after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.41);
        z-index: 1;
    }

    .overlay-text,
    .overlay-text_2 {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        color: white;
        z-index: 2;
        text-shadow: 0 0 10px rgba(0, 0, 0, 0.76);
        font-family: 'Poppins', sans-serif;
    }

    .overlay-text {
        top: 40%;
        font-size: 55px;
        font-weight: bold;
    }

    .overlay-text_2 {
        top: 55%;
        font-size: 30px;
        font-weight: bold;
    }

    /* Section-2 */
    .abt-p {
        font-size: 17px;
        font-weight: 444;
        line-height: 1.7;
        color: rgb(91, 86, 86);
        max-width: 700px;
        margin: 60px auto;
        padding: 0 20px;
        font-family: 'Nunito', sans-serif;
    }

    /* Section-3 */
    .sec3 {
        background-color: rgb(45, 167, 201);
        height: 380px;
        width: 100%;
    }

    .abt-d3 {
        position: relative;
        background-color: rgb(255, 255, 255);
        top: 15%;
        left: 6.5%;
        height: 70%;
        width: 87%;
        border-radius: 20px;
    }

    .subs-h{
        position: relative;
        top: 24%;
        left: 4%;
        color: rgb(45, 167, 201);
        font-family: 'Popins', sans-serif;
        font-weight: 700;
        font-size: 30px;
    }

    .subs-p1{
        position: relative;
        top: 25%;
        left: 4%;
        font-family: 'Nunito', sans-serif;
    }

    .abt-d3 input {
        position: relative;
        top: -50px;
        margin-left: 60%;
        width: 300px;
        height: 40px;
        background-color: #fff;
        border: 1px solid rgba(168, 168, 168, 0.67);
        outline: none;
        border-radius: 40px;
        font-size: 17px;
        padding: 20px 15px 20px 20px;
    }

    .abt-d3 input::placeholder {
        color: black;
    }

    .abt-d3 .em-btn {
        position: relative;
        top: -92px;
        margin-left: 85%;   
        width: 90px;
        height: 40px;
        border-radius: 30px;
        background-color: rgb(45, 167, 201);
        color: white;
        border: none;
        outline: none;
        font-family: 'Popins',sans-serif;
        font-weight: 600;
        font-size: 16px;
    }

    .abt-d3 input:hover {
        background-color: rgb(255, 255, 255);
    }

    .abt-d3 .em-btn:hover {
        color: rgb(255, 255, 255);
        background-color: rgb(45, 167, 201);
        font-size: 16.2px;
        box-shadow: 0px 0px 10px 0.5px rgb(46, 119, 139);
        transition: 0.8s;
    }

    .subs-p2{
        position: relative;
        top: -70px;
        margin-left: 61%;
        font-family: 'Nunito', sans-serif;
        font-size: 13px;
    }

    /* Section-3 */
    .sec4 {
        background-color: white;
    }

    .sec4-p{
        position: relative;
        font-family: 'Popins', sans-serif;
        font-size: 55px;
        font-weight: 700;
        margin-top: 5%;
        margin-left: 2%;
        line-height: normal;
    }

    .sec4-d{
        padding: 10px 0px 50px 0px;
    }

    .cards{
      display: flex;
      justify-content: space-between;
      gap: 10px;
      flex-wrap: wrap;
      margin: 20px 35px;
    }

    .card1,.card2,.card3{
        position: relative;
        height: 300px;
        width: 400px;
        background-color: rgba(207, 207, 207, 0.28);
        border-radius: 15px;
        border: none;
        box-shadow: 0px 0px 18px 2px rgba(55, 55, 55, 0.25);
    }

    .cards .cp-h{
        position: relative;
        margin-top: 20px;
        font-family: 'Popins', sans-serif;
        font-size: 25px;
        padding: 0px 25px;
        font-weight: 700;
    }

    .cards .cp{
        position: relative;
        margin-top: 20px;
        font-family: 'Popins', sans-serif;
        font-size: 16px;
        padding: 10px 25px;
    }

    /* Responsiveness Media Queries */
    @media (max-width: 992px) {
        .overlay-text { font-size: 42px; }
        .overlay-text_2 { font-size: 24px; top: 60%; }
        .abt-p { margin: 40px auto; font-size: 16px; }
        .subs-h { font-size: 26px; }
        .abt-d3 input { margin-left: 10%; top: 40px; width: 80%; }
        .abt-d3 .em-btn { margin-left: 10%; top: 50px; }
        .subs-p2 { margin-left: 10%; top: 60px; }
        .sec4-p { font-size: 38px; }
        .card1, .card2, .card3 { width: 100%; max-width: 450px; height: auto; padding-bottom: 20px; }
    }

    @media (max-width: 768px) {
        .abt-img-wrapper, .abt-img { height: 400px; }
        .overlay-text { font-size: 32px; top: 35%; }
        .overlay-text_2 { font-size: 20px; top: 55%; width: 90%; }
        .sec3 { height: auto; padding: 40px 0; }
        .abt-d3 { left: 5%; width: 90%; top: 0; padding-bottom: 40px; }
        .subs-h, .subs-p1 { left: 5%; text-align: center; width: 90%; }
        .abt-d3 input { margin: 20px auto; display: block; position: static; width: 90%; }
        .abt-d3 .em-btn { margin: 0 auto; display: block; position: static; }
        .subs-p2 { margin: 10px auto; text-align: center; position: static; width: 90%; }
        .sec4-p { font-size: 30px; text-align: center; margin-left: 0; }
        .cards { justify-content: center; }
    }

    @media (max-width: 480px) {
        .abt-img-wrapper, .abt-img { height: 300px; }
        .overlay-text { font-size: 26px; }
        .overlay-text_2 { font-size: 16px; }
        .sec4-p { font-size: 24px; }
    }

</style>

<body>

    <!-- Sec-1 -->
    <section class="sec1">
        <div class="abt-img-wrapper">
            <img class="abt-img" src="img/abt-img_2.jpg" alt="abt-img">
        </div>
        <div class="overlay-text"> About Us </div>
        <div class="overlay-text_2"> For every explorer enthusiasts. </div>
    </section>

    <!-- Sec-2 -->
    <section class="sec2">
        <p class="abt-p"> We believe that travel is for everyone. It helps us learn about ourselves and the world around
            us.<br><br>

            Our goal is to help more people from more backgrounds experience the joy of exploration.
            Because we believe this builds a kinder, more inclusive, more open-minded world.<br> <br>

            Like you, travel is in our DNA. At Roaming Routes, we believe travel opens the door to the greatest, most
            unforgettable experiences life can offer.
            And we have learned that the best travel is about putting yourself out there, about leaving behind the
            everyday,
            about immersing yourself, rather than just seeing the sights.<br> <br>

            As travelers, you're on a journey, and at Roaming Routes, we're on one, too. Over the last two years, travel
            has transformed.
            We're thinking deeply not just about how we travel but why we travel and how to best serve travelers on
            their journey – and we approach our 50th year with a passion and commitment to helping others do it,
            too.<br> <br>
        </p>
    </section>

    <!-- Sec-3 -->
    <section class="sec3">
        <div class="abt-d3">
            <h4 class="subs-h"> Subscribe & Get 20% Off </h4>
            <p class="subs-p1"> Join with us and Enjoy 20% off your next adventure <br> 
                                and stay updated with the latest travel news, tips, and exclusive offers. <br> 
                                As a subscriber, you’ll be the first to know about trending hotspots,<br> 
                                hidden gems, seasonal deals.</p>
            <form action="#" method="post">
                <input type="email" id="email" name="email" placeholder="Email address">
                <button class="em-btn" type="submit" name="send"> Submit </button><br>
                <p class="subs-p2"> Subscribe to Roaming Routes for more updates and promotions.</p>
            </form>
        </div>
    </section>

    <!-- Sec-4 -->
    <section class="sec4">
        <p class="sec4-p"> At Roaming Routes, <br> our core values  <br> guide our evolution: </p>
        <div class="sec4-d">
            <div class="cards">
                <div class="card1">
                    <p class="cp-h"> Passion For Exploration </p>
                    <p class="cp">
                        We believe that the world is meant to be explored with curiosity, excitement, and a sense of wonder. 
                        At the heart of everything we do is a deep passion for helping people discover new places, cultures, and perspectives. 
                    </p>
                </div>
                <div class="card2">
                    <p class="cp-h"> Trust & Transparency  </p>
                    <p class="cp">
                        Travel is a personal experience, and it requires trust. That’s why we are committed to complete transparency in everything 
                        we offer from honest destination insights to accurate pricing and real user reviews. 
                        We value your trust and work hard to earn it by ensuring that the information you see is authentic. 
                    </p>
                </div>
                <div class="card3">
                    <p class="cp-h"> Sustainable Travel </p>
                    <p class="cp">
                        We believe in travel that leaves a positive impact not just on the traveler, but on the world. 
                        Our commitment to sustainability means promoting experiences that respect local communities, preserve natural environments, and support cultural heritage. 
                    </p>
                </div>
            </div>
        </div>
    </section>

</body>
<?php include('includes/footer.php'); ?>