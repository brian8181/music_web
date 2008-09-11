<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<!-- headers -->
	<head>
	<title>Browse Albums</title>
		<meta name="generator" content="Bluefish 1.0.7">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="stylesheet" type="text/css" href="/css/main_web.css">
	</head>
	<!-- Here Begineth the main body -->
	<body>
		<!-- Start - Whole Page Table -->
		<table class="Main" width="90%"><tr><td>
		<?php include("../module/login_greeting.php"); ?>
		<br />
			<!-- Display Title -->
			<center><div class="box" style="text-align: center">
				<h1><em>Browse Albums</em></h1>
			</div></center>
			<!-- Navagation Bar -->
			<table class="Nav" align="center">
			<tr class="Nav">
				<td align="center"><a class="Nav" href="/">Home</a></td>
				<td align="center"><a class="Nav" href="pics">Pictures</a></td>
				<td align="center"><a class="Nav" href="music">Browse Music</a></td>
				<td align="center"><a class="Nav" href="query/query.php">Search Music</a></td>
				<td align="center"><a class="Nav" href="wiki/index.php">BkpWiki</a></td>
				<td align="center"><a class="Nav" href="bugzilla">Bugzilla</a></td>
			</tr>
			</table>
			<br />
			<div align="center">
			<a href="/query/browse_albums.php?row=0&letter=A">A</a>&nbsp;&nbsp;
			<a href="/query/browse_albums.php?row=0&letter=B">B</a>&nbsp;&nbsp;
			<a href="/query/browse_albums.php?row=0&letter=C">C</a>&nbsp;&nbsp;
			<a href="/query/browse_albums.php?row=0&letter=D">D</a>&nbsp;&nbsp;
			<a href="/query/browse_albums.php?row=0&letter=E">E</a>&nbsp;&nbsp;
			<a href="/query/browse_albums.php?row=0&letter=F">F</a>&nbsp;&nbsp;
			<a href="/query/browse_albums.php?row=0&letter=G">G</a>&nbsp;&nbsp;
			<a href="/query/browse_albums.php?row=0&letter=H">H</a>&nbsp;&nbsp;
			<a href="/query/browse_albums.php?row=0&letter=I">I</a>&nbsp;&nbsp;
			<a href="/query/browse_albums.php?row=0&letter=J">J</a>&nbsp;&nbsp;
			<a href="/query/browse_albums.php?row=0&letter=K">K</a>&nbsp;&nbsp;
			<a href="/query/browse_albums.php?row=0&letter=L">L</a>&nbsp;&nbsp;
			<a href="/query/browse_albums.php?row=0&letter=M">M</a>&nbsp;&nbsp;
			<a href="/query/browse_albums.php?row=0&letter=N">N</a>&nbsp;&nbsp;
			<a href="/query/browse_albums.php?row=0&letter=O">O</a>&nbsp;&nbsp;
			<a href="/query/browse_albums.php?row=0&letter=P">P</a>&nbsp;&nbsp;
			<a href="/query/browse_albums.php?row=0&letter=Q">Q</a>&nbsp;&nbsp;
			<a href="/query/browse_albums.php?row=0&letter=R">R</a>&nbsp;&nbsp;
			<a href="/query/browse_albums.php?row=0&letter=S">S</a>&nbsp;&nbsp;
			<a href="/query/browse_albums.php?row=0&letter=T">T</a>&nbsp;&nbsp;
			<a href="/query/browse_albums.php?row=0&letter=U">U</a>&nbsp;&nbsp;
			<a href="/query/browse_albums.php?row=0&letter=V">V</a>&nbsp;&nbsp;
			<a href="/query/browse_albums.php?row=0&letter=W">W</a>&nbsp;&nbsp;
			<a href="/query/browse_albums.php?row=0&letter=X">X</a>&nbsp;&nbsp;
			<a href="/query/browse_albums.php?row=0&letter=Y">Y</a>&nbsp;&nbsp;
			<a href="/query/browse_albums.php?row=0&letter=Z">Z</a>&nbsp;&nbsp;
			</div>
			<br />
			<!-- Main Section -->
<?php
// database connection stuff
$db = mysql_connect($db_address, $db_user_name, $db_password);
mysql_select_db("music", $db) or die(mysql_errno() . ": " . mysql_error() . "<br>");
// including the navbar class
include("../php/navbar.php");
// initiate it!
$nav = new navbar;
// set how many records to show at a time
$nav->numrowsperpage = 10;
$sql = "SELECT * FROM song INNER JOIN album on album_id=album.id WHERE album LIKE '$letter%'";
// the third parameter of execute() is optional
$result = $nav->execute($sql, $db, "mysql");
// handle the returned result set
$rows = mysql_num_rows($result);
echo( "Rows: $rows<br /><br />\n" );
/*
for ($y = 0; $y < $rows; $y++)
{
	$data = mysql_fetch_row($result);
	echo( "#$y - $data[0]<br />" );
	//echo $data->url . "<br>\n";
}
*/
echo "<hr>\n";
// build the returned array of navigation links
$links = $nav->getlinks("all", "on");
			?>
			<table cellspacing="35" align="center">
			<tr>
				<td>
					<!-- Cover Image & Drop Shadow -->
					<table valign="top"  align="center" border="0" cellpadding="0" cellspacing="0">
						<tbody>
						<!-- <caption align=bottom>TODO</caption> -->
						<tr>
							<td background="../image/lside-10x1024.white.jpg" width="10">&nbsp;</td>
							<td>
								<img src="../image/{bc5fcfe7-bba5-4161-b285-d6a436dedbce}.jpeg" 
								alt="Cover Art" align="right" border="0" height="150" 
								hspace="0" vspace="0" width="150">
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
			</tr>
			</table>
			<center>
			<table><tr><td align="center">
<?php
$count = count($links);
for ($y = 0; $y < $count; $y++) {
	if($y > 9)
	{
		echo( "...&nbsp;&nbsp;" . $links[$count-2] . "&nbsp;&nbsp;" );
		echo( $links[$count-1] );
		break;
	}
	echo $links[$y] . "&nbsp;&nbsp;";
}
				?>
			</td></tr></table>
			</center>
			<br />
			<!-- Navagation Bar -->
			<table class="Nav" align="center">
				<tr class="Nav">
					<td align="center"><a class="Nav" href="/">Home</a></td>
					<td align="center"><a class="Nav" href="/query/query.php">Search Music</a></td>
					<td align="center"><a class="Nav" href="/query/playlists.php">Playlists</a></td>
					<td align="center"><a class="Nav" href="/maintenance.html">Advanced Search</a></td>
					<td align="center"><a class="Nav" href="/query/topsearch.php">Top Search</a></td>
					<td align="center"><a class="Nav" href="/wiki/index.php">BkpWiki</a></td>
				</tr>
			</table>
			<!-- w3c: validate page -->
			<center>
				<p>
					<a href="http://validator.w3.org/check?uri=referer">
						<img src="image/valid-html401-blue.png" alt="Valid HTML 4.01 Transitional" height="31" width="88">
					</a>
				</p>
			</center>
			<br />
			<!-- Contact Info -->
			<div style="text-align: center">
				If you know me and want a password you can e-mail me, maybe I will give you one.
				<br />
				<a href="mailto:brian@bkp-online.com?subject=Web Password">brian@bkp-online.com</a>
			</div>
			<br />
			<em>Version 1.0.0.0</em>
		<!-- End - Whole Page Table -->
		</td></tr></table>
	</body>
</html>
