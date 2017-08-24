<!DOCTYPE html>
<html lang="en">
<head>
  <title>Login</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/template.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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
        <li><a class="active" href="loginscreen.php"><span class="glyphicon glyphicon-log-in"></span> <?php
		session_start();
		if(isset($_SESSION['email'])){
			echo " Logged in as ".$_SESSION['fname']." ".$_SESSION['lname'];
		}
		else{
			echo " Login";
		}
		
		?></a></li>
      </ul>
    </div>
  </div>
</nav>
  
<div class="container-fluid text-center">    
  <div class="row content">
    <div class="col-sm-2 sidenav">
      <div class="well"><p><a href="homepage.php">Home</a></p></div>
      <div class="well"><p><a href="bookaroom.php">Book A Room</a></p></div>
	   <?php
		if($_SESSION['account_type'] == 'Employee'){
			echo '<div class="well"><p><a href="changeBookingDate.php">Change Booking Date</a></p></div>';
		}
	  ?>
    </div>
    <div class="col-sm-8 text-left"> 
		<h1 class="text-center">Login</h1><br><br><br>
		<?php
			session_start();
			
			if(isset($_SESSION['email'])){
				echo "You've already been logged in as ".$_SESSION['fname']." ".$_SESSION['lname'];

			}
			else{
				echo<<<_END
					<form class="form-horizontal" action="authenticate.php" method="post">
			<div class="form-group">
				<label for="email" class="control-label col-sm-offset-2 col-sm-2 col-lg-offset-0">Email:</label>
				<div class="col-sm-6 col-lg-10">
					<input type="email" placeholder="Enter Email" class="form-control" id="email" name="email">
				</div>
			</div>
			<div class="form-group">
				<label for="password" class="control-label col-sm-offset-2 col-sm-2 col-lg-offset-0">Password:</label>
				<div class="col-sm-6 col-lg-10">
					<input type="password" placeholder="Enter Password" class="form-control" id="password" name="password">
				</div>
			</div>
			<div class="form-group">
				<button type="submit" class="col-sm-offset-5 btn btn-default" value="authenticate" name="action">Submit</submit>
				<button type="submit" class="col-sm-offset-1 btn btn-default" value="register" name="action">Register</submit>
			</div>
		</form>
		<div id="result">
		</div>
_END;
				
			}
		
		?>
	
		
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
