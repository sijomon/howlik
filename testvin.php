<?php

define("SERVER","localhost");
define("USER","new_classifieds");
define("PASSWORD","new_classifieds123!");
define("DATABASE","new_classifieds");

$conn = mysql_connect(SERVER, USER, PASSWORD) or die(mysql_error());
mysql_select_db(DATABASE, $conn) or die(mysql_error());

$tempA = array();
$dupeA = array();
$qry = mysql_query("SELECT id, country_code, title, lat, lon, address1, zip FROM business WHERE id>6564 ORDER BY id");
while($res = mysql_fetch_assoc($qry)){
	if(isset($tempA[trim($res['title'])])){
		$count = 2;
		if(isset($dupeA[trim($res['title'])])){
			$count = $dupeA[trim($res['title'])]['count'];
			$count++;
		}else{
			$dupeA[trim($res['title'])][] = $tempA[trim($res['title'])];
		}
		$dupeA[trim($res['title'])][] = array('id'=>trim($res['id']), 'address'=>trim($res['address1']), 'zip'=>trim($res['zip']), 'country_code'=>trim($res['country_code']), 'lat'=>trim($res['lat']), 'lon'=>trim($res['lon']), 'count'=>$count );
	}
	$tempA[trim($res['title'])] = array('id'=>trim($res['id']), 'address'=>trim($res['address1']), 'zip'=>trim($res['zip']), 'country_code'=>trim($res['country_code']), 'lat'=>trim($res['lat']), 'lon'=>trim($res['lon']) );
}

/*echo "<pre>";
print_r($tempA);
exit;*/

/*
//Code to make xls of All entiries
//define separator (defines columns in excel & tabs in word)
$sep = "\t"; //tabbed character
$fp = fopen('allbusiness.xls', "w");
$schema_insert = "";
$schema_insert_rows = "#".$sep."Title".$sep."Address".$sep."Zip".$sep."Country".$sep."Lat".$sep."Lon".$sep."\n";
fwrite($fp, $schema_insert_rows);
//start of printing column names as names of MySQL fields
$i = 1;
foreach($tempA as $key => $value){
	$cnt = count($value);
	$schema_insert = $i.$sep.$key.$sep.$value['address'].$sep.$value['zip'].$sep.$value['country_code'].$sep.$value['lat'].$sep.$value['lon'].$sep;
	$i++;
	$schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
	$schema_insert .= "\n";
	fwrite($fp, $schema_insert);
}
fclose($fp);
*/


/*
//Code to make xls of repeated entiries
//define separator (defines columns in excel & tabs in word)
$sep = "\t"; //tabbed character
$fp = fopen('duplicate.xls', "w");
$schema_insert = "";
$schema_insert_rows = "#".$sep."Title".$sep."Address".$sep."Zip".$sep."Country".$sep."Lat".$sep."Lon".$sep."Total".$sep."Duplicate".$sep."\n";
fwrite($fp, $schema_insert_rows);
//start of printing column names as names of MySQL fields
$i = 1;
foreach($dupeA as $key => $value){
	$cnt = count($value);
	print_r($value);
	$schema_insert = $i.$sep.$key.$sep.$value[0]['address'].$sep.$value[0]['zip'].$sep.$value[0]['country_code'].$sep.$value[0]['lat'].$sep.$value[0]['lon'].$sep.$cnt.$sep.($cnt-1).$sep;
	$i++;
	$schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
	$schema_insert .= "\n";
	fwrite($fp, $schema_insert);
}
fclose($fp);
*/

/*
//Code to delete repeated entries
foreach($dupeA as $name => $value){
	foreach($value as $key => $biz){
		if($key>0){
			mysql_query("DELETE FROM `business` WHERE id='".$biz['id']."'");
			mysql_query("DELETE FROM `businessImages` WHERE biz_id='".$biz['id']."'");
			mysql_query("DELETE FROM `businessLocations` WHERE biz_id='".$biz['id']."'");
		}
	}
}
*/
?>