<?php
include 'includes/auth.php';
require_once '../database/traveldb.php';

$error = '';
$success = '';

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
    
    $sql = "INSERT INTO destinations (name, description, images, city, state, country, category, price_range, keywords, reviews, ratings, is_deleted) 
            VALUES ('$name', '$description', '$images', '$city', '$state', '$country', '$category', '$price_range', '$keywords', '$reviews', '$ratings', '0')";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: destinations.php?msg=added");
        exit();
    } else {
        $error = "Error adding destination: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Destination - Admin Panel</title>
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
                <h1 class="page-title">Add Destination</h1>
                <p class="page-subtitle">Create a new travel destination</p>
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
                            <input type="text" name="name" class="form-control" placeholder="e.g. Golden Temple" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">City *</label>
                            <input type="text" name="city" class="form-control" placeholder="e.g. Amritsar" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">State *</label>
                            <input type="text" name="state" class="form-control" placeholder="e.g. Punjab" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Country *</label>
                            <input type="text" name="country" class="form-control" placeholder="e.g. India" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Category</label>
                            <select name="category" class="form-control">
                                <option value="Family">Family</option>
                                <option value="Friends">Friends</option>
                                <option value="Solo">Solo</option>
                                <option value="Couple">Couple</option>
                                <option value="Adventure">Adventure</option>
                                <option value="Religious">Religious</option>
                                <option value="Beach">Beach</option>
                                <option value="Mountain">Mountain</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Price (₹) *</label>
                            <input type="number" name="price_range" class="form-control" placeholder="e.g. 25000" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Rating</label>
                            <select name="reviews" class="form-control">
                                <option value="">Select Review</option>
                                <option value="top">Top</option>
                                <option value="average">Average</option>
                                <option value="medium">Medium</option>
                                <option value="bottom">Bottom</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Star Rating (1-5)</label>
                            <select name="ratings" class="form-control">
                                <option value="0">No Rating</option>
                                <option value="1">1 Star</option>
                                <option value="2">2 Stars</option>
                                <option value="3">3 Stars</option>
                                <option value="4">4 Stars</option>
                                <option value="5">5 Stars</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Description *</label>
                        <textarea name="description" class="form-control" placeholder="Describe this destination..." required></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Images (comma-separated filenames)</label>
                        <input type="text" name="images" class="form-control" placeholder="e.g. image1.jpg, image2.jpg">
                        <small style="color: var(--text-muted); display: block; margin-top: 5px;">
                            Upload images to /img/destinations/ folder and enter filenames here
                        </small>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Keywords (for search)</label>
                        <input type="text" name="keywords" class="form-control" placeholder="e.g. temple, spiritual, historic">
                    </div>
                    
                    <div style="display: flex; gap: 15px; margin-top: 30px;">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add Destination
                        </button>
                        <a href="destinations.php" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
