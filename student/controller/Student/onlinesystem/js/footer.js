

function check(qid,ans)
	{
	$("#ch").html($("#"+qid).val());
	var a=$("#"+qid).val();
	$("#"+qid).attr("class","tooltip_answered");
	if ($("input[id=review"+qid+"]").is(':checked'))
	{
		$("#"+qid).attr("class","tooltip_reviewanswered");
				

		//$("#R"+qid).css("color","black");
	}
    $('input[id=copy'+qid+']').attr("checked", true);
		//$("#R"+qid).css("color","white");
		count();
}
function count()
{
i=1;
m=0;
m1=0;
m2=0;
m3=0;
n=0;
n1=0;
n2=0;
n3=0;
o=0;
o1=0;
o2=0;
o3=0;
p=0;
p1=0;
p2=0;
p3=0;
q=0;
q1=0;
q2=0;
q3=0;
var data_x='';
var v=document.getElementById("Qut2").value;
//alert(v);
while(i<=v)
{
if ($("input[name=Q"+i+"]").is(':checked'))
{
 data_x=data_x+","+$('input:radio[name=Q'+i+']:checked').val();
document.getElementById("xx").value=data_x;
}
else
{
 data_x=data_x+","+0;
 document.getElementById("xx").value=data_x;

}

//var vv=$("#Q"+i).is(':checked');
if ($("input[name=Q"+i+"]").is(':checked'))
{
m=m+1;
}
if ($("input[name=R"+i+"]").is(':checked'))
{
m1=m1+1;
}
if ($("input[name=S"+i+"]").is(':checked'))
{
m2=m2+1;
}
if ($("input[name=T"+i+"]").is(':checked'))
{
m3=m3+1;
}

if ($("input[name=reviewQ"+i+"]").is(':checked') && (!$("input[name=Q"+i+"]").is(':checked')))
{
n=n+1;
}
if ($("input[name=reviewR"+i+"]").is(':checked') && (!$("input[name=R"+i+"]").is(':checked')))
{
n1=n1+1;
}
if ($("input[name=reviewS"+i+"]").is(':checked') && (!$("input[name=S"+i+"]").is(':checked')))
{
n2=n2+1;
}
if ($("input[name=reviewT"+i+"]").is(':checked') && (!$("input[name=T"+i+"]").is(':checked')))
{
n3=n3+1;
}


if ($("input[name=reviewQ"+i+"]").is(':checked') && $("input[name=Q"+i+"]").is(':checked'))
{
o=o+1;
}
if ($("input[name=reviewR"+i+"]").is(':checked') && $("input[name=R"+i+"]").is(':checked'))
{
o1=o1+1;
}
if ($("input[name=reviewS"+i+"]").is(':checked') && $("input[name=S"+i+"]").is(':checked'))
{
o2=o2+1;
}
if ($("input[name=reviewT"+i+"]").is(':checked') && $("input[name=T"+i+"]").is(':checked'))
{
o3=o3+1;
}

/*if ($("input[name=Q]").click())
{
p=p+1;
}
if ($("input[name=Q]").click())
{
p1=p1+1;
}
if ($("input[name=Q]").click())
{
p2=p2+1;
}
if ($("input[name=Q]").click())
{
p3=p3+1;
}*/



i++;
}
/*$(".att1").html(m);
$(".att2").html(m1);
$(".att3").html(m2);
$(".att4").html(m3);


$(".natt1").html(n);
if(!n){
	$(".natt1").html(0);
}
$(".natt2").html(n1);
if(!n1){
	$(".natt2").html(0);
}
$(".natt3").html(n2);
if(!n2){
	$(".natt3").html(0);
}
$(".natt4").html(n3);
if(!n3){
	$(".natt4").html(0);
}


$(".ratt1").html(o);
if(!o){
	$(".ratt1").html(0);
}
$(".ratt2").html(o1);
if(!o1){
	$(".ratt2").html(0);
}
$(".ratt3").html(o2);
if(!o2){
	$(".ratt3").html(0);
}
$(".ratt4").html(o3);
if(!o3){
	$(".ratt4").html(0);
}*/
var count=document.getElementById("count").value;
var q= document.getElementById('QA').value;

/*$(".uatt1").html(q-(m+n));
if(!q){
	$(".uatt1").html(1);
}
if(count>=2){
var r= document.getElementById('RA').value;
$(".uatt2").html(r-(m1+n1));
if(!r){
	$(".uatt2").html(1);
}
}
if(count>=3){
var s= document.getElementById('SA').value;
$(".uatt3").html(s-(m2+n2));
if(!s){
	$(".uatt3").html(1);
}
}
if(count>=4){
var t= document.getElementById('TA').value;
$(".uatt4").html(t-(m3+n3));
if(!t){
	$(".ratt4").html(1);
}
}
 var v=document.getElementById("Qut2").value; 
 //alert(v);
 if(q!='1'){
 $(".rev1").html(v-q);
 }
 //alert(r);
 if(r!='1'){
 $(".rev2").html(v-r);
 }
 //alert(s);
 if(s!='1'){
 $(".rev3").html(v-s);
 }
 //alert(t);
 if(t!='1'){
 $(".rev4").html(v-t);
 }
 //alert(p1);
// alert(p);
 //$("#natt").text(n);
*/
    }
	
function mfreview(qid)
{
		
	if ($("input[name=review"+qid+"]").is(':checked'))
	{
	if ($("input[name="+qid+"]").is(':checked'))
	{
		$("#"+qid).attr("class","tooltip_reviewanswered");
		//$("#RQ"+qid).css("color","black");
	}
	else
	{

		$("#"+qid).attr("class","tooltip_review");
		//$("#RQ"+qid).css("color","black");
	}
	}
	else
	{
	if ($("input[name="+qid+"]").is(':checked'))
	{
		$("#"+qid).attr("class","tooltip_answered");
		//$("#RQ"+qid).css("color","black");
	}
	else
	{

		$("#"+qid).attr("class","tooltip_not_answered");
		//$("#RQ"+qid).css("color","black");
	}

	}
	}
function start1(a)
{
   
var value1=document.getElementById("Q").value;
var value2=document.getElementById("R").value;
var value3=document.getElementById("S").value;
var value4=document.getElementById("T").value;
//var coutrand= document.getElementById("countrand2").value;


$("#start").hide();
$("#st").hide();
for(var i=2;i<=a;i++){
$("#Q"+value1+i).hide();
$("#Q"+value2+i).hide();
$("#Q"+value3+i).hide();
$("#Q"+value4+i).hide();
}
for(var z=1;z<=a;z++){
	
	if ($("input[name="+value1+i+"]").is(':checked'))
	{
		$("#"+value1+i).attr("class","tooltip_answered");
		//$("#RQ"+qid).css("color","black");
	}
	
	if ($("input[name="+value2+i+"]").is(':checked'))
	{
		$("#"+value2+i).attr("class","tooltip_answered");
		//$("#RQ"+qid).css("color","black");
	}
	
	if ($("input[name="+value3+i+"]").is(':checked'))
	{
		$("#"+value3+i).attr("class","tooltip_answered");
		//$("#RQ"+qid).css("color","black");
	}
	
	if ($("input[name="+value4+i+"]").is(':checked'))
	{
		$("#"+value4+i).attr("class","tooltip_answered");
		//$("#RQ"+qid).css("color","black");
	}
	
	}


//$("#"+value1+1).attr("class","tooltip_not_answered");
var qa= document.getElementById("QA").value;
$("#Q"+value1+1).show();
//alert(qa);
if(qa!=1){
$("#Q"+value1+qa).hide();
}
var ra= document.getElementById("RA").value;
$("#Q"+value2+1).show();
//alert(ra);
if(ra!=1){
$("#Q"+value2+ra).hide();
}
var sa= document.getElementById("SA").value;
//alert(sa);
$("#Q"+value3+1).show();
if(sa!=1){
	//alert(a);
$("#Q"+value3+sa).hide();
}
var ta= document.getElementById("TA").value;
//alert(ta);
$("#Q"+value4+1).show();
if(ta!=1){
$("#Q"+value4+ta).hide();
}
//alert(coutrand);
//$("#Q"+countrand).hide();
$(".review").show();
//$("#progress2").show();
$("#cont").show();
document.getElementById("Qut").value=1;
//alert(a);
document.getElementById("Qut2").value=a;
//$( "#RQ1").css( "font-size","2" );
/*var selected = $("#tabs").tabs("option", "active");
$("#tabs").tabs("option", "active", selected - 1);
*/
check();
$(".pt").hide();
np();
$(".nt1").hide();

}

function next(val)
{
var value1=document.getElementById("Qut").value;
var value=document.getElementById("Qut1").value;
//alert(val);
//alert(value);
if(value==0){
	value=val;
}

$( "#"+value+value1).attr("class","tooltip_not_answered");

	if($("input[id="+value+value1+"]").is(':checked')){
		$("#"+value+value1).attr("class","tooltip_answered");
	}
    if ($("input[id=review"+value+value1+"]").is(':checked'))
	{
		$("#"+value+value1).attr("class","tooltip_review");
		//$("#R"+qid).css("color","black");
	}
	if ($("input[id=review"+value+value1+"]").is(':checked') && $("input[id="+value+value1+"]").is(':checked'))
	{
		$("#"+value+value1).attr("class","tooltip_reviewanswered");
		//$("#R"+qid).css("color","black");
	}
	
//alert(value);
//alert(value1);
$("#Q"+value1).show();
if(value=='Q'){
var qa= document.getElementById(value+"A").value;
if(value1==qa){
document.getElementById(value+"A").value=(++qa);
}
//alert(qa);
}
if(value=='R'){
var ra= document.getElementById(value+"A").value;
if(value1==ra){
document.getElementById(value+"A").value=(++ra);
}
}
if(value=='S'){
var sa= document.getElementById(value+"A").value;
if(value1==sa){
document.getElementById(value+"A").value=(++sa);
}
}
if(value=='T'){
var ta= document.getElementById(value+"A").value;
if(value1==ta){
document.getElementById(value+"A").value=(++ta);
}
}

//document.getElementById("Q"+value1).value=ua+1;
value1=parseInt(value1)+1;
value2=parseInt(value1)-1;
$(".Question").hide();
//$( "#RQ"+value2).css("background-image","url(image/blank.png)");

var x=$( "#"+value+value1).attr("class");
if(x=='review'){
$( "#"+value+value1).attr("class","tooltip_not_answered");
}
//$( "#RQ"+value2).css( "font-size","100%" );

//$( "#RQ"+value1).css( "font-size","160%" );
document.getElementById("Qut").value=value1;

$("#Q"+value+value1).fadeIn(1000);
check();
np();
return false;

}
function prev(val)
{
var value2=document.getElementById("Qut").value;
var value=document.getElementById("Qut1").value;
if(value==0){
	value=val;
}
//alert(value2);
//alert(value);
$( "#"+value+value2).attr("class","tooltip_not_answered");

	if($("input[id="+value+value2+"]").is(':checked')){
		$("#"+value+value2).attr("class","tooltip_answered");
	}

	if ($("input[id=review"+value+value2+"]").is(':checked'))
	{
		$("#"+value+value2).attr("class","tooltip_review");
		//$("#R"+qid).css("color","black");
	}
	if ($("input[id=review"+value+value2+"]").is(':checked') && $("input[id="+value+value2+"]").is(':checked'))
	{
		$("#"+value+value2).attr("class","tooltip_reviewanswered");
		//$("#R"+qid).css("color","black");
	}
	
value1=parseInt(value2)-1;
$("#Q"+value1).show();
$(".Question").hide();
var x=$( "#"+value+value1).attr("class");
if(x=='review'){
$( "#"+value+value1).attr("class","tooltip_not_answered");
}
document.getElementById("Qut").value=value1;
//$( "#RQ"+value2).css("background-image","url(image/blank.png)");;

//$( "#RQ"+value1).css("background-image","url(images/mark.png)");
//$( "#RQ"+value2).css( "font-size","100%" );

//$( "#RQ"+value1).css( "font-size","160%" );

$("#Q"+value+value1).fadeIn(1000);
np();
return false;

}
function randq(value1,value2,value3)
{ 
//alert(value3);
$(".Question").hide();
document.getElementById("Qut").value=value2;
//document.getElementById("Qut1").value=value3;
var x=$( "#"+value1).attr("class");
if(x=='review')
$( "#"+value1).attr("class","tooltip_not_answered");

/*var value12=document.getElementById("Qut1").value;
if(value12=='Q'){
var qa= document.getElementById(value12+"A").value;

document.getElementById(value12+"A").value=(++qa);
}
//alert(qa);

if(value12=='R'){
var ra= document.getElementById(value12+"A").value;

document.getElementById(value12+"A").value=(++ra);

}
if(value12=='S'){
var sa= document.getElementById(value12+"A").value;

document.getElementById(value12+"A").value=(++sa);
}

if(value12=='T'){
var ta= document.getElementById(value12+"A").value;

document.getElementById(value12+"A").value=(++ta);

}*/


//$( ".review").css( "font-size","100%" );
//$( ".review").css("background-image","url()");;

//$( "#RQ"+value1).css( "font-size","160%" );
//$( "#RQ"+value1).css("background-image","url(images/mark.png)");
document.getElementById("countrand2").value=value1;
$("#Q"+value1).show();
check();
np();
return false;
}

function np()
 {
 var value2=document.getElementById("Qut").value;
 if(value2<2)
 {
  $(".pt").hide();
 }
 else
 {
   $(".pt").show();
 }
var value=document.getElementById("Qut2").value;
//alert(value);
//alert(value2);
  if(value==value2)
 {
  $(".nt").hide();
  $(".nt1").show();
  //alert("You have reached the last question of this section..");
 }
 else
 {
   $(".nt").show();
   $(".nt1").hide();
 }

 }




function start()
{
    var iNow = new Date().setTime(new Date().getTime() + 0 * 1000); // now plus 5 secs
    var iEnd = new Date().setTime(new Date().getTime() + time3*60 * 1000); // now plus 15 secs
    
   $('#progress2').anim_progressbar({start: iNow, finish: iEnd, interval: 100});
   $(".review").show();
var count=document.getElementById("count").value;
$("#cont").show();
document.getElementById("Qut").value=1;
var a=document.getElementById("totalq").value;
document.getElementById("Qut2").value=a;
//$( "#RQ1").css( "font-size","2" );
//check();
$(".pt").hide();
np();
var value1=document.getElementById("Q").value;
$("#Q"+value1+1).show();
if(count>=2){
var value2=document.getElementById("R").value;
$("#Q"+value2+1).show();
}
if(count>=3){
var value3=document.getElementById("S").value;
$("#Q"+value3+1).show();
}
if(count>=4){
var value4=document.getElementById("T").value;
$("#Q"+value4+1).show();
}
//$("#start1").hide();
$("#st").hide();
//$("#"+value1+1).attr("class","tooltip_not_answered");
for(var z=1;z<=a;z++){
	
	if ($("input[name="+value1+z+"]").is(':checked'))
	{
		$("#"+value1+z).attr("class","tooltip_answered");
		//$("#RQ"+qid).css("color","black");
	}
	
	if ($("input[name="+value2+z+"]").is(':checked'))
	{
		$("#"+value2+z).attr("class","tooltip_answered");
		//$("#RQ"+qid).css("color","black");
	}
	
	if ($("input[name="+value3+z+"]").is(':checked'))
	{
		$("#"+value3+z).attr("class","tooltip_answered");
		//$("#RQ"+qid).css("color","black");
	}
	
	if ($("input[name="+value4+z+"]").is(':checked'))
	{
		$("#"+value4+z).attr("class","tooltip_answered");
		//$("#RQ"+qid).css("color","black");
	}
	
	}

}

function anssave(id,val){
	//alert(id);
	document.getElementById("A"+id).style.color = "green";
	$("#A"+id).html("Answered and Saved");
	
	$("#A"+id).css("color:green");
	var text = $('#quest');
    text.val(text.val() + ',' + id);
	var text1 = $('#answ');
    text1.val(text1.val() + ',' + val);
}
function clear1(id){
	//alert(id);
	document.getElementById("A"+id).style.color = "red";
	$("#A"+id).html("Not Answered");
}
