<?php
$counter = 0;
$dbh = new PDO('mysql:host=127.0.0.1;dbname=photo','user','pass');
// echo "hi begin";
$basedir = "./galleries";
$structure[] .= $basedir;
foreach(scandir($basedir) as $dir){
		if(($dir == "." || $dir == "..")) continue;
	// echo implode($structure) . "/" . $dir . "\n" ;
	if(is_dir(implode($structure) . "/" . $dir)){
		domyscan($basedir . "/" . $dir);
	}
}
echo "\nCounter is " . $counter;



function domyscan($dir){
	foreach(scandir($dir) as $thedir){
		// echo "hiiiii";
		if(is_file($dir . "/" . $thedir)){
			if(preg_match('/.*[\(|\)].*/',$thedir,$data)){
				// echo "\nfound one\t";
				if($test = preg_replace('/[\(|\)]/','-',$thedir)) {
					echo $thedir. " is now " . $test . "\n";
					$copiedfrom = $dir . "/" . $thedir;
					$copiedto = $dir . "/" . $test;
					// copy($copiedfrom,$copiedto);
					global $dbh;
					// $dbh->query('insert into imagescopied (copiedfrom,copiedto) values ("' . $copiedfrom . '","' . $copiedto . '")');
					global $counter;
					$counter++;
				}
			}
		}


		if(is_dir($dir . "/" . $thedir)){
			if(!($thedir == "." || $thedir == "..")){

				domyscan($dir . "/" . $thedir);

			}

		}
	}
}

?>
