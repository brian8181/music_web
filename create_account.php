<?php 
session_start();
include_once("./config/config.php");
include("./php/functions.php");
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Create User</title>
		<meta name="generator" content="Bluefish 1.0.7"/>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="<?php echo("./css/$style") ?>" />
		<script type="text/javascript">
			function on_submit(form)  // intialize all values
			{
				// todo
			}
		</script>
	</head>
	<body>
	<div class="text_area">
	<img src="./image/home.gif" alt="user" />
	<a href="./index.php"><b>Home</b></a>
			<div class="box" style="text-align: center">
			<h1>Create User</h1>
			</div>
			<br />	
			<hr />
			<center>
			<form name="create_form" action="create_account.php" method="get" onsubmit="on_submit(create_form)">
				<input type="hidden" name="submitted" value="true"/>
				<table cellpadding="3">
				<tr>
					<td>User:&nbsp;</td>
					<td><input type="text" name="user_name" /></td>
				</tr>
				<tr>
					<td>Password:&nbsp;</td>
					<td><input type="password" name="password" /></td>
				</tr>
				<tr>
					<td>Retype:&nbsp;</td>
					<td><input type="password" name="password2" /></td>
				</tr>
				<tr>
					<td>Full Name:&nbsp;</td>
					<td><input type="text" name="full_name" /></td>
				</tr>
				<tr>
					<td>Email:&nbsp;</td>
					<td><input type="text" name="email" /></td>
				</tr>
				<tr>
					<td>Security Question:&nbsp;</td>
					<td>
					<select name="listOption" size="0">
						<?php
							$db = mysql_connect($db_address, $db_user_name, $db_password);
							mysql_select_db($db_name, $db);
							mysql_query("SET NAMES 'utf8'");
							$result = mysql_query("SELECT id, question FROM security_question WHERE `default`=TRUE", $db);
							while( $row = mysql_fetch_assoc($result) )
							{
								$id = $row['id'];
								$question = $row['question'];
								echo("<option value=\"$id\">$question</option>");
							}
						?>
					</select>
					</td>
				</tr>
				<tr>
					<td>Answer:&nbsp;</td>
					<td><input type="text" name="question_answer" /></td>
				</tr>
				</table>
				<input type="submit" value="Create" />			
			</form>
			<h3>
<?php

$user_name  = isset($_GET['user_name']) ? $_GET['user_name'] : null;
$password   = isset($_GET['password'])  ? $_GET['password']  : null;
$password2  = isset($_GET['password2']) ? $_GET['password2'] : null;
$full_name  = isset($_GET['full_name']) ? $_GET['full_name'] : null;
$user_email = isset($_GET['user_email']) ? $_GET['user_email']     : null;
$listOption = isset($_GET['listOption']) ? $_GET['listOption'] : null;
$question_answer = isset($_GET['question_answer']) ? $_GET['question_answer'] : null;
$submitted = isset($_GET['submitted']) ? $_GET['submitted'] : null;

if( !empty($user_name) && !empty($password) && !empty($password2) && 
	!empty($full_name) && !empty($user_email) && !empty($question_answer) && !empty($listOption) )
{
	// TODO! validate user, password, email for length spaces & invalid chars
	if( $password == $password2 )
	{
		if( validate_pass( $password ) )
		{
			if( !ip_blocked( 'CREATE', $db ) )
			{
				$user_name = mysql_real_escape_string($user_name);
				$password = mysql_real_escape_string($password);
				$full_name = mysql_real_escape_string($full_name);
				$user_email = mysql_real_escape_string($user_email);
				// make sure user dose not exsit
				$result = get_user( $user_name, $db );
				if($result)
				{
					echo( "Account already exists, please choose another user name." );
				}
				else
				{
					if(create_account( $user_name, $password, $full_name, $user_email, $listOption, $question_answer, $db ))
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
