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
<html>
<head>
<style>
 table, th, td,tr {
   border: 1px solid black;

 }
 table{
    width:100%;
    border-collapse: collapse;
 }
 
 </style>

<!--/*var checkbox_check=document.getElementById('input[name="col"]').checked*/
/*document.getElementById(col_name+"_head").style.display="none";
document.getElementById(col_name).value="show";*/
/*document.getElementById(col_name+"_head").style.display="table-cell";
document.getElementById(col_name).value="hide";*/-->


<?php error_reporting ( 0 ); ?>


<div class="divCenter">

<div id="contenu">
<!--Différents titres des pages/tableaux en fonctions de la page actuelle-->
<h1 style="text-align: center">familles à pourvoir<br>

<?php

  $nbFamilleM=0;
  $lastNomF="";
  foreach($lesBesoinsFamillesM as $elem){
    if($elem['numero_Famille']!=$lastNomF){
      $lastNomF=$elem['numero_Famille'];
      $nbFamilleM += 1;
    }
  }

if($action=='voirTousFamilleBesoinM'){
  echo 'besoin immédiat pour le ménage <p style="text-transform: lowercase" >(pas d\'intervenant en place actuellement)</p>';
  echo ($nbFamilleM);
  }
  
  ?>
  RÉSULTAT<?php if($nbFamilleM>1){echo 'S';}?>
</h1>
</head>

<table style='width:100%;border: solid 1px black;border-collapse:collapse;' class="sortable zebre">
		<thead>
	    <tr>
        <th> M </th>
        <th> PM </th>
        <th> PGE </th>
        <th> REG </th>
        <th> Nom de la famille </th>
        <th> Ville de la famille </th>
        <th> Quartier de la famille </th>
        <th> Date à pourvoir </th>

        <th> Activité </th>

        <th> Jour sans <br/> importance </th>
        <th>Exception</th>
        <th> Lundi  </th>
        <th> Mardi  </th>
        <th> Mercredi  </th>
        <th> Jeudi  </th>
        <th> Vendredi  </th>
        <th> Samedi  </th>
        <th> Dimanche  </th>
        <th> Nombre d'heures/sem </th>
        <th> Total des heures  </th>
        <th> Email préfabriqué </th>
      </tr>
	</thead>

	<?php      
    echo "<tbody>";

    $i=0;
    while($i<count($lesBesoinsFamillesM)){
      $numeroFamille=$lesBesoinsFamillesM[$i]['numero_Famille'];
      $PGE = $lesBesoinsFamillesM[$i]['PGE_Famille'];
      $exceptionJour = explode(' ', $lesBesoinsFamillesM[$i]['jourException']);
      $heureSem = $lesBesoinsFamillesM[$i]['heureSemaine'];
      $PM = $lesBesoinsFamillesM[$i]['PM_Famille'];
      $nomFamille = $lesBesoinsFamillesM[$i]['nom_Parents'];
      $quartier=$lesBesoinsFamillesM[$i]["quartier_Famille"];
      $ville=$lesBesoinsFamillesM[$i]["ville_Famille"];
      $REG=$lesBesoinsFamillesM[$i]["REG_Famille"];
      $dateFin=$lesBesoinsFamillesM[$i]["dateFin_Proposer"];
      $dateApourvoir=$lesBesoinsFamillesM[$i]["Date_aPourvoir_PM"];
      $numFamille=$lesBesoinsFamillesM[$i]['numero_Famille'];
      //Mise en forme des dates en date françaises
      $dateApourvoir=explode("-",$lesBesoinsFamillesM[$i]["Date_aPourvoir_PM"]);
      $dateApourvoir=$dateApourvoir[2]."-".$dateApourvoir[1]."-".$dateApourvoir[0];

      $dateFin=explode('-', $lesBesoinsFamillesM[$i]["dateFin_Proposer"]);
      $dateFin=$dateFin[2]."-".$dateFin[1]."-".$dateFin[0]; 
      // echo $activite." </br>";

      $sansImportance="";
      $lundi="";
      $mardi="";
      $mercredi="";
      $jeudi="";
      $vendredi="";
      $samedi="";
      $dimanche="";

      $total=0;
      $sommeL=0;
      $sommeM=0;
      $sommeMe= 0;
      $sommeJ=0;
      $sommeV=0;
      $sommeS=0;
      $sommeD=0;
      $j=0;

      while($j<count($lesBesoinsFamillesM)){
        
        if($lesBesoinsFamillesM[$j]['numero_Famille']==$lesBesoinsFamillesM[$i]['numero_Famille']){
          $jour=$lesBesoinsFamillesM[$j]["jour"];
          $heureDebut=$lesBesoinsFamillesM[$j]["heureDebut"];
          $heureFin=$lesBesoinsFamillesM[$j]["heureFin"];
          $frequence=$lesBesoinsFamillesM[$j]["frequence"];
          if($jour=="sans importance"){
            $timeDebut    = explode(':', $heureDebut);
            $minutesDebut= ($timeDebut[0]*60) + ($timeDebut[1]) + ($timeDebut[2]/60);

            $timeFin    = explode(':', $heureFin);
            $minutesFin= ($timeFin[0]*60) + ($timeFin[1]) + ($timeFin[2]/60);
            
            $sommeL+=($minutesFin-$minutesDebut)/$frequence;

            $sansImportance.=$heureDebut."-".$heureFin."</br>";
            if($frequence!=1){
              $sansImportance.="une semaine sur ".$frequence."</br>";
            }
          }
          elseif($jour=="lundi"){
            $timeDebut    = explode(':', $heureDebut);
            $minutesDebut= ($timeDebut[0]*60) + ($timeDebut[1]) + ($timeDebut[2]/60);

            $timeFin    = explode(':', $heureFin);
            $minutesFin= ($timeFin[0]*60) + ($timeFin[1]) + ($timeFin[2]/60);
            
            $sommeL+=($minutesFin-$minutesDebut)/$frequence;

            $lundi.=$heureDebut."-".$heureFin."</br>";
            // echo $sommeL;
            if($frequence!=1){
              $lundi.="une semaine sur ".$frequence."</br>";
            }
          }
          elseif($jour=="mardi"){
            $timeDebut = explode(':', $heureDebut);
            $minutesDebut= ($timeDebut[0]*60) + ($timeDebut[1]) + ($timeDebut[2]/60);

            $timeFin    = explode(':', $heureFin);
            $minutesFin= ($timeFin[0]*60) + ($timeFin[1]) + ($timeFin[2]/60);
            
            $sommeM+=($minutesFin-$minutesDebut)/$frequence;

            $mardi.=$heureDebut."-".$heureFin."</br>";
            //  echo $sommeM;
            if($frequence!=1){
              $mardi.="une semaine sur ".$frequence."</br>";
            }
          }
          elseif($jour=="mercredi"){
            $timeDebut    = explode(':', $heureDebut);
            $minutesDebut= ($timeDebut[0]*60) + ($timeDebut[1]) + ($timeDebut[2]/60);

            $timeFin    = explode(':', $heureFin);
            $minutesFin= ($timeFin[0]*60) + ($timeFin[1]) + ($timeFin[2]/60);
            
            $sommeMe+=($minutesFin-$minutesDebut)/$frequence;

            $mercredi.=$heureDebut."-".$heureFin."</br>";
            //  echo $sommeMe;
            if($frequence!=1){
              $mercredi.="une semaine sur ".$frequence."</br>";
            }
          }
          elseif($jour=="jeudi"){
            $timeDebut    = explode(':', $heureDebut);
            $minutesDebut= ($timeDebut[0]*60) + ($timeDebut[1]) + ($timeDebut[2]/60);

            $timeFin    = explode(':', $heureFin);
            $minutesFin= ($timeFin[0]*60) + ($timeFin[1]) + ($timeFin[2]/60);
            
            $sommeJ+=($minutesFin-$minutesDebut)/$frequence;
            

            $jeudi.=$heureDebut."-".$heureFin."</br>";
            //  echo $sommeJ;
            if($frequence!=1){
              $jeudi.="une semaine sur ".$frequence."</br>";
            }
            
          }
          elseif($jour=="vendredi"){
            $timeDebut    = explode(':', $heureDebut);
            $minutesDebut= ($timeDebut[0]*60) + ($timeDebut[1]) + ($timeDebut[2]/60);

            $timeFin    = explode(':', $heureFin);
            $minutesFin= ($timeFin[0]*60) + ($timeFin[1]) + ($timeFin[2]/60);
            
            $sommeV+=($minutesFin-$minutesDebut)/$frequence;

            $vendredi.=$heureDebut."-".$heureFin."</br>";
            // echo $sommeV;
            if($frequence!=1){
              $vendredi.="une semaine sur ".$frequence."</br>";
            }
          }
          elseif($jour=="samedi"){
            $timeDebut    = explode(':', $heureDebut);
            $minutesDebut= ($timeDebut[0]*60) + ($timeDebut[1]) + ($timeDebut[2]/60);

            $timeFin    = explode(':', $heureFin);
            $minutesFin= ($timeFin[0]*60) + ($timeFin[1]) + ($timeFin[2]/60);
            
            $sommeS+=($minutesFin-$minutesDebut)/$frequence;

            $samedi.=$heureDebut."-".$heureFin."</br>";
            // echo $sommeS;
            if($frequence!=1){
              $samedi.="une semaine sur ".$frequence."</br>";
            }
            
          }
          elseif($jour=="dimanche"){

            $timeDebut    = explode(':', $heureDebut);
            $minutesDebut= ($timeDebut[0]*60) + ($timeDebut[1]) + ($timeDebut[2]/60);

            $timeFin    = explode(':', $heureFin);
            $minutesFin= ($timeFin[0]*60) + ($timeFin[1]) + ($timeFin[2]/60);
            
            $sommeD+=($minutesFin-$minutesDebut)/$frequence;
            

            $dimanche.=$heureDebut."-".$heureFin."</br>";
            // echo $sommeD;
            if($frequence!=1){
              $dimanche.="une semaine sur ".$frequence."</br>";
            }
          }
        }
        $j++;
      }
     
    $i++;
    if($numeroFamille!=$lesBesoinsFamillesM[$i]['numero_Famille']){
      echo "<tr>";
      echo "<td><strong>".$numeroFamille."</strong></td>";
      echo "<td><strong>".$PM."</strong></td>";
      echo "<td><strong>".$PGE."</strong></td>";
      echo "<td><strong>".$REG."</strong></td>";
      echo '<td><a href="index.php?uc=annuFamille&action=voirDetailFamille&num='.$numFamille.'"><strong>'.$nomFamille.'</strong></a></td>';
      echo "<td>".$ville."</td>";
      echo "<td>".$quartier."</td>";
      echo "<td><strong>".$dateApourvoir."</strong></td>";

      echo "<td>MENAGE</td>";
      
      echo "<td>".$sansImportance."</td>";
      echo "<td>" . (isset($exceptionJour) ? "<strong>" . $exceptionJour[0] . "</strong> " . $exceptionJour[1] : "") . "</td>";
      echo "<td>".$lundi."</td>";
      echo "<td>".$mardi."</td>";
      echo "<td>".$mercredi."</td>";
      echo "<td>".$jeudi."</td>";
      echo "<td>".$vendredi."</td>";
      echo "<td>".$samedi."</td>";
      echo "<td>".$dimanche."</td>";
      echo "<td>".(isset($heureSem) ? $heureSem . "h" : "")."</td>";
      $total=$sommeL+$sommeM+$sommeMe+$sommeJ+$sommeV+$sommeS+$sommeD;
      echo "<td><strong>".($total/60)."h</strong></td>";
      echo '<td><a href="index.php?uc=annuFamille&action=voirEmailPrefabMenage&num='.$numFamille.'"> Voir l\'email </a></td>';
      echo '</tr>';
    }
  }
  echo "</tbody>";
  echo "</table>";  
?>
</div>
</body>
</html>

      <!--Vincent--> 
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