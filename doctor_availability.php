<?php
session_start();
	$conn = mysqli_connect("guc353_1.encs.concordia.ca", "guc353_1", "mehal420", "guc353_1");  

	if (mysqli_connect_errno()) {
		printf("Connection Not Completed: %s\n", mysqli_connect_error());
	exit();
	}
	$query="SELECT* FROM EQUIPMENT";
	$result=mysqli_query($conn,$query);
	$option="";
	while($row=mysqli_fetch_array($result)){
		$option=$option."<option>$row[0]</option>";
	}
	mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
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
			<li><a href="login.php">Log Out</a></li>

			    <?php
               if($_SESSION['ID'] < 40000 && $_SESSION['ID'] > 30000 ) // Doctor
                 echo '<li><a href="https://guc353_1.encs.concordia.ca/Search.php"> Search Patients</a></li>
                       <li><a href="https://guc353_1.encs.concordia.ca/doctor.php"> Worker Details</a></li>
					   <li><a href="https://guc353_1.encs.concordia.ca/doctor_appointment.php">Prescription</a></li>
					   <li><a href="https://guc353_1.encs.concordia.ca/doctor_availability.php">Availability</a></li>';

                if($_SESSION['ID'] > 40000 ) // Therapist
                                 echo '<li><a href="https://guc353_1.encs.concordia.ca/doctor_availability.php">Availability</a></li>
               						<li><a href="https://guc353_1.encs.concordia.ca/PatientRec.php"> View Patients Appointments </a></li>';
                ?>
		  </ul>
		</div>
	  </div>
	 </nav>
	</header>
	<div class="container">
	  <div class="row">
		<div class="col-md-6">
		  <form action = "insertDOCTOR_availability.php" method = "post" onsubmit="return confirm('Do you really want to submit the form?');">		
				<table class="table">
				<caption>Staff Availability</caption>
					
					<tr>
						<th>
							<label>Work ID:</label>
						</th>
						<th>

							<input type="number" class="form-control" name="workID" placeholder="Enter Doctor ID">

						</th>
					</tr>
					
					<tr>
						<th>
							<label>Available Treatment Date:</label>
						</th>
						<th>

							<input type="datetime" class="form-control" name="avDATE" placeholder="YYYY-MM-DD hh:mm:ss">

						</th>
					</tr>	
					
					<tr>
						<th>
							<label>Treatment Type:</label>
						</th>
						<th>
							<input type="text" class="form-control" name="treatment" placeholder="Enter Treatment">
						</th>
					</tr>			

					<tr>
						<th>
							<label>Equipment Used:</label>
						</th>
						<th>
						<select name="selectbox">
							<?php echo $option; ?>
						</select>
						</th>
					</tr>		


				</table>	
			    <div class="pull-right">
				  <button type="reset" class="btn btn-default ">Reset</button>
				  <button type="submit" name="submit" class="btn btn-primary">Submit</button>
			    </div>
			</form>						
		</div>
		<div class="col-md-6">
			<div class="jumbotron">
				<h2>Bahamas Sports Physio Center</h2>
				<p>Enter your available time</p>
			</div>
		</div>			
	  </div>
	</div>
	<nav class = "navbar navbar-default navbar-fixed-bottom">

	</nav>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="http://cdn.bootcss.com/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
	<script type = "text/javascript" src="./js/validation.js"></script>
  </body>
</html>
