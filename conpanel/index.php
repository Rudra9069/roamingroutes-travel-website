<?php
include 'includes/auth.php';
require_once '../database/traveldb.php';

// Get statistics
$users_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM users"))['count'];
$destinations_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM destinations WHERE is_deleted = '0'"))['count'];

// Check if payments table exists and get stats
$payments_result = mysqli_query($conn, "SHOW TABLES LIKE 'payments'");
if (mysqli_num_rows($payments_result) > 0) {
    $transactions_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM payments"))['count'];
    $total_revenue = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COALESCE(SUM(amount), 0) as total FROM payments WHERE status = 'captured' OR status = 'authorized'"))['total'];
    $recent_transactions = mysqli_query($conn, "SELECT p.*, u.name as user_name, d.name as dest_name 
                                                FROM payments p 
                                                LEFT JOIN users u ON p.u_id = u.u_id 
                                                LEFT JOIN destinations d ON p.destination_id = d.id 
                                                ORDER BY p.id DESC LIMIT 5");
} else {
    $transactions_count = 0;
    $total_revenue = 0;
    $recent_transactions = null;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Admin Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="icon" href="../img/icon/Icon.ico">
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>
    
    <div class="main-content">
        <div class="page-header">
            <div>
                <h1 class="page-title">Dashboard</h1>
                <p class="page-subtitle">Welcome back, Admin! Here's what's happening today.</p>
            </div>
        </div>
        
        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="icon users">
                    <i class="fas fa-users"></i>
                </div>
                <div class="value"><?php echo number_format($users_count); ?></div>
                <div class="label">Total Users</div>
            </div>
            
            <div class="stat-card">
                <div class="icon destinations">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div class="value"><?php echo number_format($destinations_count); ?></div>
                <div class="label">Destinations</div>
            </div>
            
            <div class="stat-card">
                <div class="icon revenue">
                    <i class="fas fa-indian-rupee-sign"></i>
                </div>
                <div class="value">₹<?php echo number_format($total_revenue); ?></div>
                <div class="label">Total Revenue</div>
            </div>
            
            <div class="stat-card">
                <div class="icon transactions">
                    <i class="fas fa-credit-card"></i>
                </div>
                <div class="value"><?php echo number_format($transactions_count); ?></div>
                <div class="label">Transactions</div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="card" style="margin-bottom: 30px;">
            <div class="card-header">
                <h3 class="card-title">Quick Actions</h3>
            </div>
            <div class="card-body" style="display: flex; gap: 15px; flex-wrap: wrap;">
                <a href="destination_add.php" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add Destination
                </a>
                <a href="users.php" class="btn btn-secondary">
                    <i class="fas fa-users"></i> Manage Users
                </a>
                <a href="transactions.php" class="btn btn-secondary">
                    <i class="fas fa-chart-line"></i> View Transactions
                </a>
            </div>
        </div>
        
        <!-- Recent Transactions -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Recent Transactions</h3>
                <a href="transactions.php" class="btn btn-sm btn-secondary">View All</a>
            </div>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Destination</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($recent_transactions && mysqli_num_rows($recent_transactions) > 0): ?>
                            <?php while ($txn = mysqli_fetch_assoc($recent_transactions)): ?>
                            <tr>
                                <td>#<?php echo $txn['id']; ?></td>
                                <td>
                                    <div class="user-info">
                                        <div class="avatar"><?php echo strtoupper(substr($txn['name'] ?? 'G', 0, 1)); ?></div>
                                        <div>
                                            <div class="name"><?php echo htmlspecialchars($txn['name'] ?? 'Guest'); ?></div>
                                            <div class="email"><?php echo htmlspecialchars($txn['email']); ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td><?php echo htmlspecialchars($txn['dest_name'] ?? 'N/A'); ?></td>
                                <td>₹<?php echo number_format($txn['amount']); ?></td>
                                <td>
                                    <span class="badge <?php echo ($txn['status'] == 'captured' || $txn['status'] == 'authorized') ? 'badge-success' : 'badge-warning'; ?>">
                                        <?php echo ucfirst($txn['status']); ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="text-align: center; color: var(--text-muted); padding: 40px;">
                                    <i class="fas fa-inbox" style="font-size: 2rem; margin-bottom: 10px; display: block;"></i>
                                    No transactions yet
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
