<?php
	$salt1 = "as#@fdsf4";
	$salt2 = "2#$'2;";
	require_once('login.php');
	require_once('mysql_entities_fix_string.php');
	$connection = new mysqli($hn,$un,$pw,$db);
	if($connection->connection_error) die ($connection->error);

	$fname = mysql_entities_fix_string($connection,$_POST['fname']);
	$lname = mysql_entities_fix_string($connection,$_POST['lname']);
	$email = mysql_entities_fix_string($connection,$_POST['email']);
	$password = mysql_entities_fix_string($connection,$_POST['password']);
	
	echo <<<_END
		<!DOCTYPE html>
		<html lang="en">
		<head>
		  <title>Registration</title>
		  <meta charset="utf-8">
		  <meta name="viewport" content="width=device-width, initial-scale=1">
		  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		  <link rel="stylesheet" href="../css/template.css">
		  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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
					echo " Logged in as ".$fname." ".$lname;
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
			</div>
			<div class="col-sm-8 text-left"> 
_END;

	
		
	if(!checkIfEmailAlreadyExists($connection,$email)){
		session_start();
		$password = hash('ripemd128',$salt1.$password.$salt2);
		$query = "INSERT INTO Account_Information VALUES ('$email','$password',NULL,'$fname','$lname','Guest')";
		
		$result = $connection->query($query);
		if(!$result) die ($connection->error);
		$query = "SELECT LAST_INSERT_ID()";
		$result = $connection->query($query);
		if(!result) die ($connection->error);
		$row = $result->fetch_array(MYSQLI_NUM);
		$account_number = $row[0];
		
		$_SESSION['id']	   			= $account_number;
 		$_SESSION['fname'] 			= $fname;
		$_SESSION['lname'] 			= $lname;
		$_SESSION['email'] 			= $email;
		$_SESSION['account_type']	= 'Guest';
	
	echo <<<_END
		  <h1>Registration Complete</h1>
			  <p></p>
			  <hr>
			  <div class="table-responsive ">
			  <table class="table-hover table-striped">
				<tbody>
					<tr>
						<td class="col-xs-2">Account Number</td>
						<td class="col-xs-2">$account_number</td>
					</tr>
					<tr>
						<td class="col-xs-2">First Name</td>
						<td class="col-xs-2">$fname</td>
					</tr>
					<tr>
					<tr>
						<td class="col-xs-2">Last Name</td>
						<td class="col-xs-2">$lname</td>
					</tr>
					<tr>
						<td class="col-xs-2">Email</td>
						<td class="col-xs-2">$email</td>
					</tr>
				</tbody>
			  </table>
			 </div>
_END;
	}
	else{
		echo <<<_END
		<h1>Registration Failed</h1>
		<p></p>
		<hr>
		<p>
		Failed to create account, the email already exists within the system
		</p>
_END;
	}
	
echo<<<_END
			</div>
			<div class="col-sm-2 sidenav">
			  <div class="well">
				<p><a href="myAccount.php">My Account</a></p>
			  </div>
			  <div class="well">
				<p><a href="signout.php">Sign Out</a></p>
			  </div>
			</div>
		  </div>
		</div>


		<footer class="container-fluid text-center">
		  <p>Footer Text</p>
		</footer>

		</body>
		</html>

_END;
	
	$connection->close();
	
	function checkIfEmailAlreadyExists($connection, $email){
		$query = "SELECT Email FROM Account_Information WHERE Email='$email'";
		$result = $connection->query($query);
		if(!$result) die ($connection->error);
		return $result->num_rows != 0;
	}
?>
