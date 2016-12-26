<?php
$dbh = new PDO('mysql:host=127.0.0.1;dbname=photo','user','pass');

$stmt = $dbh->query('select id, path from piwigo_images where md5sum is null');
$counter = 0;
foreach($stmt as $a){
	$dbh->query("update piwigo_images set md5sum = '" . md5_file($a['path']) . "' where id = " . $a['id'] );
	echo ++$counter . "\t";
}
echo "\n";

?>
