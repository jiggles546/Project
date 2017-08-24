<?php

	//No sanitazion required as the elements are taking from dropdown list with predetermined values
	require_once'login.php';
	$connection = new mysqli($hn,$un,$pw,$db);
	if($connection->connect->error) die ($connection->connect_error);
	
	if(isset($_GET['reservation_id'])){
		$get_room_num = "SELECT Room_ID FROM Reservation WHERE Reservation_ID='".$_GET['reservation_id']."'";
		$result = $connection->query($get_room_num);
		if(!$result) die ($connection->error);
		$num_num = $result->num_rows;
		$room_id = $result->fetch_array(MYSQLI_NUM);
		echo $room_id[0];
		$result->close();
	}

	$connection->close();
?>