<?php
include "db.php";

/* CHECK ID */
if(!isset($_GET['id'])){
    die("Invalid Access");
}

$id = intval($_GET['id']);

/* FETCH LATEST RESULT */
$query = $conn->query("
SELECT students.name, students.vtu, results.score, results.exam_date
FROM results
JOIN students ON results.student_id = students.id
WHERE results.student_id = $id
ORDER BY results.id DESC LIMIT 1
");

$data = $query->fetch_assoc();

if(!$data){
    die("No certificate data found!");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Certificate</title>

<style>

/* PRINT SETTINGS */
@page {
    size: A4 landscape;
    margin: 0;
}

body{
    margin:0;
    font-family:"Times New Roman";
    background:white;
}

/* FULL PAGE */
.outer{
    width:100%;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

/* CERTIFICATE BOX */
.inner{
    width:95%;
    height:90%;
    border:8px solid #1e5fa3;
    padding:60px;
    box-sizing:border-box;
    text-align:center;
    position:relative;
}

/* INNER BORDER */
.inner::before{
    content:"";
    position:absolute;
    top:25px;
    left:25px;
    right:25px;
    bottom:25px;
    border:3px solid #1e5fa3;
}

/* LOGO */
.logo{
    width:90px;
    margin-bottom:10px;
}

/* TITLE */
h1{
    font-size:28px;
    margin:10px 0;
}

/* NAME */
.name{
    font-size:42px;
    color:#1e5fa3;
    font-weight:bold;
    margin:20px 0;
}

/* TEXT */
p{
    font-size:18px;
    margin:6px;
}

/* SIGNATURE (FIXED POSITION) */
.footer{
    position:absolute;
    bottom:60px;
    right:120px;
    text-align:center;
}

/* SIGN LINE */
.sign-line{
    width:200px;
    border-top:2px solid #1e5fa3;
    margin:0 auto 10px;
}

/* BUTTON */
button{
    margin-top:15px;
    padding:10px 20px;
    background:#1e5fa3;
    color:white;
    border:none;
    cursor:pointer;
}

/* HIDE BUTTON IN PRINT */
@media print{
    button{
        display:none;
    }
}

</style>

</head>
<body>

<div class="outer">
<div class="inner">

<img src="logo.png" class="logo">

<h2>Vel Tech Rangarajan Dr. Sagunthala</h2>
<h2>R&D Institute of Science and Technology</h2>

<p><b>School of Computing</b></p>
<p><b>Department of Computer Science and Engineering</b></p>

<h1>CERTIFICATE OF ACHIEVEMENT</h1>

<p>This certificate is proudly presented to</p>

<div class="name">
<?php echo strtoupper($data['name']); ?>
</div>

<p><b>VTU No: <?php echo $data['vtu']; ?></b></p>

<p>For successfully completing the</p>

<p><b>Dynamic HTML Quiz Assessment</b></p>

<p><b>Score: <?php echo $data['score']; ?> / 20</b></p>

<p><b>Date: <?php echo date("d/m/Y", strtotime($data['exam_date'])); ?></b></p>

<!-- SIGNATURE -->
<div class="footer">

    <p><b>Dr. S. Hemamalini</b></p>

  <div class="sign-line"></div>

    <p>M.E., Ph.D</p>
    <p>Assistant Professor - Senior Grade</p>
    <p><b>Authorized Signatory</b></p>

</div>

</div>
</div>

<!-- DOWNLOAD BUTTON -->
<button onclick="window.print()">⬇ Download Certificate</button>

</body>
</html>