<?php 
extract($_POST);
if(isset($update))
{
$a = trim(stripslashes(htmlspecialchars($_POST['n'])));
if (!is_numeric($_POST['mob']) || strlen($_POST['mob'])!=10 || !preg_match("/^[a-zA-Z-' ]*$/",$a)) {
	$err="<font color='red'><h3 align='center'>Only digits allowed in phone number and only letters and white space allowed in name<h3></font>";
}
else{
$sql_select_phone = "SELECT phone FROM student WHERE phone=:phno";
    $select_stmt_phone = $pdo->prepare($sql_select_phone);
    $select_stmt_phone->execute(array(
        ':phno' => $_POST['mob']));
    $row_phone=$select_stmt_phone->fetch(PDO::FETCH_ASSOC);
    if($row_phone["phone"] == $_POST['mob']){
        $err="<font color='red'><h3 align='center'>phone number already exists<h3></font>";
    }
	else{
	$update_stmt = $pdo->prepare("UPDATE student SET student_name ='$n',phone='$mob' WHERE student_email= '".$_SESSION['user']."'");
	$update_stmt->execute();
	$_SESSION['student_name']=$n;

	$err="<font color='blue'>Profie updated successfully !!</font>";
	}
}
}

$stmt = $pdo->prepare("SELECT * FROM student WHERE student_email= '".$_SESSION['user']."'");
	$stmt->execute();
	$res = $stmt->fetch(PDO::FETCH_ASSOC);

?>
<h2 align="center">Update Your Profile</h2>

		<form method="post">
			<table class="table table-bordered">
	<Tr>
		<Td colspan="2"><?php echo @$err;?></Td>
	</Tr>
				
				<tr>
					<td>Enter Your name</td>
					<Td><input class="form-control" value="<?php echo $res['student_name'];?>"  type="text" name="n"/></td>
				</tr>
				<tr>
					<td>Enter Your email </td>
					<Td><input class="form-control" type="email" readonly="true" value="<?php echo $res['student_email'];?>"  name="e"/></td>
				</tr>
				
				
				<tr>
					<td>Enter Your Mobile </td>
					<Td><input class="form-control" type="text" value="<?php echo $res['phone'];?>"  name="mob"/></td>
				</tr>
					
				<tr>	

<Td colspan="2" align="center">
<input type="submit" class="btn btn-default" value="Update My Profile" name="update"/>
<input type="reset" class="btn btn-default" value="Reset"/>
				
					</td>
				</tr>
			</table>
		</form>