<?php
session_start();
include 'config.php';

// Ensure tenant is logged in
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "tenant") {
    die(json_encode(["success" => false, "message" => "Unauthorized Access"]));
}

$tenant_id = $_SESSION["user_id"];
$booking_id = $_POST["booking_id"] ?? null;

if (!$booking_id) {
    die(json_encode(["success" => false, "message" => "Invalid booking ID"]));
}

// Cancel booking if it's pending
$stmt = $conn->prepare("UPDATE bookings SET status = 'cancelled' WHERE id = ? AND tenant_id = ? AND status = 'pending'");
$stmt->bind_param("ii", $booking_id, $tenant_id);

if ($stmt->execute() && $stmt->affected_rows > 0) {
    echo json_encode(["success" => true, "message" => "Booking cancelled successfully"]);
} else {
    echo json_encode(["success" => false, "message" => "Cannot cancel this booking"]);
}
?>
