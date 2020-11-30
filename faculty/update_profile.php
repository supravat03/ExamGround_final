<?php
	extract($_POST);
	if(isset($save))
	{	
		$a = trim(stripslashes(htmlspecialchars($_POST['n'])));
if (!preg_match("/^[a-zA-Z-' ]*$/",$a)) {
	$err="<font color='red'><h3 align='center'>Only letters and white space allowed in name<h3></font>";
}
	else{
		$update_stmt = $pdo->prepare("UPDATE professor SET name ='$n'  WHERE email= '".$_SESSION['faculty_login']."'");
		$update_stmt->execute();
		$_SESSION['name']=$n;

	$err="<font color='green'>Faculty Details updated</font>";
	}

	}

	$stmt = $pdo->prepare("SELECT * FROM professor WHERE email= '".$_SESSION['faculty_login']."'");
	$stmt->execute();
	$res = $stmt->fetch(PDO::FETCH_ASSOC);
?>


<div class="col-lg-8" style="margin:15px;">
	<form method="post">
	
	<div class="control-group form-group">
    	<div class="controls">
        	<label><?php echo @$err;?></label>
        </div>
   	</div>
	
	<div class="control-group form-group">
    	<div class="controls">
        	<label>Name:</label>
            	<input type="text" value="<?php echo @$res['name'];?>" name="n" class="form-control" required>
        </div>
   	</div>
	
 	
	<div class="control-group form-group">
    	<div class="controls">
        	<label>Email :</label>
            	<input type="email" value="<?php echo @$res['email'];?>"  name="email" readonly="true" class="form-control" required>
        </div>
    </div>
	
	<div class="control-group form-group">
    	<div class="controls">
            	<input type="submit" class="btn btn-success" name="save" value="Update  Profile">
        </div>
  	</div>
	</form>


</div>