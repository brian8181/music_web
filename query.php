<?php
session_start(); 
if( isset( $enable_security ) && $enable_security == true )
{
	include_once("./php/sec_user.php"); 
	if( !isset( $_SESSION['_USER']) || !isset( $_SESSION['_GROUPS']) )
	{
		$_SESSION['_PAGE'] = 'index.php';
		header( "Location: login.php" );
	}
}
include_once("./config/config.php");
			    ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>Query Page</title>
    
	<link rel="stylesheet" type="text/css" href="./css/<?php echo($style); ?>" />
    	
    <script type="text/javascript">
      function on_submit(form)  // intialize all values
      {
      var search_string = form.elements['album'].value;
      var option = form.elements['listOption'].value;
      form.elements['album'].value = "";

      if(search_string.length > 1)
      {
      switch(option)
      {
		  case "0":  // ALL
			  form.elements['album'].value = search_string;
			  form.elements['artist'].value = search_string;
			  form.elements['title'].value = search_string;
				break;
		  case "1": // Title
			  form.elements['title'].value = search_string;
			  break;
		  case "2": // Album
			  form.elements['album'].value = search_string;
			  break;
		  case "3": // Artist
			  form.elements['artist'].value = search_string;
			  break;
		  case "4": // File
			form.elements['file'].value = search_string;
			break;
		  case "5": // File
			  form.elements['lyrics'].value = search_string;
			  break;	
		  default:
		  return false;
      }
      }
      else
      {
      return false;
      }
      return true;
      }
    </script>
	</head>
	<body>
	<div class="text_area">

<?php include("./module/login_greeting.php"); ?>

			<!-- Display Title -->
			<div class="box" style="text-align: center">
			<h1>
<?php 
echo($search_title); 
		?>
			</h1>
			</div>
	
			<!-- Navagation Bar -->
				
<?php include("./module/top_toolbar.php"); ?>

			<hr />
			<br />
			<br />
			
			<!-- Submit Search String From -->
			<form name="search_form" onsubmit="return on_submit(search_form)" action="results.php" method="get">
				<div style="text-align: center">
	
					<div style="text-align: center">
						<h3>Search For:  </h3>
					</div>
					<input type="hidden" name="query_type" value="default" />
					<input type="hidden" name="and" value="false" />
					<input type="text" name="album" align="right"value="<?php if (isset($txtSearch)) { echo $txtSearch; } ?>"/>
					<input type="hidden" name="artist" />
					<input type="hidden" name="title" />
					<input type="hidden" name="file" />
					<input type="hidden" name="genre" />
					<input type="hidden" name="comments" />
					<input type="hidden" name="lyrics" />
					<input type="hidden" name="and" value="false" />
					<input type="hidden" name="wildcard" value="off" />
					<input type="hidden" name="sortby" />
					<input type="submit" value="Search" />
					in fields 
					<!-- Options DropList -->
					<?php $listOption = "0" ?>
					<select name="listOption" size="0">
						<option value="0"<?php if ($listOption == "0") { echo " SELECTED"; } ?>>All</option>
						<option value="1"<?php if ($listOption == "1") { echo " SELECTED"; } ?>>Title</option>
						<option value="2"<?php if ($listOption == "2") { echo " SELECTED"; } ?>>Album</option>
						<option value="3"<?php if ($listOption == "3") { echo " SELECTED"; } ?>>Artist</option>
						<option value="4"<?php if ($listOption == "4") { echo " SELECTED"; } ?>>File</option>
						<option value="5"<?php if ($listOption == "5") { echo " SELECTED"; } ?>>Lyrics</option>
					</select>
					use wildcards:
					<input name="wildcard" type="checkbox" value="on" <?php if (isset($wildcard)) { echo " CHECKED"; } ?> />
				</div>
			</form>
	
			<br />
			<br />
			<br />
			<br />
	
			<p><strong></strong></p>
					
			<br />
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

