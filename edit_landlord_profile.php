<?php
session_start();
include('config.php');

// Check if landlord is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'landlord') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Update profile without changing the password
    if (empty($password)) {
        $query = "UPDATE users SET name='$name', email='$email' WHERE id=$user_id";
    } else {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $query = "UPDATE users SET name='$name', email='$email', password='$hashed_password' WHERE id=$user_id";
    }

    mysqli_query($conn, $query);
    header("Location: landlord_profile.php");
    exit();
}

// Fetch current data
$query = "SELECT name, email FROM users WHERE id = $user_id";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="css/edit_landlord_profile.css">
</head>
<body>
    <header>
        <nav>
            <h1>House Rental System</h1>
            <ul>
                <li><a href="landlord_dashboard.php">Dashboard</a></li>
                <li><a href="landlord_profile.php">Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <div class="edit-profile-container">
        <h2>Edit Profile</h2>
        <form method="POST" action="">
            <input type="text" name="name" value="<?php echo $row['name']; ?>" required>
            <input type="email" name="email" value="<?php echo $row['email']; ?>" required>
            <input type="password" name="password" placeholder="Change Password (optional)">
            <button type="submit">Update Profile</button>
        </form>
    </div>
    
</body>
</html>
