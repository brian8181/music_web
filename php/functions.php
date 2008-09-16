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

function assert_group($group)
{
	if(assert_login())
	{
		$groups_loc = $_SESSION['_GROUPS']; 
		if(array_key_exists('admin', $groups_loc))
		{
			return true;
		}
	}
	return false;
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

?>