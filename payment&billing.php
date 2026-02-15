<?php

session_start();
include('database/traveldb.php');

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    echo "<h3>Please log in to view your profile.</h3>";
    exit;
}

// Get email from session
$email = $_SESSION['email'];

// Fetch user info from database
$query = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
} else {
    echo "<script> alert('User not found') </script>";
}

?>

<?php include('includes/header.php'); ?>
<style>
:root {
    --bg-dark: #1e2433;
    --bg-card: #262d40;
    --accent: #d1ad72;
    --text-light: #eaeaea;
    --text-muted: #a5a8b1;
}

body {
    background: #040d22ff;
    font-family: 'Poppins', sans-serif;
}

.profile-wrapper {
    max-width: 1200px;
    margin: 100px 10px 50px 90px;
    background: var(--bg-card);
    border-radius: 16px;
    display: grid;
    grid-template-columns: 260px 1fr;
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(0,0,0,0.25);
}

/* Sidebar */
.profile-sidebar {
    background: var(--bg-dark);
    padding: 30px 20px;
}

.profile-sidebar h2 {
    color: var(--accent);
    font-size: 22px;
    margin-bottom: 30px;
}

.profile-sidebar a {
    display: block;
    color: var(--text-light);
    text-decoration: none;
    padding: 12px 10px;
    border-radius: 8px;
    margin-bottom: 10px;
    transition: 0.3s;
}

.profile-sidebar a:hover,
.profile-sidebar a.active {
    background: rgba(209,173,114,0.15);
    color: var(--accent);
}

/* Content */
.profile-content {
    padding: 40px;
    color: var(--text-light);
}

.profile-content h3 {
    color: var(--accent);
    margin-bottom: 30px;
}

/* Billing placeholder card */
.billing-card {
    background: rgba(255,255,255,0.04);
    border: 1px dashed rgba(209,173,114,0.4);
    border-radius: 14px;
    padding: 40px;
    text-align: center;
}

.billing-card p {
    font-size: 18px;
    margin-bottom: 8px;
}

.billing-card span {
    color: var(--text-muted);
    font-size: 14px;
}

/* Responsiveness Media Queries */
@media (max-width: 992px) {
    .profile-wrapper {
        grid-template-columns: 1fr;
        margin: 80px 15px 40px 15px;
    }
    .profile-sidebar {
        display: flex;
        overflow-x: auto;
        gap: 10px;
        padding: 20px;
        scrollbar-width: none;
    }
    .profile-sidebar::-webkit-scrollbar { display: none; }
    .profile-sidebar h2 { display: none; }
    .profile-sidebar a {
        flex-shrink: 0;
        margin-bottom: 0;
        padding: 8px 15px;
        white-space: nowrap;
    }
    .profile-content { padding: 30px 20px; }
}

@media (max-width: 600px) {
    .billing-card-real { flex-direction: column; }
    .billing-card-img { width: 100%; height: 180px; }
    .footer-row { flex-direction: column; align-items: flex-start; gap: 15px; }
    .footer-actions { width: 100%; justify-content: space-between; }
}
</style>

<div class="profile-wrapper">

    <!-- Sidebar -->
    <div class="profile-sidebar">
        <h2>My Account</h2>
        <a href="profile.php">Profile</a>
        <a href="history.php">Travel History</a>
        <a href="payment&billing.php" class="active">Payment & Billing</a>
        <a href="settings.php">Settings</a>
        <a href="help.php">Help</a>
        <a href="../index.php">Logout</a>
    </div>

    <!-- Content -->
    <div class="profile-content">
        <h3>Payment & Billing</h3>

        <div class="billing-container">
            <?php
            // Fetch payments and joined destination info for the logged-in user
            $u_id = $_SESSION['u_id'];
            $payment_query = "SELECT p.*, d.name as dest_name, d.city, d.images 
                             FROM payments p 
                             JOIN destinations d ON p.destination_id = d.id 
                             WHERE p.u_id = ? 
                             ORDER BY p.created_at DESC";
            
            $p_stmt = $conn->prepare($payment_query);
            $p_stmt->bind_param("i", $u_id);
            $p_stmt->execute();
            $p_result = $p_stmt->get_result();

            if ($p_result->num_rows > 0):
                while ($payment = $p_result->fetch_assoc()):
                    $imgList = explode(',', $payment['images']);
                    $displayImg = trim($imgList[0]);
            ?>
                <div class="billing-card-real">
                    <div class="billing-card-img">
                        <img src="img/destinations/<?php echo $displayImg; ?>" alt="Destination">
                    </div>
                    <div class="billing-card-info">
                        <div class="header-row">
                            <span class="invoice-id">#<?php echo $payment['razorpay_id']; ?></span>
                            <span class="payment-status <?php echo strtolower($payment['status']); ?>">
                                <?php echo ucfirst($payment['status']); ?>
                            </span>
                        </div>
                        <h4><?php echo htmlspecialchars($payment['dest_name']); ?></h4>
                        <p class="billing-loc"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($payment['city']); ?></p>
                        <div class="footer-row">
                            <span class="billing-date"><i class="far fa-calendar-alt"></i> <?php echo date('d M, Y', strtotime($payment['created_at'])); ?></span>
                            <div class="footer-actions">
                                <a href="generate_receipt.php?razorpay_id=<?php echo $payment['razorpay_id']; ?>" class="receipt-link-small" target="_blank">
                                    <i class="fas fa-file-invoice"></i> Receipt
                                </a>
                                <span class="billing-price">₹<?php echo number_format($payment['amount']); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
            <?php else: ?>
                <!-- Placeholder / empty state -->
                <div class="billing-card">
                    <p>No billing records yet</p>
                    <span>Your invoices and payments will appear here.</span>
                </div>
            <?php endif; ?>
        </div>
    </div>

</div>

<style>
/* New styles for real billing cards */
.billing-container {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.billing-card-real {
    background: rgba(255,255,255,0.03);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 15px;
    display: flex;
    overflow: hidden;
    transition: 0.3s;
}

.billing-card-real:hover {
    background: rgba(255,255,255,0.06);
    transform: translateX(5px);
}

.billing-card-img {
    width: 150px;
    height: 120px;
}

.billing-card-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.billing-card-info {
    flex: 1;
    padding: 15px 20px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.header-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 5px;
}

.invoice-id {
    font-family: 'Montserrat';
    font-size: 11px;
    color: var(--text-muted);
    letter-spacing: 0.5px;
}

.payment-status {
    font-size: 10px;
    padding: 3px 10px;
    border-radius: 20px;
    font-weight: 600;
    text-transform: uppercase;
}

.payment-status.captured, .payment-status.authorized {
    background: rgba(46, 204, 113, 0.2);
    color: #2ecc71;
}

.billing-card-info h4 {
    margin: 0;
    font-size: 18px;
    color: var(--accent);
}

.billing-loc {
    margin: 2px 0;
    font-size: 13px;
    color: var(--text-muted);
}

.footer-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 10px;
}

.billing-date {
    font-size: 12px;
    color: var(--text-muted);
}

.footer-actions {
    display: flex;
    align-items: center;
    gap: 15px;
}

.receipt-link-small {
    color: var(--accent);
    text-decoration: none;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 4px 10px;
    border: 1px solid rgba(209, 173, 114, 0.3);
    border-radius: 4px;
    transition: 0.3s;
}

.receipt-link-small:hover {
    background: rgba(209, 173, 114, 0.1);
    border-color: var(--accent);
}

.billing-price {
    font-size: 20px;
    font-weight: 700;
    color: var(--text-light);
}
</style>

<?php include('includes/footer.php'); ?>

<?php include('includes/footer.php'); ?>