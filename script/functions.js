function on_header_click(link, order) 
{
	var qs = new Querystring();
	var order = qs.get("order_by");
	var cols = order.split(",");
	var pair = cols[0].split(" ");
	var ret;
	
	var name = new String(link.name);
	if(name == pair[0])
	{
		if( pair[1] == "ASC" )
			ret = order.replace("ASC", "DESC", "gi");
		else
			ret = order.replace("DESC", "ASC", "gi");
	}
	else
	{
		order = "";
		for( var i in cols )
		{
			pair = cols[i].split(" "); 
			if(pair[0] == link.name)
				continue;
			order += cols[i] + ",";	
		}
		order = order.substr( 0, order.length-1 );
		ret = link.name +  " ASC," + order;
	}
	link.href += "&order_by=" + ret;
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