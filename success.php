<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&family=Montserrat:wght@700&display=swap" rel="stylesheet">
    <title>Payment Successful - Roaming Routes</title>
    <style>
        :root {
            --navy: #0f172a;
            --gold: #ba7e1eff;
            --white: #ffffff;
            --success: #22c55e;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background-color: var(--navy);
            font-family: 'Poppins', sans-serif;
            color: var(--white);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: radial-gradient(circle at top right, rgba(210, 182, 138, 0.1), transparent),
                        radial-gradient(circle at bottom left, rgba(15, 23, 42, 1), #000);
        }

        .success-card {
            width: 100%;
            max-width: 600px;
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 30px;
            padding: 60px 40px;
            text-align: center;
            box-shadow: 0 40px 100px rgba(0,0,0,0.5);
            animation: slideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .icon-box {
            width: 100px;
            height: 100px;
            background: rgba(34, 197, 94, 0.1);
            border: 2px solid var(--success);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            font-size: 45px;
            color: var(--success);
            animation: scaleIn 0.5s 0.3s both cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        @keyframes scaleIn {
            from { transform: scale(0); }
            to { transform: scale(1); }
        }

        h2 {
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 15px;
            color: var(--gold);
        }

        .message {
            font-size: 16px;
            color: rgba(255,255,255,0.7);
            line-height: 1.6;
            margin-bottom: 40px;
        }

        .message a {
            color: var(--gold);
            font-weight: 600;
            text-decoration: none;
            border-bottom: 1px dashed var(--gold);
            transition: 0.3s;
        }

        .message a:hover { color: #fff; border-color: #fff; }

        .btn-group {
            display: flex;
            flex-direction: column;
            gap: 15px;
            align-items: center;
        }

        .btn-primary {
            background: var(--gold);
            color: var(--navy);
            text-decoration: none;
            padding: 16px 40px;
            border-radius: 12px;
            font-weight: 800;
            font-size: 16px;
            transition: 0.3s;
            width: 100%;
            max-width: 250px;
        }

        .btn-primary:hover {
            background: #e5cc9f;
            transform: translateY(-2px);
        }

        .thanks-text {
            margin-top: 50px;
            font-family: 'Montserrat', sans-serif;
            font-size: 14px;
            letter-spacing: 2px;
            color: rgba(255,255,255,0.3);
            text-transform: uppercase;
        }

        .logo {
            height: 50px;
            margin-top: 30px;
            opacity: 0.5;
        }

        @media (max-width: 576px) {
            .success-card { padding: 40px 25px; }
            h2 { font-size: 26px; }
            .icon-box { width: 80px; height: 80px; font-size: 35px; }
        }
    </style>
</head>
<body>

<div class="success-card">
    <div class="icon-box">
        <i class="fa-solid fa-check"></i>
    </div>
    <h2>Booking Confirmed!</h2>
    <p class="message">
        Thank you for choosing Roaming Routes. Your payment has been successfully processed and your journey is officially booked.
        <?php if(isset($_GET['razorpay_id'])): ?>
            <br><br>
            <a href="generate_receipt.php?razorpay_id=<?php echo htmlspecialchars($_GET['razorpay_id']); ?>" target="_blank">
                <i class="fas fa-file-invoice"></i> Download your official booking receipt
            </a>
        <?php endif; ?>
    </p>

    <div class="btn-group">
        <a href="index.php" class="btn-primary">Back to Home</a>
    </div>

    <p class="thanks-text">Roaming Routes</p>
    <img class="logo" alt="Roaming Routes" src="img/logo/rr_logo_2.png">
</div>

</body>
</html>
