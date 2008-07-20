<?php
// Query Functions
function set_order($sort_str)
{
	// split comma delimited string 
	$splits = explode(",", $sort_str);
	switch($sortby)
	{
		case "song.track":
			break;
		case "song.title":
			break;
		case "album.album":
			break;
		case "artist.artist":
			break;
		default:
			break;
	}
}

define("TRACK", 0x2);
define("TITLE", 0x10);
define("ALBUM", 0x80);
define("ARTIST", 0x800);

function set_sort_order($item, $sort_srt)
{
	switch($sortby)
	{
		case "song.track":
			if( $item & TRACK )
			{
				
			}
			break;
		case "song.title":
			break;
		case "album.album":
			break;
		case "artist.artist":
			break;
		default:
			break;
	}
}
?>