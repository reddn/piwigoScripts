<?php
$dbh = new PDO('mysql:host=127.0.0.1;dbname=photo','user','pass');

$stmt = $dbh->query('select id, path, file from piwigo_images where date_creation is null');
$counter = 0;
$errored = 0;
	$matchedpattern3 =0;
foreach($stmt as $a){

	$pattern =  '/.*(\d{4})(\d{2})(\d{2}).*(?:(\d{2})(\d{2})(\d{2}))/';   //1219160028.mp4 2015-12-05 20.29.08.mp4
																	// 2016-08-08 14.16.43.jpg
	$pattern = preg_match($pattern,$a['file'],$date);


	$pattern2 = '/.*(\d{2})(\d{2})(\d{2})(\d{2})(\d{2}).*/';
	$pattern2 = preg_match($pattern2,$a['file'],$date2);

	$pattern3 = '/.*(\d{4})\W(\d{2})\W(\d{2})([\s|_](\d{2})\W(\d{2})\W(\d{2}))?.*/';
		// $pattern3 = '/.*(\d{2})(\d{2})(\d{2})(\d{4}).*/';
		$pattern3 = '.*(\d{4})\W(\d{2})\W(\d{2})?[\s|_]+(\d{2})?[^\d]+(\d{2})?[^\d]+(\d{2})?[^\d]+.*';
	$pattern3 = '/.*(\d{4})\W(\d{2})\W(\d{2})?[\s|_]?(\d{2})?[\s|_]?(\d{2})?[\s|_]?(\d{2})?[^\w|_]?(\d{2})?[\s|_]?.*/';
	$pattern3= '/.*(\d{4})\W(\d{2})\W[\s|_|\.|\W]?(\d{2})?[\s|_|\.|\W]?(\d{2})?[\s|_|\.|\W]?(\d{2})?[\s|_|\.|\W]?(\d{2})?.*/';
	$pattern3 = preg_match($pattern3,$a['file'],$date3);

	$pattern4 = '/.*[^\d{4}]\D(\d{2})[\D&\s|_|\.|\W](\d{2})[\s|_|\.|\W]?(\d{2})[\s|_|\.|\W]?(\d{2})?[\s|_|\.|\W]?(\d{2})?.*/';
	$pattern4 = preg_match($pattern4,$a['file'],$date4);

	if($pattern){
		echo "\npattern " . $a['file'];
		$size = sizeof($date);
		// echo "\n size of pattern is " . $size;
		// print_r($date);
		$thedate = $date[1];
		$size1 = $size>3?3:$size;
		for($i=2;$i<$size1+1;$i++){
			$thedate .= "-" . $date[$i];
		}
		if($size>3){
			$thedate .= " " . $date[4];
			for($i=5;$i<$size;$i++){
				$thedate .= ":" . $date[$i];
			}
		}

		echo "\t" . $thedate;
		// $dbh->query("insert into imagesIfuckedwith (id) values (" . $a['id'] . ")");
		$dbh->query("update piwigo_images set date_creation = '" . $thedate . "' where id = " . $a['id'] );
	}
	if($pattern2) {
		if($pattern)echo "\n********************************";
		// echo "\npattern2 " . $a['file'];
				echo "\npattern2 " . $a['file'];
		$size = sizeof($date2);
		// echo "\n size of pattern is " . $size;
		// print_r($date);
		$thedate = $date2[1];
		$size1 = $size>3?3:$size;
		for($i=2;$i<$size1+1;$i++){
			$thedate .= "-" . $date2[$i];
		}
		if($size>3){
			$thedate .= " " . $date2[4];
			for($i=5;$i<$size;$i++){
				$thedate .= ":" . $date2[$i];
			}
		}

		echo "\t" . $thedate;
		// $dbh->query("insert into imagesIfuckedwith (id) values (" . $a['id'] . ")");
		$dbh->query("update piwigo_images set date_creation = '" . $thedate . "' where id = " . $a['id'] );

	}
	if($pattern3) {
		if($pattern2||$pattern) echo "\n*************************";
		// echo "\npattern3 " . $a['file'];
				echo "\npattern3 " . $a['file'];
		$size = sizeof($date3);
		// echo "\n size of pattern is " . $size;
		// print_r($date3);
		$thedate = $date3[1];
		$size1 = $size>3?4:$size;

		for($i=2;$i<$size1;$i++){
			$thedate .= "-" . $date3[$i];
		}
		if($size>3){
			$thedate .= " " . $date3[4];
			for($i=5;$i<$size;$i++){
				$thedate .= ":" . $date3[$i];
			}
		}
		// $dbh->query("insert into imagesIfuckedwith (id) values (" . $a['id'] . ")");
		$dbh->query("update piwigo_images set date_creation = '" . $thedate . "' where id = " . $a['id'] );
		echo "\t" . $thedate;
		$matchedpattern3++;
	}
	if($pattern4){
		if($pattern2||$pattern||$pattern3) echo "\n*************************\n******************************";
		// echo "\npattern3 " . $a['file'];
				echo "\npattern4 " . $a['file'];
		$size = sizeof($date4);
		// echo "\n size of pattern is " . $size;
		// print_r($date3);
		$thedate = "20" . $date4[1];
		$size1 = $size>3?4:$size;

		for($i=2;$i<$size1;$i++){
			$thedate .= "-" . $date4[$i];
		}
		if($size>3){
			$thedate .= " " . $date4[4];
			for($i=5;$i<$size;$i++){
				$thedate .= ":" . $date4[$i];
			}
		}
		// $dbh->query("insert into imagesIfuckedwith (id) values (" . $a['id'] . ")");
		$dbh->query("update piwigo_images set date_creation = '" . $thedate . "' where id = " . $a['id'] );
		echo "\t" . $thedate;
	}
	if(!$pattern && !$pattern2 && !$pattern3 && !$pattern4){
		echo "\nfound none*********" . $a['file'];
	}
	continue;




	if($myerror <1){
		echo "\nerror " . $a['file'];
		$errored++;
		continue;
	}
	$year = $date[1];
	if(!($year < 2020 && $year > 2000)) $myerror = 0;

	$month = $date[2];
	if(!($month < 13 && $month > 0)) $myerror = 0;
	$day = $date[3];
	if(!($day < 32 && $day > 0)) $myerror = 0;

	// echo "year " . $year . "  month " . $month . "  day " . $day . "\n";
	if($myerror <1){
		echo "\nif matched:" . $ifmatched . "  error " . $a['file'];
		$errored++;
		continue;
	}
	if($myerror <1){
		echo "it did not break \n";
		// break;

	}
	// $dbh->query("update piwigo_images set date_creation = '" . md5_file($a['path']) . "' where id = " . $a['id'] );

	echo $ifmatched . "-" .++$counter . "\t";
}
echo "\nErrored: " . $errored . "\n";
echo "\nPattern3: " . $matchedpattern3 . "\n";


function testDateLayout($a){


}


?>
