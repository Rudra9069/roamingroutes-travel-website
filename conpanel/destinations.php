<?php
include 'includes/auth.php';
require_once '../database/traveldb.php';

// Handle delete action
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "UPDATE destinations SET is_deleted = '1' WHERE id = $id");
    header("Location: destinations.php?msg=deleted");
    exit();
}

// Search functionality
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$where = $search ? "AND (name LIKE '%$search%' OR city LIKE '%$search%' OR state LIKE '%$search%')" : "";

$destinations = mysqli_query($conn, "SELECT * FROM destinations WHERE is_deleted = '0' $where ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Destinations - Admin Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="icon" href="../img/icon/Icon.ico">
    <style>
        .dest-image {
            width: 80px;
            height: 50px;
            object-fit: cover;
            border-radius: 6px;
        }
    </style>
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>
    
    <div class="main-content">
        <div class="page-header">
            <div>
                <h1 class="page-title">Destinations</h1>
                <p class="page-subtitle">Manage all travel destinations</p>
            </div>
            <a href="destination_add.php" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Destination
            </a>
        </div>
        
        <?php if (isset($_GET['msg'])): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <?php 
                    if ($_GET['msg'] == 'deleted') echo "Destination deleted successfully!";
                    if ($_GET['msg'] == 'added') echo "Destination added successfully!";
                    if ($_GET['msg'] == 'updated') echo "Destination updated successfully!";
                ?>
            </div>
        <?php endif; ?>
        
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">All Destinations (<?php echo mysqli_num_rows($destinations); ?>)</h3>
                <form method="GET" class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" placeholder="Search destinations..." value="<?php echo htmlspecialchars($search); ?>">
                </form>
            </div>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Location</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($destinations) > 0): ?>
                            <?php while ($dest = mysqli_fetch_assoc($destinations)): ?>
                            <?php 
                                $images = explode(',', $dest['images']);
                                $firstImage = trim($images[0]);
                            ?>
                            <tr>
                                <td>
                                    <img src="../img/destinations/<?php echo $firstImage; ?>" alt="<?php echo htmlspecialchars($dest['name']); ?>" class="dest-image">
                                </td>
                                <td>
                                    <strong><?php echo htmlspecialchars($dest['name']); ?></strong>
                                </td>
                                <td>
                                    <div style="color: var(--text-secondary);">
                                        <?php echo htmlspecialchars($dest['city']); ?>, <?php echo htmlspecialchars($dest['state']); ?>
                                    </div>
                                    <div style="font-size: 0.8rem; color: var(--text-muted);">
                                        <?php echo htmlspecialchars($dest['country']); ?>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-info"><?php echo htmlspecialchars($dest['category'] ?? 'General'); ?></span>
                                </td>
                                <td>₹<?php echo number_format($dest['price_range']); ?></td>
                                <td>
                                    <div class="action-btns">
                                        <a href="destination_edit.php?id=<?php echo $dest['id']; ?>" class="action-btn edit" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="action-btn delete" title="Delete" onclick="confirmDelete(<?php echo $dest['id']; ?>)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 40px;">
                                    <i class="fas fa-map-marker-alt" style="font-size: 2rem; margin-bottom: 10px; display: block;"></i>
                                    No destinations found
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
            <p style="color: var(--text-secondary);">Are you sure you want to delete this destination? This action cannot be undone.</p>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeModal()">Cancel</button>
                <a id="deleteLink" href="#" class="btn btn-danger">Delete</a>
            </div>
        </div>
    </div>
    
    <script>
        function confirmDelete(id) {
            document.getElementById('deleteLink').href = 'destinations.php?delete=' + id;
            document.getElementById('deleteModal').classList.add('active');
        }
        
        function closeModal() {
            document.getElementById('deleteModal').classList.remove('active');
        }
    </script>
</body>
</html>
