<?php 
include_once("./config/config.php");
$style = assert_login() ? $_SESSION['_STYLE'] : "./css/$style";
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>[$title]</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="./favicon.png" />
	<link rel="stylesheet" type="text/css" href="./css/<?php echo($style); ?>" />
</head>
	<body>
	<div class="text_area">
   
<?php 
include("./module/login_greeting.php"); 
                ?> 
				
	<div class="box" style="text-align: center">
		<h1>
			<em>[$title]</em>
		</h1>
	</div>
	
<?php 
include("./module/top_toolbar.php"); 
		?>
		
		<hr />
<?php		

//$mysql = new mysql_db();
//$mysql->sql_connect($db_address, $db_user_name, $db_password, $db_name);

//$db = mysql_connect($db_address, $db_user_name, $db_password);
//mysql_select_db($db_name, $db);
//mysql_query("SET NAMES 'utf8'");

//$sql = "SELECT artist FROM artist";
//$result = mysql_query( $sql );

	    ?>
	    
	    <table>
	    <tr>
	    	<th>Artist</th>
	    	<th>Album Count</th>
	    	<th>Sougs Count</th>
	    </tr>
	    <tr>
	    	<td></td>
	    	<td></td>
	    	<td></td>
	    </tr>
	    </table>			
	
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
