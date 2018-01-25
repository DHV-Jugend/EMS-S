function EMS_S_showStuff(text, id) {
	n=0;
	obj_id=text + n;
	//console.log(obj_id);
	while (document.getElementById(obj_id) !== null){
		if (n == id){
			document.getElementById(obj_id).style.display = '';
			//console.log ('activate_show: ', obj_id);
		}
		else {
			document.getElementById(obj_id).style.display = 'none';
		}
		n=n+1;
		obj_id=text + n;
	}
}

function EMS_S_toogleStuff(obj){
	
	//console.log(obj.id,' is ',obj.checked);
	objid_string=obj.id.split('_');
	year = objid_string[1]
	type = objid_string[0];
	
	//console.log ('ID: ', type+'_row_' + year);
	if (obj.checked){
			document.getElementById(type+ '_row_' + year).style.display = '';
			//console.log ('activate_toogle: ', type+'_row_' + id);
		}
		else {
			document.getElementById(type+ '_row_' + year).style.display = 'none';
		}
}

function buildchart_by_id(id, type ='line', mylabels=[], xAxes_labelString ="default", yAxes_labelString ="default"){
	//console.log(1);
	//console.log('Create Chart: ',[ id, type, mylabels, xAxes_labelString, yAxes_labelString]);
	//console.log(2);
	var ctx = document.getElementById(id).getContext('2d');
	var id_name= id+'_object';
	
	console.log('Create Chart object : ',id_name);
	
	eval(id_name +"= new Chart(ctx, {type: type ,data: {labels: mylabels}, options: {scales:{xAxes: [{scaleLabel: {display: true,labelString: xAxes_labelString }}],yAxes: [{scaleLabel: {display: true,labelString: yAxes_labelString },ticks: {beginAtZero:true}}]}}});");
}

function EMS_S_charttoogle(obj){
	console.log('aktivate Chart:...', obj);
	var objekt = obj;
	var obj_str =obj.id.split("_");
	var chartname = obj_str[0]+"_"+obj_str[1];
	var year =obj_str[2];
	var data= eval(obj_str[1])[year];
	var mychart=eval(chartname+'_object');
	//console.log ('obj_str' ,obj_str);

	if(obj.checked){
		
		var id =mychart.config.data.datasets.length;
		var labels = mychart.config.data.labels;
		var str = '[';
		labels.forEach(function(entry){
			str += data[entry] +",";
		});
		str = str.substr(0,str.length-1);
		str +=']';
		mychart.config.data.datasets[id]=[];
		mychart.config.data.datasets[id].data= eval(str);
		mychart.config.data.datasets[id].label=year;
		
		
		//console.log (obj_str);
		var c=document.getElementById(chartname+'_'+year+'_color').value;
		r= parseInt('0x'+c.substr(1,2),16);
		g= parseInt('0x'+c.substr(3,2),16);
		b= parseInt('0x'+c.substr(5,2),16);
		
		mychart.config.data.datasets[id].backgroundColor ='rgba('+r+','+g+','+b+',1)';
		mychart.config.data.datasets[id].borderColor ='rgba('+r+','+g+','+b+',1)';
		mychart.config.data.datasets[id].borderWidth = '1';
		mychart.config.data.datasets[id].year =year;
	}
	else{
		mychart.config.data.datasets.forEach(function callback(currentValue, index, array){
			if (currentValue.year == year){
				//console.log(index,currentValue );
				mychart.config.data.datasets.splice(index,1);
			}
		});
	}
    mychart.update();
}

function EMS_S_chartpaint(obj){
	var objekt = obj;
	var obj_str =obj.id.split("_");
	var chartname = obj_str[0]+"_"+obj_str[1];
	var year =obj_str[2];
	var data= eval(obj_str[1])[year];
	var mychart=eval(chartname+'_object');
	//console.log ('year ', year);
	//console.log ('chartname' ,chartname)
	//console.log ('obj_str' ,obj_str)
	
	mychart.config.data.datasets.forEach(function callback(currentValue, index, array){
			if (currentValue.year == year){
				var c=obj.value;
				r= parseInt('0x'+c.substr(1,2),16);
				g= parseInt('0x'+c.substr(3,2),16);
				b= parseInt('0x'+c.substr(5,2),16);
				//console.log(r, g, b);
				mychart.config.data.datasets[index].backgroundColor ='rgba('+r+','+g+','+b+',1)';
				mychart.config.data.datasets[index].borderColor ='rgba('+r+','+g+','+b+',1)';
			}
		});
	
    mychart.update();
}

function show_data(chartname, Titel , data ){
	 mychart=eval(chartname+'_object');
	
	 id =mychart.config.data.datasets.length;
	 labels = mychart.config.data.labels;
	 str = '[';
	labels.forEach(function(entry){
		
		str += data[entry] +",";
		});

	str = str.substr(0,str.length-1);
	str +=']';
	mychart.config.data.datasets[id]=[];
	mychart.config.data.datasets[id].data= eval(str);
	mychart.config.data.datasets[id].label=Titel;
	mychart.config.data.datasets[id].backgroundColor = 'DarkBlue';
	mychart.config.data.datasets[id].borderColor ='DarkBlue';
	
    mychart.update();
}

function div_array(array1, array2, key1, key2){
	//console.log(key1);
	y=2014;
	c={};
	console.log(array1[y]);
	console.log(array2[y]);
	while (typeof array1[y] !== 'undefined'){
		c[y]=array1[y][key1]/array2[y];
		y=y+1;
	}
	//console.log(c);
	
pTjT[0]=c;

return c;

}

function toogle_array_key(obj){
	obj=obj.nextElementSibling;
	//console.log(obj.style.visibility);
	//obj = document.getElementById(id);
	
	if (obj.style.visibility == 'collapse'){
		obj.style.visibility = '';
	}
	else{
		obj.style.visibility = 'collapse';
	}
	
}

function ask() {
		  var type = document.getElementById('type').value;
		  var affected = document.getElementById('affected').value;
		  var id = document.getElementById('id').value;
		 return confirm('Bist du Sicher, dass du |'+type+'| Datensatz: |'+affected+'| |'+id+'| in die Datenbank eintragen willst?');
}

function toogle_obj( obj ){
		//console.log(obj);
			value= obj.value;
			hiddenobj= document.getElementById('hiddenopt');
			console.log(value);
			if (value == 'remove'){
				hiddenobj.style.display = 'none';
			}
			else{
				hiddenobj.style.display = '';
			}
		}