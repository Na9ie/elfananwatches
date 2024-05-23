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

// Handle service deletion
if (isset($_GET['delete'])) {
    $deleteServiceId = mysqli_real_escape_string($conn, $_GET['delete']);
    $sql = "DELETE FROM services WHERE id='$deleteServiceId'";

    if ($conn->query($sql) === TRUE) {
        $message = "Service deleted successfully!";
    } else {
        $error = "Error deleting service: " . $conn->error;
    }
}

// Handle service editing
if (isset($_GET['edit'])) {
    $editServiceId = mysqli_real_escape_string($conn, $_GET['edit']);
    $result = $conn->query("SELECT * FROM services WHERE id='$editServiceId'");

    if ($result === false) {
        $error = "Error in SQL query: " . $conn->error;
    } elseif ($result->num_rows > 0) {
        $editService = $result->fetch_assoc();
    } else {
        $error = "Service not found for editing.";
    }
}

// Handle add/edit service
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $serviceId = mysqli_real_escape_string($conn, $_POST['serviceId']);
    $serviceName = mysqli_real_escape_string($conn, $_POST['serviceName']);
    $serviceImage = mysqli_real_escape_string($conn, $_POST['serviceImage']);
    $serviceUrl = mysqli_real_escape_string($conn, $_POST['serviceUrl']);

    if (!empty($serviceId)) {
        // Edit service if service ID is present
        $sql = "UPDATE services SET names='$serviceName', image='$serviceImage', urll='$serviceUrl' WHERE id='$serviceId'";
        $action = 'updated';
    } else {
        // Add new service if service ID is not present
        $sql = "INSERT INTO services (names, image, urll) VALUES ('$serviceName', '$serviceImage', '$serviceUrl')";
        $action = 'added';
    }

    if ($conn->query($sql) === TRUE) {
        // Service added or updated successfully
        $message = "Service $action successfully!";
    } else {
        // Error adding or updating service
        $error = "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch all services
$result = $conn->query("SELECT * FROM servies");
$services = $result->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Service Management</title>
    <link rel="icon" type="image/x-icon" href="assets\logo1.png">
    <link rel="stylesheet" href="view.css">
</head>
<body>
    <div class="container">
        <div class="div34">
            <h2>Admin Service Management</h2>
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

        <!-- Service Management Form -->
        <form action="" method="post">
            <label for="serviceName">Service Name:</label>
            <input type="text" id="serviceName" name="serviceName" value="<?php echo isset($editService['names']) ? $editService['names'] : ''; ?>" required>

            <label for="serviceImage">Service Image:</label>
            <input type="text" id="serviceImage" name="serviceImage" value="<?php echo isset($editService['image']) ? $editService['image'] : ''; ?>" required>

            <label for="serviceUrl">Service URL:</label>
            <input type="text" id="serviceUrl" name="serviceUrl" value="<?php echo isset($editService['urll']) ? $editService['urll'] : ''; ?>" required>

            <input type="hidden" name="serviceId" value="<?php echo isset($editService['id']) ? $editService['id'] : ''; ?>">

            <button type="submit" name="submit"><?php echo isset($editService) ? 'Edit Service' : 'Add Service'; ?></button>
        </form>

        <!-- Service List -->
        <h3>Service List</h3>
        <table border="1">
            <tr>
                <th>Service Name</th>
                <th>Service Image</th>
                <th>Service URL</th>
                <th>Action</th>
            </tr>
            <?php foreach ($services as $service) : ?>
                <tr>
                    <td><?php echo $service['names']; ?></td>
                    <td><img src="<?php echo $service['image']; ?>" alt="<?php echo $service['names']; ?>" style="max-width: 100px;"></td>

                    <td><?php echo $service['urll']; ?></td>
                    <td>
                        <a href="delete_service.php?delete=<?php echo $service['id']; ?>" onclick="return confirm('Are you sure you want to delete this service?')">Delete</a>
                        <a href="<?php echo "edit_service.php?edit=" . $service['id']; ?>">Edit</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
