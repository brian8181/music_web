<?php
include_once("./config/config.php");
		?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>Details</title>
    <meta name="generator" content="Bluefish 1.0.7" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="./css/<?php echo($style); ?>" />
</head>
<body>
	<div class="text_area">
<?php
$db = mysql_connect($db_address, $db_user_name, $db_password);
mysql_select_db($db_name, $db);
mysql_query("SET NAMES 'utf8'");

$sid = isset($_GET['sid']) ? $_GET['sid'] : null;
include("./module/login_greeting.php");
        ?>
		
		<br />
			<div class="box" style="text-align: center">
		<h1>
<?php 
echo($details_title); 
		?>
		</h1>
			</div>
		<br />			

<?php
include("./module/top_toolbar.php"); 
$sql = "SELECT track, title, album.album, artist.artist, genre, bitrate," .
		"length, file_size, year, encoder, song.file, comments, art.file, lyrics FROM song " .
		"INNER JOIN artist ON artist.id = song.artist_id " .
		"INNER JOIN album ON album.id = song.album_id " . 
		"INNER JOIN art ON song.art_id = art.id " . 
		"WHERE song.id='$sid'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result, MYSQL_NUM);
	//$helper = new Helper();
	//echo( $sql ); 
	mysql_close($db); 
			?>
			<hr>
            <table class="Main" width="="100%"><tr>
			<td  class="Padded" width="80%">
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
				echo( "<a href=\"lyrics.php?sid='" . $sid . "'\"><em>see</em></a>" );
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
			</td>
			<td align="center">
			<table valign="top" width="100%" align="right" border="0" cellpadding="0" cellspacing="0">
				<tbody>
				<!-- <caption align=bottom>TODO</caption> -->
				<tr>
					<td background="./image/lside-10x1024.white.jpg" width="10">&nbsp;</td>
					<td>
						<?php echo("<img src=\"$art_location/large/" .$row[12]) . "\" " ?> 
						alt="Cover Art" align="right" border="0" height="225" hspace="0" vspace="0" width="225">
					</td>
					<td background="./image/vdrop-20x1024.white.jpg" width="20">&nbsp;</td>
				</tr>
				<tr>
					<td width="10"></td>
					<td background="./image/hdrop-1024x20.white.jpg" height="20"></td>
					<td background="./image/cdrop-20x20.white.jpg" height="20"></td>
				</tr>
				</tbody>
			</table>
			</td>
			</tr></table>
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
