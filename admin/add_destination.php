<?php
include('database/traveldb.php');

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $country = $_POST['country'];
    $category = $_POST['category'];
    $price_range = $_POST['price_range'];
    $ratings = $_POST['ratings'];
    $keywords = $_POST['keywords'];
    $is_deleted = '0';

    // Image upload handling
    $images = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $upload_dir = "img/destinations/";

    // Move uploaded file to destination folder
    move_uploaded_file($image_tmp, $upload_dir . $images);

    // Insert into database
    $sql = "INSERT INTO destinations 
        (name, description, images, city, state, country, category, price_range, ratings,keywords,is_deleted) VALUES 
        ('$name', '$description', '$images', '$city', '$state', '$country', '$category' , '$price_range' , '$ratings' ,'$keywords', '$is_deleted')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Destination added successfully!')</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>


<form action="add_destination.php" method="POST" enctype="multipart/form-data">
    <input type="text" name="name" placeholder="Destination Name" required><br>
    <textarea name="description" placeholder="Description"></textarea><br>
    <input type="text" name="city" placeholder="City" required><br>
    <input type="text" name="state" placeholder="State" required><br>
    <input type="text" name="country" placeholder="Country" required><br>
    <input type="text" name="category" placeholder="Category" required><br>
    <input type="number" name="price_range" placeholder="Price Range"><br>
    <input type="text" name="ratings" placeholder="ratings"><br>
    <input type="text" name="keywords" placeholder="place keyword"><br>
    <input type="file" name="image" accept="image/*" required><br>
    <input type="submit" name="submit" value="Add Destination">
</form>
