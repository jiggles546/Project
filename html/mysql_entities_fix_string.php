<?php
	function mysql_fix_string($connection, $var){
			if(get_magic_quotes_gpc()){
				$var = stripslashes($var);
			}
			return $connection->real_escape_string($var);
		}
	
	function mysql_entities_fix_string($connection, $var){
			return htmlentities(mysql_fix_string($connection,$var));
	}

?>