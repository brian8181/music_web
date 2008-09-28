<?php
session_start();
include_once("./config/config.php");
include_once("./php/functions.php");
include_once("./php/navbar.php");
isset( $_SESSION['_SEARCH_PAGE'] ) ? $back = $_SESSION['_SEARCH_PAGE'] : $back = "./query.php";
$_SESSION['RETURN_PAGE']  = $_SERVER['REQUEST_URI'];
$_SESSION['_QUERY'] = $_SERVER['QUERY_STRING'];
$style = assert_login() ? $_SESSION['USER_STYLE'] : "./css/$style";
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title><?php echo($results_title); ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="<?php echo($style) ?>" />
</head>
<body>
<div class="text_area">
<?php
$db = mysql_connect($db_address, $db_user_name, $db_password);
mysql_select_db($db_name, $db);
mysql_query("SET NAMES 'utf8'");
$album      = isset($_GET['album'])      ? $_GET['album']      : null;
$artist     = isset($_GET['artist'])     ? $_GET['artist']     : null;
$title      = isset($_GET['title'])      ? $_GET['title']      : null;
$genre      = isset($_GET['genre'])      ? $_GET['genre']      : null;
$file       = isset($_GET['file'])       ? $_GET['file']       : null;
$comments   = isset($_GET['comments'])   ? $_GET['comments']   : null;
$lyrics     = isset($_GET['lyrics'])     ? $_GET['lyrics']     : null;
$and        = isset($_GET['and'])        ? $_GET['and']        : null;
$wildcard   = isset($_GET['wildcard'])   ? $_GET['wildcard']   : null;
$order_by   = isset($_GET['order_by'])   ? $_GET['order_by']     : $default_order;
$order_dir  = isset($_GET['order_dir'])  ? $_GET['order_dir'] : $default_order_direction;
$clicked  = isset($_GET['clicked']) ? $_GET['clicked'] : null;
$pid        = isset($_GET['pid'])         ? $_GET['pid']         : null;
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
<center><a href="<?php echo($back) ?>"><b>Back To Search</b></a></center>
<?php

// build the sql query
$uid = isset($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : null;
// get order by 
$order_by = get_sort_order($order_by, $order_dir, $clicked);

$sql = get_search(
$artist, $album, $title, $genre, $file, $lyrics, $order_by, $and, $order_dir );
$nav_row = isset($_GET['nav_row']) ? $_GET['nav_row'] : 0;
printTable($sql, $db);
mysql_close($db);

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
