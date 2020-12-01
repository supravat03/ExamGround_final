<?php 
extract($_POST);
if(isset($submit))
{
$user=$_SESSION['user'];
$code=$_POST['subject'];
$student_id=$_SESSION['student_id'];

$new_stmt=$pdo->prepare("SELECT * FROM feedback WHERE subject_code ='$code' AND student_id='$student_id'" );
$new_stmt->execute();
if($new_stmt->rowCount() > 0)
{
echo "<h2 style='color:red'>You have already given feedback for this subject</h2>";
}
else
{
  $ans1=$_POST['ans1'];
  $ans2=$_POST['ans2'];
  $ans3=$_POST['ans3'];
  $ans4=$_POST['ans4'];
  $ans5=$_POST['ans5'];
  $ans6=$_POST['ans6'];
  $ans7=$_POST['ans7'];
  $ans8=$_POST['ans8'];
  $total='0';
$query="INSERT into feedback() values('$code','$student_id','$ans1','$ans2','$ans3','$ans4','$ans5','$ans6','$ans7','$ans8',$total)";
$stmt=$pdo->prepare($query);
$stmt->execute();
echo "<h2 style='color:green'>Thank you </h2>";
}
}


?>
<form method="post">
<fieldset>
<h2 style="color: #426bca;"><u>Student's FeedBack Form</u></h2><br>
 
<fieldset>



<h3>Please give your answer about the following question by circling the given grade on the scale:</h3>


<!--button type="button" style="font-size:7pt;color:white;background-color:green;border:2px solid #336600;padding:3px">Strongly Agree 5</button>
<button type="button" style="font-size:7pt;color:white;background-color:Brown;border:2px solid #336600;padding:3px">Agree 4</button>
<button type="button" style="font-size:7pt;color:white;background-color:blue;border:2px solid #336600;padding:3px">Neutral 3</button>
<button type="button" style="font-size:7pt;color:white;background-color:Black;border:2px solid #336600;padding:3px"> Disagree 2</button>
<button type="button" style="font-size:7pt;color:white;background-color:red;border:2px solid #336600;padding:3px">Strongly Disagree 1</button-->

<table class="table table-bordered" style="margin-top:30px">
<tr>
<?php
  $id=$_SESSION['student_id'];
  $stmt=$pdo->prepare("SELECT enrolls_for.subject_code FROM enrolls_for WHERE enrolls_for.student_id='$id'");
  $stmt->execute();?>
<th> Select Subject Code :</th>
<td>
<Td><select name="subject" id="" class="form-control" required>
        <?php 
            while($row= $stmt->fetch(PDO::FETCH_ASSOC))
            {
        ?>
        <option value="<?php echo $row['subject_code'];?>"><?php echo $row['subject_code'];?></option>
        <?php }
            ?>
</select>
</td>
</tr>
</table>


<h3>A-About the Instructor :</h3>
<table class="table table-bordered">
<tr>
<td><b>1:</b> Overall, the teaching by the instructor was excellent:</td>  
<td><input type="radio" name="ans1" value="5" required> 5
  <input type="radio" name="ans1" value="4"> 4
  <input type="radio" name="ans1" value="3"> 3
<input type="radio" name=" ans1" value="2"> 2
<input type="radio" name="ans1" value="1"> 1</td>
</tr>
  
<tr> 
<td><b>2:</b>The concepts were explained with clarity:</td> 
<td><input type="radio" name="ans2" value="5" required> 5
  <input type="radio" name="ans2" value="4"> 4
  <input type="radio" name="ans2" value="3"> 3
<input type="radio" name="ans2" value="2"> 2
<input type="radio" name="ans2" value="1"> 1</td>
</tr>

<tr>
<td>
<b>3:</b>Questions and discussions were encouraged:</td> 
<td>
<input type="radio" name="ans3" value="5" required> 5
  <input type="radio" name="ans3" value="4"> 4
  <input type="radio" name="ans3" value="3"> 3
<input type="radio" name="ans3" value="2"> 2
<input type="radio" name="ans3" value="1"> 1</td>
</tr>

<tr>
<td><b>4:</b>Allotted number of classes was held:</td> 
<td><input type="radio" name="ans4" value="5" required>5
  <input type="radio" name="ans4" value="4"> 4
  <input type="radio" name="ans4" value="3"> 3
<input type="radio" name=" ans4" value="2"> 2
<input type="radio" name="ans4" value="1"> 1</td>
</tr>


<tr>
<td><b>5:</b>Evaluation was done regularly and feedback was given:</td> 
<td><input type="radio" name="ans5" value="5" required> 5
  <input type="radio" name="ans5" value="4"> 4
  <input type="radio" name="ans5" value="3"> 3
<input type="radio" name=" ans5" value="2"> 2
<input type="radio" name="ans5" value="1"> 1</td>
</tr>


</table>

<h3>B-About the Course:</h3>
 <table  class="table table-bordered" >
<Td><b>1:</b> The course was highly enjoyable:</td>
<td> <input type="radio" name="ans6" value="5" required> 5
  <input type="radio" name="ans6" value="4"> 4
  <input type="radio" name="ans6" value="3"> 3
<input type="radio" name="ans6" value="2"> 2
<input type="radio" name="ans6" value="1"> 1
</td>

<tr>
<td>
<b>2:</b> The content of the course was appropriate:</td>
<td> 
<input type="radio" name="ans7" value="5" required> 5
<input type="radio" name="ans7" value="4"> 4
  <input type="radio" name="ans7" value="3"> 3
<input type="radio" name="ans7" value="2"> 2
<input type="radio" name="ans7" value="1"> 1</td>
</tr>
<tr>
<td><b>3:</b> Text/Reference materials were appropriate for the course:</td>
<td>
 <input type="radio" name="ans8" value="5" required> 5
  <input type="radio" name="ans8" value="4"> 4
  <input type="radio" name="ans8" value="3"> 3
<input type="radio" name=" ans8" value="2"> 2
<input type="radio" name="ans8" value="1"> 1</td>
</tr>
</table>
<input type="submit" value="submit" name="submit" class="btn btn-info"/>
</form>
</fieldset>