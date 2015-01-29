<?php
header('Content-Type: application/json');

$host="localhost";
  $uname="jack";
  $pass="jack";
  $database = "business";
  $connection=mysql_connect($host,$uname,$pass); 
   $selectdb=mysql_select_db($database) or die("Database could not be selected"); 
  $result=mysql_select_db($database)or die("database cannot be selected <br>"); 
function backup_db(){
/* Store All Table name in an Array */
$allTables = array();
$result = mysql_query('SHOW TABLES');
while($row = mysql_fetch_row($result)){
     $allTables[] = $row[0];
}
$return="";
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
$d=date('d-m-Y');
$folder = 'E:/'.$d.'/';
if (!is_dir($folder))
mkdir($folder, 0777, true);
chmod($folder, 0777);

$date = date('m-d-Y-H-i-s', time()); 
$filename = $folder."business-".$date; 

$handle = fopen($filename.'.sql','w+');
fwrite($handle,$return);
fclose($handle);
}

// Call the function
backup_db();
$zip = new ZipArchive();
$zip->open('E:\\'.date('d-m-Y').'\\'.date('m-d-Y-H-i-s', time()).'.zip', ZipArchive::CREATE);

$dirName = 'D:\xampp\htdocs\demo';

if (!is_dir($dirName)) {
throw new Exception('Directory ' . $dirName . ' does not exist');
}

$dirName = realpath($dirName);
if (substr($dirName, -1) != '/') {
$dirName.= '/';
}

/*
* NOTE BY danbrown AT php DOT net: A good method of making
* portable code in this case would be usage of the PHP constant
* DIRECTORY_SEPARATOR in place of the '/' (forward slash) above.
*/

$dirStack = array($dirName);
//Find the index where the last dir starts
$cutFrom = strrpos(substr($dirName, 0, -1), '/')+1;

while (!empty($dirStack)) {
$currentDir = array_pop($dirStack);
$filesToAdd = array();

$dir = dir($currentDir);
while (false !== ($node = $dir->read())) {
if (($node == '..') || ($node == '.')) {
continue;
}
if (is_dir($currentDir . $node)) {
array_push($dirStack, $currentDir . $node . '/');
}
if (is_file($currentDir . $node)) {
$filesToAdd[] = $node;
}
}

$localDir = substr($currentDir, $cutFrom);
$zip->addEmptyDir($localDir);

foreach ($filesToAdd as $file) {
$zip->addFile($currentDir . $file, $localDir . $file);
}
}

$zip->close();
$rc['result']="success";
echo json_encode ($rc);
?>