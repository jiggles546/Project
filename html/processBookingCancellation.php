<?php

	
	require_once'login.php';
	require_once('mysql_entities_fix_string.php');
	$connection = new mysqli($hn,$un,$pw,$db);
	if($connection->connect_error) die ($connection->connect_error);
	
	$reservation_id = $_GET['reservation_number'];
	$cancel_booking = "DELETE FROM Reservation WHERE Reservation_ID='".$reservation_id."'";
	$result = $connection->query($cancel_booking);
	if(!$result) die ($connection->error);
	$connection->close();
	header('Location:successfulDeletionBooking.php');
?>