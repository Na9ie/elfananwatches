<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $address = $_POST['address'];
    // $id_number = $_POST['id_number'];
    $date_of_birth = $_POST['date_of_birth'];
    $telephone = $_POST['telephone'];

    // Input validation - you may add more validation as needed

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_ARGON2ID);

    // Create a prepared statement
    $sql = "INSERT INTO userss (username, password_hash, email, address, date_of_birth, telephone) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Check if the prepare() call succeeded
    if (!$stmt) {
        echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
        exit();
    }

    // Bind parameters to the prepared statement
    $stmt->bind_param("ssssss", $username, $hashed_password, $email, $address, $date_of_birth, $telephone);

    // Execute the prepared statement
    if ($stmt->execute()) {
        // Registration successful
        session_start();
        $_SESSION['username'] = $username;
        header("Location: index.php");
        exit();
    } else {
        // Registration failed
        echo "Error during registration. Please try again.";
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link rel="icon" type="image/x-icon" href="assets\logo1.png">
    <link rel="stylesheet" href="reg.css">
</head>
<body>
    <!-- <h2>User Registration</h2> -->
    <div >
        <img src="assets\logo1.png" alt="">
    </div>
    <form method="post" action="">
        <legend>User Registration</legend>
        <label for="username">Username:</label>
        <input type="text" name="username" required>

        <label for="email">Email:</label>
        <input type="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" name="password" required>

        <label for="address">Address:</label>
        <input type="text" name="address">

        <label for="date_of_birth">Date of Birth:</label>
        <input type="date" name="date_of_birth">

        <label for="telephone">Telephone:</label>
        <input type="text" name="telephone">

        <input type="submit" value="Register">
    </form>
</body>
</html>
