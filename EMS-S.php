<?php
/*

Plugin Name: Event Managment System Statistics
author: Ingo Fleckenstein
Description: Statistikerweiterung für EMS
version: 1.02
email: ingo@smallspotstone.de

link: http://smallspotstone.de

*/

$data=[];
$tick=0;
$errors=[];

include __DIR__.'/php/content_functions.php';
include __DIR__.'/php/content_creat_functions.php';
include __DIR__.'/php/array_build_functions.php';
include __DIR__.'/php/data_work_functions.php';
include __DIR__.'/php/db_work_functions.php';
include __DIR__.'/php/etc.php';



register_uninstall_hook( __FILE__ , 'uninstall' );
function uninstall(){
	global $wpdb;
	$datatable = $wpdb->prefix . 'emss';
	$wpdb->query("DROP TABLE $datatable");
	
}
	
register_activation_hook( __FILE__ , 'myhome_activation_function' );
function myhome_activation_function() {
	global $wpdb;

	creat_DB_tables();
	fill_costom_emss();
		

} //call Setup functions creat_DB_tables()

add_action( 'admin_menu', 'EMSS_Options' );
function EMSS_Options(){
	
  $page_title = 'EMS_Statistics';
  $menu_title = 'EMS_Statistics';
  $capability = 'manage_options';
  $menu_slug  = 'EMS_Statistics';
  $function   = 'emss_options_page';
  $icon_url   = 'dashicons-admin-home';
  $position   = 999;

  add_options_page( $page_title,
                 $menu_title, 
                 $capability, 
                 $menu_slug, 
                 $function);
} //Options for Admin Menu Page

function emss_option_page_get($get){
	global $wpdb, $data;
	$table_emss 		= $wpdb->prefix . "emss"; 
	
	if (!isset($get["mode"])) $get["mode"]=null;
	
	if ($get["mode"]=='db'){
		if(!isset($get["type"]) or !isset($get["affected"]) or !isset($get["id"]) or !isset($get["info"])){
			echo("<h3>Unzureichende Dateineingebe</h3>");
		}
		
		elseif($get["type"]=='skip'){
			
			$type=$get["type"];
			$affected=$get["affected"];
			$affectedid=$get["id"];
			$info=$get["info"];
			write2emss($type, $affected, $affectedid, null , null , $info);
			echo("<h3>Erfolgreich Gespeichert!</h3>");
		}
	
		elseif($get["type"]=='add'){
			
			$type=$get["type"];
			$affected=$get["affected"];
			$data=$get["data"];
			$affectedid=$get["id"];
			$info=$get["info"];
			write2emss($type, $affected, $affectedid, null , $data , $info);
			echo("<h3>Erfolgreich Gespeichert!</h3>");
		}
	}
	elseif($get["mode"]=='gender'){
		if(isset($get["user_id"]) and isset($get["gender"])){
			$table_usermeta 	= $wpdb->prefix . "usermeta";  	

			$wpdb->update( $table_usermeta,array('meta_value' => $get["gender"]), 	array( 'user_id' => $get["user_id"] , 'meta_key' => 'emss_gender'), 			array ('%s'), array ('%s', '%s'));
			$wpdb->update( $table_usermeta,array('meta_value' => 100), 				array( 'user_id' => $get["user_id"] , 'meta_key' => 'emss_gender_accuracy'),	array ('%s'), array ('%s', '%s'));
			echo("<h3>Erfolgreich Gespeichert!</h3>");

			$type=null;
			$affected=null;
			$affectedid=null;
			$info=null;
		}
	}
	elseif($get['mode']=='option'){
		foreach($data['db_correction']['config']['adminmenu'] as $key => $value){
			if(substr($key,0,4)=='show'){
				if (!isset($get[$key])) $value=0;
				else $value=1;
				
				$updated = $wpdb->update( $table_emss, array('value_data' => $value), array('id' => 0, 'value_type' => $key) );
				$data['db_correction']['config']['adminmenu'][$key] =$value;
				if ($updated) echo "<h3>Erfolgreich Gespeichert!</h3>";
				
			}
			
			
		}
		$type=null;
		$affected=null;
		$affectedid=null;
		$info=null;
	}
	else{
		$type=null;
		$affected=null;
		$affectedid=null;
		$info=null;
	}
	
	$array = array(
		'table_emss' => $table_emss,
		'type' => $type,
		'affected' => $affected,
		'affectedid' => $affectedid,
		'info'	=> $info		
	);
	
	return $array;
}

function emss_options_page(){
	global $wpdb, $data;
	fill_Data_EMSS();	
	$default = emss_option_page_get($_GET);
	
	$table_emss =	$default['table_emss'];
	$type =			$default['type'];
	$affected =		$default['affected'];
	$affectedid =	$default['affectedid'];
	$info =			$default['info'];
	{
		
	
		
		
	echo "
		<h1>Options</h1>
		<table><form action='/wp-admin/admin.php'>
  		<input type='hidden' name='page' value='EMS_Statistics'>
		<input type='hidden' name='mode' value='option'>";	
		
		foreach($data['db_correction']['config']['adminmenu'] as $key => $value){
			if(substr($key,0,4)=='show'){
				echo "<tr><th>$key</th><td><input type=checkbox name=$key id=$key ";
				if($value) echo "checked";
				echo " ></td></tr>";
			}
		}
		
	echo "
		<tr><td colspan=2><input type='submit' value='Speichern'></td></tr>
		</form></table>
		<hr>
	";
	} // Option

	{
	echo "
	<script>
		function ask() {
		  var type = document.getElementById('type').value;
		  var affected = document.getElementById('affected').value;
		  var id = document.getElementById('id').value;
		 return confirm('Bist du Sicher, dass du |'+type+'| Datensatz: |'+affected+'| |'+id+'| in die Datenbank eintragen willst?');
}

		function toogle( obj ){
		//console.log(obj);
			value= obj.value;
			hiddenobj= document.getElementById('hiddenopt');
			console.log(value);
			if (value == 'skip'){
				hiddenobj.style.display = 'none';
			}
			else{
				hiddenobj.style.display = '';
			}
		}
		
	</script>
	
	<h1>Hinzufügen $table_emss Daten</h1>
	<table>
	 <form action='/wp-admin/admin.php'>
  		<input type='hidden' name='page' value='EMS_Statistics'>
		<input type='hidden' name='mode' value='db'>
		<tr><th>Type:</th><td><select name='type' id='type' onchange='toogle(this)' value='$type' >
						  		<option value='skip'>skip</option>
								<option value='add'>add</option>
							  </select></td></tr>	
		  <tr><th>Beeinflusst:</th><td><select name='affected' id='affected'  value='$affected' >
			<option value='user'>user</option>
			<option value='page'>post</option>
		  </select></td></tr>
  		
		<tr><th>Betroffener Datensatz -> ID:</th><td>	<input type='number' name='id' id='id' value='$affectedid' required></td></tr>
		<tr style='display:none;' id='hiddenopt'><th>Daten (JSON Array)</th><td>	<input type='text' name='data' id='data' ></td></tr>
		<tr><th>Warum?</th><td>				<input type='text' name='info' value='$info' required></td></tr>
  	<tr><td colspan=2>
  		<input type='hidden' id='page' value='EMS_Statistics'><input type='submit' onclick='return ask()' value='Speichern'></td></tr>
	</form> 
	</table>
	
	
	
	<hr>";
	} // Zur DB hinzufügen

	{
	echo "<h1>Manuell Gender insert!</h1>
	";
	
	$table_usermeta 	= $wpdb->prefix . "usermeta";  	
	$request4="SELECT user_id FROM $table_usermeta WHERE meta_key = 'emss_gender' and meta_value = 'a_unknown' limit 1";
	$userids =	$wpdb->get_results( $request4, 'ARRAY_N' );
	
	//echoerrors(__FILE__,__LINE__,array_key($userids);
	if($userids != []){
		$userid=$userids[0][0];
		$request4="SELECT meta_key , meta_value FROM $table_usermeta WHERE user_id = $userid";

		$userdatas =	$wpdb->get_results( $request4, 'ARRAY_A' );
		$userdata=[];
		
		foreach($userdatas as $row){
			if ($row['meta_value']=="") $row['meta_value']='leer';
			 $userdata[$row['meta_key']]=$row['meta_value'];
		}

		$email = $userdata['user_email'];
		$name = $userdata['first_name'];
		$last_name = $userdata['last_name'];
		$user_login = $userdata['user_login'];
		//echo (array_key($userdata));

		echo "
		<table>
			<form action='/wp-admin/admin.php'>
			<input type='hidden' name='page' value='EMS_Statistics'>
			<input type='hidden' name='mode' value='gender'>
			<input type='hidden' name='user_id' value=$userid>
				<tr>
				<tr><td colspan=3>Name: $name</td></tr><tr><td colspan=3>Surname: $last_name</td></tr><tr><td colspan=3>User Login: $user_login</td></tr><tr><td colspan=3>E-Mail: $email</td></tr><tr><td><input type='submit' value='male' name='gender'></td><td><input type='submit' value='female' name='gender'></td><td><input type='submit' value='unknown' name='gender'></td></tr>
				</tr>
			</form> 
		</table>

		";}
	else echo ("<h3>Keine Daten zur auswertung vorhanden!</h3>");
	} // Manuell Gender insert!
	
	
} //Page on Adminmenu

add_action('wp_enqueue_scripts','js_init');
function js_init() {
    wp_register_script( 'moment.js', plugins_url( '/js/moment.min.js', __FILE__ ));
    wp_register_script( 'chart.js', plugins_url( '/js/chart.min.js', __FILE__ ));
    wp_register_script( 'EMS-S.js', plugins_url( '/js/EMS-S.js', __FILE__ ));
	wp_enqueue_script ('moment.js');
	wp_enqueue_script ('chart.js');
	wp_enqueue_script ('EMS-S.js');
} //Load Java scripts für chart visualisation

add_shortcode('EMSS_Show_Statistics', 'EMSS_Show_Statistics_function');
function EMSS_Show_Statistics_function($atts){
	global $data, $errors, $tick;	
	$tick =microtime_float ();
	$process_time =0;	
	
	if (!current_user_can('edit_posts')){
  		return "<h1>Zugriff verweigert! Nur für Eventleiter!</h1><a href='". wp_login_url( get_permalink() ) ."' title='Login'>Login</a>";
 	}
		
	$options =build_option_row_settings();
	build_arrays();
	
	$return_str = '';
	$return_str .= add_category_menu($options);
	
	$tock =microtime_float();
	$process_time =round(($tock-$tick)*1000, 2) ;
	
	$return_str .= "Bearbeitungszeit für diesen ShortKey = $process_time ms </br>";
	ksort($data['user']);
	if ($data['db_correction']['config']['adminmenu']['show_data']== 1) $return_str .= array_key($data, '$data');
	if ($data['db_correction']['config']['adminmenu']['show_ERRORS']== 1) $return_str .= array_key($errors, 'ERRORS');
	
	
	
	return $return_str;
} // Main Shortcut === Start of all happening

function add_category_menu( $options = array() ){
	/*
		$functions[#]['name']=name;
		$functions[#]['functionname']=functionname;
		$functions[#]['registername']=Register Name;
	*/
	global $data;
	$id='EMS_S_Content_';
	
	$str = '<table><tr>';
	$n=1;
	foreach($options as $function){
		$str .= "<td><button type='button' onclick="."EMS_S_showStuff('".$id."',$n)>".$function['disp_name']."</button></td>";
		
		$r=$n % 6;
		if ($n != 0 and $r == 0) $str .="</tr><tr>";
		$n= $n+1;
	}
	$str .= '</tr><tr><td colspan = "'.$n.'">';
	$n=1;
	$id='EMS_S_Content_';
	$str .= '<div id='.$id.'0 >'.Content_default($data).'</div>';
	foreach($options as $function){
		$funcname = 'Content_'.$function['id'];
		$str .= '<div id='.$id.$n.' style="display: none;">'.$funcname($data).'</div>';
		$n= $n+1;
	}
		
	
	$str .= '</td></tr></table>';
	
	return $str;
} //Create Input Of MainRegisters and fill Content from function

function build_arrays(){
	global $wpdb, $data;
	global $tick;

	
	{
	$table_EMS_Reg 		= $wpdb->prefix . "ems_event_registration"; 
	$table_EMS_Reg_Log 	= $wpdb->prefix . "log_ems_eventregistration"; 
	$table_users 		= $wpdb->prefix . "users"; 	
	$table_usermeta 	= $wpdb->prefix . "usermeta";  	
	$table_posts 		= $wpdb->prefix . "posts";   	
	$table_postmeta 	= $wpdb->prefix . "postmeta"; 
	
	}// ------ Define wp tabels ---------
	
	{
		$request1="SELECT user_id, event_id, data, deleted, create_date, modify_date ,delete_date FROM ".$table_EMS_Reg;
		$request2="SELECT ID, post_title FROM ".$table_posts." WHERE post_type = 'ems_event' AND post_parent != '0'  ORDER BY `wp_posts`.`ID` ASC";
		$request3="SELECT ID, user_email, user_registered FROM ".$table_users;
		$request4="SELECT user_id, meta_key, meta_value FROM ".$table_usermeta." WHERE meta_key IN ('first_name', 'last_name', 'fum_birthday', 'fum_street', 'fum_city', 'fum_postcode', 'fum_state', 'fum_aircraft', 'fum_license_number', 'fum_premium_participant', 'fum_dhv_member_number', 'emss_fed_state', 'emss_gender', 'emss_gender_accuracy')";
		$request5="SELECT time, user, event FROM $table_EMS_Reg_Log WHERE message = 'Added event registration.'";
		$request6="SELECT time, user, event FROM $table_EMS_Reg_Log WHERE message = 'Deleted event registration.'";
		
	}// ------ Define SQL Requests ---------
	
	{
		$EMR_temp = 		$wpdb->get_results( $request1, 'ARRAY_A' );
		$posts = 	$wpdb->get_results( $request2, 'ARRAY_A' );
		$users =	$wpdb->get_results( $request3, 'ARRAY_A' );
		$usermeta_temp =	$wpdb->get_results( $request4, 'ARRAY_A' );
		$register = $wpdb->get_results( $request5, 'ARRAY_A' );
		$deregister = $wpdb->get_results( $request6, 'ARRAY_A' );
		

		//echoerrors(__FILE__,__LINE__,sizeof($EMR_temp));

	}// ------ Get all DATA from DB ------------
	
	{
	
	$data['db_correction']=[];
	
	fill_Data_EMSS();
	}// ------ Realine emss for better use -----
	
	//echoerrors(__FILE__,__LINE__,array_key($data['known_issue']));
	
	{
	
	$ids_temp =$wpdb->get_results( "SELECT post_id from ".$table_postmeta." WHERE meta_key = 'ems_start_date'", 'ARRAY_N' );
	$ids ='(';
	foreach($ids_temp as $id) $ids .= $id[0].',';
	$ids = substr($ids, 0, -1);
	$ids .= ')';
	}				// ------ Get post_ids for Relevant Pages by "ems_start_date" meta_key -----------
	
	{
	
	$request5="SELECT * FROM ".$table_postmeta." WHERE post_id IN $ids";
	$postmeta_temp =	$wpdb->get_results( $request5, 'ARRAY_A' );
	}				// ------ Get relevant wp_postmeta Data vom DB -------------
	
	{
	
	//echoerrors(__FILE__,__LINE__,array_key($usermeta_temp));
		
	if (!isset($data['user'])) $data['user']=[];
	foreach($usermeta_temp as $row){
		
		if (knownissue('user', $row['user_id'])){
			$id =$row['user_id'];
			echoerrors(__FILE__,__LINE__."_n", "SKIP user: $id");
			continue;
		}
		if (!isset( $data['user'][ $row['user_id'] ] ) ) $data['user'][$row['user_id']]=[ ];
		
		if( $row['meta_key'] == 'fum_state' ) $data['user'][ $row['user_id'] ][ $row['meta_key'] ] = false;
		else $data['user'][ $row['user_id'] ][ $row['meta_key'] ] = $row['meta_value'];
		
		
		}
		
		//$data['user'][$row['user_id']]['api_city']
		
		//if ($row['user_id']=='30') echoerrors(__FILE__,__LINE__,'30';
	} 				// --------- $usermeta_temp --> $data['user'] -----------
	
	foreach($users as $row){
		if(isset($data['user'][$row['ID']])) {
			$data['user'][$row['ID']]['reg_date']= strtotime($row['user_registered']);
			$data['user'][$row['ID']]['user_email'] = $row['user_email'];
		}
	} 						// -------  $users --> $data['user'] --------------
	
	foreach($data['user'] as $user => $userdata){
		if (empty($userdata['emss_fed_state'])){
			//echoerrors(__FILE__,__LINE__,"$user");
			if (!isset($userdata['fum_postcode'])) {
				echoerrors(__FILE__,__LINE__," $user ");
				continue;
			}
			
			if ($userdata['fum_postcode']==''){
				//
				if($userdata['fum_state']==''){
					if($userdata['fum_city']==''){
						//echoerrors(__FILE__,__LINE__,"All User $user data are empty </br>"); 
						continue;
					}
					echoerrors(__FILE__,__LINE__,"User $user has City value </br>"); 
					
				}
			}
			{

				$postcode=(string)$userdata['fum_postcode'];
				$fed_state =$userdata['fum_state'];
				$city =$userdata['fum_city'];


				if (!isset($data['p_code'])) {
					$data['p_code']=read_geo_data(plugin_dir_path( __FILE__ )."data/DE.txt");
					//echoerrors(__FILE__,__LINE__,'Lade p_code Datei...<br>');
				} //Lese DE Datenbankdatei

				if (!isset($data['p_code'][$postcode])){

					echoerrors(__FILE__,__LINE__,"User $user has undefined Postcode: $postcode and $fed_state and $city --> lookup @ GeoNames with cityname</br>");
					
					if (contains_at_least_one_word($city)) $city=explode(' ',$city)[0];
					
					$url_array=(array)json_decode(file_get_contents("http://api.geonames.org/searchJSON?q=$city&country=FR&country=DE&country=IT&country=CH&country=AT&username=smallspotstone"),true);
					if (!isset($url_array['totalResultsCount'])) echo $url_array('message');
					if ($url_array['totalResultsCount'] !=0){
						$emss_fed_state=$url_array['geonames'][0]['adminName1'];
						
						echoerrors(__FILE__,__LINE__,"Write to usermeta: $user -> $emss_fed_state </br>");
						insert2usermeta($user, 'emss_fed_state', $emss_fed_state);
						continue;
					}
					else{
						$emss_fed_state= 'a_unknown';
						echoerrors(__FILE__,__LINE__,"error --> no data @ User: $user City: $city PLZ: $postcode");
						echoerrors(__FILE__,__LINE__,"Write to usermeta: $user -> $emss_fed_state </br>");
						insert2usermeta($user, 'emss_fed_state', $emss_fed_state);
						continue;
					}
				}


				$emss_fed_state=$data['p_code'][$postcode][key($data['p_code'][$postcode])]['federal state'];

				echoerrors(__FILE__,__LINE__,"Write to usermeta: $user -> $emss_fed_state </br>");
				insert2usermeta($user, 'emss_fed_state', $emss_fed_state);			
			}
			
		}
		//else echoerrors(__FILE__,__LINE__,'scippt');
	} // Set federal State for all active users
	$skip=false;
	foreach($data['user'] as $user => $userdata){
		if(!isset($userdata['emss_gender']) and !$skip){
			
			$txt ="no gender --> create one User: $user ";
			
			if(!isset($userdata['first_name'])) {
				insert2usermeta($user, 'emss_gender_accuracy', 100);
				insert2usermeta($user, 'emss_gender', 'a_unknown');
				echoerrors(__FILE__,__LINE__.'_n', $txt." break up --> NO Name! </br>" );
				continue;
			} 
			if($userdata['first_name']==''){
				insert2usermeta($user, 'emss_gender_accuracy', 100);
				insert2usermeta($user, 'emss_gender', 'a_unknown');
				echoerrors(__FILE__,__LINE__.'_n', $txt." break up --> empty Name! </br>" );
				continue;
			} 
			set_time_limit(0);
			$name =$userdata['first_name'];
			
			if (contains_at_least_one_word($name)) $name=explode(' ',$name)[0];
			if (contains_at_least_one_word($name)) $name=explode('-',$name)[0];
			$request = urlencode ("https://api.genderize.io/?name=$name");
			$jsonrequest =file_get_contents($request);
			$url_array=(array)json_decode($jsonrequest,true);
			
				
			if($url_array['gender']===null){
				insert2usermeta($user, 'emss_gender_accuracy', 100);
				insert2usermeta($user, 'emss_gender', 'a_unknown');
				
				echoerrors(__FILE__,__LINE__.'_n', $txt." break up --> no data from API! </br>" );
				continue;
			}
			
			$emss_gender=$url_array['gender'];
			$accuracy=$url_array['probability']*100;
			   
			echoerrors(__FILE__,__LINE__.'_n',"$name ist zu $accuracy % $emss_gender ( $request ) </br>");
			$data['user'][$user]['emss_gender']=$emss_gender;
			$data['user'][$user]['emss_gender_accuracy']=$accuracy;
			if (isset($accuracy)) insert2usermeta($user, 'emss_gender_accuracy', $accuracy);
			if (isset($emss_gender)) insert2usermeta($user, 'emss_gender', $emss_gender);	
		}
	}	// Set gender for all active users
		
	$data['lists']['posts']=[];
	foreach($posts as $row){
		if (!isset( $data['lists']['posts'][ $row['ID'] ] ) ) $data['lists']['posts'][$row['ID']]=[ ];
		$data['lists']['posts'][ $row['ID'] ]['post_titel'] = $row['post_title'];
	} 						// -------  $posts --> $data['lists']['posts'][$ID] --------------
			
	$data['postmeta']=[];
	foreach($postmeta_temp as $row){
		if (!isset( $data['postmeta'][ $row['post_id'] ] ) ) $data['postmeta'][$row['post_id']]=[ ];
		$data['postmeta'][ $row['post_id'] ][ $row['meta_key'] ] = $row['meta_value'];
		if ($row['meta_key'] == "ems_start_date" or  $row['meta_key'] == "ems_end_date" ){
			$data['lists']['posts'][ $row['post_id'] ][ $row['meta_key'] ] = $row['meta_value'];
			$data['lists']['posts'][ $row['post_id'] ][ 'year' ] = date("Y", $row['meta_value']);
		}
	} 				// -------  $postmeta_temp --> $data['lists']['posts'][$ID] --------------
		
	foreach($data['db_correction']['page'] as $pid => $correct){
		//echo "Postid: $pid";
		//echo (array_key($correct));
		//echo (array_key(json_decode($correct['data'], true)));
		$data['postmeta'][ $pid ] = json_decode($correct['data'], true);
		//echo (array_key($data['postmeta'][ $pid ] ));
		$ems_start_date=$data['postmeta'][ $pid ]['ems_start_date'];
		$ems_end_date=$data['postmeta'][ $pid ]['ems_end_date'];
		if (!isset( $data['postmeta'][$pid] ) ) $data['postmeta'][$pid]=[ ];
		
		$data['lists']['posts'][ $pid ][ 'post_titel' ] = $data['postmeta'][ $pid ]['name'];
		$data['lists']['posts'][ $pid ][ 'ems_start_date' ] = $ems_start_date;
		$data['lists']['posts'][ $pid ][ 'ems_end_date' ] = $ems_end_date;
		$data['lists']['posts'][ $pid ][ 'year' ] = date("Y", $ems_start_date);
		
	}
	
	foreach($EMR_temp as $row){
		if (isset($data['lists']['posts'][$row['event_id']])){
			
			if (knownissue('user', $row['user_id'])){
				$id =$row['user_id'];
				echoerrors(__FILE__,__LINE__."_n", "SKIP user: $id");
				continue;
			}	
			
		
			$temp=json_decode($row['data'], true);	
			
			
			
			$data['user'][ $row['user_id'] ]['Events'][EMS_get_Eventyear_by_Event_ID($row['event_id'])][$row['event_id']]=[

				'deleted' 		=> $row['deleted'],
				'cancelled'		=> false,
				'create_date' 	=> $row['create_date'],
				'delete_date' 	=> $row['delete_date'],
				'modify_date' 	=> $row['modify_date'],
				'name'			=> $data['lists']['posts'][$row['event_id']]['post_titel'],
				'user_age_on_event' => EMS_get_age_on_time_by_id($row['user_id'], $data['lists']['posts'][ $row['event_id'] ]['ems_start_date'])
				
				];
			foreach($temp as $key => $temprow){
				$data['user'][ $row['user_id'] ]['Events'][EMS_get_Eventyear_by_Event_ID($row['event_id'])][$row['event_id']][$key] = $temprow;
				
			}
			$data['user'][ $row['user_id']]['silentuser'] = false;
		}
		
		else{
			echoerrors(__FILE__,__LINE__,'!!!UNKNOWN ISSUE: CALL ADMIN!!! post_'.$row['event_id']. '</br>');
			
		}
	} 					// -------  $EMR_temp --> data['user'][ $userid ]['Events'][ $year ][ $eventid ]... --------------
	
	foreach($deregister as $dereg){
		
		if (knownissue('user', $dereg['user'])){
				$id =$dereg['user'];
				echoerrors(__FILE__,__LINE__."_n", "SKIP user: $id");
				continue;
			}	
		$event =$dereg['event'];
		
		
		
		$y=EMS_get_Eventyear_by_Event_ID($event);
		$data['user'][$dereg['user']]['Events'][$y][$event]['deleted']=true;
		$data['user'][$dereg['user']]['Events'][$y][$event]['cancelled']=false;
		
		
	} 				// -------  $deregister --> data['user'][ $userid ]['Events'][ $year ][ $eventid ]['deleted']=true  --------------
	//echoerrors(__FILE__,__LINE__,array_key($register, '$reg');
		
	foreach($register as $reg){
		
		if (knownissue('user', $reg['user'])){
				$id =$reg['user'];
				echoerrors(__FILE__,__LINE__."_n", "SKIP user: $id");
				continue;
			}
		
		$event =$reg['event'];
		$y=EMS_get_Eventyear_by_Event_ID($event);
		if (!isset($data['user'][$reg['user']]['Events'][$y][$event])) continue; 
		
		if (!isset($data['user'][$reg['user']]['Events'][$y][$event]['register'])) $data['user'][$reg['user']]['Events'][$y][$event]['register']=0;
		$data['user'][$reg['user']]['Events'][$y][$event]['register']++;
		
	} 					// -------  $register --> data['user'][ $userid ]['Events'][ $year ][ $eventid ]['register']=#ofRegister  --------------
	// ------ Realign DB-Arrays to customize look ($usermeta_temp -> $data['user']-----------
	
	{
	// Event-ID sort by year
	$data['lists']['yearlist_eventid']=[];
	
	for ($y=2014; $y <= date("Y"); $y =$y+1){
		$lower_date = date(mktime(0,0,1,1,1,$y));
		
		$opper_date = date(mktime(23,59,59,12,31,$y));
		$ids_temp =$wpdb->get_results( "SELECT post_id from ".$table_postmeta." WHERE meta_key = 'ems_start_date' AND meta_value >= $lower_date AND meta_value <= $opper_date", 'ARRAY_N' );
		$data['lists']['yearlist_eventid'][$y]=[];
		foreach($ids_temp as $ids){
			array_push($data['lists']['yearlist_eventid'][$y],$ids[0]);
		}
		//var_dump($yearlist_eventid[$y]);
								 
	}
	$n=0;
	$data['lists']['dead_users']=[];
	$data['lists']['silent_users']=[];
	
	foreach($data['user'] as $key => $event_user){
		//if ($event_user['silentuser']==true) continue;
		if (!isset($event_user['Events'])) {
			$data['user'][$key]['Events']=array();
			$data['user'][$key]['silentuser']=true;
			$data['user'][$key]['deaduser']=true;
			array_push($data['lists']['dead_users'],$key);
			continue;
		}
		else {
			for ($y=2014; $y <= date("Y"); $y =$y+1){
				if (!isset($data['user'][$key]['reg_date'])){
					//echoerrors(__FILE__,__LINE__,$key.'</br>';
					continue;
				}
				if (strtotime($y.'-11-15')>$data['user'][$key]['reg_date'] and !isset($data['user'][$key]['Events'][$y])){
					$n++;
					if( !isset($data['lists']['silent_users'][$y])) $data['lists']['silent_users'][$y]=array();
					array_push($data['lists']['silent_users'][$y],$key);
				}
				//else echoerrors(__FILE__,__LINE__,'tada</br>';
		}
	}
	}
	}// ------ Create lists of Interesting ID's of data-----
	
	
	
} //Get data vom DB and build data arrays 
 
?>