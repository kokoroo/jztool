<?php
ob_end_clean();
//ignore_user_abort(true);
set_time_limit(0);


$auto=1;

$bomed_list=array();


bom_dir('.');


function bom_dir( $basedir ){
	if ($dh = opendir($basedir)) {
		while (($file = readdir($dh)) !== false) {
			if ($file!='.' && $file!='..'){ 
				if ( is_dir($basedir."/".$file) ){
					bom_dir($basedir."/".$file);
				}else{
					echo "filename: $basedir/$file ".checkBOM("$basedir/$file")." <br>";
				}
			}
		}
		closedir($dh);
	}
}

function checkBOM ($filename) {
	global $auto,$bomed_list;
	$contents=file_get_contents($filename);
	$charset[1]=substr($contents, 0, 1);
	$charset[2]=substr($contents, 1, 1);
	$charset[3]=substr($contents, 2, 1);
	if (ord($charset[1])==239 && ord($charset[2])==187 && ord($charset[3])==191) {
		if ($auto==1) {
			$rest=substr($contents, 3);
			rewrite ($filename, $rest);
			$bomed_list[]=$filename;
			return ("<font color=red>BOM found, automatically removed.</font>");
		} else {
			return ("<font color=red>BOM found.</font>");
		}
	} else {
		return ("BOM Not Found.");
	}
}

function rewrite ($filename, $data) {
	$filenum=fopen($filename,"w");
	flock($filenum,LOCK_EX);
	fwrite($filenum,$data);
	fclose($filenum);
}

echo '<h3>BOMed LIST:</h3>';
echo '<pre>';
print_r($bomed_list);
echo '</pre>';
?>
