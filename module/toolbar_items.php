<?php
if( isset( $enable_advanced ) && $enable_advanced == true )
{
	?>
	 <td align="center">
       <a class="Nav" href="adv_query.php">Advanced</a>
    </td>
<?php
}
	if( isset( $enable_playlist ) && $enable_playlist == true )
	{
	?>
	<td align="center">
       <a class="Nav" href="browse_artist.php">Browse</a>
    </td>
<?php
}
if( isset( $enable_browse ) && $enable_browse == true )
{
		?>
    <td align="center">
       <a class="Nav" href="playlists.php">Playlists</a>
     </td>
<?php
}
if( isset( $enable_statistics ) && $enable_statistics == true )
{
	?>
	 <td align="center">
       <a class="Nav" href="music_stats.php">Statistics</a>
     </td>
<?php
}
?>