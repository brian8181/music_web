<?php

include("functions.php");
if( !empty($user) && !empty($password) && !empty($password2) && !empty($full_name) && !empty($email) )
{
	// TODO! validate user, password, email for leneght spaces & invalid chars
	if( $password == $password2 )
	{
		if( validate_pass( $password ) )
		{
			$db = mysql_connect('127.0.0.1', 'web', 'sas*.0125');
			mysql_select_db('web_admin', $db);

			mysql_real_escape_string($user);
	        	mysql_real_escape_string($password);
			mysql_real_escape_string($full_name);
			mysql_real_escape_string($email);

			// make sure user dose not exsit
			$sql = "SELECT password, last_login FROM `web_admin`.`user` WHERE user='$user'";
			$result = mysql_query( $sql, $db );
			if( mysql_num_rows($result) )
			{
				echo( "Account already exists, please choose another user name." );
			}
			else
			{
				// insert into db
				$sql = "INSERT INTO `user` (`user`, `password`, `full_name`, `email`, `comment`)
  					VALUES('$user', '$password', '$full_name', '$email', 'web user')";
				mysql_query( $sql, $db );
	
				// insert into user group
				$user_id = mysql_insert_id( $db );
				
				$sql = "SELECT id FROM `group` WHERE `group`.`group`='user'";
				$result = mysql_query( $sql, $db );
				$row = mysql_fetch_row( $result );
				$group_id = $row[0];
				
				mysql_query("INSERT INTO `user_group` (`user_id`, `group_id`) VALUES($user_id, $group_id)", $db);
				
				// make sure it inserted
				if( mysql_affected_rows($db) > 0 )
					echo( "Account created for $full_name ($user)" );
				else
					echo( "Sorry account could not be created plesae try agion later (unknown Error)" );
			}
		}
		else
		{
			echo( "Password must be at least 7 characters and be both letters and numbers" );
		}
	}
	else
	{
		echo( "Password do not match" );
	}
}
else
{
	echo( "Invalid or Missing Fields" );
}

mysql_close($db);
?>