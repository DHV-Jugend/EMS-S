<?php


function readdata($file){
	
	$lines = file((string)$file);
	
	return $lines;
} // read data --> return lines in array

function read_geo_data($file){
	$temp_array= readdata($file);
	$firstline=preg_split('/\s+/', $temp_array[0]);
	//echo array_key($firstline);
	$contry=$firstline[0];
	$contry_len=strlen ($contry);
	$postcode_len=strlen ($firstline[1]);
	
	
	$array=[];
	$str="";
	foreach($temp_array as $row){
		$row= substr($row, 0, -2);
		$row= explode('	', $row);
		if(!isset($array[$row[1]])) $array[$row[1]]=[];
		$array[$row[1]][$row[2]]['state']=$row[0];
		$array[$row[1]][$row[2]]['federal state']=$row[3];
		$array[$row[1]][$row[2]]['fs']=$row[4];
		$array[$row[1]][$row[2]]['district']=$row[7];
		$array[$row[1]][$row[2]]['north']=$row[9];
		$array[$row[1]][$row[2]]['east']=$row[10];
		
	}
	//echo array_key($array);
	return $array;
	
	
} // read data --> return (array)[zipcode][vilagename]...


?>