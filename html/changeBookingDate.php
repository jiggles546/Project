<?php
	require_once('login.php');
	$connection = new mysqli($hn,$un,$pw,$db);
	if($connection->connection_error) die ($connection->connection_error);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Change Booking Date</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/template.css">
   <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css">
  <script src="../js/updateRoomAjax.js"></script>
  <script src="../js/addCalendars.js"></script>
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
			echo '<div class="well"><p><a href="changeBookingDate.php">Change Booking</a></p></div>';
		}
	  ?>
		</div>
		<div class="col-sm-8 text-left"> 
			
		  <h1>Change Booking Date</h1>
		  <hr>
		  <div class ="row">
		  <!-- Form to filter and select a room -->
		  <form  action="changeReservation.php" method="post" id="roomfinder" name="roomfinder" class="col-xs-3">
			<h4>Select a reservation and a new start and end date then hit "Change Reservation"</h4>
			<?php
			//Employees and Admins can book a room for a guest
				session_start();
				if($_SESSION['account_type'] == 'Employee'){
					echo <<<_END
					<div class="form-group">
						<label for="guest_id">Guest ID</label>
						<select name="guest_id" id="guest_id" onchange="updateCancellationID()">
							<option value=""></option>
_END;
					$get_user_accounts = "SELECT ID FROM Account_Information WHERE User_Type='Guest'";
					$result = $connection->query($get_user_accounts);
					if(!$result) die ($connection->error);
					$num_rows = $result->num_rows;
					for($x = 0; $x < $num_rows; ++$x){
						$result->data_seek($x);
						$row = $result->fetch_array(MYSQLI_NUM);
						echo '<option value="'.$row[0].'">'.$row[0].'</option>';
					}
					echo <<<_END
					</select>
					</div>
_END;
	
				}
			?>
			<div class="form-group">
				<label for="reservation_id">Reservation Number:</label>
				<select id="reservation_id" name="reservation_id" required>
					
				</select>
			</div>
			
			
			<div class="form-group">
				<label for="start_date">New Start Date:</label>
				<input class="date_selector" name="start_date" id="start_date" value=""  readonly="readonly" required>
			</div>
			<div class="form-group">
				<label for="end_date">New End Date:</label>
				<input class="date_selector" name="end_date" id="end_date" value=""  readonly="readonly" required>
			</div>
			<div class="form-group">
				<button type="submit" id="submitbooking" class="btn-default btn-warning">Change Reservation</button>
			</div>
			
		  </form>
		</div>
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
