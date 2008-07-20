<?php 
//include_once("../php/sec_user.php"); 
//include_once("../php/validate_login.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>Music Database</title>
    <meta name="generator" content="Bluefish 1.0.7"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="../favicon.png" />
	<link rel="stylesheet" type="text/css" href="/css/main_web.css" />
</head>
	<body>
	<div class="text_area">
   
<?php 
$db = mysql_connect('127.0.0.1', 'web','sas*.0125'); mysql_select_db('music', $db);
mysql_query("SET NAMES 'utf8'");
mysql_query("INSERT INTO hitcount VALUES ( NULL, 'index.php', NOW() )"); 
mysql_close();
include("./module/login_greeting.php"); 
                ?> 
                <div class="box" style="text-align: center">
                    <h1>
                        <em>Music&nbsp;Database</em></h1>
                </div>
                <br />
                <br />
	<!-- Navagation Bar -->
	<div id="nav_menu">
  <?php 
  include("./module/top_toolbar.php"); 
		?>
	<hr />
<?php
include("./module/bottom_toolbar.php");
include("./module/contact_info.php");
			?>
			
			<br />
            <!-- verison info -->
			<span style="font-size: smaller;"><em>Version 2.0.0.2 Sat Sep 8 11:23:37 CDT 2007 ~(Copyright
                    © by Brian Preston (2007))</em></span>
	</div>	
	</body>
</html>
