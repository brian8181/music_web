<?php
include_once("../php/sec_user.php");
//include_once("../php/validate_login.php");
include_once("./config/config.php");
		?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  	<head>
		<title>Your Query Results</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="./css/<?php echo($style); ?>" />
		<link rel="stylesheet" type="text/css" href="./css/query.css" />
	</head>
	<body>
	<div class="text_area">
  
<?php
$db = mysql_connect($db_address, $db_user_name, $db_password); mysql_select_db($db_name, $db);
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
// palylist id
$id         = isset($_GET['id'])         ? $_GET['id']         : null;
// deprecated!! used with - case "quick_search" 
$txtSearch  = isset($_GET['txtSearch'])  ? $_GET['txtSearch']  : null;
  
mysql_query("SET NAMES 'utf8'");
$sql = "INSERT INTO `query3` (`query_type`, `album`, `artist`, `title`, `genre`, `file`, `comments`, `lyrics`, `and`, `wildcard`, `sortby`) VALUES(" .
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
	(!empty($sortby) ? "'$sortby'" : "NULL") . ")";
mysql_query($sql);
		?>
		
	<?php include("./module/login_greeting.php"); ?>
	<br />
	<!-- Display Title -->
	<div class="box" style="text-align: center">
		<h1>
			<em>Your Query Results</em>
		</h1>
	</div>
	<br />
	<?php include("./module/top_toolbar.php"); ?>
	<img src="./image/apache_pb.gif" align="right" width="259" height="32" alt="Apache" />
	<hr />
<?php
if( !isset( $query_type ) ) $query_type = "default";
$sql = "";
// todo: change to stored procecudres (requires use of "MYSQLI") 
switch( $query_type )
{
	case "all_lyrics":
		$sql = "SELECT art.file, track, title, album, artist.artist, song.file, song.id FROM song " .
			"LEFT JOIN artist ON artist.id = song.artist_id " .
			"LEFT JOIN album ON album.id = song.album_id " .
			"LEFT JOIN art ON song.art_id = art.id WHERE NOT lyrics IS NULL";
		break;	
	case "playlist":
		if( !isset($id) )
			break;
		$sql = "SELECT art.file, track, title, album, artist.artist, song.file, song.id FROM song " . 
			"LEFT JOIN playlist_songs ON song.id = song_id " .
			"LEFT JOIN album ON album.id = song.album_id " .
			"LEFT JOIN artist ON artist.id = artist_id " .
			"LEFT JOIN art ON song.art_id = art.id " .
			"WHERE playlist_id=$id ORDER BY `order`";
		break;
	case "album":
		$sql = "SELECT art.file, track, title, album, artist.artist, song.file, song.id FROM song " .
			"LEFT JOIN artist ON artist.id = song.artist_id " .
			"LEFT JOIN album ON album.id = song.album_id " .
			"LEFT JOIN art ON song.art_id = art.id WHERE album_id=$album_id ORDER BY track";
		break;		
	case "quick_search": //deprecated
		if( !isset($txtSearch) )
			break;
		$album = $txtSearch;
		$artist = $txtSearch;
		$title = $txtSearch;
	// FALL THROUGH!
	default:
		{
			// check for wildcards & strip escape characters
			if(isset($wildcard) && $wildcard == "on")
			{
				$album = str_replace( "*", "%", $album);
				$album = str_replace( "?", "_", $album);
				$artist = str_replace( "*", "%", $artist);
				$artist = str_replace( "?", "_", $artist);
				$title = str_replace( "*", "%", $title);
				$title = str_replace( "?", "_", $title);
				$genre = str_replace( "*", "%", $genre);
				$genre = str_replace( "?", "_", $genre);
				$file = str_replace( "*", "%", $file);
				$file = str_replace( "?", "_", $file);
			}
			else
			{
				$album = !empty( $album ) ? "%$album%" : "";
				$artist = !empty( $artist ) ? "%$artist%" : "";
				$title = !empty( $title ) ? "%$title%" : "";
				$genre = !empty( $genre ) ? "%$genre%" : "";
				$file = !empty( $file ) ? "%$file%" : "";
			}
			$album = mysql_real_escape_string( $album );
			$artist = mysql_real_escape_string( $artist );
			$title = mysql_real_escape_string( $title );
			$genre = mysql_real_escape_string( $genre );
			$file = mysql_real_escape_string( $file );
			// Build SQL
			$sql = "SELECT art.file, track, title, album, artist.artist, song.file, song.id FROM song " .
				"LEFT JOIN artist ON artist.id = song.artist_id " .
				"LEFT JOIN album ON album.id = song.album_id " .
				"LEFT JOIN art ON song.art_id = art.id";
			$operator = '';
			$sql = "$sql WHERE";
			if( !empty( $artist ) )
			{
				$sql = "$sql (`artist`.`artist` LIKE '$artist')";
				$operator = isset($and) && ($and == "false") ? "OR" : "AND";
			}
							if( !empty( $album ) )
			{
				$sql = "$sql $operator (`album`.`album` LIKE '$album')";
				$operator = isset($and) && ($and == "false") ? "OR" : "AND";
			}
			if( !empty( $title ) )
			{
				$sql = "$sql $operator (`song`.`title` LIKE '$title')";
				$operator = isset($and) && ($and == "false") ? "OR" : "AND";
			}
			if( !empty( $genre ) )
			{
				$sql = "$sql $operator (`song`.`genre` LIKE '$genre')";
				$operator = isset($and) && ($and == "false") ? "OR" : "AND";
			}
			if( !empty( $file ) )
			{
				$sql = "$sql $operator (`song`.`file` LIKE '$file')";
			}
			if( !empty( $sortby ) )
				$sql = "$sql ORDER BY $sortby";
		}
		break;
}
$sql = "$sql";

//debug
//echo("<br /><br />SQL: $sql<br /><br />");

// including the navbar class
include("./php/browse_functions.php");
$nav = new navbar;
$nav->numrowsperpage = 100;
$result = $nav->execute($sql, $db, "mysql");
$num_rows = mysql_num_rows($result);
$result = mysql_query($sql, $db);
if($result)
{
	$num_rows = mysql_num_rows($result);
	//echo( "<br /><br /><b>$numtoshow / $total_records</b>" . " results found." );
	echo( "<br /><br /><b>$num_rows</b>" . " results found." );
}
//log the query
$uri = $_SERVER['REQUEST_URI'];
//$ip = $_SERVER['REMOTE_ADDR'];
//$self = $_SERVER['PHP_SELF']
//$query_string = $_SERVER['QUERY_STRING']
			?>
				
		<!-- Results table -->			
		<table class="Result" align="center">
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
		<tr bgcolor="#0A6653">
		<th align="center">Cover</th>
		<th align="center"><a class="Header" href=<?php echo( "\"$uri&amp;sortby=track\"" ) ?>>Track</a></th>
		<th align="center"><a class="Header" href=<?php echo( "\"$uri&amp;sortby=title\"" ) ?>>Title</a></th>
		<th align="center"><a class="Header" href=<?php echo( "\"$uri&amp;sortby=album.album,track\"" ) ?>>Album</a></th>
		<th align="center">
		<a class="Header" href=<?php echo( "\"$uri&amp;sortby=artist.artist\"" ) ?>>Artist</a></th>
		<th align="center">Download</th>
		</tr>

<?php
if($result)
{
	echo("\n");
	while ( $record = mysql_fetch_row($result) )
	{
		// process the row...
		echo(
				"<tr bgcolor='#BFBFBF'>\n" .
				//cover
				"\t<td align='center' bgcolor='#FFFFFF'>
					<a class=\"Logo\" href=\"/query/results.php?album=$record[3]&artist=$record[4]&amp;sortby=track\">
					<img src=\"$art_location/xsmall/$record[0]\" width=\"50\" height=\"50\" alt=\"NA\"/>
					</a>
					</td>\n" .
				// track
				"\t<td align='center'>$record[1]</td>\n" .
				// title
				"\t<td class='Padded' align='left'>
					<a href=\"details.php?sid=$record[6]\">$record[2]</a>
					</td>\n" .
				// album
				"\t<td class='Padded' align='left'>
					<a href=\"results.php?album=$record[3]&amp;sortby=track\">$record[3]</a>
					</td>\n" .
				// artist
				"\t<td class='Padded' align='left'>
					<a href=\"results.php?artist=$record[4]&amp;sortby=album.album,track\">$record[4]</a>
					</td>\n" .
				// download link
				"\t<td align='center'>
					<a href=\"$music_location$record[5]\">download</a>
					</td>\n" .
				"</tr>\n" 
				);
	}
	// free results, this doesn't hurt
	mysql_free_result($result);
}
mysql_close($db);
			?>
		</table>
	
	<center>
	<table>
		<tr>
			<td align="center">	
			</td>
		</tr>
	</table>
	</center>
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
	<body>
</html>
