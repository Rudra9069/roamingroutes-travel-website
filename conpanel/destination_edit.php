<?php
include 'includes/auth.php';
require_once '../database/traveldb.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (!$id) {
    header("Location: destinations.php");
    exit();
}

// Get destination data
$result = mysqli_query($conn, "SELECT * FROM destinations WHERE id = $id");
$dest = mysqli_fetch_assoc($result);

if (!$dest) {
    header("Location: destinations.php");
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $state = mysqli_real_escape_string($conn, $_POST['state']);
    $country = mysqli_real_escape_string($conn, $_POST['country']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $price_range = mysqli_real_escape_string($conn, $_POST['price_range']);
    $keywords = mysqli_real_escape_string($conn, $_POST['keywords']);
    $images = mysqli_real_escape_string($conn, $_POST['images']);
    $reviews = mysqli_real_escape_string($conn, $_POST['reviews']);
    $ratings = intval($_POST['ratings']);
    
    $sql = "UPDATE destinations SET 
            name = '$name', 
            description = '$description', 
            images = '$images',
            city = '$city', 
            state = '$state', 
            country = '$country',
            category = '$category',
            price_range = '$price_range',
            keywords = '$keywords',
            reviews = '$reviews',
            ratings = '$ratings'
            WHERE id = $id";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: destinations.php?msg=updated");
        exit();
    } else {
        $error = "Error updating destination: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Destination - Admin Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="icon" href="../img/icon/Icon.ico">
    <style>
        .preview-images {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 10px;
        }
        .preview-images img {
            width: 100px;
            height: 70px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid var(--border);
        }
    </style>
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>
    
    <div class="main-content">
        <div class="page-header">
            <div>
                <h1 class="page-title">Edit Destination</h1>
                <p class="page-subtitle">Update destination information</p>
            </div>
            <a href="destinations.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Destinations
            </a>
        </div>
        
        <?php if ($error): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Destination Details</h3>
            </div>
            <div class="card-body">
                <form method="POST" style="max-width: 800px;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="form-group">
                            <label class="form-label">Destination Name *</label>
                            <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($dest['name']); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">City *</label>
                            <input type="text" name="city" class="form-control" value="<?php echo htmlspecialchars($dest['city']); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">State *</label>
                            <input type="text" name="state" class="form-control" value="<?php echo htmlspecialchars($dest['state']); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Country *</label>
                            <input type="text" name="country" class="form-control" value="<?php echo htmlspecialchars($dest['country']); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Category</label>
                            <select name="category" class="form-control">
                                <?php
                                $categories = ['Family', 'Friends', 'Solo', 'Couple', 'Adventure', 'Religious', 'Beach', 'Mountain'];
                                foreach ($categories as $cat) {
                                    $selected = ($dest['category'] == $cat) ? 'selected' : '';
                                    echo "<option value=\"$cat\" $selected>$cat</option>";
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Price (₹) *</label>
                            <input type="number" name="price_range" class="form-control" value="<?php echo htmlspecialchars($dest['price_range']); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Rating</label>
                            <select name="reviews" class="form-control">
                                <option value="" <?php echo empty($dest['reviews']) ? 'selected' : ''; ?>>Select Review</option>
                                <option value="top" <?php echo ($dest['reviews'] ?? '') == 'top' ? 'selected' : ''; ?>>Top</option>
                                <option value="average" <?php echo ($dest['reviews'] ?? '') == 'average' ? 'selected' : ''; ?>>Average</option>
                                <option value="medium" <?php echo ($dest['reviews'] ?? '') == 'medium' ? 'selected' : ''; ?>>Medium</option>
                                <option value="bottom" <?php echo ($dest['reviews'] ?? '') == 'bottom' ? 'selected' : ''; ?>>Bottom</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Star Rating (1-5)</label>
                            <select name="ratings" class="form-control">
                                <?php $current_rating = intval($dest['ratings'] ?? 0); ?>
                                <option value="0" <?php echo $current_rating == 0 ? 'selected' : ''; ?>>No Rating</option>
                                <option value="1" <?php echo $current_rating == 1 ? 'selected' : ''; ?>>1 Star</option>
                                <option value="2" <?php echo $current_rating == 2 ? 'selected' : ''; ?>>2 Stars</option>
                                <option value="3" <?php echo $current_rating == 3 ? 'selected' : ''; ?>>3 Stars</option>
                                <option value="4" <?php echo $current_rating == 4 ? 'selected' : ''; ?>>4 Stars</option>
                                <option value="5" <?php echo $current_rating == 5 ? 'selected' : ''; ?>>5 Stars</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Description *</label>
                        <textarea name="description" class="form-control" required><?php echo htmlspecialchars($dest['description']); ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Images (comma-separated filenames)</label>
                        <input type="text" name="images" class="form-control" value="<?php echo htmlspecialchars($dest['images']); ?>">
                        <div class="preview-images">
                            <?php
                            $images = explode(',', $dest['images']);
                            foreach ($images as $img) {
                                $img = trim($img);
                                if ($img) {
                                    echo '<img src="../img/destinations/' . $img . '" alt="' . $img . '">';
                                }
                            }
                            ?>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Keywords (for search)</label>
                        <input type="text" name="keywords" class="form-control" value="<?php echo htmlspecialchars($dest['keywords']); ?>">
                    </div>
                    
                    <div style="display: flex; gap: 15px; margin-top: 30px;">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Changes
                        </button>
                        <a href="destinations.php" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
