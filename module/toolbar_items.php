<?php
if( isset( $enable_advanced ) && $enable_advanced == true )
{
	?>
	 <td align="center">
       <a class="Nav" href="adv_query.php">Advanced</a>
    </td>
<?php
}
if( isset( $enable_browse ) && $enable_browse == true )
	{
	?>
	<td align="center">
       <a class="Nav" href="browse_artist.php?nav_row=0">Browse</a>
    </td>
<?php
}
if( isset( $enable_playlist ) && $enable_playlist == true )
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
if( isset( $enable_security ) && $enable_security == true )
{
	if(assert_group('admin'))
	{
	?>
	 <td align="center">
       <a class="Nav" href="./user_admin.php">Admin</a>
     </td>
<?php
	}
}
if( isset( $enable_quick_search ) && $enable_quick_search == true )
{
	?>
	 <td align="center">
        <form name="toolbar" onsubmit="on_quick_submit(toolbar)" method="get" action="results.php">
          <input type="hidden" name="artist" />
          <input type="hidden" name="title" />
          <input type="hidden" name="and" value="false" />
          <div class="white" style="text-align: center">
            <strong>
              <em>Quick Search:</em>
            </strong>&nbsp;
            <input type="text" name="album" align="right"/>
          </div>
        </form>
      </td>
<?php
}
?>