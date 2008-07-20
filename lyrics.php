<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<!-- headers -->
	<head>
		<title>Song Lyrics</title>
		<meta name="generator" content="Bluefish 1.0.7"/>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="/css/main_web.css" />
	</head>
	<body>
	<div class="text_area">
		<?php include("../module/login_greeting.php"); ?>
		<br />
			<div class="box" style="text-align: center">
			<center>
				<h1><em>Song Lyrics</em></h1>
			</center>
			</div>
			<br />	
<?php
include("../module/top_toolbar.php"); 
			?>
			
			<hr />
<?php
include("../php/sql_conn.php");
$db = mysql_connect('127.0.0.1', 'web', 'sas*.0125');
mysql_select_db('music', $db);

/// get song id
$sid = isset($_GET['sid']) ? $_GET['sid'] : null;

			?>
			
			<center>
<?php
if( isset( $sid ) )
{	
	$sql = "SELECT title, lyrics from song WHERE song.id=$sid";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result, MYSQL_NUM);
	$title = $row[0];
	echo("<h2>$title</h2>");
	$lyrics = $row[1];
	$lyrics = str_replace( "\r\n", "<br />", $lyrics);
	echo( $lyrics );
	mysql_close($db);
}
			?>
			</center>
			<br />
			<hr />
<?php
include("../module/bottom_toolbar.php");
include("../module/contact_info.php");

			?>
			<br />
			<em>
			Version 1.0.0.1 Sat Sep  8 11:23:37 CDT 2007 ~( Copyright © (2007) )
			</em>
	</div>	
	</body>
</html>
