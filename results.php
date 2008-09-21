<?php
session_start();
include_once("./config/config.php");
include_once("./php/functions.php");
include_once("./php/navbar.php");
include_once("./php/results.php");
include_once("./classes/table.php");
isset( $_SESSION['_SEARCH_PAGE'] ) ? $back = $_SESSION['_SEARCH_PAGE'] : $back = "./index.php";
$_SESSION['_PAGE']  = $_SERVER['REQUEST_URI'];
$_SESSION['_QUERY'] = $_SERVER['QUERY_STRING'];
$style = assert_login() ? $_SESSION['_STYLE'] : "./css/$style";
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
	<br />

<?php 
include("./module/top_toolbar.php"); 
		?>
	<hr />
	<br />
	<center><a href="<?php echo($back) ?>"><b>Back To Search</b></a></center>
<?php
if( !isset( $query_type ) ) $query_type = "default";

// build the sql query
$sql = build_query(
	$query_type, $artist, $album, $title, $genre, $file, $lyrics, $sortby, $and );

if( $page_result_limit > 0 ) {
	$sql = "$sql LIMIT $page_result_limit";
}
//debug
//echo("<br /><br />SQL: $sql<br /><br />");

$nav_row  = isset($_GET['nav_row'])  ? $_GET['nav_row']  : null;
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
$uri = $_SERVER['REQUEST_URI'];
			?>
		<br /><br />	
<?php
// Remove "sortby" from URI
$pos = strrpos($uri, "sortby");
if ( ! ($pos === false) ) {  
	// found...
	$len = strlen($uri);
	$len -= $pos-1;
	$uri = substr( $uri, 0, -$len );
}
	?>
	<table id="result">		
<?php
$headers = new result_headers($uri);
$headers->printOut($uri);

if($result)
{
	$authorized = !$enable_security || assert_login(); 
	echo("\n");
	while ( $row = mysql_fetch_row($result) )
	{
		$sid = $row[6];
		// process the row...
		echo(
				"<tr id=\"table_row\">\n" .
				//cover
				"\t<td id=\"art_col\">
					<a class=\"NoColor\" href=\"./results.php?album=$row[3]&artist=$row[4]&amp;sortby=track\">
					<img src=\"$art_location/xsmall/$row[0]\" width=\"50\" height=\"50\" alt=\"NA\"/>
					</a>
					</td>\n" .
				// track
				"\t<td align='center'>$row[1]</td>\n" .
				// title
				"\t<td class='Padded' align='left'>
					<a href=\"details.php?sid=$sid\">$row[2]</a>
					</td>\n" .
				// album
				"\t<td class='Padded' align='left'>
					<a href=\"results.php?album=$row[3]&amp;sortby=track\">$row[3]</a>
					</td>\n" .
				// artist
				"\t<td class='Padded' align='left'>
					<a href=\"results.php?artist=$row[4]&amp;sortby=album.album,track\">$row[4]</a>
					</td>\n"  );
		// download link			
		if( $authorized )
		{
			if($enable_direct_download)
			{
				echo( "\t<td align='center'>
							<a href=\"$music_location$row[5]\">download</a>
						</td>\n" );
			}
			else
			{
				echo( "\t<td align='center'>
							<a href=\"./php/download.php?sid=$sid\">download</a>
						</td>\n" );
			}
			echo( "\t<td align='center'>
							<a href=\"./php/add_to_cart.php?sid=$sid\">add to cart</a>
						</td>\n" );
		}
		else
		{
			echo( "\t<td align='center'><i>NA</i></td>\n" );
			echo( "\t<td align='center'><i>NA</i></td>\n" );	
		}
		echo("</tr>\n");
	}
}
//mysql_close($db);
		?>
	</table>	
	
	<br /><br />
	<center>
<?php

	$links = $nav->getlinks("all", "on");
	if($links != null)
	{
		for ($y = 0; $y < count($links); $y++) {
		  echo $links[$y] . "&nbsp;&nbsp;";
		}
	}

	?>
	<br />
	<br />	
	<hr />
	</center>
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
