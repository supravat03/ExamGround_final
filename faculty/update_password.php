<?php 
extract($_POST);
if(isset($save))
{

	if($np=="" || $cp=="" || $op=="")
	{
	$err="<font color='red'>fill all the fileds first</font>";	
	}
	else
	{
		$stmt = $pdo->prepare("SELECT * FROM professor WHERE email= '".$_SESSION['faculty_login']."'");
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($stmt->rowCount() > 0) {
				if(password_verify($op, $result["pass"])){
					if($np==$cp){
						if( strlen($_POST['np']) < 8){
							$err="<font color='red'>Password must be atleast 8 characters</font>";
						}
						else{
						$new_password = password_hash($np, PASSWORD_DEFAULT);
						$update_stmt = $pdo->prepare("UPDATE professor SET pass ='$new_password' WHERE email= '".$_SESSION['faculty_login']."'");
						$update_stmt->execute();
						$err="<font color='blue'>Password updated </font>";
						}
					}
					else{
						$err="<font color='red'>New  password not matched with Confirm Password </font>";
					}
				}
				else{
					$err="<font color='red'>Wrong Old Password </font>";
				}

		}
		else{
			$err="<font color='red'>kuch nhi hua </font>";
		}
	}
}

?>
<h2 align="center">Update Password</h2>
<form method="post">
	
	<div class="row">
		<div class="col-sm-4"></div>
		<div class="col-sm-4"><?php echo @$err;?></div>
	</div>
	
	
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Enter Yuur Old Password</div>
		<div class="col-sm-5">
		<input type="password" name="op" class="form-control"/></div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Enter Your New Password</div>
		<div class="col-sm-5">
		<input type="password" name="np" class="form-control"/></div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Enter Your Confirm Password</div>
		<div class="col-sm-5">
		<input type="password" name="cp" class="form-control"/></div>
	</div>
	<div class="row" style="margin-top:10px">
		<div class="col-sm-2"></div>
		<div class="col-sm-8">
		
		
		<input type="submit" value="Update Password" name="save" class="btn btn-success"/>
		<input type="reset" class="btn btn-success"/>
		</div>
	</div>
</form>