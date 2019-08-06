// JScript File
var gdCtrl = new Object();
var KeyArray = new Array("7","8","9","4","5","6","1","2","3","0","-",".","Backspace");
function fSetSelected(aCell)
{
    self.event.cancelBubble = true;    
    with(aCell)
    {
	    gdCtrl.value = gdCtrl.value + innerText;
	    var skmo=document.getElementById("skmIcode").value;
        var skmt=gdCtrl.value;
        document.getElementById("lblTValue").value="Your answer is  :: " +skmt;
        sendresp(skmo,skmt);
    }	
}

function fSetClearBack(aCell)
{
    self.event.cancelBubble = true;    
    with(aCell)
    {
        if(gdCtrl.value.length>0)
        {
	        gdCtrl.value = gdCtrl.value.substring(0,gdCtrl.value.length-1);
	        var skmo=document.getElementById("skmIcode").value;
	        var skmt=gdCtrl.value;
            document.getElementById("lblTValue").value="Your answer is  :: " +skmt;
            sendresp(skmo,skmt);
	    }
    }	
}

function fSetMouseIn(aCell)
{
    with(aCell)
    {
        className = 'KeyMouseIn';
    }
}

function fSetMouseOut(aCell)
{
    with(aCell)
    {
        className = 'KeyMouseOut';
    }
}

function DrawKeyPad(iCellHeight, iCellWidth) 
{    
    with (document) 
    {        
	    write("<tr>");
	    for(ik=0; ik<KeyArray.length; ik++)
	    {	        	        
	        if((ik%3)==0 && ik>0)
	        {
	            write("<tr></tr>");  	 
	        }
	        if(ik==KeyArray.length-1)
	        {
	            write("<td colspan=3 class='stext' id='KeyPadCell' align='center'>");
	        }
	        else
	        {
	            write("<td class='stext' id='KeyPadCell' align='center'>");
	        }
		    
			write("<div id=cellText></div>");
			write("</td>")
		}
	    write("</tr>");  	   
    }
}

function UpdateKeyPad() 
{  
    for(ik=0; ik<KeyArray.length; ik++)
    {
        with (cellText[ik]) 
		{
		    cellText[ik].innerHTML = "<div></div>";
		    if(ik==KeyArray.length-1)
		    {
		        var st="<div class='KeyNormal' style='width:100%' onclick='fSetClearBack(this)' onMouseOver='fSetMouseIn(this)' onMouseOut='fSetMouseOut(this)'>";
		    }
		    else
		    {
		        var st="<div class='KeyNormal' onclick='fSetSelected(this)' onMouseOver='fSetMouseIn(this)' onMouseOut='fSetMouseOut(this)'>";
		    }
	        
	        cellText[ik].innerHTML = st+""+KeyArray[ik]+"</div>";	        
		}
	}		  
}

function PopKeyPad(popCtrl, TxtCtrl)
{
    gdCtrl = TxtCtrl;
    UpdateKeyPad();
    with(popCtrl)
    {
        innerHTML = EKeyPad.innerHTML;
    }
   /* var point = fGetXY(popCtrl); 
    //var pointfrm = fGetXY(top.main.document.getElementById("qst"))
    //alert(pointfrm.y);
    with (EKeyPad.style) 
    {       
        left = point.x;
        top  = point.y+popCtrl.offsetHeight+1;
        //top  = pointfrm.y+point.y+popCtrl.offsetHeight+1;
        width = EKeyPad.offsetWidth;
        height = EKeyPad.offsetHeight;
        //fToggleTags(point);
        visibility = 'visible';
    }
    EKeyPad.focus();*/
}

function Point(iX, iY)
{
	this.x = iX;
	this.y = iY;
}

function fGetXY(aTag)
{
    var oTmp = aTag;
    var pt = new Point(0,0);
    do 
    {
        pt.x += oTmp.offsetLeft;
        pt.y += oTmp.offsetTop;
        oTmp = oTmp.offsetParent;
    } 
    while(oTmp.tagName!="BODY");
    return pt;
}

function HideKeyPad()
{
    var oE = window.event;
    if ((oE.clientX>0)&&(oE.clientY>0)&&(oE.clientX<document.body.clientWidth)&&(oE.clientY<document.body.clientHeight)) 
    {
        var oTmp = document.elementFromPoint(oE.clientX,oE.clientY);
        while ((oTmp.tagName!="BODY") && (oTmp.id!="EKeyPad"))
        {
            oTmp = oTmp.offsetParent;
        }
        if (oTmp.id=="EKeyPad")
        {
            return;
        }
    }
    EKeyPad.style.visibility = 'hidden';    
}

with (document) 
{
write("<Div class='cont' id='EKeyPad' onclick='focus()' style='POSITION:absolute;visibility:hidden;border:1px solid'>");
write("<table border='0' bgcolor='#f0f0f0' cellpadding='0' cellspacing='3'>");
write("<TR>");
write("<td align='center'>");
write("<DIV style='background-color:#f0f0f0;'><table width='100%' border='0' cellpadding='1' cellspacing='0'>");
DrawKeyPad(18, 16);
write("</table></DIV>");
write("</td>");
write("</TR>");
write("</TD></TR>");
write("</TABLE></Div>");
}