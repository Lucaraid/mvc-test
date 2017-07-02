<?php
$f = fopen("../app/installation/install.txt", "r");
while(!feof($f)) { 
	echo str_replace( "|TAB|", "&nbsp;&nbsp;&nbsp;&nbsp;", fgets($f) ) . "<br />";  

} 
fclose($f);
?>