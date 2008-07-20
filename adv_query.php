//<script type="text/php" language="php">
//session_start(); 

//$groups_loc = $_SESSION['groups']; 
//$user_loc = $_SESSION['user'];

//if( isset($user_loc) && isset($groups_loc) )
//{
	//$groups_loc = $_SESSION['groups']; 
	//if(!array_key_exists('user', $groups_loc))
	//{
	//	echo( "<div style=\"text-align: center\"><h3>Sorry, your are not authorized to access the page.</h3></div>" );	
	//	echo( "<div style=\"text-align: center\"><a href=\"/index.php\"><i>...</i></a></div>" );
	//	exit();
	//}
	
//}
//else
//{
	//$_SESSION['page'] = $PHP_SELF;
	//header( "Location: /login.php" );
	//exit();
//}
//</script>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <!-- Headers -->
  <head>
    <title>Advanced Query Page</title>
    <link rel="stylesheet" type="text/css" href="/css/main_web.css" />
    <link rel="stylesheet" type="text/css" href="/css/query.css" />
  </head>

  <!-- Query html main body -->
  <body>
    <!-- Hit Counter -->
<?php
$db = mysql_connect("127.0.0.1", "web", "sas*.0125", "music");
mysql_query("INSERT INTO hitcount VALUES ( NULL, 'all_lyrics.php', NOW() )");
mysql_close( $db );5
		?>
		
		<!-- PAGE TABLE -->
		<table class="Main"><tr><td>
		<?php include("../module/login_greeting.php"); ?>
		<br />

		<!-- Display Title -->
		<div class="box" style="text-align: center">
			<h1><em>Music Query</em></h1>
		</div>

		<!-- Navagation Bar -->
		<br />
		<?php include("../module/limited_top_toolbar.php"); ?>
		<hr>
		<a class="Logo" href="http://www.mysql.com">
			<img src="../image/mysql_100x52-64.gif" width="100" height="52" alt="" />
		</a>&nbsp;<sub><em>powered</em></sub>
		<br />
		<center>
		<form action="results.php" method="get">
			<table>
				<tr>
					<td>Artist:&nbsp;</td>
					<td><input type="text" name="artist" /></td>
				</tr>
				<tr>
					<td>Album:&nbsp;</td>
					<td><input type="text" name="album" /></td>
				</tr>
				<tr>
					<td>Title:&nbsp;</td>
					<td><input type="text" name="title" /></td>
				</tr>
				<tr>
					<td>Genre:&nbsp;</td>
					<td><input type="text" name="genre" /></td>
				</tr>
				<tr>
					<td>Year:&nbsp;</td>
					<td><input type="text" name="year" /></td>
				</tr>
				<tr>
					<td>File:&nbsp;</td>
					<td><input type="text" name="file" /></td>
				</tr>
				<tr>
					<td>Comments:&nbsp;</td>
					<td><input type="text" name="comments" /></td>
				</tr>
				<tr>
					<td>Lyrics:&nbsp;</td>
					<td><input type="text" name="lyrics" /></td>
				</tr>
				<tr>
					<td colspan="2">
						<br />
						<div align="center">
						<fieldset>
							All&nbsp;<input type="radio" name="and" value="true" checked="yes" />
							Any&nbsp;<input type="radio" name="and" value="false" />
						</fieldset>
						</div>
					</td>
				</tr>
			</table>
			<br />
			<input type="submit" />&nbsp;
			Use&nbsp;wildcards:
			<input name="wildcard" type="checkbox" value="on" <?php if (isset($wildcard)) { echo " CHECKED"; } ?><br /><br />
		</form>
		</center>

		<hr>
		<!-- Navagation Bar -->
<?php
include("../module/bottom_toolbar.php");
include("../module/contact_info.php");
		?>
		<br />
		<span style="font-size: smaller;">
			<em>Version 1.5.0.1 Sat Sep  8 11:23:37 CDT 2007 ~( Copyright © by Brian Preston (2007) )</em>
		</span>
		
		</td></tr></table>
	</body>
</html>

