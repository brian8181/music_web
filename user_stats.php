<?php
session_start();
include_once("./config/config.php");
include_once("./php/functions.php");
include_once("./php/results.php");
$_SESSION['_PAGE'] = $_SERVER['REQUEST_URI'];
if(!assert_login())
{
	header( "Location: ./login.php" );
	exit(); 		
}
$style = assert_login() ? $_SESSION['USER_STYLE'] : "./css/$style";
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
$user_id = $_SESSION['_USER_ID'];

include("./module/login_greeting.php"); 
                ?> 

	<div class="box" style="text-align: center">
		<h1>
			My Stats
		</h1>
	</div>
	<hr />
	<div align="center">
<?php 
include("./module/top_toolbar.php"); 
?>
<br />
		<table>
		<?php
			$result = mysql_query("SELECT MAX(insert_ts) FROM login WHERE `user_id`=$user_id", $db); 
			$row = mysql_fetch_row($result);
				?>
			<tr><td><strong>Last Login:&nbsp;&nbsp;&nbsp;</strong></td><td><em><?php echo( $row[0] ) ?></em></td></tr>
			<?php
			$result = mysql_query("SELECT count(*) FROM login WHERE `user_id`=$user_id", $db); 
			$row = mysql_fetch_row($result);
				?>
				<tr><td><strong>Login Count:&nbsp;&nbsp;&nbsp;</strong></td><td><em><?php echo( $row[0] ) ?></em></td></tr>
			<?php
			$result = mysql_query("SELECT count(*) FROM user_cart WHERE `user_id`=1", $db); 
			$row = mysql_fetch_row($result);
				?>
				<tr><td><strong>Basket Count:&nbsp;&nbsp;&nbsp;</strong></td><td><em><?php echo( $row[0] ) ?></em></td></tr>
			<?php
			$result = mysql_query("SELECT count(*) FROM download WHERE `user_id`=1", $db); 
			$row = mysql_fetch_row($result);
				?>
				<tr><td><strong>Download Count:&nbsp;&nbsp;&nbsp;</strong></td><td><em><?php echo( $row[0] ) ?></em></td></tr>	
		</table>
		<br />
		<center><a href="./user_download_history.php?nav_row=0">See download history</a></center>
		<hr />
<?php
include("./module/bottom_toolbar.php");
include("./module/contact_info.php");
			?>
		</div>
		<br />

<?php
include("./module/version.php");
			    ?>
	</div>	
	</body>
</html>
		