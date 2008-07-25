<?php
session_start(); 
if( isset($_SESSION['user']) && isset($_SESSION['groups']) )
{
	$_groups = array();
	$_groups = $_SESSION['groups']; 
	if(!array_key_exists('user', $_groups))
	{
		echo( "<div style=\"text-align: center\"><h3>Sorry, your are not authorized to access the page.</h3></div>" );	
		echo( "<div style=\"text-align: center\"><a href=\"/index.php\"><i>$server_address</i></a></div>" );
		exit();
	}
	
}
else
{
	$_SESSION['page'] = $_SERVER['PHP_SELF'];
	header( "Location: login.php" );
	exit();
}
?>