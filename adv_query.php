<?php
include_once("./config/config.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
<title>Advanced Query Page</title>
<link rel="stylesheet" type="text/css" href="./css/<?php echo($style); ?>" />
</head>
<body>
<div class="text_area"><?php 
include("./module/login_greeting.php");
?> <br />

<!-- Display Title -->
<div class="box" style="text-align: center">
<h1><em>Advanced Music Query</em></h1>
</div>

<!-- Navagation Bar --> <br />
<?php
$enable_quick_search = false;
include("./module/top_toolbar.php");
?>

<hr />
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
		<td colspan="2"><br />
		<div align="center">
		<fieldset>All&nbsp;<input type="radio" name="and" value="true"
			checked="checked" /> Any&nbsp;<input type="radio" name="and"
			value="false" /></fieldset>
		</div>
		</td>
	</tr>
</table>
<br />
<input type="submit" />&nbsp; Use&nbsp;wildcards: <input name="wildcard"
	type="checkbox" value="on"
	<?php if (isset($wildcard)) { echo " CHECKED"; } ?> /><br />
<br />
</form>
</center>

<hr />

	<?php
	include("./module/bottom_toolbar.php");
	include("./module/contact_info.php");
	?> <br />
	<?php
	include("./module/version.php");
	?></div>
</body>
</html>