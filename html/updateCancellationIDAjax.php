<?php
	
	require_once'login.php';
	require_once'mysql_entities_fix_string.php';
	$connection = new mysqli($hn,$un,$pw,$db);
	if($connection->connection_error) die ($connection->connection_error);
	
	if(isset($_GET['guest_id'])){
		$guest_id = mysql_entities_fix_string($connection, $_GET['guest_id']);
		$get_reservation_id = "SELECT Reservation_ID FROM Reservation WHERE Guest_ID='".$guest_id."'";
		$result = $connection->query($get_reservation_id);
		if(!$result) die ($connection->error);
		$num_rows = $result->num_rows;
		echo '<option value="" default></option>';
		for($index = 0; $index < $num_rows; ++$index){
			$result->data_seek($index);
			$row = $result->fetch_array(MYSQLI_NUM);
			echo '<option value="'.$row[0].'">'.$row[0]."</option>";
		}
	}
	
	
	$connection->close();


?>