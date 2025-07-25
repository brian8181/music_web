<?php
// get the default query
function get_default_query()
{
	$sql =  "SELECT art.file as art_file, track, title, album, artist.artist as artist, song.file as song_file, song.id as sid, " .
			"user_cart.user_id, user_cart.removed_ts FROM song " . 			
			"LEFT JOIN artist ON artist.id = song.artist_id " .
			"LEFT JOIN album ON album.id = song.album_id " .
			"LEFT JOIN art ON song.art_id = art.id " . 
			"LEFT JOIN user_cart ON song.id = user_cart.song_id AND (user_id IS NULL OR removed_ts IS NULL)";
	return $sql;	
}
// get all lyrics
function get_all_lyrics()
{
	$sql = get_default_query();
	return "$sql WHERE NOT lyrics IS NULL";
}
// get default playlist
function get_playlist($pid)
{
	$sql = "SELECT art.file as art_file, track, title, album, artist.artist, song.file as song_file, song.id as sid,
			user_cart.user_id, user_cart.removed_ts, playlist_songs.`order` as `order` FROM song 
			LEFT JOIN artist ON artist.id = song.artist_id
			LEFT JOIN album ON album.id = song.album_id
			LEFT JOIN art ON song.art_id = art.id
			LEFT JOIN user_cart ON song.id = user_cart.song_id AND (user_id IS NULL OR removed_ts IS NULL )
			LEFT JOIN playlist_songs ON song.id = playlist_songs.song_id
			LEFT JOIN playlists ON playlists.id = playlist_songs.id
			WHERE playlist_id=$pid ORDER BY `order`";
	
	return $sql;
}
// get a serarch
function get_search( $artist=null, $album=null, $title=null, 
					 $genre=null,  $file=null,  $lyrics=null, 
					 $order_by=null, $wildcard=null, $and=null )
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
		$lyrics = str_replace( "*", "%", $lyrics);
		$lyrics = str_replace( "?", "_", $lyrics);
	}
	else
	{
		$album = !empty( $album ) ? "%$album%" : "";
		$artist = !empty( $artist ) ? "%$artist%" : "";
		$title = !empty( $title ) ? "%$title%" : "";
		$genre = !empty( $genre ) ? "%$genre%" : "";
		$file = !empty( $file ) ? "%$file%" : "";
		$lyrics = !empty( $lyrics ) ? "%$lyrics%" : "";
	}
	$album = mysql_real_escape_string( $album );
	$artist = mysql_real_escape_string( $artist );
	$title = mysql_real_escape_string( $title );
	$genre = mysql_real_escape_string( $genre );
	$file = mysql_real_escape_string( $file );
	
	// Build SQL
	$sql = get_default_query();
	
	$operator = '';
	
	//echo( $sql );
	$sql = "$sql WHERE";
	if( !empty( $artist ) )
	{
		$sql = "$sql (`artist`.`artist` LIKE '$artist')";
		$operator = ($and == "false") ? "OR" : "AND";
	}
	if( !empty( $album ) )
	{
		$sql = "$sql $operator (`album`.`album` LIKE '$album')";
		$operator = ($and == "false") ? "OR" : "AND";
	}
	if( !empty( $title ) )
	{
		$sql = "$sql $operator (`song`.`title` LIKE '$title')";
		$operator = ($and == "false") ? "OR" : "AND";
	}
	if( !empty( $genre ) )
	{
		$sql = "$sql $operator (`song`.`genre` LIKE '$genre')";
		$operator = ($and == "false") ? "OR" : "AND";
	}
	if( !empty( $file ) )
	{
		$sql = "$sql $operator (`song`.`file` LIKE '$file')";
		$operator = ($and == "false") ? "OR" : "AND";
	}
	if( !empty( $lyrics ) )
	{
		$sql = "$sql $operator (`song`.`lyrics` LIKE '$lyrics')";
	}
	if( !empty( $order_by ) )
		$sql = "$sql ORDER BY $order_by";
	return $sql;	
}
// get user cart
function get_my_cart($uid)
{
	$sql = "SELECT art.file as art_file, track, title, album, artist.artist, song.file as song_file, song.id as sid,
		user_cart.user_id, user_cart.removed_ts FROM song 
		INNER JOIN user_cart ON user_cart.song_id=song.id
		LEFT JOIN artist ON artist.id = song.artist_id
		LEFT JOIN album ON album.id = song.album_id
		LEFT JOIN art ON song.art_id = art.id WHERE `user_cart`.user_id=$uid  AND removed_ts IS NULL";
	return $sql;			
}
// get user cart
function get_my_downloads($uid)
{
	$sql = "SELECT art.file as art_file, track, title, album, artist.artist, song.file, song.id as sid,
	    download.insert_ts FROM download
		INNER JOIN song ON download.song_id=song.id
		LEFT JOIN artist ON artist.id = song.artist_id
		LEFT JOIN album ON album.id = song.album_id
		LEFT JOIN art ON song.art_id = art.id WHERE `download`.user_id=$uid ORDER BY download.insert_ts DESC";
	return $sql;			
}
// add an item to user car
function add_2_cart($uid, $sid, $db)
{
	$uid = mysql_real_escape_string( $uid );
	$sid = mysql_real_escape_string( $sid );
	// make sure it is not already present
	$sql = "INSERT INTO user_cart (user_id, song_id) VALUES($uid, $sid)";
	mysql_query($sql, $db);
}
// delete an item from user cart 
function delete_from_cart($uid, $sid, $db)
{
	$uid = mysql_real_escape_string( $uid );
	$sid = mysql_real_escape_string( $sid );
	// make sure it is not already present
	//$sql = "DELETE FROM user_cart WHERE user_id=$uid AND song_id=$sid";
	$sql = "UPDATE user_cart SET removed_ts=NOW() WHERE user_id=$uid AND song_id=$sid";
	mysql_query($sql, $db);
}
//
function init_navbar(&$nav)
{
	global $nav_row, $clicked, $order_dir;
			
	//nav bar
	$nav = new navbar;
	$nav->numrowsperpage = 50;
	$result = $nav->execute($sql, $db, "mysql");
	//get counts
	$total = $nav->total;
	$start_number = $nav->start_number;
	$end_number = $nav->end_number;
	
	return $result;
}
//
function get_query_string()
{
	// build a custom query string - for anchor tags
	$query = "?";
	foreach ($_GET as $key => $value)
	{
        switch ($key)
        {
			case "album":
			case "artist":
			case "title":
			case "file":
			case "genre":
			case "comments":
			case "listOption":
			case "and":	
			case "order_dir":						
            	$query .= "$key=$value&";
            	break;
         }
	}
	return rtrim($query, '&'); // trim off last &
}
//
function print_count()
{
	// print count
	if($result) {
		$num_rows = mysql_num_rows($result);
		echo( "<br /><br /><b>Showing $start_number - $end_number of $total</b>" );
	}	
}
function get_result_cells($row, $type)
{
	include_once("table_functions.php");
	$art_location = $GLOBALS['art_location'];
	
	$sid = $row['sid'];
	$track = $row['track'];
	$title = $row['title'];
	$artist = $row['artist'];
	$album = $row['album'];
	$song_file = $row['song_file'];
	$art_file = $row['art_file'];
	
	$row_html = "";
	switch($type)
	{
		case "result":
			$row_html = $row_html . get_picture_cell($album, $artist, $art_location, $art_file);
			$row_html = $row_html . get_track_cell($track);
			$row_html = $row_html . get_title_cell($title, $sid);
			$row_html = $row_html . get_album_cell($album);
			$row_html = $row_html . get_artist_cell($artist);
			break;
		case "cart":
			break;
		case "playlist":
			break;			
	}
	
	return $row_html;
}
function get_result_row($row)
{
	include_once("table_functions.php");
	$enable_security = $GLOBALS['enable_security'];
	$enable_direct_download = $GLOBALS['enable_direct_download'];
	$art_location = $GLOBALS['art_location'];
	$music_location = $GLOBALS['music_location'];
	
	$sid = $row['sid'];
	$track = $row['track'];
	$title = $row['title'];
	$artist = $row['artist'];
	$album = $row['album'];
	$song_file = $row['song_file'];
	$art_file = $row['art_file'];

	$row_html = "";
	$row_html = get_result_cells($row, "result");
	
	$authorized = $authorized = !$enable_security || 
		(assert_login() && assert_group('power_user')); 
	if( $authorized )
	{
		$incart = $row['user_id'];
		$removed = $row['removed_ts'];
		if($incart && !$removed) //was in cart and not removed
		{
			$row_html =  "$row_html<td align='center'><i>added to cart</i></td>
				<td align='center'><a href=\"./php/delete_from_cart.php?sid=$sid\">delete</a></td>";	
		}
		else
		{
			$row_html = "$row_html<td align='center'>
					<a href=\"./php/download.php?sid=$sid\">download</a></td>";
			return "$row_html<td align='center'>
				<a href=\"./php/add_to_cart.php?sid=$sid\">add&nbsp;to&nbsp;cart</a></td>";
		}
	}
	else
	{
		return "$row_html<td align='center'><em>download</em></td>
				<td align='center'><em>add&nbsp;to&nbsp;cart</em></td>";
	}
}
// print result table
function print_results($sql, $db)
{
	global $nav_row, $clicked, $order_dir;
			
	//nav bar
	$nav = new navbar;
	$nav->numrowsperpage = 50;
	$result = $nav->execute($sql, $db, "mysql");
	//get counts
	$total = $nav->total;
	$start_number = $nav->start_number;
	$end_number = $nav->end_number;
	
	$query = get_query_string();

	// print count
	if($result) {
		$num_rows = mysql_num_rows($result);
		echo( "<br /><br /><b>Showing $start_number - $end_number of $total</b>" );
	}
	
	// print headers
	?>
		<script src="./script/querystring.enhanced.js" type="text/javascript"></script>
		<script src="./script/functions.js" type="text/javascript"></script>
		<table id="result">
	    <tr class="header_row">
		<th align="center">&nbsp;</th>
		<th align="center">
			<a class="<?php echo( ($clicked == "track" ? "yellow_white" : "white_yellow") ) ?>"
			name="track" onclick="on_header_click(this)" 
			href="<?php echo("$query") ?>">
			Track
			</a>
		</th>
		<th align="center">
			<a class="<?php echo( ($clicked == "title" ? "yellow_white" : "white_yellow") ) ?>"
			name="title" onclick="on_header_click(this)"
			href="<?php echo("$query") ?>">
			Title
			</a>
		</th>
		<th align="center">
			<a class="<?php echo( ($clicked == "album" ? "yellow_white" : "white_yellow") ) ?>"
			name="album" onclick="on_header_click(this)" 
			href="<?php echo("$query") ?>">
			Album
			</a>
		</th>
		<th align="center">
			<a class="<?php echo( ($clicked == "artist" ? "yellow_white" : "white_yellow") ) ?>"
			name="artist" onclick="on_header_click(this)" 
			href="<?php echo("$query&clicked=artist") ?>">
			Artist
			</a>
		</th>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
		</tr>
	<?php		
	
	// print data
	while( $row = mysql_fetch_assoc($result) )
	{
		$row_html = get_result_row($row);
		echo("<tr id=\"table_row\">$row_html</tr>");
	}
	?>
	</table>
	<br />
	<?php
	
	echo("<center>");
	// print nav bar
	$links = $nav->getlinks("all", "on");
	if($links != null)
	{
		for ($y = 0; $y < count($links); $y++) {
		  echo $links[$y] . "&nbsp;&nbsp;";
		}
	}
	echo("</center>");
}
// print a playlist table
function print_playlist($sql, $db)
{
	global $nav_row, $clicked, $order_dir;
			
	//nav bar
	$nav = new navbar;
	$nav->numrowsperpage = 50;
	$result = $nav->execute($sql, $db, "mysql");
	//get counts
	$total = $nav->total;
	$start_number = $nav->start_number;
	$end_number = $nav->end_number;

	$query = get_query_string();
	
	// print count
	if($result) {
		$num_rows = mysql_num_rows($result);
		echo( "<br /><br /><b>Showing $start_number - $end_number of $total</b>" );
	}
	
	// print headers
	?>
		<script src="./script/querystring.enhanced.js" type="text/javascript"></script>
		<script src="./script/functions.js" type="text/javascript"></script>
	    <table id="result">
	    <tr class="header_row">
		<th align="center">&nbsp;</th>
		<th align="center">
			Order
		</th>
		<th align="center">
			Title
		</th>
		<th align="center">
			Album
		</th>
		<th align="center">
			Artist
		</th>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
		</tr>
	<?php		

	$enable_security = $GLOBALS['enable_security'];
	$enable_direct_download = $GLOBALS['enable_direct_download'];
	$art_location = $GLOBALS['art_location'];
	$music_location = $GLOBALS['music_location'];
	$authorized = $authorized = !$enable_security || 
		(assert_login() && assert_group('power_user')); 
	      
	// print data
	while( $row = mysql_fetch_assoc($result) )
	{
		$sid = $row['sid'];
		$order = $row['order'];
		$title = $row['title'];
		$artist = $row['artist'];
		$album = $row['album'];
		$song_file = $row['song_file'];
		$art_file = $row['art_file'];
		
		$row_html = 
			"<td>
				<a class=\"NoColor\" href=\"./results.php?album=$album&artist=$artist&amp;order_by=artist,album,track,title\">
					<img src=\"$art_location/xsmall/$art_file\" width=\"50\" height=\"50\" alt=\"NA\"/>
				</a>
			</td>
			<td>$order</td>
			<td>
			    <a href=\"details.php?sid=$sid\">$title</a>
			</td>
			<td>
			    <a href=\"results.php?album=$album&amp;order_by=artist,album,track,title\">$album</a>
			</td>
			<td>
			    <a href=\"results.php?artist=$artist&amp;order_by=artist,album,track,title\">$artist</a>
			</td>";
				
		if( $authorized )
		{
			$incart = $row['user_id'];
			$removed = $row['removed_ts'];
			if($incart && !$removed) //was in cart and not removed
			{
				$row_html =  "$row_html<td align='center'><i>added to cart</i></td>
					<td align='center'><a href=\"./php/delete_from_cart.php?sid=$sid\">delete</a></td>";	
			}
			else
			{
				if($enable_direct_download)
				{
					$row_html =  "$row_html<td align='center'>
						<a href=\"$music_location$song_file\">download</a></td>";
				}
				else
				{
					$row_html = "$row_html<td align='center'>
						<a href=\"./php/download.php?sid=$sid\">download</a></td>";
				}
				$row_html = "$row_html<td align='center'>
					<a href=\"./php/add_to_cart.php?sid=$sid\">add&nbsp;to&nbsp;cart</a></td>";
			}
		}
		else
		{
			$row_html = "$row_html
						<td align='center'><em>download</em></td>
						<td align='center'><em>add&nbsp;to&nbsp;cart</em></td>";
		}
	   	echo("<tr id=\"table_row\">$row_html</tr>");
	}
	?>
	</table>
	<br />
	<?php
	
	echo("<center>");
	// print nav bar
	$links = $nav->getlinks("all", "on");
	if($links != null)
	{
		for ($y = 0; $y < count($links); $y++) {
		  echo $links[$y] . "&nbsp;&nbsp;";
		}
	}
	echo("</center>");
}
// print a playlist table
function print_album($sql, $db)
{
	global $nav_row, $clicked, $order_dir;
			
	//nav bar
	$nav = new navbar;
	$nav->numrowsperpage = 50;
	$result = $nav->execute($sql, $db, "mysql");
	//get counts
	$total = $nav->total;
	$start_number = $nav->start_number;
	$end_number = $nav->end_number;

	$query = get_query_string();

	// print count
	if($result) {
		$num_rows = mysql_num_rows($result);
		echo( "<br /><br /><b>Showing $start_number - $end_number of $total</b>" );
	}
	
	// print headers
	?>
		<script src="./script/querystring.enhanced.js" type="text/javascript"></script>
		<script src="./script/functions.js" type="text/javascript"></script>
		<table id="result">
	    <tr class="header_row">
		<th align="center">&nbsp;</th>
		<th align="center">
			Track
		</th>
		<th align="center">
			Title
		</th>
		<th align="center">
			Album
		</th>
		<th align="center">
			Artist
		</th>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
		</tr>
	<?php		

	$enable_security = $GLOBALS['enable_security'];
	$enable_direct_download = $GLOBALS['enable_direct_download'];
	$art_location = $GLOBALS['art_location'];
	$music_location = $GLOBALS['music_location'];
	$authorized = $authorized = !$enable_security || 
		(assert_login() && assert_group('power_user')); 
	      
	// print data
	while( $row = mysql_fetch_assoc($result) )
	{
		$sid = $row['sid'];
		$track = $row['track'];
		$title = $row['title'];
		$artist = $row['artist'];
		$album = $row['album'];
		$song_file = $row['song_file'];
		$art_file = $row['art_file'];
		
		$row_html = 
			"<td>
				<a class=\"NoColor\" href=\"./results.php?album=$album&artist=$artist&amp;order_by=artist,album,track,title\">
					<img src=\"$art_location/xsmall/$art_file\" width=\"50\" height=\"50\" alt=\"NA\"/>
				</a>
			</td>
			<td>$track</td>
			<td>
			    <a href=\"details.php?sid=$sid\">$title</a>
			</td>
			<td>
			    <a href=\"results.php?album=$album&amp;order_by=artist,album,track,title\">$album</a>
			</td>
			<td>
			    <a href=\"results.php?artist=$artist&amp;order_by=artist,album,track,title\">$artist</a>
			</td>";
				
		if( $authorized )
		{
			$incart = $row['user_id'];
			$removed = $row['removed_ts'];
			if($incart && !$removed) //was in cart and not removed
			{
				$row_html =  "$row_html<td align='center'><i>added to cart</i></td>
					<td align='center'><a href=\"./php/delete_from_cart.php?sid=$sid\">delete</a></td>";	
			}
			else
			{
				if($enable_direct_download)
				{
					$row_html =  "$row_html<td align='center'>
						<a href=\"$music_location$song_file\">download</a></td>";
				}
				else
				{
					$row_html = "$row_html<td align='center'>
						<a href=\"./php/download.php?sid=$sid\">download</a></td>";
				}
				$row_html = "$row_html<td align='center'>
					<a href=\"./php/add_to_cart.php?sid=$sid\">add&nbsp;to&nbsp;cart</a></td>";
			}
		}
		else
		{
			$row_html = "$row_html
						<td align='center'><em>download</em></td>
						<td align='center'><em>add&nbsp;to&nbsp;cart</em></td>";
		}
	   	echo("<tr id=\"table_row\">$row_html</tr>");
	}
	?>
	</table>
	<br />
	<?php
	
	echo("<center>");
	// print nav bar
	$links = $nav->getlinks("all", "on");
	if($links != null)
	{
		for ($y = 0; $y < count($links); $y++) {
		  echo $links[$y] . "&nbsp;&nbsp;";
		}
	}
	echo("</center>");
}
// print cart table		
function print_cart($sql, $db)
{
	global $nav_row, $clicked, $order_dir;
			
	//nav bar
	$nav = new navbar;
	$nav->numrowsperpage = 50;
	$result = $nav->execute($sql, $db, "mysql");
	//get counts
	$total = $nav->total;
	$start_number = $nav->start_number;
	$end_number = $nav->end_number;

	$query = get_query_string();

	// print count
	if($result) {
		$num_rows = mysql_num_rows($result);
		echo( "<br /><br /><b>Showing $start_number - $end_number of $total</b>" );
	}
	
	// print headers
	?>
		<script src="./script/querystring.enhanced.js" type="text/javascript"></script>
		<script src="./script/functions.js" type="text/javascript"></script>
		<table id="result">
	    <tr class="header_row">
		<th align="center">&nbsp;</th>
		<th align="center">
			<a class="<?php echo( ($clicked == "track" ? "yellow_white" : "white_yellow") ) ?>"
			name="track" onclick="on_header_click(this)" 
			href="<?php echo("$query") ?>">
			Track
			</a>
		</th>
		<th align="center">
			<a class="<?php echo( ($clicked == "title" ? "yellow_white" : "white_yellow") ) ?>"
			name="title" onclick="on_header_click(this)"
			href="<?php echo("$query") ?>">
			Title
			</a>
		</th>
		<th align="center">
			<a class="<?php echo( ($clicked == "album" ? "yellow_white" : "white_yellow") ) ?>"
			name="album" onclick="on_header_click(this)" 
			href="<?php echo("$query") ?>">
			Album
			</a>
		</th>
		<th align="center">
			<a class="<?php echo( ($clicked == "artist" ? "yellow_white" : "white_yellow") ) ?>"
			name="artist" onclick="on_header_click(this)" 
			href="<?php echo("$query&clicked=artist") ?>">
			Artist
			</a>
		</th>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
		</tr>
	<?php		

	$enable_security = $GLOBALS['enable_security'];
	$enable_direct_download = $GLOBALS['enable_direct_download'];
	$art_location = $GLOBALS['art_location'];
	$music_location = $GLOBALS['music_location'];
	$authorized = $authorized = !$enable_security || 
		(assert_login() && assert_group('power_user')); 
	      
	// print data
	while( $row = mysql_fetch_assoc($result) )
	{
		$sid = $row['sid'];
		$track = $row['track'];
		$title = $row['title'];
		$artist = $row['artist'];
		$album = $row['album'];
		$song_file = $row['song_file'];
		$art_file = $row['art_file'];
		
		$row_html = 
			"<td>
				<a class=\"NoColor\" href=\"./results.php?album=$album&artist=$artist&amp;order_by=artist,album,track,title\">
					<img src=\"$art_location/xsmall/$art_file\" width=\"50\" height=\"50\" alt=\"NA\"/>
				</a>
			</td>
			<td>$track</td>
			<td>
			    <a href=\"details.php?sid=$sid\">$title</a>
			</td>
			<td>
			    <a href=\"results.php?album=$album&amp;order_by=artist,album,track,title\">$album</a>
			</td>
			<td>
			    <a href=\"results.php?artist=$artist&amp;order_by=artist,album,track,title\">$artist</a>
			</td>";
				
		if( $authorized )
		{
			if($enable_direct_download)
			{
				$row_html =  "$row_html<td align='center'>
					<a href=\"$music_location$song_file\">download</a></td>";
			}
			else
			{
				$row_html = "$row_html<td align='center'>
					<a href=\"./php/download.php?sid=$sid\">download</a></td>";
			}
			$row_html =  "$row_html<td align='center'><a href=\"./php/delete_from_cart.php?sid=$sid\">delete</a></td>";	
		}
		echo("<tr id=\"table_row\">$row_html</tr>");
	}
	?>
	</table>
	<br />
	<?php
	
	echo("<center>");
	// print nav bar
	$links = $nav->getlinks("all", "on");
	if($links != null)
	{
		for ($y = 0; $y < count($links); $y++) {
		  echo $links[$y] . "&nbsp;&nbsp;";
		}
	}
	echo("</center>");
}
// get user row
function get_user($user_name, $db)
{
	$user_name = mysql_real_escape_string($user_name);
	// make sure user dose not exsit
	$sql = "SELECT id FROM `user` WHERE user='$user_name'";
	$result = mysql_query( $sql, $db );
	if( mysql_num_rows($result) )
	{
		return $result;
	}
	return null;
}
//limit number of accounts to 10 per day
function ip_blocked($type, $db)
{
	$remote_ip = $_SERVER['REMOTE_ADDR'];
	$sql = "SELECT * from limits where ip='$remote_ip' && insert_ts > (NOW() - INTERVAL 1440 MINUTE);";
	$result = mysql_query( $sql, $db );
	$count = mysql_num_rows($result);
	return $count > 9;
}
// create a new account
function create_account($user_name, $password, $full_name, $email, $question_id, $answer, $db)
{
	$sql = "INSERT INTO `user` (`user`, `password`, `full_name`, `email`, `comment`) " .
					"VALUES('$user_name', '$password', '$full_name', '$email', 'web user')";
	mysql_query( $sql, $db );
	// insert into user group
	$user_id = mysql_insert_id( $db );
	$sql = "SELECT id FROM `group` WHERE `group`.`group`='user'";
	$result = mysql_query( $sql, $db );
	$row = mysql_fetch_row( $result );
	$group_id = $row[0];
	mysql_query("INSERT INTO `user_group` (`user_id`, `group_id`) VALUES($user_id, $group_id)", $db);
		
	if( mysql_affected_rows($db) > 0 )
	{
		$remote_ip = $_SERVER['REMOTE_ADDR'];
		$sql = "INSERT INTO `limits` (`user_id`, `ip`) VALUES($user_id, '$remote_ip')";
		mysql_query($sql, $db);
		$sql = "INSERT INTO `user_security_question` (`user_id`, `question_id`, `answer`) 
				VALUES($user_id, $question_id, '$answer')";
		mysql_query($sql, $db);
		return true;
	}
	// make sure it inserted
	return false;
}
// auths user and sets session vars //
function set_session($user, $pass, $db)
{
	$user = mysql_real_escape_string($user);
	$pass = mysql_real_escape_string($pass);
	$sql = "SELECT user.id, `user`, `group`, `password`, email, full_name, `style`.`id`, `style`.`file` FROM `user` " . 
			"INNER JOIN `user_group` ON `user`.id=`user_id` " . 
			"INNER JOIN `group` ON `user_group`.`group_id`=`group`.id " .
			"LEFT JOIN `style` ON `style`.`id`=`style_id` " . 
			"WHERE user='$user' AND password='$pass'";
	$result = mysql_query( $sql, $db );
	if( mysql_num_rows($result) )
	{
		$row = mysql_fetch_row($result);
		$_SESSION['USER_ID'] = $row[0]; 
		$_SESSION['USER_NAME'] = $row[1];
		$_SESSION['USER_PASSWORD'] = $row[3];
		$_SESSION['USER_EMAIL'] = $row[4];
		$_SESSION['USER_FULLNAME'] = $row[5];
		$_SESSION['USER_STYLE_ID'] = $row[6];
		$_SESSION['USER_STYLE'] = $row[7];
		// fetch groups
		$_groups = array();
		do{
			$grp = $row[2];
			$groups[$grp] = 1;
		}while( $row == mysql_fetch_row($result) );
		$_SESSION['USER_GROUPS'] = $groups;
		return true;
	}
	return false;
}
// update user account
function update_account($user_name, $password, $full_name, $email, $style_id, $db)
{
	$sql = "UPDATE `user` SET `password`='$password', `full_name`='$full_name', `email`='$email', `style_id`=$style_id " .
					"WHERE `user`='$user_name'";
	mysql_query( $sql, $db );
	// make sure it inserted -1 = failed
	return ( mysql_affected_rows($db) > -1 );
}
// validate user is logged in 
function assert_login()
{
	if( isset($_SESSION['USER_NAME']) && isset($_SESSION['USER_GROUPS']) )
	{
		return true;
	}
	return false;
}
// assert user in group
function assert_group($group)
{
	if(assert_login())
	{
		$groups_loc = $_SESSION['USER_GROUPS']; 
		if(array_key_exists('admin', $groups_loc))
		{
			return true;
		}
	}
	return false;
}
// validate user pass strength
function validate_pass($password)
{
	if(
	ctype_alnum($password) // numbers & digits only
	&& strlen($password)>6 // at least 7 chars
	&& strlen($password)<21 // at most 20 chars
	//&& preg_match('`[A-Z]`',$password) // at least one upper case
	//&& preg_match('`[a-z]`',$password) // at least one lower case
	// at least one lower case or // at least one upper case
	&& ( preg_match('`[A-Z]`',$password) || preg_match('`[a-z]`',$password) )
	&& preg_match('`[0-9]`',$password) // at least one digit
	){
		// valid
		return true;
	}else{
		// not valid
		return false;
	} 
}
	?>