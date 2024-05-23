<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="icon" type="image/x-icon" href="assets\logo.png">

    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            background: linear-gradient(to right, #343231, #00ADD0);
            margin: 0;
            padding: 0;
        }

        header {
            position: relative;
            background: linear-gradient(to right, #343231, #00ADD0);
            color: #fff;
            font-family: 'Courier New', Courier, monospace;
            padding: 10px;
            text-align: center;
        }

        nav {
            background-color: #555;
            padding: 10px;
            font-family: 'Courier New', Courier, monospace;
            text-align: center;
        }
        p{
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Courier New', Courier, monospace;
            font-weight: bold;

            
        }
        h2{
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Courier New', Courier, monospace;
            font-weight: bold;

            
        }

        nav a {
            color: #fff;
            text-decoration: none;
            padding: 10px;
            margin: 10px;
            border-radius: 5px;
            background-color: #444;
            font-family: 'Courier New', Courier, monospace;

        }

        nav a:hover {
            background-color: #666;
            font-family: 'Courier New', Courier, monospace;

        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        footer {
            background-color: #333;
            color: #fff;
            padding: 10px;
            font-family: 'Courier New', Courier, monospace;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        img{
            width: 300px;
            border-radius: 70%;
            margin-left:600px;

            
        }
    </style>
</head>
<body>
    <header>
        <h1>Admin Panel</h1>
    </header>

    <nav>
        <a href="admin_manage_products.php">Manage Products</a>
        <a href="admin_manage_users.php">Manage users</a>
        <a href="admin_manage_servies.php">Manage servies</a>
        <a href="admin_login.php">Logout</a>
    </nav>

    <div class="container">
        <!-- Your content goes here -->
        <h2>Welcome, <?php echo $_SESSION['admin']; ?>!</h2>
        <p>Feel free to manage products and Users and Centers.</p>
    </div>
    <div >
        <img src="assets\logo1.png" alt="">
    </div>

    <footer>
        &copy; <?php echo date('Y'); ?> Admin Panel
    </footer>
</body>
</html>
