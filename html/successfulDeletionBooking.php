<?php
	session_start();
	if($_SESSION['account_type'] != 'Employee'){
		$_SESION['error_message'] = "Insufficient Permissions";
		header('Location:errorPage.php');
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Successful Deletion</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../css/homepage.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/template.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<nav class="navbar navbar-inverse" style="height:100%">
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
        <li><a href='loginscreen.php'><span class='glyphicon glyphicon-log-in'></span> <?php
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
      <div class="well"><p><a class="active" href="homepage.php">Home</a></p></div>
      <div class="well"><p><a href="bookaroom.php">Book A Room</a></p></div>
	  <?php
		if($_SESSION['account_type'] == 'Employee'){
			echo '<div class="well"><p><a href="changeBookingDate.php">Change Booking Date</a></p></div>';
		}
	  ?>
    </div>
    <div class="col-sm-8 text-left"> 
      <h1>Sucess</h1>
      <hr>
      <p>The reservation has been deleted</p>
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
      <?php
            if($_SESSION['account_type'] == 'Employee'){
            echo <<<_END
                <div class="well">
                    <p><a href="statistics.php">Statistics</a></p>
                </div>
_END;
            }
      
      ?>
      <div class="well">
        <p><a href="signout.php">Sign out</a></p>
      </div>
    </div>
  </div>
</div>

<br>
<footer class="container-fluid text-center">
<p></p>
</footer>

</body>
</html>
