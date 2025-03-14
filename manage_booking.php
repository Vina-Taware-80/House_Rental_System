<?php
include('config.php');

// Handle Approve Booking
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'approve') {
    $bookingId = $_POST['booking_id'];
    $updateQuery = "UPDATE bookings SET status = 'confirmed' WHERE id = '$bookingId'";

    if (mysqli_query($conn, $updateQuery)) {
        echo json_encode(['status' => 'approved']);
    } else {
        echo json_encode(['status' => 'error']);
    }
}

// Handle Cancel Booking
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'cancel') {
    $bookingId = $_POST['booking_id'];
    $updateQuery = "UPDATE bookings SET status = 'cancelled' WHERE id = '$bookingId'";

    if (mysqli_query($conn, $updateQuery)) {
        echo json_encode(['status' => 'cancelled']);
    } else {
        echo json_encode(['status' => 'error']);
    }
}
