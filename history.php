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

.history-container {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.history-card-real {
    background: rgba(255,255,255,0.03);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 15px;
    display: flex;
    overflow: hidden;
    transition: 0.3s;
}

.history-card-real:hover {
    background: rgba(255,255,255,0.06);
    transform: translateX(5px);
}

.trip-img {
    width: 140px;
    height: 100px;
}

.trip-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.trip-details {
    flex: 1;
    padding: 15px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.trip-main h4 {
    margin: 0;
    font-size: 18px;
    color: var(--accent);
}

.trip-loc {
    margin: 5px 0 0 0;
    font-size: 13px;
    color: var(--text-muted);
}

.trip-meta {
    text-align: right;
    display: flex;
    flex-direction: column;
    gap: 8px;
    align-items: flex-end;
}

.trip-date {
    font-size: 12px;
    color: var(--text-muted);
}

.receipt-btn {
    display: inline-block;
    color: var(--accent);
    text-decoration: none;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 6px 12px;
    border: 1px solid rgba(209, 173, 114, 0.4);
    border-radius: 4px;
    transition: 0.3s;
}

.receipt-btn:hover {
    background: rgba(209, 173, 114, 0.1);
    border-color: var(--accent);
}

.empty-history {
    background: rgba(255,255,255,0.04);
    border: 1px dashed rgba(209,173,114,0.4);
    border-radius: 14px;
    padding: 40px;
    text-align: center;
}

.empty-history i {
    font-size: 40px;
    color: var(--accent);
    opacity: 0.3;
    margin-bottom: 20px;
}

.empty-history p {
    font-size: 18px;
    margin-bottom: 8px;
}

.empty-history span {
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
    .history-card-real { flex-direction: column; }
    .trip-img { width: 100%; height: 180px; }
    .trip-details { flex-direction: column; align-items: flex-start; gap: 15px; }
    .trip-meta { width: 100%; flex-direction: row; justify-content: space-between; align-items: center; }
}
</style>

<div class="profile-wrapper">

    <!-- Sidebar -->
    <div class="profile-sidebar">
        <h2>My Account</h2>
        <a href="profile.php">Profile</a>
        <a href="history.php" class="active">Travel History</a>
        <a href="payment&billing.php">Payment & Billing</a>
        <a href="settings.php">Settings</a>
        <a href="help.php">Help</a>
        <a href="../index.php">Logout</a>
    </div>

    <!-- Content -->
    <div class="profile-content">
        <h3>Travel History</h3>

        <div class="history-container">
            <?php
            $u_id = $_SESSION['u_id'];
            $history_query = "SELECT p.*, d.name as dest_name, d.city, d.images 
                             FROM payments p 
                             JOIN destinations d ON p.destination_id = d.id 
                             WHERE p.u_id = ? 
                             ORDER BY p.created_at DESC";
            
            $h_stmt = $conn->prepare($history_query);
            $h_stmt->bind_param("i", $u_id);
            $h_stmt->execute();
            $h_result = $h_stmt->get_result();

            if ($h_result->num_rows > 0):
                while ($trip = $h_result->fetch_assoc()):
                    $imgList = explode(',', $trip['images']);
                    $displayImg = trim($imgList[0]);
            ?>
                <div class="history-card-real">
                    <div class="trip-img">
                        <img src="img/destinations/<?php echo $displayImg; ?>" alt="Trip" loading="lazy" decoding="async">
                    </div>
                    <div class="trip-details">
                        <div class="trip-main">
                            <h4><?php echo htmlspecialchars($trip['dest_name']); ?></h4>
                            <p class="trip-loc"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($trip['city']); ?></p>
                        </div>
                        <div class="trip-meta">
                            <span class="trip-date"><i class="far fa-calendar-check"></i> <?php echo date('d M, Y', strtotime($trip['created_at'])); ?></span>
                            <a href="generate_receipt.php?razorpay_id=<?php echo $trip['razorpay_id']; ?>" class="receipt-btn" target="_blank">
                                <i class="fas fa-file-invoice"></i> Receipt
                            </a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
            <?php else: ?>
                <div class="empty-history">
                    <i class="fas fa-plane-departure"></i>
                    <p>No trips yet</p>
                    <span>Your adventures will appear here.</span>
                </div>
            <?php endif; ?>
        </div>
    </div>

</div>


<?php include('includes/footer.php'); ?>