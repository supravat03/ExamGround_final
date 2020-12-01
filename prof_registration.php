<?php 
require_once('dbconfig.php');
if(isset($_POST['save']))
{

	if( strlen($_POST['password']) < 8){
		$err="<font color='red'><h3 align='center'>Password must be atleast 8 characters<h3></font>";
		goto end;
	}

	$a = trim(stripslashes(htmlspecialchars($_POST['name'])));
    if (!preg_match("/^[a-zA-Z-' ]*$/",$a)) {
		$err="<font color='red'><h3 align='center'>Only letters and white space allowed in name<h3></font>";
		goto end;
	  }
	  if (strpos($_POST['email'], '@iitg.ac.in') == false) {
       
        $err="<font color='red'><h3 align='center'>Register with iitg email only<h3></font>";
		goto end;
    }

    $c = trim(stripslashes(htmlspecialchars($_POST['email'])));

    $sql_select = "SELECT email FROM professor WHERE email = :email";
	$select_stmt = $pdo->prepare($sql_select);
	$select_stmt->execute(array(
		':email' => $_POST['email']));
	$row=$select_stmt->fetch(PDO::FETCH_ASSOC);

	if($row["email"] == $_POST['email']){
		$err= "<font color='red'><h3 align='center'>This user already exists</h3></font>";
		goto end;
	}
	$new_password = password_hash($_POST['password'], PASSWORD_DEFAULT); //encrypt password using password_hash()

    $sql = "INSERT INTO professor (name,email, pass)
              VALUES (:name, :email,:password)";
	$stmt = $pdo->prepare($sql);
	$stmt->execute(array(
		':name' => $_POST['name'],
		':email' => $_POST['email'],
		':password' => $new_password));
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
					<td>Enter Your name</td>
					<Td><input  type="text" name="name" class="form-control" required/></td>
				</tr>
				<tr>
					<td>Enter Your email </td>
					<Td><input type="email" name="email" class="form-control" required/></td>
				</tr>
				
				<tr>
					<td>Enter Your Password </td>
					<Td><input type="password" name="password" class="form-control" required/></td>
				</tr>
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