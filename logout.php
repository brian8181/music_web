<?php
// logout user and return to index
session_start();
if(isset($_SESSION['_USER']))
{
	unset($_SESSION['_USER']); 
	
}
session_destroy();
header( "Location: index.php" );
?>
