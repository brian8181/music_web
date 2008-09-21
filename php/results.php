<?php

function build_special_query($query_type)
{
 return build_query($query_type, null, null, null, null, null, null, null, null);
}

function build_query($query_type, $artist=null, $album=null, $title=null, $genre=null, $file=null, $lyrics=null, $sortby=null, $and=null)
{
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
			if( !isset($pid) )
				break;
			$sql = "SELECT art.file, track, title, album, artist.artist, song.file, song.id FROM song " . 
				"LEFT JOIN playlist_songs ON song.id = song_id " .
				"LEFT JOIN album ON album.id = song.album_id " .
				"LEFT JOIN artist ON artist.id = artist_id " .
				"LEFT JOIN art ON song.art_id = art.id " .
				"WHERE playlist_id=$pid ORDER BY `order`";
			break;
		case "my_cart":
			$sql = "SELECT art.file as art_file, track, title, album, artist.artist, song.file, song.id as sid FROM user_cart
					INNER JOIN song ON user_cart.song_id=song.id
					LEFT JOIN artist ON artist.id = song.artist_id
					LEFT JOIN album ON album.id = song.album_id
					LEFT JOIN art ON song.art_id = art.id WHERE `user_cart`.user_id=1  AND removed_ts IS NULL";
			break;	
		case "my_downloads":
			$sql = "SELECT art.file as art_file, track, title, album, artist.artist, song.file, song.id as sid FROM download
					INNER JOIN song ON download.song_id=song.id
					LEFT JOIN artist ON artist.id = song.artist_id
					LEFT JOIN album ON album.id = song.album_id
					LEFT JOIN art ON song.art_id = art.id WHERE `download`.user_id=1";	
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
				$sql = "SELECT art.file, track, title, album, artist.artist, song.file, song.id FROM song " .
					"LEFT JOIN artist ON artist.id = song.artist_id " .
					"LEFT JOIN album ON album.id = song.album_id " .
					"LEFT JOIN art ON song.art_id = art.id";
				$operator = '';
				
				//echo( $sql );
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
				if( !empty( $lyrics ) )
				{
					$sql = "$sql $operator (`song`.`lyrics` LIKE '$lyrics')";
				}
				if( !empty( $sortby ) )
					$sql = "$sql ORDER BY $sortby";
			}
			break;
	}
	return $sql;
}

function add_2_cart($uid, $sid, $db)
{
	$uid = mysql_real_escape_string( $uid );
	$sid = mysql_real_escape_string( $sid );
	// make sure it is not already present
	$sql = "INSERT INTO user_cart (user_id, song_id) VALUES($uid, $sid)";
	mysql_query($sql, $db);
}

function delete_from_cart($uid, $sid, $db)
{
	$uid = mysql_real_escape_string( $uid );
	$sid = mysql_real_escape_string( $sid );
	// make sure it is not already present
	//$sql = "DELETE FROM user_cart WHERE user_id=$uid AND song_id=$sid";
	$sql = "UPDATE user_cart SET removed_ts=NOW() WHERE user_id=$uid AND song_id=$sid";
	mysql_query($sql, $db);
}

?>