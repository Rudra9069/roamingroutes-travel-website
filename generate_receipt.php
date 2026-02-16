<?php
session_start();
include('database/traveldb.php');

// Check if user is logged in
if (!isset($_SESSION['u_id'])) {
    die("Access denied.");
}

if (!isset($_GET['razorpay_id'])) {
    die("Invalid request.");
}

$u_id = $_SESSION['u_id'];
$razorpay_id = $_GET['razorpay_id'];

// Fetch payment, user, and destination details
$query = "SELECT p.*, d.name as dest_name, d.city, d.state, d.country, u.name as user_name, u.email as user_email, u.contactno 
          FROM payments p 
          JOIN destinations d ON p.destination_id = d.id 
          JOIN users u ON p.u_id = u.u_id 
          WHERE p.razorpay_id = ? AND p.u_id = ? 
          LIMIT 1";

$stmt = $conn->prepare($query);
$stmt->bind_param("si", $razorpay_id, $u_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    die("Receipt not found or access denied.");
}

$data = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt - #<?php echo $data['razorpay_id']; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Cinzel:wght@700&display=swap" rel="stylesheet">
    <style>
        :root {
            --navy: #1a2341;
            --gold: #d1ad72;
            --light: #f4f4f4;
            --dark-navy: #151b33;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 40px;
            color: #333;
        }

        .receipt-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 50px;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            position: relative;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid var(--gold);
            padding-bottom: 30px;
            margin-bottom: 40px;
        }

        .brand h1 {
            font-family: 'Cinzel', serif;
            color: var(--navy);
            margin: 0;
            font-size: 28px;
            letter-spacing: 2px;
        }

        .brand p {
            margin: 5px 0 0 0;
            color: var(--gold);
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .invoice-meta {
            text-align: right;
        }

        .invoice-meta h2 {
            margin: 0;
            color: var(--navy);
            font-size: 22px;
        }

        .invoice-meta p {
            margin: 5px 0 0 0;
            color: #777;
        }

        .details-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-bottom: 40px;
        }

        .details-section h3 {
            font-size: 14px;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 15px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }

        .details-section p {
            margin: 5px 0;
            line-height: 1.6;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }

        .items-table th {
            background-color: var(--navy);
            color: white;
            padding: 15px;
            text-align: left;
            text-transform: uppercase;
            font-size: 12px;
        }

        .items-table td {
            padding: 15px;
            border-bottom: 1px solid #eee;
        }

        .total-section {
            display: flex;
            justify-content: flex-end;
        }

        .total-box {
            width: 250px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
        }

        .total-row.grand-total {
            border-top: 2px solid var(--navy);
            margin-top: 10px;
            font-weight: 700;
            font-size: 20px;
            color: var(--navy);
        }

        .paid-stamp {
            position: absolute;
            top: 200px;
            right: 50px;
            border: 4px solid #2ecc71;
            color: #2ecc71;
            padding: 10px 20px;
            font-size: 30px;
            font-weight: 800;
            text-transform: uppercase;
            transform: rotate(-15deg);
            opacity: 0.3;
            pointer-events: none;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            color: #999;
            font-size: 12px;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }

        .no-print {
            margin-bottom: 20px;
            text-align: center;
        }

        .no-print button {
            background-color: var(--navy);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }

    @media (max-width: 768px) {
        body { padding: 15px; }
        .receipt-container { padding: 25px; }
        .header { flex-direction: column; align-items: center; text-align: center; }
        .invoice-meta { text-align: center; margin-top: 20px; }
        .details-grid { grid-template-columns: 1fr; gap: 25px; }
        .items-table, .items-table thead, .items-table tbody, .items-table th, .items-table td, .items-table tr { 
            display: block; 
        }
        .items-table thead tr { position: absolute; top: -9999px; left: -9999px; }
        .items-table tr { border: 1px solid #eee; margin-bottom: 10px; }
        .items-table td { border: none; position: relative; padding-left: 50%; text-align: right; }
        .items-table td:before { 
            position: absolute; top: 15px; left: 15px; width: 45%; padding-right: 10px; 
            white-space: nowrap; text-align: left; font-weight: bold; color: var(--gold);
        }
        .items-table td:nth-of-type(1):before { content: "Description"; }
        .items-table td:nth-of-type(2):before { content: "Destination"; }
        .items-table td:nth-of-type(3):before { content: "Amount"; }
        .total-section { justify-content: center; }
        .total-box { width: 100%; }
        .paid-stamp { top: 150px; right: 20px; font-size: 24px; opacity: 0.2; }
    }

    @media print {
        body { padding: 0; background: white; }
        .receipt-container { box-shadow: none; border: none; }
        .no-print { display: none; }
    }
</style>
</head>
<body>

    <div class="no-print">
        <button onclick="window.print()">Print or Save as PDF</button>
        <button onclick="window.close()" style="background: #777; margin-left: 10px;">Close Window</button>
    </div>

    <div class="receipt-container">
        <div class="paid-stamp">PAID</div>
        
        <div class="header">
            <div class="brand">
                <h1>ROAMING ROUTES</h1>
                <p>Luxury Travel & Curated Experiences</p>
            </div>
            <div class="invoice-meta">
                <h2>INVOICE</h2>
                <p>#<?php echo $data['razorpay_id']; ?></p>
                <p>Date: <?php echo date('d M, Y', strtotime($data['created_at'])); ?></p>
            </div>
        </div>

        <div class="details-grid">
            <div class="details-section">
                <h3>Bill To:</h3>
                <p><strong><?php echo htmlspecialchars($data['user_name']); ?></strong></p>
                <p><?php echo htmlspecialchars($data['user_email']); ?></p>
                <p><?php echo htmlspecialchars($data['contactno']); ?></p>
            </div>
            <div class="details-section">
                <h3>Issued By:</h3>
                <p><strong>Roaming Routes Pvt Ltd.</strong></p>
                <p>G-1 Krishna Sadan, Pranami Street</p>
                <p>Valsad, Gujarat - 396001</p>
            </div>
        </div>

        <h3>Booking Details</h3>
        <table class="items-table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Destination</th>
                    <th style="text-align: right;">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <strong><?php echo htmlspecialchars($data['dest_name']); ?> Travel Package</strong><br>
                        <small><?php echo htmlspecialchars($data['city']); ?>, <?php echo htmlspecialchars($data['country']); ?></small>
                    </td>
                    <td><?php echo htmlspecialchars($data['dest_name']); ?></td>
                    <td style="text-align: right;">₹<?php echo number_format($data['amount']); ?></td>
                </tr>
            </tbody>
        </table>

        <div class="total-section">
            <div class="total-box">
                <div class="total-row">
                    <span>Subtotal:</span>
                    <span>₹<?php echo number_format($data['amount']); ?></span>
                </div>
                <div class="total-row">
                    <span>GST (0%):</span>
                    <span>₹0</span>
                </div>
                <div class="total-row grand-total">
                    <span>Total Paid:</span>
                    <span>₹<?php echo number_format($data['amount']); ?></span>
                </div>
            </div>
        </div>

        <div class="footer">
            <p>Thank you for choosing Roaming Routes for your adventure.</p>
            <p>&copy; 2026 Roaming Routes Pvt Ltd. This is a computer-generated document.</p>
        </div>
    </div>

</body>
</html>
