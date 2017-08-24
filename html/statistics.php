<?php 

    session_start();
	require_once('mysql_entities_fix_string.php');
	require_once 'login.php';
	$connection = new mysqli($hn, $un, $pw, $db);

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Statistics</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/template.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
	//Display room popularity
	google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(drawChart);
			
	// Draw the chart and set the chart values
	function drawChart() {
	var data = google.visualization.arrayToDataTable([
<?php
	
	if($connection->error){
		$_SESSION['error_message'] = "Could not connect to the database";
		header('Location:errorPage.php');
	}
	$query = "SELECT Room_ID, COUNT(Room_ID) FROM Reservation WHERE Date_In >= CURDATE() GROUP BY Room_ID";
	$result = $connection->query($query);
	$numRows = $result->num_rows;
	echo "['Room_ID','Count'],";
        $x = 0;
	for($x = 0; $x < $numRows-1; ++$x){
		$result->data_seek($x);
		$row = $result->fetch_array(MYSQLI_NUM);
		echo <<<_END
			['$row[0]',$row[1]],
_END;
	}
	$x++;
	$result->data_seek($x);
	$row = $result->fetch_array(MYSQLI_NUM);
echo<<<_END

	['$row[0]',$row[1]]]);
_END;
?>
	var options = {'title':'Room Popularity Future', 'width':550, 'height':400};
	var chart = new google.visualization.PieChart(document.getElementById('room_popularity_future'));
	chart.draw(data,options);
	}
  </script>
  <script type="text/javascript">
	//Display room popularity
	google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(drawChart);
			
	// Draw the chart and set the chart values
	function drawChart() {
	var data = google.visualization.arrayToDataTable([
<?php
	
	if($connection->error){
		$_SESSION['error_message'] = "Could not connect to the database";
		header('Location:errorPage.php');
	}
	$query = "SELECT Room_ID, COUNT(Room_ID) FROM Reservation GROUP BY Room_ID";
	$result = $connection->query($query);
	$numRows = $result->num_rows;
	echo "['Room_ID','Count'],";
        $x = 0;
	for($x = 0; $x < $numRows-1; ++$x){
		$result->data_seek($x);
		$row = $result->fetch_array(MYSQLI_NUM);
		echo <<<_END
			['$row[0]',$row[1]],
_END;
	}
	$x++;
	$result->data_seek($x);
	$row = $result->fetch_array(MYSQLI_NUM);
echo<<<_END

	['$row[0]',$row[1]]]);
_END;
?>
	var options = {'title':'Room Popularity', 'width':550, 'height':400};
	var chart = new google.visualization.PieChart(document.getElementById('room_popularity'));
	chart.draw(data,options);
	}
  </script>
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
			echo '<div class="well"><p><a href="changeBookingDate.php">Change Booking</a></p></div>';
		}
	  ?>
	 </div>
    <div class="col-sm-8 text-left"> 
      <h1>Statistics</h1>
      <hr>

		<div style="float:left;"id="room_popularity">
		</div>
     
		<div style="float:right;" id="room_popularity_future"></div>  
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
