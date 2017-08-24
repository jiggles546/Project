<?php

	$room_number = $_GET['room_num'];
	require_once 'login.php';
	$connection = new mysqli($hn, $un, $pw, $db);
	if($conection->connect->error) die($connection->connect_error);
	$getPrice = "SELECT Price FROM Room WHERE Room_ID='$room_number'";
	$result = $connection->query($getPrice);
	$price = $result->fetch_array(MYSQLI_NUM);
	$price = $price[0];
	echo $price;
	
	$result->close();
	$connection->close();
	
	
?>