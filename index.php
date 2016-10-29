<?
//Programmed by Roberto Chalean
//robertchalean@gmail.com
//Program idea Zuzo Tanous

//header("Content-Type: text/plain");
session_start();
$localIP = getHostByName(getHostName());
//echo $localIP . "<br>";

$bLocal = 0;

$dist="";
if ($localIP == "localhost:13080"){
 
	$bLocal = 1;
 
}else{

  $dist="-dist";
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Memory Direction</title>
	<script src="js/jquery.min.js"></script> 
	<script src="js/underscore-min.js"></script>

	<? if(!$bLocal){ ?>

    <script>
    //Analytics

    </script>
  <? } ?>
</head>
<body>
<? if(!$bLocal){ ?> 
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<? } ?>
<h3>Memory Direction!</h3>

Level&nbsp;
<select id="level" style="width: 65px;">
  <option value="1" selected="">5x5</option>
  <option value="2">10x10</option>
</select> 
&nbsp;
<input type="button" value="Start" id="jugar">
<!--
&nbsp;
<input type="button" value="config" id="config">
-->
&nbsp;<b>|</b>&nbsp;
&nbsp;Rapid Time&nbsp;
<select id="time" style="width: 65px;">
  <option value="1750" selected>1.75s</option>
  <option value="1400">1.4s</option>
  <option value="1350">1.35s</option>
  <option value="1300">1.3s</option>
  <option value="1250">1.25s</option>
  <option value="1200">1.2s</option>
  <option value="1150">1.15s</option>
  <option value="1100">1.1s</option>
  <option value="1050">1.05s</option>
  <option value="1000">1.0s</option>
  <option value="950">0.95s</option>
  <option value="900">0.9s</option>
  <option value="850">0.85s</option>
  <option value="800">0.8s</option>
  <option value="750">0.75s</option>
  <option value="700">0.7s</option>
  <option value="650">0.65s</option>
  <option value="600">0.6s</option>
  <option value="550">0.55s</option>
  <option value="500">0.5s</option>
  <option value="450">0.45s</option>
  <option value="400">0.4s</option>
  <option value="350">0.35s</option>
  <option value="300">0.3s</option>
  <option value="250">0.25s</option>
</select> 
&nbsp;Number&nbsp;
<select id="number">
  <option value="1">1</option>
  <option value="2">2</option>
  <option value="3">3</option>
  <option value="4">4</option>
  <option value="5">5</option>
  <option value="6">6</option>
  <option value="7">7</option>
  <option value="8">8</option>
  <option value="9">9</option>
  <option value="10">10</option>
  <option value="11">11</option>
  <option value="12">12</option>
  <option value="13">13</option>
  <option value="14">14</option>
  <option value="15" selected>15</option>
</select>
&nbsp;Constant time&nbsp; <input type="checkbox" value="1" id="constantTime">
&nbsp;
<input type="button" value="Start Rapid" id="jugar-rapid">
&nbsp;<b>|</b>&nbsp;
<input type="button" value="Memory Color" id="Mr" onclick="location.href='http://competicionmental.appspot.com/colors';"> 
&nbsp;&nbsp;
<a href="#" onclick="alert(window.helpText);"><img src="img/help.png"></a>
<? if(!$bLocal){ ?> 
&nbsp;&nbsp;<div class="fb-share-button" data-href="http://competicionmental.appspot.com/memoryDirection" data-layout="button_count"></div>
<? } ?>

<br><br>
<div id="screen"></div>

<script type="text/javascript">
helpText="Blank time = 0.2s\nIdea of memorize Direction: Zuzo Tanous\nProgramming: robertchalean@gmail.com";
arrayDirecciones=["←","↑","→","↓","↖","↗","↘","↙"];
/*
0-negro: 000000
1-marron: 974b00
2-rojo: ff0000
3-naranja:  ff8c55
4-amarillo: fff200
5-verde: 00ff00
6-azul: 0000ff
7-violeta: 800080
8-gris: 808080
*/
arrayColors=["000000","974b00","ff0000","ff8c55","fff200","00ff00","0000ff","800080","808080"];

selectedItems = [];
selectedItemsRnd = [];
var lista = [];
var aRecall = [];
var respuestas = [];

vistaConfig = 0;
t_ini = 0, t_fin = 0, t_fin2 = 0, t_dif = 0, t_total = 0;

$("#jugar").click(jugar);
$("#jugar-rapid").click( function(){ jugarRapid(1); });

function ts(ms){
   min = (ms/1000/60) << 0;
   sec = (ms/1000) % 60;

   return(min + ':' + sec);
}

function n(x){ return parseFloat($("#"+x).val()); }

var killTimeout,killTimeout1,tiempoInicial,pasadas,totalPasadas,modoJuego;

function jugarRapid(fase){

	if(fase==1){

		modoJuego=2;
		tamano=5;

		clearTimeout(killTimeout); clearTimeout(killTimeout1);

		tiempoInicial = n("time");
		pasadas=0;
		totalPasadas = n("number");

		selectedItems = [];

		for(z=0;z<25;z++){
			rnd = _.random(0,arrayDirecciones.length-1);
			rnd1 = _.random(0,arrayColors.length-1);

			figura = arrayDirecciones[rnd];
			color= arrayColors[rnd1]

			selectedItems[z] = {};
			selectedItems[z].txt = figura;
			selectedItems[z].color = color;
		}
		
		fase=2; t_ini = Date.now();
	}

	if (! $('#constantTime').is(':checked')){

		if(pasadas==3)
			tiempoInicial = tiempoInicial * 0.8;
		if(pasadas==6)
			tiempoInicial = tiempoInicial * 0.6;
		if(pasadas==8)
			tiempoInicial = tiempoInicial * 0.4;
		if(pasadas==10)
			tiempoInicial = tiempoInicial * 0.2;
	}

	$("#screen").html(`<br><br><center><b>${pasadas+1}</b></center><br><br><center><div style="font-size: 100px; color: #${selectedItems[pasadas].color};"><b>${selectedItems[pasadas].txt}</b></div></center>`);

	killTimeout = setTimeout(function(){



		$("#screen").html("");

		t_fin2 = Date.now();

		pasadas++;

		if(pasadas==totalPasadas){

			$("#screen").append("<br><br><center><input type=\"button\" value=\"Recall\" id=\"recall\"></center>");


			recall1();

			return;
		}

		killTimeout1 = setTimeout(function(){ jugarRapid(2); }, 200);

	}, tiempoInicial);
	

}

function jugar(){
	modoJuego=1;

	vistaConfig = 0;

	tamano = 0;

	if(parseInt($("#level").val())==1)
	  tamano = 5;
	else  
	  tamano = 10; 

	poner = "<table border=\"0\">";

	z=0;
	for(i=0;i<tamano;i++){
		poner += "<tr>";

		for(j=0;j<tamano;j++){
			rnd = _.random(0,arrayDirecciones.length-1);
			rnd1 = _.random(0,arrayColors.length-1);

			figura = arrayDirecciones[rnd];
			color= arrayColors[rnd1]
			selectedItems[z] = {};
			selectedItems[z].txt = figura;
			selectedItems[z].color = color;

			//poner += `<td><div class="dropdown"><a href="#" class=\"dropbtn\" style=\"text-decoration: none;\"><div style=\"background-color: " + colores[id][1] + "; width: 30px; height: 30px;  z-index: 90;\">&nbsp;</div></a><div class=\"dropdown-content\" style=\"z-index: 100;\">" + colores[id][0] + "<br>" + colores[id][1] +  "<br>" + colores[id][2] +  "<br></div></div></td>;
			
			poner += `<td style="color: #${selectedItems[z].color}; font-size: 28px;"><b>${selectedItems[z].txt}</b></td>`;

			z++;
		}
		poner += "</tr>";
	}
	poner += "</table>";

	console.log(selectedItems);

	$("#screen").html(poner);
	t_ini = Date.now();
	$("#screen").append("<br><input type=\"button\" value=\"Recall\" id=\"recall\">");


	$("#recall").click(recall1);

}

function recall1(){
  recall = []; t_fin = Date.now();
  for (var i = 0; i < 100; i++) {
  		recall[i]={};
  		recall[i].txt="x";
  		recall[i].color="x";
  };

  //selectedItemsRnd = selectedItems.slice();
  //selectedItemsRnd = selectedItemsRnd.sort(function() {return Math.random() - 0.5});
  /*
  poner2 = "<table border=\"0\">";
  z=0;
  for(i=0;i<tamano;i++){
    recall[z] = "#FFFFFF";  
    poner2 += "<tr>";

		for(j=0;j<tamano;j++){

			idRnd = selectedItemsRnd[z];

			//poner2 += "<td><div class=\"dropdown\"><a href=\"#\" class=\"dropbtn\" style=\"text-decoration: none;\"><div style=\"background-color: " + colores[idRnd][1] + "; width: 30px; height: 30px;  z-index: 90;\" onclick=\"contestar(fff,'" + colores[idRnd][1] + "');\" title=\"" + colores[idRnd][0] + "\">&nbsp;</div></a><div class=\"dropdown-content\" style=\"z-index: 100; display:none;\"></div></div></td>";


			z++;
		}
		poner2 += "</tr>";
  }
  poner2 += "</table>";
  */

  poner2=`<div>`;

	for (var i = 0; i < arrayColors.length; i++) {
			poner2+=`<div class="respuesta-color-class-zzz" id="respuesta-color-id-zzz-${i}" style="background-color: #${arrayColors[i]}; width:20px; height:20px; float: left; border-style: solid; border-width: 2px; border-color: white;" onclick="contestarColor(zzz,'${arrayColors[i]}','${i}');">&nbsp;</div>`;
	};
	poner2+="<br>";
	for (var i = 0; i < arrayDirecciones.length; i++) {
			poner2+=`<div class="respuesta-txt-class-zzz" id="respuesta-txt-id-zzz-${i}"  style="width: 20px; height:20px; float: left; border-style: solid; border-width: 2px;  border-color: white;" onclick="contestarDireccion(zzz,'${arrayDirecciones[i]}','${i}');">${arrayDirecciones[i]}</div>`;
	};

  poner2+= `<br></div>`;

  poner = "<table border=\"1\" style=\"border: 1px solid gray;  border-collapse: collapse;\">";

  z=0;
	for(i=0;i<tamano;i++){
		poner += "<tr>";

		for(j=0;j<tamano;j++){

			poner3 = poner2;
			poner3 = poner3.replace(/zzz/g,z);
			//console.log(poner3);


			if(modoJuego==1){
				poner += `<td><center>${z+1}</center>  <br> ${poner3}</td>`;


			}else{
				if(z>=totalPasadas){
					poner += `<td>&nbsp;</td>`;

				}else{
					poner += `<td><center>${z+1}</center> <br> ${poner3}</td>`;
				}
				

			}
			

			z++;
		}
		poner += "</tr>";
	}
	poner += "</table>";
  
  //$("#screen").html(poner);
  $("#screen").html(poner);
  $("#screen").append("<br><input type=\"button\" value=\"Answer\" id=\"answer\">");

  $("#answer").click(answer);
}

correctas = 0;

function answer(){
  z=0; correctas=0;
  poner = "<table border=\"0\">";

	for(i=0;i<tamano;i++){
	 
		poner += "<tr>";

		for(j=0;j<tamano;j++){


			border = "";
			idSelectedItem = selectedItems[z];

			border = " border: 1px solid green;";
			if(selectedItems[z].color!=recall[z].color || selectedItems[z].txt!=recall[z].txt){
				border = " border: 1px solid red;";

				if(modoJuego==1){
					poner += "<td>" +
				      "<div style=\"width 32px; height: 30px !important; " + border + "\">" +
				        "<div style=\"color: #" + selectedItems[z].color + "; width: 20px; height: 40px;  float: left; font-size: 20px;\">" + selectedItems[z].txt + "</div>" + 
				        "<div style=\"color: #" + recall[z].color + "; width: 20px; height: 40px; float: left; font-size: 20px;\">" + recall[z].txt + "</div>" +
				      "</div>" + 
				    "</td>";


				}else{

						if(z>=totalPasadas){
							poner += `<td>&nbsp;</td>`;

						}else{
							poner += "<td>" +
						      "<div style=\"width 32px; height: 30px !important; " + border + "\">" +
						        "<div style=\"color: #" + selectedItems[z].color + "; width: 20px; height: 40px;  float: left; font-size: 20px;\">" + selectedItems[z].txt + "</div>" + 
						        "<div style=\"color: #" + recall[z].color + "; width: 20px; height: 40px; float: left; font-size: 20px;\">" + recall[z].txt + "</div>" +
						      "</div>" + 
						    "</td>";


						}
				}
				

			}else{
				

				if(modoJuego==1){
					correctas++;

					poner += "<td>" +
					      "<div style=\"width 32px; height: 30px !important; " + border + "\">" +          
					        "<div style=\"color: #" + recall[z].color + "; width: 40px; height: 40px; float: left; font-size: 20px;\"><center>" + recall[z].txt + "</center></div>" +
					      "</div>" + 
					    "</td>";
				}else{
					if(z>=totalPasadas){
							poner += `<td>&nbsp;</td>`;

						}else{
							correctas++;

							poner += "<td>" +
					      "<div style=\"width 32px; height: 30px !important; " + border + "\">" +          
					        "<div style=\"color: #" + recall[z].color + "; width: 40px; height: 40px; float: left; font-size: 20px;\"><center>" + recall[z].txt + "</center></div>" +
					      "</div>" + 
					    "</td>";

						}
				}
			}

			z++;
		}//for j
		poner += "</tr>";
	}//for i
	poner += "</table>";

	myDate =  new Date();
	month = myDate.getMonth(); fullYear = myDate.getFullYear(); day = myDate.getDay(); date = myDate.getDate(); year = myDate.getYear();
	ponerFecha = (month+1) + "/" + date + "/" + fullYear + "<br>";


	if(modoJuego==1){

		tt = (parseInt(tamano)*parseInt(tamano));
		porcent = correctas * 100 / tt; 

		t_dif = t_fin - t_ini;

		$("#screen").html(poner);
		$("#screen").append("<br><br><div style=\"background-color: #3fad46; color:white; width 500px;\">You got " + correctas + " out of " + tt + " attempted! (" + porcent.toFixed(2)  + "% accuracy) in " + getDuration(t_dif) + ", " + ponerFecha +  "</div>");
		// $("#screen").append("<br><input type=\"button\" value=\"Agregar al Ranking\" id=\"addRank\">");

	}else{

		tt = (parseInt(tamano)*parseInt(tamano));
		porcent = correctas * 100 / totalPasadas; 

		t_dif = t_fin2 - t_ini;

		$("#screen").html(poner);

		$("#screen").append("<br><br><div style=\"background-color: #3fad46; color:white; width 500px;\">You got " + correctas + " out of " + totalPasadas + " attempted! (" + porcent.toFixed(2)  + "% accuracy) in " + getDuration(t_dif) + ", " + ponerFecha +  "</div>");
		// $("#screen").append("<br><input type=\"button\" value=\"Agregar al Ranking\" id=\"addRank\">");


	}
}


function contestarDireccion(x,y,z){

	if(recall[x].txt==y){
		$(".respuesta-txt-class-"+x).css("border-color","white");
		recall[x].txt="x";
		return;
	}

  console.log(x + " = " + y);
  //$("#respuesta"+x).css("background-color",y);
  $(".respuesta-txt-class-"+x).css("border-color","white");

  $("#respuesta-txt-id-"+x+"-"+z).css("border-color","black");
  recall[x].txt=y;
}
function contestarColor(x,y,z){
	if(recall[x].color==y){
		$(".respuesta-color-class-"+x).css("border-color","white");
		recall[x].color="x";
		return;
	}

  console.log(x + " = " + y);
  $(".respuesta-color-class-"+x).css("border-color","white");

  $("#respuesta-color-id-"+x+"-"+z).css("border-color","black");
  //$("#respuesta"+x).css("background-color",y);
  recall[x].color=y;
  
}


var getDuration = function(millis){
	var dur = {};
	var units = [
	    {label:"millis",    mod:1000},
	    {label:"seconds",   mod:60},
	    {label:"minutes",   mod:60},
	    {label:"hours",     mod:24},
	    {label:"days",      mod:31}
	];
	// calculate the individual unit values...
	units.forEach(function(u){
	    millis = (millis - (dur[u.label] = (millis % u.mod))) / u.mod;
	});
	// convert object to a string representation...
	var nonZero = function(u){ return dur[u.label]; };
	dur.toString = function(){
	    return units
	        .reverse()
	        .filter(nonZero)
	        .map(function(u){
	            return dur[u.label] + " " + (dur[u.label]==1?u.label.slice(0,-1):u.label);
	        })
	        .join(', ');
	};
	return dur;
};


</script>
</body>
</html>
