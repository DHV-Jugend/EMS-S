<?php

function Content_default(){
	global $data;
	
	$str  = '';
	$str .= '<h1>Statistische Auswertung aller Daten der DHV-Jugend-Seite!</h1>';
	$str .= '<p id="process_time"></p>';
	$str .= "<div align='right' style='font-size:10px;'>created by: smallspotstone</div>";
	return $str;
}

function Content_Teilnehmer(){
	global $data;
	$content_id ='Teilnehmer';
	$chart_style = 'line';
	$yachsen_beschriftung='Anzahl an Teilnehmer(Personen)';
	$xachsen_beschriftung='Jahr';
	
	$chart_id= "Chart_$content_id";
	$tabel_id= $content_id."table";
	
	
	// ------------Paint Canvas and get Chartdata ------------
	$str ="<table><tr>";
	
	$str .= get_comment_line(5, "Zahlt die Teilnahmer (Anmeldungen-Abmeldungen)", "Ü28 Teilnehmer sind bei 'alle' mitgezählt");
	
	$n=0;
	
	for ($y=2014; $y <= date("Y"); $y = $y+1){
		
		$chartdata['alle'][$y]=0;
		$chartdata['Alter>28'][$y]=0;
		
		

	}
	
	foreach($data['user'] as $key => $event_user){
		
		
		if (!isset($event_user['Events'])) {
			continue;
		}
		
		
		foreach($event_user['Events'] as $year_key => $eventkey){
			$count=false;
			$n=0;
			$old=0;
			foreach($eventkey as $eventid => $eventid_key){
				if (!isset($eventid_key['deleted'])) echo ("user: $key year: $year_key event: $eventid </br>");

				if ($eventid_key['deleted'] == '0') {
					$count= true;
					$n++;
					$old+=$eventid_key['user_age_on_event'];
				}
			}
			if ($count){
				$age = $old/$n;
				if ($age >=28.5){
					$chartdata['Alter>28'][$year_key]++;
				}
				$chartdata['alle'][$year_key]++;
			}
		} 
		
	}
	
	$str .= get_input_col($tabel_id."_alle", $chart_id.'_'.'alle', 'alle');
	$str .= get_input_col($tabel_id."_Alter>28", $chart_id.'_'.'Alter>28', 'Alter>28');

	
	//
	$str .= "</tr>";
	$n=2;
	$str .= get_canvas_row($n,$chart_id);
	$x_achse = json_encode(array_keys($chartdata['alle']));	//write x-axes layout value

	//------------ Display Chartdata as Table ------------
	
	$str .= get_table_inlay($tabel_id,$n, $xachsen_beschriftung , $yachsen_beschriftung, $chartdata);
	
	//$str .= array_key($chartdata);
	$str .= "</table>";
	
	// display Chart and publisch Chartdata in JS 
	$str .= "<script>buildchart_by_id('$chart_id', '$chart_style' , $x_achse, '$xachsen_beschriftung', '$yachsen_beschriftung' )</script>";
	$str .= array2JS($chartdata, $content_id);
	
	//$thiscontent =$content_id."['alle']";
	//echo $thiscontent;
	//$str .= "<script>show_data('$chart_id','$yachsen_beschriftung', $thiscontent )</script>";
	
 	return $str;
}

function Content_Eventanzahl(){
	global $data;
	
	
	$content_id ='Eventanzahl';
	$chart_style = 'line';
	$yachsen_beschriftung='Anzahl der Events';
	$xachsen_beschriftung='Jahr';
	
	$chart_id= "Chart_$content_id";
	$tabel_id= $content_id."table";
	
	
	// ------------Paint Canvas and get Chartdata ------------
	$str ="<table><tr>";
	$str .= get_comment_line(5, "Zählt die Events pro Jahr");
	
	$n=0;
	
	for ($y=2014; $y <= date("Y"); $y = $y+1){
		$chartdata[0][$y]=count($data['lists']['yearlist_eventid'][$y]);
	}
	
	//$str .= get_input_col($tabel_id, $chart_id);
	
	$str .= "</tr>";
	$str .= get_canvas_row($n,$chart_id);
	$x_achse = json_encode(array_keys($chartdata[0]));	//write x-axes layout value

	//------------ Display Chartdata as Table ------------
	
	$str .= get_table_inlay($tabel_id,$n, $xachsen_beschriftung , $yachsen_beschriftung, $chartdata);
	
	//$str .= array_key($chartdata);
	$str .= "</table>";
	
	// display Chart and publisch Chartdata in JS 
	$str .= "<script>buildchart_by_id('$chart_id', '$chart_style' , $x_achse, '$xachsen_beschriftung', '$yachsen_beschriftung' )</script>";
	$str .= array2JS($chartdata, $content_id);
	
	$thiscontent =$content_id.'[0]';
	//echo $thiscontent;
	$str .= "<script>show_data('$chart_id','$yachsen_beschriftung', $thiscontent )</script>";
	
 	return $str;
}

function Content_AnvAl() {
	global $data;
	$content_id ='AnvAl';
	$chart_style = 'line';
	$yachsen_beschriftung='Alter bei Eventbeginn [Jahre]';
	$xachsen_beschriftung='Anzahl der Anmeldungen';
	
	$chart_id= "Chart_$content_id";
	$tabel_id= $content_id."table";
	
	
	// ------------Paint Canvas and get Chartdata ------------
	$str ="<table><tr>";
	$str .= get_comment_line(5, "Errechnet das Alter bei Eventbeginn und Zählt die Teilnahmen (Anmeldungen-Abmeldungen)");
	
	$n=0;
	for ($y=2014; $y <= date("Y"); $y = $y+1){ 
		
		$chartdata[$y]=[
			'<16' => 0,
			'16' => 0,
			'17' => 0,
			'18' => 0,
			'19' => 0,
			'20' => 0,
			'21' => 0,
			'22' => 0,
			'23' => 0,
			'24' => 0,
			'25' => 0,
			'26' => 0,
			'27' => 0,
			'28' => 0,
			'29' => 0,
			'30' => 0,
			'31' => 0,
			'32' => 0,
			'33' => 0,
			'34' => 0,
			'35' => 0,
			'36' => 0,
			'37' => 0,
			'38' => 0,
			'39' => 0,
			'>=40' => 0
		];// create 7mpty data ;
		foreach($data['user'] as  $userkey => $user){ 
			if(!isset($user['Events'][$y])) continue;
			foreach($user['Events'][$y] as $key => $events){
				if (!isset($events['deleted'])) echo ("user: $userkey year: $y event: $key </br>");
				
				if($events['cancelled']) continue;
				if($events['deleted']) continue;
				//if (!isset($events['user_age_on_event'])) echo array_key($events);
				//echo ($y.'--'.var_dump($key);
				//var_dump($events['user_age_on_event']); 
				if($events['user_age_on_event']<16) $chartdata[$y]['<16']++;
				elseif ($events['user_age_on_event']>=40) $chartdata[$y]['>=40']++;
				else $chartdata[$y][$events['user_age_on_event']]++;
			}
		} //count registations
		
		$x_achse = json_encode(array_keys($chartdata[$y]));	//write x-axes layout value
		
		$str .= get_input_col($tabel_id."_$y", $chart_id.'_'.$y, $y);

		
		$n=$n+1;
	} //collect Data
	$str .= "</tr>";
	$str .= get_canvas_row($n,$chart_id);
	
	//------------ Display Chartdata as Table ------------
	
	$str .= get_table_inlay($tabel_id,$n, $xachsen_beschriftung ,	$yachsen_beschriftung, $chartdata);
	
	//$str .= array_key($chartdata);
	$str .= "</table>";
	
	// display Chart and publisch Chartdata in JS 
	$str .= "<script>buildchart_by_id('$chart_id', '$chart_style' , $x_achse, '$yachsen_beschriftung', '$xachsen_beschriftung' )</script>";
	$str .= array2JS($chartdata, $content_id);
	
 	return $str;
}

function Content_Fg() {
	global $data;
	$content_id ='Fg';
	$chart_style = 'bar';
	$yachsen_beschriftung='Fluggeräte';
	$xachsen_beschriftung='Anzahl der Anmeldungen';
	
	$chart_id= "Chart_$content_id";
	$tabel_id= $content_id."table";
	
	
	// ------------Paint Canvas and get Chartdata ------------
	$str ="<table><tr>";
	$str .= get_comment_line(5, "Sortier und Zählt die Teilnahmen (Anmeldungen-Abmeldungen)", "Teilnahmen =(Anmeldungen - Abmeldungen) ohne Rettungsgeräteseminar");
	$n=0;
	$m=0;
	for ($y=2014; $y <= date("Y"); $y = $y+1){ 
		
		$chartdata[$y]=[
			'Gleitschirm' => 0,
			'Drachen' => 0,
			'Fußgänger' => 0,
			
		];// create empty data
		
		foreach($data['user'] as $key => $user){
			if(!isset($user['Events'][$y])) continue;
			foreach($user['Events'][$y] as $eventkey => $events){
				
				if ($events['deleted']==1 or $events['name']=='Rettungsgeräteseminar' ){
					//$chartdata[$y]['Gleitschirm']++; //Db BUG Kompensieren 4 User haben keine Daten in Sicherheitstrainings
					
					//echo("User: $key / Year: $y / Event: $eventkey </br>");
					continue;
				} //skip deleted users
				
				if (!isset($events['cancelled'])){
						echo("User: $key / Year: $y / Event: $eventkey </br>");
						continue;
				} //skip cancelled Events
				
				if ($events['cancelled']==1 ){
						//echo("User: $key / Year: $y / Event: $eventkey </br>");
						continue;
				} //skip cancelled Events
				
				if (!isset($events['fum_aircraft'])){
					echo("User: $key / Year: $y / Event: $eventkey </br>");
				}
				
				//var_dump($events['fum_aircraft']); 
				if ($events['fum_aircraft'] == "gleitschirm") $chartdata[$y]['Gleitschirm']++;
				elseif ($events['fum_aircraft'] == "drachen") $chartdata[$y]['Drachen']++;
				elseif ($events['fum_aircraft'] == "fussgaenger") $chartdata[$y]['Fußgänger']++;
			}
		} //count data
		
		$x_achse = json_encode(array_keys($chartdata[$y]));	//write x-axes layout value
		
		$str .= get_input_col($tabel_id."_$y", $chart_id.'_'.$y, $y);
	
		
		$n=$n+1;
	}
	$str .= "</tr>";
	$str .=  get_canvas_row($n, $chart_id);
	
	//------------ Display Chartdata as Table ------------
	$str .= get_table_inlay($tabel_id, $n, $yachsen_beschriftung, $xachsen_beschriftung, $chartdata);

	
	// display Chart and publisch Chartdata in JS 
	$str .= '</table>';
	$str .= "<script>buildchart_by_id('$chart_id', '$chart_style' , $x_achse, '$yachsen_beschriftung', '$xachsen_beschriftung' )</script>";
	$str .= array2JS($chartdata,$content_id);
	
 	return $str;
}

function Content_AnAbmeldung(){
	global $data;
	
	$content_id ='AnAbmeldung';
	$chart_style = 'bar';
	$yachsen_beschriftung='Typ';
	$xachsen_beschriftung='Anzahl';
	
	$chart_id= "Chart_$content_id";
	$tabel_id= $content_id."table";
	
	
	// ------------Paint Canvas and get Chartdata ------------
	$str ="<table><tr>";
	$str .= get_comment_line(5, "Zählt die Anmeldungen, Abmeldungen und löschen aufgrund von nicht stattgefunden Events und errechet die tatsächliche Teilnehmerzahl)");
	
	$n=0;
	for ($y=2014; $y <= date("Y"); $y = $y+1){ 
		
		$chartdata[$y]=[
			'Anmeldungen' 	=> 0,
			'Abmeldungen' 	=> 0,
			'nicht stattgefunden' => 0,
			'Delta' 		=> 0
			
		];// create empty data
		
		foreach($data['user'] as $key => $user){
			if(!isset($user['Events'][$y]) ) {
				//echo $data['lists']['silent_users'][$y][$key].'</br>';
				continue;
			}
			foreach($user['Events'][$y] as $userevent){
				if ($userevent['deleted']==false and $userevent['cancelled']==false) $chartdata[$y]['Anmeldungen']++;
				elseif($userevent['cancelled']=='1') $chartdata[$y]['nicht stattgefunden']++;
				else $chartdata[$y]['Abmeldungen']++;
				
				
			}
			
		} //count data
		$chartdata[$y]['Delta']= $chartdata[$y]['Anmeldungen'] - $chartdata[$y]['nicht stattgefunden'] - $chartdata[$y]['Abmeldungen'];
		$x_achse = json_encode(array_keys($chartdata[$y]));	//write x-axes layout value
		
		$str .= get_input_col($tabel_id."_$y", $chart_id.'_'.$y, $y);
	
		
		$n=$n+1;
	}
	$str .= "</tr>";
	$str .=  get_canvas_row($n, $chart_id);
	
	//------------ Display Chartdata as Table ------------
	$str .= get_table_inlay($tabel_id, $n, $yachsen_beschriftung, $xachsen_beschriftung, $chartdata);

	
	// display Chart and publisch Chartdata in JS 
	$str .= '</table>';
	$str .= "<script>buildchart_by_id('$chart_id', '$chart_style' , $x_achse, '$yachsen_beschriftung', '$xachsen_beschriftung' )</script>";
	$str .= array2JS($chartdata,$content_id);
	
 	return $str;
}

function Content_pTjT() {
	
	global $data;
	$content_id ='pTjT';
	$chart_style = 'line';
	$yachsen_beschriftung='Durchschnitt Teilnahmen';
	$xachsen_beschriftung='Jahr';
	
	$chart_id= "Chart_$content_id";
	$tabel_id= $content_id."table";
	
	
	// ------------Paint Canvas and get Chartdata ------------
	$str ="<table><tr>";
	$str .= get_comment_line(1, "Zählt die Teilnahmen (Anmeldungen-Abmeldungen)");
	$n=0;
	
	for ($y=2014; $y <= date("Y"); $y = $y+1){
		$chartdata[0][$y]=0;
	}
	// ---------- WIRD AUS AnAbmeldung und Teilnehmer['alle'] berechnet ---------------
	//$str .= get_input_col($tabel_id, $chart_id);
	
	$str .= "</tr>";
	$str .= get_canvas_row($n,$chart_id);
	$x_achse = json_encode(array_keys($chartdata[0]));	//write x-axes layout value

	//------------ Display Chartdata as Table ------------
	
	$str .= get_table_inlay($tabel_id,$n, $xachsen_beschriftung , $yachsen_beschriftung, $chartdata);
	
	//$str .= array_key($chartdata);
	$str .= "</table>";
	
	// display Chart and publisch Chartdata in JS 
	$str .= "<script>buildchart_by_id('$chart_id', '$chart_style' , $x_achse, '$xachsen_beschriftung', '$yachsen_beschriftung' )</script>";
	$str .= array2JS($chartdata, $content_id);
	
	$thiscontent =$content_id.'[0]';
	//echo $thiscontent;
	$str .= "<script>div_array(AnAbmeldung,Teilnehmer['alle'],'Delta',null)</script>";
	$str .= "<script>show_data('$chart_id','$yachsen_beschriftung', $thiscontent )</script>";
	
 	return $str;
}

function Content_PR(){
	global $data;
	
	$content_id ='PR';
	$chart_style = 'bar';
	$yachsen_beschriftung='Anzahl seit 2014';
	$xachsen_beschriftung='Bundesland';
	
	$chart_id= "Chart_$content_id";
	$tabel_id= $content_id."table";
	
	//echo (array_key($data['user'][231]));
	// ------------Paint Canvas and get Chartdata ------------
	$str ="<table><tr>";
	$str .= get_comment_line(5, "Sortiert und zählt alle Nutzer nach Wohnort (Bundesland).");
	$n=0;
	for ($y=2014; $y <= date("Y"); $y = $y+1){ 
		
		foreach($data['user'] as $key => $user){
			if(!isset($chartdata[$y]))$chartdata[$y]=[];
			
			if (!isset($data['user'][$key]['emss_fed_state'])) continue;
			if (!isset($data['user'][$key]['Events'][$y])) continue;
			$bl= ($user['emss_fed_state']);
			if (!isset($chartdata[$y][$bl])) $chartdata[$y][$bl]=0;
			$chartdata[$y][$bl]++;
		}
		$str .= get_input_col($tabel_id."_$y", $chart_id."_$y", $y);
		$n++;
		
	}
	
	for ($y=2014; $y <= date("Y"); $y = $y+1) arsort($chartdata[$y]);
	
	
	
	$str .= "</tr>";
	
	$str .= get_canvas_row($n,$chart_id);
	$x_achse = json_encode(array_keys($chartdata[2014]));	//write x-axes layout value

	//------------ Display Chartdata as Table ------------
	
	$str .= get_table_inlay($tabel_id,$n, $xachsen_beschriftung , $yachsen_beschriftung, $chartdata);
	
	//$str .= array_key($chartdata);
	$str .= "</table>";
	
	// display Chart and publisch Chartdata in JS 
	$str .= "<script>buildchart_by_id('$chart_id', '$chart_style' , $x_achse, '$xachsen_beschriftung', '$yachsen_beschriftung' )</script>";
	$str .= array2JS($chartdata, $content_id);
	
	$thiscontent =$content_id.'[0]';
	//echo $thiscontent;
	//$str .= "<script>show_data('$chart_id','$yachsen_beschriftung', $thiscontent )</script>";
	
 	return $str;
}

function Content_sex(){
	global $data;
	
	$content_id ='gender';
	$chart_style = 'bar';
	$yachsen_beschriftung='Gender';
	$xachsen_beschriftung='Anzahl [%]';
	
	$chart_id= "Chart_$content_id";
	$tabel_id= $content_id."table";
	
	
	// ------------Paint Canvas and get Chartdata ------------
	$str ="<table><tr>";
	$str .= get_comment_line(5, "Sortiert und zählt alle Nutzer nach Geschlecht."," 'unbekannt' --> Nutzer die aufgrund des Namens nicht einem Geschlecht zugeordnet werden konnten. ");
	
	$n=0;
	$number=0;
	$acc=0;
	for ($y=2014; $y <= date("Y"); $y = $y+1){ 
		
		$chartdata[$y]=[
			'Männlich' 	=> 0,
			'Weiblich' 	=> 0,
			'unbekannt' => 0,
			
		];// create empty data
		
		foreach($data['user'] as $key => $user){
			if(!isset($user['Events'][$y]) ) {
				//echo $data['lists']['silent_users'][$y][$key].'</br>';
				continue;
			}
			foreach($user['Events'][$y] as $userevent){
				if ($userevent['deleted']==false and $userevent['cancelled']==false){
					if (!isset($user['emss_gender'])){
						echoerrors(__FILE__, __LINE__, "No Gender for USER: $key");
						continue;
					}
					if 		($user['emss_gender']=='male') 		$chartdata[$y]['Männlich']++;
					elseif 	($user['emss_gender']=='female') 	$chartdata[$y]['Weiblich']++;
					else 										$chartdata[$y]['unbekannt']++;
					$number++;
					$acc+=$user['emss_gender_accuracy'];
				}
			}
			
		} //count data
		$all=$chartdata[$y]['Männlich']+$chartdata[$y]['Weiblich']+$chartdata[$y]['unbekannt'];
		$chartdata[$y]['Männlich']=$chartdata[$y]['Männlich']*100/$all;
		$chartdata[$y]['Weiblich']=$chartdata[$y]['Weiblich']*100/$all;
		$chartdata[$y]['unbekannt']=$chartdata[$y]['unbekannt']*100/$all;
		
		$x_achse = json_encode(array_keys($chartdata[$y]));	//write x-axes layout value
		
		$str .= get_input_col($tabel_id."_$y", $chart_id.'_'.$y, $y);
	
		
		$n=$n+1;
	}
	$str .= "</tr>";
	$str .=  get_canvas_row($n, $chart_id);
	$percent = round($acc/ $number,1);
	$str .= "<tr><td colspan =$n> Das Chart ist zu $percent % genau!</td></tr>";
	//------------ Display Chartdata as Table ------------
	$str .= get_table_inlay($tabel_id, $n, $yachsen_beschriftung, $xachsen_beschriftung, $chartdata);

	
	// display Chart and publisch Chartdata in JS 
	$str .= '</table>';
	$str .= "<script>buildchart_by_id('$chart_id', '$chart_style' , $x_achse, '$yachsen_beschriftung', '$xachsen_beschriftung' )</script>";
	$str .= array2JS($chartdata,$content_id);
	
 	return $str;
}

function Content_reg_user(){
	global $data;
	$content_id ='RegistrieterNutzer';
	$chart_style = 'line';
	$yachsen_beschriftung='Anzahl an Nutzer(Personen)';
	$xachsen_beschriftung='Jahr';
	
	$chart_id= "Chart_$content_id";
	$tabel_id= $content_id."table";
	
	
	// ------------Paint Canvas and get Chartdata ------------
	$str ="<table><tr>";
	$str .= get_comment_line(4, "Sortiert und zählt alle Nutzer nach aktivität."," 'alle' -> Gesamtnutzeranzahl </br> 'aktiv'-> Nutzeranzahl von Nutzern die in diesem Jahr auf einem Event waren </br> 'neu'-> Nutzeranzahl von neuen registrierten Nutzern </br> 'inaktiv'-> Nutzeranzahl von Nutzern die in diesem Jahr NICHT auf einem Event waren </br> Stichtag (Saisonende / -anfang) = 1 November ");
	
	$n=0;
	
	for ($y=2014; $y <= date("Y"); $y++){
		
		$chartdata['alle'][$y]=0;
		$chartdata['aktiv'][$y]=0;
		$chartdata['neu'][$y]=0;
		$chartdata['inaktiv'][$y]=0;
		
		foreach($data['user'] as $key => $event_user){
			
			if( !isset($event_user['reg_date'])) {
				
				$chartdata['inaktiv'][$y]++;
				$chartdata['aktiv'][$y]++;
				//echo "User: $key no registration Date!</br>";
				continue;
			}
			
			if(strtotime("1 November $y")<$event_user['reg_date']){
				//echo ("1 November $y < regist");
				continue;
			}
			
			$chartdata['alle'][$y]++;
			if (!isset($event_user['Events'][$y])) {
				
				$chartdata['inaktiv'][$y]++;
				continue;
			}
			$chartdata['aktiv'][$y]++;

			

		}
		
		if ($y==2014) $alt=$chartdata['neu'][2014];
		else $chartdata['neu'][$y]=$chartdata['alle'][$y]-$chartdata['alle'][$y-1];
	}
	
	$str .= get_input_col($tabel_id."_alle",		 	$chart_id.'_'.'alle', 		'alle');
	$str .= get_input_col($tabel_id."_aktiv",	 	$chart_id.'_'.'aktiv', 		'aktiv');
	$str .= get_input_col($tabel_id."_neu", 		$chart_id.'_'.'neu', 		'neu');
	$str .= get_input_col($tabel_id."_inaktiv", 	$chart_id.'_'.'inaktiv', 	'inaktiv');

	
	//
	$str .= "</tr>";
	$n=4;
	$str .= get_canvas_row($n,$chart_id);
	$x_achse = json_encode(array_keys($chartdata['alle']));	//write x-axes layout value

	//------------ Display Chartdata as Table ------------
	
	$str .= get_table_inlay($tabel_id,$n, $xachsen_beschriftung , $yachsen_beschriftung, $chartdata);
	
	//$str .= array_key($chartdata);
	$str .= "</table>";
	
	// display Chart and publisch Chartdata in JS 
	$str .= "<script>buildchart_by_id('$chart_id', '$chart_style' , $x_achse, '$xachsen_beschriftung', '$yachsen_beschriftung' )</script>";
	$str .= array2JS($chartdata, $content_id);
	
	//$thiscontent =$content_id."['alle']";
	//echo $thiscontent;
	//$str .= "<script>show_data('$chart_id','$yachsen_beschriftung', $thiscontent )</script>";
	
 	return $str;
}

function Content_top20teilnehmer(){
	
	global $data;
	$content_id ='top20';
	$chart_style = 'bar';
	$yachsen_beschriftung='Anzahl der Teilnahmen (- abgemeldete Teilnahmen)';
	$xachsen_beschriftung='Person';
	
	$chart_id= "Chart_$content_id";
	$tabel_id= $content_id."table";
	
	
	// ------------Paint Canvas and get Chartdata ------------
	$str ="<table><tr>";
	$str .= get_comment_line(2, "Berechnet die Differenz zwischen An- und Abmeldungen für alle Nutzer. Die 20 Nutzer mit der höchsten Differenz werden angezeigt. Gilt für alle Jahr seit 2014");
	
	$n=0;
	$chartdata=[];
	foreach($data['user'] as $key => $event_user){
		if(isset($event_user['first_name'])) $firstname=$event_user['first_name'];
		else $firstname='NOONE'; 
		if(isset($event_user['last_name'])) $name=$event_user['last_name'];
		else $name='MUSTERMANN';
		
		$chartdata[$firstname." ".$name." id=".$key."'"]=0;
		for ($y=2014; $y <= date("Y"); $y++){
			if (!isset($data['user'][$key]['Events'][$y])) continue;
			foreach($event_user['Events'][$y] as $event){
				if ($event['deleted']!=1) $chartdata[$firstname." ".$name." id=".$key."'"]++;
			}
			//$chartdata[$firstname." ".$name." ".$key] += count($data['user'][$key]['Events'][$y]);
		}
	}
	arsort($chartdata);
	$chartdata=array_slice($chartdata,0,20);
	//echo(array_key($chartdata));
	$str .= "</tr>";
	$n=1;
	$str .= get_canvas_row($n,$chart_id);
	$x_achse = json_encode(array_keys($chartdata));	//write x-axes layout value

	//------------ Display Chartdata as Table ------------
	
	//$str .= get_table_inlay($tabel_id,$n, $xachsen_beschriftung , $yachsen_beschriftung, $chartdata);
	
	//$str .= array_key($chartdata);
	$str .= "</table>";
	
	// display Chart and publisch Chartdata in JS 
	$str .= "<script>buildchart_by_id('$chart_id', '$chart_style' , $x_achse, '$xachsen_beschriftung', '$yachsen_beschriftung' )</script>";
	$str .= array2JS($chartdata, $content_id);
	
	$thiscontent =$content_id;
	//echo $thiscontent;
	$str .= "<script>show_data('$chart_id','$yachsen_beschriftung', $thiscontent )</script>";
	
 	return $str;
}

function Content_TeilnAlter(){
	global $data;
	$content_id ='TeilNAlter';
	$chart_style = 'line';
	$yachsen_beschriftung='Teilnahmen';
	$xachsen_beschriftung='Alter';
	
	$chart_id= "Chart_$content_id";
	$tabel_id= $content_id."table";
	
	// ------------Paint Canvas and get Chartdata ------------
	$str ="<table><tr>";
	$str .= get_comment_line(2, "Zählt für alle Nutzer die Anmeldungen und trägt sie über das Useralter (bei Event) auf!");
	
	$n=0;
	$chartdata=[];
	$temp=[];
	foreach($data['user'] as $key => $event_user){
		//echo $age."</br>";
		for ($y=2014; $y <= date("Y"); $y++){

			if (!isset($event_user['Events'])) echo "No Events for User: $key </br>";
			if (!isset($event_user['Events'][$y])) continue;
			$write=false;
			foreach($event_user['Events'][$y] as $rowkey => $row){
				if ($row['deleted']==1) continue;
				
				if (!isset($row['user_age_on_event'])){
					echo ("User: $key has no 'age o.e.' on Event: $rowkey in year: $y</br>");
					continue;	
				} 
			
				$age=$row['user_age_on_event'];
				
				if (!isset($temp[$age])){
					$temp[$age]=0;
					$chartdata[$age]=0;
				}
				$chartdata[$age]++;
				$write=true;
				//if ($age < 16 ) echo("This User ($key) is under 16 years old ($age)!</br>");
			}
			if($write) $temp[$age]++;
			
			//if ($age < 16 ) echo("This User ($key) is under 16 years old ($age)!</br>");
			
		}
	}
	foreach($chartdata as $age => $value){
		if ($value==0) $chartdata[$age]=0;
		$chartdata[$age]=$value / $temp[$age];
	}
	ksort($chartdata);
	//echo(array_key($chartdata));
	$str .= "</tr>";
	$n=1;
	$str .= get_canvas_row($n,$chart_id);
	$x_achse = json_encode(array_keys($chartdata));	//write x-axes layout value

	//------------ Display Chartdata as Table ------------
	
	//$str .= get_table_inlay($tabel_id,$n, $xachsen_beschriftung , $yachsen_beschriftung, $chartdata);
	
	//$str .= array_key($chartdata);
	$str .= "</table>";
	
	// display Chart and publisch Chartdata in JS 
	$str .= "<script>buildchart_by_id('$chart_id', '$chart_style' , $x_achse, '$xachsen_beschriftung', '$yachsen_beschriftung' )</script>";
	$str .= array2JS($chartdata, $content_id);
	
	$thiscontent =$content_id;
	//echo $thiscontent;
	$str .= "<script>show_data('$chart_id','$yachsen_beschriftung', $thiscontent )</script>";
	
 	return $str;
}

function Content_TeilnMitgliedz(){
	global $data;
	$content_id ='TeilNMitgliedz';
	$chart_style = 'bar';
	$yachsen_beschriftung='Teilnahmen';
	$xachsen_beschriftung='Mitgliedszeit[Jahre]';
	
	$chart_id= "Chart_$content_id";
	$tabel_id= $content_id."table";
	
	
	// ------------Paint Canvas and get Chartdata ------------
	$str ="<table><tr>";
	$n=0;
	$chartdata=[];
	$temp=[];
	
	foreach($data['user'] as $user => $userdata){
		if ($userdata['Events']==[]) continue;
		$min =	date('Y', $userdata['reg_date']);
		//$min = min(array_keys($userdata['Events']));
		$max = max(array_keys($userdata['Events']));
		$ycount = count(array_keys($userdata['Events']));

		foreach($userdata['Events'] as $y => $eventdata){
			$abmeldungen = 0;
			$anmeldungen = count(array_keys($eventdata));

			foreach($eventdata as $event){
				if($event['deleted']==1 or $event['cancelled']==1 ){
					$abmeldungen++;
				} //skip this event
			}
			if ($y < $min) $y= $min;
			if(!isset($chartdata['Anmeldungen'][$y-$min])) {
				$chartdata['Anmeldungen'][$y-$min]=0;
			}
			if(!isset($chartdata['Abmeldungen'][$y-$min])) {
				$chartdata['Abmeldungen'][$y-$min]=0;
			}
			if(!isset($chartdata['n'][$y-$min])) {
				$chartdata['n'][$y-$min]=0;
			}

			
			$chartdata['Anmeldungen'][$y-$min] += $anmeldungen;
			$chartdata['Abmeldungen'][$y-$min] += $abmeldungen;
			$chartdata['n']			 [$y-$min]++;
			
		

		}
		
		//echo "User: $user | Anmeldungen: $anmeldungen | Abmeldungen: $abmeldungen </br>";
		
		
	}
	
	foreach($chartdata['Anmeldungen'] as $j => $cdata){
		$chartdata['Anmeldungen'][$j] = $cdata/$chartdata['n'][$j];
	}
	foreach($chartdata['Abmeldungen'] as $j => $cdata){
		$chartdata['Abmeldungen'][$j] = $cdata/$chartdata['n'][$j];
	}
		
	$str .= get_comment_line(2, "Zählt für alle Nutzer die An- und Abmeldungen und trägt sie über die Mitgliedschaftszeit (Eventjahr - Registrierjahr) auf!");
	$str .= get_input_col($tabel_id."_Anmeldungen",	 	$chart_id.'_'.'Anmeldungen', 		'Anmeldungen');
	$str .= get_input_col($tabel_id."_Abmeldungen",	 	$chart_id.'_'.'Abmeldungen', 		'Abmeldungen');
	
	
	ksort($chartdata['Anmeldungen']);
	//echo(array_key($chartdata));
	$str .= "</tr>";
	$n=2;
	$str .= get_canvas_row($n,$chart_id);
	$x_achse = json_encode(array_keys($chartdata['Anmeldungen']));	//write x-axes layout value

	//------------ Display Chartdata as Table ------------
	
	//$str .= get_table_inlay($tabel_id,$n, $xachsen_beschriftung , $yachsen_beschriftung, $chartdata);
	
	//$str .= array_key($chartdata);
	$str .= "</table>";
	
	// display Chart and publisch Chartdata in JS 
	$str .= "<script>buildchart_by_id('$chart_id', '$chart_style' , $x_achse, '$xachsen_beschriftung', '$yachsen_beschriftung' )</script>";
	$str .= array2JS($chartdata, $content_id);
	
	$thiscontent =$content_id;
	//echo $thiscontent;
	//$str .= "<script>show_data('$chart_id','$yachsen_beschriftung', $thiscontent )</script>";
	
 	return $str;
}

function Content_newcomer(){
	
	global $data;
	$content_id ='newcomer';
	$chart_style = 'bar';
	$yachsen_beschriftung='Anzahl der Neulinge (- abgemeldete Teilnahmen)';
	$xachsen_beschriftung='Events';
	
	$chart_id= "Chart_$content_id";
	$tabel_id= $content_id."table";
	
	
	// ------------Paint Canvas and get Chartdata ------------
	$str ="<table><tr>";
	$str .= get_comment_line(2, "Zählt alle Neulinge");
	
	$n=0;
	$chartdata=[];
	foreach($data['user'] as $key => $event_user){
		foreach($event_user['Events'] as $y => $event){
		
			//echo array_key($event);
			
		}
	}
	arsort($chartdata);
	$chartdata=array_slice($chartdata,0,20);
	//echo(array_key($chartdata));
	$str .= "</tr>";
	$n=1;
	$str .= get_canvas_row($n,$chart_id);
	$x_achse = json_encode(array_keys($chartdata));	//write x-axes layout value

	//------------ Display Chartdata as Table ------------
	
	//$str .= get_table_inlay($tabel_id,$n, $xachsen_beschriftung , $yachsen_beschriftung, $chartdata);
	
	//$str .= array_key($chartdata);
	$str .= "</table>";
	
	// display Chart and publisch Chartdata in JS 
	$str .= "<script>buildchart_by_id('$chart_id', '$chart_style' , $x_achse, '$xachsen_beschriftung', '$yachsen_beschriftung' )</script>";
	$str .= array2JS($chartdata, $content_id);
	
	$thiscontent =$content_id;
	//echo $thiscontent;
	$str .= "<script>show_data('$chart_id','$yachsen_beschriftung', $thiscontent )</script>";
	
 	return $str;


}

