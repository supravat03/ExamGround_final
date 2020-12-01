<?php include('header.php') ?>
	<?php //include('auth.php') ?>
	<?php //include('dbconfig.php') ?>

<style>
		/*li.answer{
			cursor: pointer;
		}
		li.answer:hover{
			background: #00c4ff3d;
		}*/
		li.answer input:checked{
			background: #00c4ff3d;
		}
		
	</style>
<?php

if (!isset($_POST['view_subject_choosen']) &&  isset($_POST['view_quiz_choosen']))
{
	$_SESSION['test_name_for_view_quiz']=$_POST['y_give_see_quiz'];
	$test_name_for_view_quiz = $_SESSION['test_name_for_view_quiz'];
	$view_test_id = "SELECT test_id FROM quiz WHERE test_name = '$test_name_for_view_quiz'";
    $give_id_stmt=$pdo->prepare($view_test_id);
    $give_id_stmt->execute();
    $get_view_id=$give_id_stmt->fetch(PDO::FETCH_ASSOC);
    $test_id_for_view_quiz = $get_view_id['test_id'];
    $student_id_for_view_quiz = $_SESSION['student_id'];
	$subject_code_for_view_quiz = $_SESSION['subject_code_for_view_quiz'];

	$sql_to_select_question= "SELECT * FROM responses WHERE student_id='$student_id_for_view_quiz' AND test_id='$test_id_for_view_quiz'";
	$stmt_view_question=$pdo->prepare($sql_to_select_question);
	$stmt_view_question->execute();
	

	$a_stmt_for_total=$pdo->prepare("SELECT COUNT(*) AS total FROM responses WHERE student_id='$student_id_for_view_quiz' AND test_id='$test_id_for_view_quiz'");
	$a_stmt_for_total->execute();

	$r_total=$a_stmt_for_total->fetch(PDO::FETCH_ASSOC);
	$finally_total=$r_total['total'];
	

	$a_stmt_for_score=$pdo->prepare("SELECT SUM(score) AS total_score FROM responses WHERE student_id='$student_id_for_view_quiz' AND test_id='$test_id_for_view_quiz'");
	$a_stmt_for_score->execute();

	$r_score=$a_stmt_for_score->fetch(PDO::FETCH_ASSOC);
	$finally_score=$r_score['total_score'];



?>
	<div class="container-fluid admin">
		<div class="col-md-12 alert alert-success"><?php echo "Quiz Name: ".$test_name_for_view_quiz; ?> </div> 
		<div class="col-md-12 alert alert-success">SCORE : <?php echo $finally_score; ?>  / <?php echo $finally_total; ?></div>
		<br><br><br><br><br><br><br>
		<div class="card">
			<div class="card-body">
					<input type="hidden" name="user_id" value="<?php echo $_SESSION['student_id'] ?>">
					<input type="hidden" name="quiz_id" value="<?php echo $test_name_for_view_quiz ?>">
					<input type="hidden" name="qpoints" value="<?php //echo $quiz['qpoints'] ?>">
					<?php
					//$question = $conn->query("SELECT * FROM questions where qid = '".$quiz['id']."' order by id desc ");
					$i = 1 ;
					while($row =$stmt_view_question->fetch(PDO::FETCH_ASSOC) ){
						$qq_id=$row['q_id'];
						$to_get_right_answer = "SELECT * FROM question WHERE q_id='$qq_id' AND test_id=' $test_id_for_view_quiz' ";
						$stmt_to_get = $pdo->prepare($to_get_right_answer);
						$stmt_to_get->execute();
						$y_right_ans = $stmt_to_get->fetch(PDO::FETCH_ASSOC);
						//echo $y_right_ans['answer'];
						//$opt = $conn->query("SELECT * FROM question_opt where question_id = '".$row['id']."' order by RAND() ");
					//$answer = $conn->query("SELECT * FROM answers where quiz_id ='".$quiz['id']."' and user_id= '".$_SESSION['login_id']."' and question_id = '".$row['id']."'  ")->fetch_array();
					?>

				<ul class="q-items list-group mt-4 mb-4 ?>">
					<li class="q-field list-group-item">
						<strong><?php echo ($i++). '. '; ?> <?php echo $y_right_ans['question'] ?></strong>
						<input type="hidden" name="question_id[<?php echo $row['q_id'] ?>]" value="<?php echo $row['q_id'] ?>">
						<br>
						<ul class='list-group mt-4 mb-4'>
						<?php //while($orow = $opt->fetch_assoc()){ ?>
							
						<li class="answer list-group-item <?php    $y_right_ans['answer'] == 1 ? "bg-success" : "bg-danger" ?>"  <?php if($y_right_ans['answer']==1) {?> style="background-color: lightgreen !important ;" <?php }  ?><?php if($row['student_ans']==1) {?> style="background-color: brown;" <?php }  ?>  >
								<label><input type="radio" name="option_id[<?php echo $row['q_id'] ?>]" value="1" <?php echo $row['student_ans'] == 1  ? "checked='checked'" : "" ?>> <?php echo $y_right_ans['ques1'] ?></label>
							</li>

							<li class="answer list-group-item <?php echo $y_right_ans['answer'] == 2 ? "bg-success" : "bg-danger" ?>"   <?php if($y_right_ans['answer']==2) {?> style="background-color: lightgreen !important ;" <?php } ?> <?php if($row['student_ans']==2) {?> style="background-color: brown;" <?php }  ?>>
								<label><input type="radio" name="option_id[<?php echo $row['q_id'] ?>]" value="2" <?php echo $row['student_ans'] == 2 ? "checked='checked'" : "" ?>> <?php echo $y_right_ans['ques2'] ?></label>
							</li>

							<li class="answer list-group-item <?php echo $y_right_ans['answer'] == 3 ? "bg-success" : "bg-danger" ?>"  <?php if($y_right_ans['answer']==3) {?> style="background-color: lightgreen !important ;" <?php }  ?> <?php if($row['student_ans']==3) {?> style="background-color: brown;" <?php }  ?> >
								<label><input type="radio" name="option_id[<?php echo $row['q_id'] ?>]" value="3" <?php echo $row['student_ans'] == 3 ? "checked='checked'" : "" ?>> <?php echo $y_right_ans['ques3'] ?></label>
							</li>

							<li class="answer list-group-item <?php echo $y_right_ans['answer'] == 4 ? "bg-success" : "bg-danger" ?>" <?php if($y_right_ans['answer']==4) {?> style="background-color: lightgreen !important ;" <?php } ?> <?php if($row['student_ans']==4) {?> style="background-color: brown;" <?php }  ?>  >
								<label><input type="radio" name="option_id[<?php echo $row['q_id'] ?>]" value="4" <?php echo $row['student_ans'] == 4  ? "checked='checked'" : "" ?>> <?php echo $y_right_ans['ques4'] ?></label>
							</li>
						<?php //} ?>

						</ul>

					</li>
				</ul>

				<?php } ?>
			</div>	
		</div>
	</div>
	<script>
	$(document).ready(function(){
		$('input').attr('readonly',true)
		
	})
	</script>
<?php
    
}

if (isset($_POST['view_subject_choosen']) &&  !isset($_POST['view_quiz_choosen']))
{
	$_SESSION['subject_code_for_view_quiz']=$_POST['y_give_see_subject'];
	$y_give_subject_code=$_POST['y_give_see_subject'];
	$view_student_id = $_SESSION['student_id'];
	// echo $view_student_id;
	// echo $y_give_subject_code;
    $view_quiz_stmt=$pdo->prepare("SELECT * FROM `quiz` WHERE subject_code='$y_give_subject_code' AND test_id IN(SELECT  test_id FROM responses WHERE student_id='$view_student_id') " );
	$view_quiz_stmt->execute();

	if($view_quiz_stmt->rowCount()==0){
		?><h3 class="no_record">Sorry, You have not given any quiz! </h3><?php
		}
		else
	{
	
		?>
		<h2 class="heading">Select Your Quiz</h2>
		<div>
    <form method="post" enctype="multipart/form-data">
	<table style="width:540px; border: 1px solid black" class="center">
        <tr>
            <th>Select Your Quiz</th>
        </tr>
        <?php 
            while($row= $view_quiz_stmt->fetch(PDO::FETCH_ASSOC))
            {
                ?><tr><td><input type="radio" name="y_give_see_quiz" value="<?php echo $row['test_name'];?>">
                <?php echo $row['test_name'];?>    </td>
                
        <?php }
            ?><br>
           
    </table><br>
    
        <input type="submit" value="Select quiz" name="view_quiz_choosen" class="btn input_center btn-info"   />
    </form>
<?php 
    }
}












if (!isset($_POST['view_subject_choosen']) &&  !isset($_POST['view_quiz_choosen']))
{  
        
		$a_student_id=$_SESSION['student_id'];
		$view_student_id = $_SESSION['student_id'];
        $y_view_stmt=$pdo->prepare("SELECT enrolls_for.subject_code FROM enrolls_for WHERE enrolls_for.student_id='$view_student_id'" );
		$y_view_stmt->execute();
		
		if($y_view_stmt->rowCount()==0){
            ?><h3 class="no_record">Sorry, You are not enrolled in any subject! </h3><?php
			}
            else
        {
    ?> 
	<h2 class="heading">Select Your Subject</h2>
    <div>
    <form method="post" enctype="multipart/form-data">
    <table style="width:540px; border: 1px solid black" class="center">
        <tr>
            <th>Subject Code </th>
            <th>Subject Name</th>
        </tr>
        
        <?php 
            while($result= $y_view_stmt->fetch(PDO::FETCH_ASSOC))
            {
                $ak=$result['subject_code'];
                $ak_stmt=$pdo->prepare("SELECT * FROM available_subjects WHERE subject_code='$ak'");
                $ak_stmt->execute();
                $ak_name=$ak_stmt->fetch(PDO::FETCH_ASSOC);
                ?><tr><td><input type="radio" name="y_give_see_subject" value="<?php echo $result['subject_code'];?>">
                <?php echo $result['subject_code'];?>    </td>
                <td><?php echo $ak_name['subject_name']?>    </td></tr>
                
        <?php }
            ?><br>
           
    </table><br>
        <input type="submit" value="Select your Subject" name="view_subject_choosen" class="btn input_center btn-info"   />
    
    </form>
       
           
<?php 
        }
} ?>