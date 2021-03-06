<?php 
extract($_POST);
if(isset($save))
	{
		if ( strlen($_POST['e']) < 1 || strlen($_POST['p']) < 1) {
            $err="<font color='red'>Missing data</font>";
			goto end;
        }
    
        if ( strpos($_POST['e'],'@') === false ) {
            $err="<font color='red'>Please enter a valid email address</font>";
			goto end;
        }

        if( strlen($_POST['p']) < 8){
            $err="<font color='red'>Password must be atleast 8 characters</font>";
			goto end;
        }
		$stmt = $pdo->prepare("SELECT * FROM student WHERE student_email= :email");
		$stmt->execute(array(
			':email' => $_POST['e']));
		$result = $stmt->fetch(PDO::FETCH_ASSOC);

		if ($stmt->rowCount() > 0) {
				if(password_verify($_POST['p'], $result["password"])){
					$_SESSION['user']=$_POST['e'];
					$_SESSION['student_id']=$result['student_id'];
					$_SESSION['student_name']=$result['student_name'];

					
					header('location:user');
				}
				else{
					$err="<font color='red'>Incorrect password.</font>";
				}
			}
		else{
			$err="<font color='red'>User not registered</font>";
		}
	}
?>

<?php end: ?>
<div class="row">
		<div class="col-sm-2"></div>
		<div class="col-sm-8">

<form method="post">
	<div class="row">
		<div class="col-sm-4"></div>
		<div class="col-sm-4"><h2>Student LogIn</h2></div>
	</div>
	
	<div class="row">
		<div class="col-sm-4"></div>
		<div class="col-sm-4"><?php echo @$err;?></div>
	</div>
	
	
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Enter Your Email</div>
		<div class="col-sm-5">
		<input type="email" name="e" class="form-control"/></div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Enter Your Password</div>
		<div class="col-sm-5">
		<input type="password" name="p" class="form-control"/></div>
	</div>
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4"></div>
		<div class="col-sm-8">
		<input type="submit" value="Login" name="save" class="btn btn-info"/>
		
		</div>
	</div>
</form>	
</div>
</div>