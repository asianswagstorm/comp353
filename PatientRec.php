<?php   session_start();
        $connect = mysqli_connect("guc353_1.encs.concordia.ca", "guc353_1", "mehal420", "guc353_1");

        if($_SESSION['ID'] < 10001)
        $ID = $_SESSION['ID'];
        else if ($_SESSION['ID'] == 10001){
        if(isset($_POST['Submit'])){
        		$ID = stripslashes($_POST['Id']);
        		$ID = mysqli_real_escape_string($connect,$ID);
           	     $query ="SELECT F_NAME, L_NAME FROM PATIENT WHERE P_ID = $ID";
           	    $data = mysqli_query($connect,$query);
                        $info= $data->fetch_assoc();
           	                        }
                                        	


	if(isset($_POST['Delete'])){
		$patient=mysqli_real_escape_string($connect,$_REQUEST['patient']);//patient ID
		$resultPatient=mysqli_query($connect, "SELECT P_ID FROM patient_record WHERE P_ID='$patient'");
		
		$period=mysqli_real_escape_string($connect,$_REQUEST['delDATE']);//delete time
		$resultPeriod=mysqli_query($connect, "SELECT APPOINTMENT_PERIOD FROM patient_record WHERE APPOINTMENT_PERIOD= '$period' AND P_ID='$patient'");
			if($resultPatient)
				$numsPatient=mysqli_num_rows($resultPatient);
			else
				$numsPatient=0;
			
			if($resultPeriod)
				$numsPeriod=mysqli_num_rows($resultPeriod);
			else
				$numsPeriod=0;
			
			if($numsPatient===0){
				echo "Invalid Patient ID";
			}
			else if($period==='0000-00-00 00:00:00'){
				echo "Invalid Appointment time entered.";
			}
			else if(!($numsPeriod>=1)){
				echo "The patient does not have that appointment time.<br> Please retry <br>";		
			}
			else{

					$sql1="DELETE FROM MAKE WHERE PERIOD='$period' AND P_ID='$patient'";
					$query1=mysqli_query($connect,$sql1);//delete appointment record from MAKE
					$query2=mysqli_query($connect,"DELETE FROM APPOINTMENT WHERE PERIOD='$period'");
					if($query1){
						echo "<h4> DELETION SUCCESSFUL</h4> </br>";
					}
					else{
						echo "Error: ". mysqli_error($connect);
					}
				
			}
	}
		}
		
        $sql = "SELECT  PERIOD FROM MAKE WHERE P_ID= $ID";
	//$sql = "SELECT * FROM(PRESCRIPTION JOIN TAKE ON TAKE.NUMBER = PRESCRIPTION.NUMBER) WHERE P_ID = $ID ";
        $result = mysqli_query($connect,$sql);
		$ID=$_SESSION['ID'];
		$sql2="SELECT PROVIDE.PERIOD, PROVIDE.TYPE 
				FROM RECEIVE JOIN PROVIDE ON PROVIDE.PERIOD=RECEIVE.PERIOD AND PROVIDE.TYPE=RECEIVE.TYPE
				WHERE THERA_ID='$ID'";
		$result2=mysqli_query($connect,$sql2);

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
				<li><a href="https://guc353_1.encs.concordia.ca/logout.php">Log Out</a></li>
			    <?php if(isset($_SESSION['ID'])){

                              if($_SESSION['ID'] < 10001) //Patient
                                echo '
                                       <li><a href="https://guc353_1.encs.concordia.ca/Appointment.php"> Make an Appointment</a></li>
                                       <li><a href="https://guc353_1.encs.concordia.ca/PatientRec.php"> View My Appointments</a></li>';

                              if($_SESSION['ID'] == 10001) // Receptionist
                                echo '<li><a href="https://guc353_1.encs.concordia.ca/Appointment.php"> Make an Appointment</a></li>
                                      <li><a href="https://guc353_1.encs.concordia.ca/PatientRec.php"> View Patients Appointments</a></li>
                                      <li><a href="https://guc353_1.encs.concordia.ca/Register.php">Register</a></li>
                                      <li><a href="https://guc353_1.encs.concordia.ca/Search.php"> Search Patients</a></li>
                                      <li><a href="https://guc353_1.encs.concordia.ca/doctor.php"> Worker Details</a></li>';

                              if($_SESSION['ID'] > 40000 ) // Therapist
                                 echo '<li><a href="https://guc353_1.encs.concordia.ca/doctor_availability.php">Availability</a></li>
                                       <li><a href="https://guc353_1.encs.concordia.ca/PatientRec.php"> View Patients Appointments </a></li>';

                                                  } ?>
			  </ul>
			</div>
		  </div>
		 </nav>
		</header>
		  <div class="container">
			<div class="row">
			    <?php
                                      if ($_SESSION['ID'] == 10001){
                                         echo'    <div class="col-md-4">
                              				<form method="POST" action = "">
                              				  <div class="form-group">
                              					<label for="Login ID">Enter Patient ID</label>
                              					<input type="number" class="form-control" id="PID" name= "Id" placeholder="Patient ID">
                              				  </div>
                              				  <button type="submit" name= "Submit" class="btn btn-primary" > Submit</button>
	
							<div class="form-group">
								<th><label>Delete Appointment: </label></th> 
								<th><input type="datetime"class="form-control" name="delDATE" placeholder="YYYY-MM-DD hh:mm:ss"></th>
								<th><label>For Patient: </label></th> 
								<th><input type="number"class="form-control" name="patient" placeholder="Enter Patient ID"></th>
							</div>
								<button type="submit" name= "Delete" class="btn btn-primary" > Delete</button>
	
                              				</form>
                              		         </div> ';
                                                         }
                                       ?>
			  <div class="col-md-8">

					     <div class="jumbotron">
						 <h2>Bahamas Sports Physio Center</h2>
						 <p> <?php
                            if(isset($_SESSION['ID'])){
                             if ($_SESSION['ID'] == 10001)
                            echo ' <p> Here are the appointments for <br> '.$info['F_NAME'].' '.$info['L_NAME'].'  </p>';
                            else{
                            echo ' <p>  '.$_SESSION['F_NAME'].' '.$_SESSION['L_NAME'].',  <br> Here are your appointments </p>';
							while($row2= $result2->fetch_assoc()  )
								{
										 echo '
												<tr>
												 <td>'.$row2['PERIOD'].'<br></td> 
											   
												</tr>';
								}
							 mysqli_free_result($result2);
							}
                             if($result-> num_rows > 0 ){
                                        echo' <table>
                                          <tr>
                       				      <th>Appointments Scheduled</th>
                       			          </tr>';

                        while($row= $result->fetch_assoc()  )
	                    {
	                        if ($row['APPOINTMENT_PERIOD'] == '0000-00-00 00:00:00')
                                 echo '
                                		<tr>
                                		<td> - </td>
                                        </tr>';
                            else
		                         echo '
		                                <tr>
										 <td>'.$row['PERIOD'].'</td> 
				                       
			                            </tr>';
	                    }
	                          mysqli_free_result($result);
	                        echo '</table>';
                                                        }
                            	  } ?></p>
					 </div>
			  </div>
			  <div class="col-md-4">

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
