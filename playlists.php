<?php 
include_once("./config/config.php");
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
		<br />
			<div class="box" style="text-align: center">
			<center>
				<h1><em>Playlists</em></h1>
			</center>
			</div>
			<br />	
<?php include("./module/top_toolbar.php"); ?>
			<hr />
			<center>
<?php
$db = $db = mysql_connect($db_address, $db_user_name, $db_password);
mysql_select_db('music', $db);

$sql = "SELECT id, name from playlists ORDER BY name";
$result = mysql_query($sql);
while ( $row = mysql_fetch_array($result, MYSQL_NUM) )
{
	$id = $row[0];
	echo( "<a href=\"./results.php?query_type=playlist&id=$id\">$row[1]</a><br />" );
}
mysql_close($db);
			?>
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
