<?php 

    session_start();
	require_once('mysql_entities_fix_string.php');
	require_once 'login.php';
	$connection = new mysqli($hn, $un, $pw, $db);
	if($connection->connect_error) die ($connection->connect_error);

    if(!isset($_SESSION['email'])){
        $_SESSION['error_message'] = "User not logged in, please login and restart the operation";
        header('Location:errorPage.php');
    }
	else{
		$room_num 		= mysql_entities_fix_string($connection,$_POST['room_numbers']);
		$smoking_option = mysql_entities_fix_string($connection,$_POST['smoking_option']);
		$pet_option 	= mysql_entities_fix_string($connection,$_POST['pet_option']);
		$start_date 	= mysql_entities_fix_string($connection,$_POST['start_date']);
		$end_date 		= $_POST['end_date'];
		$guest_id		= $_SESSION['id'];
				
		//Employees can only book rooms for other guests
		if($_SESSION['account_type'] == 'Employee')
			$insert_booking = "INSERT INTO Reservation VALUES (NULL,'$room_num', '".$_POST['guest_id']."', '$start_date', '$end_date', 'false')";
		else
			$insert_booking = "INSERT INTO Reservation VALUES (NULL, '$room_num', '$guest_id', '$start_date', '$end_date', 'false')";
		$result = $connection->query($insert_booking);
		if(!$result) die ($connection->error);
		
		$getConfirmationNumber = "SELECT LAST_INSERT_ID()";
		$result = $connection->query($getConfirmationNumber);
		if(!result) die ($connction->error);
		$confirmationNumber = $result->fetch_array(MYSQLI_NUM);
		$confirmationNumber = $confirmationNumber[0];
		
	}
?>


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
			echo '<div class="well"><p><a href="changeBookingDate.php">Change Booking Date</a></p></div>';
		}
	  ?>
	 </div>
    <div class="col-sm-8 text-left"> 
      <h1>Confirm</h1>
      <hr>
	  <p>Thank you for booking with our hotel, your reservation number is <?php echo $confirmationNumber;?></p>
          <p>The amount due is to be paid at check in time. If you would like to change the reservation dates or cancel your reservation please contact the hotel at 519-222-2222</p>
      
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
