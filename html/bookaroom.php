<?php
	session_start();
	require_once('login.php');
	require_once('mysql_entities_fix_string.php');
	$connection = new mysqli($hn,$un,$pw,$db);
	if($connection->connection_error) die ($connection->connection_error);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Rooms</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/template.css">
   <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css">
  <script src="../js/updateRoomAjax.js"></script>
  <script src="../js/addCalendars.js"></script>
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
				echo <<<_END
						  <div class="well"><p><a href="changeBookingDate.php">Change Booking</a></p></div>

_END;
			}
		  ?>
		</div>
		<div class="col-sm-8 text-left"> 
			
		  <h1>Rooms</h1>
		  <div class ="row">
		  <!-- Form to filter and select a room -->
		  <form  action="bookRoomGuest.php" method="post" id="roomfinder" name="roomfinder" class="col-xs-7 col-md-5" onchange="updateRoomsAjax();">
			<h4>Select a room and hit "Confirm Booking"</h4>
			<h4>Please select a date</h4>
			<h4>Then choose the options you want to display the availability</h4>
			<?php
			//Employees and Admins can book a room for a guest
				if($_SESSION['account_type'] == 'Employee'){
					echo <<<_END
					<div class="form-group">
						<label for="guest_id">Guest ID</label>
						<select name="guest_id" id="guest_id">
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
				<label for="room_numbers">Room Numbers</label>
				<select id="room_numbers" name="room_numbers">
					<?php
						$query = "SELECT Room_ID FROM Room";
						$result = $connection->query($query);
						if(!$result) die ($connection->error);
						
						$num_rows = $result->num_rows;
						for($x=0;$x<$num_rows;++$x){
							$result->data_seek($x);
							$rows = $result->fetch_array(MYSQLI_NUM);
							echo "\n<option value=\"".$rows[0]."\">".$rows[0]."</option>";
						}
					?>			
				</select>
			</div>
			<div class="form-group">
				<label for="smoking_option">Smoking Option:</label>
				<select id="smoking_option" name="smoking_option">
					<option value="false">Non-Smoking</option>
					<option value="true">Smoking</option>
					<option value="either" selected>Either</option>
				</select>
			</div>
			<div class="form-group">
				<label for="pet_option">Pet Option</label>
				<select id="pet_option" name="pet_option">
					<option value="true">Pet Friendly</option>
					<option value="false">Non-Pet Friendly</option>
					<option selected="selected" value="either">Either</option>
				</select>
			</div>
			<div class="form-group">
				<label for="room_size">Room Size</label>
				<select name="room_size" id="room_size">
					<?php
						
						$query = "SELECT DISTINCT(Room_Type) As Type FROM Room";
						$result = $connection->query($query);
						if(!$result) die ($connection->connection_error);
						$num_rows = $result->num_rows;
						for($x=0; $x<$num_rows;$x++){
							$result->data_seek($x);
							$row = $result->fetch_array(MYSQLI_NUM);
							echo "\n<option value=\"".$row[0]."\">".$row[0]."</option>";
						}
						$result->close();
					
					?>
				</select>
			</div>
			<div class="form-group">
				<label for="start_date">Start Date:</label>
				<input class="date_selector" name="start_date" id="start_date" value=""  readonly="readonly" required>
			</div>
			<div class="form-group">
				<label for="end_date">End Date:</label>
				<input class="date_selector" name="end_date" id="end_date" value=""  readonly="readonly" required>
			</div>
			<div class="form-group">
				<label id="price">Price:</label>
			</div>
			<div class="form-group">
				<button type="submit" id="submitbooking" class="btn-default btn-warning">Choose Room</button>
			</div>
			
		  </form>
		  <div class="table-responsive col-xs-offset-1 col-lg-offset-4">

			<table class="table-responsive" style="width:20%;">
				<tr>
					<td style="border:2px solid black; padding:2px;">Not Available</td>
				</tr>
				<tr>
					<td style="border:2px solid black; padding:2px; background-color: red;">Available</td>
				</tr>
			</table>
		  <!-- Room Map -->
			<h3>Map Of The Hotel</h3>
			<table style="border:none;" id="room_map">
			<?php 
				
				
				$query = "SELECT Room_ID FROM Room";
				$result = $connection->query($query);
				if(!$result) die ($connection->error);
				
				$num_of_rooms = $result->num_rows;
				
				
				for($x=0;$x<$num_of_rooms;$x++){
					$result->data_seek($x);
					$room_num = $result->fetch_array(MYSQLI_NUM);
					
					if($x % 9 == 0)
						echo "\n\t<tr>";
					echo '<td style="border:2px solid black; padding:2px;" value="'.$room_num[0]."\">".$room_num[0]."</td>";
					if($x % 9 == 0 && $x != 0)
						echo "\n\t</tr>";
				}

				$result->close();
				$connection->close();
			?>
			</table>
			<br>
			
		</div>
		
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
