<?php

session_start();
include('header.php') ;
$to_show_quiz_added_successfully_message = 0;
if(isset($_POST['y_subject']) || isset($_POST['y_quiz']))
{
    if(isset($_POST['y_subject']))
    {
        $_SESSION['y_subject']= $_POST['y_subject_choosen_for_quiz'];
    }
    

    if(isset($_POST['y_quiz']))
    {
        $yy_quiz_name = $_POST['y_quiz_name'];
        $yy_quiz_duration = $_POST['y_quiz_duration'];
        
        $y_sub_id = $_SESSION['y_subject'];
        $y_for_quiz = "INSERT INTO quiz(test_name , duration , subject_code) 
                        VALUES (:test_name , :duration , :subject_code  )";
        $y_st = $pdo->prepare($y_for_quiz);
        $y_st->execute(array(
            ':test_name' => $_POST['y_quiz_name'],
            ':duration' => $_POST['y_quiz_duration'],
            
            ':subject_code' => $y_sub_id
        ));
        $to_show_quiz_added_successfully_message=1;
    }
    ?>

<div class="col-sm-8">
    <?php if($to_show_quiz_added_successfully_message==1){
    
    ?><h3 class="no_record">Quiz Created Successfully! </h3><?php }?>
		<form method="post" enctype="multipart/form-data">
		<table class="table table-bordered" style="margin-bottom:50px">
	<caption><h2 align="center">Fill the detials to create quiz</h2></caption>
	<Tr>
		<Td colspan="2"><?php echo @$err;?></Td>
	</Tr>
				
				<tr style=" background-color: white;">
					<td>Enter quiz name : </td>
					<Td><input  type="text" name="y_quiz_name" class="form-control" required/></td>
                </tr>
                
				<tr style=" background-color: white;">
					<td>Enter Duration : </td>
					<Td><input type="number" name="y_quiz_duration" class="form-control" required/></td>
				</tr>
				<tr>
					
					<Td colspan="2" align="center">
					<input type="submit" value="Save" class="btn btn-info" name="y_quiz"/>
					<input type="reset" value="Reset" class="btn btn-info"/>
					</td>
				</tr>
			</table>
		</form>
        </div>
<?php
}

if(!isset($_POST['y_subject']) &&  !isset($_POST['y_quiz'])  )
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
                ?><tr><td><input type="radio" name="y_subject_choosen_for_quiz" value="<?php echo $result['subject_code'];?>">
                <?php echo $result['subject_code'];?>    </td>
                <td><?php echo $ak_name['subject_name']?>    </td></tr>
                
        <?php }
            ?><br>
           
    </table><br>
        <input type="submit" value="Select your Quiz" name="y_subject" class="btn input_center btn-info"   />
    
    </form>
    

<?php
} ?>