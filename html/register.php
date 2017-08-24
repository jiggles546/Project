<!DOCTYPE html>
<html lang="en">
<head>

  <title>Registration Page</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/template.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
  <script type="text/javascript" src="../js/validateForm.js"></script>

</head>
<body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
		<img src="../images/hotellogo.png" alt="hotel logo" class="embed-responsive-item" style="width:15%;">
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="loginscreen.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
      </ul>
    </div>
  </div>
</nav>
  
<div class="container-fluid text-center">    
  <div class="row content">
    <div class="col-sm-2 sidenav">
      <div class="well"><p><a class="active" href="homepage.php">Home</a></p></div>
      <div class="well"><p><a href="bookaroom.php">Book A Room</a></p></div>
	   <?php
		if($_SESSION['account_type'] == 'Employee'){
			echo '<div class="well"><p><a href="changeBookingDate.php">Change Booking Date</a></p></div>';
		}
	  ?>
    </div>
    <div class="col-sm-8 text-left"> 
      <h1 class="text-center">Register As A Guest</h1><br><br><br>
      <form class="form-horizontal" action="createGuestAccount.php" method="post" id="register">
		<div class="form-group">
			<label for="email" class="control-label col-sm-offset-2 col-sm-2 col-lg-offset-0">First Name:</label>
			<div class="col-sm-6 col-lg-10">
				<input type="text" placeholder="Enter Your First Name" class="form-control" id="fname" name="fname" required>
			</div>
		</div>
		<div class="form-group">
			<label for="email" class="control-label col-sm-offset-2 col-sm-2 col-lg-offset-0">Last Name:</label>
			<div class="col-sm-6 col-lg-10">
				<input type="text" placeholder="Enter Your Last Name" class="form-control" id="lname" name="lname" required>
			</div>
		</div>
		<div class="form-group">
			<label for="email" class="control-label col-sm-offset-2 col-sm-2 col-lg-offset-0">Email:</label>
			<div class="col-sm-6 col-lg-10">
				<input type="email" placeholder="Enter Your Email Address" class="form-control" id="email" name="email" required>
			</div>
		</div>
		<div class="form-group">
			<label for="password" class="control-label col-sm-offset-2 col-sm-2 col-lg-offset-0">Password:</label>
			<div class="col-sm-6 col-lg-10">
				<input type="password" placeholder="Please Enter Your Password" class="form-control" id="password" name="password" required>
			</div>
		</div>
		<div class="form-group">
			<label for="passwordconfirmation" class="control-label col-sm-offset-2 col-sm-2 col-lg-offset-0">Confirm Password:</label>
			<div class="col-sm-6 col-lg-10">
				<input type="password" placeholder="Please Confirm Your Password" class="form-control" id="confirmpassword" name="confirmpassword" required>
							<br><span id="message" class="text-center"  name="message"></span>

			</div>
		</div>
			<button type="submit" class="col-sm-offset-5 btn btn-default">Submit</button><br>
	  <form>
    </div>
    <div class="col-sm-2 sidenav">
	  <?php
		if($_SESSION['account_type'] == 'Employee'){
		echo <<<_END
		<div class="well">
			<p><a href="cancelBooking.php">Cancel Bookings</a></p>
		</div>
_END;
		}
	  ?>
	       <div class="well">
        <p><a href="myAccount.php">My Account</a></p>
      </div>
	  <div class="well">
        <p><a href="signout.php">Sign Out</a></p>
      </div>
	</div>
  </div>
  

</div>


<footer class="container-fluid text-center">
  <p></p>
</footer>
</body>
</html>
