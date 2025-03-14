<?php
// Database Connection (config.php)
include 'config.php';

// Fetch Properties from Database
$query = "SELECT * FROM properties WHERE status = 'available'";
$result = mysqli_query($conn, $query);

$properties = [];

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $properties[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>House Rental System</title>
    <!-- <link rel="stylesheet" href="css/Home_Page.css"> -->
    <style>
        /* General Styles */
body {
    font-family: 'Roboto', sans-serif;
    margin: 0;
    padding: 0;
    color: #333;
    line-height: 1.6;
}

header {
    background-color: #007BFF;
    color: #fff;
    padding: 10px 0;
    position: fixed;
    width: 100%;
    z-index: 1000;
}

nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 20px;
}

nav h1 {
    font-size: 24px;
    margin: 0;
    font-weight: bold;
}

nav ul {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
}

nav ul li {
    margin-left: 20px;
}

nav ul li a {
    color: #fff;
    text-decoration: none;
    font-size: 16px;
    transition: color 0.3s ease;
    position: relative;
    padding: 5px 0;
}

nav ul li a::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 2px;
    background: #FFC107;
    transform: scaleX(0);
    transition: transform 0.3s ease;
}

nav ul li a:hover::after {
    transform: scaleX(1);
}

/* Hero Section */
.hero {
    text-align: center;
    padding: 120px 20px;
    color: black;
    min-height: 400px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    background: url('images/b1.jpg') no-repeat center center/cover;
    background-attachment: fixed;
}

.hero h2 {
    font-size: 40px;
    margin-bottom: 20px;
    font-weight: bold;
}

.hero p {
    font-size: 18px;
    margin-bottom: 20px;
}

.hero input[type="text"] {
    width: 100%;
    max-width: 600px;
    padding: 12px 15px;
    font-size: 16px;
    border: 2px solid #fff;
    background: rgba(255, 255, 255, 0.8);
    color: #333;
    border-radius: 8px;
    margin: 0 auto;
}

.hero input[type="text"]:focus {
    outline: none;
    border-color: #FFC107;
}

/* Properties Section */
.properties {
    padding: 60px 20px;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 25px;
    background: #f5f5f5;
}

/* Property Card */
.property-card {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: transform 0.3s ease-in-out;
}

.property-card:hover {
    transform: translateY(-8px);
}

.property-card img {
    width: 100%;
    height: 220px;
    object-fit: cover;
}

.property-card h3 {
    font-size: 22px;
    margin: 15px 10px 5px;
}

.property-card p {
    font-size: 16px;
    margin: 5px 10px;
    color: #555;
}

.property-card .view-btn {
    display: block;
    text-align: center;
    padding: 10px 20px;
    background-color: #007BFF;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    margin: 15px 10px;
    transition: background-color 0.3s ease;
}

.property-card .view-btn:hover {
    background-color: #0056b3;
}

/* Responsive Design */
@media (max-width: 768px) {
    .hero h2 {
        font-size: 32px;
    }

    .hero p {
        font-size: 16px;
    }

    .property-card img {
        height: 180px;
    }

    .property-card h3 {
        font-size: 20px;
    }

    .property-card p {
        font-size: 14px;
    }

    .property-card .view-btn {
        padding: 8px 16px;
        font-size: 14px;
    }
}

@media (max-width: 480px) {
    .hero h2 {
        font-size: 28px;
    }

    .hero p {
        font-size: 14px;
    }

    .property-card img {
        height: 150px;
    }

    .property-card h3 {
        font-size: 18px;
    }

    .property-card p {
        font-size: 12px;
    }

    .property-card .view-btn {
        padding: 6px 12px;
        font-size: 12px;
    }
}

    </style>
</head>

<body>
    <header>
        <nav>
            <h1>House Rental</h1>
            <ul>
                <li><a href="Home_Page.php">Home</a></li>
                <li><a href="#">Properties</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="signup.php">Sign Up</a></li>
            </ul>
        </nav>
    </header>

    <section class="hero">
        <div class="hero-content">
            <h2>Find Your Perfect Rental Home</h2>
            <p>Discover the comfort and convenience of a new home.</p>
            <input type="text" id="search" placeholder="Search for properties..." oninput="filterProperties()">
        </div>
    </section>

    <section class="properties" id="property-list">
        <!-- Display Properties from Backend -->
        <?php foreach ($properties as $property): ?>
            <div class="property-card">
                <img src="images/<?= $property['image'] ?>" alt="Property Image">
                <h3><?= $property['title'] ?></h3>
                <p><?= $property['location'] ?></p>
                <p>Price: ₹<?= $property['price'] ?></p>
                <a href="property_details.php?property_id=<?= $property['id'] ?>" class="view-btn">View Details</a>
            </div>
        <?php endforeach; ?>
    </section>

    <script>
        function filterProperties() {
            let searchValue = document.getElementById('search').value.toLowerCase();
            let properties = document.querySelectorAll('.property-card');

            properties.forEach(property => {
                let title = property.querySelector('h3').textContent.toLowerCase();
                let location = property.querySelector('p').textContent.toLowerCase();

                if (title.includes(searchValue) || location.includes(searchValue)) {
                    property.style.display = 'block';
                } else {
                    property.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>
