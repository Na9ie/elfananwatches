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

// Handle product editing
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

/// Handle add/edit product
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = mysqli_real_escape_string($conn, $_POST['productId']);
    $productName = mysqli_real_escape_string($conn, $_POST['productName']);
    $productUrl = mysqli_real_escape_string($conn, $_POST['productUrl']);
    $productImage_Path = mysqli_real_escape_string($conn, $_POST['productImage_Path']);
    $productDescription = mysqli_real_escape_string($conn, $_POST['productDescription']);

    if (!empty($productId)) {
        // Edit product if product ID is present
        $sql = "UPDATE products SET name='$productName', price='$productPrice', image_path='$productImage_Path', description='$productDescription' WHERE id='$productId'";
        $action = 'updated';
    } else {
        // Add new product if product ID is not present
        $sql = "INSERT INTO products (name, url, image_path, description) VALUES ('$productName', '$productUrl', '$productImage_Path', '$productDescription')";
        $action = 'added';
    }

    if ($conn->query($sql) === TRUE) {
        // Product added or updated successfully
        $message = "Product $action successfully!";
    } else {
        // Error adding or updating product
        $error = "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch all products
$result = $conn->query("SELECT * FROM products");
$products = $result->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Product Management</title>
    <link rel="icon" type="image/x-icon" href="assets\logo.ico">
    <link rel="stylesheet" href="view.css">
</head>
<body>
    <div class="container">
        <div class="div34">
            <h2>Admin Product Management</h2>
            <img src="assets\logo1.png" alt="" class="img2">


        </div>
        

        <?php
        // Display success or error messages
        if (!empty($message)) {
            echo "<p class='success'>$message</p>";
        } elseif (!empty($error)) {
            echo "<p class='error'>$error</p>";
        }
        ?>

        <!-- Product Management Form -->
        <form action="" method="post">
            <label for="productName">Product Name:</label>
            <input type="text" id="productName" name="productName" value="<?php echo isset($editProduct['name']) ? $editProduct['name'] : ''; ?>" required>
            <label for="productImage_Path">Product Image Path:</label>
            <input type="text" id="productImage_Path" name="productImage_Path" value="<?php echo isset($editProduct['image_path']) ? $editProduct['image_path'] : ''; ?>" required>

            <label for="productUrl">Product Url:</label>
            <input type="number" id="productUrl" name="productUrl" value="<?php echo isset($editProduct['url']) ? $editProduct['url'] : ''; ?>" required>

            <label for="productDescription">Product Description:</label>
            <textarea id="productDescription" name="productDescription"><?php echo isset($editProduct['description']) ? $editProduct['description'] : ''; ?></textarea>

            <input type="hidden" name="productId" value="<?php echo isset($editProduct['id']) ? $editProduct['id'] : ''; ?>">
            <br>   
            <button type="submit" name="submit"><?php echo isset($editProduct) ? 'Edit Product' : 'Add Product'; ?></button>
        </form>

        <!-- Product List -->
        <h3>Product List</h3>
        <table border="1">
            <tr>
                <th>Image Product</th>
                <th>Product Name</th>
                <th>Product Description</th>
                <th>Product Url</th>
                <th>Action</th>
            </tr>
            <?php foreach ($products as $product) : ?>
                <tr>
                    <td><img src="<?php echo $product['image_path']; ?>" alt="<?php echo $product['name']; ?>" style="max-width: 100px;"></td>
                    <td><?php echo $product['name']; ?></td>
                    
                    <td><?php echo $product['description']; ?></td>
                    <td><?php echo $product['url']; ?></td>
                    <td>
                        <a href="delete_product.php?delete=<?php echo $product['id']; ?>" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                        <a href="edit_product.php?edit=<?php echo $product['id']; ?>">Edit</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <a href="admin_panel.php">Back to Panel</a>

    </div>
</body>
</html>
