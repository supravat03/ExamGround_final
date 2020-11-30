<head>
<style>
table
{
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th
{
  border: 1px solid #dddddd;
  
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
</head>
<?php include('header.php') ?>
<?php 
if(!isset($_POST["subject"])  && (isset($_POST["quiz"]) || isset($_POST["edit"]) || isset($_POST["update"]) || isset($_POST["delete"]) ) )
{

    if(isset($_POST["update"])){
        $a_test_id_for_update=$_SESSION["a_test_id_for_view_paper"];
        $a_q_id_for_update=$_SESSION['$a_q_id'];
        $Q = $_POST['questions'];
        $op1 = $_POST['op1'];
        $op2 = $_POST['op2'];
        $op3 = $_POST['op3'];
        $op4 = $_POST['op4'];
        $ans = $_POST['ans'];
        $a_update_stmt_for_ques = $pdo->prepare("UPDATE question SET question ='$Q', ques1='$op1',ques2='$op2',ques3='$op3',ques4='$op4',answer='$ans'  WHERE test_id='$a_test_id_for_update' AND q_id='$a_q_id_for_update'");
		$a_update_stmt_for_ques->execute();

	echo $err="<font color='green'>Question updated</font>";

    }
    if(isset($_POST["delete"]))
    {
        $y_q_id= $_POST['select_question'];
        $y_test_id=$_SESSION["a_test_id_for_view_paper"];
        echo $y_q_id;
        echo $y_test_id;
        $y_del= " DELETE FROM question WHERE q_id='$y_q_id' AND test_id='$y_test_id'";
        $y_ds=$pdo->prepare($y_del);
        $y_ds->execute();
        echo $err="<font color='green'>Question deleted</font>";

    }
    if(isset($_POST["quiz"])){

    $test_name=$_POST['see_quiz'];
    $code=$_SESSION['subject_code_for_view'];
    $question_stmt=$pdo->prepare("SELECT * FROM question WHERE test_id IN (SELECT test_id FROM quiz WHERE subject_code= '$code' AND test_name='$test_name') " );
    $question_stmt->execute();

    if($question_stmt->rowCount()==0){
        ?><h3 class="no_record">Sorry, There are no Questions ! </h3><?php
    }

    else{
        ?>
            <?php
            ?>


    <h2 class="heading">Select Your Quiz</h2>
    <div>
    
    <form method="post" enctype="multipart/form-data">
    <table style="width:680px; border: 1px solid black" class="center">
                <tr>
                    <th>Serial No </th>
                    <th>Question</th>
                    <th>Right Answer</th>
                    
                </tr>
        <?php 
            while($r= $question_stmt->fetch(PDO::FETCH_ASSOC))
            {
                $_SESSION["a_test_id_for_view_paper"]=$r['test_id'];
                ?><tr><td><input type="radio" name="select_question" value="<?php echo $r['q_id'];?>">
                <?php echo $r['q_id'];?>    </td>
                <td><?php echo $r['question']?></td>
                    <td><?php echo $r['answer']?></td>
                
        <?php }
            ?><br>
           
    </table><br>
    
        <input type="submit" value="Edit" name="edit" class="btn input_center btn-info"   />
        <input type="submit" value="Delete" name="delete" class="btn input_center btn-info"   />
    
    </form>
            
            <?php 
        
        }
    }
        if(isset($_POST["edit"])){
            $_SESSION['$a_q_id']=$_POST['select_question'];
            $a_q_id=$_POST['select_question'];
            $a_test_id=$_SESSION["a_test_id_for_view_paper"];
            $a_edit_stmt = $pdo->prepare("SELECT * FROM question WHERE test_id='$a_test_id' AND q_id='$a_q_id'");
            $a_edit_stmt->execute();
            $res = $a_edit_stmt->fetch(PDO::FETCH_ASSOC);

            ?>
            <form id="add_Q_form" action="" method="post">
                    <h4>Enter question</h4>
                    <p> <textarea value="<?php echo @$res['question'];?>" name="questions" id="" cols="70" rows="3" required><?php echo @$res['question'];?></textarea> </p>
                    <p> enter option 1 <input type="text" value="<?php echo @$res['ques1'];?>" name="op1" class="Q" id="" required> </p>
                    <p> enter option 2 <input type="text" value="<?php echo @$res['ques2'];?>" name="op2" class="Q" id="" required> </p>
                    <p> enter option 3 <input type="text" value="<?php echo @$res['ques3'];?>" name="op3" class="Q" id="" required> </p>
                    <p> enter option 4 <input type="text" value="<?php echo @$res['ques4'];?>" name="op4" class="Q" id="" required> </p>
                    <p>
                        Enter Answer
                        <select name="ans" id="" style="margin-left: 10px;" required>
                            <option value="1">option 1</option>
                            <option value="2">option 2</option>
                            <option value="3">option 3</option>
                            <option value="4">option 4</option>
                        </select>

                    </p>

                    <p><input type="submit" value="Update" name="update" class="btn btn-info"/></p>
                </form>
            <?php
        }
}
if(isset($_POST["subject"]) && !isset($_POST["quiz"]) ){
    $_SESSION['subject_code_for_view']=$_POST['see_subject'];
    $subject_code=$_POST['see_subject'];
    $quiz_stmt=$pdo->prepare("SELECT * FROM quiz WHERE subject_code='$subject_code' " );
    $quiz_stmt->execute();
    if($quiz_stmt->rowCount()==0){
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
            while($row= $quiz_stmt->fetch(PDO::FETCH_ASSOC))
            {
                ?><tr><td><input type="radio" name="see_quiz" value="<?php echo $row['test_name'];?>">
                <?php echo $row['test_name'];?>    </td>
                
        <?php }
            ?><br>
           
    </table><br>
    
        <input type="submit" value="Select quiz" name="quiz" class="btn input_center btn-info"   />
    </form>
<?php 
}
}
if(!isset($_POST["subject"]) && !isset($_POST["quiz"]) && !isset($_POST["edit"]))
{   
        $p_id=$_SESSION['p_id'];
        $stmt=$pdo->prepare("SELECT * FROM subject WHERE p_id='$p_id' " );
        $stmt->execute();
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
            while($result= $stmt->fetch(PDO::FETCH_ASSOC))
            {
                $ak=$result['subject_code'];
                $ak_stmt=$pdo->prepare("SELECT * FROM available_subjects WHERE subject_code='$ak'");
                $ak_stmt->execute();
                $ak_name=$ak_stmt->fetch(PDO::FETCH_ASSOC);
                ?><tr><td><input type="radio" name="see_subject" value="<?php echo $result['subject_code'];?>">
                <?php echo $result['subject_code'];?>    </td>
                <td><?php echo $ak_name['subject_name']?>    </td></tr>
                
        <?php }
            ?><br>
           
    </table><br>
        <input type="submit" value="Select your Subject" name="subject" class="btn input_center btn-info"   />
    
    </form>
<?php 
} ?>