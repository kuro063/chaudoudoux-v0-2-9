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
$activite0="menage";
  
//$nbFamilleM=$pdoChaudoudoux->nbFamille($activite0);

$nbFamilleM=0;
  $lastNomF="";
  foreach($lesBesoinsFamillesM as $elem){
    if($elem['numero_Famille']!=$lastNomF){
      $lastNomF=$elem['numero_Famille'];
      $nbFamilleM += 1;
    }
  }

if($action=='voirTousFamilleBesoinM')							{echo 'leurs besoins<br> pour le ménage <br>';
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
<th> Lundi  </th>
<th> Mardi  </th>
<th> Mercredi  </th>
<th> Jeudi  </th>
<th> Vendredi  </th>
<th> Samedi  </th>
<th> Dimanche  </th>
<th> Total des heures  </th>

    </tr>
	</thead>

	<?php      
    // var_dump($lesBesoinsFamillesGE[1]["jour"]);
    // var_dump($lesBesoinsFamillesGE);
    /**
     * Je dois faire afficher tous les besoins(menage ou garde d'enfants) d'une famille sur une ligne et mettre toutes les horaires d'un jour dans sa case
     * Exemple : lundi de 10h à 12h à mettre dans la case lundi (entete lundi) s'il y a plusieurs horaires pour un même jour mettre tout dans la même case
     * Je dois afficher les demandes de lundi dans lundi, mardi dans mardi, etc.
     * 
     * Je prends tous les besoins des familles
     * Je prends les besoins d'une famille
     * Pour cette famille j'affiche un tableau avec lundi mardi mercredi ...
     */
    //var_dump($lesBesoinsFamillesGE);
  
  

    $numeroFamille=$lesBesoinsFamillesM[0]['numero_famille'];

    echo "<tbody>";
  
    for($j=0;$j<=count($lesBesoinsFamillesM);$j++){
      if($numeroFamille==$lesBesoinsFamillesM[$j]['numero_Famille']){
        if($activite0=$lesBesoinsFamillesM[$j]['activite']==$activite0){
          
          $numFamille=$lesBesoinsFamillesM[$j]["numero_Famille"];
          $jour=$lesBesoinsFamillesM[$j]["jour"];
          $heureDebut=$lesBesoinsFamillesM[$j]["heureDebut"];
          $heureFin=$lesBesoinsFamillesM[$j]["heureFin"];
          $frequence=$lesBesoinsFamillesM[$j]["frequence"];
          $PGE = $lesBesoinsFamillesM[$j]['PGE_Famille'];
          $PM = $lesBesoinsFamillesM[$j]['PM_Famille'];
          $nomFamille = $lesBesoinsFamillesM[$j]['nom_Parents'];
          $quartier=$lesBesoinsFamillesM[$j]["quartier_Famille"];
          $ville=$lesBesoinsFamillesM[$j]["ville_Famille"];
          $REG=$lesBesoinsFamillesM[$j]["REG_Famille"];
          $dateApourvoir=$lesBesoinsFamillesM[$j]["Date_aPourvoir_PM"];
          //Mise en forme des dates en date françaises
          $dateApourvoir=explode("-",$lesBesoinsFamillesM[$j]["Date_aPourvoir_PM"]);
          $dateApourvoir=$dateApourvoir[2]."-".$dateApourvoir[1]."-".$dateApourvoir[0];
          // echo $activite." </br>";
          
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
              $mercredi.="une semaine sur ".$frequence;
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
      }else{
      
        if($numeroFamille!=""){
        echo "<tr>";
        echo "<td><strong>".$numFamille."</strong></td>";
        echo "<td><strong>".$PM."</strong></td>";
        echo "<td>".$PGE."</td>";
        echo "<td>".$REG."</td>";
        echo '<td><a href="index.php?uc=annuFamille&action=voirDetailFamille&num='.$numFamille.'"><strong>'.$nomFamille.'</strong></a></td>';
        echo "<td>".$ville."</td>";
        echo "<td>".$quartier."</td>";
        echo "<td><strong>".$dateApourvoir."</strong></td>";
        
        echo "<td>MENAGE</td>";
        
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
        
        echo "</tr>";
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

        $numeroFamille=$lesBesoinsFamillesM[$j]['numero_Famille'];
        $numFamille=$lesBesoinsFamillesM[$j]["numero_Famille"];
        $quartier=$lesBesoinsFamillesM[$j]["quartier_Famille"];
        $ville=$lesBesoinsFamillesM[$j]["ville_Famille"];
        $jour=$lesBesoinsFamillesM[$j]["jour"];
        $heureDebut=$lesBesoinsFamillesM[$j]["heureDebut"];
        $heureFin=$lesBesoinsFamillesM[$j]["heureFin"];
        $frequence=$lesBesoinsFamillesM[$j]["frequence"];
        $PGE = $lesBesoinsFamillesM[$j]['PGE_Famille'];
        $PM = $lesBesoinsFamillesM[$j]['PM_Famille'];
        $nomFamille = $lesBesoinsFamillesM[$j]['nom_Parents'];
        $REG = $lesBesoinsFamillesM[$j]['REG_Famille'];


        if($jour=="sans importance"){
          $timeDebut    = explode(':', $heureDebut);
          $minutesDebut= ($timeDebut[0]*60) + ($timeDebut[1]) + ($timeDebut[2]/60);

          $timeFin    = explode(':', $heureFin);
          $minutesFin= ($timeFin[0]*60) + ($timeFin[1]) + ($timeFin[2]/60);
          
          $sommeL+=($minutesFin-$minutesDebut)/$frequence;

          $sansImportance.=$heureDebut."-".$heureFin."</br>";
          // echo $sommeL;
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
            $timeDebut    = explode(':', $heureDebut);
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
            $mercredi.="une semaine sur ".$frequence;
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
        $dateApourvoir=$lesBesoinsFamillesM[$j]["Date_aPourvoir_PM"];
        //Mise en forme des dates en date françaises
        $dateApourvoir=explode("-",$lesBesoinsFamillesM[$j]["Date_aPourvoir_PM"]);
        $dateApourvoir=$dateApourvoir[2]."-".$dateApourvoir[1]."-".$dateApourvoir[0];
        
      }
      
      
      
      
      //var_dump($numFamille);
      //var_dump($activite);
      //var_dump($heureDebut);
      //var_dump($heureFin);
    }
    
    
    
    
    
    /*}*/
    echo "</tbody>";
    echo "</table>";
    
    
    ?>
</div>



</body>
</html>




      <!--Vincent--> 
 <button class="button" onclick="topFunction()" id="topBtn"><img src="images/toTop.png" width="60"></button>




<!--Vincent bouton vers le haut de page
<button class="button" onclick="topFunction()" id="topBtn"><img src="../images/toTop.png" width="60"></button>
--> 

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
