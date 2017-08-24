<?php
	session_start();
	require_once'login.php';
	$connection = new mysqli($hn,$un,$pw,$db);
	if($connection->error) die ($connection->error);
	if(!isset($_SESSION['email'])){
		$_SESSION['error_message'] = "Not signed into an account, please login";
		header('Location:errorPage.php');
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>My Account</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/template.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="../js/updateAccountInformation.js"></script>
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
	    <div class="col-sm-8 text-left"> 
		<h1>Welcome <?php echo $_SESSION['fname']." ".$_SESSION['lname'];?></h1>
		<hr>
		<p>Here you can review and make changes to your account details or your bookings</p>
		<div class="row content" >
			<button class="btn" data-toggle="collapse" data-target="#account_info" id="reveal_account_info">Account Information</button>
				<div id="account_info">
					<?php
						$query = "SELECT Email,ID,First_Name,Last_Name FROM Account_Information WHERE ID='".$_SESSION['id']."'";
						$result = $connection->query($query);
						if(!result) die ($connection->error);
						$num_rows = $result->num_rows;
						$row = $result->fetch_array(MYSQLI_NUM);
echo <<<_END
	<table>
		<tr><td>Account Number: $row[1] </td></tr>
		<tr><td>Email Adress: $row[0]</td></tr><tr><td><button class="btn" id="emailButton">Change</button></td></tr> 
		<tr><td><form action="submitChange.php" method="get">
			<span id="email_input"><input name="new_email" type="email" required/> <button type="submit" class="btn" id="submit_email">Submit</button></span><br>
		</form>
		</td></tr>
		<tr><td>Full Name: $row[2] $row[3]</td></tr><tr><td><button class="btn" id="nameButton">Change</button></td></tr>
		<tr><td><form action="submitChange.php" method="get">
			<span id="name_input"><input name="new_fname" type="text" placeholder="First Name" required /> <input name="new_lname" placeholder="Last Name" type="text" required /> <button type="submit" class="btn" id="submit_name">Submit</button></span><br>
		</form>
		</td></tr>
	</table><br>
_END;
					?>
				</div>
			<?php
				if($_SESSION['account_type'] == 'Guest'){
					echo '<button class="btn" data-toggle="collapse" data-target="#booking_info">Booking Information</button>';
					echo '<div id="booking_info">';
						
							$query = "SELECT Reservation_ID, Room_ID, Date_In, Date_Out FROM Reservation WHERE (Date_In >= CURDATE() OR Date_Out >= CURDATE()) AND
							Is_Cancelled='FALSE' AND Guest_ID=".$_SESSION['id'];
							$result = $connection->query($query);
							if(!$result) die ($connection->error);
							$num_rows = $result->num_rows;
							echo "<table>";
							for($x = 0; $x < $num_rows; ++$x){
								$result->data_seek($x);
								$row = $result->fetch_array(MYSQLI_NUM);
								echo '<tr><td>Reservation ID: '.$row[0].'</td></tr>';
								echo '<tr><td>Room Number: '.$row[1].'</td></tr>';
								echo '<tr><td>Check In Date: '.$row[2].'</td></tr>';
								echo '<tr><td>Check Out Date: '.$row[3].'</td></tr>';
								echo '<tr><td><br></td></tr>';
							}
						echo "</table>";
						
						$result->close();
						$connection->close();
						
					echo '</div>';
			}
			?>
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
</body>
</html>
