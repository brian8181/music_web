<?php
include_once("./php/sec_user.php");
//include_once("./php/validate_login.php");
include_once("./config/config.php");
			    ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>Music Statistics</title>
    <meta name="generator" content="Bluefish 1.0.7"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="./css/<?php echo($style); ?>" />
  </head>
  <body>
	<div class="text_area">
		<?php include("./module/login_greeting.php"); ?>
		<div class="box" style="text-align: center">
			<h1>
			  <em>Music Statistics</em>
			</h1>
		</div>

		<br />
<!--        toolbar              -->
<?php 
include("./module/top_toolbar.php"); 
		?>
		
		<br />
		<br />
		<span style="font-size: larger;">
			<div align="center">
			
<?php
$db = mysql_connect($db_address, $db_user_name, $db_password);
mysql_select_db('music', $db);

$result = mysql_query('SELECT count(*) FROM song', $db); 
$row = mysql_fetch_row($result);
echo("<strong>Total Songs: <em>$row[0]</em></strong><br />");

$result = mysql_query('SELECT count(*) FROM artist', $db); 
$row = mysql_fetch_row($result);
echo("<strong>Total Artists: <em>$row[0]</em></strong><br />");

$result = mysql_query('SELECT count(*) FROM album', $db); 
$row = mysql_fetch_row($result);
echo("<strong>Total Albums: <em>$row[0]</em></strong><br />");

$result = mysql_query('SELECT count(*) FROM art', $db); 
$row = mysql_fetch_row($result);
echo("<strong>Total Art: <em>$row[0]</em></strong><br />");

$result = mysql_query("SELECT count(*) FROM song WHERE NOT lyrics IS NULL", $db); 
$row = mysql_fetch_row($result);
echo("<strong>Total Lyrics: <em>$row[0]</em></strong><br />");

$result = mysql_query("SELECT count(*) FROM song WHERE file like '%.mp3'", $db); 
$row = mysql_fetch_row($result);
echo("<strong>MP3: <em>$row[0]</em></strong><br />");

$result = mysql_query("SELECT count(*) FROM song WHERE file like '%.wma'", $db); 
$row = mysql_fetch_row($result);
echo("<strong>WMA: <em>$row[0]</em></strong><br />");

$result = mysql_query("SELECT count(*) FROM song WHERE file like '%.ogg'", $db); 
$row = mysql_fetch_row($result);
echo("<strong>OGG: <em>$row[0]</em></strong><br />");

$result = mysql_query("SELECT count(*) FROM song WHERE file like '%.flac'", $db); 
$row = mysql_fetch_row($result);
echo("<strong>FLAC: <em>$row[0]</em></strong><br />");
			?>
				
				<br />
				<hr />
		
<?php
$result = mysql_query("SELECT count(*) FROM artist LEFT JOIN song ON artist.id=artist_id WHERE artist_id IS NULL", $db); 
$row = mysql_fetch_row($result);
echo("<strong>Orphaned Artists: <em>$row[0]</em></strong><br />");

$result = mysql_query("SELECT count(*) FROM album LEFT JOIN song ON album.id=album_id WHERE album_id IS NULL", $db); 
$row = mysql_fetch_row($result);
echo("<strong>Orphaned Albums: <em>$row[0]</em></strong><br />");

$result = mysql_query("SELECT count(*) FROM song where  artist_id is null;", $db); 
$row = mysql_fetch_row($result);
echo("<strong>Null Artist: <em>$row[0]</em></strong><br />");

$result = mysql_query("SELECT count(*) FROM song where  album_id is null;", $db); 
$row = mysql_fetch_row($result);
echo("<strong>Null Album: <em>$row[0]</em></strong><br />");

$result = mysql_query("SELECT count(*) FROM song where art_id is null;", $db); 
$row = mysql_fetch_row($result);
echo("<strong>Null Art: <em>$row[0]</em></strong><br />");

$result = mysql_query("SELECT DISTINCT update_ts FROM song ORDER BY update_ts DESC LIMIT 2", $db); 
$row = mysql_fetch_row($result);
echo("<strong>Last Update: <em>$row[0]</em></strong><br />");
        ?>
		
				<br />
				<hr />
		
<?php
$result = mysql_query("SELECT count(*) FROM music.query_log", $db); 
$row = mysql_fetch_row($result);
echo("<strong>Total DB Queries: <em>$row[0]</em></strong><br />");

$result = mysql_query("USE web_admin", $db); 
$result = mysql_query("SELECT count(*) from user;", $db);
$row = mysql_fetch_row($result);
echo("<strong>Total Users: <em>$row[0]</em></strong><br />");

mysql_close($db);
			?>
			
 			</div>
		</span>
	<br />
	<br />
	
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
