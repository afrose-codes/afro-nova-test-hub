<?php
include "db.php";

$student_id = $_GET['id'];

$sql = "SELECT * FROM questions";
$result = $conn->query($sql);

$questions = [];
while($row = $result->fetch_assoc()){
    $questions[] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Exam</title>
<link rel="stylesheet" href="style.css">

<style>
.timer{
    font-size:18px;
    color:red;
    float:right;
}

/* OPTIONS DESIGN */
.options{
    margin-top:15px;
}

.option{
    display:flex;
    align-items:center;
    gap:10px;
    background:#2a2a40;
    padding:10px;
    margin:8px 0;
    border-radius:6px;
    cursor:pointer;
}

.option:hover{
    background:#3a3a60;
}

.option input{
    width:auto;
}
</style>

</head>
<body>

<div class="container">
<h2>AfroNova Test Hub</h2>

<div class="timer">Time: <span id="time">20</span>s</div>

<form id="quizForm" action="result.php" method="POST">
<input type="hidden" name="student_id" value="<?php echo $student_id; ?>">

<div id="questionBox"></div>

<br>
<button type="button" onclick="nextQuestion()">Next</button>

</form>

</div>

<script>

let questions = <?php echo json_encode($questions); ?>;
let index = 0;
let answers = {};
let timeLeft = 20;

/* LOAD QUESTION */
function loadQuestion(){
    let q = questions[index];

    let html = `
    <p><b>${index+1}. ${q.question}</b></p>

    <div class="options">
        <label class="option">
            <input type="radio" name="q" value="1"> ${q.option1}
        </label>

        <label class="option">
            <input type="radio" name="q" value="2"> ${q.option2}
        </label>

        <label class="option">
            <input type="radio" name="q" value="3"> ${q.option3}
        </label>

        <label class="option">
            <input type="radio" name="q" value="4"> ${q.option4}
        </label>
    </div>
    `;

    document.getElementById("questionBox").innerHTML = html;

    timeLeft = 20;
    document.getElementById("time").innerText = timeLeft;
}

/* NEXT QUESTION */
function nextQuestion(){

    let selected = document.querySelector('input[name="q"]:checked');

    if(selected){
        answers[questions[index].id] = selected.value;
    }

    index++;

    if(index < questions.length){
        loadQuestion();
    } else {
        submitExam();
    }
}

/* SUBMIT */
function submitExam(){

    let form = document.getElementById("quizForm");

    for(let key in answers){
        let input = document.createElement("input");
        input.type = "hidden";
        input.name = "answers["+key+"]";
        input.value = answers[key];
        form.appendChild(input);
    }

    form.submit();
}

/* TIMER */
setInterval(function(){
    timeLeft--;
    document.getElementById("time").innerText = timeLeft;

    if(timeLeft <= 0){
        nextQuestion();
    }
},1000);

/* INITIAL LOAD */
loadQuestion();

</script>

</body>
</html>