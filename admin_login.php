<?php
session_start();

if (isset($_POST['submit'])) {
    $admin_username = "ahmed";
    $admin_password = "ahmed123456"; // Hashed password in a real-world scenario

    $input_username = $_POST['username'];
    $input_password = $_POST['password'];

    if ($input_username == $admin_username && $input_password == $admin_password) {
        $_SESSION['admin'] = true;
        header("Location: admin_panel.php");
        exit();
    } else {
        $error_message = "Invalid credentials.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="icon" type="image/x-icon" href="assets\logo.ico">

    <link rel="stylesheet" href="style12.css">

</head>
<body>

    <div >
        <img src="assets\logo1.png" alt="">
    </div>
    <form method="post" action="">
        <legend>Admin Login</legend>
        <label for="username">Username:</label>
        <input type="text" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br>

        <input type="submit" name="submit" value="Login">
    <?php
    if (isset($error_message)) {
        echo "<p style='color: red;'>$error_message</p>";
    }
    ?>
    </form>
</body>
</html>
