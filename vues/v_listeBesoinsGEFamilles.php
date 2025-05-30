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
<h1 style="text-align: center">familles <br>

<?php
  
  $nbFamilleGE=0;
  $lastNomF="";
  foreach($lesBesoinsFamillesGE as $elem){
    if($elem['numero_Famille']!=$lastNomF){
      $lastNomF=$elem['numero_Famille'];
      $nbFamilleGE += 1;
    }
  }

if($action=='voirTousFamilleBesoinGE')							{echo 'besoin immédiat pour la garde d\'enfants <p style="text-transform: lowercase" >(pas d\'intervenant en place actuellement)</p>';
   echo ($nbFamilleGE);
  }
  
  ?>
  RÉSULTAT<?php if($nbFamilleGE){echo 'S';}?>
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
      <th> Age des enfants </th>
      <th> Spécificité </th>
      <th> Activité </th>

      <th> Jour sans <br/> importance </th>
      <th> Lundi  </th>
      <th> Mardi  </th>
      <th> Mercredi  </th>
      <th> Jeudi  </th>
      <th> Vendredi  </th>
      <th> Samedi  </th>
      <th> Dimanche  </th>
      <th> Total des heures  </th>
      <th> Email préfabriqué </th>
    </tr>
  </thead>

	<?php      
    
    $lesBesoinsDuneFamille=$lesBesoinsFamillesGE[0];
    $numeroFamille=$lesBesoinsFamillesGE[0]['numero_Famille'];

    
    echo "<tbody>";
    $i=0;
    while($i<count($lesBesoinsFamillesGE)){
      $numeroFamille=$lesBesoinsFamillesGE[$i]['numero_Famille'];
      $PGE = $lesBesoinsFamillesGE[$i]['PGE_Famille'];
      $PM = $lesBesoinsFamillesGE[$i]['PM_Famille'];
      $nomFamille = $lesBesoinsFamillesGE[$i]['nom_Parents'];
      $quartier=$lesBesoinsFamillesGE[$i]["quartier_Famille"];
      $ville=$lesBesoinsFamillesGE[$i]["ville_Famille"];
      $REG=$lesBesoinsFamillesGE[$i]["REG_Famille"];
      $dateApourvoir=$lesBesoinsFamillesGE[$i]["Date_aPourvoir_PGE"];
      //Mise en forme des dates en date françaises
      $dateApourvoir=explode("-",$lesBesoinsFamillesGE[$i]["Date_aPourvoir_PGE"]);
      $dateApourvoir=$dateApourvoir[2]."-".$dateApourvoir[1]."-".$dateApourvoir[0];
      // echo $activite." </br>";

      //Les booléens suivants servent à vérifier la tranche d'âge
      //Une famille ne peut avoir qu'une seule tranche d'âge, qui correspond à l'enfant le + jeune
      $tranche1=false;
      $tranche2=false;
      $specificiteEnfant="";        
      $numFamille=$lesBesoinsFamillesGE[$i]["numero_Famille"];
      $enfants=$pdoChaudoudoux->obtenirEnfantsFamille($numFamille);
      $age="";
      foreach ($enfants as $enfant){
        //On divise par 365 pour avoir le nb d'années
        $ageYear = $enfant["age"]/365;
        //On retire les unités au nb d'années et on multiplie par 12 pour avoir le nb de mois
        $ageMonth = intval(($ageYear - floor($ageYear)) * 12);
        //IF qui permet de ne pas avoir de '/' en début de châine
        if($age==""){
          $age = intval($ageYear);
        }
        else {
          $age = $age . ' / ' . intval($ageYear);
        }
        //On vérifie si l'enfant à moins de 6 mois
        if($ageYear<=0.5){
            $specificiteEnfant="Moins de <strong>6mois</strong>";
            $tranche1=true;
        }
        //On vérifie si l'enfant à entre 6mois et 1,5ans
        if($ageYear>0.5&&$ageYear<=1.5){
          if(!$tranche1){
            $specificiteEnfant="Entre <strong>6mois</strong> et <strong>1,5ans</strong>";
            $tranche2=true;
          }
        }
        //On vérifie si l'enfant à entre 1,5ans et 3ans
        if($ageYear>1.5&&$ageYear<=3){
          if(!$tranche2){
            $specificiteEnfant="Entre <strong>1,5ans</strong> et <strong>3ans</strong>";
          }
        }
      }

      if($lesBesoinsFamillesGE[$i]["enfantHand_Famille"]==1){
        $unHandicap="<strong>HANDICAP</strong>";
      }
      else{
        //SI non, on met la chaîne à vide pour ne rien afficher
        $unHandicap=""; 
      } 
      if($lesBesoinsFamillesGE[$i]['vehicule_Famille']==1){
        $besoinVoiture="<strong>VOITURE</strong>";
      }
      else{
        $besoinVoiture="";
      }

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
      while($j<count($lesBesoinsFamillesGE)){
        
        if($lesBesoinsFamillesGE[$j]['numero_Famille']==$lesBesoinsFamillesGE[$i]['numero_Famille']){
          $jour=$lesBesoinsFamillesGE[$j]["jour"];
          $heureDebut=$lesBesoinsFamillesGE[$j]["heureDebut"];
          $heureFin=$lesBesoinsFamillesGE[$j]["heureFin"];
          $frequence=$lesBesoinsFamillesGE[$j]["frequence"];
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
    if($numeroFamille!=$lesBesoinsFamillesGE[$i]['numero_Famille']){
      echo "<tr>";
      echo "<td><strong>".$numeroFamille."</strong></td>";
      echo "<td><strong>".$PM."</strong></td>";
      echo "<td><strong>".$PGE."</strong></td>";
      echo "<td><strong>".$REG."</strong></td>";
      echo '<td><a href="index.php?uc=annuFamille&action=voirDetailFamille&num='.$numFamille.'"><strong>'.$nomFamille.'</strong></a></td>';
      echo "<td>".$ville."</td>";
      echo "<td>".$quartier."</td>";
      echo "<td><strong>".$dateApourvoir."</strong></td>";
      echo "<td><strong>".$age."</strong></td>";
      echo "<td><p>" .  $specificiteEnfant . "</p><p>".$unHandicap."</p><p> $besoinVoiture </p> </td>";

      echo "<td>GE</td>";
      
      echo "<td>".$sansImportance."</td>";
      echo "<td>".$lundi."</td>";
      echo "<td>".$mardi."</td>";
      echo "<td>".$mercredi."</td>";
      echo "<td>".$jeudi."</td>";
      echo "<td>".$vendredi."</td>";
      echo "<td>".$samedi."</td>";
      echo "<td>".$dimanche."</td>";
      $total=$sommeL+$sommeM+$sommeMe+$sommeJ+$sommeV+$sommeS+$sommeD;
      echo "<td><strong>".($total/60)."h</strong></td>";
      echo '<td><a href="index.php?uc=annuFamille&action=voirEmailPrefabGE&num='.$numFamille.'"> Voir l\'email </a></td>';
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