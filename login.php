<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $sql = "SELECT id, password_hash FROM userss WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($user_id, $hashed_password);

        if ($stmt->fetch() && password_verify($password, $hashed_password)) {
            // Successful login
            session_start();
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username; // Store the username in the session
            header("Location: index.php");
            exit();
        } else {
            // Invalid credentials
            $error_message = "Invalid username or password.";
        }
    } catch (Exception $e) {
        // Handle database errors
        $error_message = "An error occurred. Please try again later.";
    } finally {
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link rel="icon" type="image/x-icon" href="assets\logo.ico">
    <link rel="stylesheet" href="style12.css">
    <style>
        .error {
            color: red;
        }

        /* Add styles for animation */
        @keyframes shake {
            0%, 100% {
                transform: translateX(0);
            }
            10%, 30%, 50%, 70%, 90% {
                transform: translateX(-10px);
            }
            20%, 40%, 60%, 80% {
                transform: translateX(10px);
            }
        }

        .shake {
            animation: shake 0.5s ease-in-out;
        }
    </style>
</head>

<body>
    <!-- <h2>User Login</h2> -->
    <div class="div12">

    </div>
    <div >
        <img src="assets\logo1.png" alt="">
    </div>
    <form method="post" action="" onsubmit="return validateForm()">
        <legend>User Login</legend>
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>

        <input type="submit" value="Login">
        <br>
        
        <!-- <button>Create Account to Store</button> -->
        <a href="register.php" class="a">Register</a>
        

    <?php
    if (isset($error_message)) {
        echo "<p class='error'>$error_message</p>";
    }
    ?>
    </form>



    <script>
        function validateForm() {
            var username = document.getElementById('username').value;
            var password = document.getElementById('password').value;

            if (username.trim() === '' || password.trim() === '') {
                // If username or password is empty, add a shake animation to the form
                document.querySelector('form').classList.add('shake');
                setTimeout(function () {
                    document.querySelector('form').classList.remove('shake');
                }, 500);
                return false;
            }

            // If validation passes, submit the form
            return true;
        }
    </script>
</body>
</html>
