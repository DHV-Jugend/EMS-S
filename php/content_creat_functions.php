<?php

function get_comment_line($n, $head, $text = null ){
	$str = "";
	$str .= "<tr><th colspan=$n>$head</th></tr>";
	if ($text != null){
		$str .= "<tr><td colspan=$n>$text</td></tr>";
	}
	return $str;
} // return (html)string row of a tbale wiht comments for Charts in it $n -> colspann

function get_table_inlay($id,$n,$xlable,$ylable,$data){
	$str = '';
	foreach($data as $y => $chartdata){
		$thisid =$id.'_row_'.$y;
		$str .= "<tr id='$thisid' style='display: none;'><td colspan='$n'>";
		$str .= '<table>';
		$str .= "<tr><th colspan =2><center>$y</center></th></tr>";
		$str .= "<tr><th>$xlable</th><th>$ylable</th></tr>";
			foreach($chartdata as $x_value => $y_value){
				$str .= "<tr><td>$x_value</td><td>$y_value</td></tr>";	
			}
		$str .= '</table>';
		$str .= "</td></tr>";
	}
	return $str;
} // return (html)string row of a table with filled table od data in it $n -> colspann

function get_canvas_row($n, $id){
	$str = '';
	$str .= "<tr><td colspan='$n'><canvas id='$id' width='400' height='200'></canvas></td></tr>";
	return $str;
} // return (html)string row of a table with chart canvas in it $n -> colspann

function build_option_row_settings(){
	$options=array(
		array(
			'name' 			=> 	'Teilnehmer',
			'id'			=>	'Teilnehmer',
			'disp_name'		=> 	'Teilnehmer'
		),array(
			'name' 			=> 	'Eventanzahl',
			'id'			=>	'Eventanzahl',
			'disp_name'		=> 	'Eventanzahl'
		),array( 

			'name' 			=> 	'Anmeldungen vs. Alter',
			'id'			=>	'AnvAl',
			'disp_name'		=> 	'Anmeldungen vs. Alter'
		),array( 

			'name' 			=> 	'An- Abmeldungen',
			'id'			=>	'AnAbmeldung',
			'disp_name'		=> 	'An- Abmeldungen'
		),array( 

			'name' 			=> 	'&#216; Anmeldungen',
			'id'			=>	'pTjT',
			'disp_name'		=> 	'&#216; Anmeldungen'
		),array( 

			'name' 			=> 	'Fluggerät',
			'id'			=>	'Fg',
			'disp_name'		=> 	'Fluggeräte'
		),array( 

			'name' 			=> 	'Registrierte Benuter',
			'id'			=>	'reg_user',
			'disp_name'		=> 	'Registrierte Benuter'
		),array( 

			'name' 			=> 	'TOP 20 Teilnehmer',
			'id'			=>	'top20teilnehmer',
			'disp_name'		=> 	'TOP 20 Teilnehmer'
		),array( 


			'name' 			=> 	'Teilnahme über Mitgliedszeit',
			'id'			=>	'TeilnMitgliedz',
			'disp_name'		=> 	'&#216; Teilnahme über Jugend-Mitgliedszeit'
		),array( 

			'name' 			=> 	'&#216; Teilnahmen nach Alter',
			'id'			=>	'TeilnAlter',
			'disp_name'		=> 	'&#216; Teilnahmen nach Alter'
		),array( 

			'name' 			=> 	'Piloten Regionen',
			'id'			=>	'PR',
			'disp_name'		=> 	'Regionen'
		),array( 

			'name' 			=> 	'Gender',
			'id'			=>	'sex',
			'disp_name'		=> 	'Gender'
		),array( 

			'name' 			=> 	'Top Newcomer',
			'id'			=>	'newcomer',
			'disp_name'		=> 	'Top Newcomer'
		)
	);
	
	
	
	return $options;
} //returns array Like a Config File --> Name, id, And displaynamy for MainRegisters


?>