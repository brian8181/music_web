// JScript File
function validate(form) 
{
	form.elements['artist'].value = form.elements['album'].value;
	form.elements['title'].value = form.elements['album'].value;
}

function on_submit(form)  // intialize all values
{
	// get check boxes
	var fids = "";
	var count = form.elements.length;
	for( var i = 0; i < count; ++i)
	{
		if(form.elements[i].checked)
		{
			var str = form.elements[i].name;
			var pairs = str.split('_');
			var folder_id = pairs[1] ;
			fids +=  folder_id + " ";
		}
	}
	var len = fids.length;
	fids = fids.substr(0, len-1);
	form.elements['folder_id'].value = fids;
	return true;
}
			

function on_submit_move(form)  // intialize all values
{
    var fids = "";
	var frm = document.forms[0];
	var count = frm.elements.length;
	for( var i = 0; i < count; ++i)
	{
		if(frm.elements[i].checked)
		{
			var str = frm.elements[i].name;
			var pairs = str.split('_');
			fids +=  pairs[1] + " ";
		}
	}
	var len = fids.length;
	fids = fids.substr(0, len-1);
	form.elements['folder_id'].value = fids;
}

function get_checks(form)  // intialize all values
{
    // get check boxes
	var fids = "";
	var count = form.elements.length;
	for( var i = 0; i < count; ++i)
	{
		if(form.elements[i].checked)
		{
			var str = form.elements[i].name;
			var pairs = str.split('_');
			var folder_id = pairs[1] ;
			fids +=  folder_id + " ";
		}
	}
	var len = fids.length;
	fids = fids.substr(0, len-1);
	form.elements['folder_id'].value = fids;
}