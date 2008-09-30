<?php
session_start();
include_once("./config/config.php");
include_once("./php/functions.php");
$_SESSION['RETURN_PAGE'] = $_SERVER['REQUEST_URI'];
$_SESSION['SEARCH_PAGE'] = $_SESSION['RETURN_QUERY'];
$logged_in = assert_login();
$last_query = isset($_SESSION['RETURN_QUERY']) ? $_SESSION['RETURN_QUERY'] : null;
if($last_query != null)
{
	parse_str($last_query);
}
$style = $logged_in ? $_SESSION['USER_STYLE'] : "./css/$style";
	?>	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title><?php echo($advanced_title) ?></title>
<link rel="stylesheet" type="text/css" href="<?php echo($style) ?>" />
</head>
<body>

<div class="text_area">
<?php 
include("./module/login_greeting.php");
	?> 
<div class="box" style="text-align: center">
	<h1><?php echo($advanced_title) ?></h1>
</div>

<?php
$enable_quick_search = false;
include("./module/top_toolbar.php");
	?>
<center>
<form action="results.php" method="get">
<table>
	<tr>
		<td>Artist:&nbsp;</td>
		<td><input type="text" name="artist" value="<?php if( isset($artist) ) echo($artist); ?>" /></td>
	</tr>
	<tr>
		<td>Album:&nbsp;</td>
		<td><input type="text" name="album" value="<?php if( isset($album) ) echo($album); ?>" /></td>
	</tr>
	<tr>
		<td>Title:&nbsp;</td>
		<td><input type="text" name="title" value="<?php if( isset($title) ) echo($title); ?>" /></td>
	</tr>
	<tr>
		<td>Genre:&nbsp;</td>
		<td><input type="text" name="genre" value="<?php if( isset($genre) ) echo($genre); ?>" /></td>
	</tr>
	<tr>
		<td>Year:&nbsp;</td>
		<td><input type="text" name="year" value="<?php if( isset($year) ) echo($year); ?>" /></td>
	</tr>
	<tr>
		<td>File:&nbsp;</td>
		<td><input type="text" name="file" value="<?php if( isset($file) ) echo($file); ?>" /></td>
	</tr>
	<tr>
		<td>Comments:&nbsp;</td>
		<td><input type="text" name="comments" value="<?php if( isset($comments) ) echo($comments); ?>" /></td>
	</tr>
	<tr>
		<td>Lyrics:&nbsp;</td>
		<td><input type="text" name="lyrics" value="<?php if( isset($lyrics) ) echo($lyrics); ?>" /></td>
	</tr>
	<tr>
		<td colspan="2"><br />
		<div align="center">
		<fieldset>
		<legend>Boolean Modifier</legend>
			All&nbsp;<i>(AND)</i>&nbsp;<input type="radio" name="and" value="true" 
			<?php if( !isset($and) || $and=="true" ) echo("checked=\"checked\""); ?> />
			Any<i>&nbsp;(OR)</i>&nbsp;<input type="radio" name="and" value="false" 
			<?php if( isset($and) && $and=="false" ) echo("checked=\"checked\""); ?> />
		</fieldset>
		</div>
		</td>
	</tr>
</table>
<br />
<input type="submit" value="Search" />&nbsp; Use&nbsp;wildcards: <input name="wildcard" type="checkbox" value="on" 
<?php if( isset($wildcard) ) echo("checked=\"checked\""); ?> /><br />
</form>
</center>
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