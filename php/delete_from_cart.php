<?php
session_start();
include_once("../config/config.php");
include_once("../php/functions.php");
include_once("../php/results.php");
if( assert_login() )
{ 
	$db = mysql_connect($db_address, $db_user_name, $db_password);
	mysql_select_db($db_name, $db);
	
	$uid = $_SESSION['_USER_ID'];
	if( isset($_GET['sid']) )
	{
		delete_from_cart($uid, $_GET['sid'], $db);
		if( isset( $_SESSION['_PAGE'] ) )
		{
			$page = $_SESSION['_PAGE'];
			header( "Location: $page" ); 
		} 
		else 
		{
			header( "Location: ./index.php" ); 
		} 
	}
}
?>