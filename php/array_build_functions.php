<?php
function get_empty_data_EMSS()	{
	global $data, $wpdb;
	$table_emss		= $wpdb->prefix . "emss"; 
	$request8="SELECT id, value_data FROM $table_emss WHERE value_type = 'affected' ";
	$emss_ids = $wpdb->get_results( $request8, 'ARRAY_A' );
	//echoerrors(__FILE__,__LINE__,array_key($emss_ids));
	//echo array_key($emss_ids);
	
	foreach($emss_ids as $row){
		$id = $row['id'];
		$data['db_correction'][$row['value_data']][$id]=[];
		if (!isset($data['db_correction'][$row['value_data']]['ids'])) $id_list =[$id];
		else {
			$id_list=explode(' ',$data['db_correction'][$row['value_data']]['ids']);
			array_push($id_list, $id);
		}
		$data['db_correction'][$row['value_data']]['ids']=implode(' ', $id_list);
	}
} //get EMSS ID's and grate empty Array

function fill_Data_EMSS(){
	get_empty_data_EMSS();
	global $data, $wpdb;
	
	$table_emss 		= $wpdb->prefix . "emss"; 
	$request7="SELECT * FROM $table_emss ";
	$emss_temp = $wpdb->get_results( $request7, 'ARRAY_A' );
	
	foreach($emss_temp as $row){
		$id = $row['id'];
		foreach($data['db_correction'] as $key => $data_row){
			$id_list=explode(' ',$data_row['ids']);
			
			if (!in_array($id, $id_list))continue;
			$data['db_correction'][$key][$id][$row['value_type']]=$row['value_data'];
			
		}
	}
	$temp =$data['db_correction'];
	
	foreach($temp as $type => $typevalues){
		
		unset($data['db_correction'][$type]['ids']);
		foreach($typevalues as $key => $values ){
			if (gettype($values)!='array') continue;
			
			$data['db_correction'][$type][$values['id']] = $values;
			unset($data['db_correction'][$type][$key]);
		}
	}
} //fill EMSS array!


?>