<?php

	require_once'login.php';
	require_once'mysql_entities_fix_string.php';
	$connection = new mysqli($hn,$un,$pw,$db);
	session_start();
	
	
	if(isset($_GET['new_email'])){
		$new_email = mysql_entities_fix_string($connection, $_GET['new_email']);
		$insert_new_email = "UPDATE Account_Information SET Email='".$_GET['new_email']."' WHERE Email='".$_SESSION['email']."'";
		$result = $connection->query($insert_new_email);
		if(!$result) {
			$_SESSION['error_message'] = $connection->error; 
			header('Location:errorPage.php');
		}
		$_SESSION['email'] = $_GET['new_email'];
		
	}

	if(isset($_GET['new_fname']) &&
	isset($_GET['new_lname'])){
		
		$new_fname = mysql_entities_fix_string($connection, $_GET['new_fname']);
		$new_lname = mysql_entities_fix_string($connection, $_GET['new_lname']);
		
		
		$insert_new_name = "UPDATE Account_Information SET First_Name='".$new_fname."', Last_Name='".$new_lname."' WHERE Email='".$_SESSION['email']."'";
		$result = $connection->query($insert_new_name);
		if(!$result) die ($connection->error);
		$_SESSION['fname'] = $new_fname;
		$_SESSION['lname'] = $new_lname;
	}
	
	$connection->close();
	header('Location:myAccount.php');
	
?>