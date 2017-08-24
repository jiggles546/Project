<?php


	$room_size		= $_GET['room_size'];
	$smoking_option = $_GET['smoking_option'];
	$pet_option 	= $_GET['pet_option'];
	$start_date 	= $_GET['start_date'];
	$end_date 		= $_GET['end_date'];
	
	require_once'login.php';
	
	$connection = new mysqli($hn, $un, $pw, $db);
	if($connection->connect_error) die ($connection->connect_error);
	
	$query = "SELECT DISTINCT(Room.Room_ID) FROM Room,Reservation WHERE 1";

	if(	!empty($start_date) &&
		!empty($end_date)
		){
			$query .= " AND Room.Room_ID NOT IN( SELECT Reservation.Room_ID FROM Reservation WHERE Date_In BETWEEN '".$start_date."' AND '".$end_date."' OR Date_Out BETWEEN '".$start_date."' AND '".$end_date."' )";
			
	}

	$query .= " AND Room.Room_Type='".$room_size."'";

	if(!empty($smoking_option))
		if(strcmp($smoking_option, "either") != 0)
			$query .= " AND Room.Smoking=".$smoking_option;
		
	

	if(!empty($pet_option))
		if(strcmp($pet_option, "either") != 0)
			$query .= " AND Room.`Pet-Friendly`=".$pet_option;
		
	
	$result = $connection->query($query);
	$num_rows = $result->num_rows;
	
	for($index = 0; $index < $num_rows; ++$index){
		$result->data_seek($index);
		$row = $result->fetch_array(MYSQLI_NUM);
		echo '<option value="'.$row[0].'">'.$row[0].'</option>';
	}
	
	$result->close();
	$connection->close();
?>