<?php 

session_start();
include('database/traveldb.php'); 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer files
require 'vendor/autoload.php';

if (isset($_POST['send']))
{
  if (isset($_SESSION['u_id'])) 
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
    else {
      echo "<script> alert('This email is not registered. Please register first.'); </script>";
    }
  }
  else {
    echo "<script> alert('Please create an account or register to subscribe.'); </script>";
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
        background: linear-gradient(
            to bottom,
            rgba(0, 0, 0, 0.2) 0%,
            rgba(0, 0, 0, 0.5) 100%
        );
        z-index: 1;
    }

    .overlay-text,
    .overlay-text_2 {
        position: absolute;
        left: 0;
        right: 0;
        margin: 0 auto;
        color: white;
        z-index: 2;
        text-shadow: 0 0 10px rgba(0, 0, 0, 0.76);
        font-family: 'Poppins', sans-serif;
        text-align: center;
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
        line-height: 1.8;
        color: rgb(75, 72, 72);
        max-width: 750px;
        margin: 60px auto;
        padding: 0 20px;
        font-family: 'Nunito', sans-serif;
    }

    /* Section-3 */
    .sec3 {
        background: linear-gradient(135deg, rgb(45, 167, 201) 0%, rgb(35, 140, 175) 100%);
        height: auto;
        padding: 60px 0;
        width: 100%;
    }

    .abt-d3 {
        position: relative;
        background-color: rgb(255, 255, 255);
        margin: 0 auto;
        min-height: 250px;
        width: 90%;
        max-width: 1200px;
        border-radius: 20px;
        padding: 40px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        box-shadow: 0 12px 45px rgba(0, 0, 0, 0.1);
    }

    .subs-h{
        position: relative;
        color: rgb(35, 140, 175);
        font-family: 'Montserrat', sans-serif;
        font-weight: 700;
        font-size: 30px;
        margin-bottom: 10px;
    }

    .subs-p1{
        position: relative;
        font-family: 'Inter', sans-serif;
        margin-bottom: 25px;
        max-width: 800px;
        color: #555;
        line-height: 1.6;
    }

    .subs-form {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        align-items: center;
        justify-content: center;
    }

    .abt-d3 input {
        width: 100%;
        max-width: 300px;
        height: 48px;
        background-color: #fff;
        border: 1.5px solid rgba(45, 167, 201, 0.3);
        outline: none;
        border-radius: 40px;
        font-size: 17px;
        padding: 10px 20px;
        font-family: 'Inter', sans-serif;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    .abt-d3 input:focus {
        border-color: rgb(45, 167, 201);
        box-shadow: 0 0 0 3px rgba(45, 167, 201, 0.12);
    }

    .abt-d3 .em-btn {
        width: 100px;
        height: 44px;
        border-radius: 30px;
        background: linear-gradient(135deg, rgb(45, 167, 201) 0%, rgb(35, 140, 175) 100%);
        color: white;
        border: none;
        outline: none;
        font-family: 'Montserrat', sans-serif;
        font-weight: 600;
        font-size: 16px;
        cursor: pointer;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .abt-d3 .em-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(45, 167, 201, 0.35);
    }

    .abt-d3 .em-btn:active {
        transform: scale(0.97);
    }

    .subs-p2{
        position: relative;
        margin-top: 15px;
        font-family: 'Inter', sans-serif;
        font-size: 13px;
        width: 100%;
        color: #999;
    }

    /* Section-3 */
    .sec4 {
        background-color: white;
    }

    .sec4-p{
        position: relative;
        font-family: 'Montserrat', sans-serif;
        font-size: 55px;
        font-weight: 700;
        margin-top: 5%;
        margin-left: 2%;
        line-height: normal;
        letter-spacing: -0.5px;
    }

    .sec4-d{
        padding: 10px 0px 50px 0px;
    }

    .cards{
      display: flex;
      justify-content: space-between;
      gap: 20px;
      flex-wrap: wrap;
      margin: 20px 35px;
    }

    .card1,.card2,.card3{
        position: relative;
        height: auto;
        min-height: 300px;
        width: 100%;
        max-width: 450px;
        background-color: #fff;
        border-radius: 16px;
        border: none;
        border-left: 4px solid rgb(45, 167, 201);
        box-shadow: 0 4px 25px rgba(0, 0, 0, 0.08);
        padding-bottom: 20px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card1:hover,.card2:hover,.card3:hover{
        transform: translateY(-5px);
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.12);
    }

    .cards .cp-h{
        position: relative;
        margin-top: 20px;
        font-family: 'Montserrat', sans-serif;
        font-size: 25px;
        padding: 0px 25px;
        font-weight: 700;
        letter-spacing: -0.3px;
        color: rgb(35, 140, 175);
    }

    .cards .cp{
        position: relative;
        margin-top: 20px;
        font-family: 'Inter', sans-serif;
        font-size: 16px;
        padding: 10px 25px;
        line-height: 1.7;
        color: #555;
    }

    /* Responsiveness Media Queries */

    /* ---- Tablet (≤992px) ---- */
    @media (max-width: 992px) {
        .overlay-text { font-size: 42px; }
        .overlay-text_2 { font-size: 22px; top: 58%; }
        .abt-p { margin: 40px auto; font-size: 16px; padding: 0 30px; }
        .subs-h { font-size: 26px; }
        .abt-d3 { padding: 40px 25px; align-items: center; text-align: center; }
        .subs-form { justify-content: center; width: 100%; }
        .abt-d3 input { margin: 10px 0; width: 100%; max-width: 350px; position: static; }
        .abt-d3 .em-btn { margin: 10px 0; position: static; }
        .subs-p2 { margin: 10px 0 0 0; position: static; text-align: center; }
        .sec4-p { font-size: 38px; text-align: center; margin-left: 0; }
        .cards { justify-content: center; gap: 20px; }
        .card1, .card2, .card3 { width: 100%; max-width: 450px; height: auto; padding-bottom: 20px; margin: 0 auto; }
    }

    /* ---- Mobile (≤768px) ---- */
    @media (max-width: 768px) {
        /* Hero Section */
        .abt-img-wrapper, .abt-img { height: 380px; }
        .abt-img-wrapper::after {
            background: linear-gradient(
                to bottom,
                rgba(0, 0, 0, 0.25) 0%,
                rgba(0, 0, 0, 0.55) 100%
            );
        }
        .overlay-text {
            font-size: 30px;
            top: 38%;
            width: 90%;
            letter-spacing: 1px;
        }
        .overlay-text_2 {
            font-size: 17px;
            top: 55%;
            width: 85%;
            line-height: 1.5;
            font-weight: 500;
        }

        /* About Paragraph */
        .abt-p {
            margin: 35px auto;
            font-size: 15px;
            padding: 0 24px;
            line-height: 1.8;
            text-align: justify;
            color: rgb(75, 72, 72);
        }

        /* Subscribe Section */
        .sec3 {
            height: auto;
            padding: 40px 16px;
            background: linear-gradient(135deg, rgb(45, 167, 201) 0%, rgb(35, 140, 175) 100%);
        }
        .abt-d3 {
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
            padding: 32px 20px;
            position: static;
            border-radius: 18px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        }
        .subs-h {
            font-size: 22px;
            left: 0;
            text-align: center;
            width: 100%;
            position: static;
            color: rgb(35, 140, 175);
        }
        .subs-p1 {
            left: 0;
            text-align: center;
            width: 100%;
            position: static;
            font-size: 14px;
            line-height: 1.6;
            color: #666;
            padding: 0 5px;
        }
        .subs-form {
            flex-direction: column;
            align-items: center;
            gap: 12px;
        }
        .abt-d3 input {
            margin: 0;
            width: 100%;
            max-width: 300px;
            position: static;
            display: block;
            height: 48px;
            font-size: 15px;
            border-radius: 30px;
            border: 1.5px solid rgba(45, 167, 201, 0.3);
            transition: border-color 0.3s ease;
        }
        .abt-d3 input:focus {
            border-color: rgb(45, 167, 201);
        }
        .abt-d3 .em-btn {
            margin: 0;
            position: static;
            display: block;
            width: 140px;
            height: 46px;
            font-size: 15px;
            border-radius: 30px;
            background: linear-gradient(135deg, rgb(45, 167, 201) 0%, rgb(35, 140, 175) 100%);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .abt-d3 .em-btn:active {
            transform: scale(0.97);
        }
        .subs-p2 {
            margin: 14px 0 0 0;
            text-align: center;
            position: static;
            width: 100%;
            font-size: 12px;
            color: #999;
        }

        /* Core Values Section */
        .sec4-p {
            font-size: 26px;
            text-align: center;
            margin-left: 0;
            margin-top: 40px;
            padding: 0 20px;
            line-height: 1.35;
        }
        .cards {
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin: 20px 16px;
            gap: 18px;
        }
        .card1, .card2, .card3 {
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
            padding: 24px 20px 28px;
            min-height: auto;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border-left: 4px solid rgb(45, 167, 201);
            background: #fff;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .card1:active, .card2:active, .card3:active {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        }
        .cards .cp-h {
            font-size: 20px;
            margin-top: 0;
            padding: 0 0 8px 0;
            color: rgb(35, 140, 175);
        }
        .cards .cp {
            font-size: 14px;
            margin-top: 0;
            padding: 0;
            line-height: 1.7;
            color: #555;
        }
    }

    /* ---- Small Mobile (≤480px) ---- */
    @media (max-width: 480px) {
        .abt-img-wrapper, .abt-img { height: 280px; }
        .overlay-text { font-size: 24px; top: 35%; }
        .overlay-text_2 { font-size: 14px; top: 53%; width: 90%; }
        .abt-p { font-size: 14px; padding: 0 18px; margin: 28px auto; }
        .sec3 { padding: 30px 12px; }
        .abt-d3 { padding: 28px 16px; }
        .subs-h { font-size: 20px; }
        .subs-p1 { font-size: 13px; }
        .abt-d3 input { max-width: 260px; height: 44px; }
        .abt-d3 .em-btn { width: 120px; height: 42px; }
        .sec4-p { font-size: 22px; padding: 0 16px; }
        .sec4-d { padding: 5px 0px 40px 0px; }
        .cards { margin: 15px 12px; gap: 14px; }
        .card1, .card2, .card3 { padding: 20px 16px 24px; }
        .cards .cp-h { font-size: 18px; }
        .cards .cp { font-size: 13px; }
    }

    /* ---- Scroll Animations ---- */
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(40px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to   { opacity: 1; }
    }
    @keyframes slideInLeft {
        from { opacity: 0; transform: translateX(-30px); }
        to   { opacity: 1; transform: translateX(0); }
    }

    .anim-hidden {
        opacity: 0;
    }
    .anim-fade-up {
        animation: fadeUp 0.7s cubic-bezier(0.22, 1, 0.36, 1) forwards;
    }
    .anim-fade-in {
        animation: fadeIn 0.8s ease forwards;
    }
    .anim-slide-left {
        animation: slideInLeft 0.7s cubic-bezier(0.22, 1, 0.36, 1) forwards;
    }

    /* Staggered card delays */
    .card1.anim-fade-up { animation-delay: 0s; }
    .card2.anim-fade-up { animation-delay: 0.15s; }
    .card3.anim-fade-up { animation-delay: 0.3s; }

    /* Respect reduced motion */
    @media (prefers-reduced-motion: reduce) {
        .anim-hidden { opacity: 1; }
        .anim-fade-up, .anim-fade-in, .anim-slide-left {
            animation: none;
            opacity: 1;
            transform: none;
        }
    }

</style>

<body>

    <!-- Sec-1 -->
    <section class="sec1">
        <div class="abt-img-wrapper">
            <img class="abt-img" src="img/abt-img_2.jpg" alt="abt-img" loading="lazy" decoding="async">
        </div>
        <div class="overlay-text anim-hidden" data-anim="anim-fade-in"> About Us </div>
        <div class="overlay-text_2 anim-hidden" data-anim="anim-fade-up"> For every explorer enthusiasts. </div>
    </section>

    <!-- Sec-2 -->
    <section class="sec2">
        <p class="abt-p anim-hidden" data-anim="anim-fade-up"> We believe that travel is for everyone. It helps us learn about ourselves and the world around
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
        <div class="abt-d3 anim-hidden" data-anim="anim-fade-up">
            <h4 class="subs-h"> Subscribe & Get 20% Off </h4>
            <p class="subs-p1"> Join with us and Enjoy 20% off your next adventure <br> 
                                and stay updated with the latest travel news, tips, and exclusive offers. <br> 
                                As a subscriber, you’ll be the first to know about trending hotspots,
                                hidden gems, seasonal deals.</p>
            <div class="subs-form">
                <form action="#" method="post" style="display: contents;">
                    <input type="email" id="email" name="email" placeholder="Email address">
                    <button class="em-btn" type="submit" name="send"> Submit </button><br>
                </form>
            </div>
            <p class="subs-p2"> Subscribe to Roaming Routes for more updates and promotions.</p>

        </div>
    </section>

    <!-- Sec-4 -->
    <section class="sec4">
        <p class="sec4-p anim-hidden" data-anim="anim-slide-left"> At Roaming Routes, <br> our core values  <br> guide our evolution: </p>
        <div class="sec4-d">
            <div class="cards">
                <div class="card1 anim-hidden" data-anim="anim-fade-up">
                    <p class="cp-h"> Passion For Exploration </p>
                    <p class="cp">
                        We believe that the world is meant to be explored with curiosity, excitement, and a sense of wonder. 
                        At the heart of everything we do is a deep passion for helping people discover new places, cultures, and perspectives. 
                    </p>
                </div>
                <div class="card2 anim-hidden" data-anim="anim-fade-up">
                    <p class="cp-h"> Trust & Transparency  </p>
                    <p class="cp">
                        Travel is a personal experience, and it requires trust. That’s why we are committed to complete transparency in everything 
                        we offer from honest destination insights to accurate pricing and real user reviews. 
                        We value your trust and work hard to earn it by ensuring that the information you see is authentic. 
                    </p>
                </div>
                <div class="card3 anim-hidden" data-anim="anim-fade-up">
                    <p class="cp-h"> Sustainable Travel </p>
                    <p class="cp">
                        We believe in travel that leaves a positive impact not just on the traveler, but on the world. 
                        Our commitment to sustainability means promoting experiences that respect local communities, preserve natural environments, and support cultural heritage. 
                    </p>
                </div>
            </div>
        </div>
    </section>

<!-- Scroll Animation Observer -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const animElements = document.querySelectorAll('.anim-hidden');
        
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    const animClass = entry.target.getAttribute('data-anim');
                    if (animClass) {
                        entry.target.classList.add(animClass);
                        entry.target.classList.remove('anim-hidden');
                    }
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15 });

        animElements.forEach(function(el) {
            observer.observe(el);
        });
    });
</script>

</body>
<?php include('includes/footer.php'); ?>