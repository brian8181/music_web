<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>Details</title>
    <meta name="generator" content="Bluefish 1.0.7" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="/css/main_web.css" />
</head>
<body>
	<div class="text_area">
<?php
$db = mysql_connect('127.0.0.1', 'web', 'sas*.0125');
mysql_select_db('music', $db);
mysql_query("SET NAMES 'utf8'");

$sid = isset($_GET['sid']) ? $_GET['sid'] : null;
        ?>
			<script type="text/php" language="php">  
		    //include("../module/login_greeting.php");
		</script>
		<br />
			<div class="box" style="text-align: center">
				<h1><em>Songs Details</em></h1>
			</div>
			<br />			

<?php
include("../module/top_toolbar.php"); 
$sql = "SELECT track, title, album.album, artist.artist, genre, bitrate," .
		"length, file_size, year, encoder, song.file, comments, art.file, lyrics FROM song " .
		"INNER JOIN artist ON artist.id = song.artist_id " .
		"INNER JOIN album ON album.id = song.album_id " . 
		"INNER JOIN art ON song.art_id = art.id " . 
		"WHERE song.id='$sid'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result, MYSQL_NUM);
	//$helper = new Helper();
			?>
			
			<hr>
            <table class="Main"><tr>
			<td  class="Padded">
			<h2>Song Details:</h2>
			<ul>
				<li><strong>Track:</strong>&nbsp;<em> <?php echo( $row[0] ); ?></em></li>
				<li><strong>Title:</strong>&nbsp;<em><?php echo( $row[1] ); ?></em></li>
				<li><strong>Album:</strong>&nbsp;<em><?php echo ( $row[2] ); ?></em></li>
				<li><strong>Artist:</strong>&nbsp;<em><?php echo ( $row[3] ); ?></em></li>
				<li><strong>Genre:</strong>&nbsp;<em><?php echo ( $row[4] ); ?></em></li>
				<li><strong>Bitrate:</strong>&nbsp;<em><?php echo ( $row[5] ); ?></em></li>
				<li><strong>Length:</strong>&nbsp;<em><?php echo ( $row[6]  ); ?></em></li>
				<li><strong>Size:</strong>&nbsp;<em><?php echo ( $row[7] ); ?></em></li>
				<li><strong>Year:</strong>&nbsp;<em><?php echo ( $row[8] ); ?></em></li>
				<li><strong>EncodedBy:</strong>&nbsp;<em><?php echo ( $row[9] ); ?></em></li>
				<!-- <li><strong>Track Count:</strong>&nbsp;<em><?php echo ( $row[9] ); ?></em></li> -->
				<!-- <li><strong>Disc:</strong>&nbsp;<em><?php echo ( $row[9] ); ?></em></li> -->
				<!-- <li><strong>Disc Count:</strong>&nbsp;<em><?php echo ( $row[9] ); ?></em></li> -->
				<li><strong>File:&nbsp;</strong> 
				<em><?php echo ( "<a href=\"/music" . $row[10] . "\">" . basename($row[10]) . "</a>" ); ?></em></li>
				<li><strong>Lyrics:</strong>
<?php
	if($row[13] != NULL)
	{
				echo( "<a href=\"/query/lyrics.php?sid='" . $sid . "'\"><em>see</em></a>" );
	}
	else
	{
				echo( "<em>NA</em>" );
	}
			?>
				</li>
			</ul>
			<dl>
				<dt><strong>Comments:</strong></dt>
				<dd>
					<em><?php echo( $row[11] ); ?></em>
				</dd>
			</dl>
			<!--<dl>
			<dt><strong>Tags:</strong></dt>
			<dd>
<?php
if( isset($edit_mode) )
{
	echo("work progress, comming soon...");
		?>
		<form>
          	<input type="text" name="tags">
		</form>
		<?php
}
else
{
		?>
		None&nbsp;<a href="details.php?sid=<?php echo($sid) ?>&edit_mode=1" name="edit_tags">Edit</a>
		<?php
}
		?>
			</dd>
			</dl>-->
			</td>
			<td class="Padded">
			<table valign="top" align="right" border="0" cellpadding="0" cellspacing="0">
				<tbody>
				<!-- <caption align=bottom>TODO</caption> -->
				<tr>
					<td background="../image/lside-10x1024.white.jpg" width="10">&nbsp;</td>
					<td>
						<img src=<?php echo("\"/music/.album_art/large/$row[12]\"") ?> 
						alt="Cover Art" align="right" border="0" height="225" hspace="0" vspace="0" width="225">
					</td>
					<td background="../image/vdrop-20x1024.white.jpg" width="20">&nbsp;</td>
				</tr>
				<tr>
					<td width="10"></td>
					<td background="../image/hdrop-1024x20.white.jpg" height="20"></td>
					<td background="../image/cdrop-20x20.white.jpg" height="20"></td>
				</tr>
				</tbody>
			</table>
			</td>
			</tr></table>
			<hr />
<?php
include("../module/bottom_toolbar.php");
include("../module/contact_info.php");
		?>
		<br />
		<span style="font-size: smaller;">
			<em>Version 2.0.0.7 Sat Sep  8 11:23:37 CDT 2007 ~( Copyright © by Brian Preston (2007) )</em>
		</span>
		
		<?php mysql_close($db); ?>
		</div>
	</body>
</html>
