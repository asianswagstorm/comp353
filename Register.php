<?php
session_start();
$connect = mysqli_connect("guc353_1.encs.concordia.ca", "guc353_1", "mehal420", "guc353_1");
    if (mysqli_connect_errno()) {
	print "Connection Failed" . mysqli_connect_error();
	exit();
}
$F_NAME= '';
$L_NAME='';
$PHONE='';
$ADDRESS='';
$AGE= '';
    if(isset($_POST['Register'])){

		$F_NAME = stripslashes($_POST['fname']);
		$L_NAME = stripslashes($_POST['lname']);
		$PHONE = stripslashes($_POST['phone']);
		$ADDRESS = stripslashes($_POST['address']);
		$AGE = stripslashes($_POST['age']);

        $QUERYID = "SELECT MAX(P_ID) FROM patient_record";

        $tempIDR = mysqli_query($connect, $QUERYID);

        $row = mysqli_fetch_array($tempIDR);
        $tempID = $row[0];
        $NEWID = ($tempID+1);
			
            $query = "INSERT INTO patient_record (P_ID, APPOINTMENT_PERIOD) VALUES ($NEWID, '0000-00-00 00:00:00')";
			$SQL = "INSERT INTO PATIENT (P_ID, F_NAME ,L_NAME ,ADDRESS,PHONE ,AGE) VALUES ($NEWID, '$F_NAME','$L_NAME','$ADDRESS','$PHONE',$AGE)";
			$patientR = mysqli_query($connect, $query);
			if (!$patientR){
				echo $NEWID;
			}
			$result= mysqli_query($connect, $SQL);

            if(!$result)
                echo "<div class='form'> <h3>Registration Failed </h3>";
			else{
				$rid=$_SESSION['ID'];
			    $registerSUCCESS=mysqli_query($connect,"INSERT INTO REGISTER(P_ID,R_ID) VALUES('$NEWID','$rid')");
			}

        }
		mysqli_close($connect);
?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bahamas Sports Physio Center</title>
		<script type="text/javascript"  src="js/formValidation.js"></script>
    <!-- Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">


	  <script type="text/javascript" src="javascript/validation.js"> </script>
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
			    <li class="active"><a href="logout.php">Logout</a></li>
			    <li><a href="https://guc353_1.encs.concordia.ca/Appointment.php"> Make an Appointment</a></li>
			    <li><a href="https://guc353_1.encs.concordia.ca/PatientRec.php"> View Patient Appointments</a></li>
			    <li class="active"><a href="./Register.php">Register</a></li>
			    <li><a href="https://guc353_1.encs.concordia.ca/Search.php"> Search Patients</a></li>
                <li><a href="https://guc353_1.encs.concordia.ca/doctor.php"> Worker Details</a></li>

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
						 <?php
                         		   if(isset($_SESSION['ID'])){
                         		   echo '  Hello '.$_SESSION['F_NAME'].' '.$_SESSION['L_NAME'].' , <br>';
                         		            if($result)
                                   			echo "<div class='form'> <h3> Patient Successfully Registered. Patient ID:".$NEWID."  </h3>";
                         		            else echo "Please register a new patient thank you very much!" ;

                         		  }?>

					 </div>
			  </div>
			  <div class="col-md-4">
					<form method = "post" name = "signup" id = "frm" onsubmit="validate()">

					  <div class="form-group">
						<label for="InputFName">First Name</label>
						<input type="text" class="form-control" name = "fname" id="fname" placeholder="First Name">
					  </div>

					  <div class="form-group">
						<label for="InputLName">Last Name</label>
						<input type="text" class="form-control" name = "lname" id="lname" placeholder="Last Name">
					  </div>

					  <div class="form-group">
						<label for="InputPhone">Phone Number</label>
						<input type="text" class="form-control" id="phonen" name="phone" placeholder="(xxx)xxx-xxxx">
					  </div>				  
					  <div class="form-group">
						<label for="exampleInputEmail1">Address</label>
						<input type="text" class="form-control" id="Addr" name = "address" placeholder="Enter Address">
					  </div>

				      <div class="form-group">
						<label for="InputAge">Age</label>
						<input type="number" min=18 class="form-control" id="Age" name="age" placeholder="Enter Age">
					  </div>

					  <button type="reset" class="btn btn-default">Reset</button>
						<button type="submit" class="btn btn-primary" name = "Register" onclick = "return validate()">Register</button>
					</form>
			  </div>
			</div>
		  </div>
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
		<script type = "text/javascript" src="./js/validation.js"></script>
    </body>
</html>
