<?php
session_start();
include_once("./config/config.php");
include_once("./php/functions.php");
include_once("./php/results.php");
include_once("./php/navbar.php");
include_once("./php/html_functions.php");
include_once("./module/standard_headers.php");
$uri = $_SERVER['REQUEST_URI'];
$_SESSION['_PAGE'] = $uri;
if(!assert_login())
{
	header( "Location: ./login.php" );
	exit(); 		
}
$style = assert_login() ? $_SESSION['_STYLE'] : "./css/$style";
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
$sql = build_query('my_cart');

if(isset($_GET['nav_row']))
{
	$nav_row = $_GET['nav_row'];
}
else
{
	$_GET['nav_row'] = $nav_row = 0;
}


$nav = new navbar;
$nav->numrowsperpage = 50;
$result = $nav->execute($sql, $db, "mysql");
$total = $nav->total;
$start_number = $nav->start_number;
$end_number = $nav->end_number;

			
if($result) {
	$num_rows = mysql_num_rows($result);
	echo( "<br /><br /><b>Showing $start_number - $end_number of $total</b>" );
}
?>
		
		<table id="result">		
		<tr id ="header_row">
			<?php get_result_headers($uri); ?>
		</tr>
		<?php
			
			while( $row = mysql_fetch_assoc($result) )
			{
				$sid = $row['sid'];
				open_row();
				add_data( "<img src=\"$art_location/xsmall/" . $row['art_file'] . "\" />" );
				add_data($row['track']);
				add_data($row['title']);
				add_data($row['album']);
				add_data($row['artist']);
				add_data("<a href=\"./php/download.php?sid=$sid\">download</a>");
				add_data("<a href=\"./php/delete_from_cart.php?sid=$sid\">delete</a>");
				close_row();					
			}
		?>
		</table>
<?php
	$links = $nav->getlinks("all", "on");
	/*if($links != null)
	{
		for ($y = 0; $y < count($links); $y++) {
		  echo $links[$y] . "&nbsp;&nbsp;";
		}
	}*/
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
		