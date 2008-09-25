<?php
session_start();
include_once("./config/config.php");
include_once("./php/navbar.php");
include_once("./php/functions.php");
// init vars
$logged_in = assert_login();
$style = $logged_in ? $_SESSION['USER_STYLE'] : "./css/$style";
$album_id = isset($_GET['album_id']) ? $_GET['album_id'] : null;
// connect to mysql
$db = mysql_connect($db_address, $db_user_name, $db_password); 
mysql_select_db($db_name, $db);
mysql_query("SET NAMES 'utf8'");
// get album name
$result = mysql_query("SELECT album FROM album where id='$album_id'");
$album_name = "Album View";
if($result)
{
	$row = mysql_fetch_row($result);
	if($row)
	{
		$album_name = $row[0];
	}
}
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>Album View - <?php echo($album_name) ?></title>
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
		<h1>
			<?php echo($album_name) ?>
		</h1>
	</div>
<?php 
include("./module/top_toolbar.php"); 
		?>
		<hr />
		<br />
<?php 
$sql = get_default_query();
$sql =  "$sql WHERE album_id=$album_id ORDER BY track";
$nav_row = isset($_GET['nav_row']) ? $_GET['nav_row'] : 0;
printTable($sql, $db);
mysql_close($db);
	?>		
		<br />
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
