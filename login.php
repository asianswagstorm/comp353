<?php
	session_start();
	$connect = mysqli_connect("guc353_1.encs.concordia.ca", "guc353_1", "mehal420", "guc353_1");

	if (mysqli_connect_errno()) {
		printf("Connection Not Completed: %s\n", mysqli_connect_error());
	exit();
	}

	if(isset($_POST['LOGIN'])){
		$loginID = stripslashes($_POST['loginId']);
		$loginID = mysqli_real_escape_string($connect,$loginID);

		if($loginID < 10001){
		$query = "SELECT* FROM PATIENT WHERE P_ID = $loginID";


		$result = mysqli_query($connect,$query);
		$row = mysqli_fetch_assoc($result);
		$numrows = mysqli_num_rows($result);

       if($numrows>=1 ){

       			$_SESSION['ID'] = $row['P_ID'];
       			$_SESSION['F_NAME'] = $row['F_NAME'];
       			$_SESSION['L_NAME'] = $row['L_NAME'];
                   header("Location:https://guc353_1.encs.concordia.ca/index.php");
       		}
        }
        if ($loginID >= 10001){
        $query = "SELECT* FROM worker WHERE ID = $loginID";
        $qf = "SELECT* FROM worker WHERE ID = $loginID";

		$result = mysqli_query($connect,$query);
		$row = mysqli_fetch_assoc($result);
		$numrows = mysqli_num_rows($result);

         if ($numrows>=1){
     		      $_SESSION['ID'] = $row['ID'];
              	  $_SESSION['F_NAME'] = $row['F_NAME'];
              	  $_SESSION['L_NAME'] = $row['L_NAME'];
                  header("Location:https://guc353_1.encs.concordia.ca/index.php");
     		 }
        }


		else{
			echo "<div class='form'> <h3>Login ID is incorrect.</h3>";}
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
            	echo '<li class="active"><a href="login.php">Login</a></li>'; }
            ?>

	  </div>

	 </nav>
	</header>
	<div class="container">
		 <div class="jumbotron">
		  <h1>Bahamas Sports Physio Center</h1>
		  <p>WELCOME</p>

		</div>
		<div class="row">
			<div class="col-md-4">
				<h2>Login</h2>
				 <div class="col-md-4">
                				<form method="POST" action = "">
                				  <div class="form-group">
                					<label for="Login ID">Login ID</label>
                					<input type="number" class="form-control" min =1 id="PLog" name= "loginId" placeholder="Login ID">
                				  </div>
                				  <button type="submit" name= "LOGIN" class="btn btn-primary"  >Login</button>
                				</form>
                		  </div>
				</p>
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