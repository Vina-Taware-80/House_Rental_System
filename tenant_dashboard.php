<?php
session_start();
include 'config.php';

// Ensure tenant is logged in
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "tenant") {
    die("Unauthorized Access");
}

$tenant_id = $_SESSION["user_id"];

// Fetch tenant's bookings
$query = "SELECT b.id AS booking_id, p.title, p.location, p.price, b.status 
          FROM bookings b
          JOIN properties p ON b.property_id = p.id
          WHERE b.tenant_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $tenant_id);
$stmt->execute();
$result = $stmt->get_result();

$bookings = [];
while ($row = $result->fetch_assoc()) {
    $bookings[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenant Dashboard</title>
    <link rel="stylesheet" href="css/tenant_dashboard.css">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="container">
            <h2>🏠 Rental System</h2>
            <ul>
                <li><a href="property_list.php">View Properties</a></li>
                <li><a href="Home_Page.php">Home</a></li>
                <li><a href="user_profile.php">Edit Profile</a></li>
                <li class="active"><a href="tenant_dashboard.php">My Bookings</a></li>
                
                <li><a href="Home_Page.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <!-- Dashboard Container -->
    <div class="dashboard-container">
        <h1 class="welcome-text">Welcome to Your Tenant Dashboard</h1>
        
        <main class="main-content">
            <h2>My Bookings</h2>

            <?php if (count($bookings) > 0): ?>
                <table class="booking-table">
                    <thead>
                        <tr>
                            <th>Property</th>
                            <th>Location</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bookings as $booking): ?>
                            <tr>
                                <td><?= $booking["title"] ?></td>
                                <td><?= $booking["location"] ?></td>
                                <td>$<?= $booking["price"] ?></td>
                                <td class="<?= $booking["status"] ?>"><?= ucfirst($booking["status"]) ?></td>
                                <td>
                                    <?php if ($booking["status"] === "pending"): ?>
                                        <button class="cancel-btn" onclick="cancelBooking(<?= $booking['booking_id'] ?>)">Cancel</button>
                                    <?php else: ?>
                                        <button class="disabled" disabled>Cancel</button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="no-bookings">No bookings found.</p>
            <?php endif; ?>
        </main>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2025 Rental System. All Rights Reserved.</p>
    </footer>

    <script>
        function cancelBooking(bookingId) {
            if (confirm("Are you sure you want to cancel this booking?")) {
                fetch("cancel_booking.php", {
                    method: "POST",
                    body: new URLSearchParams({ booking_id: bookingId })
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    location.reload();
                });
            }
        }
    </script>

</body>
</html>
