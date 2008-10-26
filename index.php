<?php
include_once("./config/config.php");
include_once("./module/header.php");

open_page($index_title);

if(assert_login())
{
	include("./module/index_body.php");
}
else
{
	include("./module/deny_index_body.php");
}

include("./module/footer.php");
	?>
	
