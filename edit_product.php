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

// Retrieve product ID from URL parameter
if (isset($_GET['edit'])) {
    $editProductId = mysqli_real_escape_string($conn, $_GET['edit']);
    $result = $conn->query("SELECT * FROM products WHERE id='$editProductId'");

    if ($result === false) {
        $error = "Error in SQL query: " . $conn->error;
    } elseif ($result->num_rows > 0) {
        $editProduct = $result->fetch_assoc();
    } else {
        $error = "Product not found for editing.";
    }
}

// Handle product update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = mysqli_real_escape_string($conn, $_POST['productId']);
    $productName = mysqli_real_escape_string($conn, $_POST['productName']);
    $productUrl = mysqli_real_escape_string($conn, $_POST['productUrl']);
    $productImage_Path = mysqli_real_escape_string($conn, $_POST['productImage_Path']);
    $productDescription = mysqli_real_escape_string($conn, $_POST['productDescription']);

    $sql = "UPDATE products SET name='$productName', url='$productUrl', image_path='$productImage_Path', description='$productDescription' WHERE id='$productId'";

    if ($conn->query($sql) === TRUE) {
        // Product updated successfully
        $message = "Product updated successfully!";
        // Redirect to product list page or display a success message
        header("Location: admin_panel.php");
        exit();
    } else {
        // Error updating product
        $error = "Error updating product: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="icon" type="image/x-icon" href="assets\logo.ico">
    <link rel="stylesheet" href="st.css">
</head>
<body>
    <div class="container">
        <h2>Edit Product</h2>

        <?php
        // Display success or error messages
        if (!empty($message)) {
            echo "<p class='success'>$message</p>";
        } elseif (!empty($error)) {
            echo "<p class='error'>$error</p>";
        }
        ?>

        <!-- Product Edit Form -->
        <form action="" method="post">
            <label for="productName">Product Name:</label>
            <input type="text" id="productName" name="productName" value="<?php echo isset($editProduct['name']) ? $editProduct['name'] : ''; ?>" required>
            <label for="productImage_Path">Product Image Path:</label>
            <input type="text" id="productImage_Path" name="productImage_Path" value="<?php echo isset($editProduct['image_path']) ? $editProduct['image_path'] : ''; ?>" required>
            <label for="productUrl">Product Url:</label>
            <input type="text" id="productUrl" name="productUrl" value="<?php echo isset($editProduct['url']) ? $editProduct['url'] : ''; ?>" required>
            <label for="productDescription">Product Description:</label>
            <textarea id="productDescription" name="productDescription" required><?php echo isset($editProduct['description']) ? $editProduct['description'] : ''; ?></textarea>
            <input type="hidden" name="productId" value="<?php echo isset($editProduct['id']) ? $editProduct['id'] : ''; ?>">
            <button type="submit" name="submit">Update Product</button>
        </form>
    </div>
</body>
</html>
