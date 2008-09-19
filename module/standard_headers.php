<?php
function get_result_headers($uri)
{
 ?> 
		<th align="center">Cover</th>
		<th align="center"><a class="Header" href=<?php echo( "\"$uri&amp;sortby=track\"" ) ?>>Track</a></th>
		<th align="center"><a class="Header" href=<?php echo( "\"$uri&amp;sortby=title\"" ) ?>>Title</a></th>
		<th align="center"><a class="Header" href=<?php echo( "\"$uri&amp;sortby=album.album,track\"" ) ?>>Album</a></th>
		<th align="center">
			<a class="Header" href=<?php echo( "\"$uri&amp;sortby=artist.artist\"" ) ?>>Artist</a>
		</th>
 	<?php 
}
?>