<?php
include_once("./config/config.php"); 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	
	<head>
		<title>Query Page</title>
		<link rel="stylesheet" type="text/css" href="./css/<?php echo($style); ?>" />
		<link rel="stylesheet" type="text/css" href="./css/query.css" />
	</head>
	<body>
	<div class="text_area">	
<?php
$db = mysql_connect('127.0.0.1', 'web', 'sas*.0125');
mysql_select_db('music', $db);
mysql_query("SET NAMES 'utf8'");
mysql_query("INSERT INTO hitcount VALUES ( NULL, 'playlist.php', NOW() )");
		?>
	
<?php include("./module/login_greeting.php"); ?>
		<br />
		<div class="box" style="text-align: center">
		<h1><em>Playlist</em></h1>
		</div>
		<br />
<?php include("./module/limited_top_toolbar.php"); ?>
		<hr />
		
<?php
if( isset( $id ) )
{	
	$sql = "SELECT art.file, track, title, album, artist.artist, song.file, song.id FROM playlist_songs" . 
		" INNER JOIN song ON song.id = song_id" .
		" INNER JOIN album ON album.id = song.album_id" .
		" INNER JOIN artist ON artist.id = artist_id" .
		" INNER JOIN art ON song.art_id = art.id" .
		" WHERE playlist_id=$id ORDER BY `order`";
	$result = mysql_query($sql);
}
		?>
		<!-- Song Table -->
		<table class="Result" align="center">
			<!-- Column Headers-->
			<tr bgcolor="#0A6653">
				<th align="center">Cover</th>
				<th align="center"><a class="Header" href=<?php echo( "\"$url&amp;sortby=track\"" ) ?>>Track</a></th>
				<th align="center"><a class="Header" href=<?php echo( "\"$url&amp;sortby=title, track\"" ) ?>>Title</a></th>
				<th align="center"><a class="Header" href=<?php echo( "\"$url&amp;sortby=album.album, track\"" ) ?>>Album</a></th>
				<th align="center">
				<a class="Header" href=<?php echo( "\"$url&amp;sortby=artist.artist, track\"" ) ?>>Artist</a></th>
				<th align="center">Download</th>
			</tr>
<?php
echo("\n");
while ( $row = mysql_fetch_array($result, MYSQL_NUM) )
{
	echo(
			"<tr bgcolor='#BFBFBF'>\n" .
			//cover
			"\t<td align='center' bgcolor='#FFFFFF'>
				<a href=\"/query/query.php?txtSearch=$row[3]&amp;listOption=2&amp;sortby=track\">
				<img src=\"/music/.album_art/small/$row[0]\" width=\"75\" height=\"75\" alt=\"NA\"/>
				</a>
				</td>\n" .
			// track$DB = new mysql_db();
			"\t<td align='center'>$row[1]</td>\n" .
			// title
			"\t<td class='Padded' align='left'><a href=\"/query/details.php?sid=$row[6]\">$row[2]</a></td>\n" .
			// album
			"\t<td class='Padded' align='left'><a href=\"/query/query.php?txtSearch=$row[3]&amp;listOption=2&amp;sortby=track\">$row[3]</a></td>\n" .
			// artist
			"\t<td class='Padded' align='left'><a href=\"/query/query.php?txtSearch=$row[4]&amp;listOption=3\">$row[4]</a></td>\n" .
			// download link
			"\t<td align='center'><a href=\"/music$row[5]\">download</a></td>\n" .
			"</tr>\n" 
			);
}
mysql_free_result($result);
mysql_close($db);
			?>
		</table>
		<br />
		<hr>
		<!-- Navagation Bar -->
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
