<?php
// Database Connection
include 'config.php';

// Start Session
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'landlord') {
    header("Location: Home_Page.php");
    exit();
}

$landlord_id = $_SESSION['user_id'];

// Fetch Landlord Data
$query = "SELECT * FROM users WHERE id = $landlord_id";
$result = mysqli_query($conn, $query);
$landlord = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landlord Profile</title>
    <link rel="stylesheet" href="css/landlord_profile.css">
</head>

<body>
    <header>
        <nav>
            <h1>House Rental System</h1>
            <ul>
                <li><a href="landlord_dashboard.php">Dashboard</a></li>
                <li><a href="landlord_profile.php">Profile</a></li>
                <li><a href="Home_Page.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <section class="profile-container">
        <h2>Landlord Profile</h2>
        <div class="profile-card">
            <div class="profile-icon">
                <i class="fas fa-user-circle"></i>
            </div>
            <h3><?php echo $landlord['name']; ?></h3>
            <p>Email: <?php echo $landlord['email']; ?></p>
            <p>Role: <?php echo ucfirst($landlord['role']); ?></p>
            <p>Member Since: <?php echo date('d M, Y', strtotime($landlord['created_at'])); ?></p>
            <a href="edit_landlord_profile.php" class="edit-btn">Edit Profile</a>
        </div>
    </section>

    <footer>
        <p>&copy; 2025 House Rental System. All Rights Reserved.</p>
    </footer>
</body>

</html>
