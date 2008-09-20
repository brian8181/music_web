<?php
session_start();
include_once("./config/config.php");
include_once("./php/functions.php");
$_SESSION['_PAGE'] = $_SERVER['REQUEST_URI'];
			?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Playlists</title>
		<meta name="generator" content="Bluefish 1.0.7"/>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="./css/<?php echo($style); ?>" />
	</head>
	<body>
	<div class="text_area">
<?php include("./module/login_greeting.php"); ?>
			<div class="box" style="text-align: center">
			<center>
				<h1>Playlists</h1>
			</center>
			</div>
			<br />	
<?php include("./module/top_toolbar.php"); ?>
			<hr />
			<center>
<?php
$db = $db = mysql_connect($db_address, $db_user_name, $db_password);
mysql_select_db($db_name, $db);

$sql = "SELECT id, name from playlists ORDER BY name";
$result = mysql_query($sql);
?>
	<!-- move formating to css -->
	<table>
	<tr>
		<th align="left">Name</th>
		<th align="left">Count</th>
	</tr>
<?php 
while ( $row = mysql_fetch_array($result, MYSQL_NUM) )
{
	echo("<tr>");
	$id = $row[0];
	$name = $row[1];
	$sql = "SELECT count(*) FROM playlist_songs WHERE playlist_id=$id";
	$count_result = mysql_query($sql);
	$count_row = mysql_fetch_array($count_result, MYSQL_NUM);
	$count = $count_row[0]; 
	echo( "<td><a href=\"./results.php?query_type=playlist&pid=$id\">$name</a><br /></td>" );
	echo( "<td><em>$count</em></td>" );
	echo("</tr>");
}
mysql_close($db);
			?>
	</table>			
			</center>
			<hr />
<?php
include("./module/bottom_toolbar.php");
include("./module/contact_info.php");
			?>
		<br />
<?php
include("./module/version.php");
			?>
		</div>	
	</body>
</html>
