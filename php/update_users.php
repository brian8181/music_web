<?php
session_start();
include_once("../config/config.php");

if( !isset( $_SESSION['USER_ID'] ) )
{
	exit();
}
$groups_loc = $_SESSION['USER_GROUPS']; 
if(!array_key_exists('admin', $groups_loc))
{
	exit();
}
else
{
	$usr_grps = isset($_GET['usr_grps']) ? $_GET['usr_grps'] : null;
	//$usr_grps UID:GID[-][,GID-UID:GID...]
	if(!isset($usr_grps))
	{
		echo( "<div style=\"text-align: center\"><h3>Sorry, there was an error accessing this page.</h3></div>" );	
		echo( "<div style=\"text-align: center\"><a href=\"/index.php\"><i>www.bkp-online.com</i></a></div>" );
		exit();
	}
	
	$db = mysql_connect($db_address, $db_user_name, $db_password);
	mysql_select_db($db_name, $db);
	mysql_query("SET NAMES 'utf8'");

	$user_array = explode('-', $usr_grps);
	foreach($user_array as $usr)
	{
		$u_g = explode(':', $usr); // seperate user & group
		$uid = $u_g[0];
		$grps = explode(',', $u_g[1]); // get groups
		
		// delete current users
		$sql = "DELETE FROM `user_group` WHERE `user_id`=$uid";
		mysql_query($sql, $db);
				
		foreach($grps as $gid)
		{
			if($gid == 'delete')
			{
				$sql = "DELETE FROM `user` WHERE `id`=$uid";
				mysql_query($sql, $db);
				break;
			}
			else
			{
				$sql = "INSERT INTO `user_group` (user_id, group_id) VALUES($uid, $gid)";
				mysql_query($sql, $db);
			}
		}
	}
	mysql_close($db);
	header("Location: ../user_admin.php?updated=true");	
}

?>