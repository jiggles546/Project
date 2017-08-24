<?php
	$salt1 = "as#@fdsf4";
	$salt2 = "2#$'2;";
	
	if($_POST['action'] == 'register'){
		header('Location:register.php');
	}
	else{
		require_once('login.php');
		require_once'mysql_entities_fix_string.php';

		$connection = new mysqli($hn, $un, $pw, $db);
		if($connection->connect_error) die($connection->connect_error);
		
		
		$rec_un = $_POST['email'];
		$rec_pw = $_POST['password'];
		if(	!empty($rec_un) &&
			!empty($rec_pw)
			){
				$un_temp = $rec_un;
				$pw_temp = $rec_pw;
				$un_temp = mysql_entities_fix_string($connection,$rec_un);
				$pw_temp = mysql_entities_fix_string($connection,$rec_pw);
				$query = "SELECT * FROM Account_Information WHERE Email='$un_temp'";
				$result = $connection->query($query);
				if(!$result){
					die($connection->error);
				} 
				elseif($result->num_rows == 1){
					$row = $result->fetch_array(MYSQLI_NUM);
					$result->close();
					$token = hash('ripemd128', $salt1.$pw_temp.$salt2);
					session_start();
					if($token == $row[1]){
						
						$_SESSION['id']	   			= $row[2];
 						$_SESSION['fname'] 			= $row[3];
						$_SESSION['lname'] 			= $row[4];
						$_SESSION['email'] 			= $un_temp;
						$_SESSION['account_type']	        = $row[5];
						$connection->close();
						header('Location:homepage.php');
					}
					else{
						$_SESSION['error_message'] = "Error logging in, invalid username/password";
                                                header('Location:errorPage.php');
                                        }
				}
			}
		else{
			header('Location:loginscreen.php');
			$connection->close();
		}
		
		
	}
?>
