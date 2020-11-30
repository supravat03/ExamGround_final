<?php include('header.php') ?>
<?php

if(isset($_POST['subject'])){
		$a_subject=$_POST['see_subject'];
			$stmt = $pdo->prepare("SELECT * FROM feedback where subject_code='$a_subject'");
			$stmt->execute();
			if ($stmt->rowCount() == 0) {
				?><h3 class="no_record">Sorry, There are no Feedback ! </h3><?php
			}
			else
			{
			?>	 

			<div class="row">
				<div class="col-sm-12" style="color:orange;">
					<h1 align="center" >Feedback</h1>
				</div>
			</div>
			<div class="row">

			<div class="col-sm-12">

			<table class="table table-bordered">

				<thead >
				
				<tr class="success">
					<th>Serial No.</th>
					<th>Subject Code</th>
					<th>Student id</th>
					<th>ans1</th>
					<th>ans2</th>
					<th>ans3</th>
					<th>ans4</th>
					<th>ans5</th>
					<th>ans6</th>
					<th>ans7</th>
					<th>ans8</th>
					<th>total</th>
					</tr>
					</thead>
					
					<?php
					$i=1;
				while($row= $stmt->fetch(PDO::FETCH_ASSOC))
					{
						echo "<tr>";
						echo "<td>".$i."</td>";
						echo "<td>".$row['subject_code']."</td>";
						echo "<td>".$row['student_id']."</td>";
						echo "<td>".$row['ans1']."</td>";
						echo "<td>".$row['ans2']."</td>";
						echo "<td>".$row['ans3']."</td>";
						echo "<td>".$row['ans4']."</td>";
						echo "<td>".$row['ans5']."</td>";
						echo "<td>".$row['ans6']."</td>";
						echo "<td>".$row['ans7']."</td>";
						echo "<td>".$row['ans8']."</td>";
						echo "<td>".$row['total']."</td>";
						
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
        <!--td><select name="a_see_subject" id="" class="form-control" required-->
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