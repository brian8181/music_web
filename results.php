<?php
session_start();
include_once("./config/config.php");
include_once("./php/functions.php");
include_once("./php/navbar.php");
isset( $_SESSION['_SEARCH_PAGE'] ) ? $back = $_SESSION['_SEARCH_PAGE'] : $back = "./index.php";
$_SESSION['_PAGE']  = $_SERVER['REQUEST_URI'];
$_SESSION['_QUERY'] = $_SERVER['QUERY_STRING'];
$style = assert_login() ? $_SESSION['USER_STYLE'] : "./css/$style";
		?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  	<head>
		<title>
<?php 
echo($results_title); 
		?>
		</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="<?php echo($style) ?>" />
	</head>
	<body>
	<div class="text_area">
<?php
$db = mysql_connect($db_address, $db_user_name, $db_password);
mysql_select_db($db_name, $db);
mysql_query("SET NAMES 'utf8'");

$query_type = isset($_GET['query_type']) ? $_GET['query_type'] : null;
$album      = isset($_GET['album'])      ? $_GET['album']      : null;
$artist     = isset($_GET['artist'])     ? $_GET['artist']     : null;
$title      = isset($_GET['title'])      ? $_GET['title']      : null;
$genre      = isset($_GET['genre'])      ? $_GET['genre']      : null;
$file       = isset($_GET['file'])       ? $_GET['file']       : null;
$comments   = isset($_GET['comments'])   ? $_GET['comments']   : null;
$lyrics     = isset($_GET['lyrics'])     ? $_GET['lyrics']     : null;
$and        = isset($_GET['and'])        ? $_GET['and']        : null;
$wildcard   = isset($_GET['wildcard'])   ? $_GET['wildcard']   : null;
$sortby     = isset($_GET['sortby'])     ? $_GET['sortby']     : null;
// playlist
$pid         = isset($_GET['pid'])         ? $_GET['pid']         : null;
// deprecated!! used with - case "quick_search" 
$txtSearch  = isset($_GET['txtSearch'])  ? $_GET['txtSearch']  : null;
// logging
$remote_ip = $_SERVER['REMOTE_ADDR'];
$sql = "INSERT INTO `query_log` (`query_type`, `album`, `artist`, `title`, `genre`, `file`, `comments`, `lyrics`, `and`, `wildcard`, `sortby`, `ip`) VALUES(" .
	(!empty($query_type) ? "'$query_type'" : "NULL") . ", " . 
	(!empty($album) ? "'$album'" : "NULL") . ", " . 
	(!empty($artist) ? "'$artist'" : "NULL") . ", " . 
	(!empty($title) ? "'$title'" : "NULL") . ", " . 
	(!empty($genre) ? "'$genre'" : "NULL") . ", " . 
	(!empty($file) ? "'$file'" : "NULL") . ", " . 
	(!empty($comments) ? "'$comments'" : "NULL") . ", " .
	(!empty($lyrics) ? "'$lyrics'" : "NULL") . ", " .
	(!empty($and) ? "'$and'" : "NULL") . ", " .
	(!empty($wildcard) ? "'$wildcard'" : "NULL") . ", " .
	(!empty($sortby) ? "'$sortby'" : "NULL") . ", " .
	"'$remote_ip'" . ")";
mysql_query($sql);
		?>
		
<?php 
include("./module/login_greeting.php"); 
		?>
		
	<div class="box" style="text-align: center">
		<h1>
<?php 
echo($results_title); 
		?>
		</h1>
	</div>

<?php 
include("./module/top_toolbar.php"); 
		?>
	<hr />
	<br />
	<center><a href="<?php echo($back) ?>"><b>Back To Search</b></a></center>
<?php
if( !isset( $query_type ) ) $query_type = "default";

// build the sql query
$uid = isset($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : null;
$sql = get_search(
	$artist, $album, $title, $genre, $file, $lyrics, $sortby, $and, $pid );
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
