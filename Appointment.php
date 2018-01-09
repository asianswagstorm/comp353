<?php
session_start();
$connect = mysqli_connect("guc353_1.encs.concordia.ca", "guc353_1", "mehal420", "guc353_1");

$prescriptionNum='';
$AppointmentDate='';






//echo sizeof($ID);
  if($_SESSION['ID'] < 10001)
       { $P_ID = $_SESSION['ID'];
           $query ="SELECT * FROM TAKE WHERE P_ID=$P_ID";
          $data = mysqli_query($connect,$query);

        }
        else if ($_SESSION['ID'] == 10001){
			 $rid=$_SESSION['ID'];
           	 $query ="SELECT * FROM TAKE ORDER BY P_ID";
           	 $data = mysqli_query($connect,$query);
        }
        $provide = mysqli_query($connect, "SELECT * FROM PROVIDE");
        $sql = "SELECT  APPOINTMENT_PERIOD FROM patient_record WHERE P_ID= $P_ID";
        $result = mysqli_query($connect,$sql);

if(isset($_POST['submit'])) {
$prescriptionNum = trim(htmlspecialchars($_POST['prescriptNum']));
$AppointmentDate = trim(htmlspecialchars($_POST['date']));
if ($_SESSION['ID'] == 10001){
	$P_ID = trim(htmlspecialchars($_POST['P_ID']));
}

$APP = mysqli_query($connect, "INSERT INTO APPOINTMENT (PRESCR_N, PERIOD) VALUES ($prescriptionNum, '$AppointmentDate')");
$SQL= "INSERT INTO MAKE (P_ID,PRESCR_N, PERIOD) VALUES ('$P_ID' , $prescriptionNum , '$AppointmentDate')";
$MAKE=mysqli_query($connect, $SQL);
$getTYPE=mysqli_fetch_assoc(mysqli_query($connect, "SELECT TYPE FROM TREATMENT WHERE PERIOD='$AppointmentDate' LIMIT 1"));
$resultTYPE=$getTYPE['TYPE'];
$RECEIVE=mysqli_query($connect, "INSERT INTO RECEIVE VALUES('$P_ID','$resultTYPE','$AppointmentDate')");
$REC = mysqli_query($connect, "INSERT INTO patient_record VALUES ('$P_ID', '$AppointmentDate')");

if ($MAKE){
	$_SESSION['paydate'] = $AppointmentDate;
	$UPDATES=mysqli_query($connect, "INSERT INTO UPDATES(R_ID,APPOINTMENT_PERIOD,PRESCR_N) VALUES ('$rid','$AppointmentDate','$prescriptionNum')");
	header("Location:https://guc353_1.encs.concordia.ca/payment.php");
}

else {
	echo "Invalid Appointment";
}

}//end of submit


        mysqli_close($connect);
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
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="http://cdn.bootcss.com/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

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
			<li><a href="logout.php"> Log Out </a></li>
		<?php
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
		   ?>
		     </ul>
		</div>
	  </div>
	 </nav>
	</header>
	<div class="container">
	  <div class="row">
		<div class="col-md-6">
		  <form action = "#" method = "post" name = "postdetail" id = "postdetail">		
				<table class="table">
				<caption>Book an Appointment</caption>

					<tr>
						<th>
							<label>Perscription Number</label>
							</th>
						<th>
							    <input type="number" class="form-control" id="prescription" name = "prescriptNum" placeholder="Enter Perscription Number">
						</th>
					</tr>
					
					<?php
					
					if ($_SESSION['ID'] == 10001){
						
						echo'<tr>
							<th>
								<label>Patient ID</label>
								</th>
							<th>
									<input type="number" class="form-control" id="PID" name = "P_ID" placeholder="Enter Patient ID">
							</th>
						</tr>';
					}
					?>
					<tr>
						<th>
							<label>Appointment Date:</label>
						</th>
						<th>
							<input type="datetime-local" class="form-control" id="offerdate" name="date" placeholder="enter appointment date">
						</th>
					</tr>

				</table>	
			    <div class="pull-right">
				  <button type="reset" class="btn btn-default ">Reset</button>
				  <button type="submit" class="btn btn-primary" name = "submit" onclick = "#">Submit</button>
			    </div>
			</form>
		</div>
		

		<div class="col-md-6">
			<div class="jumbotron">
				<h2>Bahamas Sports Physio Center</h2>
               <p> <?php
                     if(isset($_SESSION['ID'])){
                           if ($_SESSION['ID'] == 10001)
                     { echo ' <p> Prescription Numbers For Patients <br>  </p>';

                            if($data-> num_rows > 0 ){
                        echo' <table>
                        <tr>
                        <th> Patient ID  &nbsp&nbsp&nbsp </th>
                        <th> Prescription Number</th>
                        </tr>';
                         while($info= $data->fetch_assoc())
               	                    {
               		                  echo '
               		                      <tr>
               				              <td>'.$info['P_ID'].'</td>
               				              <td>'.$info['NUMBER'].'</td>
               			                  </tr>';
               	                    }
               	                          mysqli_free_result($data);
               	                        echo '</table>';
                                                         }
                     }
                           else {
                                   if($data-> num_rows > 0 ){
                                      echo' <table>
                                            <tr>
                                            <th> Your Prescription Numbers are </th>
                                            </tr>';
                                             while($info= $data->fetch_assoc() )
                                               {
                                                 echo '
                                                    <tr>
                                                    <td>'.$info['NUMBER'].'</td>
                                                   	</tr>';
                                               }
                                              mysqli_free_result($data);
                                              echo '</table>';
                                           	                    }
                                   }
                                                         }?>

			    </div>
		    <div>
                <?php

                       if(isset($_SESSION['ID'])){
                            echo ' <p> Available times from Therapists <br>  </p>';

                                        if($provide-> num_rows > 0 ){
                                    echo' <table>
                                    <tr>
                                 
                                      <th> Available Period &nbsp&nbsp&nbsp </th>
                                      <th> Type Of Treatment</th>
									  <th> Therapist First Name &nbsp&nbsp&nbsp </th>
                                      <th> Therapist Last Name  &nbsp&nbsp&nbsp </th>

                                    </tr>';
									echo '
                           		                      <tr>';
									$connect = mysqli_connect("guc353_1.encs.concordia.ca", "guc353_1", "mehal420", "guc353_1");
									$THERA_IDR= mysqli_query($connect, "SELECT THERA_ID FROM PROVIDE");
									 $a = 0;
									 $tF = array();
									$tL = array();
									for ($i = 0;$i < mysqli_num_rows($THERA_IDR); $i++){
										$theraNR = mysqli_query($connect, "SELECT F_NAME,L_NAME FROM worker where ID = $THERA_ID");
										$ID = mysqli_fetch_array($THERA_IDR);
										//while($ID-> num_rows > 0)
										$THERA_ID = $ID[0];
										$theraNR = mysqli_query($connect, "SELECT F_NAME,L_NAME FROM worker where ID = $THERA_ID");
										$theraN = mysqli_fetch_array($theraNR);
										$theraFN = $theraN['F_NAME'];
										$theraLN = $theraN['L_NAME'];
										array_push($tF, $theraFN);
										array_push($tL, $theraLN);
									}
                                     while($values = $provide ->fetch_assoc())
                           	                    {
                           		                  
                           		                      echo '
                           				              <td>'.$values['PERIOD'].'  &nbsp&nbsp&nbsp</td>
                           				              <td>'.$values['TYPE'].'</td>
													  <td>'.$tF[$a].'</td>
													  <td>'.$tL[$a].'</td>
													  </tr>';
													  $a = $a + 1;
                           	                    }
                           	                          mysqli_free_result($provide);
													  
									
                           	                        echo '</table>';
                                                                     }


                                                                   } ?>
																   
		    </div>
		</div>			
	  </div>
	  
	</div>

	
	
	<nav class = "navbar navbar-default navbar-fixed-bottom">
	</nav>

	<script type = "text/javascript" src="./js/validation.js"></script>
  </body>
</html>