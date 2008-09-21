<?php 
session_start();
include_once("./config/config.php");
include_once("./php/functions.php");
$_SESSION['_PAGE'] = $_SERVER['REQUEST_URI'];
$style = assert_login() ? $_SESSION['USER_STYLE'] : "./css/$style";
		?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

  <head>
    <title>Browse Artist</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="<?php echo($style) ?>" />
    
  </head>
  <body>
	<div class="text_area">
<?php 
include("./module/login_greeting.php"); 
	?>
          <div class="box" style="text-align: center">
            <center>
              <h1>
                Browse Artist
              </h1>
            </center>
          </div>
<?php
include("./module/top_toolbar.php"); 
	?>
          
		  <hr />
          <div align="center">
<?php

//get set variables
$letter   = isset($_GET['letter'])    ? $_GET['letter']  : null;
$nav_row   = isset($_GET['nav_row'])  ? $_GET['nav_row']  : 0;
$show_all  = isset($_GET['show_all']) ? $_GET['show_all'] : null;

$filter = "";
$filters = "";
$db = mysql_connect( $db_address, $db_user_name, $db_password );
mysql_select_db( $db_name, $db );
mysql_query("SET NAMES 'utf8'");

$letter = isset($letter) ? mysql_real_escape_string($letter, $db) : 'A';
$view_state = "show_all=false";

if(isset($show_all) && $show_all != "true") {
       	      ?>
                    <a href="./browse_artist.php?nav_row=0&letter=<?php echo($letter) ?>&show_all=true">Full Albums</a>&nbsp;|&nbsp;
                    Show All<br /><br />
	<?php
}
else{
	?>
						Full Albums&nbsp;|&nbsp;
                    <a href="./browse_artist.php?nav_row=0&letter=<?php echo($letter) ?>&show_all=false">Show All</a><br /><br />
	<?php
	$filter = "/albums/";
	$view_state = "show_all=true";
} 
	?>
            <a href="./browse_artist.php?nav_row=0&letter=A&<?php echo($view_state) ?>">A</a>&nbsp;&nbsp;
            <a href="./browse_artist.php?nav_row=0&letter=B&<?php echo($view_state) ?>">B</a>&nbsp;&nbsp;
            <a href="./browse_artist.php?nav_row=0&letter=C&<?php echo($view_state) ?>">C</a>&nbsp;&nbsp;
            <a href="./browse_artist.php?nav_row=0&letter=D&<?php echo($view_state) ?>">D</a>&nbsp;&nbsp;
            <a href="./browse_artist.php?nav_row=0&letter=E&<?php echo($view_state) ?>">E</a>&nbsp;&nbsp;
            <a href="./browse_artist.php?nav_row=0&letter=F&<?php echo($view_state) ?>">F</a>&nbsp;&nbsp;
            <a href="./browse_artist.php?nav_row=0&letter=G&<?php echo($view_state) ?>">G</a>&nbsp;&nbsp;
            <a href="./browse_artist.php?nav_row=0&letter=H&<?php echo($view_state) ?>">H</a>&nbsp;&nbsp;
            <a href="./browse_artist.php?nav_row=0&letter=I&<?php echo($view_state) ?>">I</a>&nbsp;&nbsp;
            <a href="./browse_artist.php?nav_row=0&letter=J&<?php echo($view_state) ?>">J</a>&nbsp;&nbsp;
            <a href="./browse_artist.php?nav_row=0&letter=K&<?php echo($view_state) ?>">K</a>&nbsp;&nbsp;
            <a href="./browse_artist.php?nav_row=0&letter=L&<?php echo($view_state) ?>">L</a>&nbsp;&nbsp;
            <a href="./browse_artist.php?nav_row=0&letter=M&<?php echo($view_state) ?>">M</a>&nbsp;&nbsp;
            <a href="./browse_artist.php?nav_row=0&letter=N&<?php echo($view_state) ?>">N</a>&nbsp;&nbsp;
            <a href="./browse_artist.php?nav_row=0&letter=O&<?php echo($view_state) ?>">O</a>&nbsp;&nbsp;
            <a href="./browse_artist.php?nav_row=0&letter=P&<?php echo($view_state) ?>">P</a>&nbsp;&nbsp;
            <a href="./browse_artist.php?nav_row=0&letter=Q&<?php echo($view_state) ?>">Q</a>&nbsp;&nbsp;
            <a href="./browse_artist.php?nav_row=0&letter=R&<?php echo($view_state) ?>">R</a>&nbsp;&nbsp;
            <a href="./browse_artist.php?nav_row=0&letter=S&<?php echo($view_state) ?>">S</a>&nbsp;&nbsp;
            <a href="./browse_artist.php?nav_row=0&letter=T&<?php echo($view_state) ?>">T</a>&nbsp;&nbsp;
            <a href="./browse_artist.php?nav_row=0&letter=U&<?php echo($view_state) ?>">U</a>&nbsp;&nbsp;
            <a href="./browse_artist.php?nav_row=0&letter=V&<?php echo($view_state) ?>">V</a>&nbsp;&nbsp;
            <a href="./browse_artist.php?nav_row=0&letter=W&<?php echo($view_state) ?>">W</a>&nbsp;&nbsp;
            <a href="./browse_artist.php?nav_row=0&letter=X&<?php echo($view_state) ?>">X</a>&nbsp;&nbsp;
            <a href="./browse_artist.php?nav_row=0&letter=Y&<?php echo($view_state) ?>">Y</a>&nbsp;&nbsp;
            <a href="./browse_artist.php?nav_row=0&letter=Z&<?php echo($view_state) ?>">Z</a>&nbsp;&nbsp;
          </div>
          <br />
          <div style="text-align: center">
          
<?php

// including the navbar class
include_once("./php/navbar.php");
$nav = new navbar();

$sql = '';
if( $letter != 'T' )
{
	$sql = "SELECT DISTINCT artist.id, artist FROM artist INNER JOIN song ON artist_id=artist.id " .
		"WHERE artist like CONCAT('$letter', '%') AND song.file LIKE CONCAT('$filter', '%') " .
		"UNION " .
		"SELECT artist.id, SUBSTRING(artist.artist, 5, LENGTH(artist.artist) - 1) FROM artist INNER JOIN song ON artist_id=artist.id " .
		"WHERE artist like CONCAT('The ', '$letter', '%') AND song.file LIKE CONCAT('$filter', '%') ORDER BY artist";
}
else
{
	$sql = "SELECT DISTINCT artist.id, artist FROM  artist INNER JOIN song ON artist_id=artist.id " .
		"WHERE ((artist LIKE 'T%' AND artist NOT LIKE 'The %') OR (artist LIKE 'The T%')) " .
		"AND song.file LIKE CONCAT('$filter', '%') ORDER BY artist";
}

$nav->numrowsperpage = 25;
$result = $nav->execute($sql, $db, 'mysql'); 
echo '<br />';
?>
	<center>
	<table cellpadding="3">
	<tr>
		<th style="text-align: left">Artist</th>
		<th style="text-align: center">Songs</th>
		<th style="text-align: center">Albums</th>
	</tr>
<?php 
	while( $row = mysql_fetch_row( $result ) )
	{
		$aid = $row[0];
		// get counts
		$res = mysql_query("SELECT count(*) FROM song where artist_id=$aid", $db); 
		$r = mysql_fetch_row($res);
		$song_count = $r[0];
		
		$res = mysql_query("SELECT count(DISTINCT album_id) FROM song where artist_id=$aid", $db); 
		$r = mysql_fetch_row($res);
		$album_count = $r[0];
		
		echo("<tr>");
		echo("<td><a href=\"browse_artist_albums.php?aid=$aid&filter=$filters\">$row[1]</a></td>");
		echo("<td style=\"text-align: center\">$song_count</td>");
		echo("<td style=\"text-align: center\">$album_count</td>");
		echo("</tr>");
	}
	?>
	</table>
	</center>
	<br />
<?php
// display links
$links = $nav->getlinks("all", "on");
for ($y = 0; $y < count($links); $y++)
{
	echo $links[$y] . "&nbsp;&nbsp;";
}
mysql_close( $db );
				?>
 	</div>
    <br />
	<hr />	         
<?php
include("./module/bottom_toolbar.php");
include("./module/contact_info.php");
			    ?>
         <br />
<?php
include("./module/version.php");
			    ?>
         
	</div>
  </body>
</html>