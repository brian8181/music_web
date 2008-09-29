function on_header_click(anchor)
{
	var header = anchor.name;
	var order;
	//todo copy from functions.php
}


function lTrim(sString)
{
while (sString.substring(0,1) == ' ')
{
sString = sString.substring(1, sString.length);
}
return sString;
}

function rTrim(sString)
{
while (sString.substring(sString.length-1, sString.length) == ' ')
{
sString = sString.substring(0,sString.length-1);
}
return sString;
}