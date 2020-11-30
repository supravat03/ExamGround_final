<?php   session_start(); 
include('header.php') ?>
<?php



if(isset($_POST['subject']) &&  !isset($_POST['quiz']) && !isset($_POST['question']) )
{
    $sub_code = $_POST['subject_choosen_for_quiz'];
    $_SESSION['subject_code']=$_POST['subject_choosen_for_quiz'];

    $new_stmt=$pdo->prepare("SELECT quiz.test_name FROM quiz WHERE subject_code='$sub_code'" );
    $new_stmt->execute();
    if($new_stmt->rowCount()==0){
        ?><h3 class="no_record">Sorry, There are no quiz to add Question ! </h3><?php
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

if(!isset($_POST['subject']) &&  ( isset($_POST['quiz']) || isset($_POST['question']) ) )
{
    if (isset($_POST['question']) )
    {
        $code=$_SESSION['subject_code'];
        $t_name = $_SESSION['test_name'];
        $calculate_number_of_question = " SELECT MAX(q_id) AS to_get_max FROM question JOIN quiz ON  quiz.test_id = question.test_id WHERE quiz.subject_code='$code'AND quiz.test_name='$t_name' ";
        $stmnt=$pdo->prepare($calculate_number_of_question);
        $stmnt->execute();
        $c_r=$stmnt->fetch(PDO::FETCH_ASSOC);
        
        $q_id=$c_r['to_get_max']+1;
        

        
        $get_t_id = "SELECT test_id FROM quiz WHERE test_name='$t_name' AND subject_code='$code'";
        $prep=$pdo->prepare($get_t_id);
        $prep->execute();
        $r= $prep->fetch(PDO::FETCH_ASSOC);
        $Q = $_POST['questions'];
        $op1 = $_POST['op1'];
        $op2 = $_POST['op2'];
        $op3 = $_POST['op3'];
        $op4 = $_POST['op4'];
        $ans = $_POST['ans'];
        
    

        $insert_sql = "INSERT INTO question VALUES (:q_id,:test_id,:question,:ques1,:ques2,:ques3,:ques4,:answer)";
        $insert_stmt = $pdo->prepare($insert_sql);
	    $insert_stmt->execute(array(
            ':q_id' => $q_id,
            ':test_id' => $r['test_id'],
            ':question' => $Q,
            ':ques1' => $op1,
            ':ques2' => $op2,
            ':ques3' => $op3,
            ':ques4' => $op4,
            ':answer' => $ans));

          echo  $err="<font color='blue'><h3 align='center'>Question added successfully !! You can add more or go to view paper to see questions.<h3></font>";
        }
    if(isset($_POST['quiz'])){
        $_SESSION['test_name']=$_POST['quiz_choosen_to_add_question'];
    
    }
    ?>
    <form id="add_Q_form" action="" method="post">
                    <h4>Enter question</h4>
                    <p> <textarea name="questions" id="" cols="70" rows="3" required></textarea> </p>
                    <p> enter option 1 <input type="text" name="op1" class="Q" id="" required> </p>
                    <p> enter option 2 <input type="text" name="op2" class="Q" id="" required> </p>
                    <p> enter option 3 <input type="text" name="op3" class="Q" id="" required> </p>
                    <p> enter option 4 <input type="text" name="op4" class="Q" id="" required> </p>
                    <p>
                        Enter Answer
                        <select name="ans" id="" style="margin-left: 10px;" required>
                            <option value="1">option 1</option>
                            <option value="2">option 2</option>
                            <option value="3">option 3</option>
                            <option value="4">option 4</option>
                        </select>

                    </p>

                    <p><input id="add_Q" type="submit" value="submit question"class="btn btn-primary" name="question"></p>




    </form>
<?php
}

if(!isset($_POST['subject']) &&  !isset($_POST['quiz']) && !isset($_POST['question']) )
{
        $id=$_SESSION['p_id'];

        $new_stmt=$pdo->prepare("SELECT subject.subject_code FROM subject WHERE p_id='$id'" );
        $new_stmt->execute();
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
        <input type="submit" value="select for quiz" name="subject" class="btn input_center btn-info"   />
    
    </form>

<?php
}
?>