<?php
	//if not logged in goto login page 
	session_start(); 
	if( !isset( $_SESSION['_USER'] ) )
	{
		$_SESSION['_PAGE'] = $PHP_SELF;
		header( "Location: /login.php" );
	}
	else
	{
		//$usr_grps UID:GID[-][,GID-UID:GID...]
		if(!isset($usr_grps))
		{
			echo( "<div style=\"text-align: center\"><h3>Sorry, there was an error accessing this page.</h3></div>" );	
			echo( "<div style=\"text-align: center\"><a href=\"/index.php\"><i>www.bkp-online.com</i></a></div>" );
		}
		
		$db = mysql_connect('127.0.0.1', 'web', 'sas*.0125');
		mysql_select_db('web_admin', $db);
	
		$user_array = explode('-', $usr_grps);
		foreach($user_array as $usr)
		{
			$u_g = explode(':', $usr); // seperate user & group
			$uid = $u_g[0];
			$grps = explode(',', $u_g[1]); // get groups
			
			$sql = "DELETE FROM `user_group` WHERE `user_id`=$uid";
			echo "$sql<br />";
			mysql_query($sql, $db);
			
			foreach($grps as $gid)
			{
				$sql = "INSERT INTO `user_group` (user_id, group_id) VALUES($uid, $gid)";
				echo "$sql<br />";
				mysql_query($sql, $db); 
			}
		}
		mysql_close($db);
		header("Location: user_admin.php");	
	}
?>