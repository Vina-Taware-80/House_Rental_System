<?php
session_start();
include 'config.php';

// Ensure the user is logged in as a tenant
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "tenant") {
    die("Unauthorized Access");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $tenant_id = $_SESSION["user_id"];
    $property_id = $_POST["property_id"];

    // Insert booking request
    $stmt = $conn->prepare("INSERT INTO bookings (tenant_id, property_id, status) VALUES (?, ?, 'pending')");
    $stmt->bind_param("ii", $tenant_id, $property_id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Booking request sent!'); window.location.href='tenant_dashboard.php';</script>";
    } else {
        echo "<script>alert('Error booking property!'); window.location.href='properties.php';</script>";
    }
}
?>
