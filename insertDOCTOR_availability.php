<?php
	$con=mysqli_connect("guc353_1.encs.concordia.ca","guc353_1","mehal420","guc353_1");
	if($con===false){
		die("connection failed!".mysqli_connect_error());
	}
	
	if(isset($_POST["submit"])){
		$w_id=mysqli_real_escape_string($con,$_REQUEST['workID']);//worker ID
		$period=mysqli_real_escape_string($con,$_REQUEST['avDATE']);//available time
		$treatment=mysqli_real_escape_string($con,$_REQUEST['treatment']);//type of treatment provided
		$center=mysqli_real_escape_string($con,$_REQUEST['center']);;//CENTER at which therapist provides treatment
		
		$resultPeriod=mysqli_query($con, "SELECT PERIOD FROM TIMETABLE WHERE PERIOD= '$period'");
		$numsPeriod=mysqli_num_rows($resultPeriod);
		
		$resultWorker=mysqli_query($con, "SELECT ID FROM worker WHERE ID= '$w_id'");
		$numsWorker=mysqli_num_rows($resultWorker);
		
		if($w_id<10000 || !($numsWorker>=1))
		{
			echo "<h4> Invalid worker ID</h4> </br>";
			echo"<a href='https://guc353_1.encs.concordia.ca/doctor_availability.php'>Go Back</a>";
		}
		else if($period<date('Y-m-d H:i:s')){
			echo "<h4> That period is in the past</h4> </br>";
			echo"<a href='https://guc353_1.encs.concordia.ca/doctor_availability.php'>Go Back</a>";
		}
		else if($period>date('Y-m-d H:i:s', strtotime("+60 days")))
		{
			echo "<h4> Cannot display availability at this time yet</h4> </br>";
			echo"<a href='https://guc353_1.encs.concordia.ca/doctor_availability.php'>Go Back</a>";
		}
		else if($numsPeriod>=1)
		{
			$sql1="";
			if($w_id>40000)
				$sql1.="UPDATE AVAILABLE_AT SET THERA_ID='$w_id' WHERE PERIOD='$period'";
			else if($w_id>30000)
				$sql1.="UPDATE AVAILABLE_AT SET DOC_ID='$w_id' WHERE PERIOD='$period'";
			else
				$sql1.="UPDATE AVAILABLE_AT SET NURSE_ID='$w_id' WHERE PERIOD='$period'";
			$query1=mysqli_query($con,$sql1);//insert values into AVAILABLE_AT table
			echo "<h4> Update Successful</h4> </br>";
			echo"<a href='https://guc353_1.encs.concordia.ca/doctor_availability.php'>Go Back</a>";
		}
		else{ 
			
			$sql1="INSERT INTO TIMETABLE(PERIOD) VALUES('$period')";
			$query1=mysqli_query($con,$sql1);//insert values into TIMETABLE table
			
			$sql2="INSERT INTO TREATMENT(PERIOD,TYPE) VALUES('$period','$treatment')";
			$query2=mysqli_query($con,$sql2);//insert values into TREATMENT table
			
			if($w_id>40000){
				$sql3="INSERT INTO PROVIDE(THERA_ID,PERIOD,TYPE) VALUES('$w_id','$period','$treatment')";
				$query3=mysqli_query($con,$sql3);//insert values into PROVIDE table
			}
			$sql4="";
			if($w_id>40000)
				$sql4.="INSERT INTO AVAILABLE_AT(THERA_ID,PERIOD) VALUES('$w_id','$period')";
			else if($w_id>30000)
				$sql4.="INSERT INTO AVAILABLE_AT(DOC_ID,PERIOD) VALUES('$w_id','$period')";
			else
				$sql4.="INSERT INTO AVAILABLE_AT(NURSE_ID,PERIOD) VALUES('$w_id','$period')";
			$query4=mysqli_query($con,$sql4);//insert values into AVAILABLE_AT table

			$chosenOption=mysqli_real_escape_string($con,$_REQUEST['selectbox']);
			$query5=mysqli_query($con,"INSERT INTO USES(EQUIP_NAME, TREAT_PERIOD, TREAT_TYPE) VALUES ('$chosenOption', '$period', '$treatment')");
			
			if($w_id>40000){
				if($query1 && $query2 && $query3 && $query4){
					echo "<h4> THANKS</h4> </br>";
					echo"<a href='https://guc353_1.encs.concordia.ca/doctor_availability.php'>Go Home</a>";
				}
				else{
					echo "Error: ". mysqli_error($con);
				}
			}
			else{
				if($query1 && $query2 && $query4){
					echo "<h4> THANKS</h4> </br>";
					echo"<a href='https://guc353_1.encs.concordia.ca/doctor_availability.php'>Go Home</a>";
			}
				else{
					echo "Error: ". mysqli_error($con);
				}
			}
		}
	}
	mysqli_close($con);

?>
