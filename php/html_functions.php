<?php

function add_data($data)
{
	echo("<td>$data</td>");
}

function open_row()
{
	echo("<tr>");
}

function close_row()
{
	echo("<tr>");
}

function print_img_srck($path)
{
	echo("<img src=\"$path\" />");	
}

function print_anchor_link($link, $name)
{
	echo("<a href=\"$link\">$name</a>");	
}

?>