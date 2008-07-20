<?php
$ROOT = $_SERVER['DOCUMENT_ROOT'];
include("../php/sec_user.php");
include("../php/validate_login.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <!-- headers -->
  <head>
    <title>Title Here!</title>
    <meta name="generator" content="Bluefish 1.0.7"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php 
//$ROOT = $_SERVER['DOCUMENT_ROOT'];
//include("$ROOT/php/set_style.php"); 
		?>
	</head>
	<body>
		<!-- Start - Whole Page Table -->
		<center>
		<table width="100%"><tr><td>
			<div class="box" style="text-align: center">
			<center>
				<h1><em>Edit Song Lyrics</em></h1>
			</center>
			</div>
			<br />	
			<!-- Navagation Bar -->
			<?php include("../module/top_toolbar.php"); ?>
			<!-- ######################### START BODY ###################################### -->
				<!-- Main Section -->
				<center>
			<form action="entry.php" method="get">
				<!-- Main Section -->
				<h2><em></em></h2>
				<div align="center">
					<textarea name="quote" rows="20" cols="40"></textarea><br /><br />
				</div>
				<input type="submit" />
			</form>
			</center>
			<!-- ######################### END BODY ######################################## -->
<?php
include("../module/bottom_toolbar.php");
include("../module/contact_info.php");
			?>
			<br />
			<!-- verison info -->
			<em>
			Version 1.0.0.1 Sat Sep  8 11:23:37 CDT 2007 ~( Copyright © by Brian Preston (2007) )
			</em>
		</td></tr></table>
		</center>
	</body>
</html>
