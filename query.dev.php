<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<!-- Query Page -->
<html>
	<!-- Headers -->
	<head>
		<title>Query Page</title>
		<link rel="stylesheet" type="text/css" href="../main_web.css">
		<link rel="stylesheet" type="text/css" href="../css/query.css">
	</head>

	<!-- Query html main body -->
	<body>
		
		<!-- PAGE TABLE -->
		<table class="Main"><tr><table class="Padded">

		<!-- Display Title -->
		<div class="box" style="text-align: center">
			<h1><em>Music Query</em></h1>
		</div>

		<!-- Navagation Bar -->
		<br />
		<table class="Nav" align="center">
			<tr class="Nav">
				<td align="center"><a class="Nav" href="/">Home</a></td>
				<td align="center"><a class="Nav" href="/pics">Pictures</a></td>
				<td align="center"><a class="Nav" href="/music">Browse Music</a></td>
				<td align="center"><a class="Nav" href="/query/query.php">Search Music</a></td>
				<td align="center"><a class="Nav" href="/wiki/index.php">BkpWiki</a></td>
				<td align="center"><a class="Nav" href="/bugzilla">Bugzilla</a></td>
			</tr>
		</table>
		<hr>

		<a class="Logo" href="httP://www.mysql.com">
			<img src="../image/mysql_100x52-64.gif" width="100" height="52" alt="" />
		</a>&nbsp;<sub><em>powered</em></sub>

		<!-- Submit Search String From -->
		<form action="query.dev.php" method="get">
			<div style="text-align: center">

				<div style="text-align: center">
					<h3>Search For:  </h3>
				</div>

				<!-- Seach Button -->
				<input type="text" name="txtSearch" value="<?php if (isset($txtSearch)) { echo $txtSearch; } ?>"/>
				<input type="submit" />
				in fields 
				<!-- Options DropList -->
				<select name="listOption" size="0">
					<option value="0"<?php if ($listOption == "0") { echo " SELECTED"; } ?>>All</option>
					<option value="1"<?php if ($listOption == "1") { echo " SELECTED"; } ?>>Title</option>
					<option value="2"<?php if ($listOption == "2") { echo " SELECTED"; } ?>>Album</option>
					<option value="3"<?php if ($listOption == "3") { echo " SELECTED"; } ?>>Artist</option>
					<option value="4"<?php if ($listOption == "4") { echo " SELECTED"; } ?>>File</option>
				</select>
				Use Wildcards:
				<input name="wildcard" type="checkbox" value="on" <?php if (isset($wildcard)) { echo " CHECKED"; } ?>>
        		</div>
		</form>
		<br />
		<p><strong></strong></p>
				
		<!-- Page comments -->
		<p><em>
			<b>Note:</b>&nbsp; Wildcards are still beign tested. If you leave the box unchecked things 
			should work the same as they always have. If you choose to use wildcards be aware there there
			 are some issues (<em>see...<a href="/bugzilla">Bugzilla</a> </em>).
			This is just a <strong>"friend"</strong> database so don't try anything funny (like SQL Injection). It is being logged &amp;
			I know who you are so I may drive over <strong>kick and your ass!</strong>
		</em></p>
		<br />

		<!-- Open/Close MySQL Connect & Query -->
<?php
function CloseExit()
{
	echo("<P>Error performing query: " . mysql_error() . "</P>");
	echo("</BODY></HTML>");
	// Closing connection
	mysql_close($dbcnx);
	exit();
}

// set url to deafult values
$url = "/query/query.php&amp;listOption=0";

if ( isset( $txtSearch ) )
{
	$dbcnx = @mysql_connect("127.0.0.1", "web", "sas*.0125");
	if(!$dbcnx)
		CloseExit();
	
	if(! @mysql_select_db("music") ) 
		CloseExit();
	
	$sql = "SELECT songs.art, track, title, album, artists.artist, file, songs.id FROM songs " .
		"INNER JOIN artists ON artists.id = songs.artist_id " .
		"INNER JOIN albums ON albums.id = songs.album_id ";
	
	// check for wildcards & strip escape characters
	$search = $txtSearch;
	if(isset($wildcard))
	{
		$search = str_replace( "*", "%", $search);
		$search = str_replace( "?", "_", $search);
	}
	else
	{
		$search = "%$search%";
	}
	$search = mysql_real_escape_string($search);
	
	// set search options
	switch($listOption)
	{
		case "0":
			$sql = $sql . "WHERE (artists.artist LIKE '$search') OR " .
				"(songs.title LIKE '$search') OR " .
				"(albums.album LIKE '$search') ";
			break;
		case "1":
			$sql = $sql . "WHERE (songs.title LIKE '$search') ";
			break;
		case "2":
			$sql = $sql . "WHERE (albums.album LIKE '$search') ";
			break;
		case "3":
			$sql = $sql . "WHERE (artists.artist LIKE '$search') ";
			break;
		case "4":
			$sql = $sql . "WHERE (songs.file LIKE '$search') ";
			break;
		default:
			$sql = $sql . "WHERE (artists.artist LIKE '$search') OR " .
				"(songs.title LIKE '%$search%') OR " .
				"(albums.album LIKE '%$search%') ";
			break;
	}
	
	if( isset( $sortby ) )
	{
		$sql = $sql . "ORDER BY $sortby ";
	}
	$sql = $sql . "LIMIT 0,501";
	
	echo($sql);
	$result = mysql_query($sql);
	$num_rows = mysql_num_rows($result);
	if( $num_rows > 500 )
	{
		echo( "Over <b>500</b> results found." );
	}
	else
	{
		echo( "<b>$num_rows</b>" . " results found." );
	}
	$url = "/query/query.php?txtSearch=" .$search . "&amp;listOption=" . $listOption;
}
		?>

		<!-- Song Table -->
		<table class="Result" align="center">
			<!-- Column Headers-->
			<tr bgcolor="#0A6653">
				<th align="center">Cover</th>
				<th align="center"><a class="Header" href=<?php echo( "\"" . $url . "&amp;sortby=track\"" ) ?>>Track</a></th>
				<th align="center"><a class="Header" href=<?php echo( "\"" . $url . "&amp;sortby=title\"" ) ?>>Title</a></th>
				<th align="center"><a class="Header" href=<?php echo( "\"" . $url . "&amp;sortby=albums.album\"" ) ?>>Album</a></th>
				<th align="center"><a class="Header" href=<?php echo( "\"" . $url . "&amp;sortby=artists.artist\"" ) ?>>Artist</a></th>
				<th align="center">Download</th>
			</tr>

			<!-- Fill table from query -->
<?php
$url = "/query/query.php?txtSearch=" .$row[2] . "&amp;listOption=Artist";
echo("\n");
while ( $row = mysql_fetch_array($result, MYSQL_NUM) )
{
	// process the row...
	echo( "<tr bgcolor='#BFBFBF'>\n" .
			//cover
			"\t<td align='center' bgcolor='#FFFFFF'>
				<a href=\"" . "/query/query.php?txtSearch=" . $row[3] . "&amp;listOption=2&amp;sortby=Track\">
				<img src=\"/music" . $row[0] . "\" width=\"75\" height=\"75\" alt=\"NA\"/>
				</a>
				</td>\n" .
			// track
			"\t<td align='center'>" . $row[1] . "</td>\n" .
			// title
			"\t<td class='Padded' align='left'><a href=\"/query/details.php?sid=" . $row[6] . "\">" 
			. $row[2]. "</a></td>\n" .
			// album
			"\t<td class='Padded' align='left'><a href=\"" . "/query/query.php?txtSearch=" 
			.$row[3] . "&amp;listOption=2&amp;sortby=Track\">" . $row[3]. "</a></td>\n" .
			// artist
			"\t<td class='Padded' align='left'><a href=\"" . "/query/query.php?txtSearch=" 
			.$row[4] . "&amp;listOption=3\">" . $row[4]. "</a></td>\n" .
			// download link
			"\t<td align='center'><a href=\"/music" . $row[5] . "\">download</a></td>\n" .
			"</tr>\n" );
}
// Free resultsetfile:///home/brian/src/web_page/query/query.php
mysql_free_result($result);
// Closing connection
mysql_close($dbcnx);
			?>
		</table>

		<br />
		<hr>

		<!-- Navagation Bar -->
		<table class="Nav" align="center">
			<tr class="Nav">
				<td align="center"><a class="Nav" href="/">Home</a></td>
				<td align="center"><a class="Nav" href="/pics">Pictures</a></td>
				<td align="center"><a class="Nav" href="/music">Browse Music</a></td>
				<td align="center"><a class="Nav" href="/query/query.php">Search Music</a></td>
				<td align="center"><a class="Nav" href="/wiki/index.php">BkpWiki</a></td>
				<td align="center"><a class="Nav" href="/bugzilla">Bugzilla</a></td>
			</tr>
		</table>
		
		<!-- w3c: validate page -->
		<center>
			<p>
				<a href="http://validator.w3.org/check?uri=referer">
					<img src="../image/valid-html401-blue.png" alt="Valid HTML 4.01 Transitional" height="31" width="88">
				</a>
			</p>
		</center>

		<!-- [ Page Footer ] Mail/  Date / Version # -->
		<center>
			<em>
				
				<span style="font-size: smaller;">Send all complaints to ...</span>
				<a href="mailto:george@whitehouse.gov?subject=A%20fellow%20moron%20looking%20for%20advice.">
					george@whitehouse.gov
				</a>
				<span style="font-size: smaller;"> ... other comments to ... </span>
				<a href="mailto:brian@bkp-online.com?subject=About%20Web%20Query">
					brian@bkp-online.com
				</a>
			</em>
		</center>
		
		<br />
		<span style="font-size: smaller;">
			<em>Version 1.0.0.6 Sat Sep  8 11:23:37 CDT 2007 ~( Copyright © by Brian Preston (2007) )</em>
		</span>
		
		</td></tr></table>
	</body>
</html>
