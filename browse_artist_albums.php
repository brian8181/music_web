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
		<!-- Start - Whole Page Table -->
		<center>
		<table class="Main" width="100%"><tr>
		<?php include("../module/login_greeting.php"); ?>
		<br />
			<div class="box" style="text-align: center">
			<center>
				<h1><em>Artist Albums</em></h1>
			</center>
			</div>
			<br />	
			<!-- Navagation Bar -->
			<?php include("../module/top_toolbar.php"); ?>
			<br />
			<table align="center">
<?php
if(isset($aid))
{
	$db = mysql_connect("127.0.0.1", "web", "sas*.0125");
	mysql_select_db("music", $db) or die(mysql_errno() . ": " . mysql_error() . "<br>");
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
			<!-- ######################### END BODY ######################################## -->
<?php
include("./module/bottom_toolbar.php");
include("./module/contact_info.php");
			?>
			<br />
			<!-- verison info -->
			<em>
			Version 1.0.0.3 Sat Sep  8 11:23:37 CDT 2007 ~( Copyright © by Brian Preston (2007) )
			</em>
			</td></tr></table>
		</center>
	</body>
</html>
