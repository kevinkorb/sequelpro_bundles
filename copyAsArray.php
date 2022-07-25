#!/usr/bin/env /usr/local/bin/php
<?php
$stdIn = fopen("php://stdin", "r");
$result = [];
while($row = fgetcsv($stdIn, 0)) {
	foreach($row AS $k => $v){
		$row[$k] = strtr( $v, array(  "\n" => "\\n",  "\r" => "\\r"  ));
	}
	array_push($result, $row);
}
$columns = array_shift($result);
if ($result) {
	foreach($result as $k => $data) {
		$result[$k] = array_combine($columns, $data);
	}
}

$cmd = 'echo '.escapeshellarg(str_replace("'NULL'", 'NULL', var_export($result, true))).' | __CF_USER_TEXT_ENCODING='.posix_getuid().':0x8000100:0x8000100 pbcopy';
shell_exec($cmd);

