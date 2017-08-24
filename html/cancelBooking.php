<?php
	session_start();
	require_once'login.php';
	
	$connection = new mysqli($hn,$un,$pw,$db);
	if($connection->connect_error) die ($connection->connect_error);
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Cancel Booking Page</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/template.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="../js/cancelBookingAjax.js"></script>
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
        <li><a href='loginscreen.php'><span class='glyphicon glyphicon-log-in'></span> <?php
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
      <h1>Cancel Booking Page</h1>
	  <hr>
	  <form action="processBookingCancellation.php" class="form-responsive" method="get" style="left:-50%;">
		<div class="form-group">		
			<label for="guest_id">Guest ID</label>
			<select id="guest_id" name="guest_id" onchange="updateCancellationID()">
				<option value="" default></option>
				<?php
					$get_user_accounts = "SELECT ID FROM Account_Information WHERE User_Type='Guest'";
					$result = $connection->query($get_user_accounts);
					if(!$result) die ($connection->error);
					$num_rows = $result->num_rows;
					for($x = 0; $x < $num_rows; ++$x){
					$result->data_seek($x);
					$row = $result->fetch_array(MYSQLI_NUM);
					echo '<option value="'.$row[0].'">'.$row[0].'</option>';
					}
				?>
					</select>
		</div>	
		<div class="form-group">		
			<label for="reservation_id">Reservation ID:</label>
			<select id="reservation_id" name="reservation_number" onchange="updateRoomNum()" required>
				<option value=""></option>
			</select>
		</div>
		<div class="form-group">			
			<label for="room_id">Room Number:</label>
			<input type="text" readonly="readonly" id="room_id" name="room_id">
		</div>
		<div class="form-group">
			<button type="submit">Cancel Booking</button>
		</div>  
	</form>
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


<footer class="container-fluid text-center">
  <p></p>
</footer>

</body>
</html>
<?php
	$connection->close();
?>
