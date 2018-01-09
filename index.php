<?php
session_start();
$db = mysqli_connect("guc353_1.encs.concordia.ca","guc353_1", "mehal420", "guc353_1");

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bahamas Sports Physio Center</title>
    <!-- Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body style="padding-bottom: 70px;padding-top: 70px;">
    <header>
	 <nav class="navbar navbar-default navbar-fixed-top">
	  <div class="container-fluid">
		<div class="navbar-header">
			<button class="navbar-toggle collapsed" aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" type="button">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			</button>		
		    <a class="navbar-brand" href="#">Physio Database</a>
		</div>
            <div id="navbar" class="navbar-collapse collapse">
		    <ul class="nav navbar-nav">
			<li><a href="./index.php">Home</a></li>
			<?php

			if(!isset($_SESSION['ID'])){
            				echo '<li class="active"><a href="https://guc353_1.encs.concordia.ca/login.php">Login</a></li>'; }
			else
			echo '<li><a href="https://guc353_1.encs.concordia.ca/logout.php">Log Out</a></li>';
             if(isset($_SESSION['ID'])){

              if($_SESSION['ID'] < 10001) //Patient
                echo '
                       <li><a href="https://guc353_1.encs.concordia.ca/Appointment.php"> Make an Appointment</a></li>
                       <li><a href="https://guc353_1.encs.concordia.ca/PatientRec.php"> View My Appointments</a></li>';

              if($_SESSION['ID'] == 10001) // Receptionist
                echo '<li><a href="https://guc353_1.encs.concordia.ca/Appointment.php"> Make an Appointment</a></li>
                      <li><a href="https://guc353_1.encs.concordia.ca/PatientRec.php"> View Patients Appointments </a></li>
                      <li><a href="https://guc353_1.encs.concordia.ca/Register.php">Register</a></li>
                      <li><a href="https://guc353_1.encs.concordia.ca/Search.php"> Search Patients</a></li>
                      <li><a href="https://guc353_1.encs.concordia.ca/doctor.php"> Worker Details</a></li>';

               if($_SESSION['ID'] < 40000 && $_SESSION['ID'] > 30000 ) // Doctor
                 echo '<li><a href="https://guc353_1.encs.concordia.ca/Search.php"> Search Patients</a></li>
                       <li><a href="https://guc353_1.encs.concordia.ca/doctor.php"> Worker Details</a></li>
					   <li><a href="https://guc353_1.encs.concordia.ca/doctor_appointment.php">Prescription</a></li>
					   <li><a href="https://guc353_1.encs.concordia.ca/doctor_availability.php">Availability</a></li>';
               if($_SESSION['ID'] < 30000 && $_SESSION['ID'] > 20000 ) // Nurse
                 echo ' <li><a href="https://guc353_1.encs.concordia.ca/doctor.php"> Worker Details</a></li>';

               if($_SESSION['ID'] > 40000 ) // Therapist
                  echo '<li><a href="https://guc353_1.encs.concordia.ca/doctor_availability.php">Availability</a></li>
						<li><a href="https://guc353_1.encs.concordia.ca/PatientRec.php"> View Patients Appointments </a></li>';
                                   }
            ?>
	  </div>
	 </nav>
	</header>
	<div class="container">
		 <div class="jumbotron">
		  <h1>Bahamas Sports Physio Center</h1>

		  <?php
		   if(isset($_SESSION['ID'])){

		   echo ' <p> WELCOME '.$_SESSION['F_NAME'].' '.$_SESSION['L_NAME'].' ! <br> Have a beautiful day  </p>';
		  }?>

		</div>


	<!--Footer-->
	<nav class = "navbar navbar-default navbar-fixed-bottom"> 
		<div class="container">
			<center>

			<center>
		</div>
	</nav>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="http://cdn.bootcss.com/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
  </body>
</html>