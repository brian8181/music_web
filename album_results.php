<?php
  $ROOT = $_SERVER['DOCUMENT_ROOT'];
	include("$ROOT/sec_user.php");
  include("$ROOT/validate_login.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- Query Page -->
<html>
  <!-- Headers -->
  <head>
    <title>Your Query Results</title>
    <link rel="stylesheet" type="text/css" href="/css/main_web.css" />
    <link rel="stylesheet" type="text/css" href="/css/query.css" />
  </head>
  <!-- Query html main body -->
  <body>
    <!-- Hit Counter -->
    <?php
			$db = mysql_connect('127.0.0.1', 'web', 'sas*.0125');
			mysql_select_db('music', $db);
			/*$sql = "INSERT INTO `query3` 
				(`query_type`, `album`, `artist`, `title`, `genre`, `file`, `comments`, `lyrics`, `and`, `wildcard`, `sortby`, `txtSearch`) 
				VALUES('$query_type', '$album', '$artist', '$title', '$genre', '$file', '$comments', '$lyrics', 'FALSE', '$and', '$sortby', NULL)";
			mysql_query($sql);*/
    	?>
    <!-- PAGE TABLE -->
    <table class="Main">
      <tr>
        <td class="Padded">
          <!-- Display Title -->
          <div class="box" style="text-align: center">
            <h1><em>Your Query Results</em></h1>
		</div>
		<!-- Navagation Bar -->
		<br />
		<?php include("../top_toolbar.php"); ?>
		<img src="/image/apache_pb.gif" align="right" width="259" height="32" alt="Apache" />
		<hr />
	<!-- ######################### START BODY ###################################### -->
	<a class="Logo" href="http://www.mysql.com">
		<img src="../image/mysql_100x52-64.gif" width="100" height="52" alt="" />
	</a>&nbsp;<sub><em>powered</em></sub>
	<!-- Open/Close MySQL Connect & Query -->
	<?php
		if( !isset( $query_type ) ) $query_type = "default";
		$sql = "";
		//echo( "<br />$sql<br />" );
		// Query
		$result = mysql_query($sql);
		$num_rows = mysql_num_rows($result);
		if( $num_rows > 500 )
			echo( "<br /><br />Over <b>500</b> results found." );
		else
			echo( "<br /><br /><b>$num_rows</b>" . " results found." );
		// log the query
		//$uri = $_SERVER['REQUEST_URI'];
		//$ip = $_SERVER['REMOTE_ADDR'];
		//$self = $_SERVER['PHP_SELF']
		//$query_string = $_SERVER['QUERY_STRING']
	?>
	<!-- Song Table -->
	<table class="Result" align="center">
		<!-- Column Headers-->
		<?php
		// Remove "sortby" from URI
		$pos = strrpos($uri, "sortby");
		if ( ! ($pos === false) ) // note: three equal signs
		{  
			// found...
			$len = strlen($uri);
			$len -= $pos-1;
			$uri = substr( $uri, 0, -$len );
		}
		?>
		<tr bgcolor="#0A6653">
			<th align="center">Cover</th>
			<th align="center"><a class="Header" href="<?php echo( "$uri&amp;sortby=track" ); ?>">Track</a></th>
			<th align="center"><a class="Header" href="<?php echo( "$uri&amp;sortby=title" ); ?>">Title</a></th>
			<th align="center"><a class="Header" href="<?php echo( "$uri&amp;sortby=album.album,track" ); ?>">Album</a></th>
			<th align="center">
			<a class="Header" href="<?php echo( "$uri&amp;sortby=artist.artist" ) ?>">Artist</a></th>
			<th align="center">Download</th>
		</tr>
		<!-- Fill table from query -->
		<?php
		echo("\n");
		while ( $row = mysql_fetch_row($result) )
		{
			// process the row...
		echo(
				"<tr bgcolor='#BFBFBF'>\n" .
				//cover
				"\t<td align='center' bgcolor='#FFFFFF'>
					<a href=\"/query/results.php?album=$row[3]&artist=$row[4]&amp;sortby=track\">
						<img src=\"/music/.album_art/xsmall/$row[0]\" width=\"50\" height=\"50\" alt=\"NA\"/>
					</a>
				</td>\n" .
				// track
				"\t<td align='center'>$row[1]</td>\n" .
				// title
				"\t<td class='Padded' align='left'>
					<a href=\"/query/details.php?sid=$row[6]\">$row[2]</a>
				</td>\n" .
				// album
				"\t<td class='Padded' align='left'>
					<a href=\"/query/results.php?album=$row[3]&amp;sortby=track\">$row[3]</a>
				</td>\n" .
				// artist
				"\t<td class='Padded' align='left'>
					<a href=\"/query/results.php?artist=$row[4]&amp;sortby=album.album,track\">$row[4]</a>
				</td>\n" .
				// download link
				"\t<td align='center'>
					<a href=\"/music$row[5]\">download</a>
				</td>\n" .
				"</tr>\n" 
			);
		}
		// free results, this doesn't hurt
		mysql_free_result($result);
		mysql_close($db);
		?>
	</table>
	<br />
	<!-- ######################### END BODY ######################################## -->
		<hr />
		<!-- Navagation Bar -->
		<?php
			include("../bottom_toolbar.php");
			include("../contact_info.php");
		?>
		<br />
		<span style="font-size: smaller;">
			<em>Version 2.0.0.7 Sat Sep  8 11:23:37 CDT 2007 ~( Copyright © by Brian Preston (2007) )</em>
		</span>
		</td></tr></table>
	</body>
</html>
<?php
	}
?>
