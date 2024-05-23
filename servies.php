<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Watch maintenance and sales centers</title>
    <link rel="icon" type="image/x-icon" href="assets\logo1.png">


    <!-- Bootstrap CSS from CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Your custom CSS files -->
    <link rel="stylesheet" href="sty.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="path/to/fontawesome-free-5.15.3-web/css/all.min.css">

    <!-- Anime.js from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/animejs@3.2.1"></script>

    <style>
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #332E2D, #0F8DA6);
        }

        header {
            position: relative;
            background: linear-gradient(to right, #332E2D, #0F8DA6);
            color: #fff;
            padding: 10px;
            text-align: center;
            font-family: "Lucida Console", "Courier New", monospace;

            

        }
        .h1{
            color:#fff;
            font-family: "Lucida Console", "Courier New", monospace;

        }

        .user-info {
            position: absolute;
            top: 10px;
            right: 10px;
            color: white;
            display: flex;
            align-items: center;
        }

        .user-info img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            margin-right: 5px;
        }

        /* Updated styling for Bootstrap Navbar */
        nav {
            margin-top: 10px;
            background: linear-gradient(to right, #332E2D, #0F8DA6);
            font-family: "Lucida Console", "Courier New", monospace;



        }

        footer {
            background: linear-gradient(to right, #332E2D, #0F8DA6);
            font-family: "Lucida Console", "Courier New", monospace;
            color: white;
            text-shadow: 4px 4px 10px red;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            grid-gap: 20px;
        }

        .product {
            border: 1px solid #ddd;
            padding: 15px;
            text-align: center;
        }
        .order-button {
        display: inline-block;
        padding: 10px 20px;
        background: linear-gradient(to right, #332E2D, #0F8DA6);
        color: #fff;
        text-decoration:none;
        border-radius: 5px;
        margin-top: 10px;
        transition: background-color 0.3s ease;
        }

        .order-button:hover {
            background: linear-gradient(to right, #332E2D, #094450);
            color: #fff;
            margin-top: 5px;

            text-decoration:none;

        }
    </style>
</head>

<body>
<?php
    // Ensure session_start() is called at the very beginning
    session_start();
    ?>
    <!-- The script for product animation, search, and filter functionality -->
    <script>
        function animateProductItems() {
            anime({
                targets: '.product',
                opacity: [0, 1],
                translateY: [20, 0],
                duration: 1000,
                easing: 'easeInOutQuad',
                delay: anime.stagger(100),
            });
        }

        function searchProducts() {
            var searchInput = document.getElementById('searchInput').value.toLowerCase();
            var productContainers = document.querySelectorAll('.product');

            productContainers.forEach(function (container) {
                var productName = container.querySelector('h3').innerText.toLowerCase();
                if (productName.includes(searchInput)) {
                    container.style.display = 'block';
                } else {
                    container.style.display = 'none';
                }
            });
        }

        function filterProducts(order) {
            var productContainers = document.querySelectorAll('.product');
            var sortedProducts = Array.from(productContainers).sort(function (a, b) {
                var priceA = parseFloat(a.querySelector('p:last-child').innerText.split('$')[1]);
                var priceB = parseFloat(b.querySelector('p:last-child').innerText.split('$')[1]);

                if (order === 'low') {
                    return priceA - priceB;
                } else if (order === 'high') {
                    return priceB - priceA;
                }
            });

            // Update container with sorted products
            var container = document.querySelector('.container');
            container.innerHTML = '';
            sortedProducts.forEach(function (product) {
                container.appendChild(product);
            });

            animateProductItems(); // Reapply animation
        }

        document.addEventListener('DOMContentLoaded', function () {
            animateProductItems();
            searchProducts(); // Call the search function on page load
        });
        function addToCart(productId) {
            var xhr = new XMLHttpRequest();
            
            xhr.open('POST', 'cart.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.send('product_id=' + productId);

            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        alert('Product added to cart successfully!');
                    } else {
                        alert('Failed to add product to cart.');
                    }
                }
            };
            function addToCart(productId) {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'cart.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.send('product_id=' + productId);

                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        var response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            alert('Product added to cart successfully!');
                        } else {
                            alert('Failed to add product to cart.');
                        }
                    }
                };
            }
          
}
    </script>
  

    <header>
    
        <h1>Watch maintenance and sales centers</h1>
        <?php
        if (isset($_SESSION['username'])) {
            echo "<div class='user-info'><a href='profile.php'><img src='assets\user.png' alt='User Icon' class='user-icon'></a> " . $_SESSION['username'] . "</div>";
        }
        ?>
     
    </header>

    <!-- Bootstrap Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Watch maintenance and sales centers</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="servies.php">Servies</a>
                </li>
               
            
                <li class="nav-item">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search by name" aria-label="Search" id="searchInput">
                        <div class="input-group-append">
                            <button class="btn btn-outline-light" type="button" onclick="searchProducts()">Search</button>
                        </div>
                    </div>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="login.php"><i class="fas fa-sign-in-alt"></i> Login</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "db";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM servies";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='product'>";
                echo "<h3>" . $row['names'] . "</h3>";
                // echo "<p>" . $row['image'] . "</p>";
                echo "<img src='" . $row['image'] . "' alt='" . $row['names'] . " Image'>";
                if (!empty($row['urll'])) {
                    echo "<a href='" . $row['urll'] . "' target='_blank' class='order-button'>Go to Page</a>";
                } else {
                    echo "<button class='order-button' disabled>Page URL Not Available</button>";
                }
                echo "</div>";
            }
        } else {
            echo "No Servies Available yet.";
        }

        $conn->close();
        ?>
    </div>

    <footer>
        &copy; Watch maintenance and sales centers
    </footer>

    <!-- Bootstrap JavaScript from CDN -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
