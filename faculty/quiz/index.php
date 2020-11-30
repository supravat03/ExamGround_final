<?php 
session_start();
include('../../dbconfig.php');
error_reporting(1);

$user= $_SESSION['faculty_login'];

if($user=="")
{header('location:../../index.php');}
echo $user;
$u_name = $_SESSION['name'];
$sql=mysqli_query($conn,"SELECT * FROM prof WHERE email='".$_SESSION['faculty_login']."'");
$r=mysqli_num_rows($sql);
$row=mysqli_fetch_array($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

   
    <title>Quiz part</title>
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <link href="../../css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <link href="../../css/dashboard.css" rel="stylesheet">
    <script src="../../js/ie-emulation-modes-warning.js"></script>
</head>
<body>
   
<nav class="navbar navbar-inverse navbar-fixed-top" style="background:#428bca">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" style="color:#FFFFFF" href="#">Hello <?php echo $u_name;?></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
          <li><a href="../index.php"  style="color:#FFFFFF">Home</a></li>
            <li><a href="../logout.php"  style="color:#FFFFFF">Logout</a></li>
          </ul>
          
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li class="active"><a href="index.php">Dashboard <span class="sr-only">(current)</span></a></li>			
            <li><a href="#"><img style="border-radius:50px" src="../../images/faculty1.png" width="100" height="100" alt="not found"/></a></li>

			
			
<li><a href="index.php?quiz_part=add_quiz"><span class="glyphicon glyphicon-plus"></span> Add Quiz</a></li>    
  <li><a href="index.php?quiz_part=add_question"><span class="glyphicon glyphicon-plus"></span> Add Question</a></li>
  <li><a href="index.php?quiz_part=view_paper"><span class="glyphicon"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-laptop" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" d="M13.5 3h-11a.5.5 0 0 0-.5.5V11h12V3.5a.5.5 0 0 0-.5-.5zm-11-1A1.5 1.5 0 0 0 1 3.5V12h14V3.5A1.5 1.5 0 0 0 13.5 2h-11z"/>
  <path d="M0 12h16v.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 12.5V12z"/>
</svg></span> View Paper </a></li>   
          </ul>
         
         
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		  <?php 
		@$quiz_part=  $_GET['quiz_part'];
		  if($quiz_part!="")
		  {
		  	  if($quiz_part=="view_paper")
			    {
          	include('view_paper.php');
          }
        
			    if($quiz_part=="add_question")
			    {
			    	include('add_question.php');
          }
          
			    if($quiz_part=="add_quiz")
			    {    
            include('add_quiz.php');
			    }
		  }
		  else
		  {
		  
		  ?>
		 
		  <h1>You are in Quiz section</h1> 
<?php } ?>       
        </div>
      </div>
    </div>

    
  </body>
</html>