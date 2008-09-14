<?php

// validate user is logged in
function assert_login()
{
	if( isset($_SESSION['_USER']) && isset($_SESSION['_GROUPS']) )
	{
		return true;
	}
	return false;
}

function logout()
{
	session_start();
	$_SESSION = array();
	if (isset($_COOKIE[session_name()])) {
		setcookie(session_name(), '', time()-42000, '/');
		}
	session_destroy();
}

function validate_pass($password)
{
	if(
	ctype_alnum($password) // numbers & digits only
	&& strlen($password)>6 // at least 7 chars
	&& strlen($password)<21 // at most 20 chars
	//&& preg_match('`[A-Z]`',$password) // at least one upper case
	//&& preg_match('`[a-z]`',$password) // at least one lower case
	// at least one lower case or // at least one upper case
	&& ( preg_match('`[A-Z]`',$password) || preg_match('`[a-z]`',$password) )
	&& preg_match('`[0-9]`',$password) // at least one digit
	){
		// valid
		return true;
	}else{
		// not valid
		return false;
	} 
}


function selfURL() 
{ 
	$s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : ""; 
	$protocol = strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s; 
	$port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]); 
	return $protocol."://".$_SERVER['SERVER_NAME'].$port.$_SERVER['REQUEST_URI']; 
} 

function strleft($s1, $s2) 
{ 
	return substr($s1, 0, strpos($s1, $s2)); 
}

function sql_value($var)
{
	return isset($var) ? $var : "NULL";
}

?>