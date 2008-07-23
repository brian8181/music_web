<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

  <head>
    <title>Browse Artist</title>
    <meta name="generator" content="Bluefish 1.0.7"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="/css/main_web.css" />
  </head>
  <body>
	<div class="text_area">
		<?php include("./module/login_greeting.php"); ?>
          <br />
          <div class="box" style="text-align: center">
            <center>
              <h1>
                <em>Browse Artist</em>
              </h1>
            </center>
          </div>
          <br />
          <?php include("./module/top_toolbar.php"); ?>
          
          <br />
          <div align="center">
<?php
include_once("./config/config.php");

//get set variables
$letter   = isset($_GET['letter'])    ? $_GET['letter']   : null;
$row      = isset($_GET['row'])       ? $_GET['row']      : null;
$show_all  = isset($_GET['show_all']) ? $_GET['show_all'] : null;

$filter = "";
$filters = "";
$mysqli = new mysqli( $db_address, $db_user_name, $db_password, $db_name );
$letter = isset($letter) ? mysqli_real_escape_string($mysqli, $letter) : 'A';
$view_state = "show_all=false";

if(isset($show_all) && $show_all != "true") {
       	        ?>
                    <a href="/query/browse_artist.php?row=0&letter=<?php echo($letter) ?>&show_all=true">Full Albums</a>&nbsp;|&nbsp;
                    Show All<br /><br />
	<?php
}
else{
					?>
						Full Albums&nbsp;|&nbsp;
                    <a href="/query/browse_artist.php?row=0&letter=<?php echo($letter) ?>&show_all=false">Show All</a><br /><br />
	<?php
	$filter = "/albums/";
	$view_state = "show_all=true";
} 
			      ?>
            <a href="/query/browse_artist.php?row=0&letter=A&<?php echo($view_state) ?>">A</a>&nbsp;&nbsp;
            <a href="/query/browse_artist.php?row=0&letter=B&<?php echo($view_state) ?>">B</a>&nbsp;&nbsp;
            <a href="/query/browse_artist.php?row=0&letter=C&<?php echo($view_state) ?>">C</a>&nbsp;&nbsp;
            <a href="/query/browse_artist.php?row=0&letter=D&<?php echo($view_state) ?>">D</a>&nbsp;&nbsp;
            <a href="/query/browse_artist.php?row=0&letter=E&<?php echo($view_state) ?>">E</a>&nbsp;&nbsp;
            <a href="/query/browse_artist.php?row=0&letter=F&<?php echo($view_state) ?>">F</a>&nbsp;&nbsp;
            <a href="/query/browse_artist.php?row=0&letter=G&<?php echo($view_state) ?>">G</a>&nbsp;&nbsp;
            <a href="/query/browse_artist.php?row=0&letter=H&<?php echo($view_state) ?>">H</a>&nbsp;&nbsp;
            <a href="/query/browse_artist.php?row=0&letter=I&<?php echo($view_state) ?>">I</a>&nbsp;&nbsp;
            <a href="/query/browse_artist.php?row=0&letter=J&<?php echo($view_state) ?>">J</a>&nbsp;&nbsp;
            <a href="/query/browse_artist.php?row=0&letter=K&<?php echo($view_state) ?>">K</a>&nbsp;&nbsp;
            <a href="/query/browse_artist.php?row=0&letter=L&<?php echo($view_state) ?>">L</a>&nbsp;&nbsp;
            <a href="/query/browse_artist.php?row=0&letter=M&<?php echo($view_state) ?>">M</a>&nbsp;&nbsp;
            <a href="/query/browse_artist.php?row=0&letter=N&<?php echo($view_state) ?>">N</a>&nbsp;&nbsp;
            <a href="/query/browse_artist.php?row=0&letter=O&<?php echo($view_state) ?>">O</a>&nbsp;&nbsp;
            <a href="/query/browse_artist.php?row=0&letter=P&<?php echo($view_state) ?>">P</a>&nbsp;&nbsp;
            <a href="/query/browse_artist.php?row=0&letter=Q&<?php echo($view_state) ?>">Q</a>&nbsp;&nbsp;
            <a href="/query/browse_artist.php?row=0&letter=R&<?php echo($view_state) ?>">R</a>&nbsp;&nbsp;
            <a href="/query/browse_artist.php?row=0&letter=S&<?php echo($view_state) ?>">S</a>&nbsp;&nbsp;
            <a href="/query/browse_artist.php?row=0&letter=T&<?php echo($view_state) ?>">T</a>&nbsp;&nbsp;
            <a href="/query/browse_artist.php?row=0&letter=U&<?php echo($view_state) ?>">U</a>&nbsp;&nbsp;
            <a href="/query/browse_artist.php?row=0&letter=V&<?php echo($view_state) ?>">V</a>&nbsp;&nbsp;
            <a href="/query/browse_artist.php?row=0&letter=W&<?php echo($view_state) ?>">W</a>&nbsp;&nbsp;
            <a href="/query/browse_artist.php?row=0&letter=X&<?php echo($view_state) ?>">X</a>&nbsp;&nbsp;
            <a href="/query/browse_artist.php?row=0&letter=Y&<?php echo($view_state) ?>">Y</a>&nbsp;&nbsp;
            <a href="/query/browse_artist.php?row=0&letter=Z&<?php echo($view_state) ?>">Z</a>&nbsp;&nbsp;
          </div>
          <br />
          <span style="font-size: larger;">
            <div style="text-align: center">
<?php
// including the navbar class
include("./php/browse_functions.php");
$nav = new navbar;
$sql = "CALL get_artist_by_letter('$letter', '$filter');";
$mysqli->multi_query("SET NAMES 'utf8'");
//$res = $mysqli->multi_query($sql);
$nav->numrowsperpage = 20;
$res = $nav->execute($sql, $mysqli, "mysqli");
$rows = mysqli_affected_rows($mysqli);
for ($y = 0; $y < $rows; $y++) 
{
	//$data = mysql_fetch_object($result);
	$data = "TEST";
	//echo $data->url . "<br>\n";
}
echo("-0-");
echo("$sql<br />");
if( $res )
{
	echo("-1-");
	$results = 0;
	do {
		echo("-2-");
		if ($result = $mysqli->store_result())
		{
		echo("-3-");
			while( $row = $result->fetch_row() )
			{
			echo("-4-");
				echo("<a href=\"browse_artist_albums.php?aid=$row[0]&filter=$filters\">$row[1]</a><br />");
			}
			$result->close();
			if( $mysqli->more_results() ) echo "<br/>";
		}
	} while( $mysqli->next_result() );
}
echo "<hr>\n";
// didplay links
$links = $nav->getlinks("all", "on");
for ($y = 0; $y < count($links); $y++)
{
	echo $links[$y] . "&nbsp;&nbsp;";
}
$mysqli->close();
				?>
            </div>
          </span>
          <br />
         
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
