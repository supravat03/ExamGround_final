<?php

 include('header.php');

if(!isset($_POST['subject']) &&  isset($_POST['quiz']) && !isset($_POST['student']) && !isset($_POST['result']) )
{

        $a_test_name=$_POST['quiz_choosen_to_add_question'];
        $a_sub_code=$_SESSION['subject_code'];
        $a_query_t_id=$pdo->prepare("SELECT * FROM quiz WHERE test_name='$a_test_name' AND subject_code='$a_sub_code'");
        $a_query_t_id->execute();
        $a_row_for_result=$a_query_t_id->fetch(PDO::FETCH_ASSOC);
        $a_test_id=$a_row_for_result['test_id'];


        $a_query_student=$pdo->prepare("SELECT DISTINCT student_id FROM responses WHERE test_id='$a_test_id'");
        $a_query_student->execute();

        if ($a_query_student->rowCount() == 0) {
            ?><h3 class="no_record">Sorry, Quiz not submitted by any student ! </h3><?php
        }
        else
        {
        ?>

            <div class="row">
				<div class="col-sm-12" style="color:blue;">
					<h1 align="center" >RESULT</h1>
				</div>
			</div>
			<div class="row">

			<div class="col-sm-12">

			<table class="table table-bordered">

				<thead >
				
				<tr class="success">
					<th>Serial No.</th>
                    <th>Student Email</th>
					<th>Student Name</th>
					<th>Score</th>
					</tr>
					</thead>
					
					<?php

                $i=1;
                while($a_row_for_student=$a_query_student->fetch(PDO::FETCH_ASSOC))
                {

                    $a_student_id=$a_row_for_student['student_id'];

                    $a_stmt_for_student_name=$pdo->prepare("SELECT * FROM student WHERE student_id='$a_student_id'");
                    $a_stmt_for_student_name->execute();

                    $r_student=$a_stmt_for_student_name->fetch(PDO::FETCH_ASSOC);
                    $finally_name=$r_student['student_name'];
                    $finally_email=$r_student['student_email'];

                    
                    $a_stmt_for_score=$pdo->prepare("SELECT SUM(score) AS total_score FROM responses WHERE student_id='$a_student_id' AND test_id='$a_test_id'");
                    $a_stmt_for_score->execute();

                    $r_score=$a_stmt_for_score->fetch(PDO::FETCH_ASSOC);
                    $finally_score=$r_score['total_score'];

                        echo "<tr>";
                        echo "<td>".$i."</td>";
                        echo "<td>".$finally_email."</td>";
						echo "<td>".$finally_name."</td>";
                        echo "<td>".$finally_score."</td>";
                    
						$i++;
						echo "</tr>";

                }
                ?>
					
                </table>
                </div>
                </div>
            <?php


                    // $ak_stmt_student = $pdo->prepare("SELECT * FROM student where student_id='$a_student_id'");
                    // $ak_stmt_student->execute();    

    }
    

}








if(isset($_POST['subject']) &&  !isset($_POST['quiz']) && !isset($_POST['student']) && !isset($_POST['result']) )
{

            $sub_code = $_POST['subject_choosen_for_quiz'];
            $_SESSION['subject_code']=$_POST['subject_choosen_for_quiz'];

            $new_stmt=$pdo->prepare("SELECT quiz.test_name FROM quiz WHERE subject_code='$sub_code'" );
            $new_stmt->execute();


            if($new_stmt->rowCount()==0){
                ?><h3 class="no_record">Sorry, There are no quiz! </h3><?php
                }
                else
            {
            ?>
            <h2 class="heading">SELECT Your Quiz for <?php echo $sub_code?></h2>
            <div>
            
            <form method="post" enctype="multipart/form-data">
            <table style="width:540px; border: 1px solid black" class="center">
                <tr>
                    <th>Quiz Name</th>
                </tr>
                <!--td><select name="a_see_subject" id="" class="form-control" required-->
                <?php 
                    while($row= $new_stmt->fetch(PDO::FETCH_ASSOC))
                    {
                        ?><tr><td><input type="radio" name="quiz_choosen_to_add_question" value="<?php echo $row['test_name'];?>">
                        <?php echo $row['test_name'];?>    </td>
                        
                <?php }
                    ?><br>
                
            </table><br>
            
                <input type="submit" value="Select quiz" name="quiz" class="btn input_center btn-info"   />
            </form>
            <?php
    }
}





if(!isset($_POST['subject']) &&  !isset($_POST['quiz']) && !isset($_POST['student']) && !isset($_POST['result']) )
{

            $id=$_SESSION['p_id'];

                $new_stmt=$pdo->prepare("SELECT subject.subject_code FROM subject WHERE p_id='$id'" );
                $new_stmt->execute();


                if($new_stmt->rowCount()==0){
                    ?><h3 class="no_record">Sorry, There are no subjects! </h3><?php
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
                        while($result= $new_stmt->fetch(PDO::FETCH_ASSOC))
                        {
                            $ak=$result['subject_code'];
                            $ak_stmt=$pdo->prepare("SELECT * FROM available_subjects WHERE subject_code='$ak'");
                            $ak_stmt->execute();
                            $ak_name=$ak_stmt->fetch(PDO::FETCH_ASSOC);
                            ?><tr><td><input type="radio" name="subject_choosen_for_quiz" value="<?php echo $result['subject_code'];?>">
                            <?php echo $result['subject_code'];?>    </td>
                            <td><?php echo $ak_name['subject_name']?>    </td></tr>
                            
                    <?php }
                        ?><br>
                    
                </table><br>
                    <input type="submit" value="Select your Subject" name="subject" class="btn input_center btn-info"   />
                
                </form>

            <?php
            }
}
?>