<?php 
session_start();
include_once("./config/config.php");
			?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Create Account</title>
		<meta name="generator" content="Bluefish 1.0.7"/>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="./css/<?php echo($style); ?>" />
	</head>
	<body>
	<div class="text_area">
	<img src="./image/home.gif" alt="user" />
	<a href="./index.php"><b>Home</b></a>
			<div class="box" style="text-align: center">
			<h1>Create Account</h1>
			</div>
			<br />	
			<hr />
			<center>
			<form action="create_account.php" method="get">
				<input type="hidden" name="submitted" value="true"/>
				<table cellpadding="3">
				<tr>
					<td>User:&nbsp;</td>
					<td><input type="text" name="user_name" value="<?php if (isset($user_name)) { echo $user_name; } ?>" /></td>
				</tr>
				<tr>
					<td>Password:&nbsp;</td>
					<td><input type="password" name="password" value="<?php if (isset($password)) { echo $password; } ?>" /></td>
				</tr>
				<tr>
					<td>Retype:&nbsp;</td>
					<td><input type="password" name="password2" value="<?php if (isset($password2)) { echo $password2; } ?>" /></td>
				</tr>
				<tr>
					<td>Full Name:&nbsp;</td>
					<td><input type="text" name="full_name" value="<?php if (isset($full_name)) { echo $full_name; } ?>" /></td>
				</tr>
				<tr>
					<td>Email:&nbsp;</td>
					<td><input type="text" name="email" value="<?php if (isset($email)) { echo $email; } ?>" /></td>
				</tr>
				</table>
				<input type="submit" value="Create" />			
			</form>
			<h3>
<?php
include("./php/functions.php");
include("./admin/functions.php");

$user_name  = isset($_GET['user_name']) ? $_GET['user_name'] : null;
$password   = isset($_GET['password'])  ? $_GET['password']  : null;
$password2  = isset($_GET['password2']) ? $_GET['password2'] : null;
$full_name  = isset($_GET['full_name']) ? $_GET['full_name'] : null;
$email      = isset($_GET['email'])     ? $_GET['email']     : null;

if( !empty($user_name) && !empty($password) && !empty($password2) && !empty($full_name) && !empty($email) )
{
	// TODO! validate user, password, email for length spaces & invalid chars
	if( $password == $password2 )
	{
		if( validate_pass( $password ) )
		{
			$db = mysql_connect($admin_db_address, $admin_db_user_name, $admin_db_password);
			mysql_select_db($admin_db_name, $db);
			mysql_query("SET NAMES 'utf8'");
			
			if( !ip_blocked( 'CREATE', $db ) )
			{
				$user_name = mysql_real_escape_string($user_name);
				$password = mysql_real_escape_string($password);
				$full_name = mysql_real_escape_string($full_name);
				$email = mysql_real_escape_string($email);
				// make sure user dose not exsit
				$result = get_user( $user_name, $db );
				if($result)
				{
					echo( "Account already exists, please choose another user name." );
				}
				else
				{
					if(create_account( $user_name, $password, $full_name, $email, $db ))
					{
						echo( "Account created for $full_name ($user_name)" );
					}
					else
					{
						echo( "Sorry account could not be created. (unknown Error)." );
					}
				}
				mysql_close($db);
			}
			else
			{
				// ip blocked (do not give any real reason here!)
				echo( "Sorry account could not be created. (unknown Error)." );	
			}
		}
		else
		{
			echo( "Password must be at least 7 characters and be both letters and numbers." );
		}
	}
	else
	{
		echo( "Passwords do not match." );
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
