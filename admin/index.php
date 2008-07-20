<?php
session_start(); 

$groups_loc = $_SESSION['_GROUPS']; 
$user_loc = $_SESSION['_USER'];

if( isset($user_loc) && isset($groups_loc) )
{
	$groups_loc = $_SESSION['_GROUPS']; 
	if(!array_key_exists('user', $groups_loc))
	{
		echo( "<div style=\"text-align: center\"><h3>Sorry, your are not authorized to access the page.</h3></div>" );	
		echo( "<div style=\"text-align: center\"><a href=\"/index.php\"><i>www.bkp-online.com</i></a></div>" );
		exit();
	}
	
}
else
{
	$_SESSION['_PAGE'] = $PHP_SELF;
	header( "Location: /login.php" );
	exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <!-- Headers -->
  <head>
    <title>Admistration @ bkp-online.com</title>
    <link rel="stylesheet" type="text/css" href="../css/main_web.css" />
    <link rel="stylesheet" type="text/css" href="../css/query.css" />
  </head>
  <body>
    <!-- Page Table -->
    <table class="Main">
      <tr>
        <td class="Main">
          <?php include("../module/login_greeting.php"); ?>
          <br />

          <!-- Display Title -->
          <div class="box" style="text-align: center">
            <h1>
              <em>Admistration</em>
            </h1>
          </div>
          <!-- Navagation Bar -->
          <br />
          <?php include("../module/limited_top_toolbar.php"); ?>
          <br />
          <h4>General</h4>
          <ul>
            <li>
              <a href="user_admin.php">User Adminsitration</a>
            </li>
            <li>
              <a href="phpinfo.php">pHp Info</a>
            </li>
            <li>
              <a href="music_stats.php">Music DB Statatics</a>
            </li>
          </ul>
          <h4>Tools</h4>
          <ul>
            <li>
              <a href="../php/script_out.php?script_name=whoami.php">Whoami Utility</a>
            </li>
            <li>
              <a href="../php/script_out.php?script_name=login.php">Login Script</a>
            </li>
            <li>
              <a href="../php/script_out.php?script_name=.kill.php">Kill Session</a>
            </li>
			<li>
              <a href="../php/unset_G.php" />Kill Globals/a>
            </li>
          </ul>
          <br />
          <hr/>
          <!-- Navagation Bar -->
<?php
if(isset($script_name))
{
	include("../php/script_out.php");
}
          ?>
          <hr/>
          <br/>
<?php
include("../module/bottom_toolbar.php");
include("../module/contact_info.php");
			    ?>
          <br />
          <span style="font-size: smaller;">
            <em>Version 1.0.0.0 Fri Jan 11 14:53:18 CST 2008 ~( Copyright © by Brian Preston (2008) )</em>
          </span>

        </td>
      </tr>
    </table>
  </body>
</html>

