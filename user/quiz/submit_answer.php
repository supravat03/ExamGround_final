<?php 

session_start();
include('../../dbconfig.php');
error_reporting(1);

extract($_POST);
$points = 0;
//echo $_SESSION['student_id'];
foreach ($question_id as $key => $value) 
{
	//$data = ' q_id = '.$user_id;
	//$data .= ', quiz_id =  '.$quiz_id;
	//$data .= ', question_id = "'.$question_id[$key].'" ';
	$is_right = 0;
     $current_question_id=$question_id[$key];
	 $query="SELECT * FROM question WHERE q_id='$current_question_id' AND test_id='$quiz_id'";
	 $ans_stmt=$pdo->prepare($query);
	 $ans_stmt->execute();
     $r=$ans_stmt->fetch(PDO::FETCH_ASSOC);
     //if(count($r)==0)echo "kyabhgya";
     $check=0;
	 if(isset($option_id[$key])){
	 	if($option_id[$key] == $r['answer']){
	 		$check=1;
	 	}
     }
    // header('location:index.php');
    
	//$data .= ', is_right = "'.$is_right.'" ';
	//$insert = $conn->query("INSERT INTO answers set ".$data);
	if( $check > 0)
        { $points++;}
    
    
    // // echo("INSERT INTO answers set ".$data);
    // $into_response = "INSERT INTO responses(q_id, test_id, student_id, student_ans, score) 
    // VALUES (':q_id' , ':test_id' , ':student_id' , ':student_ans' ,':score' )";
    // $prep_response = $pdo->prepare($into_response);
    // $prep_response->execute(array(
    //     ':q_id' =>$question_id[$key],
    //     ':test_id' =>  $quiz_id,
    //     ':student_id' =>$user_id,
    //     ':student_ans' => $option_id[$key],
    //     ':score' => $check
    // ));
    $ttt="INSERT INTO `responses` (`q_id`, `test_id`, `student_id`, `student_ans`, `score`)
     VALUES ('$question_id[$key]', '$quiz_id', '$user_id', '$option_id[$key]', '$check')";
     $tst=$pdo->prepare($ttt);
     $tst->execute();
    
}
 $qpoints=1;//mne liki
 $score = $points * $qpoints;
$total = count($question_id) * $qpoints;
	// $data = ' quiz_id =  '.$quiz_id;
	// $data .= ', user_id = '.$user_id;
	// $data .= ', score =  '.$score;
	// $data .= ', total_score =  '.$total;
	// $insert2 = $conn->query("INSERT INTO history set ".$data);
    // if($insert2)*/
   // $score=1;
   // $total=2;
	echo json_encode(array('status'=>1,'score'=>$score.'/'.$total));
?>