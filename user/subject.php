<body>
<?php include('header.php')?>
<form method="post">
    
    <div >
		<input type="submit" value="enroll now" name="enroll" class="btn btn-info"/>
    
		<input type="submit" value="view subjects" name="view" class="btn btn-info"/>
    </div>  

    
</form>	
</body>
<?php

    if(isset($_POST['Delete']))
    {
        $id=$_SESSION['student_id'];
        $code=$_POST['delete_subject'];
        $add_stmt=$pdo->prepare("DELETE FROM enrolls_for WHERE student_id='$id' AND subject_code='$code'");
        $add_stmt->execute();
        //echo "delete successfully";
        echo $err="<font color='green'>Subject Deleted Successfully</font>";

    }

    if(isset($_POST['view']))
    {
        $id=$_SESSION['student_id'];
        $stmt=$pdo->prepare("SELECT subject.subject_code, subject.subject_name FROM subject WHERE subject_code IN( SELECT subject_code FROM enrolls_for WHERE subject.subject_code= enrolls_for.subject_code AND enrolls_for.student_id='$id' )" );
        $stmt->execute();

        if($stmt->rowCount()==0){
            ?><h3 class="no_record">Sorry, There are no subjects to show! </h3><?php
        }
        else{

            ?>


            <form method="post" enctype="multipart/form-data">
    <table style="width:540px; border: 1px solid black" class="center">
        <tr>
            <th>Subject Code </th>
            <th>Subject Name</th>
        </tr>
        <?php 
            while($result= $stmt->fetch(PDO::FETCH_ASSOC))
            {
                ?><tr><td><input type="radio" name="delete_subject" value="<?php echo $result['subject_code'];?>">
                <?php echo $result['subject_code'];?>    </td>
                <td><?php echo $result['subject_name']?>    </td></tr>
                
        <?php }
            ?><br>
           
    </table><br>
        <input type="submit" value="Delete" name="Delete" class="btn input_center btn-info"   />
    
    </form>
       
           
<?php 
        }
}




    if(isset($_POST['Add'])){
        $id=$_SESSION['student_id'];
        $code=$_POST['subject'];
        $add_stmt=$pdo->prepare("INSERT INTO enrolls_for(student_id,subject_code) VALUES ('$id','$code' )");
        $add_stmt->execute();
        echo $err="<font color='green'>Subject Added Successfully</font>";
    }


    

    if(isset($_POST['enroll']))
    {
        $id=$_SESSION['student_id'];
        $stmt=$pdo->prepare("SELECT subject.subject_code, subject.subject_name FROM subject WHERE subject_code NOT IN( SELECT subject_code FROM enrolls_for WHERE subject.subject_code= enrolls_for.subject_code AND enrolls_for.student_id='$id' )" );
        $stmt->execute();

        if($stmt->rowCount()==0){
            ?><h3 class="no_record">Sorry, There are no subjects to get enrolled in! </h3><?php
        }
        else{

            ?>
            <form method="post" enctype="multipart/form-data">
            <table style="width:540px; border: 1px solid black" class="center">
                <tr>
                    <th>Subject Code </th>
                    <th>Subject Name</th>
                </tr>
                <?php 
                    while($result= $stmt->fetch(PDO::FETCH_ASSOC))
                    {
                        ?><tr><td><input type="radio" name="subject" value="<?php echo $result['subject_code'];?>">
                        <?php echo $result['subject_code'];?>    </td>
                        <td><?php echo $result['subject_name']?>    </td></tr>
                        
                <?php }
                    ?><br>
                   
            </table><br>
                <input type="submit" value="Add" name="Add" class="btn input_center btn-info"   />
            
            </form>
               
                   
        <?php 
                }
        }