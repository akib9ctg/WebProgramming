<?php include("Database.php"); ?>
        <?php
        $databaseObj = new Database();
        $databaseObj->createTable(" CREATE TABLE student(
                                    id Varchar(10) PRIMARY KEY, 
                                    name VARCHAR(30) NOT NULL,
                                    section VARCHAR(10) NOT NULL,
                                    semester varchar(10) Not Null,
                                    registrationStatus bool,
                                    password varchar(100),
                                    contactNumber varchar(50),
                                    email VARCHAR(50),
                                    forgetPasswordIdentity varchar(100));");
        $databaseObj->createTable("CREATE TABLE courseTable(
                                    CourseCode Varchar(10) PRIMARY KEY, 
                                    CourseName VARCHAR(30) NOT NULL
                                    Credit varchar(4));");
        $databaseObj->createTable("Create Table registrationtable(
                                    CourseCodeStudentID varchar(50) PRIMARY key,
                                    studentID varchar(10),
                                    CourseName varchar(100),
                                    courseCode varchar(10),
                                    CourseCredit varchar(10),
                                    section Varchar(10)
                                    );");
        $databaseObj->createTable("Create table pendingList (
                                  CourseCodeStudentID varchar(50) PRIMARY key,
                                  studentID varchar(10),
                                  courseCode varchar(10),
                                  CourseName varchar(100),
                                  CourseCredit varchar(10));");
        $databaseObj->createTable("Create table adminTable (
                                  adminID varchar(50) PRIMARY key,
                                  adminName varchar(100),
                                  adminPassword varchar(100),
                                  adminEmail varchar(100),
                                  adminMobile varchar(20),
                                  hashIdentity varchar(100));");
        $databaseObj->createTable("Create table tempTable (
                                  CourseCodeStudentID varchar(50) PRIMARY key,
                                  studentID varchar(10),
                                  courseCode varchar(10),
                                  CourseName varchar(100),
                                  Credit varchar(10));");
        
        
        ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Pre-registration</title>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

	<header class="navbar navbar-fixed-top">
		
		<div class="container-fluid">
			<div class="row">
				<div class="main-menu">
				
					<div class="col-md-4">
						<div class="site-logo">
							<h4>University Pre-registration System</h4>
						</div>
					</div>	
					<div class="col-md-8">
						<div class="site-navigation">
							<ul class="navigation">
								<li><a href="studentLogin.php">Student Login</a></li>
                                                                <li><a href="adminLogin.php">Admin Login</a></li>
							</ul>
						</div>
					</div>
					
				</div>
			</div>
			
		</div>
		
</header>
<main>
	<div class="container sm100">
		<div class="row">
			<div class="col-sm-12">
				<div id="my-slider" class="carousel slide" data-ride="carousel">
					<ol class="carousel-indicators">
						<li data-target="#my-slider" data-slide-to="0" class="active"></li>
						<li data-target="#my-slider" data-slide-to="1"></li>
						<li data-target="#my-slider" data-slide-to="2"></li>
					</ol>
				
				
					<div class="carousel-inner" role="listbox">
						<div class="item active">
							<img src="assets/img/1.jpg">
							<div class="carousel-caption">
								<h3>An investment in knowledge pays the best interest -Benjamin Franklin</h3>
							</div>
						</div>
						<div class="item">
							<img src="assets/img/2.jpg">
							<div class="carousel-caption">
								<h3>Change is the end result of all true learning -Leo Buscaglia</h3>
							</div>
						</div>
						<div class="item">
							<img src="assets/img/3.jpg">
							<div class="carousel-caption">
								<h3>The function of education is to teach one to think intensively and to think critically. Intelligence plus character - that is the goal of true education  - Martin Luther King, Jr.</h3>
							</div>
						</div>
					
					</div>
					<a class="left carousel-control" href="#my-slider" role="button" data-slide="prev">
					<span><i class="fa fa-chevron-left sm200" aria-hidden="true"></i></span>
					</a>
					
					<a class="right carousel-control" href="#my-slider" role="button" data-slide="next">
						<i class="fa fa-chevron-right  sm200" aria-hidden="true"></i>
					</a>
				
				
				</div>
			
			</div>
		</div>
	</div>




</main>
<footer>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<p>&copy;2017 University Pre-registration System. All rights reserved | Created by IIUC_....</p>
			</div>
		</div>
	</div>

</footer>
	
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>


</body>
</html>