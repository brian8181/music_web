<?php
session_start();
include_once("./config/config.php");
include_once("./php/functions.php");
$style = assert_login() ? $_SESSION['USER_STYLE'] : "./css/$style";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en"
	lang="en">
<!-- headers -->
<head>
<title>Song Lyrics</title>
<meta name="generator" content="Bluefish 1.0.7" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="<?php echo($style) ?>" />
</head>
<body>
<div class="text_area"><?php include("./module/login_greeting.php"); ?>

<div class="box" style="text-align: center">
<center>
<h1>Song Lyrics</h1>
</center>
</div>
<br />

<?php
include("./module/top_toolbar.php");
	?>

<?php
$db = mysql_connect($db_address, $db_user_name, $db_password);
mysql_select_db($db_name, $db);
mysql_query("SET NAMES 'utf8'");
/// get song id
$sid = isset($_GET['sid']) ? $_GET['sid'] : null;
	?>

<center>
<?php
if( isset( $sid ) )
{
	$sql = "SELECT title, lyrics from song WHERE song.id=$sid";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result, MYSQL_NUM);
	$title = $row[0];
	echo("<h2>$title</h2>");
	$lyrics = $row[1];
	$lyrics = str_replace( "\r\n", "<br />", $lyrics);
	echo( $lyrics );
	mysql_close($db);
}
	?>
</center>
<?php
include("./module/footer.php");
	?>
</div>
</body>
</html>
