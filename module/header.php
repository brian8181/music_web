<?php
include_once("./php/functions.php");
// open header
function open_page($title)
{
	global $enable_security, $enable_advanced, $enable_browse;
	global $enable_playlist, $enable_statistics, $enable_security;
		
	session_start();
	$style = "style.css";
	$style = assert_login() ? $_SESSION['USER_STYLE'] : "./css/$style";
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<?php echo("<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">"); ?>
	<head>
		<title><?php echo($title); ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="shortcut icon" href="./favicon.png" />
		<link rel="stylesheet" type="text/css" href="<?php echo($style) ?>" />
		<script src="./script/functions.js" type="text/javascript"></script>
	</head>
	<?php
	echo("<body>");
	echo("<div class=\"text_area\">");
	include("./module/login_greeting.php");
	echo(
		"<div class=\"box\" style=\"text-align: center\">
			<h1>$title</h1>
		</div>"
	);
	include("top_toolbar.php");
}
?>	
