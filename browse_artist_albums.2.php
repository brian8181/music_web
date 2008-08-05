<?php
include_once("./config/config.php");
		?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<!-- headers -->
	<head>
		<title>Artist Albums</title>
		<meta name="generator" content="Bluefish 1.0.7"/>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		 <link rel="stylesheet" type="text/css" href="./css/<?php echo($style); ?>" />
	</head>
	<body>
		<div class="text_area">
		
<?php 
include("./module/login_greeting.php"); 
		?>
		<br />
			<div class="box">
				<h1><em>Artist Albums</em></h1>
			</div>
		<br />	
		
<?php 
include("./module/top_toolbar.php"); 
		?>
			
<?php

$aid   = isset($_GET['aid'])    ? $_GET['aid'] : null;
$filter = isset($_GET['filter']) ? $_GET['filter']: null;

if(isset($aid))
{
	$db = mysql_connect($db_address, $db_user_name, $db_password);
	mysql_select_db($db_name, $db);
	mysql_query("SET NAMES 'utf8'");
	
	if(isset($filter) && strlen($filter) > 0)
	{
		$filter = mysql_real_escape_string( $filter );
		$filter = "AND song.file LIKE '/$filter/%'";
	}
	else
	{
		$filter = "";
	}
	$sql = "SELECT DISTINCT album, art.file, album_id FROM song " . 
		"INNER JOIN album ON album_id=album.id " .
		"INNER JOIN artist ON artist_id=artist.id " . 
		"LEFT JOIN art ON art_id=art.id WHERE artist_id='$aid' $filter";
	//echo($sql);			
	$result = mysql_query($sql, $db);
	$row = mysql_fetch_row($result);
	echo("<div align=\"center\"><h3>$row[3]</h3></div>");
}
	?>

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