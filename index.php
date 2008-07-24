<?php 
include_once("./php/sec_user.php"); 
//include_once("./php/validate_login.php");
include_once("./config/config.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>Music Database</title>
    <meta name="generator" content="Bluefish 1.0.7"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="./favicon.png" />
	<link rel="stylesheet" type="text/css" href="./css/<?php echo($style); ?>" />
</head>
	<body>
	<div class="text_area">
   
<?php 
$db = mysql_connect($db_address, $db_user_name, $db_password); mysql_select_db($db_name, $db);
mysql_query("SET NAMES 'utf8'");
mysql_query("INSERT INTO hitcount VALUES ( NULL, 'index.php', NOW() )"); 
mysql_close();
include("./module/login_greeting.php"); 
                ?> 
				
	<div class="box" style="text-align: center">
		<h1>
			<em>Music&nbsp;Database</em>
		</h1>
	</div>
	
<?php 
include("./module/top_toolbar.php"); 
		?>
		
		<hr />
<?php		
include("./module/index_body.php"); 		
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
