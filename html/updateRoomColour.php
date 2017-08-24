<?php

//No sanitazion required as the elements are taking from dropdown list with predetermined values
$room_num 		= $_GET['room_num'];
$room_size		= $_GET['room_size'];
$smoking_option = $_GET['smoking_option'];
$pet_option 	= $_GET['pet_option'];
$start_date 	= $_GET['start_date'];
$end_date 		= $_GET['end_date'];

$possible_rooms = array();
require_once('login.php');
$connection = new mysqli($hn,$un,$pw,$db);
if($connection->connection_error) die ($connection->connection_error);

$query = "SELECT Room.Room_ID FROM Room,Reservation WHERE 1";

if(	!empty($start_date) &&
    !empty($end_date)
    ){
        $query .= " AND Room.Room_ID NOT IN( SELECT Reservation.Room_ID FROM Reservation WHERE Date_In BETWEEN '".$start_date."' AND '".$end_date."' OR Date_Out BETWEEN '".$start_date."' AND '".$end_date."' )";
        
}

$query .= " AND Room.Room_Type='".$room_size."'";

if(!empty($smoking_option)){
    if(strcmp($smoking_option, "either") != 0)
        $query .= " AND Room.Smoking=".$smoking_option;
	
}

if(!empty($pet_option)){
    if(strcmp($pet_option, "either") != 0)
        $query .= " AND Room.`Pet-Friendly`=".$pet_option;
}

$result = $connection->query($query);
$num_rows = $result->num_rows;
for($x=0;$x<$num_rows;$x++){
    $result->data_seek($x);
    $row = $result->fetch_array(MYSQLI_NUM);
    array_push($possible_rooms,$row[0]);
}

$room_num = 1;

$query = "SELECT COUNT(*) FROM Room";
$result = $connection->query($query);
$num_of_rooms = $result->fetch_array(MYSQLI_NUM);
$num_of_rooms = $num_of_rooms[0];


for($x=0;$x<$num_of_rooms;$x++){
	
	if($x % 9 == 0)
		echo "\n\t<tr>";
	if(xIsAPossibleRoom($room_num, $possible_rooms))
		echo "<td style=\"border:2px solid black; padding:2px; background-color:red;\" value=\"".$room_num."\">".$room_num."</td>";
	else
		echo "<td style=\"border:2px solid black; padding:2px;\" value=\"".$room_num."\">".$room_num."</td>";
	$room_num++;
	if($x % 9 == 0)
		echo "\n\t</tr>";
}

echo "\n\t</tr>";

$result->close();
$connection->close();

function xIsAPossibleRoom($x, $possible_rooms){
    $size = sizeof($possible_rooms);
    for($index=0;$index<$size;$index++){
        if($x == $possible_rooms[$index]) return true;
    }
    return false;
}
?>

