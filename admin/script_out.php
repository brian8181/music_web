<?php
if(isset($script_name))
{
	echo("<b>$script_name output:</b>");
	echo("<p>");
	include($script_name);
	echo("</p>");
}
?>	