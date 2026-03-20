<?php
include "db.php";
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Panel</title>

<style>
body{
    font-family: Arial;
    background:#0f2027;
    color:white;
    text-align:center;
}

.container{
    width:80%;
    margin:40px auto;
}

h2{
    margin-bottom:20px;
}

/* BUTTON */
.btn{
    display:inline-block;
    padding:10px 20px;
    background:#4CAF50;
    color:white;
    text-decoration:none;
    border-radius:5px;
    margin-bottom:20px;
}

/* TABLE */
table{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
}

th, td{
    padding:10px;
    border:1px solid #ccc;
}

th{
    background:#1e5fa3;
}

tr:nth-child(even){
    background:#2a2a40;
}

tr:nth-child(odd){
    background:#1e1e2f;
}

/* TOP 3 */
.top3{
    display:flex;
    justify-content:space-around;
    margin-bottom:30px;
}

.card{
    background:#1e1e2f;
    padding:20px;
    border-radius:10px;
    width:25%;
}

.gold{ color:gold; }
.silver{ color:silver; }
.bronze{ color:#cd7f32; }

</style>

</head>
<body>

<div class="container">

<h2>🏆 Admin Dashboard</h2>

<!-- 📥 DOWNLOAD BUTTON -->
<a href="download_marklist.php" class="btn">
📥 Download Mark List
</a>

<!-- TOP 3 -->
<h3>Top 3 Students</h3>

<div class="top3">

<?php
$top = $conn->query("
SELECT students.name, results.score
FROM results
JOIN students ON results.student_id = students.id
ORDER BY results.score DESC
LIMIT 3
");

$i = 1;

while($row = $top->fetch_assoc()){

    $class = ($i==1) ? "gold" : (($i==2) ? "silver" : "bronze");

    echo "<div class='card'>
            <h3 class='$class'>#$i</h3>
            <p>".$row['name']."</p>
            <p>Score: ".$row['score']."</p>
          </div>";

    $i++;
}
?>

</div>

<!-- ALL STUDENTS -->
<h3>All Students Result</h3>

<table>
<tr>
<th>VTU No</th>
<th>Reg No</th>
<th>Name</th>
<th>Slot</th>
<th>Score</th>
<th>Percentage</th>
<th>Date</th>
</tr>

<?php
$result = $conn->query("
SELECT students.vtu, students.reg_no, students.name, students.slot,
       results.score, results.percentage, results.exam_date
FROM results
JOIN students ON results.student_id = students.id
ORDER BY results.score DESC
");

while($row = $result->fetch_assoc()){
?>

<tr>
<td><?php echo $row['vtu']; ?></td>
<td><?php echo $row['reg_no']; ?></td>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['slot']; ?></td>
<td><?php echo $row['score']; ?></td>
<td><?php echo number_format($row['percentage'],2); ?>%</td>
<td><?php echo $row['exam_date']; ?></td>
</tr>

<?php } ?>

</table>

</div>

</body>
</html>