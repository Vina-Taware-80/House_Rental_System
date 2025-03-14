<?php
session_start();
include 'config.php';

// Ensure the user is logged in as a tenant
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "tenant") {
    die("Unauthorized Access");
}

$tenant_id = $_SESSION["user_id"];

// Fetch available properties
$query = "SELECT * FROM properties WHERE status = 'available'";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Properties | House Rental</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Global Styles */
        body {
            font-family: Arial, sans-serif;
            background: url('images/background.jpg') no-repeat center center/cover;
            margin: 0;
            padding: 0;
        }

        /* Header */
        header {
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 15px 20px;
            text-align: center;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header h1 {
            margin: 0;
        }

        .btn {
            background: #ff6600;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            transition: 0.3s;
        }

        .btn:hover {
            background: #cc5500;
        }

        /* Property Listing */
        .property-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            padding: 20px;
        }

        .property-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 300px;
            text-align: center;
            padding: 15px;
        }

        .property-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-bottom: 2px solid #ff6600;
        }

        .property-card h3 {
            margin: 10px 0;
            color: #333;
        }

        .property-card p {
            color: #666;
            font-size: 14px;
        }

        .book-btn {
            background: #ff6600;
            color: white;
            padding: 8px 12px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            transition: 0.3s;
            margin-top: 10px;
        }

        .book-btn:hover {
            background: #cc5500;
        }

        /* Footer */
        footer {
            text-align: center;
            padding: 15px;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Available Properties</h1>
        <a href="tenant_dashboard.php" class="btn">🏠 My Dashboard</a>
    </header>

    <section class="property-list">
        <?php while ($property = $result->fetch_assoc()): ?>
            <div class="property-card">
            <img src="images/<?php echo $property['image']; ?>" alt="Property Image">
                <h3><?= $property['title'] ?></h3>
                <p><?= $property['description'] ?></p>
                <p><strong>Location:</strong> <?= $property['location'] ?></p>
                <p><strong>Price:</strong> $<?= $property['price'] ?></p>
                <form action="book_property.php" method="POST">
                    <input type="hidden" name="property_id" value="<?= $property['id'] ?>">
                    <button type="submit" class="book-btn">Book Now</button>
                </form>
            </div>
        <?php endwhile; ?>
    </section>

    <footer>
        <p>&copy; 2025 House Rental System. All rights reserved.</p>
    </footer>
</body>
</html>
