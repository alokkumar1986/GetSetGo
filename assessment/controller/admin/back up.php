<?php require_once("../../include/membersite_config.php");
if(!$fgmembersite->CheckLogin())
{
 $fgmembersite->RedirectToURL("../login.php");
 exit;
}
$fgmembersite->DBLogin();
function backup_db(){
/* Store All Table name in an Array */
$allTables = array();
$result = mysql_query('SHOW TABLES');
while($row = mysql_fetch_row($result)){
     $allTables[] = $row[0];
}

foreach($allTables as $table){
$result = mysql_query('SELECT * FROM '.$table);
$num_fields = mysql_num_fields($result);

$return.= 'DROP TABLE IF EXISTS '.$table.';';
$row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
$return.= "\n\n".$row2[1].";\n\n";

for ($i = 0; $i < $num_fields; $i++) {
while($row = mysql_fetch_row($result)){
   $return.= 'INSERT INTO '.$table.' VALUES(';
     for($j=0; $j<$num_fields; $j++){
       $row[$j] = addslashes($row[$j]);
       $row[$j] = str_replace("\n","\\n",$row[$j]);
       if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } 
       else { $return.= '""'; }
       if ($j<($num_fields-1)) { $return.= ','; }
     }
   $return.= ");\n";
}
}
$return.="\n\n";
}

// Create Backup Folder
$folder = 'DB_Backup/';
if (!is_dir($folder))
mkdir($folder, 0777, true);
chmod($folder, 0777);

$date = date('m-d-Y-H-i-s', time()); 
$filename = $folder."db-backup-".$date; 

$handle = fopen($filename.'.sql','w+');
fwrite($handle,$return);
fclose($handle);
}

// Call the function
backup_db();

?>
<div id='fg_membersite_content'>
<h2> Database Back Up is done. </h2>
Database back up is successfully done.

</div>