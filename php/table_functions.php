<?php
function get_picture_cell($album, $artist, $art_location, $file)
{
	return "<td>
				<a class=\"NoColor\" href=\"./results.php?album=$album&artist=$artist&amp;order_by=artist,album,track,title\">
					<img src=\"$art_location/xsmall/$file\" width=\"50\" height=\"50\" alt=\"NA\"/>
				</a>
			</td>";
}
function get_track_cell($track)
{
	return "<td>$track</td>";	
}
function get_title_cell($title, $sid)
{
	return "<td>
			    <a href=\"details.php?sid=$sid\">$title</a>
			</td>";	
}
function get_album_cell($album)
{
	return 	"<td>
			    <a href=\"results.php?album=$album&amp;order_by=artist,album,track,title\">$album</a>
			</td>";
}
function get_artist_cell($artist)
{
	return 	"<td>
			    <a href=\"results.php?artist=$artist&amp;order_by=artist,album,track,title\">$artist</a>
			</td>";
}
function get_order_cell($order)
{
	return 	"<td>$order</td>";
}
function get_checkbox_cell($name, $checked)
{
	return 	"<td><input name=\"$name\" type=\"checkbox\" value=\"on\" checked=\"$checked\" /></td>";
}
?>