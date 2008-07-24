<?php
include_once("./config/config.php");
		?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

  <head>
    <title>Advanced Query Page</title>
    <link rel="stylesheet" type="text/css" href="./css/<?php echo($style); ?>" />
    <link rel="stylesheet" type="text/css" href="./css/query.css" />
  </head>

  <!-- Query html main body -->
  <body>
  <!-- Hit Counter -->
<?php
$db = mysql_connect($db_address, $db_user_name, $db_password);
mysql_query("INSERT INTO hitcount VALUES ( NULL, 'all_lyrics.php', NOW() )");
mysql_close( $db );5
		?>
	
	<?php include("./module/login_greeting.php"); ?>
		<br />

		<!-- Display Title -->
		<div class="box" style="text-align: center">
			<h1><em>Advanced Music Query</em></h1>
		</div>

		<!-- Navagation Bar -->
		<br />
		<?php include("./module/top_toolbar.php"); ?>
		<hr>
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
include("./module/bottom_toolbar.php");
include("./module/contact_info.php");
		?>
		<br />
<?php
		include("./module/version.php");
		?>
	</body>
</html>

