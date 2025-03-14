<?php
include('config.php');

// Check if property_id is set in the URL
if (isset($_GET['property_id']) && !empty($_GET['property_id'])) {
    $property_id = $_GET['property_id'];
    
    $result = mysqli_query($conn, "SELECT * FROM properties WHERE id='$property_id'");
    
    if (mysqli_num_rows($result) > 0) {
        $property = mysqli_fetch_assoc($result);
    } else {
        echo "<h3>❌ Property Not Found!</h3>";
        exit;
    }
} else {
    echo "<h3>❌ Invalid Property ID!</h3>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Details</title>
    <link rel="stylesheet" href="css/property_details.css">
</head>
<body>

<!-- Navbar -->
<nav>
    <h1>House Rental System</h1>
    <ul>
        <li><a href="home_page.php">Home</a></li>
        <li><a href="tenant_dashboard.php">My Bookings</a></li>
        <li><a href="Home_page.php">Logout</a></li>
    </ul>
</nav>

<!-- Property Details Section -->
<div class="property-details">

    <div class="property-img">
        <img src="images/<?php echo $property['image']; ?>" alt="Property Image">
    </div>

    <div class="details">
        <h2><?php echo $property['title']; ?></h2>
        <p><strong>Location:</strong> <?php echo $property['location']; ?></p>
        <p><strong>Price:</strong> ₹<?php echo $property['price']; ?></p>
        <p><strong>Description:</strong> <?php echo $property['description']; ?></p>
        <p><strong>Contact:</strong> <?php echo $property['contact_number']; ?></p>

        <form method="POST" action="book_property.php">
            <input type="hidden" name="property_id" value="<?php echo $property['id']; ?>">
            <button type="submit" name="book_now" class="btn">Book Now</button>
        </form>
    </div>

</div>

<!-- Footer -->
<footer>
    <p>&copy; 2025 House Rental System | All Rights Reserved</p>
</footer>

</body>
</html>
