<?php
session_start();
include_once("./config/config.php");
include_once("./php/functions.php");
$style = assert_login() ? $_SESSION['USER_STYLE'] : "./css/$style";
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title><?php echo($index_title); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="./favicon.png" />
<link rel="stylesheet" type="text/css" href="<?php echo($style) ?>" />
</head>

<body>
<div class="text_area">

<?php 
include("./module/login_greeting.php");
	?>

<div class="box" style="text-align: center">
<h1><?php echo($index_title);?></h1>
</div>

<?php
include("./module/top_toolbar.php");
	?>

<hr />
<?php
if(assert_login())
{
	include("./module/index_body.php");
}
else
{
	include("./module/deny_index_body.php");
}
	?>

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
