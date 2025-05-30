<!--Vincent bouton vers le haut de page--> 
<button class="button" onclick="topFunction()" id="topBtn"><img src="images/toTop.png" width="60"></button>

<script>
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
 if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
   document.getElementById("topBtn").style.display = "block";
 } else {
   document.getElementById("topBtn").style.display = "none";
 }
}

function topFunction() {
 document.body.scrollTop = 0;
 document.documentElement.scrollTop = 0;
}
</script>

<?php
/* La directive @var permet de déclarer une variable créée dans un script séparé 
 * du présent script, et ainsi de bénéficier de l'auto-complétion sur cette variable
 */
/* @var $lesEtudiants array 

for($i = 0 ; $i < 58 ; $i++){
  echo "$i - ";
  var_dump($lesChamps[$i]["COLUMN_NAME"]);
  echo"<br/>";
}
*/


//var_dump($lesSalaries[0]);
?>
<!-- Division pour le contenu principal -->
<div id="contenu">
  <table width="100%"> <tr> <td> 

  <?php if ($action=='resAdvSearchI'){?>
    <?php 
    $stack = array();

    foreach ($lesSalaries as $unSalarie)  
    {
      array_push($stack, $unSalarie[37]);
    }

    $_SESSION['stack'] = $stack;

    $_SESSION['numeroElementListeSearch'] = 1;

    $_SESSION['pointeur'] = current($stack);

    ?>
    <a class="btn btn-secondary display-4 sideButton" target="_blank" href="planning.php?action=resAdvSearchI&amp;num=<?php echo $stack[0]?>">PLANNING <br> de la recherche avancée</a>
  <?php } else {?>
    <a class="btn btn-secondary display-4 sideButton" target="_blank" href="planning.php?num=<?php echo $pdoChaudoudoux->premierSal()?>">PLANNING</a> 
    <?php } ?>

  </td> <td> 
  
  <h1 style="text-align: center">INTERVENANTS <br>
  <?php if ($archive==1){echo 'archivés <br>';}?><?php
  if ($action=='resAdvSearchI'){ echo ' résultat de la recherche avancée <br>';}
  if ($action=='voirSalPlace'){ echo ' placés <br>';}
  if ($action =='complH'){echo ' en recherche de complément <br>';}
  if ($action =='voirTousSalarie'){echo ' non placés <br>';}
  if ($action =='voirTousSalarieplaces'){echo ' qui ont été placés<br>';}
  if ($action =='voirTousSalariejamaisplaces'){echo ' Jamais placés <br>';}
  if ($action =='voirSalHorsRennes'){echo ' hors de Rennes <br>';}
  if ($action =='voirSalRennes'){echo ' Rennais <br>';}
  if ($action =='voirSalVehicule'){echo ' véhiculés <br>';}
  if ($action =='voirSalGE'){echo ' garde d\'enfants placés <br>';}
  if ($action =='voirSalGENP'){echo ' garde d\'enfants non placés <br>';}
  if ($action =='voirSalmoins3a'){echo ' moins de 3 ans <br>';}
  if ($action =='voirSalenfHand'){echo ' enfants handicapés <br>';}
  if ($action =='voirSalMenage'){echo ' ménage placés <br>';}
  if ($action =='voirSalMenageNP'){echo ' ménage non placés <br>';}
  if ($action =='voirTousSalarieArchive'){echo ' placés <br>';}
  if ($action =='voirTousSalarieArchiveNonPlace'){echo ' non placés <br>';}
  if ($action =='voirSalGEP'){echo ' garde d\'enfants prestataire <br>';}
  if ($action =='voirSalGEM'){echo ' garde d\'enfants mandatairef <br>';} 
  if ($action =='voirTousSalarieArret') {echo ' en arrêt de travail <br>';}
  if($action=='vueModif'){ echo ' dont l\'emploi du temps prestataire à été modifié dans le mois actuel <br>';}
  echo count($lesSalaries);
  ?>
  RÉSULTATS  </h1>
  </td> <td align="right" width="30%"> 
   
    <a class="btn btn-secondary display-4 sideButton" href="index.php?uc=search&amp;action=advSearchI">RECHERCHE AVANCÉE</a>
   
  </td> </tr> </table>

  

<button id="btnToutCocher">Tout cocher</button>
<button id="btnToutDecocher">Tout décocher</button> 
<select id="lstPreSelection">
</select>
<input id="nomSelection">
<button id="btnSavePreSelection">Enregistrer la selection</button>
<button id="btnDelPreSelection">Supprimer les selections</button>
<br> <br>
<div class="deroule">
<span><h2 class="revert dropdown-toggle" style="cursor:pointer;padding:10px;border-style:solid;border-width:2px;text-align:center;border-color:#4d4d4d;align:center">AFFICHAGE COLONNES</h2></span>
<div class="deroule-content" style="column-count: 4">
<form id="chks">
</div>
</div>

</form>
<table class="sortable zebre" id="listeSalaries" style="max-width:100%">
<tr class="btn-secondary"> </tr>
</table>
    </div>
    

    <script>
    window.addEventListener("load", initApp);
    window.addEventListener("load", supprimerTable);
    window.addEventListener("load", colones);
/**
 * Définit tous les écouteurs d'événement
 */
let entete = <?php echo json_encode($lesChamps);?>;
// entete = removeDuplicates(entete);
var intervenants = <?php echo json_encode($lesSalaries); ?>;
var selections = <?php echo(substr(file_get_contents("./config/selections.txt"), 0, -1) . "]") ?>;

var select = document.getElementById("lstPreSelection");
for (k = 0; k != selections.length; k++){
  var option = document.createElement('option');
  option.setAttribute("value", selections[k][1]);
  option.appendChild(document.createTextNode( selections[k][0] ));
  select.appendChild(option);
}


var form = document.getElementById("chks");
for (u = 1; u != entete.length; u++){
  var chk = document.createElement('input');
  chk.setAttribute("type", "checkbox");
  chk.setAttribute("id", "chk"+u);
  chk.setAttribute("value", u);
  chk.setAttribute("checked", true);
  var label = document.createElement('label');
  label.setAttribute("class","container");
  if (entete[u]['COLUMN_NAME'].split('_')[0] == 'expBBmoins1a') {
    label.innerHTML = "expmoins3a&nbsp&nbsp&nbsp;";
  } else {
    label.innerHTML = entete[u]['COLUMN_NAME'].split('_')[0]+"&nbsp&nbsp&nbsp;";
  }
  var span = document.createElement('span');
  span.setAttribute("class","checkmark");
  
  label.setAttribute("for", "chk"+u);
  label.innerHTML = "<b>" + label.innerHTML + "</b>";
  
  label.appendChild(chk);
  label.appendChild(span);
  form.appendChild(label);
}

intervenants.splice(0, 0, entete);

// queFaire booléen pour cochez tout (true) ou tout decochez (false)
function cocherDecocher(queFaire) {
  var from = document.getElementById("chks");
  var toutesLesCases = from.querySelectorAll("input[type=checkbox]");
  for (var i = 0; i < toutesLesCases.length; i++) {
    toutesLesCases[i].checked = queFaire;
  }
}
// o = ligne du tableau intervenants
// p = colonne du tableau intervenants
function colones() {
  var table = document.getElementById("listeSalaries");


  for (o = 0; o != intervenants.length; o++) {   
    if (o == 1){
      var body = document.createElement('tbody');
    } else if (o == 0){
      var head = document.createElement('thead');
    }      
    var row = document.createElement('tr');
    if (o == 0) {
      row.className += "btn-secondary";
    }

    //boucle td = creation d'un tr
    for (p = 1; p != intervenants[o].length; p++) { 

      //case cochez?
      var from = document.getElementById("chks");
      if (
        
        from.querySelectorAll("input[type=checkbox]")[p-1].checked == true
      ) {
        let cell = "";
        if (o == 0) {
          cell = document.createElement("th"); //si thead
        } else {
          cell = document.createElement("td"); //si tbody
        }
        //fin cochez?


        
        if (o == 0) {
          if ( intervenants[o][p]['COLUMN_NAME'].split('_')[0] == 'expBBmoins1a') {
            var cellText = document.createTextNode('expmoins3a');
          } else {
            var cellText = document.createTextNode(intervenants[o][p]['COLUMN_NAME'].split('_')[0]);
          }
          
        } else if (intervenants[0][p]['COLUMN_TYPE'] == 'tinyint(1)') {
          if (intervenants[o][p] == 1){
            var cellText = document.createTextNode('OUI');
          } else {
            var cellText = document.createTextNode('NON');
          }
        } else if (intervenants[0][p]['COLUMN_TYPE'] == 'date' || intervenants[0][p]['COLUMN_TYPE'] == 'datetime') {
          if (intervenants[o][p] == "0000-00-00" || intervenants[o][p] == null){
            var cellText = document.createTextNode('');
          } else {
            var date = intervenants[o][p].toLocaleString('en-US');
            if (date.length > 10){
              var date = date.substring(0, date.length - 9);
            }
            
            var paragraf = document.createElement("p");
            var cellText = document.createTextNode(date + " | ");

            paragraf.appendChild(cellText);
            paragraf.hidden=true;
            cell.appendChild(paragraf);
            var cellText = document.createTextNode(new Date(intervenants[o][p]).toLocaleDateString("fr"));
          
          }
        } else if (intervenants[0][p]['COLUMN_NAME'].split('_')[0] == 'nom') {
          var cellText = document.createElement("a");
          cellText.setAttribute("href", "index.php?uc=annuSalarie&action=voirDetailSalarie&num="+intervenants[o][37]);
		  // cellText.setAttribute("target", "_blank");
          var texte = document.createTextNode(intervenants[o][p]);
          cellText.appendChild(texte);
        } else if (intervenants[0][p]['COLUMN_NAME'].split('_')[0] == 'Mutuelle') {
          if (intervenants[o][p] == 0){
            var cellText = document.createTextNode("");
          } else {
            var cellText = document.createTextNode(intervenants[o][p]);
          }
          
        } else {
          if (intervenants[o][p] == null){
            var cellText = document.createTextNode("");
          } else {
            var cellText = document.createTextNode(intervenants[o][p]);
          }
          
        }
        
      
        

        
        cell.appendChild(cellText);
        row.appendChild(cell);
        //fin condition
        
      }
      if (o == 0){
        
        head.appendChild(row);
      } else {
        body.appendChild(row);
      }
    }
    //boucle td
    
    
  }
  table.appendChild(head);
  table.appendChild(body);
  sorttable.makeSortable(table);
}

function removeDuplicates(colors) {
  
  let unique = {};
  colors.forEach(function(i) {
    if(!unique[i]) {
      unique[i] = true;
    }
  });
  return Object.keys(unique);
}

function supprimerTable() {
  let Tableau = document.getElementById("listeSalaries");
  Tableau.removeChild(Tableau.querySelector("tbody"));
  Tableau.removeChild(Tableau.querySelector("thead"));
  
}

function checkSelection() {
  var from = document.getElementById("chks");
  var toutesLesCases = from.querySelectorAll("input[type=checkbox]");
  for (var i = 0; i < toutesLesCases.length; i++) {
    if (document.getElementById("lstPreSelection").value.includes(entete[i+1]['COLUMN_NAME'])){
      toutesLesCases[i].checked = true;
    } else {
      toutesLesCases[i].checked = false;
    }
  }
}

function initApp() {
  var boutonCocher = document.getElementById("btnToutCocher");
  boutonCocher.addEventListener("click", function () {
    cocherDecocher(true);
    supprimerTable();
    colones();
  });
  var boutonDecocher = document.getElementById("btnToutDecocher");
  boutonDecocher.addEventListener("click", function () {
    cocherDecocher(false);
    supprimerTable();
    colones();
  });
  var from = document.getElementById("chks");
  var chk = from.querySelectorAll("input[type=checkbox]");
  for (l = 0; l < chk.length; l++){
    chk[l].addEventListener("click", function () {
      supprimerTable();
      colones();
    });
  }
  var boutonSavePreSelection = document.getElementById("btnSavePreSelection");
  boutonSavePreSelection.addEventListener("click", function () {
    var nom = document.getElementById("nomSelection").value;
    var selection = "["

    var from = document.getElementById("chks");
    var toutesLesCases = from.querySelectorAll("input[type=checkbox]");
    for (j = 0; j < toutesLesCases.length; j++){
      if (toutesLesCases[j].checked == true){
        var selection = selection + "'" + entete[document.getElementById("chk"+(j+1)).value]['COLUMN_NAME'] + "',";
        
      }
    }
    
    


    selection = selection.substring(0, selection.length - 1)
    var selection = selection + "]"
    if (nom != "" && selection != "]"){
      document.location.href="index.php?uc=annuSalarie&action=ajoutSelection&nom="+nom+"&selection="+selection;
    }
  });
  var lstPreSelection = document.getElementById("lstPreSelection");
  lstPreSelection.addEventListener("change", function () {
    checkSelection();
    supprimerTable();
    colones();
  });
  var btnDelPreSelection = document.getElementById("btnDelPreSelection");
  btnDelPreSelection.addEventListener("click", function () {
    document.location.href="index.php?uc=annuSalarie&action=delSelection"
  });
}

    </script>