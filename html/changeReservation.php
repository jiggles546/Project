<?php
	session_start();
	if($_SESSION['account_type'] == 'Employee'){
		require_once('login.php');
		require_once('mysql_entities_fix_string.php');
		$connection = new mysqli($hn,$un,$pw,$db);
		if($connection->connect_error) die ($connection->connect_error);
		
		$start_date = mysql_entities_fix_string($connection,$_POST['start_date']);
		$end_date = mysql_entities_fix_string($connection,$_POST['end_date']);
		$reservation_id = mysql_entities_fix_string($connection,$_POST['reservation_id']);
		
		$change_booking_date = "UPDATE Reservation SET Date_In='".$start_date."', Date_Out='".$end_date."' WHERE Reservation_ID='".$reservation_id."'";
		$result = $connection->query($change_booking_date);
		if(!$result) die ($connection->error);
			
		$connection->close();
		header('Location:successfullChange.php');
	}
	else{
		$_SESSION['error_message'] = "You do not have the proper privileges for this operation";
		header('Location:errorPage.php');
	}

?>