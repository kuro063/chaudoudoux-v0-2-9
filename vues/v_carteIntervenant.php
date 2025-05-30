<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"></script>
    <style type="text/css">
      html, body { width:100%;height:100%;padding:0;margin:0; }
      #map { width:100%;height:100%;padding:0;margin:0;z-index:0 }
      #image { height: 10% }
      .address:hover { color:#AA0000;text-decoration:underline }
    </style>
  </head>
  
<div class="Place" style="float:left;position:absolute;left:40px;">
		<h3> PLACÉ OU NON :</h3>
		<h5><input type='checkbox' id='place' onchange='hide_show_markers(this.id)' checked />PLACÉ</h5>
		<h5><input type='checkbox' id='non_place' onchange='hide_show_markers(this.id)' checked  />NON PLACÉ</h5><br/><br/> 
</div>

<div class="spe" style="float:left;position:absolute;left:600px;top:0.1px">
	<h3> SPÉCIFICITÉ(s) :</h3>
		<h5><input type='checkbox' id='GE_moins_3ans' onchange='hide_show_markers(this.id)'  />G.ENFANTS -3ANS</h5>
		<h5><input type='checkbox' id='voiture' onchange='hide_show_markers(this.id)'  />VOITURE</h5>
		<h5><input type='checkbox' id='handicap' onchange='hide_show_markers(this.id)'   />HANDICAP</h5><br/><br/> 
</div>
<div id="top">
	<a class="btn btn-secondary display-4 sideButton" style="float:right;position:absolute;right:10px" href="geocoder/localisationIntervenants.php" target="_blank">GÉNÉRATEUR D'ADRESSE</a>
	
	<div class="deroule" style="float:left;position:absolute;left:30px;top:100px">
	<label class="container"><b>TOUT COCHER / DÉCOCHER</b>
		<input type="checkbox" id="hide_all" onchange="hide_show_markers(this.id)" checked>
		<span class="checkmark"></span>
		</label>

	  <label class="container"><b>GARDE D'ENFANTS ET MÉNAGE</b>
		<input type="checkbox" name="marker" value="hide" id="ge_menage" onchange="hide_show_markers(this.id)" checked>
		<span class="checkmark"></span>
		</label>

	  <label class="container"><b>GARDE ENFANTS</b>
		<input class="ge_menage" type="checkbox" name="marker" value="hide" id="garde_enfant" onchange="hide_show_markers(this.id)" checked>
		<span class="checkmark"></span>
		</label>

	  <label class="container"><b>MENAGE</b>
		<input class="ge_menage" type="checkbox" name="marker" value="hide" id="menage" onchange="hide_show_markers(this.id)" checked>
		<span class="checkmark"></span>
		</label>
 
	</div>
</div>


	  <h1 style="text-align: center"  id="nombre_Intervenants"></h1>


<body>
  <div class="deroule-content" style="column-count: 1;display: initial; position :fixed; right: 1% ;bottom: 2%;width: 400px;height: 265px;">

  <img src="https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-black.png"
  alt="Marker de couleur noir" id="image">: Employés <br>
  
  <h6><strong>Non Placé :</strong></h6>
  <img src="https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-orange.png"
  alt="Marker de couleur orange" id="image">: G.Enfants et Ménage<br>

  <img src="https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png"
  alt="Marker de couleur rouge" id="image">: Garde d'Enfants<br>

  <img src="https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-violet.png"
  alt="Marker de couleur violet" id="image">: Ménage<br>

  <h6><strong>Placé :</strong></h6>
  <img src="https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png"
  alt="Marker de couleur vert" id="image">: G.Enfants et ménage<br>

  <img src="https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png"
  alt="Marker de couleur bleu" id="image">: Garde d'Enfants<br>
  
  

  <img src="https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-yellow.png"
  alt="Marker de couleur jaune" id="image">: Ménage<br>


</div>

<div id="map" style="column-count: 1;display: initial; position :absolute;top:250px"></div>

<?php $coord = array();
$count = 0;
foreach($lesSalaries as $unSalarie){
	$numSalarie = $unSalarie["0"];
	$Salarie = $pdoChaudoudoux->obtenirDetailsSalarie($numSalarie);
	array_push($coord, $Salarie);
	$count++;
}

// echo sizeof($lesSalaries[10]);
// echo json_encode($place[1]["Place"]);
?>
<script type="text/javascript">
lesSalaries = <?php echo json_encode($lesSalaries);?>;
infoSalaries = <?php echo json_encode($coord);?>;
//Pour les couleurs, chaque élément du tableau représente une option du tableau
// 0: Ménage 1: GE+Ménage 2: Garde d'enfants 3: Placé ou Non
menu_option = [1,1,1,1];
let listeMarker = new Array();
console.log(lesSalaries[26]);

$(document).ready(function() {//démarrage de jQuery
    var myItems;
    $.getJSON('assets/json/intervenants.json', function(data) {//recupere les données du json
        myItems = data;
        for (let i = 0; i < lesSalaries.length; i++) 
        {
          try//pour que le code ne s'arrete pas car une famille n'est pas présente dans le json
          {
            var k = myItems.findIndex(element => element["id"] == lesSalaries[i]["0"]);//Permet de retrouver les valeurs d'une famille dans le json
            lat = myItems[k]["latitude"];
            lon = myItems[k]["longitude"];
          }
          catch(e)//Si dans le json une famille n'est pas présente, l'erreur sera renvoyé
          {
            console.log(e + "à l'intervenant " + lesSalaries[i]["0"] + " " + i);
            lat = 0;
            lon = 0;
          }
          
          listeMarker.push([L.marker([lat, lon], {title: "Coordinates", alt: "Coordinates"}).addTo(map).on('mouseover', function() {
            listeMarker[i][0].bindPopup("M : " + lesSalaries[i]["37"] + "<br/>" +
            "NOM : " + lesSalaries[i]['3'] + "<br/>" +
            Popup_message(i) + "<br/>" +
            "<a href='index.php?uc=annuSalarie&action=voirDetailSalarie&num=" + lesSalaries[i]["37"] +
            "'>detail</a>").openPopup(); //Informations qui apparaissent quand la souris passe au-dessus du marker
          }),0]);//le 0 correspond à un index expliqué dans Marker_options
          listeMarker[i][0].on('click', function(){
            window.open("index.php?uc=annuSalarie&action=voirDetailSalarie&num=" + lesSalaries[i]["37"]);
          });//lorsque le marker est cliqué, il ouvre la page detail de la famille correspondante
          //
          Marker_options(i);
          Couleur_option(i);
          count_Intervenant();
        }
            });
});


function Marker_options(i)
{
  var index = 0;
  //index est le nombre de fois une famille
  //a une des options du menu déroulant
  //sauf autres, qui ont un index négatif
  if(lesSalaries[i][56] == 1 || lesSalaries[i][56] == 0){
    index++;
  }
  if(index == 0){
    index--;
  }
  listeMarker[i][1] = index;
}

//
var options = {
 center: [48.114059, -1.677005],
 zoom: 9
};

var map = L.map('map', options);
var nzoom = 11;
map.setView([48.074059, -1.677005],nzoom);

L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {attribution: 'OSM'}).addTo(map);

function Couleur_option(i)
{
  var typeInterv = null;
  
  // typeInterv prend la valeur 'ENFANT, MENAGE ou TOUT'
  if(menu_option[0] == 1 && lesSalaries[i][33] == "MENAGE"){
		typeInterv = lesSalaries[i][33];
  }
  if(menu_option[2] == 1 && lesSalaries[i][33] == "ENFANT"){
		typeInterv = lesSalaries[i][33];
  } 
  if(menu_option[1] == 1 && lesSalaries[i][33] == "TOUT"){
		typeInterv = lesSalaries[i][33];
  }

  //ensemble de if pour savoir quelle couleur donné à un marker
  if(typeInterv =="MENAGE" && lesSalaries[i][56]==1){
		url="yellow";
  }
  else if(typeInterv=="TOUT"&& lesSalaries[i][56]==1){
       url="green";
  }
  else if(typeInterv=="ENFANT" && lesSalaries[i][56]==1){
        url="blue";
  }
  else if(typeInterv=="MENAGE" && lesSalaries[i][56]==0){
		url="violet";
  }
  else if(typeInterv=="TOUT" && lesSalaries[i][56]==0){
       url="orange";
  }
  else if(typeInterv=="ENFANT" && lesSalaries[i][56]==0){
        url="red";
  }
  else { //if((lesSalaries[i][33] == "EMPLOYÉ" && lesSalaries[i][56]==0) || (lesSalaries[i][33] == "EMPLOYÉ" && lesSalaries[i][56]==1))
	  url = "black";
  }
  icon(url,listeMarker[i][0]);
}

function icon(url,marker)
{
  var Icon_created = new L.Icon({
  iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-' + url + '.png',
  shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
  iconSize: [25, 41],
  iconAnchor: [12, 41],
  popupAnchor: [1, -34],
  shadowSize: [41, 41]
});//crée une variable icon et l'affecte à l'icon d'un marker
  marker.setIcon(Icon_created);
}

function hide_show_markers(type_marker)
{
  switch(type_marker){
    case "menage":
      for(let i = 0; i < listeMarker.length; i++)//boucle pour le nombre de marker
      {
        if (!document.getElementById(type_marker).checked)//si la case n'est pas coché
        {
			if(lesSalaries[i][33]=="MENAGE" && listeMarker[i][1]==1){//si l'intervenant fais que le ménage
				menu_option[0] = 0;//on veut cacher la couleur associé au ménage
				Couleur_option(i);//on relance la fonction si la couleur change
				listeMarker[i][1]--;//index diminue car une des options est cachée
				closure(listeMarker[i][0],listeMarker[i][1]);//regarde si l'index est égale à 0
															 //si oui cache le marker
			}
			if(lesSalaries[i][33]=="TOUT"){
				if(menu_option[2]==0 && menu_option[0]==0 && listeMarker[i][1]==1){
					menu_option[1]=0;
					Couleur_option(i);
					listeMarker[i][1]--;
					closure(listeMarker[i][0],listeMarker[i][1]);
				}
			}
        }
        else
        {
			if(document.getElementById("place").checked){
			  if(document.getElementById("GE_moins_3ans").checked && lesSalaries[i][28]==1){
					if(document.getElementById("voiture").checked && lesSalaries[i][23]==1){
						if(document.getElementById("handicap").checked && lesSalaries[i][29]==1){
						  if(lesSalaries[i][33]=="MENAGE" && lesSalaries[i][56] == 1 && listeMarker[i][1]==0){//si la famille associé au marker à une demande a pourvoir de ménage
							menu_option[0] = 1;//on veut faire réapparaitre la couleur associé au ménage
							Couleur_option(i);//on relance la fonction si la couleur change
							listeMarker[i][1]++;//index augmente car cette option est affiché
							closure(listeMarker[i][0],listeMarker[i][1]);//si le marker a un index supérieur à 0 (normalement le cas)
						  }
						  if(lesSalaries[i][33]=="TOUT"){
							if((menu_option[2]==1 || menu_option[0]==1) && listeMarker[i][1]==0 && lesSalaries[i][56] == 1){
								menu_option[1]=1;
								Couleur_option(i);
								listeMarker[i][1]++;
								closure(listeMarker[i][0],listeMarker[i][1]);
							}
						  }
						}
						else if(!document.getElementById("handicap").checked){
						  if(lesSalaries[i][33]=="MENAGE" && lesSalaries[i][56] == 1 && listeMarker[i][1]==0){//si la famille associé au marker à une demande a pourvoir de ménage
							menu_option[0] = 1;//on veut faire réapparaitre la couleur associé au ménage
							Couleur_option(i);//on relance la fonction si la couleur change
							listeMarker[i][1]++;//index augmente car cette option est affiché
							closure(listeMarker[i][0],listeMarker[i][1]);//si le marker a un index supérieur à 0 (normalement le cas)
						  }
						  if(lesSalaries[i][33]=="TOUT"){
							if((menu_option[2]==1 || menu_option[0]==1) && listeMarker[i][1]==0 && lesSalaries[i][56] == 1 && lesSalaries[i][29] ==0){
								menu_option[1]=1;
								Couleur_option(i);
								listeMarker[i][1]++;
								closure(listeMarker[i][0],listeMarker[i][1]);
							}
						  }
						}
					}
					else if(document.getElementById("handicap").checked && lesSalaries[i][29]==1 && !document.getElementById("voiture").checked){
					  if(lesSalaries[i][33]=="MENAGE" && lesSalaries[i][56] == 1 && listeMarker[i][1]==0){//si la famille associé au marker à une demande a pourvoir de ménage
						menu_option[0] = 1;//on veut faire réapparaitre la couleur associé au ménage
						Couleur_option(i);//on relance la fonction si la couleur change
						listeMarker[i][1]++;//index augmente car cette option est affiché
						closure(listeMarker[i][0],listeMarker[i][1]);//si le marker a un index supérieur à 0 (normalement le cas)
					  }
					  if(lesSalaries[i][33]=="TOUT"){
						if((menu_option[2]==1 || menu_option[0]==1) && listeMarker[i][1]==0 && lesSalaries[i][56] == 1){
							menu_option[1]=1;
							Couleur_option(i);
							listeMarker[i][1]++;
							closure(listeMarker[i][0],listeMarker[i][1]);
						}
					  }
					}
				}
				else if(document.getElementById("handicap").checked && lesSalaries[i][29]==1 && !document.getElementById("GE_moins_3ans").checked){
					if(document.getElementById("voiture").checked && lesSalaries[i][23]==1){
						if(lesSalaries[i][33]=="MENAGE" && lesSalaries[i][56] == 1 && listeMarker[i][1]==0){//si la famille associé au marker à une demande a pourvoir de ménage
							menu_option[0] = 1;//on veut faire réapparaitre la couleur associé au ménage
							Couleur_option(i);//on relance la fonction si la couleur change
							listeMarker[i][1]++;//index augmente car cette option est affiché
							closure(listeMarker[i][0],listeMarker[i][1]);//si le marker a un index supérieur à 0 (normalement le cas)
						  }
						  if(lesSalaries[i][33]=="TOUT"){
							if((menu_option[2]==1 || menu_option[0]==1) && listeMarker[i][1]==0 && lesSalaries[i][56] == 1){
								menu_option[1]=1;
								Couleur_option(i);
								listeMarker[i][1]++;
								closure(listeMarker[i][0],listeMarker[i][1]);
							}
						  }
					}
					else if(!document.getElementById("voiture").checked){
						if(lesSalaries[i][33]=="MENAGE" && lesSalaries[i][56] == 1 && listeMarker[i][1]==0){//si la famille associé au marker à une demande a pourvoir de ménage
							menu_option[0] = 1;//on veut faire réapparaitre la couleur associé au ménage
							Couleur_option(i);//on relance la fonction si la couleur change
							listeMarker[i][1]++;//index augmente car cette option est affiché
							closure(listeMarker[i][0],listeMarker[i][1]);//si le marker a un index supérieur à 0 (normalement le cas)
						  }
						  if(lesSalaries[i][33]=="TOUT" && lesSalaries[i][23]==0){
							if((menu_option[2]==1 || menu_option[0]==1) && listeMarker[i][1]==0 && lesSalaries[i][56] == 1){
								menu_option[1]=1;
								Couleur_option(i);
								listeMarker[i][1]++;
								closure(listeMarker[i][0],listeMarker[i][1]);
							}
						  }
					}
				}
				else if(document.getElementById("voiture").checked && lesSalaries[i][23]==1 && !document.getElementById("handicap").checked && !document.getElementById("GE_moins_3ans").checked){
					if(lesSalaries[i][33]=="MENAGE" && lesSalaries[i][56] == 1 && listeMarker[i][1]==0){//si la famille associé au marker à une demande a pourvoir de ménage
							menu_option[0] = 1;//on veut faire réapparaitre la couleur associé au ménage
							Couleur_option(i);//on relance la fonction si la couleur change
							listeMarker[i][1]++;//index augmente car cette option est affiché
							closure(listeMarker[i][0],listeMarker[i][1]);//si le marker a un index supérieur à 0 (normalement le cas)
					}
					if(lesSalaries[i][33]=="TOUT"){
						if((menu_option[2]==1 || menu_option[0]==1) && listeMarker[i][1]==0 && lesSalaries[i][56] == 1){
							menu_option[1]=1;
							Couleur_option(i);
							listeMarker[i][1]++;
							closure(listeMarker[i][0],listeMarker[i][1]);
						}
					}
				}
				else if(document.getElementById("GE_moins_3ans").checked && lesSalaries[i][28]==1 && !document.getElementById("handicap").checked && !document.getElementById("voiture").checked){
					if(lesSalaries[i][33]=="MENAGE" && lesSalaries[i][56] == 1 && listeMarker[i][1]==0){//si la famille associé au marker à une demande a pourvoir de ménage
							menu_option[0] = 1;//on veut faire réapparaitre la couleur associé au ménage
							Couleur_option(i);//on relance la fonction si la couleur change
							listeMarker[i][1]++;//index augmente car cette option est affiché
							closure(listeMarker[i][0],listeMarker[i][1]);//si le marker a un index supérieur à 0 (normalement le cas)
					}
					if(lesSalaries[i][33]=="TOUT"){
						if((menu_option[2]==1 || menu_option[0]==1) && listeMarker[i][1]==0 && lesSalaries[i][56] == 1){
							menu_option[1]=1;
							Couleur_option(i);
							listeMarker[i][1]++;
							closure(listeMarker[i][0],listeMarker[i][1]);
						}
					}
				}
				else if(!document.getElementById("GE_moins_3ans").checked && !document.getElementById("voiture").checked && !document.getElementById("handicap").checked){
					if(lesSalaries[i][33]=="MENAGE" && lesSalaries[i][56] == 1 && listeMarker[i][1]==0){//si la famille associé au marker à une demande a pourvoir de ménage
							menu_option[0] = 1;//on veut faire réapparaitre la couleur associé au ménage
							Couleur_option(i);//on relance la fonction si la couleur change
							listeMarker[i][1]++;//index augmente car cette option est affiché
							closure(listeMarker[i][0],listeMarker[i][1]);//si le marker a un index supérieur à 0 (normalement le cas)
					}
					if(lesSalaries[i][33]=="TOUT"){
						if((menu_option[2]==1 || menu_option[0]==1) && listeMarker[i][1]==0 && lesSalaries[i][56] == 1){
							menu_option[1]=1;
							Couleur_option(i);
							listeMarker[i][1]++;
							closure(listeMarker[i][0],listeMarker[i][1]);
						}
					}
				}
			}
			if (document.getElementById("non_place").checked){
				if(document.getElementById("GE_moins_3ans").checked && lesSalaries[i][28]==1){
					if(document.getElementById("voiture").checked && lesSalaries[i][23]==1){
						if(document.getElementById("handicap").checked && lesSalaries[i][29]==1){
						  if(lesSalaries[i][33]=="MENAGE" && lesSalaries[i][56] == 0 && listeMarker[i][1]==0){//si la famille associé au marker à une demande a pourvoir de ménage
							menu_option[0] = 1;//on veut faire réapparaitre la couleur associé au ménage
							Couleur_option(i);//on relance la fonction si la couleur change
							listeMarker[i][1]++;//index augmente car cette option est affiché
							closure(listeMarker[i][0],listeMarker[i][1]);//si le marker a un index supérieur à 0 (normalement le cas)
						  }
						  if(lesSalaries[i][33]=="TOUT"){
							if((menu_option[2]==1 || menu_option[0]==1) && listeMarker[i][1]==0 && lesSalaries[i][56] == 0){
								menu_option[1]=1;
								Couleur_option(i);
								listeMarker[i][1]++;
								closure(listeMarker[i][0],listeMarker[i][1]);
							}
						  }
						}
						else if(!document.getElementById("handicap").checked){
						  if(lesSalaries[i][33]=="MENAGE" && lesSalaries[i][56] == 0 && listeMarker[i][1]==0){//si la famille associé au marker à une demande a pourvoir de ménage
							menu_option[0] = 1;//on veut faire réapparaitre la couleur associé au ménage
							Couleur_option(i);//on relance la fonction si la couleur change
							listeMarker[i][1]++;//index augmente car cette option est affiché
							closure(listeMarker[i][0],listeMarker[i][1]);//si le marker a un index supérieur à 0 (normalement le cas)
						  }
						  if(lesSalaries[i][33]=="TOUT"){
							if((menu_option[2]==1 || menu_option[0]==1) && listeMarker[i][1]==0 && lesSalaries[i][56] == 0 && lesSalaries[i][29] ==0){
								menu_option[1]=1;
								Couleur_option(i);
								listeMarker[i][1]++;
								closure(listeMarker[i][0],listeMarker[i][1]);
							}
						  }
						}
					}
					else if(document.getElementById("handicap").checked && lesSalaries[i][29]==1 && !document.getElementById("voiture").checked){
					  if(lesSalaries[i][33]=="MENAGE" && lesSalaries[i][56] == 0 && listeMarker[i][1]==0){//si la famille associé au marker à une demande a pourvoir de ménage
						menu_option[0] = 1;//on veut faire réapparaitre la couleur associé au ménage
						Couleur_option(i);//on relance la fonction si la couleur change
						listeMarker[i][1]++;//index augmente car cette option est affiché
						closure(listeMarker[i][0],listeMarker[i][1]);//si le marker a un index supérieur à 0 (normalement le cas)
					  }
					  if(lesSalaries[i][33]=="TOUT"){
						if((menu_option[2]==1 || menu_option[0]==1) && listeMarker[i][1]==0 && lesSalaries[i][56] == 0){
							menu_option[1]=1;
							Couleur_option(i);
							listeMarker[i][1]++;
							closure(listeMarker[i][0],listeMarker[i][1]);
						}
					  }
					}
				}
				else if(document.getElementById("handicap").checked && lesSalaries[i][29]==1 && !document.getElementById("GE_moins_3ans").checked){
					if(document.getElementById("voiture").checked && lesSalaries[i][23]==1){
						if(lesSalaries[i][33]=="MENAGE" && lesSalaries[i][56] == 0 && listeMarker[i][1]==0){//si la famille associé au marker à une demande a pourvoir de ménage
							menu_option[0] = 1;//on veut faire réapparaitre la couleur associé au ménage
							Couleur_option(i);//on relance la fonction si la couleur change
							listeMarker[i][1]++;//index augmente car cette option est affiché
							closure(listeMarker[i][0],listeMarker[i][1]);//si le marker a un index supérieur à 0 (normalement le cas)
						  }
						  if(lesSalaries[i][33]=="TOUT"){
							if((menu_option[2]==1 || menu_option[0]==1) && listeMarker[i][1]==0 && lesSalaries[i][56] == 0){
								menu_option[1]=1;
								Couleur_option(i);
								listeMarker[i][1]++;
								closure(listeMarker[i][0],listeMarker[i][1]);
							}
						  }
					}
					else if(!document.getElementById("voiture").checked){
						if(lesSalaries[i][33]=="MENAGE" && lesSalaries[i][56] == 0 && listeMarker[i][1]==0){//si la famille associé au marker à une demande a pourvoir de ménage
							menu_option[0] = 1;//on veut faire réapparaitre la couleur associé au ménage
							Couleur_option(i);//on relance la fonction si la couleur change
							listeMarker[i][1]++;//index augmente car cette option est affiché
							closure(listeMarker[i][0],listeMarker[i][1]);//si le marker a un index supérieur à 0 (normalement le cas)
						  }
						  if(lesSalaries[i][33]=="TOUT"){
							if((menu_option[2]==1 || menu_option[0]==1) && listeMarker[i][1]==0 && lesSalaries[i][56] == 0){
								menu_option[1]=1;
								Couleur_option(i);
								listeMarker[i][1]++;
								closure(listeMarker[i][0],listeMarker[i][1]);
							}
						  }
					}
				}
				else if(document.getElementById("voiture").checked && lesSalaries[i][23]==1 && !document.getElementById("handicap").checked && !document.getElementById("GE_moins_3ans").checked){
					if(lesSalaries[i][33]=="MENAGE" && lesSalaries[i][56] == 0 && listeMarker[i][1]==0){//si la famille associé au marker à une demande a pourvoir de ménage
							menu_option[0] = 1;//on veut faire réapparaitre la couleur associé au ménage
							Couleur_option(i);//on relance la fonction si la couleur change
							listeMarker[i][1]++;//index augmente car cette option est affiché
							closure(listeMarker[i][0],listeMarker[i][1]);//si le marker a un index supérieur à 0 (normalement le cas)
					}
					if(lesSalaries[i][33]=="TOUT"){
						if((menu_option[2]==1 || menu_option[0]==1) && listeMarker[i][1]==0 && lesSalaries[i][56] == 0){
							menu_option[1]=1;
							Couleur_option(i);
							listeMarker[i][1]++;
							closure(listeMarker[i][0],listeMarker[i][1]);
						}
					}
				}
				else if(document.getElementById("GE_moins_3ans").checked && lesSalaries[i][28]==1 && !document.getElementById("handicap").checked && !document.getElementById("voiture").checked){
					if(lesSalaries[i][33]=="MENAGE" && lesSalaries[i][56] == 0 && listeMarker[i][1]==0){
							menu_option[0] = 1;//on veut faire réapparaitre la couleur associé au ménage
							Couleur_option(i);//on relance la fonction si la couleur change
							listeMarker[i][1]++;//index augmente car cette option est affiché
							closure(listeMarker[i][0],listeMarker[i][1]);//si le marker a un index supérieur à 0 (normalement le cas)
					}
					if(lesSalaries[i][33]=="TOUT"){
						if((menu_option[2]==1 || menu_option[0]==1) && listeMarker[i][1]==0 && lesSalaries[i][56] == 0){
							menu_option[1]=1;
							Couleur_option(i);
							listeMarker[i][1]++;
							closure(listeMarker[i][0],listeMarker[i][1]);
						}
					}
				}
				else if(!document.getElementById("GE_moins_3ans").checked && !document.getElementById("voiture").checked && !document.getElementById("handicap").checked){
					if(lesSalaries[i][33]=="MENAGE" && lesSalaries[i][56] == 0 && listeMarker[i][1]==0){
							menu_option[0] = 1;//on veut faire réapparaitre la couleur associé au ménage
							Couleur_option(i);//on relance la fonction si la couleur change
							listeMarker[i][1]++;//index augmente car cette option est affiché
							closure(listeMarker[i][0],listeMarker[i][1]);//si le marker a un index supérieur à 0 (normalement le cas)
					}
					if(lesSalaries[i][33]=="TOUT"){
						if((menu_option[2]==1 || menu_option[0]==1) && listeMarker[i][1]==0 && lesSalaries[i][56] == 0){
							menu_option[1]=1;
							Couleur_option(i);
							listeMarker[i][1]++;
							closure(listeMarker[i][0],listeMarker[i][1]);
						}
					}
				}
			}
		}
		console.log(listeMarker[i]);
      }
      count_Intervenant();//relance le test du nombre de famille
      break;
    case "ge_menage":
      if (!document.getElementById(type_marker).checked){//si la case n'est pas coché
        $('input[class="ge_menage"]').each(function() { //jQuery récupère chaque html bloc de type input et class "garde_enfant"
          if(this.checked){//si le type input est checké permettant de ne pas refaire exécuter le code
			  	this.checked = false;//décoché le type input
          this.onchange();//declenche le changement de position du type input
          }
        });
      }
      else{//de même avec un check si le type input n'est pas coché
        $('input[class="ge_menage"]').each(function() { 
          if(!this.checked){
			  	this.checked = true;
          this.onchange();
          }
        });
		}
      count_Intervenant();
      break;
    case "garde_enfant"://de meme que ménage
      for(let i = 0; i < listeMarker.length; i++)
      {
        if (!document.getElementById(type_marker).checked)
        {
          if(lesSalaries[i][33] == "ENFANT" && listeMarker[i][1]==1){
            menu_option[2] = 0;
            Couleur_option(i);
            listeMarker[i][1]--;
            closure(listeMarker[i][0],listeMarker[i][1]);
          }
		  if(lesSalaries[i][33]=="TOUT"){
			if(menu_option[2]==0 && menu_option[0]==0 && listeMarker[i][1]==1){
				menu_option[1]=0;
				Couleur_option(i);
				listeMarker[i][1]--;
				closure(listeMarker[i][0],listeMarker[i][1]);
			}
		  }
        }
        else
        {
			if(document.getElementById("place").checked){
			  if(document.getElementById("GE_moins_3ans").checked && lesSalaries[i][28]==1){
					if(document.getElementById("voiture").checked && lesSalaries[i][23]==1){
						if(document.getElementById("handicap").checked && lesSalaries[i][29]==1){
						  if(lesSalaries[i][33]=="ENFANT" && lesSalaries[i][56] == 1 && listeMarker[i][1]==0){//si la famille associé au marker à une demande a pourvoir de ménage
							menu_option[2] = 1;//on veut faire réapparaitre la couleur associé au ménage
							Couleur_option(i);//on relance la fonction si la couleur change
							listeMarker[i][1]++;//index augmente car cette option est affiché
							closure(listeMarker[i][0],listeMarker[i][1]);//si le marker a un index supérieur à 0 (normalement le cas)
						  }
						  if(lesSalaries[i][33]=="TOUT"){
							if((menu_option[2]==1 || menu_option[0]==1) && listeMarker[i][1]==0 && lesSalaries[i][56] == 1){
								menu_option[1]=1;
								Couleur_option(i);
								listeMarker[i][1]++;
								closure(listeMarker[i][0],listeMarker[i][1]);
							}
						  }
						}
						else if(!document.getElementById("handicap").checked){
						  if(lesSalaries[i][33]=="ENFANT" && lesSalaries[i][56] == 1 && listeMarker[i][1]==0){//si la famille associé au marker à une demande a pourvoir de ménage
							menu_option[2] = 1;//on veut faire réapparaitre la couleur associé au ménage
							Couleur_option(i);//on relance la fonction si la couleur change
							listeMarker[i][1]++;//index augmente car cette option est affiché
							closure(listeMarker[i][0],listeMarker[i][1]);//si le marker a un index supérieur à 0 (normalement le cas)
						  }
						  if(lesSalaries[i][33]=="TOUT"){
							if((menu_option[2]==1 || menu_option[0]==1) && listeMarker[i][1]==0 && lesSalaries[i][56] == 1 && lesSalaries[i][29] ==0){
								menu_option[1]=1;
								Couleur_option(i);
								listeMarker[i][1]++;
								closure(listeMarker[i][0],listeMarker[i][1]);
							}
						  }
						}
					}
					else if(document.getElementById("handicap").checked && lesSalaries[i][29]==1 && !document.getElementById("voiture").checked){
					  if(lesSalaries[i][33]=="ENFANT" && lesSalaries[i][56] == 1 && listeMarker[i][1]==0){//si la famille associé au marker à une demande a pourvoir de ménage
						menu_option[2] = 1;//on veut faire réapparaitre la couleur associé au ménage
						Couleur_option(i);//on relance la fonction si la couleur change
						listeMarker[i][1]++;//index augmente car cette option est affiché
						closure(listeMarker[i][0],listeMarker[i][1]);//si le marker a un index supérieur à 0 (normalement le cas)
					  }
					  if(lesSalaries[i][33]=="TOUT"){
						if((menu_option[2]==1 || menu_option[0]==1) && listeMarker[i][1]==0 && lesSalaries[i][56] == 1){
							menu_option[1]=1;
							Couleur_option(i);
							listeMarker[i][1]++;
							closure(listeMarker[i][0],listeMarker[i][1]);
						}
					  }
					}
				}
				else if(document.getElementById("handicap").checked && lesSalaries[i][29]==1 && !document.getElementById("GE_moins_3ans").checked){
					if(document.getElementById("voiture").checked && lesSalaries[i][23]==1){
						if(lesSalaries[i][33]=="ENFANT" && lesSalaries[i][56] == 1 && listeMarker[i][1]==0){//si la famille associé au marker à une demande a pourvoir de ménage
							menu_option[2] = 1;//on veut faire réapparaitre la couleur associé au ménage
							Couleur_option(i);//on relance la fonction si la couleur change
							listeMarker[i][1]++;//index augmente car cette option est affiché
							closure(listeMarker[i][0],listeMarker[i][1]);//si le marker a un index supérieur à 0 (normalement le cas)
						  }
						  if(lesSalaries[i][33]=="TOUT"){
							if((menu_option[2]==1 || menu_option[0]==1) && listeMarker[i][1]==0 && lesSalaries[i][56] == 1){
								menu_option[1]=1;
								Couleur_option(i);
								listeMarker[i][1]++;
								closure(listeMarker[i][0],listeMarker[i][1]);
							}
						  }
					}
					else if(!document.getElementById("voiture").checked){
						if(lesSalaries[i][33]=="ENFANT" && lesSalaries[i][56] == 1 && listeMarker[i][1]==0){//si la famille associé au marker à une demande a pourvoir de ménage
							menu_option[2] = 1;//on veut faire réapparaitre la couleur associé au ménage
							Couleur_option(i);//on relance la fonction si la couleur change
							listeMarker[i][1]++;//index augmente car cette option est affiché
							closure(listeMarker[i][0],listeMarker[i][1]);//si le marker a un index supérieur à 0 (normalement le cas)
						  }
						  if(lesSalaries[i][33]=="TOUT" && lesSalaries[i][23]==0){
							if((menu_option[2]==1 || menu_option[0]==1) && listeMarker[i][1]==0 && lesSalaries[i][56] == 1){
								menu_option[1]=1;
								Couleur_option(i);
								listeMarker[i][1]++;
								closure(listeMarker[i][0],listeMarker[i][1]);
							}
						  }
					}
				}
				else if(document.getElementById("voiture").checked && lesSalaries[i][23]==1 && !document.getElementById("handicap").checked && !document.getElementById("GE_moins_3ans").checked){
					if(lesSalaries[i][33]=="ENFANT" && lesSalaries[i][56] == 1 && listeMarker[i][1]==0){//si la famille associé au marker à une demande a pourvoir de ménage
							menu_option[2] = 1;//on veut faire réapparaitre la couleur associé au ménage
							Couleur_option(i);//on relance la fonction si la couleur change
							listeMarker[i][1]++;//index augmente car cette option est affiché
							closure(listeMarker[i][0],listeMarker[i][1]);//si le marker a un index supérieur à 0 (normalement le cas)
					}
					if(lesSalaries[i][33]=="TOUT"){
						if((menu_option[2]==1 || menu_option[0]==1) && listeMarker[i][1]==0 && lesSalaries[i][56] == 1){
							menu_option[1]=1;
							Couleur_option(i);
							listeMarker[i][1]++;
							closure(listeMarker[i][0],listeMarker[i][1]);
						}
					}
				}
				else if(document.getElementById("GE_moins_3ans").checked && lesSalaries[i][28]==1 && !document.getElementById("handicap").checked && !document.getElementById("voiture").checked){
					if(lesSalaries[i][33]=="ENFANT" && lesSalaries[i][56] == 1 && listeMarker[i][1]==0){//si la famille associé au marker à une demande a pourvoir de ménage
							menu_option[2] = 1;//on veut faire réapparaitre la couleur associé au ménage
							Couleur_option(i);//on relance la fonction si la couleur change
							listeMarker[i][1]++;//index augmente car cette option est affiché
							closure(listeMarker[i][0],listeMarker[i][1]);//si le marker a un index supérieur à 0 (normalement le cas)
					}
					if(lesSalaries[i][33]=="TOUT"){
						if((menu_option[2]==1 || menu_option[0]==1) && listeMarker[i][1]==0 && lesSalaries[i][56] == 1){
							menu_option[1]=1;
							Couleur_option(i);
							listeMarker[i][1]++;
							closure(listeMarker[i][0],listeMarker[i][1]);
						}
					}
				}
				else if(!document.getElementById("GE_moins_3ans").checked && !document.getElementById("voiture").checked && !document.getElementById("handicap").checked){
					if(lesSalaries[i][33]=="ENFANT" && lesSalaries[i][56] == 1 && listeMarker[i][1]==0){//si la famille associé au marker à une demande a pourvoir de ménage
							menu_option[2] = 1;//on veut faire réapparaitre la couleur associé au ménage
							Couleur_option(i);//on relance la fonction si la couleur change
							listeMarker[i][1]++;//index augmente car cette option est affiché
							closure(listeMarker[i][0],listeMarker[i][1]);//si le marker a un index supérieur à 0 (normalement le cas)
					}
					if(lesSalaries[i][33]=="TOUT"){
						if((menu_option[2]==1 || menu_option[0]==1) && listeMarker[i][1]==0 && lesSalaries[i][56] == 1){
							menu_option[1]=1;
							Couleur_option(i);
							listeMarker[i][1]++;
							closure(listeMarker[i][0],listeMarker[i][1]);
						}
					}
				}
			}
			if (document.getElementById("non_place").checked){
				if(document.getElementById("GE_moins_3ans").checked && lesSalaries[i][28]==1){
					if(document.getElementById("voiture").checked && lesSalaries[i][23]==1){
						if(document.getElementById("handicap").checked && lesSalaries[i][29]==1){
						  if(lesSalaries[i][33]=="ENFANT" && lesSalaries[i][56] == 0 && listeMarker[i][1]==0){//si la famille associé au marker à une demande a pourvoir de ménage
							menu_option[2] = 1;//on veut faire réapparaitre la couleur associé au ménage
							Couleur_option(i);//on relance la fonction si la couleur change
							listeMarker[i][1]++;//index augmente car cette option est affiché
							closure(listeMarker[i][0],listeMarker[i][1]);//si le marker a un index supérieur à 0 (normalement le cas)
						  }
						  if(lesSalaries[i][33]=="TOUT"){
							if((menu_option[2]==1 || menu_option[0]==1) && listeMarker[i][1]==0 && lesSalaries[i][56] == 0){
								menu_option[1]=1;
								Couleur_option(i);
								listeMarker[i][1]++;
								closure(listeMarker[i][0],listeMarker[i][1]);
							}
						  }
						}
						else if(!document.getElementById("handicap").checked){
						  if(lesSalaries[i][33]=="ENFANT" && lesSalaries[i][56] == 0 && listeMarker[i][1]==0){//si la famille associé au marker à une demande a pourvoir de ménage
							menu_option[2] = 1;//on veut faire réapparaitre la couleur associé au ménage
							Couleur_option(i);//on relance la fonction si la couleur change
							listeMarker[i][1]++;//index augmente car cette option est affiché
							closure(listeMarker[i][0],listeMarker[i][1]);//si le marker a un index supérieur à 0 (normalement le cas)
						  }
						  if(lesSalaries[i][33]=="TOUT"){
							if((menu_option[2]==1 || menu_option[0]==1) && listeMarker[i][1]==0 && lesSalaries[i][56] == 0 && lesSalaries[i][29] ==0){
								menu_option[1]=1;
								Couleur_option(i);
								listeMarker[i][1]++;
								closure(listeMarker[i][0],listeMarker[i][1]);
							}
						  }
						}
					}
					else if(document.getElementById("handicap").checked && lesSalaries[i][29]==1 && !document.getElementById("voiture").checked){
					  if(lesSalaries[i][33]=="ENFANT" && lesSalaries[i][56] == 0 && listeMarker[i][1]==0){//si la famille associé au marker à une demande a pourvoir de ménage
						menu_option[2] = 1;//on veut faire réapparaitre la couleur associé au ménage
						Couleur_option(i);//on relance la fonction si la couleur change
						listeMarker[i][1]++;//index augmente car cette option est affiché
						closure(listeMarker[i][0],listeMarker[i][1]);//si le marker a un index supérieur à 0 (normalement le cas)
					  }
					  if(lesSalaries[i][33]=="TOUT"){
						if((menu_option[2]==1 || menu_option[0]==1) && listeMarker[i][1]==0 && lesSalaries[i][56] == 0){
							menu_option[1]=1;
							Couleur_option(i);
							listeMarker[i][1]++;
							closure(listeMarker[i][0],listeMarker[i][1]);
						}
					  }
					}
				}
				else if(document.getElementById("handicap").checked && lesSalaries[i][29]==1 && !document.getElementById("GE_moins_3ans").checked){
					if(document.getElementById("voiture").checked && lesSalaries[i][23]==1){
						if(lesSalaries[i][33]=="ENFANT" && lesSalaries[i][56] == 0 && listeMarker[i][1]==0){//si la famille associé au marker à une demande a pourvoir de ménage
							menu_option[2] = 1;//on veut faire réapparaitre la couleur associé au ménage
							Couleur_option(i);//on relance la fonction si la couleur change
							listeMarker[i][1]++;//index augmente car cette option est affiché
							closure(listeMarker[i][0],listeMarker[i][1]);//si le marker a un index supérieur à 0 (normalement le cas)
						  }
						  if(lesSalaries[i][33]=="TOUT"){
							if((menu_option[2]==1 || menu_option[0]==1) && listeMarker[i][1]==0 && lesSalaries[i][56] == 0){
								menu_option[1]=1;
								Couleur_option(i);
								listeMarker[i][1]++;
								closure(listeMarker[i][0],listeMarker[i][1]);
							}
						  }
					}
					else if(!document.getElementById("voiture").checked){
						if(lesSalaries[i][33]=="ENFANT" && lesSalaries[i][56] == 0 && listeMarker[i][1]==0){//si la famille associé au marker à une demande a pourvoir de ménage
							menu_option[2] = 1;//on veut faire réapparaitre la couleur associé au ménage
							Couleur_option(i);//on relance la fonction si la couleur change
							listeMarker[i][1]++;//index augmente car cette option est affiché
							closure(listeMarker[i][0],listeMarker[i][1]);//si le marker a un index supérieur à 0 (normalement le cas)
						  }
						  if(lesSalaries[i][33]=="TOUT"){
							if((menu_option[2]==1 || menu_option[0]==1) && listeMarker[i][1]==0 && lesSalaries[i][56] == 0){
								menu_option[1]=1;
								Couleur_option(i);
								listeMarker[i][1]++;
								closure(listeMarker[i][0],listeMarker[i][1]);
							}
						  }
					}
				}
				else if(document.getElementById("voiture").checked && lesSalaries[i][23]==1 && !document.getElementById("handicap").checked && !document.getElementById("GE_moins_3ans").checked){
					if(lesSalaries[i][33]=="ENFANT" && lesSalaries[i][56] == 0 && listeMarker[i][1]==0){//si la famille associé au marker à une demande a pourvoir de ménage
							menu_option[2] = 1;//on veut faire réapparaitre la couleur associé au ménage
							Couleur_option(i);//on relance la fonction si la couleur change
							listeMarker[i][1]++;//index augmente car cette option est affiché
							closure(listeMarker[i][0],listeMarker[i][1]);//si le marker a un index supérieur à 0 (normalement le cas)
					}
					if(lesSalaries[i][33]=="TOUT"){
						if((menu_option[2]==1 || menu_option[0]==1) && listeMarker[i][1]==0 && lesSalaries[i][56] == 0){
							menu_option[1]=1;
							Couleur_option(i);
							listeMarker[i][1]++;
							closure(listeMarker[i][0],listeMarker[i][1]);
						}
					}
				}
				else if(document.getElementById("GE_moins_3ans").checked && lesSalaries[i][28]==1 && !document.getElementById("handicap").checked && !document.getElementById("voiture").checked){
					if(lesSalaries[i][33]=="ENFANT" && lesSalaries[i][56] == 0 && listeMarker[i][1]==0){//si la famille associé au marker à une demande a pourvoir de ménage
							menu_option[2] = 1;//on veut faire réapparaitre la couleur associé au ménage
							Couleur_option(i);//on relance la fonction si la couleur change
							listeMarker[i][1]++;//index augmente car cette option est affiché
							closure(listeMarker[i][0],listeMarker[i][1]);//si le marker a un index supérieur à 0 (normalement le cas)
					}
					if(lesSalaries[i][33]=="TOUT"){
						if((menu_option[2]==1 || menu_option[0]==1) && listeMarker[i][1]==0 && lesSalaries[i][56] == 0){
							menu_option[1]=1;
							Couleur_option(i);
							listeMarker[i][1]++;
							closure(listeMarker[i][0],listeMarker[i][1]);
						}
					}
				}
				else if(!document.getElementById("GE_moins_3ans").checked && !document.getElementById("voiture").checked && !document.getElementById("handicap").checked){
					if(lesSalaries[i][33]=="ENFANT" && lesSalaries[i][56] == 0 && listeMarker[i][1]==0){//si la famille associé au marker à une demande a pourvoir de ménage
							menu_option[2] = 1;//on veut faire réapparaitre la couleur associé au ménage
							Couleur_option(i);//on relance la fonction si la couleur change
							listeMarker[i][1]++;//index augmente car cette option est affiché
							closure(listeMarker[i][0],listeMarker[i][1]);//si le marker a un index supérieur à 0 (normalement le cas)
					}
					if(lesSalaries[i][33]=="TOUT"){
						if((menu_option[2]==1 || menu_option[0]==1) && listeMarker[i][1]==0 && lesSalaries[i][56] == 0){
							menu_option[1]=1;
							Couleur_option(i);
							listeMarker[i][1]++;
							closure(listeMarker[i][0],listeMarker[i][1]);
						}
					}
				}
			}
        }
		console.log(listeMarker[i]);
	  }
      count_Intervenant();
      break;
	case "place":
		for(let i = 0; i < listeMarker.length; i++)//boucle pour le nombre de marker
		{
			if (!document.getElementById(type_marker).checked){
				if(lesSalaries[i][56] == 1 && listeMarker[i][1]==1 && (menu_option[1]==1 || menu_option[2]==1)){
					Couleur_option(i);
					listeMarker[i][1]--;
					closure(listeMarker[i][0],listeMarker[i][1]);
				  }
			}
			else{
				if(lesSalaries[i][56] == 1 && listeMarker[i][1]==0 && (menu_option[1]==1 || menu_option[2]==1)){
					Couleur_option(i);
					listeMarker[i][1]++;
					closure(listeMarker[i][0],listeMarker[i][1]);
				  }
			}
		}
		count_Intervenant();
		break;
	case "non_place":
		for(let i = 0; i < listeMarker.length; i++)//boucle pour le nombre de marker
		{
			if (!document.getElementById(type_marker).checked){
				if(lesSalaries[i][56] == 0 && listeMarker[i][1]==1 && (menu_option[1]==1 || menu_option[2]==1)){
					Couleur_option(i);
					listeMarker[i][1]--;
					closure(listeMarker[i][0],listeMarker[i][1]);
				  }
			}
			else{
				if(lesSalaries[i][56] == 0 && listeMarker[i][1]==0 && (menu_option[1]==1 || menu_option[2]==1)){
					Couleur_option(i);
					listeMarker[i][1]++;
					closure(listeMarker[i][0],listeMarker[i][1]);
				  }
			}
		}
		count_Intervenant();
		break;
	case "GE_moins_3ans":
		for(let i = 0; i < listeMarker.length; i++)//boucle pour le nombre de marker
		{
			if (!document.getElementById(type_marker).checked){
				if(document.getElementById("handicap").checked && lesSalaries[i][29] == 1){
					if(document.getElementById("voiture").checked && lesSalaries[i][23] == 1){
						if(lesSalaries[i][28]==0 && listeMarker[i][1]==0 && (menu_option[1]==1 || menu_option[2]==1)){
							Couleur_option(i);
							listeMarker[i][1]++;
							closure(listeMarker[i][0],listeMarker[i][1]);
						  }
					}
					else if(!document.getElementById("voiture").checked){
						if(lesSalaries[i][28]==0 && listeMarker[i][1]==0 && (menu_option[1]==1 || menu_option[2]==1)){
							Couleur_option(i);
							listeMarker[i][1]++;
							closure(listeMarker[i][0],listeMarker[i][1]);
						  }
					}
					
				}
				else if(!document.getElementById("handicap").checked && document.getElementById("voiture").checked && lesSalaries[i][23] == 1){
					if(lesSalaries[i][28]==0 && listeMarker[i][1]==0 && (menu_option[1]==1 || menu_option[2]==1)){
							Couleur_option(i);
							listeMarker[i][1]++;
							closure(listeMarker[i][0],listeMarker[i][1]);
						  }
				}
				else if(!document.getElementById("handicap").checked && !document.getElementById("voiture").checked){
					if(lesSalaries[i][28]==0 && listeMarker[i][1]==0 && (menu_option[1]==1 || menu_option[2]==1)){
							Couleur_option(i);
							listeMarker[i][1]++;
							closure(listeMarker[i][0],listeMarker[i][1]);
						  }
				}
			}
			else{
				if(document.getElementById("handicap").checked && lesSalaries[i][29] == 1){
					if(document.getElementById("voiture").checked && lesSalaries[i][23] == 1){
						if(lesSalaries[i][28]==0 && listeMarker[i][1]==1 && (menu_option[1]==1 || menu_option[2]==1)){
							Couleur_option(i);
							listeMarker[i][1]--;
							closure(listeMarker[i][0],listeMarker[i][1]);
						  }
					}
					else if(!document.getElementById("voiture").checked && lesSalaries[i][23] == 1){
						if(lesSalaries[i][28]==0 && listeMarker[i][1]==1 && (menu_option[1]==1 || menu_option[2]==1)){
							Couleur_option(i);
							listeMarker[i][1]--;
							closure(listeMarker[i][0],listeMarker[i][1]);
						  }
					}
				}
				else if(document.getElementById("voiture").checked && lesSalaries[i][23] == 1){
					if(lesSalaries[i][28]==0 && listeMarker[i][1]==1 && (menu_option[1]==1 || menu_option[2]==1)){
							Couleur_option(i);
							listeMarker[i][1]--;
							closure(listeMarker[i][0],listeMarker[i][1]);
						  }
				}
				else if(!document.getElementById("handicap").checked && !document.getElementById("voiture").checked){
					if(lesSalaries[i][28]==0 && listeMarker[i][1]==1 && (menu_option[1]==1 || menu_option[2]==1)){
							Couleur_option(i);
							listeMarker[i][1]--;
							closure(listeMarker[i][0],listeMarker[i][1]);
						  }	  
				}
			}
		}
		count_Intervenant();
		break;
	
	case "voiture":
		for(let i = 0; i < listeMarker.length; i++)//boucle pour le nombre de marker
		{
			if (!document.getElementById(type_marker).checked){
				if(document.getElementById("handicap").checked && lesSalaries[i][29] == 1){
					if(document.getElementById("GE_moins_3ans").checked && lesSalaries[i][28] == 1){
						if(lesSalaries[i][23]==0 && listeMarker[i][1]==0 && (menu_option[1]==1 || menu_option[2]==1)){
							Couleur_option(i);
							listeMarker[i][1]++;
							closure(listeMarker[i][0],listeMarker[i][1]);
						  }
					}
					else if(!document.getElementById("GE_moins_3ans").checked){
						if(lesSalaries[i][23]==0 && listeMarker[i][1]==0 && (menu_option[1]==1 || menu_option[2]==1)){
							Couleur_option(i);
							listeMarker[i][1]++;
							closure(listeMarker[i][0],listeMarker[i][1]);
						  }
					}
				}
				else if(document.getElementById("GE_moins_3ans").checked && lesSalaries[i][28] == 1){
					if(lesSalaries[i][23]==0 && listeMarker[i][1]==0 && (menu_option[1]==1 || menu_option[2]==1)){
							Couleur_option(i);
							listeMarker[i][1]++;
							closure(listeMarker[i][0],listeMarker[i][1]);
						  }
				}
				else if(!document.getElementById("handicap").checked && !document.getElementById("GE_moins_3ans").checked){
					if(lesSalaries[i][23]==0 && listeMarker[i][1]==0 && (menu_option[1]==1 || menu_option[2]==1)){
							Couleur_option(i);
							listeMarker[i][1]++;
							closure(listeMarker[i][0],listeMarker[i][1]);
						  }
				}
			}
			else{
				if(document.getElementById("GE_moins_3ans").checked && lesSalaries[i][28] == 1){
					if(document.getElementById("handicap").checked && lesSalaries[i][29] == 1){
						if(lesSalaries[i][23]==0 && listeMarker[i][1]==1 && (menu_option[1]==1 || menu_option[2]==1)){
							Couleur_option(i);
							listeMarker[i][1]--;
							closure(listeMarker[i][0],listeMarker[i][1]);
						  }
					}
					else if(!document.getElementById("handicap").checked){
						if(lesSalaries[i][23]==0 && listeMarker[i][1]==1 && (menu_option[1]==1 || menu_option[2]==1)){
							Couleur_option(i);
							listeMarker[i][1]--;
							closure(listeMarker[i][0],listeMarker[i][1]);
						  }
					}
				}
				else if(document.getElementById("handicap").checked && lesSalaries[i][29] == 1){
					if(lesSalaries[i][23]==0 && listeMarker[i][1]==1 && (menu_option[1]==1 || menu_option[2]==1)){
							Couleur_option(i);
							listeMarker[i][1]--;
							closure(listeMarker[i][0],listeMarker[i][1]);
						  }
				}
				else if (!document.getElementById("handicap").checked && !document.getElementById("handicap").checked){
					if(lesSalaries[i][23]==0 && listeMarker[i][1]==1 && (menu_option[1]==1 || menu_option[2]==1)){
							Couleur_option(i);
							listeMarker[i][1]--;
							closure(listeMarker[i][0],listeMarker[i][1]);
						  }
				}
			}
		}
		count_Intervenant();
		break;
	case "handicap":
		for(let i = 0; i < listeMarker.length; i++)//boucle pour le nombre de marker
		{
			if (!document.getElementById(type_marker).checked){
				if(document.getElementById("GE_moins_3ans").checked && lesSalaries[i][28] == 1){
					if(document.getElementById("voiture").checked && lesSalaries[i][23] == 1){
						if(lesSalaries[i][29]==0 && listeMarker[i][1]==0 && (menu_option[1]==1 || menu_option[2]==1)){
							Couleur_option(i);
							listeMarker[i][1]++;
							closure(listeMarker[i][0],listeMarker[i][1]);
						  }
					}
					else if(!document.getElementById("voiture").checked){
						if(lesSalaries[i][29]==0 && listeMarker[i][1]==0 && (menu_option[1]==1 || menu_option[2]==1)){
							Couleur_option(i);
							listeMarker[i][1]++;
							closure(listeMarker[i][0],listeMarker[i][1]);
						  }
					}
				}
				else if(document.getElementById("voiture").checked && lesSalaries[i][23] == 1 && !document.getElementById("GE_moins_3ans").checked){
					if(lesSalaries[i][29]==0 && listeMarker[i][1]==0 && (menu_option[1]==1 || menu_option[2]==1)){
							Couleur_option(i);
							listeMarker[i][1]++;
							closure(listeMarker[i][0],listeMarker[i][1]);
						  }
				}
				else if(!document.getElementById("voiture").checked && !document.getElementById("GE_moins_3ans").checked){
					if(lesSalaries[i][29]==0 && listeMarker[i][1]==0 && (menu_option[1]==1 || menu_option[2]==1)){
							Couleur_option(i);
							listeMarker[i][1]++;
							closure(listeMarker[i][0],listeMarker[i][1]);
						  }
				}
			}
			else{
				if(document.getElementById("GE_moins_3ans").checked && lesSalaries[i][28] == 1){
					if(document.getElementById("voiture").checked && lesSalaries[i][29] == 1){
						if(lesSalaries[i][29]==0 && listeMarker[i][1]==1 && (menu_option[1]==1 || menu_option[2]==1)){
							Couleur_option(i);
							listeMarker[i][1]--;
							closure(listeMarker[i][0],listeMarker[i][1]);
						  }
					}
					else if(!document.getElementById("voiture").checked){
						if(lesSalaries[i][29]==0 && listeMarker[i][1]==1 && (menu_option[1]==1 || menu_option[2]==1)){
							Couleur_option(i);
							listeMarker[i][1]--;
							closure(listeMarker[i][0],listeMarker[i][1]);
						  }
					}
				}
				else if(document.getElementById("voiture").checked && lesSalaries[i][23] == 1 && document.getElementById("GE_moins_3ans").checked){
					if(lesSalaries[i][29]==0 && listeMarker[i][1]==1 && (menu_option[1]==1 || menu_option[2]==1)){
							Couleur_option(i);
							listeMarker[i][1]--;
							closure(listeMarker[i][0],listeMarker[i][1]);
						  }
				}
				else if(!document.getElementById("voiture").checked && !document.getElementById("GE_moins_3ans").checked){
					if(lesSalaries[i][29]==0 && listeMarker[i][1]==1 && (menu_option[1]==1 || menu_option[2]==1)){
							Couleur_option(i);
							listeMarker[i][1]--;
							closure(listeMarker[i][0],listeMarker[i][1]);
						  }
				}
			}
		}
		count_Intervenant();
		break;
    case "hide_all":
      if (!document.getElementById(type_marker).checked){//si la case n'est pas coché
        $('input[name="marker"]').each(function() { //jQuery récupère chaque html bloc de type input et nom "marker"
          if(this.checked){//si le type input est checké permettant de ne pas refaire exécuter le code
			  	this.checked = false;//décoché le type input
          this.onchange();//declenche le changement de position du type input
          }
        });
      }
      else{//de même avec un check si le type input n'est pas coché
        $('input[name="marker"]').each(function() { 
          if(!this.checked){
			  	this.checked = true;
          this.onchange();
          }
        });
      }
      count_Intervenant();
      break;
  }
}
function Popup_message(i) {
  var message = "";
  if (lesSalaries[i][56] == 1) {
    message = "Placé";
  }
  else if (lesSalaries[i][56] == 0){
	  message = "Non placé";
  }
  
  // if (lesSalaries[i]["aPourvoir_PGE"]) {
    // message = message + " Prestation Garde d'enfant";
  // }
  return message;
}

function closure(marker,index){
    if(index == 0){//si l'index est égale à 0
       map.removeLayer(marker);//enlever le marker
    }
    else{
      map.addLayer(marker);//mettre le marker
    }
}

function count_Intervenant(){
  var nbr = 0;
  var p = document.getElementById("nombre_Intervenants");
  for(let j = 0; j < listeMarker.length; j++){
	  if(listeMarker[j][1]!=0){
		nbr++;
	  }
  }
  p.innerHTML = "intervenants <br>" + nbr + " RÉSULTATS";
}
console.log(listeMarker);

</script>

</body>
</html>