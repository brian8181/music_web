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
// create a new account
function create_account($user_name, $password, $full_name, $email, $question_id, $answer, $db)
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
		$sql = "INSERT INTO `limits` (`user_id`, `ip`) VALUES($user_id, '$remote_ip')";
		mysql_query($sql, $db);
		$sql = "INSERT INTO `user_security_question` (`user_id`, `question_id`, `answer`) 
				VALUES($user_id, $question_id, '$answer')";
		mysql_query($sql, $db);
		return true;
	}
	// make sure it inserted
	return false;
}
//////////////////////////////////////
// auths user and sets session vars //
//////////////////////////////////////
function set_session($user, $pass, $db)
{
	$sql = "SELECT user.id, `user`, `group`, `password`, email, full_name, `style`.`id`, `style`.`file` FROM `user` " . 
			"INNER JOIN `user_group` ON `user`.id=`user_id` " . 
			"INNER JOIN `group` ON `user_group`.`group_id`=`group`.id " .
			"LEFT JOIN `style` ON `style`.`id`=`style_id` " . 
			"WHERE user='$user' AND password='$pass'";
	$result = mysql_query( $sql, $db );
	if( mysql_num_rows($result) )
	{
		$row = mysql_fetch_row($result);
		$_SESSION['_USER_ID'] = $row[0]; 
		$_SESSION['_USER'] = $row[1];
		$_SESSION['USER_PASSWORD'] = $row[3];
		$_SESSION['USER_EMAIL'] = $row[4];
		$_SESSION['USER_FULLNAME'] = $row[5];
		$_SESSION['USER_STYLE_ID'] = $row[6];
		$_SESSION['USER_STYLE'] = $row[7];
		// fetch groups
		$_groups = array();
		do{
			$grp = $row[2];
			$groups[$grp] = 1;
		}while( $row == mysql_fetch_row($result) );
		$_SESSION['_GROUPS'] = $groups;
		return true;
	}
	return false;
}

function update_account($user_name, $password, $full_name, $email, $style_id, $db)
{
	$sql = "UPDATE `user` SET `password`='$password', `full_name`='$full_name', `email`='$email', `style_id`=$style_id " .
					"WHERE `user`='$user_name'";
	mysql_query( $sql, $db );
	// make sure it inserted -1 = failed
	return ( mysql_affected_rows($db) > -1 );
}

function update_settings($user_name, $style_id, $db)
{
		
}

// validate user is logged in 
function assert_login()
{
	if( isset($_SESSION['_USER']) && isset($_SESSION['_GROUPS']) )
	{
		return true;
	}
	return false;
}

function assert_group($group)
{
	if(assert_login())
	{
		$groups_loc = $_SESSION['_GROUPS']; 
		if(array_key_exists('admin', $groups_loc))
		{
			return true;
		}
	}
	return false;
}

function validate_pass($password)
{
	if(
	ctype_alnum($password) // numbers & digits only
	&& strlen($password)>6 // at least 7 chars
	&& strlen($password)<21 // at most 20 chars
	//&& preg_match('`[A-Z]`',$password) // at least one upper case
	//&& preg_match('`[a-z]`',$password) // at least one lower case
	// at least one lower case or // at least one upper case
	&& ( preg_match('`[A-Z]`',$password) || preg_match('`[a-z]`',$password) )
	&& preg_match('`[0-9]`',$password) // at least one digit
	){
		// valid
		return true;
	}else{
		// not valid
		return false;
	} 
}

?>