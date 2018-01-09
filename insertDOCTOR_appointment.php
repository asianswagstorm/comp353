<?php
	$con=mysqli_connect("guc353_1.encs.concordia.ca","guc353_1","mehal420","guc353_1");
	if($con===false){
		die("connection failed!".mysqli_connect_error());
	}
	
	if(isset($_POST["submit"])){
		$d_id=mysqli_real_escape_string($con,$_REQUEST['docID']);//doctor
		$p_id=mysqli_real_escape_string($con,$_REQUEST['patientID']);//patient
		$diagnosis=mysqli_real_escape_string($con,$_REQUEST['diagnosis']);//diagnosis for prescription
		$notes=mysqli_real_escape_string($con,$_REQUEST['note']);//dcotor's notes
		$center=mysqli_real_escape_string($con,$_REQUEST['center']);;//CENTER at which therapist provides treatment
		
		$resultPatient=mysqli_query($con, "SELECT P_ID FROM patient_record WHERE P_ID= '$p_id'");
		$numsPatient=mysqli_num_rows($resultPatient);
		
		if(!($numsPatient>=1))
		{
			echo "<h4> Invalid Patient ID</h4> </br>";
			echo"<a href='https://guc353_1.encs.concordia.ca/doctor_appointment.php'>Go Back</a>";
		}
		else{ 
			
			$sql="INSERT INTO WRITES(DOC_ID) VALUES ('$d_id')";
			$query=mysqli_query($con,$sql);//insert DOC_ID in WRITES table
			
			$query1=mysqli_query($con,"SELECT NUMBER FROM WRITES ORDER BY NUMBER DESC LIMIT 1");
			$row=mysqli_fetch_array($query1);
			$number=$row['NUMBER'];//gets the latest prescription number from WRITES table
			$sql2="INSERT INTO PRESCRIPTION(NUMBER,CENTER,DIAGNOSIS,DOCTOR_DESCRIPTION) 
			VALUES ('$number','$center','$diagnosis','$notes')";
			$query2=mysqli_query($con,$sql2);//insert values into PRESCRIPTION table
			
			$sql3="INSERT INTO TAKE(P_ID,NUMBER) VALUES('$p_id','$number')";
			$query3=mysqli_query($con,$sql3);//insert values into TAKE table*/
			
			
			if($query && $query2 && $query3){
				echo "<h4> PRESCRITION NUMBER: $number</h4> </br>";
				echo"<a href='https://guc353_1.encs.concordia.ca/doctor_appointment.php'>Go Home</a>";
			}
			else{
				echo "Error: ". mysqli_error($con);
			}
		}
	}
	mysqli_close($con);

?>
