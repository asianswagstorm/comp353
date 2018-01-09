<?php
	session_start();
	$conn = mysqli_connect("guc353_1.encs.concordia.ca", "guc353_1", "mehal420", "guc353_1");  

	if (mysqli_connect_errno()) {
		printf("Connection Not Completed: %s\n", mysqli_connect_error());
	exit();
	}
	
	$date = $_SESSION['paydate'];
	
	//$db = mysql_select_db("guc353_1");

	//echo $date;
	
	
	if(isset($_POST['pay'])){
		$method = $_POST['method'];
		$amount = $_POST['amount'];
		$patient= $_POST['patient'];
		
		//echo 'hi';
		//echo $method;
		//echo $amount;
		//$loginID = stripslashes($_POST['loginId']);
		//$loginID = mysqli_real_escape_string($db,$loginID);
		/*
		mysql_query("INSERT INTO `table` (`dateposted`) VALUES (now())");
		//if($loginID < 10001){
		$query = "INSERT INTO PAYMENT (METHOD, PERIOD, AMOUNT) VALUES ($method,now(), $amount)";
		$qf = "SELECT* FROM PATIENT WHERE P_ID = $loginID";
*/
		//$method = mysqli_real_escape_string($db,$method);

		$sql = "INSERT INTO PAYMENT ( METHOD, PERIOD, AMOUNT) VALUES ('$method',  '$date', '$amount') ";
		echo $method . $date . $amount;
		$result = mysqli_query($conn,$sql);
		//$verify = mysqli_query($conn,"INSERT INTO VERIFY  VALUES ('$date', '$amount', 'PayPal', '21:00:00') ");
		$validPatient=mysqli_query($conn, "SELECT P_ID FROM patient_record WHERE P_ID='$patient'");
		if($validPatient)
			$numsPatient=mysqli_num_rows($validPatient);
		else
			$numsPatient=0;
		if($numsPatient===0)
			echo "Invalid Patient ID";
		else if(!$result){
			echo 'Invalid payment <br/>';
		}
		else{
			$patientPaid=mysqli_query($conn,"INSERT INTO PAY(P_ID,AMOUNT,PERIOD) VALUES('$patient','$amount','$date')");
			echo 'Payment successful <br/>';
		}
		
		if($method == 'CARD'){
			$verify = mysqli_query($conn,"INSERT INTO VERIFY  VALUES ('$date', '$amount', 'PayPal', '21:00:00') ");
			if($verify){
			echo 'Card agency properly verified';
		}
		}
		
		
		
    }

	mysqli_close($conn);
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
                echo '<li><a href="https://guc353_1.encs.concordia.ca/payment.php"> Make Payment</a></li>
                       <li><a href="https://guc353_1.encs.concordia.ca/Appointment.php"> Make an Appointment</a></li>
                       <li><a href="https://guc353_1.encs.concordia.ca/PatientRec.php"> View My Appointments</a></li>';
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

	</div>
	<div class="container">
					<form method="POST" action = "">
						<fieldset>
							<label> Patient ID
							<input type ="number" name="patient" id="patient"/> </label><br/>
						
							<label> Prefered method of payment?
								<select name = "method">
									<option value = "CASH"> Cash</option>
									<option value = "CARD"> Card</option>
									<option value = "CHEQUE"> Cheque </option>
								</select>
							</label><br /><br />
							<label>Amount?
							<input type ="text" name="amount" id="amount"/> </label><br/>
						</fieldset>
						
						 <button type="submit" name= "pay" class="btn btn-primary"  >Submit Payment</button>
                	</form>
					
		</div>
	<!--Footer-->
	<nav class = "navbar navbar-default navbar-fixed-bottom">
		
	</nav>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="http://cdn.bootcss.com/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
  </body>
</html>