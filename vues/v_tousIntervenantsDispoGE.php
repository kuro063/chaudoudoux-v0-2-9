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


<?php error_reporting ( 0 ); 
            // $lesDispoIntervsM=$pdoChaudoudoux->obtenirDispoMInterv();
            // var_dump($lesDispoIntervsM);
            $activite0="garde d'enfants";

            $nbIntervGE=$pdoChaudoudoux->nbInterv($activite0);
?>


<div class="divCenter">

	



<div id="contenu">
<!--Différents titres des pages/tableaux en fonctions de la page actuelle-->
<h1 style="text-align: center">Intervenants <br>

<?php

if($action=='voirTousDispoIntervGE'){echo 'leurs Disponibilités pour la garde d\'enfants<br>';}
  echo count($nbIntervGE);
  
  ?>
 Résultat<?php if(count($nbIntervGE)>1){echo 'S';}?>
</h1>

<?php
//var_dump($lesDispoIntervsM);
?>



<table style='width:100%;border: solid 1px black;border-collapse:collapse;' class="sortable zebre">
	<thead> 
		
	<tr>
  <th> ID du salarié </th>
  

  <th> Nom de l'intervenant </th>
  <th> Ville de l'intervenant </th>
  <th> Quartier de l'intervenant </th>
  <th> Véhicule </th>
  <th> Spécificité </th>
  <th> Activité </th>

  <th> En attente </th>
  <th> Lundi  </th>
  <th> Mardi  </th>
  <th> Mercredi  </th>
  <th> Jeudi  </th>
  <th> Vendredi  </th>
  <th> Samedi  </th>
  <th> Dimanche  </th>
  <th> Total des heures  </th>
  <th> Modification </th>
  <th> Suppression </th>
  <th> Dernière modification de la fiche </th>
	
</tr>
	</thead>

	<?php      
    
    echo "<tbody>";
    $numeroInterv=$lesDispoIntervsGE[0]['numero_Intervenant'];
    //echo $activite0;
    
    for($j=0;$j<=count($lesDispoIntervsGE);$j++){
      
      if($numeroInterv==$lesDispoIntervsGE[$j]['numero_Intervenant']){
       //var_dump($lesDispoIntervsGE[$j]);
        if($lesDispoIntervsGE[$j]['activite']==$activite0){
          
          
          $numInterv = $lesDispoIntervsGE[$j]["numero_Intervenant"];
          $idSalarie= $lesDispoIntervsGE[$j]["idSalarie_Intervenants"];
          $jour = $lesDispoIntervsGE[$j]["jour"];
          $heureDebut = $lesDispoIntervsGE[$j]["heureDebut"];
          $heureFin = $lesDispoIntervsGE[$j]["heureFin"];
          $frequence = $lesDispoIntervsGE[$j]["frequence"];
          $nomInterv = $lesDispoIntervsGE[$j]['nom_Candidats'];
          $villeInterv = $lesDispoIntervsGE[$j]['ville_Candidats'];
          $quartierInterv = $lesDispoIntervsGE[$j]['Quartier_Candidats'];
          $haveVehicule = $lesDispoIntervsGE[$j]['vehicule_Candidats'];
          $enAttente = false;
          $dateModifIntervenant = $lesDispoIntervsGE[$j]['dateModif_Intervenants'];

          if($haveVehicule == 1){
            $haveVehicule = 'Voiture';
          }
          else{
            $haveVehicule = '';
          }
          if($lesDispoIntervsGE[$j]['expBBmoins1a_Candidats'] == 1){
            $expBBmoins1a = 'GE - 3ans';
          }
          else{
            $expBBmoins1a = '';
          }
          
          if($lesDispoIntervsGE[$j]['enfantHand_Candidats']==1){
            $enfantHand = 'Enfant handicapé';
          }
          else{
            $enfantHand = '';
          }

          $creneaux = $pdoChaudoudoux->obtenirCreneaux($numInterv); 
          
          if($jour == "lundi"){ $enPrestaLundi = false; }
          if($jour == "mardi"){ $enPrestaMardi = false; }
          if($jour == "mercredi"){ $enPrestaMercredi = false; }
          if($jour == "jeudi"){ $enPrestaJeudi = false; }
          if($jour == "vendredi"){ $enPrestaVendredi = false; }
          if($jour == "samedi"){ $enPrestaSamedi = false; }
          if($jour == "dimanche"){ $enPrestaDimanche = false;  }
          
          
          
          foreach($creneaux as $unCreneau){
            $jourCreneau = $unCreneau["jour_Proposer"];
            $heureDebCreneau = $unCreneau["hDeb_Proposer"];
            $heureFinCreneau = $unCreneau["hFin_Proposer"];
           
            if($jourCreneau == $jour){            
              // Heure de début
                $timeDeb = explode(':', $heureDebut);
                $timeHeureDeb = $timeDeb[0];
                $timeMinuteDeb = $timeDeb[1];

                $timeDebCreneau = explode(':', $heureDebCreneau);
                $timeHeureDebCreneau = $timeDebCreneau[0];
                $timeMinuteDebCreneau = $timeDebCreneau[1];

              // Heure de fin
                $timeFin = explode(':', $heureFin);
                $timeHeureFin = $timeFin[0];  
                $timeMinuteFin = $timeFin[1];

                $timeFinCreneau = explode(':', $heureFinCreneau);
                $timeHeureFinCreneau = $timeFinCreneau[0];
                $timeMinuteFinCreneau = $timeFinCreneau[1];
              
                if($timeHeureFin < $timeHeureDebCreneau){
                  if($jour == "lundi"){ $enPrestaLundi = false; }
                  if($jour == "mardi"){ $enPrestamardi = false; }
                  if($jour == "mercredi"){ $enPrestaMercredi = false; }
                  if($jour == "jeudi"){ $enPrestaJeudi = true;  }
                  if($jour == "vendredi"){ $enPrestaVendredi = false; }
                  if($jour == "samedi"){ $enPrestaSamedi = false;  }
                  if($jour == "dimanche"){ $enPrestaDimanche = false;  }
                }
  
                if($timeHeureDeb > $timeHeureFinCreneau  ){
                  if($jour == "lundi"){ $enPrestaLundi = false; }
                  if($jour == "mardi"){ $enPrestamardi = false; }
                  if($jour == "mercredi"){ $enPrestaMercredi = false; }
                  if($jour == "jeudi"){ $enPrestaJeudi = true;  }
                  if($jour == "vendredi"){ $enPrestaVendredi = false; }
                  if($jour == "samedi"){ $enPrestaSamedi = false;  }
                  if($jour == "dimanche"){ $enPrestaDimanche = false;  }
                }
              // Heure début dispo empiète sur heure début creneau
              if($timeHeureDeb <= $timeHeureDebCreneau){
                if($timeHeureDeb == $timeHeureDebCreneau){
                  if($timeMinuteDeb <= $timeMinuteDebCreneau){
                    if($jour == "lundi"){ $enPrestaLundi = true; }
                    if($jour == "mardi"){ $enPrestamardi = true; }
                    if($jour == "mercredi"){ $enPrestaMercredi = true; }
                    if($jour == "jeudi"){ $enPrestaJeudi = true;  }
                    if($jour == "vendredi"){ $enPrestaVendredi = true; }
                    if($jour == "samedi"){ $enPrestaSamedi = true;  }
                    if($jour == "dimanche"){ $enPrestaDimanche = true;  }
                  } 
                }
                else{
                  if($jour == "lundi"){ $enPrestaLundi = true; }
                  if($jour == "mardi"){ $enPrestamardi = true; }
                  if($jour == "mercredi"){ $enPrestaMercredi = true; }
                  if($jour == "jeudi"){ $enPrestaJeudi = true;  }
                  if($jour == "vendredi"){ $enPrestaVendredi = true; }
                  if($jour == "samedi"){ $enPrestaSamedi = true;  }
                  if($jour == "dimanche"){ $enPrestaDimanche = true;  }
                }
              }
              // Heure fin dispo empiète sur heure fin creneau
              if($timeHeureFin >= $timeHeureFinCreneau){
                if($timeHeureFin == $timeHeureFinCreneau){
                  if($timeMinuteFin >= $timeMinuteFinCreneau){
                    if($jour == "lundi"){ $enPrestaLundi = true; }
                    if($jour == "mardi"){ $enPrestamardi = true; }
                    if($jour == "mercredi"){ $enPrestaMercredi = true; }
                    if($jour == "jeudi"){ $enPrestaJeudi = true;  }
                    if($jour == "vendredi"){ $enPrestaVendredi = true; }
                    if($jour == "samedi"){ $enPrestaSamedi = true;  }
                    if($jour == "dimanche"){ $enPrestaDimanche = true;  }
                  }
                }
                else{
                  if($jour == "lundi"){ $enPrestaLundi = true; }
                  if($jour == "mardi"){ $enPrestamardi = true; }
                  if($jour == "mercredi"){ $enPrestaMercredi = true; }
                  if($jour == "jeudi"){ $enPrestaJeudi = true;  }
                  if($jour == "vendredi"){ $enPrestaVendredi = true; }
                  if($jour == "samedi"){ $enPrestaSamedi = true;  }
                  if($jour == "dimanche"){ $enPrestaDimanche = true;  }
                }
              }

              // Heure début dispo empiète sur heure fin creneau
              if($timeHeureDeb <= $timeHeureFinCreneau){
                if($timeHeureDeb == $timeHeureFinCreneau){
                  if($timeMinuteDeb <= $timeMinuteFinCreneau){
                    if($jour == "lundi"){ $enPrestaLundi = true; }
                    if($jour == "mardi"){ $enPrestamardi = true; }
                    if($jour == "mercredi"){ $enPrestaMercredi = true; }
                    if($jour == "jeudi"){ $enPrestaJeudi = true;  }
                    if($jour == "vendredi"){ $enPrestaVendredi = true; }
                    if($jour == "samedi"){ $enPrestaSamedi = true;  }
                    if($jour == "dimanche"){ $enPrestaDimanche = true;  }
                  }
                }
                else{
                  if($jour == "lundi"){ $enPrestaLundi = true; }
                  if($jour == "mardi"){ $enPrestamardi = true; }
                  if($jour == "mercredi"){ $enPrestaMercredi = true; }
                  if($jour == "jeudi"){ $enPrestaJeudi = true;  }
                  if($jour == "vendredi"){ $enPrestaVendredi = true; }
                  if($jour == "samedi"){ $enPrestaSamedi = true;  }
                  if($jour == "dimanche"){ $enPrestaDimanche = true;  }

                }
              }
              
              // Heure fin dispo empiète sur heure début creneau
              if($timeHeureFin >= $timeHeureDebCreneau){
                if($timeHeureDeb <= $timeHeureDebCreneau){
                  if($timeHeureFin == $timeHeureDebCreneau){
                    if($timeMinuteFin >= $timeMinuteDebCreneau){
                      if($jour == "lundi"){ $enPrestaLundi = true; }
                      if($jour == "mardi"){ $enPrestamardi = true; }
                      if($jour == "mercredi"){ $enPrestaMercredi = true; }
                      if($jour == "jeudi"){ $enPrestaJeudi = true;  }
                      if($jour == "vendredi"){ $enPrestaVendredi = true; }
                      if($jour == "samedi"){ $enPrestaSamedi = true;  }
                      if($jour == "dimanche"){ $enPrestaDimanche = true;  }
                   }
                  }
                  else{
                    if($jour == "lundi"){ $enPrestaLundi = true; }
                    if($jour == "mardi"){ $enPrestamardi = true; }
                    if($jour == "mercredi"){ $enPrestaMercredi = true; }
                    if($jour == "jeudi"){ $enPrestaJeudi = true;  }
                    if($jour == "vendredi"){ $enPrestaVendredi = true; }
                    if($jour == "samedi"){ $enPrestaSamedi = true;  }
                    if($jour == "dimanche"){ $enPrestaDimanche = true;  }
                  }
                }
              }

              if($timeHeureDebCreneau <= $timeHeureDeb){
                if($timeHeureFinCreneau >= $timeHeureDeb){
                  if($jour == "lundi"){ $enPrestaLundi = true; }
                  if($jour == "mardi"){ $enPrestamardi = true; }
                  if($jour == "mercredi"){ $enPrestaMercredi = true; }
                  if($jour == "jeudi"){ $enPrestaJeudi = true;  }
                  if($jour == "vendredi"){ $enPrestaVendredi = true; }
                  if($jour == "samedi"){ $enPrestaSamedi = true;  }
                  if($jour == "dimanche"){ $enPrestaDimanche = true;  }
                }
              }
            }
          }


          // echo $activite." </br>";
                    
          if($jour=="lundi"){
            $timeDebut    = explode(':', $heureDebut);
            $minutesDebut= ($timeDebut[0]*60) + ($timeDebut[1]) + ($timeDebut[2]/60);

            $timeFin    = explode(':', $heureFin);
            $minutesFin= ($timeFin[0]*60) + ($timeFin[1]) + ($timeFin[2]/60);
            
            if ($timeFin[0] <= $timeDebut[0]){$minutesFin+=1440;}
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
            
            if ($timeFin[0] <= $timeDebut[0]){$minutesFin+=1440;}
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
            
            if ($timeFin[0] <= $timeDebut[0]){$minutesFin+=1440;}
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
            
            if ($timeFin[0] <= $timeDebut[0]){$minutesFin+=1440;}
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
            
            if ($timeFin[0] <= $timeDebut[0]){$minutesFin+=1440;}
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
            
            if ($timeFin[0] <= $timeDebut[0]){$minutesFin+=1440;}
            $sommeS+=($minutesFin-$minutesDebut)/$frequence;
            $samedi.=$heureDebut."-".$heureFin."</br>";
          // echo $sommeS;
          if($frequence!=1){
            $samedi.="une semaine sur ".$frequence."</br>";
          }
          
        }
        elseif($jour=="dimanche"){   
            //Les disponibilités de 1h01 à 1h01 ne doivent pas être affichées car elles ne servent qu'as
            //faire remonter les intervenants dans la page de disponbilités
            if($heureDebut == "01:01:00" && $heureFin == "01:01:00"){
              $enAttente = true;
            }
            else{ 
              $timeDebut    = explode(':', $heureDebut);
              $minutesDebut= ($timeDebut[0]*60) + ($timeDebut[1]) + ($timeDebut[2]/60);

              $timeFin    = explode(':', $heureFin);
              $minutesFin= ($timeFin[0]*60) + ($timeFin[1]) + ($timeFin[2]/60);
              
              if ($timeFin[0] <= $timeDebut[0]){$minutesFin+=1440;}
              $sommeD+=($minutesFin-$minutesDebut)/$frequence;

              $dimanche.=$heureDebut."-".$heureFin."</br>";
              // echo $sommeD;
              if($frequence!=1){  
                $dimanche.="une semaine sur ".$frequence."</br>";
              }
            }
          }
          $dateSeparateur = explode(' ', $dateModifIntervenant);
          if ($dateSeparateur[2]=='Jan') { $date_mois = '01';}
          elseif ($dateSeparateur[2]=='Feb') { $date_mois = '02';}
          elseif ($dateSeparateur[2]=='Mar') { $date_mois = '03';}
          elseif ($dateSeparateur[2]=='Apr') { $date_mois = '04';}
          elseif ($dateSeparateur[2]=='May') { $date_mois = '05';}
          elseif ($dateSeparateur[2]=='Jun') { $date_mois = '06';}
          elseif ($dateSeparateur[2]=='Jul') { $date_mois = '07';}
          elseif ($dateSeparateur[2]=='Aug') { $date_mois = '08';}
          elseif ($dateSeparateur[2]=='Sep') { $date_mois = '09';}
          elseif ($dateSeparateur[2]=='Oct') { $date_mois = '10';}
          elseif ($dateSeparateur[2]=='Nov') { $date_mois = '11';}
          elseif ($dateSeparateur[2]=='Dec') { $date_mois = '12';}

          $dateEUR = $dateSeparateur[1].'/'.$date_mois.'/'.$dateSeparateur[3];
          
        }
      }else{
        $tdStyleLundi = ""; $tdStyleMardi = ""; $tdStyleMercredi = ""; $tdStyleJeudi = ""; $tdStyleVendredi = ""; $tdStyleSamedi = ""; $tdStyleDimanche = "";
          if($enPrestaLundi){ $tdStyleLundi = "bgcolor='#FA8072	'"; }
          if($enPrestamardi){ $tdStyleMardi = "bgcolor='#FA8072'"; }
          if($enPrestaMercredi){ $tdStyleMercredi = "bgcolor='#FA8072'";}
          if($enPrestaJeudi){ $tdStyleJeudi = "bgcolor='#FA8072'";}
          if($enPrestaVendredi){ $tdStyleVendredi = "bgcolor='#FA8072'";}
          if($enPrestaSamedi){ $tdStyleSamedi = "bgcolor='#FA8072'";}
          if($enPrestaDimanche){ $tdStyleDimanche = "bgcolor='#FA8072'";}
        
        echo "<tr>";
        echo "<td><strong>".$idSalarie."</strong></td>";
        echo '<td><a href="index.php?uc=annuSalarie&action=voirDetailSalarie&num='.$numInterv.'"><strong>'.$nomInterv.'</strong></a></td>';
        echo "<td> $villeInterv </td>";
        echo "<td> $quartierInterv </td>";
        echo "<td> $haveVehicule </td>";
        echo "<td><p> $expBBmoins1a </p><p>$enfantHand</p></td>";
        echo "<td>GE</td>";      
        
        if($enAttente){
          echo "<td> Oui </td>";
        }
        else{
          echo "<td> </td>";
        }
        echo "<td ".$tdStyleLundi.">".$lundi."</td>";
        echo "<td ".$tdStyleMardi.">".$mardi."</td>";
        echo "<td ".$tdStyleMercredi.">".$mercredi."</td>";
        echo "<td ".$tdStyleJeudi.">".$jeudi."</td>";
        echo "<td ".$tdStyleVendredi.">".$vendredi."</td>";
        echo "<td ".$tdStyleSamedi.">".$samedi."</td>";
        echo "<td ".$tdStyleDimanche.">".$dimanche."</td>";
        $total=$sommeL+$sommeM+$sommeMe+$sommeJ+$sommeV+$sommeS+$sommeD;
        echo "<td><strong>".($total/60)."h</strong></td>";
        echo "<td> <a href='index.php?uc=annuSalarie&action=demanderModifSalarie&num=$numInterv'>Modifier</a></td>";
        echo "<td> <a href='index.php?uc=annuSalarie&action=supprimerAllDispoIntervGE&num=$numInterv'>SUPPRIMER</a></td>";
        echo "<td>".$dateEUR."</td>";

        echo "</tr>";
        
      
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
        $sommeMe=0;
        $sommeJ=0;
        $sommeV=0;
        $sommeS=0;
        $sommeD=0;

        $dateEUR='';
        $dateModifDispoFR='';

        $enPrestaLundi=false;
        $enPrestamardi=false;
        $enPrestaMercredi=false;
        $enPrestaMercredi=false;
        $enPrestaJeudi=false;
        $enPrestaVendredi=false;
        $enPrestaSamedi=false;
        $enPrestaDimanche=false;
        
        $numeroInterv=$lesDispoIntervsGE[$j]['numero_Intervenant'];
        $numInterv = $lesDispoIntervsGE[$j]["numero_Intervenant"];
        $idSalarie= $lesDispoIntervsGE[$j]["idSalarie_Intervenants"];
        $jour = $lesDispoIntervsGE[$j]["jour"];
        $heureDebut = $lesDispoIntervsGE[$j]["heureDebut"];
        $heureFin = $lesDispoIntervsGE[$j]["heureFin"];
        $frequence = $lesDispoIntervsGE[$j]["frequence"];
        $nomInterv = $lesDispoIntervsGE[$j]['nom_Candidats'];
        $villeInterv = $lesDispoIntervsGE[$j]['ville_Candidats'];
        $enAttente = false;
        $dateModifIntervenant = $lesDispoIntervsGE[$j]['dateModif_Intervenants'];
        $quartierInterv = $lesDispoIntervsGE[$j]['Quartier_Candidats'];
        $haveVehicule = $lesDispoIntervsGE[$j]['vehicule_Candidats'];

        $dateSeparateur = explode(' ', $dateModifIntervenant);
        if ($dateSeparateur[2]=='Jan') { $date_mois = '01';}
          elseif ($dateSeparateur[2]=='Feb') { $date_mois = '02';}
          elseif ($dateSeparateur[2]=='Mar') { $date_mois = '03';}
          elseif ($dateSeparateur[2]=='Apr') { $date_mois = '04';}
          elseif ($dateSeparateur[2]=='May') { $date_mois = '05';}
          elseif ($dateSeparateur[2]=='Jun') { $date_mois = '06';}
          elseif ($dateSeparateur[2]=='Jul') { $date_mois = '07';}
          elseif ($dateSeparateur[2]=='Aug') { $date_mois = '08';}
          elseif ($dateSeparateur[2]=='Sep') { $date_mois = '09';}
          elseif ($dateSeparateur[2]=='Oct') { $date_mois = '10';}
          elseif ($dateSeparateur[2]=='Nov') { $date_mois = '11';}
          elseif ($dateSeparateur[2]=='Dec') { $date_mois = '12';}

        $dateEUR = $dateSeparateur[1].'/'.$date_mois.'/'.$dateSeparateur[3];

        $creneaux = $pdoChaudoudoux->obtenirCreneaux($numInterv); 
          
          if($jour == "lundi"){ $enPrestaLundi = false; }
          if($jour == "mardi"){ $enPrestaMardi = false; }
          if($jour == "mercredi"){ $enPrestaMercredi = false; }
          if($jour == "jeudi"){ $enPrestaJeudi = false; }
          if($jour == "vendredi"){ $enPrestaVendredi = false; }
          if($jour == "samedi"){ $enPrestaSamedi = false; }
          if($jour == "dimanche"){ $enPrestaDimanche = false;  }
          
          
          
          foreach($creneaux as $unCreneau){
            $jourCreneau = $unCreneau["jour_Proposer"];
            $heureDebCreneau = $unCreneau["hDeb_Proposer"];
            $heureFinCreneau = $unCreneau["hFin_Proposer"];
           
            if($jourCreneau == $jour){            
              // Heure de début
                $timeDeb = explode(':', $heureDebut);
                $timeHeureDeb = $timeDeb[0];
                $timeMinuteDeb = $timeDeb[1];

                $timeDebCreneau = explode(':', $heureDebCreneau);
                $timeHeureDebCreneau = $timeDebCreneau[0];
                $timeMinuteDebCreneau = $timeDebCreneau[1];

              // Heure de fin
                $timeFin = explode(':', $heureFin);
                $timeHeureFin = $timeFin[0];  
                $timeMinuteFin = $timeFin[1];

                $timeFinCreneau = explode(':', $heureFinCreneau);
                $timeHeureFinCreneau = $timeFinCreneau[0];
                $timeMinuteFinCreneau = $timeFinCreneau[1];
              
                if($timeHeureDeb >= $timeHeureFinCreneau  ){
                  if($jour == "lundi"){ $enPrestaLundi = false; }
                  if($jour == "mardi"){ $enPrestamardi = false; }
                  if($jour == "mercredi"){ $enPrestaMercredi = false; }
                  if($jour == "jeudi"){ $enPrestaJeudi = true;  }
                  if($jour == "vendredi"){ $enPrestaVendredi = false; }
                  if($jour == "samedi"){ $enPrestaSamedi = false;  }
                  if($jour == "dimanche"){ $enPrestaDimanche = false;  }
                  break;
                }
              
              // Heure début dispo empiète sur heure début creneau
              if($timeHeureDeb <= $timeHeureDebCreneau){
                if($timeHeureDeb == $timeHeureDebCreneau){
                  if($timeMinuteDeb <= $timeMinuteDebCreneau){
                    if($jour == "lundi"){ $enPrestaLundi = true; }
                    if($jour == "mardi"){ $enPrestamardi = true; }
                    if($jour == "mercredi"){ $enPrestaMercredi = true; }
                    if($jour == "jeudi"){ $enPrestaJeudi = true;  }
                    if($jour == "vendredi"){ $enPrestaVendredi = true; }
                    if($jour == "samedi"){ $enPrestaSamedi = true;  }
                    if($jour == "dimanche"){ $enPrestaDimanche = true;  }
                  } 
                }
                else{
                  if($jour == "lundi"){ $enPrestaLundi = true; }
                  if($jour == "mardi"){ $enPrestamardi = true; }
                  if($jour == "mercredi"){ $enPrestaMercredi = true; }
                  if($jour == "jeudi"){ $enPrestaJeudi = true;  }
                  if($jour == "vendredi"){ $enPrestaVendredi = true; }
                  if($jour == "samedi"){ $enPrestaSamedi = true;  }
                  if($jour == "dimanche"){ $enPrestaDimanche = true;  }
                }
              }
              // Heure fin dispo empiète sur heure fin creneau
              if($timeHeureFin >= $timeHeureFinCreneau){
                if($timeHeureFin == $timeHeureFinCreneau){
                  if($timeMinuteFin >= $timeMinuteFinCreneau){
                    if($jour == "lundi"){ $enPrestaLundi = true; }
                    if($jour == "mardi"){ $enPrestamardi = true; }
                    if($jour == "mercredi"){ $enPrestaMercredi = true; }
                    if($jour == "jeudi"){ $enPrestaJeudi = true;  }
                    if($jour == "vendredi"){ $enPrestaVendredi = true; }
                    if($jour == "samedi"){ $enPrestaSamedi = true;  }
                    if($jour == "dimanche"){ $enPrestaDimanche = true;  }
                  }
                }
                else{
                  if($jour == "lundi"){ $enPrestaLundi = true; }
                  if($jour == "mardi"){ $enPrestamardi = true; }
                  if($jour == "mercredi"){ $enPrestaMercredi = true; }
                  if($jour == "jeudi"){ $enPrestaJeudi = true;  }
                  if($jour == "vendredi"){ $enPrestaVendredi = true; }
                  if($jour == "samedi"){ $enPrestaSamedi = true;  }
                  if($jour == "dimanche"){ $enPrestaDimanche = true;  }
                }
              }

              // Heure début dispo empiète sur heure fin creneau
              if($timeHeureDeb <= $timeHeureFinCreneau){
                if($timeHeureDeb == $timeHeureFinCreneau){
                  if($timeMinuteDeb <= $timeMinuteFinCreneau){
                    if($jour == "lundi"){ $enPrestaLundi = true; }
                    if($jour == "mardi"){ $enPrestamardi = true; }
                    if($jour == "mercredi"){ $enPrestaMercredi = true; }
                    if($jour == "jeudi"){ $enPrestaJeudi = true;  }
                    if($jour == "vendredi"){ $enPrestaVendredi = true; }
                    if($jour == "samedi"){ $enPrestaSamedi = true;  }
                    if($jour == "dimanche"){ $enPrestaDimanche = true;  }
                  }
                }
                else{
                  if($jour == "lundi"){ $enPrestaLundi = true; }
                  if($jour == "mardi"){ $enPrestamardi = true; }
                  if($jour == "mercredi"){ $enPrestaMercredi = true; }
                  if($jour == "jeudi"){ $enPrestaJeudi = true;  }
                  if($jour == "vendredi"){ $enPrestaVendredi = true; }
                  if($jour == "samedi"){ $enPrestaSamedi = true;  }
                  if($jour == "dimanche"){ $enPrestaDimanche = true;  }

                }
              }
              
              // Heure fin dispo empiète sur heure début creneau
              if($timeHeureFin >= $timeHeureDebCreneau){
                if($timeHeureDeb <= $timeDebCreneau){
                  if($timeHeureFin == $timeHeureDebCreneau){
                    if($timeMinuteFin >= $timeMinuteDebCreneau){
                      if($jour == "lundi"){ $enPrestaLundi = true; }
                      if($jour == "mardi"){ $enPrestamardi = true; }
                      if($jour == "mercredi"){ $enPrestaMercredi = true; }
                      if($jour == "jeudi"){ $enPrestaJeudi = true;  }
                      if($jour == "vendredi"){ $enPrestaVendredi = true; }
                      if($jour == "samedi"){ $enPrestaSamedi = true;  }
                      if($jour == "dimanche"){ $enPrestaDimanche = true;  }
                   }
                  }
                  else{
                    if($jour == "lundi"){ $enPrestaLundi = true; }
                    if($jour == "mardi"){ $enPrestamardi = true; }
                    if($jour == "mercredi"){ $enPrestaMercredi = true; }
                    if($jour == "jeudi"){ $enPrestaJeudi = true;  }
                    if($jour == "vendredi"){ $enPrestaVendredi = true; }
                    if($jour == "samedi"){ $enPrestaSamedi = true;  }
                    if($jour == "dimanche"){ $enPrestaDimanche = true;  }
                  }
                }
              }

              if($timeDebCreneau <= $timeHeureDeb){
                if($timeFinCreneau >= $timeHeureDeb){
                  if($jour == "lundi"){ $enPrestaLundi = true; }
                  if($jour == "mardi"){ $enPrestamardi = true; }
                  if($jour == "mercredi"){ $enPrestaMercredi = true; }
                  if($jour == "jeudi"){ $enPrestaJeudi = true;  }
                  if($jour == "vendredi"){ $enPrestaVendredi = true; }
                  if($jour == "samedi"){ $enPrestaSamedi = true;  }
                  if($jour == "dimanche"){ $enPrestaDimanche = true;  }
                }
              }
            }
          }
          

          if($haveVehicule == 1){
            $haveVehicule = 'Voiture';
          }
          else{
            $haveVehicule = '';
          }
          if($lesDispoIntervsGE[$j]['expBBmoins1a_Candidats'] == 1){
            $expBBmoins1a = 'GE - 3ans';
          }
          else{
            $expBBmoins1a = '';
          }
          
          if($lesDispoIntervsGE[$j]['enfantHand_Candidats']==1){
            $enfantHand = 'Enfant handicapé';
          }
          else{
            $enfantHand = '';
          }
  
          // echo $activite." </br>";
          if($jour=="lundi"){
            $timeDebut    = explode(':', $heureDebut);
            $minutesDebut= ($timeDebut[0]*60) + ($timeDebut[1]) + ($timeDebut[2]/60);

            $timeFin    = explode(':', $heureFin);
            $minutesFin= ($timeFin[0]*60) + ($timeFin[1]) + ($timeFin[2]/60);
            
            if ($timeFin[0] <= $timeDebut[0]){$minutesFin+=1440;}
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
            
            if ($timeFin[0] <= $timeDebut[0]){$minutesFin+=1440;}
            $sommeM+=($minutesFin-$minutesDebut)/$frequence;
            $mardi.=$heureDebut."-".$heureFin."</br>";
          //  echo $sommeM;
          if($frequence!=1){
            $mardi.="une semaine sur ".$frequence."</br>";
          }
        }
        elseif($jour=="mercredi"){
            $timeDebut    = explode(':', $heureDebut);
            $minutesDebut = ($timeDebut[0]*60) + ($timeDebut[1]) + ($timeDebut[2]/60);

            $timeFin    = explode(':', $heureFin);
            $minutesFin= ($timeFin[0]*60) + ($timeFin[1]) + ($timeFin[2]/60);
            
            if ($timeFin[0] <= $timeDebut[0]){$minutesFin+=1440;}
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
            
            if ($timeFin[0] <= $timeDebut[0]){$minutesFin+=1440;}
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
            
            if ($timeFin[0] <= $timeDebut[0]){$minutesFin+=1440;}
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
            
            if ($timeFin[0] <= $timeDebut[0]){$minutesFin+=1440;}
            $sommeS+=($minutesFin-$minutesDebut)/$frequence;
            $samedi.=$heureDebut."-".$heureFin."</br>";
          // echo $sommeS;
          if($frequence!=1){
            $samedi.="une semaine sur ".$frequence."</br>";
          }
          
        }
        elseif($jour=="dimanche"){
          //Les disponibilités de 1h01 à 1h01 ne doivent pas être affichées car elles ne servent qu'as
          //faire remonter les intervenants dans la page de disponbilités 
          if($heureDebut == "01:01:00" && $heureFin == "01:01:00"){
            $enAttente = true;
           continue;
          }
            else{
              $timeDebut    = explode(':', $heureDebut);
              $minutesDebut= ($timeDebut[0]*60) + ($timeDebut[1]) + ($timeDebut[2]/60);

              $timeFin    = explode(':', $heureFin);
              $minutesFin= ($timeFin[0]*60) + ($timeFin[1]) + ($timeFin[2]/60);
              
              if ($timeFin[0] <= $timeDebut[0]){$minutesFin+=1440;}
              $sommeD+=($minutesFin-$minutesDebut)/$frequence;

              $dimanche.=$heureDebut."-".$heureFin."</br>";
            // echo $sommeD;
            if($frequence!=1){
              $dimanche.="une semaine sur ".$frequence."</br>";
            }
          }
        } 
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
