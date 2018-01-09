<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bahamas Sports Physio Center</title>

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">

	  <script type="text/javascript" src="javascript/validation.js"> </script>
      <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>

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
			<li><a href="https://guc353_1.encs.concordia.ca/logout.php">Log Out</a></li>

			<?php
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
			?>

		  </ul>
		</div>
	  </div>
	 </nav>
	</header>
	<div class="container">
		<div class="row">
		  <div class="col-md-8">
				 <div class="jumbotron">
					 <h2>Bahamas Sports Physio Center</h2>
					 <p>Search For Patient</p>
				 </div>
		  </div>
		  <div class="col-md-4">
				<form name = "SearchPatient" id= "SearchForm"  method="post"  >
				  <div class="form-group">
					<label for="fname">First Name</label>
					<input type="text" class="form-control" name="q" id="fname" >
					<input type="submit" id="submit" value="Search"/>
					</form>
				  </div>
				  <!--
					<div class="form-group">
						<label for="lname">Last Name</label>
						<input type="text" class="form-control" id="lname" placeholder="Last Name">

					</div>
					
					<div class="form-group">
						<label for="Hnum">Health Number</label>
						<input type="text" class="form-control" id="HNum" placeholder="Health Number">
					</div>
					-->

		  </div>
		</div>
		 <div class="col-md-5">
				 <div class="jumbotron">
					 <h2>Search Results:</h2>
					 
				
		<?php
				mysql_connect("guc353_1.encs.concordia.ca", "guc353_1", "mehal420") or die("Error connecting to database: ".mysql_error());
				$db = mysql_select_db("guc353_1")or die("Error connecting to database: ".mysql_error());
				
				$q=$_POST['q'];
				
				if($_POST['q'] == ''){
					echo '<h3> No Patients Found </h3>';

				} else{
				
				$query = mysql_query("SELECT PATIENT.F_NAME, PATIENT.L_NAME, PATIENT.P_ID, PRESCRIPTION.DIAGNOSIS, PRESCRIPTION.DOCTOR_DESCRIPTION
				 FROM TAKE
				JOIN PRESCRIPTION 
				ON TAKE.NUMBER=PRESCRIPTION.NUMBER
				JOIN
				PATIENT
				ON TAKE.P_ID=PATIENT.P_ID
				WHERE PATIENT.F_NAME LIKE '%$q%' ");
				
				
				$num_rows = mysql_num_rows($query);
				
				
				while($rows = mysql_fetch_array($query)){
					
					$fName = $rows['F_NAME'];
					$lName = $rows['L_NAME'];
					$pID = $rows['P_ID'];
					$descr=$rows['DOCTOR_DESCRIPTION'];
					$diagnosis=$rows['DIAGNOSIS'];
					echo 'First Name: ' .$fName.' <br /> Last Name: '.$lName.'<br /> ID: '.$pID.' <br /> DOCTOR DESCRIPTION: '.$descr.'<br/> 						DIAGNOSIS: '.$diagnosis;
				}

				if($_POST['q'] == ''){
					echo ' BLank';
					
				}
				$noMatch = mysql_num_rows($query);
				if($noMatch == 0){
					echo "No records<br>";
				}
				 //echo 'Looked for: ' .$q; 
				}

?> 
</div>
		  </div>
		  <!--
		<div class="container">
		<h1>Search All:</h1>
		<button class="btn btn-success" onclick=" window.open('https://guc353_1.encs.concordia.ca/test.php','_blank')"> Workers</button>
	
		</div>-->
	</div>
	<nav class = "navbar navbar-default navbar-fixed-bottom">

	</nav>

    <script src="http://cdn.bootcss.com/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
  </body>
</html>
