<?php
session_start();
include_once("./config/config.php");
include_once("./php/functions.php");
include_once("./php/navbar.php");
$uri = $_SERVER['REQUEST_URI'];
$style = assert_login() ? $_SESSION['USER_STYLE'] : "./css/$style";
$pid = isset($_GET['pid']) ? $_GET['pid'] : null;

$db = mysql_connect($db_address, $db_user_name, $db_password); mysql_select_db($db_name, $db);
mysql_query("SET NAMES 'utf8'");
$result = mysql_query("SELECT name FROM playlists where id='$pid'");
$playlist_name = "Playlist View";
if($result)
{
	$row = mysql_fetch_row($result);
	if($row)
	{
		$playlist_name = $row[0];
	}
}
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>Playlist View - <?php echo($playlist_name) ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="./favicon.png" />
	<link rel="stylesheet" type="text/css" href="<?php echo($style); ?>" />
</head>
	<body>
	<div class="text_area">
<?php 
include("./module/login_greeting.php"); 
	?> 
	<div class="box" style="text-align: center">
		<h1><?php echo($playlist_name) ?></h1>
	</div>
<?php 
include("./module/top_toolbar.php"); 

$sql = get_playlist($pid);
$nav_row = isset($_GET['nav_row']) ? $_GET['nav_row'] : 0;
printTable($sql, $db);
mysql_close($db);

include("./module/footer.php");
	?>
	</div>	
	</body>
</html>
