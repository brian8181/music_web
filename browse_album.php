<?php
	//If Not Logged In Goto Login Page 
	//session_start(); 
	//if( !isset( $_SESSION['_USER'] ) )
	//{
	//	$_SESSION['page'] = $PHP_SELF;
		//header( "Location: /login.php" );
	//}
	//else if( !isset( $_SESSION['groups']['user'] ) )
	//{
		//echo( "<div style=\"text-align: center\"><h3>Sorry, your are not authorized to access the page.</h3></div>" );	
		//echo( "<div style=\"text-align: center\"><a href=\"/index.php\"><i>www.bkp-online.com</i></a></div>" );
	//}
	//else
	{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<!-- headers -->
	<head>
		<title>Browse Artist</title>
		<meta name="generator" content="Bluefish 1.0.7"/>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="/css/main_web.css" />
	</head>
	<body>
		<!-- Start - Whole Page Table -->
		<center>
		<table class="Main" width="100%"><tr>
		<?php include("../module/login_greeting.php"); ?>
		<br />
			<div class="box" style="text-align: center">
			<center>
				<h1><em>Browse Album</em></h1>
			</center>
			</div>
			<br />	
			<!-- Navagation Bar -->
			<?php include("../module/top_toolbar.php"); ?>
			<!-- ######################### START BODY ###################################### -->
			<br />
			<div align="center">
			<?php
			$filter = "";
			$filters = "";
			if(isset($show_all) && $show_all != "false")
			{
				?>
					<a href="/query/browse_album.php?row=0&letter=A&show_all=false">Full Albums</a>&nbsp;|&nbsp;
					Show All<br /><br />
				<?php
			}
			else
			{
				?>
					Full Albums&nbsp;|&nbsp;
					<a href="/query/browse_album.php?row=0&letter=A&show_all=true">Show All</a><br /><br />
				<?php
				$filters = "albums"; 
				$filter = "AND song.file LIKE '/albums/%'";	
			} 
			?>
			<a href="/query/browse_album.php?row=0&letter=A">A</a>&nbsp;&nbsp;
			<a href="/query/browse_album.php?row=0&letter=B">B</a>&nbsp;&nbsp;
			<a href="/query/browse_album.php?row=0&letter=C">C</a>&nbsp;&nbsp;
			<a href="/query/browse_album.php?row=0&letter=D">D</a>&nbsp;&nbsp;
			<a href="/query/browse_album.php?row=0&letter=E">E</a>&nbsp;&nbsp;
			<a href="/query/browse_album.php?row=0&letter=F">F</a>&nbsp;&nbsp;
			<a href="/query/browse_album.php?row=0&letter=G">G</a>&nbsp;&nbsp;
			<a href="/query/browse_album.php?row=0&letter=H">H</a>&nbsp;&nbsp;
			<a href="/query/browse_album.php?row=0&letter=I">I</a>&nbsp;&nbsp;
			<a href="/query/browse_album.php?row=0&letter=J">J</a>&nbsp;&nbsp;
			<a href="/query/browse_album.php?row=0&letter=K">K</a>&nbsp;&nbsp;
			<a href="/query/browse_album.php?row=0&letter=L">L</a>&nbsp;&nbsp;
			<a href="/query/browse_album.php?row=0&letter=M">M</a>&nbsp;&nbsp;
			<a href="/query/browse_album.php?row=0&letter=N">N</a>&nbsp;&nbsp;
			<a href="/query/browse_album.php?row=0&letter=O">O</a>&nbsp;&nbsp;
			<a href="/query/browse_album.php?row=0&letter=P">P</a>&nbsp;&nbsp;
			<a href="/query/browse_album.php?row=0&letter=Q">Q</a>&nbsp;&nbsp;
			<a href="/query/browse_album.php?row=0&letter=R">R</a>&nbsp;&nbsp;
			<a href="/query/browse_album.php?row=0&letter=S">S</a>&nbsp;&nbsp;
			<a href="/query/browse_album.php?row=0&letter=T">T</a>&nbsp;&nbsp;
			<a href="/query/browse_album.php?row=0&letter=U">U</a>&nbsp;&nbsp;
			<a href="/query/browse_album.php?row=0&letter=V">V</a>&nbsp;&nbsp;
			<a href="/query/browse_album.php?row=0&letter=W">W</a>&nbsp;&nbsp;
			<a href="/query/browse_album.php?row=0&letter=X">X</a>&nbsp;&nbsp;
			<a href="/query/browse_album.php?row=0&letter=Y">Y</a>&nbsp;&nbsp;
			<a href="/query/browse_album.php?row=0&letter=Z">Z</a>&nbsp;&nbsp;
			</div>
			<br />
			<span style="font-size: larger;">
			<div style="text-align: center">
			<?php
				$db = mysql_connect("127.0.0.1", "web", "sas*.0125");
				mysql_select_db("music", $db) or die(mysql_errno() . ": " . mysql_error() . "<br>");
				$letter = isset($letter) ? mysql_real_escape_string( $letter ) : 'A';
				//$sql = "SELECT DISTINCT artist.id, artist.artist FROM song " .
				 //"INNER JOIN artist ON artist_id=artist.id " . 
				 //"WHERE NOT album_id IS NULL AND artist.artist LIKE '$letter%' $filter ORDER BY artist.artist";
				$sql = call get_artist_by_letter('$letter');
				//echo($sql);
				$result = mysql_query($sql, $db);
				while( $row = mysql_fetch_row($result) )
				{
					echo("<a href=\"browse_album_album.php?aid=$row[0]&filter=$filters\">$row[1]</a><br />");
				}
			?>					
			</div>
			</span>
			<br />
			<!-- ######################### END BODY ######################################## -->
			<?php
				include("../module/bottom_toolbar.php");
				include("../module/contact_info.php");
			?>
			<br />
			<em>
			Version 1.0.0.1 Sat Sep  8 11:23:37 CDT 2007 ~( Copyright © by Brian Preston (2007) )
			</em>
		</td></tr></table>
		</center>
	</body>
</html>
<?php
	}
?>
