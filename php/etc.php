<?php

function echoerrors($file, $line, $str){
	global $errors;
	$file=basename($file);
	
	if (isset($errors[$file][$line]['Text'])){
		//echo "old: ";
		if (strrpos($errors[$file][$line]['Text'],$str)!=false) $errors[$file][$line]['count']++;
		else $errors[$file][$line]['Text'].="| ".$str.' ';
	}
	else{
		//echo "new: ";
		if (!isset($errors[$file])) $errors[$file]=[];
		if (!isset($errors[$file][$line])) $errors[$file][$line]=[];
		$errors[$file][$line]['Text']=' '.$str. ' ';
		$errors[$file][$line]['count']=1;	
				
	}
	
	
	//echo "$file , $line, $str";
} //add issue to errorlog array

function array_key($array, $name ='origin', $n=0){
	if ($n==0) 	$str="<table id = '$name'><tr><th colspan=2>".$name." = ".gettype($array)."</th></tr>";
	else 		$str='<button type="button"  onclick="toogle_array_key(this)">toogle</button> <table id = '.$name.' style="visibility: collapse;"><tr><th colspan=2>'.$name.' = '.gettype($array)."</th></tr>";
	
	
	if (gettype($array) == 'array' ) {
		//$str .= "Array keys: </br>";
		
		foreach($array as $key => $value) {
			
			if (gettype($value) != 'array' ) {
				//if (strlen($value)>100) $value= substr($value, 0, 97)."...";
				$str .= "<tr><td>$key</td><td>value => $value</td></tr>";
			}
			else {
				
				
				$thisname=$name.'['.$key.']';
				$str .= "<tr><td>$key</td><td>".array_key($value, $thisname, $n+1)."</td></tr>";
				//$str .= "]";
			}
			//$str .= '</br>';
		}
		//$str .= '</br>';
	}
	
	elseif (gettype($array) == 'object'  ) {
		$str = "Object keys:";
		$array= (array)$array;
		foreach(array_keys($array) as $key) {
				$str .= $key;
				if (gettype($array[$key]) != 'array' ) $str .= " = $array[$key]";
				else  $str .= " = [...]";
				$str .= '</br>';
			}
		$str .= '</br>';
	}
	else $str = "Data: ".var_export($array, true).'</br>';
	
	$str .= '</table>';	
	//echo htmlentities ($str);
	return $str;
	//return true;
} // Array(num/asso) visualized in a Table returns (html)string.  Objects will be convert to array

function EMS_get_age_on_time_by_id($id, $time = null){
	global $data;
	if(!isset($time)) $time=time();
	if(!isset($data['user'][$id]['fum_birthday'])){
		echoerrors(__FILE__,__LINE__,"User: $id has no/invalid Bday");
		return false;
	}
	$bday= strtotime($data['user'][$id]['fum_birthday']);
	//var_dump($bday);var_dump($time);
	$return=intval(($time - $bday) / (3600 * 24 * 365));
	return $return;
} // return Age of user($id) on given $time or now 

function EMS_get_Eventyear_by_Event_ID($id){
	global $data;
	if (!isset($data['lists']['posts'][$id])){
		echoerrors(__FILE__,__LINE__,"Get Year _ Eventid $id was not found!");
		return false;
	}
	if (!isset($data['lists']['posts'][$id]['year'])){
		echoerrors(__FILE__,__LINE__,"Get Year _ Eventid $id [year] was not found! ");
		return false;
	}
	$year =$data['lists']['posts'][$id]['year'];
	
	return $year;
} //return year of Event ($id)

function EMS_get_Eventdate_by_Event_ID($id){
	global $data;
	if (!isset($data['lists']['posts'][$id])){
		echoerrors(__FILE__,__LINE__,"Eventid $id was not found!");
		return false;
	}
	if (!isset($data['lists']['posts'][$id]['year'])){
		echoerrors(__FILE__,__LINE__,"Get Year _ Eventid $id [year] was not found! ");
		return false;
	}
	$date =$data['lists']['posts'][$id]['ems_start_date'];
	
	return $date;
} //return date of Event ($id)

function EMS_get_Eventname_by_Event_ID($id){
	global $data;
	
	return $data['lists']['posts'][$id]['post_titel'];
	
} //return name of Event ($id)

function array2JS($array, $name){
	$str="<script>var ".$name." = ".json_encode($array).";</script>";
	return $str;
} // publish array to js array via json_encode

function microtime_float(){
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
} //return time as microtime in float

function get_input_col($tableid, $chartid, $year=null){
	$thistableid= $tableid.'_view';
	$thiscolorid = $chartid.'_color';
	//echo $chartid."</br>";
	if(intval(explode ('_', $chartid)[2])!=false){
		$ymin=2014;
		$y= explode ('_', $chartid)[2]-$ymin+1;

		$ymax=date('Y')-$ymin+1;
		$default=(string)dechex(255-$y*255/$ymax);
		$default .= $default;
	}
	else $default=(string)dechex(mt_rand(0,65535));
	//echo($default.'</br>');
	$str = "<td>
	<input type='checkbox' id='$thistableid' onclick="."EMS_S_toogleStuff(this) '>Tabelle $year</br>
	<input type='checkbox' id='$chartid' onclick="."EMS_S_charttoogle(this) '>Chart $year 
	<input type='color' id='$thiscolorid' onchange="."EMS_S_chartpaint(this) value='#$default"."ff'></td>";
	return $str;
} //return (html)string for imputfield to toogle charts or tables (part of a table: only <td>...</td> part)

function contains_at_least_one_word($input_string) {
  foreach (explode(' ', $input_string) as $word) {
    if (!empty($word)) {
      return true;
    }
  }
  return false;
} //returns answer to questis is $input_string only one word (string without space);

function knownissue($type, $id){
	global $data;
	//echo $type.' '.$id.'</br>';
	if (isset($data['db_correction'][$type][$id])){
		//echo "skrip!";
		return true;
	}
	else return false;
} //returns answer to question isset ($data[db_correction][$type][$id] 

?>
