var university_arr=new Array("-Select College-","Gandhi Institute for Technological Advancement, Bhubaneswar","College of Engineering Bhubaneswar","Bhubaneswar Engineering College, Bhubaneswar","Bhubaneswar College of Engineering, Khordha","Dhaneswar Rath Institute of Engineering and Management Studies, Khordha","Koustuv Institute of Technology, Khordha","koustuv institute of self domain, Khordha","TRIDENT ACADEMY OF TECHNOLOGY, BHUBANESWAR","EASTERN ACADEMY OF SCIENCE & TECHNOLOGY, PHULNAKHRA","SYNERGY INSTITUTE OF ENGINEERING AND TECHNOLOGY, DHENKANAL","KRUPAJALA ENGINEERING COLLEGE, BHUBANESWAR","INDOTECH COLLEGE OF ENGINEERING, BHUBANESWAR","Others");
var c_a=new Array();
c_a[0]="";c_a[1]="";
c_a[2]="GITA";
c_a[3]="CEB";
c_a[4]="BEC";
c_a[5]="BCE";
c_a[6]="DRIEMS";
c_a[7]="KIT";
c_a[8]="KISD";
c_a[9]="TAT";
c_a[10]="EAST";
c_a[11]="SIET";
c_a[12]="KEC";
c_a[13]="ICE";
function print_university(university_id){var option_str=document.getElementById(university_id);
var x,i=0;for(x in university_arr){option_str.options[i++]=new Option(university_arr[x],university_arr[x]);}}
function print_college(college_id,college_index){var option_str=document.getElementById(college_id);
var x,i=0;college_index++;var college_arr=c_a[college_index].split("|");
for(x in college_arr){option_str.options[i++]=new Option(college_arr[x],college_arr[x]);}}