<?php
include('config.php');

// ✅ Add Property to Database
if (isset($_POST['add_property'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $price = $_POST['price'];
    $contact = $_POST['contact'];
    $status = $_POST['status'];

    $image = $_FILES['image']['name'];
    $targetDir = "images/";
    move_uploaded_file($_FILES['image']['tmp_name'], $targetDir . $image);

    mysqli_query($conn, "INSERT INTO properties (landlord_id, title, description, location, price, contact_number, image, availability) 
                        VALUES (1, '$title', '$description', '$location', '$price', '$contact', '$image', '$status')");
    header("Location: landlord_dashboard.php");
}

// ✅ Delete Property
if (isset($_POST['delete_property'])) {
    $propertyId = $_POST['property_id'];
    mysqli_query($conn, "DELETE FROM properties WHERE id='$propertyId'");
    header("Location: landlord_dashboard.php");
}

// ✅ Approve Booking
if (isset($_POST['approve_booking'])) {
    $bookingId = $_POST['booking_id'];
    mysqli_query($conn, "UPDATE bookings SET status='confirmed' WHERE id='$bookingId'");
    header("Location: landlord_dashboard.php");
}

// ✅ Cancel Booking
if (isset($_POST['cancel_booking'])) {
    $bookingId = $_POST['booking_id'];
    mysqli_query($conn, "UPDATE bookings SET status='cancelled' WHERE id='$bookingId'");
    header("Location: landlord_dashboard.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Landlord Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <button onclick="showSection('manage-properties')">🏠 Manage Properties</button>
        <button onclick="showSection('manage-bookings')">📅 Manage Bookings</button>
    </div>

    <!-- Manage Properties Section -->
    <div class="section active" id="manage-properties">
        <h2>Manage Properties</h2>
        <button onclick="showPropertyForm()">➕ Add Property</button>

        <!-- Add Property Form -->
        <form method="POST" enctype="multipart/form-data" id="property-form" class="hidden">
            <input type="text" name="title" placeholder="Property Title" required>
            <input type="text" name="description" placeholder="Description" required>
            <input type="text" name="location" placeholder="Location" required>
            <input type="number" name="price" placeholder="Price" required>
            <input type="text" name="contact" placeholder="Contact Number" required>
            <select name="status">
                <option value="available">Available</option>
                <option value="rented">Rented</option>
            </select>
            <input type="file" name="image" required>

            <button type="submit" name="add_property">✅ Save Property</button>
            <button type="button" onclick="hidePropertyForm()">❌ Cancel</button>
        </form>

        <!-- Property Table -->
        <table class="property-table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Location</th>
                    <th>Price</th>
                    <th>Contact</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = mysqli_query($conn, "SELECT * FROM properties WHERE landlord_id = 1");
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "
                    <tr>
                        <td><img src='images/{$row['image']}' width='60'></td>
                        <td>{$row['title']}</td>
                        <td>{$row['location']}</td>
                        <td>{$row['price']}</td>
                        <td>{$row['contact_number']}</td>
                        <td>{$row['availability']}</td>
                        <td>
                            <form method='POST' class='inline-form'>
                                <input type='hidden' name='property_id' value='{$row['id']}'>
                                <button type='submit' name='delete_property'>❌ Delete</button>
                            </form>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Manage Bookings Section -->
    <div class="section" id="manage-bookings">
        <h2>Manage Bookings</h2>
        <table class="booking-table">
            <thead>
                <tr>
                    <th>Property</th>
                    <th>Tenant Name</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $bookings = mysqli_query($conn, "SELECT b.id, p.title, u.name, b.status 
                                                FROM bookings b 
                                                JOIN properties p ON b.property_id = p.id 
                                                JOIN users u ON b.tenant_id = u.id");
                while ($row = mysqli_fetch_assoc($bookings)) {
                    echo "
                    <tr>
                        <td>{$row['title']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['status']}</td>
                        <td>
                            <form method='POST' class='inline-form'>
                                <input type='hidden' name='booking_id' value='{$row['id']}'>
                                <button type='submit' name='approve_booking'>✅ Approve</button>
                                <button type='submit' name='cancel_booking'>❌ Cancel</button>
                            </form>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

<script>
    function showSection(sectionId) {
        const sections = document.querySelectorAll('.section');
        sections.forEach(section => section.classList.remove('active'));
        document.getElementById(sectionId).classList.add('active');
    }

    function showPropertyForm() {
        document.getElementById('property-form').classList.remove('hidden');
    }

    function hidePropertyForm() {
        document.getElementById('property-form').classList.add('hidden');
    }
</script>

</body>
</html>
