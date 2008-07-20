<?php
	//If Not Logged In Goto Login Page 
	session_start(); 
	if( !isset( $_SESSION['_USER'] ) ||  isset($_SESSION['_GROUP']) )
	{
		$_SESSION['_PAGE'] = $PHP_SELF;
		header( "Location: /login.php" );
	}
?>