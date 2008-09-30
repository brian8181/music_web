<?php 
session_start();
include_once("./config/config.php");
include_once("./php/functions.php");
isset( $_SESSION['RETURN_PAGE'] ) ? $back = $_SESSION['RETURN_PAGE'] : $back = "./browse_artist.php";
$_SESSION['RETURN_PAGE'] = $_SERVER['REQUEST_URI'];
$style = assert_login() ? $_SESSION['USER_STYLE'] : "./css/$style";
		?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<!-- headers -->
	<head>
		<title>Artist Albums</title>
		<meta name="generator" content="Bluefish 1.0.7"/>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="<?php echo($style) ?>" />
		<style type="text/css">
			td.norepeat{background-repeat:no-repeat;}
			td#vdrop{
			background:url(./image/vdrop-20x1024.white.jpg); 
			background-repeat:no-repeat;
			}
			td#hdrop{
			background:url(./image/hdrop-1024x20.white.jpg); 
			background-repeat:no-repeat;
			}
			td#cdrop{
			background:url(./image/cdrop-20x20.white.jpg); 
			background-repeat:no-repeat;
			}
			td#lside{
			background:url(./image/lside-10x1024.white.jpg); 
			background-repeat:no-repeat;
			}
		</style> 	
	</head>
	<body>
		<div class="text_area">
<?php 
include("./module/login_greeting.php"); 
	?>
			<div class="box" style="text-align: center">
			<center>
				<h1>Artist Albums</h1>
			</center>
			</div>
			
<?php 
include("./module/top_toolbar.php"); 
	?>
			<br />
<?php
$aid = isset($_GET['aid']) ? $_GET['aid'] : null;
$filter = isset($_GET['filter']) ? $_GET['filter'] : null;

if($aid != null)
{
	$db = mysql_connect($db_address, $db_user_name, $db_password);
	mysql_select_db($db_name, $db) or die(mysql_errno() . ": " . mysql_error() . "<br>");
	if(isset($filter) && strlen($filter) > 0)
	{
		$filter = mysql_real_escape_string( $filter );
		$filter = "AND song.file LIKE '/$filter/%'";
	}
	else
	{
		$filter = "";
	}
	$sql = "SELECT DISTINCT album, art.file, album_id FROM song " . 
		"INNER JOIN album ON album_id=album.id " .
		"INNER JOIN artist ON artist_id=artist.id " . 
		"LEFT JOIN art ON art_id=art.id WHERE artist_id='$aid' $filter";
	//echo($sql);			
	$result = mysql_query($sql, $db);
	$row = mysql_fetch_row($result);
	//echo("<div align="center"><h3>$row[3]</h3></div>");
	?>
	<center><a href="<?php echo($back) ?>"><b>Back</b></a></center>
	<br />
	<table align="center">
	<?php
	while( $row )
	{
		$col = 1;
		?>
		<tr>
		<?php
		while( $row && ($col % 4) )
		{
			$album_id = $row[2];
            ?>
				<td>
					<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
					<tbody>
						<!-- <caption align=bottom>TODO</caption> -->
						<tr>
							<td id="lside" width="10">&nbsp;</td>
							<td>
							<a href="view_album.php?album_id=<?php echo( $album_id ) ?>&order_by=<?php echo( $default_order )?>">
							<img src="<?php echo( $art_location ) ?>/large/<?php echo($row[1]) ?>" 
							title=<?php echo("\"$row[0]\""); ?> 
							align="right" border="0" height="225" hspace="0" vspace="0" width="225" />
							</a>
							</td>
							<td id="vdrop" width="20">&nbsp;&nbsp;&nbsp;&nbsp;</td>
						</tr>
						<tr>
							<td width="10"></td>
							<td id="hdrop" height="20"></td>
							<td id="cdrop" height="20"></td>
						</tr>
					</tbody>
					</table>
				</td>
			<?php
			$row = mysql_fetch_row($result);
			$col++;
		} 
		?>
		</tr>
		<?php	
	} 
}  
	?>  
	</table>
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
