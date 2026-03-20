<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Login</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

<h2>🔐 Admin Login</h2>

<form method="POST">

<input type="password" name="password" placeholder="Enter Admin Password" required>

<br><br>

<button type="submit" class="btn">Login</button>

</form>

<?php
if(isset($_POST['password'])){

    $password = $_POST['password'];

    // 🔐 SET YOUR SECRET PASSWORD HERE
    if($password == "369000"){
        $_SESSION['admin'] = true;
        header("Location: admin.php");
    } else {
        echo "<p style='color:red;'>❌ Wrong Password</p>";
    }
}
?>

</div>

</body>
</html>