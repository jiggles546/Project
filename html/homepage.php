<!DOCTYPE html>
<html lang="en">
<head>
  <title>Home Page</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
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
      <h1>Welcome</h1>
      <hr>
	  <h3>Mission Statement</h3>
      <p>Here at Peterson Hotel we aim to offer our clients the outmost best care, at the best price, that's humanly possible. Currently located in Windsor Ontario, 
	  Peterson Hotel is considered one of the top rated hotels in it's area. With 67 rooms, two of which being Imperial Suites, this five star hotel provides any type of 
	  room any guest could want.</p>
	  <img class="img-responsive" src="../images/Hotel.jpg">
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
                    echo '<div class="well"><p><a href="statistics.php">Statistics</a></p></div>';
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
