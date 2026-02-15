<div class="sidebar">
    <div class="sidebar-logo">
        <img src="../img/logo/rr_logo_white.png" alt="Roaming Routes">
        <h2>Admin Panel</h2>
    </div>
    
    <nav class="sidebar-nav">
        <a href="index.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">
            <i class="fas fa-th-large"></i>
            Dashboard
        </a>
        <a href="users.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'users.php' ? 'active' : ''; ?>">
            <i class="fas fa-users"></i>
            Users
        </a>
        <a href="destinations.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'destinations.php' || basename($_SERVER['PHP_SELF']) == 'destination_add.php' || basename($_SERVER['PHP_SELF']) == 'destination_edit.php' ? 'active' : ''; ?>">
            <i class="fas fa-map-marker-alt"></i>
            Destinations
        </a>
        <a href="transactions.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'transactions.php' ? 'active' : ''; ?>">
            <i class="fas fa-credit-card"></i>
            Transactions
        </a>
    </nav>
    
    <div class="sidebar-footer">
        <a href="logout.php" class="logout-btn">
            <i class="fas fa-sign-out-alt"></i>
            Logout
        </a>
    </div>
</div>
