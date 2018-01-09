<?php
 session_start();
 $connect = mysqli_connect("guc353_1.encs.concordia.ca", "guc353_1", "mehal420", "guc353_1");
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
                          {  echo '<li><a href="https://guc353_1.encs.concordia.ca/Appointment.php"> Make an Appointment</a></li>
                                  <li><a href="https://guc353_1.encs.concordia.ca/PatientRec.php"> View Patients Appointments </a></li>
                                  <li><a href="https://guc353_1.encs.concordia.ca/Register.php">Register</a></li>
                                  <li><a href="https://guc353_1.encs.concordia.ca/Search.php"> Search Patients</a></li>
                                  <li><a href="https://guc353_1.encs.concordia.ca/doctor.php"> Worker Details</a></li>'; }

                           if($_SESSION['ID'] < 40000 && $_SESSION['ID'] > 30000 ) // Doctor
                            {
                            echo '<li><a href="https://guc353_1.encs.concordia.ca/Search.php"> Search Patients</a></li>
                                   <li><a href="https://guc353_1.encs.concordia.ca/doctor.php"> Worker Details</a></li>
            					   <li><a href="https://guc353_1.encs.concordia.ca/doctor_appointment.php">Prescription</a></li>
            					   <li><a href="https://guc353_1.encs.concordia.ca/doctor_availability.php">Availability</a></li>'; }
                           if($_SESSION['ID'] < 30000 && $_SESSION['ID'] > 20000 ) // Nurse
                             echo ' <li><a href="https://guc353_1.encs.concordia.ca/doctor.php"> Worker Details</a></li>';
			?>

		  </ul>
		</div>
	  </div>
	 </nav>
	</header>
	<div class="container" style="position:relative;left:100px;"  >
	<div class="row" >
		  <div class="col-md-10" align = "center">
				 <div class="jumbotron">
					 <h2>List of all workers</h2>
					
				 </div>
		  </div>
		
		</div>
		</div>
<div class= "container" style="position:relative;left:350px;">
<?php

$sql ="SELECT * FROM worker WHERE CENTER = 'BSPC' ";

if($result = mysqli_query($connect,$sql)){
	
	if($result-> num_rows > 0){
	echo '<table border ="1.5" width = "400" cellpadding = "1" >
		<tr>
			<th>First Name</t>
			<th>Last Name</t>
			<th>ID</t>
			<th>Center</t>

		</tr>';
	
	
	
	while($row= $result->fetch_assoc())
	{
	
		
		echo '
			<tr>
				<td>'.$row['F_NAME'].'</td>
				<td>'.$row['L_NAME'].'</td>
				<td>'.$row['ID'].'</td>
				<td>'.$row['CENTER'].'</td>
				
			</tr>';
		
		
	}
	mysqli_free_result($result);
	echo'
		</table>';
}

}


mysqli_close($connect);


?>
</div>
	<nav class = "navbar navbar-default navbar-fixed-bottom">

	</nav>

    <script src="http://cdn.bootcss.com/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
  </body>
</html>