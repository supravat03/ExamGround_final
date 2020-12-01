<?php 
require('dbconfig.php');
if(isset($_POST['save']))
{
	//p=password
	//n=name
	//e=email
	//mob=mobile
	if( (strlen($_POST['p']) < 8)){
		$err="<font color='red'><h3 align='center'>Password must be atleast 8 characters<h3></font>";
		goto end;
	}

	$a = trim(stripslashes(htmlspecialchars($_POST['n'])));
    if (!preg_match("/^[a-zA-Z-' ]*$/",$a)) {
		$err="<font color='red'><h3 align='center'>Only letters and white space allowed in name<h3></font>";
		goto end;
    }
	if (!is_numeric($_POST['mob']) || strlen($_POST['mob'])!=10) {
		$err="<font color='red'><h3 align='center'>Only digits allowed in phone number<h3></font>";
		goto end;
	}
	if (strpos($_POST['email'], '@iitg.ac.in') == false) {
       
        $err="<font color='red'><h3 align='center'>Register with iitg email only<h3></font>";
		goto end;
    }
  
	
    //$c = trim(stripslashes(htmlspecialchars($_POST['e'])));

	if (strpos($_POST['e'], '@iitg.ac.in') == false) {
       
        $err="<font color='red'><h3 align='center'>Register with iitg email only<h3></font>";
		goto end;
    }
	$sql_select = "SELECT student_email FROM student WHERE student_email=:email";
    $select_stmt = $pdo->prepare($sql_select);
    $select_stmt->execute(array(
        ':email' => $_POST['e']));
    $row=$select_stmt->fetch(PDO::FETCH_ASSOC);
    if($row["student_email"] == $_POST['e']){
		$err="<font color='red'><h3 align='center'>Email-id already exists<h3></font>";
		goto end;
	}
	
	$sql_select_phone = "SELECT phone FROM student WHERE phone=:phno";
    $select_stmt_phone = $pdo->prepare($sql_select_phone);
    $select_stmt_phone->execute(array(
        ':phno' => $_POST['mob']));
    $row_phone=$select_stmt_phone->fetch(PDO::FETCH_ASSOC);
    if($row_phone["phone"] == $_POST['mob']){
        $err="<font color='red'><h3 align='center'>phone number already exists<h3></font>";
		goto end;
    }

    $new_password = password_hash($_POST['p'], PASSWORD_DEFAULT); //encrypt password using password_hash()
				

    $sql = "INSERT INTO student (student_name, student_email, phone,password)
              VALUES (:student_name, :student_email, :phone ,:password)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':student_name' => $_POST['n'],
		':student_email' => $_POST['e'],
		':phone' => $_POST['mob'],
        ':password' => $new_password));
	//$_SESSION['success'] = 'Record Added';
	
	
	
    $err="<font color='blue'><h3 align='center'>Registration successfull !!<h3></font>";
	
}
?>

<?php end: ?>
		<div class="row">
		<div class="col-sm-2"></div>
		<div class="col-sm-8">
		<form method="post" enctype="multipart/form-data">
		<table class="table table-bordered" style="margin-bottom:50px">
	<caption><h2 align="center">Registration Form</h2></caption>
	<Tr>
		<Td colspan="2"><?php echo @$err;?></Td>
	</Tr>
				
				<tr>
					<td>Enter your name</td>
					<Td><input  type="text" name="n" class="form-control" required/></td>
				</tr>
				<tr>
					<td>Enter your email </td>
					<Td><input type="email" name="e" class="form-control" required/></td>
				</tr>
				
				<tr>
					<td>Enter your password </td>
					<Td><input type="password" name="p" class="form-control" required/></td>
				</tr>
				
				<tr>
					<td>Enter your phone no. </td>
					<Td><input type="text" name="mob" class="form-control" required/></td>
				</tr>

				<!-- <tr>
					<td>Select Your 5th Subject </td>
					<Td><select name="subject[]" class="form-control" required>
					
					<option>MA543</option>
					<option>MA512</option>
					<option>MA518</option>
					<option>MA567</option>
					<option>MA417</option>
					</select>
					</td>
				</tr> -->
				
				<tr>
					
					<Td colspan="2" align="center">
					<input type="submit" value="Save" class="btn btn-info" name="save"/>
					<input type="reset" value="Reset" class="btn btn-info"/>
					</td>
				</tr>
			</table>
		</form>
		</div>
		<div class="col-sm-2"></div>
		</div>
	</body>
</html>