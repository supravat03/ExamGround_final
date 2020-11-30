<?php

include('header.php');

    if(isset($_POST["update"])){
        $a_notice_id_for_update=$_SESSION['a_edit_notice'];
        $final_notice = $_POST['n_detail'];
        $a_update_stmt_for_notice = $pdo->prepare("UPDATE noticeboard SET notice_detail ='$final_notice' WHERE notice_id='$a_notice_id_for_update'");
		$a_update_stmt_for_notice->execute();

    ?><h3 class="no_record">Notice updated</h3><?php

    }



    if(isset($_POST["delete"]))
    {
        $y_notice_id= $_SESSION['a_edit_notice'];

        $y_del= " DELETE FROM noticeboard WHERE notice_id='$y_notice_id'";
        $y_delete=$pdo->prepare($y_del);
        $y_delete->execute();
        ?><h3 class="no_record">Notice deleted</h3><?php

    }





   




    if(isset($_POST['edit'])){

        ?>
        <form method="post">
    
    <div >
		<input type="submit" value="ADD" name="add" class="btn btn-info"/>
    
		<input type="submit" value="view notice" name="view" class="btn btn-info"/>
    </div>  

    
    </form>	
    <?php

        $_SESSION['a_edit_notice']=$_POST['a_edit_notice'];
            $a_notice_id=$_POST['a_edit_notice'];
            $a_notice_stmt = $pdo->prepare("SELECT * FROM noticeboard WHERE notice_id='$a_notice_id'");
            $a_notice_stmt->execute();
            $res = $a_notice_stmt->fetch(PDO::FETCH_ASSOC);

            ?>



            <form id="add_Q_form" action="" method="post">
                    <h4>Edit Notice</h4>
                    <p> <textarea value="<?php echo @$res['notice_detail'];?>" name="n_detail" id="" cols="120" rows="12" required><?php echo @$res['notice_detail'];?></textarea> </p>
                    <p>

                    </p>

                    <p><input type="submit" value="Update" name="update" class="btn btn-info"/></p>

                </form>
            <?php

    }









        if(isset($_POST['submit'])){
            $ak_subject=$_SESSION['see_subject'];
            $ak_notice=$_POST['notice'];
            $ak_stmt_add=$pdo->prepare(" INSERT INTO noticeboard(subject_code,notice_detail) VALUES(:sub,:notice)");
            $ak_stmt_add->execute(array(
                ':sub'=>$ak_subject,
                ':notice'=>$ak_notice));

            }






     if(isset($_POST['add']) ){
        ?>
        <form method="post">
    
    <div >
		<input type="submit" value="ADD" name="add" class="btn btn-info"/>
    
		<input type="submit" value="view notice" name="view" class="btn btn-info"/>
    </div>  

    
    </form>	
    
         <form id="add_Q_form" action="" method="post">
                     <h4>Write notice</h4>
                     <p> <textarea name="notice" id="" cols="120" rows="12" required></textarea> </p>
                    

                     <p><input id="add_Q" type="submit" value="submit notice"class="btn btn-primary" name="submit"></p>

                 </form> 
     <?php
     }









  

    if(isset($_POST["subject"])){
        $_SESSION['see_subject']=$_POST["see_subject"];
    ?>
    <form method="post">
    
    <div >
		<input type="submit" value="ADD" name="add" class="btn btn-info"/>
    
		<input type="submit" value="view notice" name="view" class="btn btn-info"/>
    </div>  

    
    </form>	
<?php
    }




    if(isset($_POST['view']) || isset($_POST['submit']) || isset($_POST["delete"]) || isset($_POST["update"]))
    {
        ?>
        <form method="post">
    
    <div >
		<input type="submit" value="ADD" name="add" class="btn btn-info"/>
    
		<input type="submit" value="view notice" name="view" class="btn btn-info"/>
    </div>  

    
    </form>	
    <?php

            
            $a_subject=$_SESSION['see_subject'];
			$stmt = $pdo->prepare("SELECT * FROM noticeboard where subject_code='$a_subject'");
			$stmt->execute();
			if ($stmt->rowCount() == 0) {
				?><h3 class="no_record">No Notice found! </h3><?php
			}
			else
			{

            ?>
            <h2 class="heading">Notice Board</h2>
                <div>
                
                <form method="post" enctype="multipart/form-data">
                <table class="table table-bordered">
                    <tr>
                        <th>Serial No. </th>
                        <th>Subject Code </th>
                        <th>Notice</th>
                    </tr>
                    <!--td><select name="a_see_subject" id="" class="form-control" required-->
                    <?php 
					$i=1;
				while($row= $stmt->fetch(PDO::FETCH_ASSOC))
					{

                        ?><tr><td><input type="radio" name="a_edit_notice" value="<?php echo $row['notice_id'];?>">
                            <?php echo $i;?>    </td>
                            <td><?php echo $row['subject_code']?>    </td>
                            <td><?php echo $row['notice_detail']?>    </td></tr>
						<?php
					$i++;
					}
					
					?><br>
                    
                    </table><br>
                    
                        <input type="submit" value="Edit" name="edit" class="btn btn-info"/>
                        <input type="submit" value="Delete" name="delete" class="btn btn-info"/>
                    </form>
       
           
<?php 
        }
    }















    
if(!isset($_POST["subject"]) && !isset($_POST['add']) && !isset($_POST["edit"]) && !isset($_POST['view']) 
&& !isset($_POST['submit']) && !isset($_POST["update"]) && !isset($_POST["delete"]))  
{   
            $id=$_SESSION['p_id'];

                $new_stmt=$pdo->prepare("SELECT subject.subject_code FROM subject WHERE p_id='$id'" );
                $new_stmt->execute();


                if($new_stmt->rowCount()==0){
                    ?><h3 class="no_record">Sorry, There are no subjects! </h3><?php
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
                        while($result= $new_stmt->fetch(PDO::FETCH_ASSOC))
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
        }
}
?>