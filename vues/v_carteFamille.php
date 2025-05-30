<?php?>
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
  <div id="top">
	<input class="btn btn-secondary display-4 sideButton" id="gen" style="float:right;position:absolute;right:10px" type="button" value="Démarrer le générateur" onclick="myLoop();timeLoop();"><!--demarre la boucle + celle qui montre le temps restant-->
	<!--<a class="btn btn-secondary display-4 sideButton" style="float:right;position:absolute;right:10px" href="geocoder/generateur.php" target="_blank">GÉNÉRATEUR D'ADRESSE</a>-->
	<div class="deroule">
		<!--Menu déroulant-->
		<span><h2 class="revert dropdown-toggle" style="cursor:pointer;padding:10px;border-style:solid;border-width:2px;text-align:center;border-color:#4d4d4d;background-color: #f9f9f9;margin-left: 60px;">...</h2></span>
	<div class="deroule-content" style="column-count: 1;width: 300px;margin-left: 60px;">
	<!--Chaque Option du menu déroulant
	execute, lors d'une modification de son état, la function hide_show_markers-->
	<label class="container"><b>Tout cocher / décocher</b>
		<input type="checkbox" id="hide_all" onchange="hide_show_markers(this.id)" checked>
		<span class="checkmark"></span>
		</label>

	  <label class="container"><b>MENAGE</b>
		<input type="checkbox" name="marker" value="hide" id="menage" onchange="hide_show_markers(this.id)" checked>
		<span class="checkmark"></span>
		</label>

	  <label class="container"><b>GARDE ENFANTS</b>
		<input type="checkbox" name="marker" value="hide" id="garde_enfant" onchange="hide_show_markers(this.id)" checked>
		<span class="checkmark"></span>
		</label>

	  <label class="container"><b>ENFANTS DE -3 ANS</b>
		<input class="garde_enfant" type="checkbox" name="marker" value="hide" id="garde_enfant_moinsde3ans" onchange="hide_show_markers(this.id)" checked>
		<span class="checkmark"></span>
		</label>

	  <label class="container"><b>ENFANTS DE +3 ANS</b>
		<input class="garde_enfant" type="checkbox" name="marker" value="hide" id="garde_enfant_plusde3ans" onchange="hide_show_markers(this.id)" checked>
		<span class="checkmark"></span>
		</label>

	  <label class="container"><b>GARDE PARTAGÉE</b>
		<input class="garde_enfant" type="checkbox" name="marker" value="hide" id="garde_enfant_partage" onchange="hide_show_markers(this.id)" checked>
		<span class="checkmark"></span>
		</label>

	  <label class="container"><b>AUTRES</b>
		<input type="checkbox" name="marker" value="hide" id="autres" onchange="hide_show_markers(this.id)" checked>
		<span class="checkmark"></span>
		</label>

	</div>
	</div>
</div>

<div id="Time"></div>
    </h1>
    <div>
      <div id="famille" style="overflow-y: auto;width: 30%;float: left;"></div>
      <!--<div id="fichier" style="width: 50%;float: left;"></div>-->
	  <h1 style="text-align: center; width: 70%" id="nombre_Familles"></h1>
</div>


<body>
  <div class="deroule-content" style="column-count: 1;display: initial; position :fixed; right: 1% ;bottom: 2%;width: 400px;height: 270px;">

  <img src="https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-grey.png"
  alt="Marker de couleur gris" id="image">: Présence de plusieurs Prestations à pourvoir<br>


  <img src="https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png"
  alt="Marker de couleur bleu" id="image">: Famille à pourvoir Ménage<br>


  <img src="https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-violet.png"
  alt="Marker de couleur bleu" id="image">: Famille à pourvoir G.Enfants avec Options<br>


  <img src="https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-orange.png"
  alt="Marker de couleur orange" id="image">: Famille à pourvoir G.Enfants - de 3 ans<br>


  <img src="https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-yellow.png"
  alt="Marker de couleur jaune" id="image">: Famille à pourvoir G.Enfants + de 3 ans<br>


  <img src="https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png"
  alt="Marker de couleur rouge" id="image">: Famille à pourvoir G.Enfants Garde Partagée<br>


  <img src="https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-black.png"
  alt="Marker de couleur noir" id="image">: Famille à pourvoir ERRONE<br>


  <img src="https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-gold.png"
  alt="Marker de couleur or, d'une taille plus grand" style='height: 12%'>: Famille à pourvoir Prestataire<br>


  <img src="https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-gold.png"
  alt="Marker de couleur or, d'une taille plus petite" style='height: 8%'>: Famille à pourvoir Mandataire


</div>
  




<div id="map"></div>

<?php 
require_once('geocoder/localisationFamilles.php');
$coord=array();
foreach($lesFamilles as $uneFamille) {
  $num = $uneFamille["numero_Famille"];
  $Famille = $pdoChaudoudoux->obtenirDetailFamille($num);//récupère les données d'une famille
  array_push($Famille,$pdoChaudoudoux->obtenirDetailEnfants($num));//récupère les données des enfants de la famille et l'ajoute au tableau
  array_push($Famille,$pdoChaudoudoux->obtenirNomFamille($num));//récupère le nom de la famille et l'ajoute au tableau
  array_push($coord ,$Famille);//ajoute dans coord les informations de chaque famille
} ?>


<script type="text/javascript">
lesFamilles = <?php echo json_encode($coord);?>;
menu_option = [1,1,1,1];//Pour les couleurs, chaque élément du tableau représente une option du tableau
let listeMarker = new Array();
function makeMarker(){
$(document).ready(function() {//démarrage de jQuery
    var myItems;
        myItems = coord;
        for (let i = 0; i < lesFamilles.length; i++) {
          try//pour que le code ne s'arrete pas car une famille n'est pas présente dans le json
          {
            var k = myItems.findIndex(element => element["id"] == lesFamilles[i]["numero_Famille"]);//Permet de retrouver les valeurs d'une famille dans le json
            lat = myItems[k]["latitude"];
            lon = myItems[k]["longitude"];
          }
          catch(e)//Si dans le json une famille n'est pas présente, l'erreur sera renvoyé
          {
            console.log(e + "à la famille " + lesFamilles[i]["numero_Famille"]);
            lat = 0;
            lon = 0;
          }
          
          listeMarker.push([L.marker([lat, lon], {title: "Coordinates", alt: "Coordinates"}).addTo(map).on('mouseover', function() {
            listeMarker[i][0].bindPopup("M : " + lesFamilles[i]["numero_Famille"] + "<br/>" +
            "NOM : " + lesFamilles[i][1] + "<br/>" +
            Popup_message(i) + "<br/>" +
            "<a href='index.php?uc=annuFamille&action=voirDetailFamille&num=" + lesFamilles[i]["numero_Famille"] +
            "'>detail</a>").openPopup(); //Informations qui apparaissent quand la souris passe au-dessus du marker
          }),0]);//le 0 correspond à un index expliqué dans Marker_options
          listeMarker[i][0].on('click', function(){
            window.open("index.php?uc=annuFamille&action=voirDetailFamille&num=" + lesFamilles[i]["numero_Famille"]);
          });//lorsque le marker est cliqué, il ouvre la page detail de la famille correspondante
          //
          Marker_options(i);
          Couleur_option(i);
          count_Famille();
        }
});
}

var options = {
 center: [48.114059, -1.677005],
 zoom: 9
};

var map = L.map('map', options);
var nzoom = 11;
map.setView([48.074059, -1.677005],nzoom);

L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {attribution: 'OSM'}).addTo(map);


function Age_enfant(i)
{
  var si_enfantmoins3ans = 0;
  var si_enfantplus3ans = 0;
  lesFamilles[i][0].forEach(element => {
    age_enfant = parseInt(element["age"]/365,10);
    if(age_enfant < 3 && element["concernGarde_Enfants"] == 1){
      si_enfantmoins3ans = 1;
    }
    if(age_enfant >=3 && element["concernGarde_Enfants"] == 1){
      si_enfantplus3ans = 1;
    }
  });
  return [si_enfantmoins3ans , si_enfantplus3ans];
}

function Marker_options(i)
{
  var index = 0;
  //index est le nombre de fois une famille
  //a une des options du menu déroulant
  //sauf autres, qui ont un index négatif
  if(lesFamilles[i]["aPourvoir_PM"] == 1){
    index++;
  }
  if(lesFamilles[i]["aPourvoir_PGE"] >= 1){
    if(lesFamilles[i]["gardePart_Famille"] == 1){
      index++;
    }
    if(Age_enfant(i)[0] == 1){
      index++;
    }
    if(Age_enfant(i)[1] == 1){
      index++;
    }
  }
  if(index == 0){
    index--;
  }
  listeMarker[i][1] = index;
}

function Couleur_option(i)
{
  var aPourvoir_PGE_moins3ans = 0;
  var aPourvoir_PGE_plus3ans = 0;
  var aPourvoir_PGE_partage = 0;
  var aPourvoir_PM = 0;
  if(menu_option[0] == 1){
    aPourvoir_PM = lesFamilles[i]["aPourvoir_PM"];
  }//Si menu_option est égale à 1,aPourvoir_PGE prend la valeur
  //du champ "aPourvoir_PGE" pour cette famille
  //autrement aPourvoir_PGE est égale à 0 et la couleur associé n'apparait plus
  //de meme pour les autres options du menu
  if(menu_option[1] == 1){
    aPourvoir_PGE_moins3ans = Age_enfant(i)[0];
  }
  if(menu_option[2] == 1){
    aPourvoir_PGE_plus3ans = Age_enfant(i)[1];
  }
  if(menu_option[3] == 1){
    aPourvoir_PGE_partage = lesFamilles[i]["gardePart_Famille"];
  }
  url = "black";
  //ensemble de if pour savoir quelle couleur donné à un marker
  if(aPourvoir_PM == 1)
  {
    url = "blue";
    if(lesFamilles[i]["aPourvoir_PGE"]>=1 ){
      if(aPourvoir_PGE_partage == 1 || aPourvoir_PGE_moins3ans == 1 || aPourvoir_PGE_plus3ans == 1) {
        url="grey";
      }
    }
  }
  else
  {
    if(lesFamilles[i]["aPourvoir_PGE"]>=1){
      if(aPourvoir_PGE_partage == 1){
        if(!(aPourvoir_PGE_moins3ans == 1 || aPourvoir_PGE_plus3ans == 1)) {url = "red";}
        else {url="violet";}
      }
      if(aPourvoir_PGE_moins3ans == 1){
        if(!(aPourvoir_PGE_partage == 1 || aPourvoir_PGE_plus3ans == 1)) {url = "orange";}
        else {url="violet";}
      }
      if(aPourvoir_PGE_plus3ans == 1){
        if(!(aPourvoir_PGE_partage == 1 || aPourvoir_PGE_moins3ans == 1)) {url = "yellow";}
        else {url="violet";}
      }
    }
  }
  if(url=="blue"){mode=1.2}
  else{
    if (lesFamilles[i]["aPourvoir_PGE"] == 2){mode = 0.8}else{mode = 1.2}
  }
  icon(url,listeMarker[i][0],mode);
}


function icon(url,marker,i)
{
  var Icon_created = new L.Icon({
  iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-' + url + '.png',
  shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
  iconSize: [25*i, 41*i],
  iconAnchor: [12*i, 41*i],
  popupAnchor: [1*i, -34*i],
  shadowSize: [41*i, 41*i]
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
          if(lesFamilles[i]["aPourvoir_PM"]==1){//si la famille associé au marker à une demande a pourvoir de ménage
            menu_option[0] = 0;//on veut cacher la couleur associé au ménage
            Couleur_option(i);//on relance la fonction si la couleur change
            listeMarker[i][1]--;//index diminue car une des options est cachée
            closure(listeMarker[i][0],listeMarker[i][1]);//regarde si l'index est égale à 0
                                                         //si oui cache le marker
          }
        }
        else
        {
          if(lesFamilles[i]["aPourvoir_PM"]==1){//si la famille associé au marker à une demande a pourvoir de ménage
            menu_option[0] = 1;//on veut faire réapparaitre la couleur associé au ménage
            Couleur_option(i);//on relance la fonction si la couleur change
            listeMarker[i][1]++;//index augmente car cette option est affiché
            closure(listeMarker[i][0],listeMarker[i][1]);//si le marker a un index supérieur à 0 (normalement le cas)
          }
        }
      }
      count_Famille();//relance le test du nombre de famille
      break;
    case "garde_enfant":
      if (!document.getElementById(type_marker).checked){//si la case n'est pas coché
        $('input[class="garde_enfant"]').each(function() { //jQuery récupère chaque html bloc de type input et class "garde_enfant"
          if(this.checked){//si le type input est checké permettant de ne pas refaire exécuter le code
			  	this.checked = false;//décoché le type input
          this.onchange();//declenche le changement de position du type input
          }
        });
      }
      else{//de même avec un check si le type input n'est pas coché
        $('input[class="garde_enfant"]').each(function() { 
          if(!this.checked){
			  	this.checked = true;
          this.onchange();
          }
        });
      }
      count_Famille();
      break;
    case "garde_enfant_moinsde3ans"://de meme que ménage
      for(let i = 0; i < listeMarker.length; i++)
      {
        if (!document.getElementById(type_marker).checked)
        {
          if(lesFamilles[i]["aPourvoir_PGE"]>=1  && Age_enfant(i)[0] == 1){
            menu_option[1] = 0;
            Couleur_option(i);
            listeMarker[i][1]--;
            closure(listeMarker[i][0],listeMarker[i][1]);
          }
        }
        else
        {
          if(lesFamilles[i]["aPourvoir_PGE"]>=1 && Age_enfant(i)[0] == 1){
            menu_option[1] = 1;
            Couleur_option(i);
            listeMarker[i][1]++;
            closure(listeMarker[i][0],listeMarker[i][1]);
          }
        }
      }
      count_Famille();
      break;
    case "garde_enfant_plusde3ans"://de meme que ménage
      for(let i = 0; i < listeMarker.length; i++)
      {
        if (!document.getElementById(type_marker).checked)
        {
          if(lesFamilles[i]["aPourvoir_PGE"]>=1  && Age_enfant(i)[1] == 1){
            menu_option[2] = 0;
            Couleur_option(i);
            listeMarker[i][1]--;
            closure(listeMarker[i][0],listeMarker[i][1]);
          }
        }
        else
        {
          if(lesFamilles[i]["aPourvoir_PGE"]>=1 && Age_enfant(i)[1] == 1){
            menu_option[2] = 1;
            Couleur_option(i);
            listeMarker[i][1]++;
            closure(listeMarker[i][0],listeMarker[i][1]);
          }
        }
      }
      count_Famille();
      break;
    case "garde_enfant_partage"://de meme que ménage
      for(let i = 0; i < listeMarker.length; i++)
      {
        if (!document.getElementById(type_marker).checked)
        {
          if(lesFamilles[i]["aPourvoir_PGE"]>=1 && lesFamilles[i]["gardePart_Famille"] == 1){
            menu_option[3] = 0;
            Couleur_option(i);
            listeMarker[i][1]--;
            closure(listeMarker[i][0],listeMarker[i][1]);
          }
        }
        else
        {
          if(lesFamilles[i]["aPourvoir_PGE"]>=0 && lesFamilles[i]["gardePart_Famille"]==1){
            menu_option[3] = 1;
            Couleur_option(i);
            listeMarker[i][1]++;
            closure(listeMarker[i][0],listeMarker[i][1]);
          }
        }
      }
      count_Famille();
      break;
    case "autres"://quand il y a un problème ,d'ou donnée errone
      for(let i = 0; i < listeMarker.length; i++)
        {
          if (!document.getElementById(type_marker).checked)//si la case n'est pas coché
          {
            if(listeMarker[i][1] == -1)//si l'index est négatif
            {
              map.removeLayer(listeMarker[i][0]);//enlever le marker
            }
          }
          else{
            if(listeMarker[i][1] == -1)
            {
              map.addLayer(listeMarker[i][0]);//mettre le marker
            }
          }
        }
        count_Famille();
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
      count_Famille();
      break;
  }
}
function Popup_message(i) {
  var message = "";
  if (lesFamilles[i]["aPourvoir_PM"]) {
    message = "Prestation Ménage";
  }
  if (lesFamilles[i]["aPourvoir_PGE"]) {
    message = message + " Prestation Garde d'enfant";
  }
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

function count_Famille(){
  var nbr = 0;
  var p = document.getElementById("nombre_Familles");
  for(let j = 0; j < listeMarker.length; j++){
    if(listeMarker[j][1] > 0){
      nbr++;
    }
  }
  p.innerHTML = "familles <br>" + nbr + " RÉSULTATS";
}


</script>

  </body>
</html>