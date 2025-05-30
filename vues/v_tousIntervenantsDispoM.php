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
            $activite0="menage";

$nbIntervM=$pdoChaudoudoux->nbInterv($activite0);
?>


<div class="divCenter">

	



<div id="contenu">
<!--Différents titres des pages/tableaux en fonctions de la page actuelle-->
<h1 style="text-align: center">Intervenants <br>

<?php

if($action=='voirTousDispoIntervM'){echo 'leurs Disponibilités pour le ménage<br>';}
    echo count($nbIntervM);
  
  ?>
  RÉSULTAT<?php if(count($nbIntervM)>1){echo 'S';} ?>
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
  <th> Total des heures  </th>
  <th> Modification </th>
  <th> Suppression </th>
  <th> Dernière modification de la fiche </th>

</tr>
	</thead>

	<?php      

    echo "<tbody>";
    $lesDispoDuneInterv=$lesDispoIntervsM[0];
    $numeroInterv=$lesDispoIntervsM[0]['numero_Intervenant'];
    //echo $activite0;


    $creneaux = $pdoChaudoudoux->obtenirCreneaux("100360");
    /*
    foreach($creneaux as $unCreneau){
      var_dump($unCreneau); 
      echo "<br/><br/>";
      //var_dump($unCreneau); 
      echo "<br/><br/>";
    }*/
    //var_dump($creneaux); echo "<br/><br/>";
    
    for($j=0;$j<=count($lesDispoIntervsM);$j++){
      if($numeroInterv==$lesDispoIntervsM[$j]['numero_Intervenant']){

       //var_dump($lesDispoIntervsM[$j]);
        if($lesDispoIntervsM[$j]['activite']==$activite0){
          
          
          $numInterv = $lesDispoIntervsM[$j]["numero_Intervenant"];

          $idSalarie = $lesDispoIntervsM[$j]["idSalarie_Intervenants"];
          $jour = $lesDispoIntervsM[$j]["jour"];
          $heureDebut = $lesDispoIntervsM[$j]["heureDebut"];
          $heureFin = $lesDispoIntervsM[$j]["heureFin"];
          $frequence = $lesDispoIntervsM[$j]["frequence"];
          $nomInterv = $lesDispoIntervsM[$j]['nom_Candidats'];
          $villeInterv = $lesDispoIntervsM[$j]['ville_Candidats'];
          $quartierInterv = $lesDispoIntervsM[$j]['Quartier_Candidats'];
          $haveVehicule = $lesDispoIntervsM[$j]['vehicule_Candidats'];
          $enAttente = false;
          $dateModifIntervenant = $lesDispoIntervsM[$j]['dateModif_Intervenants'];
          if($haveVehicule == 1){
            $haveVehicule = 'Voiture';
          }
          else{
            $haveVehicule = '';
          }
          
          if($lesDispoIntervsM[$j]['repassage_Intervenants'] == 1){
            $repassage = 'Repassage';
          }
          else{
            $repassage = '';
          }

          
          $creneaux = $pdoChaudoudoux->obtenirCreneaux($numInterv); 
          
          if($jour == "lundi"){ $enPrestaLundi = false; }
          if($jour == "mardi"){ $enPrestaMardi = false; }
          if($jour == "mercredi"){ $enPrestaMercredi = false; }
          if($jour == "jeudi"){ $enPrestaJeudi = false; }
          if($jour == "vendredi"){ $enPrestaVendredi = false; }
          if($jour == "samedi"){ $enPrestaSamedi = false; }
          
          
          
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
                }
  
                if($timeHeureDeb > $timeHeureFinCreneau  ){
                  if($jour == "lundi"){ $enPrestaLundi = false; }
                  if($jour == "mardi"){ $enPrestamardi = false; }
                  if($jour == "mercredi"){ $enPrestaMercredi = false; }
                  if($jour == "jeudi"){ $enPrestaJeudi = true;  }
                  if($jour == "vendredi"){ $enPrestaVendredi = false; }
                  if($jour == "samedi"){ $enPrestaSamedi = false;  }
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
                  } 
                }
                else{
                  if($jour == "lundi"){ $enPrestaLundi = true; }
                  if($jour == "mardi"){ $enPrestamardi = true; }
                  if($jour == "mercredi"){ $enPrestaMercredi = true; }
                  if($jour == "jeudi"){ $enPrestaJeudi = true;  }
                  if($jour == "vendredi"){ $enPrestaVendredi = true; }
                  if($jour == "samedi"){ $enPrestaSamedi = true;  }
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
                  }
                }
                else{
                  if($jour == "lundi"){ $enPrestaLundi = true; }
                  if($jour == "mardi"){ $enPrestamardi = true; }
                  if($jour == "mercredi"){ $enPrestaMercredi = true; }
                  if($jour == "jeudi"){ $enPrestaJeudi = true;  }
                  if($jour == "vendredi"){ $enPrestaVendredi = true; }
                  if($jour == "samedi"){ $enPrestaSamedi = true;  }
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
                  }
                }
                else{
                  if($jour == "lundi"){ $enPrestaLundi = true; }
                  if($jour == "mardi"){ $enPrestamardi = true; }
                  if($jour == "mercredi"){ $enPrestaMercredi = true; }
                  if($jour == "jeudi"){ $enPrestaJeudi = true;  }
                  if($jour == "vendredi"){ $enPrestaVendredi = true; }
                  if($jour == "samedi"){ $enPrestaSamedi = true;  }

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
                   }
                  }
                  else{
                    if($jour == "lundi"){ $enPrestaLundi = true; }
                    if($jour == "mardi"){ $enPrestamardi = true; }
                    if($jour == "mercredi"){ $enPrestaMercredi = true; }
                    if($jour == "jeudi"){ $enPrestaJeudi = true;  }
                    if($jour == "vendredi"){ $enPrestaVendredi = true; }
                    if($jour == "samedi"){ $enPrestaSamedi = true;  }
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
                }
              }
            }
          }
          
          
          
          
          // echo $activite." </br>";
          
          if($jour=="lundi"){
            // $totalDuree = $heureDebut->add($heureFin);
            // echo $totalDuree;
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
            $timeDebut = explode(':', $heureDebut);
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
        
          //Style à affecter aux cellules <td> correspondants aux jours
          $tdStyleLundi = ""; $tdStyleMardi = ""; $tdStyleMercredi = ""; $tdStyleJeudi = ""; $tdStyleVendredi = ""; $tdStyleSamedi = "";
          if($enPrestaLundi){ $tdStyleLundi = "bgcolor='#FA8072'"; }
          if($enPrestamardi){ $tdStyleMardi = "bgcolor='#FA8072'"; }
          if($enPrestaMercredi){ $tdStyleMercredi = "bgcolor='#FA8072'";}
          if($enPrestaJeudi){ $tdStyleJeudi = "bgcolor='#FA8072'";}
          if($enPrestaVendredi){ $tdStyleVendredi = "bgcolor='#FA8072'";}
          if($enPrestaSamedi){ $tdStyleSamedi = "bgcolor='#FA8072'";}
        

        echo "<tr>";
        echo "<td><strong>".$idSalarie."</strong></td>";
        echo '<td><a href="index.php?uc=annuSalarie&action=voirDetailSalarie&num='.$numInterv.'"><strong>'.$nomInterv.'</strong></a></td>';
        echo "<td> $villeInterv </td>";
        echo "<td> $quartierInterv </td>";
        echo "<td> $haveVehicule </td>";
        echo "<td><p>$repassage</p></td>";
        echo "<td>MENAGE</td>";      
        
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
        $total=$sommeL+$sommeM+$sommeMe+$sommeJ+$sommeV+$sommeS;
        echo "<td><strong>".($total/60)."h</strong></td>";
        echo "<td> <a href='index.php?uc=annuSalarie&action=demanderModifSalarie&num=$numInterv'>Modifier</a></td>";
        echo "<td> <a href='index.php?uc=annuSalarie&action=supprimerAllDispoIntervMenage&num=$numInterv'>SUPPRIMER</a></td>";
        echo "<td>".$dateEUR."</td>";
        
        echo "</tr>";
        
        // echo "lundi :".$lundi."</br>";
        // echo "mardi :".$mardi."</br>";
        // echo "mercredi :".$mercredi."</br>";
        // echo "jeudi :".$jeudi."</br>";
        // echo "vendredi :".$vendredi."</br>";
        // echo "samedi :".$samedi."</br>";
        // echo "dimanche :".$dimanche."</br>";
      
        $lundi="";
        $mardi="";
        $mercredi="";
        $jeudi="";
        $vendredi="";
        $samedi="";
          
        $total=0;
        $sommeL=0;
        $sommeM=0;
        $sommeMe= 0;
        $sommeJ=0;
        $sommeV=0;
        $sommeS=0;

        $dateEUR='';
        $dateModifDispoFR='';

        $enPrestaLundi=false;
        $enPrestamardi=false;
        $enPrestaMercredi=false;
        $enPrestaMercredi=false;
        $enPrestaJeudi=false;
        $enPrestaVendredi=false;
        $enPrestaSamedi=false;

        $numeroInterv=$lesDispoIntervsM[$j]['numero_Intervenant'];
        $numInterv = $lesDispoIntervsM[$j]["numero_Intervenant"];
        $idSalarie=$lesDispoIntervsM[$j]["idSalarie_Intervenants"];
        $jour = $lesDispoIntervsM[$j]["jour"];
        $heureDebut = $lesDispoIntervsM[$j]["heureDebut"];
        $heureFin = $lesDispoIntervsM[$j]["heureFin"];
        $frequence = $lesDispoIntervsM[$j]["frequence"];
        $dateModifIntervenant = $lesDispoIntervsM[$j]['dateModif_Intervenants'];
        $nomInterv = $lesDispoIntervsM[$j]['nom_Candidats'];
        $villeInterv = $lesDispoIntervsM[$j]['ville_Candidats'];
        $quartierInterv = $lesDispoIntervsM[$j]['Quartier_Candidats'];
        $haveVehicule = $lesDispoIntervsM[$j]['vehicule_Candidats'];

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
                  } 
                }
                else{
                  if($jour == "lundi"){ $enPrestaLundi = true; }
                  if($jour == "mardi"){ $enPrestamardi = true; }
                  if($jour == "mercredi"){ $enPrestaMercredi = true; }
                  if($jour == "jeudi"){ $enPrestaJeudi = true;  }
                  if($jour == "vendredi"){ $enPrestaVendredi = true; }
                  if($jour == "samedi"){ $enPrestaSamedi = true;  }
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
                  }
                }
                else{
                  if($jour == "lundi"){ $enPrestaLundi = true; }
                  if($jour == "mardi"){ $enPrestamardi = true; }
                  if($jour == "mercredi"){ $enPrestaMercredi = true; }
                  if($jour == "jeudi"){ $enPrestaJeudi = true;  }
                  if($jour == "vendredi"){ $enPrestaVendredi = true; }
                  if($jour == "samedi"){ $enPrestaSamedi = true;  }
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
                  }
                }
                else{
                  if($jour == "lundi"){ $enPrestaLundi = true; }
                  if($jour == "mardi"){ $enPrestamardi = true; }
                  if($jour == "mercredi"){ $enPrestaMercredi = true; }
                  if($jour == "jeudi"){ $enPrestaJeudi = true;  }
                  if($jour == "vendredi"){ $enPrestaVendredi = true; }
                  if($jour == "samedi"){ $enPrestaSamedi = true;  }

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
                   }
                  }
                  else{
                    if($jour == "lundi"){ $enPrestaLundi = true; }
                    if($jour == "mardi"){ $enPrestamardi = true; }
                    if($jour == "mercredi"){ $enPrestaMercredi = true; }
                    if($jour == "jeudi"){ $enPrestaJeudi = true;  }
                    if($jour == "vendredi"){ $enPrestaVendredi = true; }
                    if($jour == "samedi"){ $enPrestaSamedi = true;  }
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

        if($lesDispoIntervsM[$j]['repassage_Intervenants'] == 1){
          $repassage = 'Repassage';
        }
        else{
          $repassage = '';
        }
                  
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
              continue;
            }
        }  
      }
    
    
    
    
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
