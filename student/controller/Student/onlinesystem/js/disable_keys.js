if (document.all)
{	 	
	document.onkeydown = function ()
	{
		var ev = event.keyCode;
	//	alert(ev);
	//	if (ev==116 || ev==8 || ev==18)
	//	{
			event.keyCode=0;
	//	}
		return false;
	}
}
