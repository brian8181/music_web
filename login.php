<?php
echo("Starting Session ... <br />");
session_start();
$sid = session_id();
if( !isset( $_SESSION['_USER'] ) || !isset( $_SESSION['_GROUPS'] ) )
{
	$_user = "na";
	$_pass = "na";
	if( isset($_GET['_USER']) && isset($_GET['_PASSWORD'])) 
	{
		echo("Looking up user ... <br />");
		
		$db = mysql_connect('fire.bkp-online.com', 'web', 'sas*.0125');
		mysql_select_db('web_admin', $db);
		
		$user_t = "";
		$password_t = "";
		$user_t = $_GET['_USER'];
		$password_t = $_GET['_PASSWORD'];
		$user_t = mysql_real_escape_string($user_t);
		$password_t = mysql_real_escape_string($password_t);	
		
		$sql = "SELECT `user`, `group`, `password` FROM `user` " . 
			"INNER JOIN `user_group` ON `user`.id=`user_id` " . 
			"INNER JOIN `group` ON `user_group`.`group_id`=`group`.id " . 
			"WHERE user='$user_t' AND password='$password_t'";
		
		
		$result = mysql_query( $sql, $db );
		if( mysql_num_rows($result) )
		{
			echo("<b>User \"$user_t\" found.</b><br />");
			echo("Logging in ...<br />");
			$groups_t = array();
			while( $row = mysql_fetch_row($result) )
			{
				// store groups for user
				$grp = $row[1];
				$groups_t[$grp] = 1;	
			}
			//logged in!
			$_SESSION['_USER'] = $user_t;		
			$_SESSION['_GROUPS'] = $groups_t;
			echo("<b>User \"$user_t\" logged in.</b><br />");
			
			echo("Executing whoami ... <br />");
			//session_destroy();
			include("../tools/whoami.php");
		}
		else
		{
			//session_destroy();
			$message = "Sorry, your user and password did not match.";
			echo($message);
		}
		mysql_close();
	}
	else
	{
		$message = "<b>Invalid User/Pass paramaters.</b>";
		echo($message);
	}
}
else
{
	$user_t = $_SESSION['_USER'];
	echo("<b>User \"$user_t\" is already logged in.</b><br />");
	echo("Executing whoami ... <br />");
	include("../tools/whoami.php");
}
?>