<?php
session_start();
include_once("./config/config.php");
include_once("./php/functions.php");
include_once("./php/navbar.php");
include_once("./php/html_functions.php");
$uri = $_SERVER['REQUEST_URI'];
$_SESSION['_PAGE'] = $uri;
if(!assert_login())
{
	header( "Location: ./login.php" );
	exit(); 		
}
$uid = $_SESSION['USER_ID'];
$style = $_SESSION['USER_STYLE'];
		?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>My Cart</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="./favicon.png" />
	<link rel="stylesheet" type="text/css" href="<?php echo($style) ?>" />
</head>
	<body>
	<div class="text_area">
<?php 
$db = mysql_connect($db_address, $db_user_name, $db_password); mysql_select_db($db_name, $db);
mysql_query("SET NAMES 'utf8'");
include("./module/login_greeting.php"); 
	?> 
	<div class="box" style="text-align: center">
		<h1>
			My Cart
		</h1>
	</div>
<?php 
include("./module/top_toolbar.php"); 
	?>
	<hr />
<?php 
$sql = get_my_cart($uid);
$nav_row = isset($_GET['nav_row']) ? $_GET['nav_row'] : 0;
printTable($sql, $db);
mysql_close($db);
	?>	
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
		