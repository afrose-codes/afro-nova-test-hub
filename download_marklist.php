<?php
include "db.php";

/* EXCEL HEADERS */
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=MarkList.xls");

/* COLUMN HEADINGS */
echo "VTU No\tReg No\tName\tSlot\tScore\tPercentage\n";

/* FETCH DATA */
$query = $conn->query("
SELECT students.vtu, students.reg_no, students.name, students.slot,
       results.score, results.percentage
FROM results
JOIN students ON results.student_id = students.id
ORDER BY results.score DESC
");

/* OUTPUT DATA */
while($row = $query->fetch_assoc()){
    echo $row['vtu']."\t".
         $row['reg_no']."\t".
         $row['name']."\t".
         $row['slot']."\t".
         $row['score']."\t".
         $row['percentage']."%\n";
}
?>