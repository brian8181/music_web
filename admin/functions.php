<?php

function get_user($user_name, $db)
{
	$user_name = mysql_real_escape_string($user_name);
	// make sure user dose not exsit
	$sql = "SELECT id FROM `user` WHERE user='$user_name'";
	$result = mysql_query( $sql, $db );
	if( mysql_num_rows($result) )
	{
		return $result;
	}
	return null;
}

//limit number of accounts to 10 per day
function ip_blocked($type, $db)
{
	$remote_ip = $_SERVER['REMOTE_ADDR'];
	$sql = "SELECT * from limits where ip='$remote_ip' && insert_ts > (NOW() - INTERVAL 1440 MINUTE);";
	$result = mysql_query( $sql, $db );
	$count = mysql_num_rows($result);
	return $count > 9;
}

function create_account($user_name, $password, $full_name, $email, $db)
{
	$sql = "INSERT INTO `user` (`user`, `password`, `full_name`, `email`, `comment`) " .
					"VALUES('$user_name', '$password', '$full_name', '$email', 'web user')";
	mysql_query( $sql, $db );
	// insert into user group
	$user_id = mysql_insert_id( $db );
	$sql = "SELECT id FROM `group` WHERE `group`.`group`='user'";
	$result = mysql_query( $sql, $db );
	$row = mysql_fetch_row( $result );
	$group_id = $row[0];
	mysql_query("INSERT INTO `user_group` (`user_id`, `group_id`) VALUES($user_id, $group_id)", $db);
	
	if( mysql_affected_rows($db) > 0 )
	{
		$remote_ip = $_SERVER['REMOTE_ADDR'];
		mysql_query("INSERT INTO `limits` (`user_id`, `ip`) VALUES($user_id, '$remote_ip')", $db);
		return true;
	}
	// make sure it inserted
	return false;
}

function update_account($user_name, $password, $full_name, $email, $db)
{
	$sql = "UPDATE `user` SET `password`='$password', `full_name`='$full_name', `email`='$email' " .
					"WHERE `user`='$user_name'";
	mysql_query( $sql, $db );
	// make sure it inserted
	return ( mysql_affected_rows($db) > 0 );
}
?>