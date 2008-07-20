<?php 
//session_start();
//$_SESSION['_PAGE'] = $_SERVER['PHP_SELF'];
//include_once("../php/intialize.php" );
$db = mysql_connect('127.0.0.1', 'web', 'sas*.0125');
mysql_select_db('music', $db);
			?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Playlists</title>
		<meta name="generator" content="Bluefish 1.0.7"/>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="/css/main_web.css" />
	</head>
	<body>
	<div class="text_area">
		<center>
		<?php //include("../module/login_greeting.php"); ?>
		<br />
			<div class="box" style="text-align: center">
			<center>
				<h1><em>Playlists</em></h1>
			</center>
			</div>
			<br />	
			<?php include("../module/top_toolbar.php"); ?>
			<center>
<?php
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
include("../module/bottom_toolbar.php");
include("../module/contact_info.php");
			?>
			<br />
			<em>
			Version 1.0.0.1 Sat Sep  8 11:23:37 CDT 2007 ~( Copyright © by Brian Preston (2007) )
			</em>
		</center>
	</div>	
	</body>
</html>
