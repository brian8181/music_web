<?php
session_start();
include_once("./config/config.php");
include_once("./php/functions.php");
$_SESSION['RETURN_PAGE'] = $_SERVER['REQUEST_URI'];
if(!assert_login())
{
	header( "Location: ./login.php" );
	exit(); 		
}
$style = $_SESSION['USER_STYLE'];
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>My Stats</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="./favicon.png" />
	<link rel="stylesheet" type="text/css" href="<?php echo($style) ?>" />
</head>
	<body>
	<div class="text_area">
<?php 
$db = mysql_connect($db_address, $db_user_name, $db_password); 
mysql_select_db($db_name, $db);
mysql_query("SET NAMES 'utf8'");
// first get current settings from session 
$user_id = $_SESSION['USER_ID'];
$user_name = $_SESSION['USER_NAME'];
$password   = $_SESSION['USER_PASSWORD'];
$full_name  = $_SESSION['USER_FULLNAME'];
$user_email = $_SESSION['USER_EMAIL'];
$style_id  = $_SESSION['USER_STYLE_ID'];
include("./module/login_greeting.php"); 
	?> 
	<div class="box" style="text-align: center">
		<h1>
			My Stats
		</h1>
	</div>
<?php 
include("./module/top_toolbar.php"); 
	?>
	<div align="center">
	<table>
		<tr><td><strong>User:&nbsp;&nbsp;&nbsp;</strong></td><td><em><?php echo( $user_name ) ?></em></td></tr>
		<tr><td><strong>Full Name:&nbsp;&nbsp;&nbsp;</strong></td><td><em><?php echo( $full_name ) ?></em></td></tr>
		<tr><td><strong>Email:&nbsp;&nbsp;&nbsp;</strong></td><td><em><?php echo( $user_email ) ?></em></td></tr>
	<?php
		$result = mysql_query("SELECT MAX(insert_ts) FROM login WHERE `user_id`=$user_id", $db); 
		$row = mysql_fetch_row($result);
			?>
		<tr><td><strong>Last Login:&nbsp;&nbsp;&nbsp;</strong></td><td><em><?php echo( $row[0] ) ?></em></td></tr>
		<?php
		$result = mysql_query("SELECT count(*) FROM login WHERE `user_id`=$user_id", $db); 
		$row = mysql_fetch_row($result);
			?>
		<tr><td><strong>Logins:&nbsp;&nbsp;&nbsp;</strong></td><td><em><?php echo( $row[0] ) ?></em></td></tr>
		<?php
		$result = mysql_query("SELECT count(*) FROM user_cart WHERE `user_id`=1 AND removed_ts IS NULL", $db); 
		$row = mysql_fetch_row($result);
			?>
		<tr><td><strong>Cart Items:&nbsp;&nbsp;&nbsp;</strong></td><td><em><?php echo( $row[0] ) ?></em></td></tr>
		<?php
		$result = mysql_query("SELECT count(*) FROM download WHERE `user_id`=1", $db); 
		$row = mysql_fetch_row($result);
			?>
		<tr><td><strong>Downloads:&nbsp;&nbsp;&nbsp;</strong></td><td><em><?php echo( $row[0] ) ?></em></td></tr>	
	</table>
	<br />
	<center><a href="./user_download_history.php?nav_row=0"><em>see download history</em></a></center>
	</div>
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
		