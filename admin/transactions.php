<?php
include 'includes/auth.php';
require_once '../database/traveldb.php';

// Check if payments table exists
$table_exists = mysqli_query($conn, "SHOW TABLES LIKE 'payments'");

$transactions = null;
$total = 0;

if (mysqli_num_rows($table_exists) > 0) {
    // Search and filter
    $search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
    $status_filter = isset($_GET['status']) ? mysqli_real_escape_string($conn, $_GET['status']) : '';
    
    $where = "WHERE 1=1";
    if ($search) {
        $where .= " AND (p.name LIKE '%$search%' OR p.email LIKE '%$search%' OR d.name LIKE '%$search%')";
    }
    if ($status_filter) {
        $where .= " AND p.status = '$status_filter'";
    }
    
    $transactions = mysqli_query($conn, "
        SELECT p.*, u.name as user_name, d.name as dest_name 
        FROM payments p 
        LEFT JOIN users u ON p.u_id = u.u_id 
        LEFT JOIN destinations d ON p.destination_id = d.id 
        $where
        ORDER BY p.id DESC
    ");
    $total = mysqli_num_rows($transactions);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transactions - Admin Panel</title>
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
                <h1 class="page-title">Transactions</h1>
                <p class="page-subtitle">View all payment transactions</p>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header" style="flex-wrap: wrap; gap: 15px;">
                <h3 class="card-title">All Transactions (<?php echo $total; ?>)</h3>
                <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                    <form method="GET" class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" name="search" placeholder="Search..." value="<?php echo htmlspecialchars($search ?? ''); ?>">
                    </form>
                    <form method="GET">
                        <select name="status" class="form-control" style="padding: 10px 15px; min-width: 150px;" onchange="this.form.submit()">
                            <option value="">All Status</option>
                            <option value="captured" <?php echo ($status_filter ?? '') == 'captured' ? 'selected' : ''; ?>>Captured</option>
                            <option value="authorized" <?php echo ($status_filter ?? '') == 'authorized' ? 'selected' : ''; ?>>Authorized</option>
                            <option value="failed" <?php echo ($status_filter ?? '') == 'failed' ? 'selected' : ''; ?>>Failed</option>
                        </select>
                    </form>
                </div>
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
                            <th>Razorpay ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($transactions && mysqli_num_rows($transactions) > 0): ?>
                            <?php while ($txn = mysqli_fetch_assoc($transactions)): ?>
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
                                <td style="font-weight: 600; color: var(--accent);">₹<?php echo number_format($txn['amount']); ?></td>
                                <td>
                                    <?php
                                    $status = $txn['status'];
                                    $badge_class = 'badge-info';
                                    if ($status == 'captured' || $status == 'authorized') $badge_class = 'badge-success';
                                    else if ($status == 'failed') $badge_class = 'badge-danger';
                                    else if ($status == 'pending') $badge_class = 'badge-warning';
                                    ?>
                                    <span class="badge <?php echo $badge_class; ?>">
                                        <?php echo ucfirst($status); ?>
                                    </span>
                                </td>
                                <td style="font-size: 0.8rem; color: var(--text-muted);">
                                    <?php echo htmlspecialchars($txn['razorpay_id'] ?? 'N/A'); ?>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 40px;">
                                    <i class="fas fa-credit-card" style="font-size: 2rem; margin-bottom: 10px; display: block;"></i>
                                    <?php if (mysqli_num_rows($table_exists) == 0): ?>
                                        Payments table not found. Transactions will appear here once payments are made.
                                    <?php else: ?>
                                        No transactions found
                                    <?php endif; ?>
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
