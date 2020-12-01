<?php
 include('header.php');
if(isset($_POST['subject'])){
        $a_subject=$_POST['a_see_subject'];
        
			$stmt = $pdo->prepare("SELECT * FROM noticeboard where subject_code='$a_subject'");
			$stmt->execute();
			if ($stmt->rowCount() == 0) {
				?><h3 class="no_record">No notice found ! </h3><?php
			}
			else
			{
			?>	 

			<div class="row">
				<div class="col-sm-12" style="color:orange;">
					<h1 align="center" >Notice Board</h1>
				</div>
			</div>
			<div class="row">

			<div class="col-sm-12">

			<table class="table table-bordered">

				<thead >
				
				<tr class="success">
					<th>Serial No.</th>
					<th>Subject Code</th>
					<th>Notice</th>
					</tr>
					</thead>
					
					<?php
					$i=1;
				while($row= $stmt->fetch(PDO::FETCH_ASSOC))
					{
						echo "<tr>";
						echo "<td>".$i."</td>";
						echo "<td>".$row['subject_code']."</td>";
						echo "<td>".$row['notice_detail']."</td>";

						
						echo "</tr>";
					$i++;
					}
					
					?>
					
				
					
			</table>
			</div>
			</div>
			<?php }

	}



if(!isset($_POST["subject"]) )
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