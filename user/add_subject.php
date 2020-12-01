
<?php
require_once('dbconfig.php');
//echo "yash";
$code = $_GET['get_code'];
$id=$_SESSION['student_id'];
echo $code;
echo "\n";
echo $id;

//$sql = "INSERT INTO enrolls_for(student_id,subject_code) VALUES ('11','$code' )";
//$stmt=$pdo->prepare($sql);
$stmt=$pdo->prepare("INSERT INTO enrolls_for(student_id,subject_code) VALUES ('11','$code' )");
$stmt->execute();
header('location:index.php');
//mysqli_query($pdo, "INSERT INTO enrolls_for(student_id,subject_code) VALUES ('$id','$code' )") or die(mysqli_error($pdo));
echo "done";
//header('location:add_subject.php');

?>

