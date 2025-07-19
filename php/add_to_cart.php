<?php
session_start();
include_once("../config/config.php");
include_once("../php/functions.php");
if( assert_login() )
{ 
	$db = mysql_connect($db_address, $db_user_name, $db_password);
	mysql_select_db($db_name, $db);
	
	$uid = $_SESSION['USER_ID'];
	if( isset($_GET['sid']) )
	{
		add_2_cart($uid, $_GET['sid'], $db);
		if( isset( $_SESSION['RETURN_PAGE'] ) )
		{
			$page = $_SESSION['RETURN_PAGE'];
			header( "Location: $page" ); 
		} 
		else 
		{
			header( "Location: ./index.php" ); 
		} 
	}
}
?>