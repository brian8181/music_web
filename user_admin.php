<?php
session_start();
include_once("./config/config.php");
include_once("./php/functions.php");

if( !isset( $_SESSION['_USER'] ) || !isset( $_SESSION['_GROUPS'] ) )
{
	$_SESSION['_PAGE'] = $_SERVER['PHP_SELF'];
	header( "Location: ../login.php" );
	exit();
}

$groups_loc = $_SESSION['_GROUPS']; 
if(!array_key_exists('admin', $groups_loc))
{
	echo( "<div style=\"text-align: center\"><h3>Sorry, your are not authorized to access the page.</h3></div>" );	
	echo( "<div style=\"text-align: center\"><a href=\"/index.php\"><i>www.bkp-online.com</i></a></div>" );
	exit();
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<!-- Headers -->
<head>
    <title>User Admin Page</title>
    <link rel="stylesheet" type="text/css" href="./css/<?php echo($style); ?>" />
    <script type="text/javascript">
		function on_submit(form)  // intialize all values
		{
			// get check boxes
			var frm = document.forms[2];
			var count = frm.elements.length;
			var user_group = "";
			var cur_user = "";
			for( var i = 0; i < count; ++i)
			{
				if(frm.elements[i].checked)
				{
					var str = frm.elements[i].name;
					var pairs = str.split('-');
					var user = pairs[0] ;
					var group = pairs[1];
					
					if(cur_user != user)
					{
						if(cur_user == "")
							user_group += user + ":" + group;
						else
							user_group += "-" + user + ":" + group;
						cur_user = user;
					}
					else
					{
						user_group += "," + group;
					}
				}
			}
			form.elements['usr_grps'].value = user_group;
			return true;
		}
    </script>
    </head>
	<body>
		<div class="text_area">
<?php 
include("./module/login_greeting.php");
	?>
		<div class="box" style="text-align: center">
			<h1><em>User Administration</em></h1>
		</div>
		<br />
		<?php include("./module/top_toolbar.php"); ?>

		<hr />
		<br />
	
		<div style="text-align: center">
		<form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="get" enctype="text/plain" >
			<input type="text" name="filter" size="6" style="text-align: center;" />
			<input type="submit" value="Filter" />
		</form>
		</div>
		<br />
		<center>
		<form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="get">
		<table class="Admin" align="center">
		
<?php 
$db = mysql_connect($admin_db_address, $admin_db_user_name, $admin_db_password);
mysql_select_db($admin_db_name, $db);
mysql_query("SET NAMES 'utf8'");

$usr_grp = array();
$users = array();

// get users
$filter = isset($_GET['filter']) ? $_GET['filter'] : null;
if(isset($filter))
{
	$filter = str_replace( "*", "%", $filter);
	$filter = str_replace( "?", "_", $filter);
}
else
{
	$filter = "%";
}
$filter = mysql_real_escape_string( $filter );

$sql = "SELECT `id`, `user` FROM `user` WHERE `user` LIKE '$filter' ORDER BY `user`.`user`";
$result = mysql_query($sql, $db);

while ( $row = mysql_fetch_row($result) )
{
	$uid = $row[0];
	$usr_grp[$uid] = array();
	$users[$uid] = $row[1];
}

// get groups
$groups_loc = array();
$sql = "SELECT `id`, `group` FROM `group` ORDER BY `group`.`group`";
$result = mysql_query($sql, $db);
while ( $row = mysql_fetch_row($result) )
{
	$gid = $row[0];
	$usr_grp[$uid][$gid] = false;
	$groups_loc[$gid] = $row[1];
}

$sql = "SELECT user_id, group_id FROM `group` INNER JOIN `user_group` ON `group`.id=`group_id`";
$result = mysql_query($sql, $db);
while ( $row = mysql_fetch_row($result) )
{
	$uid = $row[0];
	$gid = $row[1];
	$usr_grp[$uid][$gid] = true;
}

echo("<th colspan=\"1\" align=\"center\">&nbsp;</th>\r\n");
foreach($groups_loc as $group)
{
	echo("<th colspan=\"1\" align=\"center\">$group</th>\r\n");
}
foreach($users as $uid => $local_user)
{
	echo("<tr class=\"Admin\">");
	echo("<td align=\"center\">$local_user</td>\r\n");
	
	foreach($groups_loc as $gid => $group)
	{
		$checked = "";
		if(isset($usr_grp[$uid][$gid]) && $usr_grp[$uid][$gid] == true)
		{
			$checked = "checked=\"checked\"";
		}
		
		echo("<td align=\"center\"><input type=\"checkbox\" name=\"$uid-$gid\" $checked /></td>\r\n");
	}
	echo("</tr>");
}
mysql_close();
		?>
		
        </table>
            <input type="reset" />
        </form>
            <br />
            <form action="./admin/update_users.php" name="update_form" onsubmit="return on_submit(update_form)"
                method="get">
                <input type="hidden" name="usr_grps" value="" />
                <input type="submit" value="Update" />
            </form>
        </center>
            <br />
            <hr>
            <!-- Navagation Bar -->
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
