<?php include('header.php') ?>
<body>
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
        $id=$_SESSION['p_id'];
        $code=$_POST['delete_subject'];
        $add_stmt=$pdo->prepare("DELETE FROM subject where subject_code='$code'");
        $add_stmt->execute();
        echo $err="<font color='green'>Subject Deleted Successfully</font>";

    }

    if(isset($_POST['view']))
    {
        $id=$_SESSION['p_id'];
        $stmt=$pdo->prepare("SELECT subject.subject_code, subject.subject_name FROM subject WHERE p_id='$id' ORDER BY RAND() ") ;
        $stmt->execute();
       

        $new_stmt=$pdo->prepare("SELECT subject.subject_code FROM subject WHERE p_id='$id'" );
        $new_stmt->execute();
        ?>
       
        
            <h2 class="heading">Select Your Subject to Delete</h2>
    <div>
    
    <form method="post" enctype="multipart/form-data">
    <table style="width:540px; border: 1px solid black" class="center">
        <tr>
            <th>Subject Code </th>
            <th>Subject Name</th>
        </tr>
        <?php 
            while($result= $new_stmt->fetch(PDO::FETCH_ASSOC))
            {
                $ak=$result['subject_code'];
                $ak_stmt=$pdo->prepare("SELECT * FROM available_subjects WHERE subject_code='$ak'");
                $ak_stmt->execute();
                $ak_name=$ak_stmt->fetch(PDO::FETCH_ASSOC);
                ?><tr><td><input type="radio" name="delete_subject" value="<?php echo $result['subject_code'];?>">
                <?php echo $result['subject_code'];?>    </td>
                <td><?php echo $ak_name['subject_name']?>    </td></tr>
                
        <?php }
            ?><br>
           
    </table><br>
        <input type="submit" value="Delete" name="Delete" class="btn input_center btn-info"   />
    
    </form>
    
    
            <?php } ?>
            <?php
    

    if(isset($_POST['Add'])){
        $id=$_SESSION['p_id'];
        $code=$_POST['ad_subject'];
        $search_subname="SELECT subject_name from available_subjects where subject_code='$code'";
        $stm=$pdo->prepare($search_subname);
        $stm->execute();
        $row= $stm->fetch(PDO::FETCH_ASSOC);
        $sub_name=$row["subject_name"];

        $add_stmt=$pdo->prepare("INSERT INTO subject(subject_code,subject_name,p_id) VALUES ('$code','$sub_name','$id' )");
        $add_stmt->execute();
        echo $err="<font color='green'>Subject Added Successfully</font>";
    }
    if(isset($_POST['enroll']))
    {
        $id=$_SESSION['student_id'];
        $stmt=$pdo->prepare("SELECT available_subjects.subject_code, available_subjects.subject_name FROM available_subjects 
        WHERE available_subjects.subject_code NOT IN (SELECT subject.subject_code from subject) " );
        $stmt->execute();
       

        $new_stmt=$pdo->prepare("SELECT available_subjects.subject_code, available_subjects.subject_name FROM available_subjects 
        WHERE available_subjects.subject_code NOT IN (SELECT subject.subject_code from subject) " );
        $new_stmt->execute();
    
?>
            <h2 class="heading">Select Your Subject to add</h2>
    <div>
    
    <form method="post" enctype="multipart/form-data">
    <table style="width:540px; border: 1px solid black" class="center">
        <tr>
            <th>Subject Code </th>
            <th>Subject Name</th>
        </tr>
        <?php 
            while($result= $new_stmt->fetch(PDO::FETCH_ASSOC))
            {
                $ak=$result['subject_code'];
                $ak_stmt=$pdo->prepare("SELECT * FROM available_subjects WHERE subject_code='$ak'");
                $ak_stmt->execute();
                $ak_name=$ak_stmt->fetch(PDO::FETCH_ASSOC);
                ?><tr><td><input type="radio" name="ad_subject" value="<?php echo $result['subject_code'];?>">
                <?php echo $result['subject_code'];?>    </td>
                <td><?php echo $ak_name['subject_name']?>    </td></tr>
                
        <?php }
            ?><br>
           
    </table><br>
        <input type="submit" value="Add" name="Add" class="btn input_center btn-info"   />
    
    </form>
    
            <?php } ?>