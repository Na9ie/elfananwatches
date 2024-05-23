<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

// Database connection constants
define("DB_SERVER", "localhost");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "");
define("DB_NAME", "db");

// Create connection
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = $error = '';

// Handle product deletion
if (isset($_GET['delete'])) {
    $deleteProductId = mysqli_real_escape_string($conn, $_GET['delete']);
    $sql = "DELETE FROM products WHERE id='$deleteProductId'";

    if ($conn->query($sql) === TRUE) {
        $message = "Product deleted successfully!";
    } else {
        $error = "Error deleting product: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Product</title>
    <link rel="stylesheet" href="st.css">
    <link rel="icon" type="image/x-icon" href="assets\logo.ico">

</head>
<body>
    <div class="container">
        <h2>Delete Product</h2>

        <?php
        // Display success or error messages
        if (!empty($message)) {
            echo "<p class='success'>$message</p>";
        } elseif (!empty($error)) {
            echo "<p class='error'>$error</p>";
        }
        ?>

        <a href="admin_manage_products.php">Back to Product Management</a>
    </div>
</body>
</html>
