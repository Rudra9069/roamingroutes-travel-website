<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Inter:wght@400;600&family=Roboto&display=swap" rel="stylesheet">
  <title>Payment Success</title>
  <style>

    /* Card*/
    *{
        margin: 0;
        padding: 0;
    }

    body{
        margin: 0;
        padding: 90px 300px 90px 340px;
        /* background-color: ; */
        background: linear-gradient(to right,rgb(204, 167, 64),rgb(15, 65, 122));

    }

    .pay-suc-card {
        position: relative;
        background-color: #00203FFF;
        color: white;
        padding: 25px;
        border-radius: 20px;
        width: 100%;
        max-width: 800px;
        height: 90%;
        max-height: 450px;
        font-family: 'Poppins';
    }

    /* Title */
    .title{
        position: relative;
        text-align: center;
        margin-top: 10%;
        font-size: 25px;
        font-family: 'Poppins';
    }

    .pay-suc-card .imp {
        text-align: center;
        margin-top: 2%;
        font-family: 'Poppins';
        font-size: 18px;
    }

    /* Buttons */
    .btn{
        position: relative;
        margin-top: 5%;
        margin-left: 38%;
        text-decoration: none;
        height: 30px;
        width: 150px;
        outline: none;
        border: none;
        border-radius: 5px;
        text-align: center;
        display: inline-block;
        font-family: 'Poppins';
        font-size: 18px;
        font-weight: 600;
        background-color: rgb(237, 237, 236);
        color: black;
        padding: 1px 10px;
        transition: 0.3s;
    }

    .btn:hover {
        background-color: rgba(49, 191, 28, 0.78);
        color: white;
        height: 30px;
        width: 150px;
        border-radius: 20px;
    }

    /* Thank You Text */
    .pay-suc-card .thankyou-text {
        text-align: center;
        margin-top: 5%;
        font-size: 25px;
        font-family: 'Poppins';
    }

    /* Logo */
    .logo{
        position: relative;
        height: 55px;
        margin-left: 83%;
        margin-top: 7%;
    }
  </style>
</head>
<body>

<div class="card">
    <div class="pay-suc-card">
        <h2 class="title"> Payment Successfull ! ✅</h2>
        <p class="imp">Thankyou for booking with us. Your payment has been received.</p>
        <div>
            <a href="index.php" class="btn">Back to home</a>
        </div>
        <p class="thankyou-text">Thankyou, <br>Roaming Routes :) </p>
        <img class="logo" alt="popup-logo" src="img/logo/rr_logo.png"></img>
    </div>
</div>

</body>
</html>
