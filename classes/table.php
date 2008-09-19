<?php
include_once("./classes/fragment.php");

abstract class song_headers extends fragment
{
	var $uri;
	
	function __construct($uri) {
       $this->$uri = $uri; 
   	}
	abstract protected function getOptions();
 
    public function printOut() {
    	global $uri;
	?> 
		<tr class="header_row">
		<th align="center">Cover</th>
		<th align="center"><a class="Header" href=<?php echo( "\"$uri&amp;sortby=track\"" ) ?>>Track</a></th>
		<th align="center"><a class="Header" href=<?php echo( "\"$uri&amp;sortby=title\"" ) ?>>Title</a></th>
		<th align="center"><a class="Header" href=<?php echo( "\"$uri&amp;sortby=album.album,track\"" ) ?>>Album</a></th>
		<th align="center">
			<a class="Header" href=<?php echo( "\"$uri&amp;sortby=artist.artist\"" ) ?>>Artist</a>
		</th>
 <?php 
    	$this->getOptions();
		echo("</tr>");
    }
}

class result_headers extends song_headers
{
    protected function getOptions() {
	?>
        	<th align="center">Download</th>
			<th align="center">Add</th>
<?php
    }
}

class cart_headers extends song_headers
{
    protected function getOptions() {

    }
}
	?>
