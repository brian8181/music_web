<?php
include_once("./config/config.php");
include_once("./module/header.php");

open_page("Playlist");

$db = $db = mysql_connect($db_address, $db_user_name, $db_password);
mysql_select_db($db_name, $db);
$sql = "SELECT id, name from playlists ORDER BY name";
$result = mysql_query($sql);
	?>
	<!-- move formating to css -->
	<div class="left">
	<table class="info">
	<tr>
		<th style="text-align: left">Name</th>
		<th style="text-align: center">Count</th>
	</tr>
<?php 
while ( $row = mysql_fetch_array($result, MYSQL_NUM) )
{
	echo("<tr>");
	$id = $row[0];
	$name = $row[1];
	$sql = "SELECT count(*) FROM playlist_songs WHERE playlist_id=$id";
	$count_result = mysql_query($sql);
	$count_row = mysql_fetch_array($count_result, MYSQL_NUM);
	$count = $count_row[0]; 
	echo( "<td><a href=\"./view_playlist.php?pid=$id&nav_row=0&order_by=$default_order\">$name</a><br /></td>" );
	echo( "<td style=\"text-align: center\"><em>$count</em></td>" );
	echo("</tr>");
}
mysql_close($db);
	?>
	
	</table>			
	</div>
	
<?php 	
	include("./module/footer.php");
	?>
