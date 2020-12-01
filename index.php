<?php
session_start();
require('dbconfig.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	<title>ExaMania</title>
	
	
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="css/modern-business.css" rel="stylesheet">

    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

</head>

<body>

    <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="background:#126782">
        <div class="container" >   
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php" style="color:#FFFFFF">ExaMania</a>	
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    
					<li style="color:#FFFFFF">
                        <a style="color:#FFFFFF" href="index.php"><i class="fa fa-home fa-fw"></i>Home</a>
                    </li>
					
                    <li class="dropdown">
                        <a style="color:#FFFFFF" href="#" class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-sign-in fa-fw"></i>Register
                        <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="index.php?info=registration">As Student</a></li>
		                    <li><a href="index.php?info=prof_registration">As Faculty</a></li> 
                        </ul>
                    </li>
								
                    <li class="dropdown">
                        <a style="color:#FFFFFF" href="#" class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-sign-in fa-fw"></i>Login
                        <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="index.php?info=login">As Student</a></li>
	                	    <li><a href="index.php?info=faculty_login">As Faculty</a></li> 
                        </ul>
                    </li> 
                </ul>
            </div>
        </div>
    </nav>

<?php 
					@$info=$_GET['info'];
					if($info!="")
					{
											
						if($info=="about")
						 {
						 include('about.php');
						 }
					    else if($info=="contact")
						 {
						 include('contact.php');
						 }
					    else if($info=="login")
						 {
						 include('login.php');
                         }
                        else if($info=="faculty_login")
						 {
						 include('faculty_login.php');
						 }
						else if($info=="registration")
						 {
						 	include('registration.php');
                         }
                        else if($info=="prof_registration")
						 {
						 	include('prof_registration.php');
                         }
					}
					else
					{
				?>
    <header id="myCarousel" class="carousel slide">
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>

        <div class="carousel-inner">
            <div class="item active">
                
                <div class="fill" style="background-image:url('images/img1.jpeg');"></div>
				<div class="carousel-caption">
                    
                </div>
            </div>
           
            <div class="item">
                <div class="fill" style="background-image:url('images/img2.jpeg');"></div>
                <div class="carousel-caption">
                   
                </div>
            </div>
			
			 <div class="item">
                <div class="fill" style="background-image:url('images/img3.jpeg');"></div>
                <div class="carousel-caption">
                   
                </div>
            </div>
		
        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
            <span class="icon-prev"></span>
        </a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
            <span class="icon-next"></span>
        </a>
    </header>

    <div class="container">

        <div class="row">
            <div class="col-lg-12">
                <div class="col-sm-10" style="margin-top:10px;margin-bottom:20px">
				<h2 style="color: #126782; font-weight:30px;">About ExaMania</h2>
				<P style="font-size: 15px;">
               ExaMania is a web-based application for technical evaluation. During this
pandemic it has become difficult for students to be physically present to give
exams and for the institute as well to conduct exams while following all
pandemic-rules. There comes the need to change the way most of the exams are
conducted. It fulfills the requirement of institute to conduct exams online. This
next step turns out to be more efficient for student as well as professor. Student
and Professor are no longer required to be physically present for the smooth
conduction of exams and it becomes easier for Professor's to efficiently evaluate
the students thoroughly through a fully automated system that not only saves lot
of time, efforts but also gives fast results. There is no chance of leakage of
question paper.
               </P>
			</div>
			
			
			
			
				<?php } ?>
            </div>
            
    </div>
	<div class="navbar-fixed-bottom nav navbar-inverse text-center" style="padding:15px;height:40px; background:#126782">
		<span style="color:#FFFFFF">Project for DBMS Course </span>
	</div>
    <script src="css/jquery.js"></script>
    <script src="css/bootstrap.min.js"></script>

    <script>
    $('.carousel').carousel({
        interval: 5000 
    })
    </script>

</body>

</html>
