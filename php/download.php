<?php
session_start();
include_once("../config/config.php");
include_once("../php/functions.php");
$sid = isset($_GET['sid']) ? $_GET['sid'] : null;

$db = mysql_connect($db_address, $db_user_name, $db_password);
mysql_select_db($db_name, $db);
mysql_query("SET NAMES 'utf8'");

$sql = "SELECT `file` FROM song WHERE id='$sid'";
$result = mysql_query($sql);

if(mysql_num_rows($result) == 1)
{
	
	$row = mysql_fetch_array($result, MYSQL_NUM);
	$path = $row[0];
	$file = basename($path);
	
	$uid = $_SESSION['USER_ID'];
	mysql_query("INSERT INTO download (user_id, song_id) VALUES( $uid, $sid )", $db);
	// remove from cart
	delete_from_cart($uid, $sid, $db);
	mysql_close($db); 
	

	if($enable_direct_download)
	{
		header( "Location: ../../music$path" ); 	
	}
	else
	{
		HttpResponse::setCache(true);
		HttpResponse::setContentType("audio/mpeg3");
		HttpResponse::setContentDisposition("$file", false);
		HttpResponse::setFile("../../music$path");
		HttpResponse::send();
	}
}

?>