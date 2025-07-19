<?php
session_start();
include_once("./config/config.php");
include_once("./php/functions.php");
$style = assert_login() ? $_SESSION['USER_STYLE'] : "./css/$style";
			    ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>Music Statistics</title>
    <meta name="generator" content="Bluefish 1.0.7"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="<?php echo($style) ?>" />
  </head>
  <body>
	<div class="text_area">
		<?php include("./module/login_greeting.php"); ?>
		<div class="box" style="text-align: center">
			<h1>
			  Music Statistics
			</h1>
		</div>
<?php 
include("./module/top_toolbar.php"); 
		?>
<div align="center">
<table>
     		
<?php
$db = mysql_connect($db_address, $db_user_name, $db_password);
mysql_select_db('music', $db);

$result = mysql_query('SELECT count(*) FROM song', $db); 
$row = mysql_fetch_row($result);
	?>
	<tr><td><strong>Total Songs:&nbsp;&nbsp;&nbsp;</strong></td><td><em><?php echo( $row[0] ) ?></em></td></tr>
<?php
$result = mysql_query('SELECT count(*) FROM artist', $db); 
$row = mysql_fetch_row($result);
	?>
	<tr><td><strong>Total Artists:&nbsp;&nbsp;&nbsp;</strong></td><td><em><?php echo( $row[0] ) ?></em></td></tr>
<?php
$result = mysql_query('SELECT count(*) FROM album', $db); 
$row = mysql_fetch_row($result);
	?>
	<tr><td><strong>Total Albums:&nbsp;&nbsp;&nbsp;</strong></td><td><em><?php echo( $row[0] ) ?></em></td></tr>
<?php
$result = mysql_query('SELECT count(*) FROM art', $db); 
$row = mysql_fetch_row($result);
	?>
	<tr><td><strong>Total Art:&nbsp;&nbsp;&nbsp;</strong></td><td><em><?php echo( $row[0] ) ?></em></td></tr>
<?php
$result = mysql_query("SELECT count(*) FROM song WHERE NOT lyrics IS NULL", $db); 
$row = mysql_fetch_row($result);
	?>	
	<tr><td><strong>Total Lyrics:&nbsp;&nbsp;&nbsp;</strong></td><td><em><?php echo( $row[0] ) ?></em></td></tr>
<?php 
$result = mysql_query("SELECT count(*) FROM song WHERE file like '%.mp3'", $db); 
$row = mysql_fetch_row($result);
	?>
	<tr><td><strong>MP3:&nbsp;&nbsp;&nbsp;</strong></td><td><em><?php echo( $row[0] ) ?></em></td></tr>
<?php 
$result = mysql_query("SELECT count(*) FROM song WHERE file like '%.wma'", $db); 
$row = mysql_fetch_row($result);
	?>
	<tr><td><strong>WMA:&nbsp;&nbsp;&nbsp;</strong></td><td><em><?php echo( $row[0] ) ?></em></td></tr>
<?php
$result = mysql_query("SELECT count(*) FROM song WHERE file like '%.ogg'", $db); 
$row = mysql_fetch_row($result);
	?>
	<tr><td><strong>OGG:&nbsp;&nbsp;&nbsp;</strong></td><td><em><?php echo( $row[0] ) ?></em></td></tr>
<?php
$result = mysql_query("SELECT count(*) FROM song WHERE file like '%.flac'", $db); 
$row = mysql_fetch_row($result);
	?>
	<tr><td><strong>FLAC:&nbsp;&nbsp;&nbsp;</strong></td><td><em><?php echo( $row[0] ) ?></em></td></tr>

<tr><td>&nbsp;</td><td>&nbsp;</td></tr>

<?php
$result = mysql_query("SELECT count(*) FROM artist LEFT JOIN song ON artist.id=artist_id WHERE artist_id IS NULL", $db); 
$row = mysql_fetch_row($result);
	?>
	<tr><td><strong>Orphaned Artists:&nbsp;&nbsp;&nbsp;</strong></td><td><em><?php echo( $row[0] ) ?></em></td></tr>
<?php 
$result = mysql_query("SELECT count(*) FROM album LEFT JOIN song ON album.id=album_id WHERE album_id IS NULL", $db); 
$row = mysql_fetch_row($result);
?>	
	<tr><td><strong>Orphaned Albums:&nbsp;&nbsp;&nbsp;</strong></td><td><em><?php echo( $row[0] ) ?></em></td></tr>
<?php
$result = mysql_query("SELECT count(*) FROM song where  artist_id is null;", $db); 
$row = mysql_fetch_row($result);
	?>
	<tr><td><strong>Null Artist:&nbsp;&nbsp;&nbsp;</strong></td><td><em><?php echo( $row[0] ) ?></em></td></tr>
<?php
$result = mysql_query("SELECT count(*) FROM song where  album_id is null;", $db); 
$row = mysql_fetch_row($result);
?>
	<tr><td><strong>Null Album:&nbsp;&nbsp;&nbsp;</strong></td><td><em><?php echo( $row[0] ) ?></em></td></tr>
<?php
$result = mysql_query("SELECT count(*) FROM song where art_id is null;", $db); 
$row = mysql_fetch_row($result);
?>
	<tr><td><strong>Null Art:&nbsp;&nbsp;&nbsp;</strong></td><td><em><?php echo( $row[0] ) ?></em></td></tr>
	
	<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
	
<?php
$result = mysql_query("SELECT DISTINCT update_ts FROM song ORDER BY update_ts DESC LIMIT 2", $db); 
$row = mysql_fetch_row($result);
?>
	<tr><td><strong>Last Update:&nbsp;&nbsp;&nbsp;</strong></td><td><em><?php echo( $row[0] ) ?></em></td></tr>
<?php
$result = mysql_query("SELECT count(*) FROM music.query_log", $db); 
$row = mysql_fetch_row($result);
?>
<tr><td><strong>Total DB Queries:&nbsp;&nbsp;&nbsp;</strong></td><td><em><?php echo( $row[0] ) ?></em></td></tr>
<?php
$result = mysql_query("USE web_admin", $db); 
$result = mysql_query("SELECT count(*) from user;", $db);
$row = mysql_fetch_row($result);
 ?>
<tr><td><strong>Total Users:&nbsp;&nbsp;&nbsp;</strong></td><td><em><?php echo( $row[0] ) ?></em></td></tr>
</table>

</div>

<?php
mysql_close($db);
include("./module/footer.php");
	?>
  </div>
  </body>
</html>
