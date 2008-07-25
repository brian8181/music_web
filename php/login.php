<?php
include_once("../php/functions.php");
include_once("../tools/kill.php"); // kill previuos sessions
session_start();
if( !isset( $_SESSION['_USER'] ) || !isset( $_SESSION['_GROUPS'] ) )
{
	$user = null;
	$pass = null;
	if( isset($_GET['_USER']) && isset($_GET['_PASSWORD']) ) 
	{
		$user = $_GET['_USER'];
		$pass = $_GET['_PASSWORD'];
		if( validate_pass( $pass ) ) //BKP: move to java?
		{
			$db = mysql_connect('bkp-online.homelinux.org', 'brian', 'sas*0125');
			mysql_select_db('web_admin', $db);
			$sql = "SELECT user.id, `user`, `group`, `password` FROM `user` " . 
				"INNER JOIN `user_group` ON `user`.id=`user_id` " . 
				"INNER JOIN `group` ON `user_group`.`group_id`=`group`.id " . 
				"WHERE user='$user' AND password='$pass'";
			$result = mysql_query( $sql, $db );
			if( mysql_num_rows($result) )
			{
				$_groups = array();
				$row = mysql_fetch_row($result);
				$_SESSION['_USER_ID'] = $row[0]; do{
					$grp = $row[2];
					$groups[$grp] = 1;
				}while( $row = mysql_fetch_row($result) );
				$_SESSION['_USER'] = $user;
				$_SESSION['_GROUPS'] = $groups;
				if( isset($_SESSION['_PAGE']) ) {
					$page = $_SESSION['_PAGE'];
					header( "Location: $_page" ); } else {
					header( "Location: index.php" ); } } else {
				$message = "<b>No matching user / password</b>"; }
			mysql_close($db); } else {
			$message = "<b>Invalid user or password.</b>"; }} else {
		$message = "<b>Please enter user & password.</b>";} } else {
	header( "Location: index.php" ); }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>User Login</title>
	<meta name="generator" content="Bluefish 1.0.7" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="frm_style.css" />
	<script src="/script/cookies.js" type="text/javascript"></script>
	<script type="text/javascript">
		function on_submit(form) // intialize all values
		{
			var save = form.elements['_SAVE'].checked;
			if(save != false)
			{
				var user = form.elements['_USER'].value;
				var auth = form.elements['_PASSWORD'].value;
				setCookie('user', user, 30);
				setCookie('auth', auth, 30);
			}
			else
			{
				delete cookie;
				deleteCookie('_USER');
				deleteCookie('_AUTH');
			}
		}
	</script>
</head>
<body>
	<form action="login.php" method="get" name="login_frm" onsubmit="on_submit(login_frm)">
			<fieldset>
			<legend>User Login:</legend>
			<p><label for="user">User</label><input type="text" name="_USER" value="<?php if (isset($user)) { echo $user; } ?>" /></p>
			<p><label for="password">Password</label><input type="password" name="_PASSWORD" value="<?php if (isset($password)) { echo $password; } ?>" /></p>
			<p><label for="save">Save</label><input type="checkbox" name="_SAVE" /></p>
			<p class="submit"><input type="submit" value="Submit" /></p>
			<p><label for="msg">
			<?php if( isset($message) ) echo("<div align=\"center\"><em>$message</em></div>"); ?>
			</label>
			</p>
			</fieldset>
			<script type="text/javascript">
				var user = checkUser('user');
				var auth = checkAuth('auth');
				if(user != null && auth != null)
				{
					// fill text boxes
					document.forms[0].elements['_USER'].value = user;
					document.forms[0].elements['_PASSWORD'].value = auth;
					document.forms[0].elements['_SAVE'].checked = true;
				}
			</script>
	</form>
</body>
</html>