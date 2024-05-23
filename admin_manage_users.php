<?php
// تأسيس الاتصال بقاعدة البيانات
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db";

$conn = new mysqli($servername, $username, $password, $dbname);

// التحقق من الاتصال
if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

// إضافة مستخدم جديد
if(isset($_POST['add_user'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $id_number = $_POST['id_number'];
    $date_of_birth = $_POST['date_of_birth'];
    $telephone = $_POST['telephone'];
    
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO userss (username, password_hash, email, address, id_number, date_of_birth, telephone) VALUES ('$username', '$password_hash', '$email', '$address', '$id_number', '$date_of_birth', '$telephone')";
    
    if ($conn->query($sql) === TRUE) {
        echo "تمت إضافة المستخدم بنجاح";
    } else {
        echo "حدث خطأ أثناء الإضافة: " . $conn->error;
    }
}

// حذف مستخدم
if(isset($_GET['delete_user'])) {
    $user_id = $_GET['delete_user'];
    
    $sql = "DELETE FROM userss WHERE id=$user_id";
    
    if ($conn->query($sql) === TRUE) {
        echo "تم حذف المستخدم بنجاح";
    } else {
        echo "حدث خطأ أثناء الحذف: " . $conn->error;
    }
}

// استعلام لاسترداد المستخدمين
$sql = "SELECT * FROM userss";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم المستخدمين</title>
    <link rel="icon" type="image/x-icon" href="assets\logo.ico">

    <link rel="stylesheet" href="use.css">
</head>
<body>
    <div class="form1">
        <div>

            <h2>Add Users</h2>
            <img src="assets\logo1.png" alt="">
        </div>


        <form method="post" action="">
            <label for="username">Username</label><br>
            <input type="text" id="username" name="username" required><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br>
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" required><br>
            <label for="address">Address:</label><br>
            <input type="text" id="address" name="address"><br>
            <!-- <label for="id_number">رقم الهوية:</label><br> -->
            <!-- <input type="text" id="id_number" name="id_number"><br> -->
            <label for="date_of_birth">Birth Day:</label><br>
            <input type="date" id="date_of_birth" name="date_of_birth"><br>
            <label for="telephone">Telephone</label><br>
            <input type="text" id="telephone" name="telephone"><br><br>
            <input type="submit" value="Add User" name="add_user" class="but1">
        </form>
    </div>
    
    <h2>Manage Users</h2>
    <table border="1">
        <tr>
            <th>الرقم</th>
            <th>اسم المستخدم</th>
            <th>البريد الإلكتروني</th>
            <th>العنوان</th>
            <!-- <th>رقم الهوية</th> -->
            <th>تاريخ الميلاد</th>
            <th>رقم الهاتف</th>
            <th>التحكم</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row["id"]."</td>";
                echo "<td>".$row["username"]."</td>";
                echo "<td>".$row["email"]."</td>";
                echo "<td>".$row["address"]."</td>";
                // echo "<td>".$row["id_number"]."</td>";
                echo "<td>".$row["date_of_birth"]."</td>";
                echo "<td>".$row["telephone"]."</td>";
                echo "<td><a href='?delete_user=".$row["id"]."'>حذف</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8'>Don't Find Users</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>
