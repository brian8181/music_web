<?php
session_start();
include_once("./config/config.php");
include_once("./php/functions.php");
if( !isset( $_SESSION['_USER'] ) || !isset( $_SESSION['_GROUPS'] ) )
{
	$user = null;
	$pass = null;
	if( isset($_GET['_USER']) && isset($_GET['_PASSWORD']) ) 
	{
		$user = $_GET['_USER'];
		$pass = $_GET['_PASSWORD'];
		$db = mysql_connect($db_address, $db_user_name, $db_password);
		mysql_select_db($db_name, $db);
		
		if( set_session($user, $pass, $db ) )
		{
			if( isset($_SESSION['_PAGE']) )
			{
				$page = $_SESSION['_PAGE'];
				header( "Location: $page" ); 
			} 
			else 
			{
				header( "Location: ./index.php" ); 
			} 
			mysql_select_db($db_name, $db);
			mysql_query( "INSERT INTO login (user_id) VALUES( $id )", $db );
		} 
		else 
		{
			$message = "<b>No matching user / password</b>"; 
		}
		mysql_close($db); 
	} 
	else 
	{
		$message = "<b>Please enter user & password.</b>";
	} 
} 
else 
{
	header( "Location: ./index.php" ); 
}
$style = assert_login() ? $_SESSION['USER_STYLE'] : "./css/$style";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>User Login</title>
	<meta name="generator" content="Bluefish 1.0.7" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="<?php echo($style) ?>" />
	<script src="./script/cookies.js" type="text/javascript"></script>
	<script type="text/javascript">
		function on_submit(form) // intialize all values
		{
			var save = form.elements['_SAVE'].checked;
			if(save != false)
			{
				var user = form.elements['_USER'].value;
				var auth = form.elements['_PASSWORD'].value;
				setCookie('user', user, 30);
				setCookie('pass', auth, 30);
			}
			else
			{
				delete cookie;
				deleteCookie('user');
				deleteCookie('pass');
			}
		}
	</script>
	<style type="text/css">
	body 
	{
		margin-left:30%;
		margin-right:30%;
	}
	</style>
</head>
<body>
	<div class="text_area">
	<img src="./image/home.gif" alt="user" />
	<a href="./index.php"><b>Home</b></a>
	<div class="box" style="text-align: center">
		<h1>Login</h1>
	</div>
	<center>
	<form action="login.php" method="get" name="login_frm" onsubmit="on_submit(login_frm)">
			<fieldset>
			<legend>User Login:</legend>
			<table>
				<tr><td><label for="user">User:&nbsp;&nbsp;</label></td><td><input type="text" name="_USER" value="<?php if (isset($user)) { echo $user; } ?>" /></td></tr>
				<tr><td><label for="password">Password:&nbsp;&nbsp;</label></td><td><input type="password" name="_PASSWORD" value="<?php if (isset($pass)) { echo $pass; } ?>" /></td></tr>
				<tr><td><label for="save">Save:&nbsp;&nbsp;</label></td><td><input type="checkbox" name="_SAVE" /></td></tr>
				<tr><td>&nbsp;</td><td><input type="submit" value="Submit" /></td></tr>
				<tr><td colspan="2" ><label for="msg"><?php if( isset($message) ) echo("<div align=\"center\"><em>$message</em></div>"); ?></label></td></tr>
			</table>
			</fieldset>
			<script type="text/javascript">
				var user = checkUser('user');
				var auth = checkAuth('pass');
				if(user != null && auth != null)
				{
					// fill text boxes
					document.forms[0].elements['_USER'].value = user;
					document.forms[0].elements['_PASSWORD'].value = pass;
					document.forms[0].elements['_SAVE'].checked = true;
				}
			</script>
	</form>
	</center>
	</div>
</body>
</html>
