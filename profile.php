<?php
// profile.php

// Start the session (make sure session_start() is called at the beginning of your script)
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Fetch user data from the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_SESSION['username'];

// Assuming 'users' is the table where user information is stored
$sql = "SELECT * FROM userss WHERE username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // User found, display user information
    $row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="icon" type="image/x-icon" href="assets\logo1.ico">


    <!-- Link to the external CSS file -->
    <link rel="stylesheet" type="text/css" href="pro.css">
</head>

<body>
    <header>
        <img src="assets\logo1.png" alt="">
        <h1>User Profile</h1>
    </header>

    <div class="container">
        <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>

        <p><strong>Birthday:</strong> <?php echo $row['date_of_birth']; ?></p>
        <p><strong>Address:</strong> <?php echo $row['address']; ?></p>
        <p><strong>Email:</strong> <?php echo $row['email']; ?></p>
        <p><strong>Telephone:</strong> <?php echo $row['telephone']; ?></p>
        <!-- <p><strong>ID Number:</strong> <?php echo $row['id_number']; ?></p> -->

        <!-- You can add more content here, or customize the display as needed -->

        <p><a href="login.php">Logout</a></p>
    </div>
</body>

</html>

<?php
} else {
    // User not found in the database
    echo "User not found.";
}

$conn->close();
?>
