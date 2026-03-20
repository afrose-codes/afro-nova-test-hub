<?php
include "db.php";

if(!$conn){
    die("Database not connected!");
}

if(isset($_POST['submit'])){

    $name = $_POST['name'];
    $vtu = $_POST['vtu'];
    $reg_no = $_POST['reg_no'];
    $slot = $_POST['slot'];

    $sql = "INSERT INTO students (name, vtu, reg_no, slot)
            VALUES ('$name','$vtu','$reg_no','$slot')";

    if($conn->query($sql)){
        $student_id = $conn->insert_id;
        header("Location: exam.php?id=$student_id");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Student Registration</h2>

    <form method="POST">

        <input type="text" name="name" placeholder="Enter Name" required><br><br>

        <input type="text" name="vtu" placeholder="Enter VTU No" required><br><br>

        <input type="text" name="reg_no" placeholder="Enter Register No" required><br><br>

        <input type="text" name="slot" placeholder="Enter Slot" required><br><br>

        <button type="submit" name="submit">Start Exam</button>

    </form>
</div>

</body>
</html>