<?php
session_start();
include_once("./config/config.php");
include("./admin/functions.php");
include("./php/functions.php");
if(assert_login() == false)
{
	exit();
}

$style = assert_login() ? $_SESSION['USER_STYLE'] : "./css/$style";
$db = mysql_connect($db_address, $db_user_name, $db_password);
mysql_select_db($db_name, $db);
mysql_query("SET NAMES 'utf8'");

$user_id = $_SESSION['_USER_ID'];
$user_name = $_SESSION['_USER'];
$password   = $_SESSION['USER_PASSWORD'];
$full_name  = $_SESSION['USER_FULLNAME'];
$user_email = $_SESSION['USER_EMAIL'];
$style_id  = $_SESSION['USER_STYLE_ID'];
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>My Account</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="<?php echo($style) ?>" />
	</head>
	<body>
	<div class="text_area">
	<img src="./image/home.gif" alt="user" />
	<a href="./index.php"><b>Home</b></a>
			<div class="box" style="text-align: center">
				<h1>My Account</h1>
			</div>
			<br />	
			<hr />
			<center>
			<form action="update_account.php" method="get">
				<input type="hidden" name="submitted" value="true"/>
				<table cellpadding="3">
				<tr>
					<td>User:&nbsp;</td><td><b><?php echo $user_name; ?></b></td>
				</tr>
				<tr>
					<td>Password:&nbsp;</td>
					<td><input type="password" name="original" value="<?php echo($password); ?>" /></td>
				</tr>
				<tr>
					<td>New Password:&nbsp;</td>
					<td><input type="password" name="password" /></td>
				</tr>
				<tr>
					<td>Retype:&nbsp;</td>
					<td><input type="password" name="password2" /></td>
				</tr>
				<tr>
					<td>Full Name:&nbsp;</td>
					<td><input type="text" name="full_name" value="<?php echo($full_name); ?>" /></td>
				</tr>
				<tr>
					<td>Email:&nbsp;</td>
					<td><input type="text" name="email" value="<?php echo($user_email); ?>" /></td>
				</tr>
				<tr>
					<td>Custom Style Setting:&nbsp;</td>
					<td>
					<select name="style_id" size="0">
						<?php
							$result = mysql_query("SELECT `id`, `style` FROM `style`", $db);
							while( $row = mysql_fetch_assoc($result) )
							{
								$id = $row['id'];
								$style = $row['style'];
								echo("<option value=\"$id\">$style</option>");
							}
						?>
					</select>
					</td>
				</tr>
				</table>
				<input type="submit" value="Update" />			
			</form>
			<h3>
<?php

if( !empty($user_name) && !empty($password) && !empty($password2) && !empty($full_name) && !empty($email) )
{
	$original    = isset($_GET['$$original']) ? $_GET['$original']  : null;
	$password   = isset($_GET['password'])  ? $_GET['password']  : null;
	$password2  = isset($_GET['password2']) ? $_GET['password2'] : null;
	$full_name  = isset($_GET['full_name']) ? $_GET['full_name'] : null;
	$user_email = isset($_GET['user_email']) ? $_GET['user_email']     : null;
	$style_id  = isset($_GET['style_id']) ? $_GET['style_id'] : null;
	
	// TODO! validate user, password, email for length spaces & invalid chars
	if( $password == $password2 )
	{
		if( validate_pass( $password ) )
		{
			$user_name = mysql_real_escape_string($user_name);
			$password = mysql_real_escape_string($password);
			$full_name = mysql_real_escape_string($full_name);
			$email = mysql_real_escape_string($email);
			// make sure user dose not exsit
			if(update_account( $user_name, $password, $full_name, $email, $style_id, $db ))
			{
				echo( "Account updated for $full_name ($user_name)" );
			}
			else
			{
				echo( "Sorry account could not be updated plesae try agion later (unknown Error)." );
			}	
			mysql_close($db);
		}
		else
		{
			echo( "Password must be at least 7 characters and be both letters and numbers." );
		}
	}
	else
	{
		echo( "Password do not match." );
	}
}
else
{
	if(isset($submitted))
		echo( "Invalid or missing fields" );
	else
		echo( "Please provide this information." );	
}
			?>
			</h3>
			</center>
			<hr />
			<br />
<?php
include("./module/version.php");
			?>
		</div>
	</body>
</html>
