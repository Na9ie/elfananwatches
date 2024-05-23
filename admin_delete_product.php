<?php
include 'header.php';
include 'db.php';

// Check if the user is logged in as an admin (you may have a different way to handle user roles)
session_start();

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    // Redirect non-admin users to the login page or handle unauthorized access
    header("Location: login.php");
    exit();
}

// Check if the product ID is provided in the URL
if (!isset($_GET['id'])) {
    // Redirect to the product management page or handle missing product ID
    header("Location: admin_products.php");
    exit();
}

$productId = $_GET['id'];

// Fetch product details from the database for confirmation
$stmt = $conn->prepare("SELECT id, name FROM Cproductss WHERE id = :id");
$stmt->bindParam(':id', $productId, PDO::PARAM_INT);
$stmt->execute();
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    // Redirect to the product management page or handle invalid product ID
    header("Location: admin_products.php");
    exit();
}

// Handle product deletion confirmation
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process the deletion confirmation when the form is submitted

    // Perform database deletion (adjust based on your actual database schema)
    $stmt = $conn->prepare("DELETE FROM CproductsS WHERE id = :id");
    $stmt->bindParam(':id', $productId, PDO::PARAM_INT);

    if ($stmt->execute()) {
        // Product deletion successful
        header("Location: admin_products.php");
        exit();
    } else {
        // Handle deletion failure
        $deleteError = "Failed to delete product. Please try again.";
    }
}

?>

<section>
    <h2>Delete Product</h2>

    <?php
    // Display delete error if any
    if (isset($deleteError)) {
        echo "<p>{$deleteError}</p>";
    }
    ?>

    <p>Are you sure you want to delete the product "<?php echo $product['name']; ?>"?</p>

    <form action="admin_delete_product.php?id=<?php echo $productId; ?>" method="post">
        <button type="submit">Confirm Deletion</button>
        <a href="admin.php">Cancel</a>
    </form>
</section>

<?php include 'footer.php'; ?>
