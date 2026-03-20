<?php
include "db.php";

/* SECURITY CHECK */
if(!isset($_POST['answers'])){
    die("Invalid Access");
}

/* SAFE STUDENT ID */
$student_id = intval($_POST['student_id']);
$score = 0;

/* TOTAL QUESTIONS */
$total_query = $conn->query("SELECT COUNT(*) AS total FROM questions");
$total = $total_query->fetch_assoc()['total'];

/* CALCULATE SCORE */
foreach($_POST['answers'] as $qid => $answer){

    $qid = intval($qid);

    $sql = "SELECT correct_option FROM questions WHERE id=$qid";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if($row['correct_option'] == $answer){
        $score++;
    }
}

/* PERCENTAGE */
$percentage = ($score/$total)*100;

/* FEEDBACK + LEVEL */
if($percentage >= 90){
    $feedback = "🎉🎉 AMAZING PERFORMANCE! 🚀🔥 
    You absolutely crushed it! 💯  
    You're a Spring Boot Master 🧠✨  
    Keep shining like a star ⭐";
    $level = "Expert Level";
    $color = "green";
}
elseif($percentage >= 75){
    $feedback = "🥳 GREAT JOB! 🎯🔥 
    You're doing fantastic! 💪  
    Just a little more practice and you'll be unstoppable 🚀";
    $level = "Advanced Level";
    $color = "limegreen";
}
elseif($percentage >= 50){
    $feedback = "👍 GOOD EFFORT! 😊  
    You're on the right track 🚶‍♂️  
    Keep learning and you'll improve quickly 📈";
    $level = "Intermediate Level";
    $color = "orange";
}
else{
    $feedback = "😅 DON'T WORRY! 💙  
    Practice more and come back stronger 💪🔥";
    $level = "Beginner Level";
    $color = "red";
}

/* 🔥 IMPORTANT FIX (ESCAPE FEEDBACK) */
$safe_feedback = mysqli_real_escape_string($conn, $feedback);

/* SAVE RESULT */
$insert = "INSERT INTO results (student_id, score, percentage, feedback)
           VALUES ('$student_id','$score','$percentage','$safe_feedback')";

if(!$conn->query($insert)){
    die("Insert Error: ".$conn->error);
}

/* FETCH STUDENT DETAILS */
$student_query = $conn->query("SELECT * FROM students WHERE id = $student_id");
$student = $student_query->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
<title>Result</title>
<link rel="stylesheet" href="style.css">

<style>
.result-box{
    background:#2a2a40;
    padding:20px;
    border-radius:10px;
    margin-top:15px;
    color:white;
}

.feedback-box{
    background:#1e1e2f;
    padding:20px;
    border-radius:10px;
    margin-top:15px;
    animation: pop 0.5s ease;
}

@keyframes pop{
    from{transform:scale(0.8); opacity:0;}
    to{transform:scale(1); opacity:1;}
}
</style>

</head>
<body>

<div class="container">

<h2>🎯 Exam Result</h2>

<div class="result-box">

<p><b>Name:</b> <?php echo $student['name']; ?></p>
<p><b>VTU No:</b> <?php echo $student['vtu']; ?></p>
<p><b>Reg No:</b> <?php echo $student['reg_no']; ?></p>
<p><b>Slot:</b> <?php echo $student['slot']; ?></p>

<hr>

<p><b>Score:</b> <?php echo $score; ?> / <?php echo $total; ?></p>
<p><b>Percentage:</b> <?php echo number_format($percentage,2); ?>%</p>

<p><b>Level:</b> 
<span style="color:<?php echo $color; ?>">
<?php echo $level; ?>
</span>
</p>

</div>

<div class="feedback-box">
<h3 style="color:<?php echo $color; ?>">
<?php echo nl2br($feedback); ?>
</h3>
</div>

<br>

<!-- 🎓 CERTIFICATE BUTTON -->
<a href="certificate.php?id=<?php echo urlencode($student_id); ?>" class="btn">
🎓 Download Certificate
</a>

<br><br>

<a href="index.php" class="btn">🏠 Go Home</a>

</div>

</body>
</html>