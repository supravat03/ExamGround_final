<head>
    <style>
        .left {
  width: 82%;
}

.right {
  width: 18%;
}
div.fixed {
  position: fixed;
  top: 10;
  right: 0;
  color: brown;
  border: 6px solid black;
}
    </style>
</head>

<?php 
session_start();//just for trial
include('../../dbconfig.php');
?>
<?php include('header.php') ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  	<script src="https://cdn.jsdelivr.net/gh/guillaumepotier/Parsley.js@2.9.1/dist/parsley.js"></script>
  	 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  	<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script> 
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
  	<link rel="stylesheet" href="style/style.css" />
    <link rel="stylesheet" href="style/TimeCircles.css" />
    <script src="style/TimeCircles.js"></script>

<?php //include('auth.php') ?>
<?php

$exam_id = '';
$remaining_minutes = '';
$duration="";

if(!isset($_POST["subject"])  && (isset($_POST["quiz"]) ))
{   
    //to get the the test_id
    $_SESSION['test_name_for_give_quiz']=$_POST['a_see_quiz'];
    $test_name_for_give_quiz = $_SESSION['test_name_for_give_quiz'];
    $give_test_id = "SELECT test_id FROM quiz WHERE test_name = '$test_name_for_give_quiz'";
    $give_id_stmt=$pdo->prepare($give_test_id);
    $give_id_stmt->execute();
    $get_id=$give_id_stmt->fetch(PDO::FETCH_ASSOC);
    $test_id_for_give_quiz = $get_id['test_id'];
    $student_id_for_give_quiz = $_SESSION['student_id'];
    $subject_code_for_give_quiz = $_SESSION['subject_code_for_give_quiz'];

    // $exam_id=$test_id_for_give_quiz;
    // $query_for_timer = "SELECT * FROM quiz WHERE test_id = '$exam_id'";
    // $a_timer=$pdo->prepare($query_for_timer);
    // $a_timer->execute();
                   
    // while($a_row =$a_timer->fetch(PDO::FETCH_ASSOC))
    // {
    //     //$exam_status = $a_row['online_exam_status'];
    //     //$exam_star_time = $a_row['start_time'];
    //     $exam_star_time=date("Y-m-d H:i:s");
	// 	$duration = $a_row['duration'] . ' minute';
	// 	$exam_end_time = strtotime($exam_star_time . '+' . $duration);

	// 	$exam_end_time = date('Y-m-d H:i:s', $exam_end_time);
    //     $remaining_minutes = strtotime($exam_end_time) - time();
    //     echo $remaining_minutes;
    //     echo "arushi";
    //     echo $exam_end_time;
    //     echo "arushi";
    //     echo $duration;
    //     echo "arushi";
    //     echo $exam_star_time;
    // }

    $exam_id=$test_id_for_give_quiz;
    $query_for_timer = "SELECT * FROM quiz WHERE test_id = '$exam_id'";
    $a_timer=$pdo->prepare($query_for_timer);
    $a_timer->execute();
    while($a_row =$a_timer->fetch(PDO::FETCH_ASSOC))
    {
		$duration = $a_row['duration'];   
    }
    $_SESSION["duration"]=$duration;
    $_SESSION["start_time"]=date("Y-m-d H:i:s");
    $end_time=$end_time= date('Y-m-d H:i:s',strtotime('+'.$_SESSION["duration"].'minutes',strtotime($_SESSION["start_time"])));

    $_SESSION["end_time"]=$end_time;
    $_SESSION['subjecthai'] = $_SESSION['subject_code_for_give_quiz'];
    $_SESSION['quizkanam'] = $_SESSION['test_name_for_give_quiz'];
    $_SESSION['ladka'] =$_SESSION['student_id'];
?>
    <body>
	<style>
		li.answer{
			cursor: pointer;
		}
		li.answer:hover{
			background: #00c4ff3d;
		}
		li.answer input:checked{
			background: #00c4ff3d;
		}
	</style>
	<?php// include('nav_bar.php') ?>
	
	<div class="container-fluid admin">
		<div style="color:#428bca ; font-weight:bolder; font-size:30px;" class="col-md-12 alert yash_style alert-primary"><br><?php echo "Quiz Name: ".$test_name_for_give_quiz ?> </div>
        <div align="center" class="fixed">
                <div id="response" style="max-width:400px; font-size:50px; width: 100%; "></div>
            </div> 
        <br><br><br><br>
        <br><br><br>
<div class="card">
    <div class="row">
        <div class="collumn right">
            
        </div>
        <div class="collumn left">
			<div class="card-body">
				<form action="" id="answer-sheet">
					<input type="hidden" name="user_id" value="<?php echo $_SESSION['student_id'] ?>">
					<input type="hidden" name="quiz_id" value="<?php echo $test_id_for_give_quiz ?>">
					
                    
                    <!--input type="hidden" name="qpoints" value="<?php //echo $quiz['qpoints'] ?>"-->
					<?php
					//$question = $pdo->query("SELECT * FROM questions where qid = '".$quiz['id']."' order by order_by asc ");
                    $question_for_give_quiz = "SELECT * FROM question WHERE test_id = '$test_id_for_give_quiz' order by RAND() ";
                    $y_question=$pdo->prepare($question_for_give_quiz);
                    $y_question->execute();
                    $i = 1 ;
                    while($row =$y_question->fetch(PDO::FETCH_ASSOC))
                    {
						//$opt = $conn->query("SELECT * FROM question_opt where question_id = '".$row['id']."' order by RAND() ");
					?>

				<ul class="q-items list-group mt-4 mb-4">
					<li class="q-field list-group-item">
						<strong><?php echo ($i++). '. '; ?> <?php echo $row['question'] ?></strong>
						<input type="hidden" name="question_id[<?php echo $row['q_id'] ?>]" value="<?php echo $row['q_id'] ?>">

                        <br>
						<ul class='list-group mt-4 mb-4'>
						<?php //for($j=0;$j<4;$j++){ ?>

							 <li class="answer list-group-item">
								<label><input type="radio" name="option_id[<?php echo $row['q_id'] ?>]" value="1"> <?php echo $row['ques1'] ?></label>
                            </li>
                            <li class="answer list-group-item">
								<label><input type="radio" name="option_id[<?php echo $row['q_id'] ?>]" value="2"> <?php echo $row['ques2'] ?></label>
                            </li>
                            <li class="answer list-group-item">
								<label><input type="radio" name="option_id[<?php echo $row['q_id'] ?>]" value="3"> <?php echo $row['ques3'] ?></label>
                            </li>
                            <li class="answer list-group-item">
								<label><input type="radio" name="option_id[<?php echo $row['q_id'] ?>]" value="4"> <?php echo $row['ques4'] ?></label>
							</li> 
						<?php //} ?>

						</ul>

					</li>
				</ul>

				<?php } ?>
				 <button  class="btn btn-block btn-primary">Submit</button> 
				</form>
			</div>	
		</div>
                
    </div>
</div>
	
</body>
<script type="text/javascript">
	$(document).ready(function()
    {



        // $("#exam_timer").TimeCircles({ 
		// time:{
		// 	Days:{
		// 		show: false
		// 	},
		// 	Hours:{
		// 		show: false
        //         }
        //     }
        // });


        // setInterval(function()
        //     {
        //         var xmlhttp = new XMLHttpRequest();
        //         xmlhttp.open("GET","response.php",false);
        //         xmlhttp.send(null);
        //         document.getElementById("response").innerHTML=xmlhttp.responseText;
                
        //             //alert('Exam time over');
        //             header('location:index.php')               

        //     },1000);

//         if((hours==00)&&(mins==00)&&(secs==00)) {
//   document.getElementById('yourForm').submit();
// } else {
//   setTimeout(countdownto, 1000);
// }

var myVar = setInterval(myTimer, 1000);

function myTimer() {
 
   var xmlhttp = new XMLHttpRequest();
  xmlhttp.open("GET","response.php",false);
  xmlhttp.send(null);

  if(xmlhttp.responseText == "Time Out"){
    myStopFunction();
     
    
   $('#answer-sheet').submit();
    window.location.href='index.php';
  }
  $('#response').html(xmlhttp.responseText);
}



function myStopFunction() {
  clearInterval(myVar);

}

        


        // setInterval(function(){
        //     var remaining_second = $("#exam_timer").TimeCircles().getTime();
        //     if(remaining_second < 1)
        //     {
        //         alert('Exam time over');
        //         location.reload();
        //     }
        // }, 1000);

        



		$('.answer').each(function()
        {
		$(this).click(function()
        {
			$(this).find('input[type="radio"]').prop('checked',true)
			$(this).css('background','lightgreen')
			$(this).siblings('li').css('background','white')
		})
        })



		$('#answer-sheet').submit(function(e)
        {
			e.preventDefault()
			$('#answer-sheet [type="submit"]').attr('disabled',true)
			$('#answer-sheet [type="submit"]').html('Saving...')
			$.ajax({
				url:'submit_answer.php',
				method:'POST',
				data:$(this).serialize(),
				error:err=>console.log(err),
				success:function(resp){
					if(typeof resp != undefined)
                    {
						resp = JSON.parse(resp)
					if(resp.status == 1)
                    {
						alert('You completed the quiz your score is '+resp.score)
						
                        location.replace('index.php?quiz_part=view_answer');
                        <?php //header('location:../index.php')?>
					}
					}
				}
			})
		})
		
	})
</script>

    



<?php
}
?>
<?php






/*if(isset($_POST["subject"]) && !isset($_POST["quiz"]) ){
    $_SESSION['subject_code_for_give_quiz']=$_POST['a_see_subject'];
    $a_subject_code=$_SESSION['subject_code_for_give_quiz'];
    $a_student_id=$SESSION['student_id'];
    $give_quiz_stmt=$pdo->prepare("SELECT * FROM `quiz` WHERE subject_code='$a_subject_code' AND test_id NOT IN(SELECT test_id FROM responses WHERE student_id='a_student_id')" );
    $give_quiz_stmt->execute();
    ?>
    <div>
    <form method="post" enctype="multipart/form-data">
        
        <td>Select Your Quiz </td>
        <Td><select name="a_see_quiz" id="" class="form-control" required>
        <?php 
            while($row= $give_quiz_stmt->fetch(PDO::FETCH_ASSOC))
            {?>
                <option value="<?php echo $row['test_name'];?>"><?php echo $row['test_name'];?></option>
        
        <?php }
            ?>
            <input type="submit" value="Select Quiz" name="quiz" class="btn btn-info"/>
        </select>
        </td>
            </form>
<?php 
}*/
if(isset($_POST["subject"]) && !isset($_POST["quiz"]) ){
    $_SESSION['subject_code_for_give_quiz']=$_POST['a_see_subject'];
	$a_subject_code=$_POST['a_see_subject'];
	$a_student_id=$_SESSION['student_id'];
    $give_quiz_stmt=$pdo->prepare("SELECT * FROM `quiz` WHERE subject_code='$a_subject_code' AND test_id NOT IN(SELECT test_id FROM responses WHERE student_id='$a_student_id') " );
	$give_quiz_stmt->execute();
    
    
    if($give_quiz_stmt->rowCount()==0){
        ?><h3 class="no_record">Sorry, There are no pending quiz! </h3><?php
        }
        else
    {

    ?>
    <h2 class="heading">Select Your Quiz</h2>
    <div>
    
    <form method="post" enctype="multipart/form-data">
    <table style="width:540px; border: 1px solid black" class="center">
        <tr>
            <th>Quiz Name</th>
        </tr>
        <!--td><select name="a_see_subject" id="" class="form-control" required-->
        <?php 
            while($row= $give_quiz_stmt->fetch(PDO::FETCH_ASSOC))
            {
                ?><tr><td><input type="radio" name="a_see_quiz" value="<?php echo $row['test_name'];?>">
                <?php echo $row['test_name'];?>    </td>
                
        <?php }
            ?><br>
           
    </table><br>
    
        <input type="submit" value="Select quiz" name="quiz" class="btn input_center btn-info"   />
    </form>
<?php 
    }
}







if(!isset($_POST["subject"]) && !isset($_POST["quiz"]) )
{   
        
        $a_student_id=$_SESSION['student_id'];
        $a_stmt=$pdo->prepare("SELECT enrolls_for.subject_code FROM enrolls_for WHERE enrolls_for.student_id='$a_student_id'" );
        $a_stmt->execute();

        if($a_stmt->rowCount()==0){
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
        <!--td><select name="a_see_subject" id="" class="form-control" required-->
        <?php 
            while($result= $a_stmt->fetch(PDO::FETCH_ASSOC))
            {
                $ak=$result['subject_code'];
                $ak_stmt=$pdo->prepare("SELECT * FROM available_subjects WHERE subject_code='$ak'");
                $ak_stmt->execute();
                $ak_name=$ak_stmt->fetch(PDO::FETCH_ASSOC);
                ?><tr><td><input type="radio" name="a_see_subject" value="<?php echo $result['subject_code'];?>">
                <?php echo $result['subject_code'];?>    </td>
                <td><?php echo $ak_name['subject_name']?>    </td></tr>
                
        <?php }
            ?><br>
           
    </table><br>
        <input type="submit" value="Select your Subject" name="subject" class="btn input_center btn-info"   />
    
    </form>
       
           
<?php 
        }
} ?>