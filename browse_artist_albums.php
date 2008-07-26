<?php
include_once("./config/config.php");
		?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<!-- headers -->
	<head>
		<title>Artist Albums</title>
		<meta name="generator" content="Bluefish 1.0.7"/>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="/css/main_web.css" />
	</head>
	<body>
		<div class="text_area">
		
		<?php include("./module/login_greeting.php"); ?>
		<br />
			<div class="box" style="text-align: center">
			<center>
				<h1><em>Artist Albums</em></h1>
			</center>
			</div>
			<br />	
			<!-- Navagation Bar -->
			<?php include("./module/top_toolbar.php"); ?>
			<br />
			<table align="center">
<?php
if(isset($aid))
{
	$db = mysql_connect($db_address, $db_user_name, $db_password);
	mysql_select_db($db_name, $db);
	mysql_query("SET NAMES 'utf8'");
	
	if(isset($filter) && strlen($filter) > 0)
	{
		$filter = mysql_real_escape_string( $filter );
		$filter = "AND song.file LIKE '/$filter/%'";
	}
	else
	{
		$filter = "";
	}
	$sql = "SELECT DISTINCT album, art.file, album_id FROM song " . 
		"INNER JOIN album ON album_id=album.id " .
		"INNER JOIN artist ON artist_id=artist.id " . 
		"LEFT JOIN art ON art_id=art.id WHERE artist_id='$aid' $filter";
	//echo($sql);			
	$result = mysql_query($sql, $db);
	$row = mysql_fetch_row($result);
	//echo("<div align="center"><h3>$row[3]</h3></div>");
	while( $row )
	{
		$col = 1;
		echo("<tr>");
		while( $row && ($col % 4) )
		{
			$album_id = $row[2];
            ?>
				<td>
					<table valign="top" align="right" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td background="../image/lside-10x1024.white.jpg" width="10">&nbsp;</td>
						<td>
						<a href="results.php?query_type=album&album_id=<?php echo("\"$album_id\"") ?>>
							<img src=<?php echo("\"/music/.album_art/large/$row[1]\" alt=\"$row[0]\"") ?> 
							title=<?php echo("\"$row[0]\""); ?> alt="Cover Art" align="right" 
							border="0" height="200" hspace="0" vspace="0" width="200">
						</a>
						</td>
						<td background="../image/vdrop-20x1024.white.jpg" width="20">&nbsp;</td>
					</tr>
					<tr>
						<td width="10"></td>
						<td background="../image/hdrop-1024x20.white.jpg" height="20"></td>
						<td background="../image/cdrop-20x20.white.jpg" height="20"></td>
					</tr>
					</table>
				</td>
<?php
			$row = mysql_fetch_row($result);
			$col++;
		} 
		echo("</tr>");	
	} 
}  
		?>  
			</table>
			</center>

<?php
include("./module/bottom_toolbar.php");
include("./module/contact_info.php");
			?>
			<br />
			<!-- verison info -->
<?php
include("./module/version.php");
			?>
		</div>
	</body>
</html>
