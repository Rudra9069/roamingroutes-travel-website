<?php
include 'includes/auth.php';
require_once '../database/traveldb.php';

// Handle delete action
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM users WHERE u_id = $id");
    header("Location: users.php?msg=deleted");
    exit();
}

// Search functionality
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$where = $search ? "WHERE name LIKE '%$search%' OR email LIKE '%$search%'" : "";

$users = mysqli_query($conn, "SELECT * FROM users $where ORDER BY u_id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users - Admin Panel</title>
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
                <h1 class="page-title">Users</h1>
                <p class="page-subtitle">Manage all registered users</p>
            </div>
        </div>
        
        <?php if (isset($_GET['msg'])): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <?php 
                    if ($_GET['msg'] == 'deleted') echo "User deleted successfully!";
                    if ($_GET['msg'] == 'updated') echo "User updated successfully!";
                ?>
            </div>
        <?php endif; ?>
        
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">All Users (<?php echo mysqli_num_rows($users); ?>)</h3>
                <form method="GET" class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" placeholder="Search users..." value="<?php echo htmlspecialchars($search); ?>">
                </form>
            </div>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Contact</th>
                            <th>DOB</th>
                            <th>Verified</th>
                            <th>Joined</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($users) > 0): ?>
                            <?php while ($user = mysqli_fetch_assoc($users)): ?>
                            <tr>
                                <td>#<?php echo $user['u_id']; ?></td>
                                <td>
                                    <div class="user-info">
                                        <div class="avatar"><?php echo strtoupper(substr($user['name'], 0, 1)); ?></div>
                                        <div>
                                            <div class="name"><?php echo htmlspecialchars($user['name']); ?></div>
                                            <div class="email"><?php echo htmlspecialchars($user['email']); ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td><?php echo htmlspecialchars($user['contactno']); ?></td>
                                <td><?php echo date('d M Y', strtotime($user['dob'])); ?></td>
                                <td>
                                    <span class="badge <?php echo $user['is_verified'] ? 'badge-success' : 'badge-warning'; ?>">
                                        <?php echo $user['is_verified'] ? 'Verified' : 'Pending'; ?>
                                    </span>
                                </td>
                                <td><?php echo date('d M Y', strtotime($user['created_at'])); ?></td>
                                <td>
                                    <div class="action-btns">
                                        <a href="user_edit.php?id=<?php echo $user['u_id']; ?>" class="action-btn edit" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="action-btn delete" title="Delete" onclick="confirmDelete(<?php echo $user['u_id']; ?>)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" style="text-align: center; color: var(--text-muted); padding: 40px;">
                                    <i class="fas fa-users" style="font-size: 2rem; margin-bottom: 10px; display: block;"></i>
                                    No users found
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal-overlay">
        <div class="modal">
            <div class="modal-header">
                <h3 class="modal-title">Confirm Delete</h3>
                <button class="modal-close" onclick="closeModal()">&times;</button>
            </div>
            <p style="color: var(--text-secondary);">Are you sure you want to delete this user? This action cannot be undone.</p>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeModal()">Cancel</button>
                <a id="deleteLink" href="#" class="btn btn-danger">Delete</a>
            </div>
        </div>
    </div>
    
    <script>
        function confirmDelete(id) {
            document.getElementById('deleteLink').href = 'users.php?delete=' + id;
            document.getElementById('deleteModal').classList.add('active');
        }
        
        function closeModal() {
            document.getElementById('deleteModal').classList.remove('active');
        }
    </script>
</body>
</html>
