<?php
// Database Connection
include 'config.php';

// Start Session
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: Home_page.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch Current User Data
$query = "SELECT * FROM users WHERE id = $user_id";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

// Handle Form Submission
if (isset($_POST['update_profile'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : $user['password'];

    // Update Query
    $update_query = "UPDATE users SET name='$name', email='$email', password='$password' WHERE id = $user_id";
    $update_result = mysqli_query($conn, $update_query);

    if ($update_result) {
        echo "<script>alert('Profile Updated Successfully!'); window.location='user_profile.php';</script>";
    } else {
        echo "Update Failed!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="css/edit_profile.css">
</head>

<body >
    <header>
        <nav>
            <h1>House Rental System</h1>
            <ul>
                <li><a href="tenant_dashboard.php">Home</a></li>
                <li><a href="user_profile.php">Profile</a></li>
                <li><a href="Home_Page.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <section class="edit-profile-container">
        <h2>Edit Profile</h2>
        <form method="POST">
            <label for="name">Name:</label>
            <input type="text" name="name" value="<?php echo $user['name']; ?>" required>

            <label for="email">Email:</label>
            <input type="email" name="email" value="<?php echo $user['email']; ?>" required>

            <label for="password">New Password:</label>
            <input type="password" name="password" placeholder="Leave blank to keep current password">

            <button type="submit" name="update_profile">Update Profile</button>
        </form>
    </section>

    <footer>
        <p>&copy; 2025 House Rental System. All Rights Reserved.</p>
    </footer>
</body>

</html>
