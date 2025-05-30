
<?php 
/* *******************************************************
  Page de matching de toutes les familles et de leur match
********************************************************** */
if(lireDonneeUrl('action')=='voirMatchingFamilleGEMasque' || lireDonneeUrl('action')=='voirMatchingFamilleMenageMasque'){
  ?>
  <style>       
  table,td,th,tr{
  border: 1px solid black;
  text-align:center;
  }
  </style>
  <script>
    /*
      Fonction qui cache les tables des familles dont il y a des intervenants qui ont des besoins qui match
      mais dont aucun d'entre eux ne peux matcher à cause des paramètres de d'affinage (ex : besoin de voiture)
    */
    function hideTableAucunMatch(){
      //On calcul le nb de tables (y compris les tables cachées)
      var x = document.getElementsByClassName("tableInterv");
      var nbTable = x.length;
    
      for(let i=0 ; i < nbTable ; i++){
        //Récupère toute les tables
        var titleName = document.getElementById("title" + i);
        var tableName = document.getElementById("tableInterv" + i);
        if (tableName.hidden == true){
          continue;
        } 
        //On vérifie si la table possède des lignes <tr>
        var type = (typeof tableName.getElementsByClassName('ligneInterv')[0]);
        //Si il n'y a pas de ligne <tr>
        if(type === 'undefined'){
          //Cache le titre de la table
          titleName.hidden = true;
          //Cache la table
          tableName.hidden = true;
        } 
      }
    }
    </script>
  <?php

  if(lireDonneeUrl('action')=='voirMatchingFamilleGEMasque'){
    $tousIntervenantsDispo = $matching->obtenirAllnumFamilleBesoinsGE();
  }
  elseif(lireDonneeUrl('action')=='voirMatchingFamilleMenageMasque') {
    $tousIntervenantsDispo = $matching->obtenirAllnumFamilleBesoinsMenage();
  }
  

  $i=0;
  if(lireDonneeUrl('action')=='voirMatchingFamilleGEMasque'){
    echo "<legend>TABLEAU DE TOUTE LES FAMILLES ET DE LEUR MATCH - Garde d'enfants</legend>";
  }
  elseif(lireDonneeUrl('action')=='voirMatchingFamilleMenageMasque'){
    echo "<legend>TABLEAU DE TOUTE LES FAMILLES ET DE LEUR MATCH - Menage</legend>";
  }

    echo "<h5> Type de disponibilité :</h5>";
    echo str_repeat('&nbsp', 5);
    echo "<input type='checkbox' id='choixTabloInterv' style='height:15px; width:15px;' onchange='toggleTableDispo()' checked />Tableau des intervenants disponible";
    echo str_repeat('&nbsp', 5);
    echo "<input type='checkbox' id='choixTabloIntervRchCompl' style='height:15px; width:15px;' onchange='toggleTableRechCompl()' checked  />Tableau des intervenants avec l'option recherche heure compléments";
    echo str_repeat('<br/>', 2);  
    
    echo" 
    <fieldset>
      <h5> Précision du matching :</h5>
      <form id='paramMatching'>";
    echo str_repeat('&nbsp', 5);
    echo "
        <input type='radio' id='option1' name='option' style='height:15px; width:15px;' onchange='togglePrecisionUneDispo()' checked='checked' value='Au moins une dispos'>
          <label for='option1'>Au moins une dispos</label>";
    echo str_repeat('&nbsp', 5);
    echo " 
        <input type='radio' id='option2' name='option'  style='height:15px; width:15px;' onchange='togglePrecisionMoitieDispo()' value='Au moins la moitié des dispos'>
          <label for='option2'>Au moins la moitié des dispos</label>";
    echo str_repeat('&nbsp', 5);
    echo "
        <input type='radio' id='option3' name='option'  style='height:15px; width:15px;' onchange='togglePrecsionToutDispo()'value='Toutes les dispos'>
          <label for='option3'>Toutes les dispos</label>";
    echo " 
      </form>
    </fieldset>
    ";
    if(lireDonneeUrl('action')=='voirMatchingFamilleGEMasque'){
      echo "<p><a href='index.php?uc=annuFamille&action=voirMatchingFamilleGE'> Retour sur la page de matching </a></p>";
    }
    elseif(lireDonneeUrl('action')=='voirMatchingFamilleMenageMasque'){
      echo "<p><a href='index.php?uc=annuFamille&action=voirMatchingFamilleMenage'> Retour sur la page de matching </a></p>";
    }
    echo "<fieldset id ='uneDispo'>";
                      
  while($i<count($tousIntervenantsDispo)){
    $numFamille = $tousIntervenantsDispo[$i]['numero_famille'];
    if(lireDonneeUrl('action')=='voirMatchingFamilleGEMasque'){
      $lesIntervenantsDispo = $matching->obtenirIntervenantsDispoGE($numFamille);
      $lesIntervenantsRechCompl = $matching->obtenirIntervenantsRechComplGE($numFamille);
    }
    elseif(lireDonneeUrl('action')=='voirMatchingFamilleMenageMasque'){
      $lesIntervenantsDispo = $matching->obtenirIntervenantsDispoMenage($numFamille);
      $lesIntervenantsRechCompl = $matching->obtenirIntervenantsRechComplMenage($numFamille);
    }
    //var_dump($lesIntervenantsRechCompl);
    $nomFamille = $pdoChaudoudoux->obtenirNomFamille($numFamille);
    $bgColor = '#ffffff';
    $lastDispo ="";
    $lastDispoRechCompl = "";

    //On récupère toutes les informations de la famille à la position $i
    if(lireDonneeUrl('action')=='voirMatchingFamilleGEMasque'){
      $tousBesoinsFamille = $pdoChaudoudoux->obtenirBesoinsFamilleByNumGE($numFamille);
    }
    elseif(lireDonneeUrl('action')=='voirMatchingFamilleMenageMasque'){
      $tousBesoinsFamille = $pdoChaudoudoux->obtenirBesoinsFamilleByNumMenage($numFamille);
    }
    $tousInfosFamille = $pdoChaudoudoux->obtenirDetailFamille($numFamille);

    $enfantMoins2ans = false;
    $enfants=$pdoChaudoudoux->obtenirEnfantsFamille($numFamille);
    $age="";
    foreach ($enfants as $enfant){
      //On divise par 365 pour avoir le nb d'années
      $ageYear = intval($enfant["age"]/365);
      if($ageYear <= 2){
        $enfantMoins2ans = true;
        break;
      }
    }
    $vehicule_Famille = $tousInfosFamille['vehicule_Famille'];
    $enfantHand_Famille = $tousInfosFamille['enfantHand_Famille'];
    $repassage_Famille = $tousInfosFamille['repassage_Famille'];
    $ville_Famille = strtolower($tousInfosFamille['ville_Famille']);
    
    

    //On gère l'entête de chaque tableau
    if($lesIntervenantsDispo!=null || $lesIntervenantsRechCompl!=null){
      echo("<h4 id='title$i'> Famille : $nomFamille </h4>");
      echo("<h5 id='subTitle$i' style='color:#F7A594'; hidden></h5>");
      echo "<table id='tableInterv$i'   class='tableInterv'  style='width:100%; '>";
        echo "<thead>";
          echo "<th> Numéro de la famille </th>";
          echo "<th> Nom de la famille </th>";
          echo "<th> Numéro des intervenants </th>";
          echo "<th> Nom des intervenants </th>";
          echo "<th> Activité </th>";
          echo "<th> Besoins Famille </th>";
          echo "<th> Disponibilités Intervenant </th>";
          echo "<th> Fréquence de la prestation </th>";
          echo "<th> Démasquer l'intervenant </th>";
        echo "</thead>";
      echo "<tbody>";
    }
    //Les familles pour lesquelles il n'y a aucun besoin qui match sont dans des tableaux cachés
    else {
      echo "<table id='tableInterv$i' class='tableInterv'  hidden>";
        echo "<thead>";
        echo "</thead>";
      echo "<tbody>";
    }


    if($lesIntervenantsDispo!=null){ 
      $lastNumInterv = '';
      foreach ($lesIntervenantsDispo as $key => $unIntervenantDispo){
        $numInterv = $unIntervenantDispo['numero_Intervenant'];
        if($lastNumInterv == $numInterv){
          continue;
        }
        

        if($bgColor == '#ffffff'){
          $bgColor = '#e3e3e3';
        }
        elseif($bgColor == '#e3e3e3'){
          $bgColor = '#ffffff';
        }

        //Informations de base de l'intervenant
        $lastNumInterv = $numInterv;
        $nomCandidat = $unIntervenantDispo['nom_Candidats'];

        //On vérifie si l'intervenant est masqué pour la famille
        $estMasque = false;
        $verifIntervMasque = $pdoChaudoudoux->verifIntervMasque($numFamille, $numInterv);
        if(lireDonneeUrl('action')=='voirMatchingFamilleGEMasque'){
          if($verifIntervMasque == null){ 
            $estMasque = true;
          }
          else{
            if($verifIntervMasque['GE']==0){
              $estMasque = true;
            }
            
          }
        }
        elseif(lireDonneeUrl('action')=='voirMatchingFamilleMenageMasque'){
          if($verifIntervMasque == null){
            $estMasque = true;
          }
          else{
            if($verifIntervMasque['menage']==0){
              $estMasque = true;
            }
          }
        }
        //echo '<br/>', 'NumInterv : ', $numInterv, '  || numFamille : ', $numFamille, ' || ', $nomCandidat, ' || ', $estMasque;

        $numSalarie = $unIntervenantDispo['idSalarie_Intervenants'];
        $numCandidat = ($pdoChaudoudoux->obtenirNumCandidatByNumInterv($numInterv))['candidats_numcandidat_candidats'];
        $tousInfosIntervCand = $pdoChaudoudoux->obtenirDetailCandidat($numCandidat);
        $tousInfosInterv = $pdoChaudoudoux->obtenirDetailsSalarie($numInterv);
        //var_dump($tousInfosInterv);

        $vehicule_Candidats = $tousInfosIntervCand['vehicule_Candidats'] ;
        $expEnfantMoins2ans = $tousInfosIntervCand['expBBmoins1a_Candidats'];
        $enfantHand_Candidats = $tousInfosIntervCand['enfantHand_Candidats'];
        $repassage_Intervenants = $tousInfosInterv[0]['repassage_Intervenants'];
        $ville_Candidats = strtolower($tousInfosIntervCand['ville_Candidats']); 
        
        //On initial les disponibilités
        $jour = '' ; 
        $hDeb = '' ; 
        $hFin = '' ; 
        $frequence = '' ; 
        $activite = '' ; 
        $id = '' ; 

        // Affinage du matching : On vérifie si l'intervenant match sur les demandes de la famille 
        //(ex : voiture obligatoire, exp avec les enfants de moins de 3 ans etc)
        if($estMasque){
          if($bgColor == '#ffffff'){
            $bgColor = '#e3e3e3';
          }
          elseif($bgColor == '#e3e3e3'){
            $bgColor = '#ffffff';
          }
          continue;
        }

        if(lireDonneeUrl('action')=='voirMatchingFamilleGEMasque'){
          if($vehicule_Famille == 1){
            if($vehicule_Candidats !=1){
              //Appel d'une fonction qui cache les tables lorsque aucun intervenant ne passe l'affinage du matching
              //echo '<script>', 'hideTableAucunMatch();', '</script>';
              if($bgColor == '#ffffff'){
                $bgColor = '#e3e3e3';
              }
              elseif($bgColor == '#e3e3e3'){
                $bgColor = '#ffffff';
              }
              continue;
            }
          }
        
          if($enfantMoins2ans == true){
            if($expEnfantMoins2ans != 1){
              echo '<script>', 'hideTableAucunMatch();', '</script>';
              if($bgColor == '#ffffff'){
                $bgColor = '#e3e3e3';
              }
              elseif($bgColor == '#e3e3e3'){
                $bgColor = '#ffffff';
              }
              continue;
            }
          }
          
          if($enfantHand_Famille == 1){
            if($enfantHand_Candidats != 1){
              //echo '<script>', 'hideTableAucunMatch();', '</script>';
              if($bgColor == '#ffffff'){
                $bgColor = '#e3e3e3';
              }
              elseif($bgColor == '#e3e3e3'){
                $bgColor = '#ffffff';
              }
              continue;
            }
          }
        }
        if(lireDonneeUrl('action')=='voirMatchingFamilleMenageMasque'){
          if($repassage_Famille == 1){
            if($repassage_Intervenants != 1){
              //echo '<script>', 'hideTableAucunMatch();', '</script>';
              if($bgColor == '#ffffff'){
                $bgColor = '#e3e3e3';
              }
              elseif($bgColor == '#e3e3e3'){
                $bgColor = '#ffffff';
              }
              continue;
            }
          }
        }

        //On parcourt tout les besoins de la famille
        foreach($tousBesoinsFamille as $unBesoinFamille){
          $hDebFamille = $unBesoinFamille['heureDebut'];
          $hFinFamille = $unBesoinFamille['heureFin'];
          $jourF = $unBesoinFamille['jour'];
          $frequenceFamille = $unBesoinFamille['frequence'];
          $activiteFamille = $unBesoinFamille['activite'];
          $idBesoinFamille = $unBesoinFamille['id'];  
          //On recupère toutes les disponibilités de l'intervenant
          if(lireDonneeUrl('action')=='voirMatchingFamilleGEMasque'){
            $matchIntervenantDispo = $pdoChaudoudoux->obtenirToutDisposByNumIntervGE($numInterv);
          }
          elseif(lireDonneeUrl('action')=='voirMatchingFamilleMenageMasque'){
            $matchIntervenantDispo = $pdoChaudoudoux->obtenirToutDisposByNumIntervMenage($numInterv);
          }
          //On parcourt chacunes de ces dispos et on les compares à chaque besoin
          foreach($matchIntervenantDispo as $unMatch){ 
            if($jourF != 'sans importance'){
              if($unMatch['jour'] != $jourF){
                $jour = '' ; $hDeb = '' ; $hFin = '' ; $id = '';
                continue;
              }
            }
            if($unMatch['activite'] != $activiteFamille){ 
              $jour = '' ; $hDeb = '' ; $hFin = '' ; $id = '';
              continue;
            }
            elseif($unMatch['heureDebut'] > $hDebFamille){        
              $jour = '' ; $hDeb = '' ; $hFin = '' ; $id = '';
              continue;
            }
            elseif($unMatch['heureFin'] < $hFinFamille){ 
              $jour = '' ; $hDeb = '' ; $hFin = '' ; $id = '';          
              continue;
            }
            elseif( $unMatch['frequence'] != $frequenceFamille){             
              continue;
            }

            $jour = $unMatch['jour'];
            $activite = $unMatch['activite'];
            $hDeb = $unMatch['heureDebut'];
            $hFin = $unMatch['heureFin'];
            $frequence = $unMatch['frequence'];
            $id = $unMatch['id'];
            $dispo = "$jour - $hDeb à $hFin";
              
            //Si le jour du besoin n'est pas sans importance
            if($jourF != 'sans importance'){
              //On arrete la boucle
              break;
            }
            else{  //Sinon, permet d'afficher toutes les dispos qui match sans prendre en compte leur jour            
              $dispo = "<br/>".$dispo.$lastDispo;
              $lastDispo = $dispo;
            } 
          }
           
        $lastDispo = "";      
        echo "<tr style='background-color:$bgColor;color:#000000;' class='ligneInterv'>";
          echo "<td class='dispo'><a href='index.php?uc=annuFamille&action=voirDetailFamille&num=$numFamille '</a> $numFamille</td>";
          echo("<td class='dispo'><a href='index.php?uc=annuFamille&action=voirDetailFamille&num=$numFamille '</a> $nomFamille </td>");
          echo "<td class='dispo'><a href='index.php?uc=annuSalarie&action=voirDetailSalarie&amp;num=$numInterv'</a>".$numSalarie."</td>";
          echo "<td class='dispo nomCandidat'><a href='index.php?uc=annuSalarie&action=voirDetailSalarie&amp;num=$numInterv'</a>".$nomCandidat."</td>";
          echo "<td class='dispo'>".$activiteFamille." </td>";
          echo "<td class='dispo besoinsFamille'> ".$jourF." - ".$hDebFamille." à ".$hFinFamille." <br/><br/></td>";
          if ($jour == ''){
            echo "<td class='dispo dispoIntervenant'><br/><br/></td>";
          }
          else{                     
          echo "<td class='dispo dispoIntervenant'> $dispo <br/><br/></td>";
          }
          echo "<td class='dispo'> Une semaine sur ".$frequenceFamille."  </td>";
          if(lireDonneeUrl('action')=='voirMatchingFamilleGEMasque'){
            echo "<td class ='dispo'><a href='index.php?uc=annuFamille&action=demasquerIntervGE&amp;numInterv=$numInterv&amp;numFamille=$numFamille'</a> Démasquer </td>";
          }
          elseif(lireDonneeUrl('action')=='voirMatchingFamilleMenageMasque'){
            echo "<td class ='dispo'><a href='index.php?uc=annuFamille&action=demasquerIntervMenage&amp;numInterv=$numInterv&amp;numFamille=$numFamille'</a> Démasquer </td>";
          }
        echo '</tr>';
        
        }              
    }
  }

    
    if($lesIntervenantsRechCompl!=null){
      $lastNumInterv = '';
      foreach ($lesIntervenantsRechCompl as $unIntervenantRechCompl) {
        $numInterv = $unIntervenantRechCompl['numero_Intervenant'];
        if($lastNumInterv == $numInterv){
          continue;
        }

        if($bgColor == '#ffffff'){
          $bgColor = '#e3e3e3';
        }
        elseif($bgColor == '#e3e3e3'){
          $bgColor = '#ffffff';
        }
        //Informations de base de l'intervenant
        $lastNumInterv = $numInterv;  
        $nomCandidat=$unIntervenantRechCompl['nom_Candidats'];
        
        //On vérifie si l'intervenant est masqué pour la famille
        $estMasque = false;
        $verifIntervMasque = $pdoChaudoudoux->verifIntervMasque($numFamille, $numInterv);
        if(lireDonneeUrl('action')=='voirMatchingFamilleGEMasque'){
          if($verifIntervMasque == null){ 
            $estMasque = true;
          }
          else{
            if($verifIntervMasque['GE']==0){
              $estMasque = true;
            }
            
          }
        }
        elseif(lireDonneeUrl('action')=='voirMatchingFamilleMenageMasque'){
          if($verifIntervMasque == null){
            $estMasque = true;
          }
          else{
            if($verifIntervMasque['menage']==0){
              $estMasque = true;
            }
          }
        }
        //echo '<br/>', 'NumInterv : ', $numInterv, '  || numFamille : ', $numFamille, ' || ', $nomCandidat, " || ", $estMasque;
        
        $numSalarie=$unIntervenantRechCompl['idSalarie_Intervenants'];
        $numCandidat = ($pdoChaudoudoux->obtenirNumCandidatByNumInterv($numInterv))['candidats_numcandidat_candidats'];
        $tousInfosIntervCand = $pdoChaudoudoux->obtenirDetailCandidat($numCandidat);
        $tousInfosInterv = $pdoChaudoudoux->obtenirDetailsSalarie($numInterv);

        $vehicule_Candidats = $tousInfosIntervCand['vehicule_Candidats'] ;
        $expEnfantMoins2ans = $tousInfosIntervCand['expBBmoins1a_Candidats'];
        $enfantHand_Candidats = $tousInfosIntervCand['enfantHand_Candidats'];
        $repassage_Intervenants = $tousInfosInterv[0]['repassage_Intervenants'];
        $ville_Candidats = strtolower($tousInfosIntervCand['ville_Candidats']);

        $jour = ''; 
        $hDeb = ''; 
        $hFin = ''; 
        $frequence = ''; 
        $activite = ''; 
        $id = ''; 
        
        // Affinage du matching : On vérifie si l'intervenant match sur les demandes de la famille 
        //(ex : voiture obligatoire, exp avec les enfants de moins de 3 ans etc)
        if($estMasque){
          if($bgColor == '#ffffff'){
            $bgColor = '#e3e3e3';
          }
          elseif($bgColor == '#e3e3e3'){
            $bgColor = '#ffffff';
          }
          continue;
        }

        if(lireDonneeUrl('action')=='voirMatchingFamilleGEMasque'){
          if($vehicule_Famille == 1){
            if($vehicule_Candidats !=1){
              if($bgColor == '#ffffff'){
                $bgColor = '#e3e3e3';
              }
              elseif($bgColor == '#e3e3e3'){
                $bgColor = '#ffffff';
              }
              continue;
            }
          }
        
          if($enfantMoins2ans == true){
            if($expEnfantMoins2ans != 1){
              if($bgColor == '#ffffff'){
                $bgColor = '#e3e3e3';
              }
              elseif($bgColor == '#e3e3e3'){
                $bgColor = '#ffffff';
              }
              continue;
            }
          }
          
          if($enfantHand_Famille == 1){
            if($enfantHand_Candidats != 1){
              if($bgColor == '#ffffff'){
                $bgColor = '#e3e3e3';
              }
              elseif($bgColor == '#e3e3e3'){
                $bgColor = '#ffffff';
              }
              continue;
            }
          }
        }
        if(lireDonneeUrl('action')=='voirMatchingFamilleMenageMasque'){
          if($repassage_Famille == 1){
            if($repassage_Intervenants != 1){
              if($bgColor == '#ffffff'){
                $bgColor = '#e3e3e3';
              }
              elseif($bgColor == '#e3e3e3'){
                $bgColor = '#ffffff';
              }
              continue;
            }
          }
        }
        //On parcourt tout les besoins de la famille
        foreach($tousBesoinsFamille as $unBesoinFamille){
          $hDebFamille = $unBesoinFamille['heureDebut'];
          $hFinFamille = $unBesoinFamille['heureFin'];
          $jourF = $unBesoinFamille['jour'];
          $frequenceFamille = $unBesoinFamille['frequence'];
          $activiteFamille = $unBesoinFamille['activite'];
          $idBesoinFamille = $unBesoinFamille['id'];

          //On recupère toutes les disponibilités de l'intervenant
          if(lireDonneeUrl('action')=='voirMatchingFamilleGEMasque'){
            $matchIntervenantDispo = $pdoChaudoudoux->obtenirToutDisposByNumIntervGE($numInterv);
          }
          elseif(lireDonneeUrl('action')=='voirMatchingFamilleMenageMasque'){
            $matchIntervenantDispo = $pdoChaudoudoux->obtenirToutDisposByNumIntervMenage($numInterv);
          }
          //On parcourt chacunes de ces dispos et on les compares à chaque besoin
          foreach($matchIntervenantDispo as $unMatch){
            if($jourF != 'sans importance'){
              if($unMatch['jour'] != $jourF){
                  $jour = '' ; $hDeb = '' ; $hFin = '' ; $id = '';
                continue;
              }
            }
            if($unMatch['activite'] != $activiteFamille){ 
              $jour = '' ; $hDeb = '' ; $hFin = '' ; $id = '';
              continue;
            }
            elseif($unMatch['heureDebut'] > $hDebFamille){        
              $jour = '' ; $hDeb = '' ; $hFin = '' ; $id = '';
              continue;
            }
            elseif($unMatch['heureFin'] < $hFinFamille){ 
              $jour = '' ; $hDeb = '' ; $hFin = '' ; $id = '';        
              continue;
            }
            elseif( $unMatch['frequence'] != $frequenceFamille){             
              continue;
            }
        
            $jour = $unMatch['jour'];
            $activite = $unMatch['activite'];
            $hDeb = $unMatch['heureDebut'];
            $hFin = $unMatch['heureFin'];
            $frequence = $unMatch['frequence'];
            $id = $unMatch['id'];
            $dispo = "$jour - $hDeb à $hFin";
              
            //Si le jour du besoin n'est pas sans importance
            if($jourF != 'sans importance'){
              //On arrete la boucle
              break;
            }
            else{  //Sinon, permet d'afficher toutes les dispos qui match sans prendre en compte leur jour             
              $dispo = "<br/>".$dispo.$lastDispo;
              $lastDispo = $dispo;
            } 
          }

        $lastDispoRechCompl = "";  
         echo "<tr style='background-color:$bgColor;color:#000000;' class='ligneInterv'>";
          echo "<td class='rchCompl'><a href='index.php?uc=annuFamille&action=voirDetailFamille&num=$numFamille '</a> $numFamille</td>";
          echo("<td class='rchCompl'><a href='index.php?uc=annuFamille&action=voirDetailFamille&num=$numFamille '</a> $nomFamille </td>");
          echo "<td class='rchCompl'><a href='index.php?uc=annuSalarie&action=voirDetailSalarie&amp;num=$numInterv'</a>".$numSalarie."</td>";
          echo "<td class='rchCompl nomCandidat'><a href='index.php?uc=annuSalarie&action=voirDetailSalarie&amp;num=$numInterv'</a>".$nomCandidat."</td>";
          echo "<td class='rchCompl'>".$activiteFamille."</td>";
          echo "<td class='rchCompl besoinsFamille'> ".$jourF." - ".$hDebFamille." à ".$hFinFamille." <br/><br/></td>";
          if ($jour == ''){                   
            echo "<td class='rchCompl dispoIntervenant'><br/><br/></td>";
          }
          else {
            echo "<td class='rchCompl dispoIntervenant'>$dispo<br/><br/></td>";
          }
          echo "<td class='rchCompl'> Une semaine sur ".$frequenceFamille." </td>";
          if(lireDonneeUrl('action')=='voirMatchingFamilleGEMasque'){
            echo "<td class ='rchCompl'><a href='index.php?uc=annuFamille&action=demasquerIntervGE&amp;numInterv=$numInterv&amp;numFamille=$numFamille'</a> Démasquer </td>";
          }
          elseif(lireDonneeUrl('action')=='voirMatchingFamilleMenageMasque'){
            echo "<td class ='rchCompl'><a href='index.php?uc=annuFamille&action=demasquerIntervMenage&amp;numInterv=$numInterv&amp;numFamille=$numFamille'</a> Démasquer </td>";
          }
        echo '</tr>';
        }
      }          
    }
    if($lesIntervenantsDispo!=null || $lesIntervenantsRechCompl!=null){
      echo "</tbody>";
      echo "</table>";
      //Appel d'une fonction qui cache les tables lorsque aucun intervenant ne passe l'affinage du matching
      echo '<script>', 'hideTableAucunMatch();', '</script>';
      echo str_repeat("<br id='sautLigne$i'>", 2);
    }
    $i++;
  } //Fin du while

  echo "</fieldset>";








  ?>
  <script> 

  /**
   * Affiche / cahche les lignes du tableau de dispo d'intervenants qui NE SONT PAS en recherche complémentaire
   */
  function toggleTableDispo() {
    //On calcul le nb de tables (y compris les tables cachées)
    var x = document.getElementsByClassName("tableInterv");
    var nbTable = x.length;
  
    var $nbHiddenTable = 0;
    for(let i=0 ; i < nbTable ; i++){
      //Récupère toute les tables
      
      var tableName = document.getElementById("tableInterv" + i);
      if (tableName.hidden == true){
        continue;
      }
      
      //Récupère tous les titres
      var titleName = document.getElementById("title" + i);
      //Récupère toutes les balises <br>
      var sautLigneName = document.getElementById("sautLigne" + i);
      //Récupère les sous-titres des tables contenant les avrtissement
      var subTitle = document.getElementById('subTitle' + i);

      //On regarde s'il y a des éléments recherche complémentaire
      var cellsRechCompl = tableName.getElementsByClassName("rchCompl");
      //Si il y en a, on compte leur nb
      var nbCellsRechCompl = cellsRechCompl.length;
      
      //On récupère tous les disponibilités des intervenants qui NE SONT PAS en recherche complémentaire
      var cellsDispo = tableName.getElementsByClassName("dispo");
      //On parcourt les lignes <td> du tableau correspondantes

      

      for (let j = 0; j< cellsDispo.length; j++) {
        if (cellsDispo[j].style.display === "none") {
          cellsDispo[j].style.display = "table-cell";
        } 
        else {
          cellsDispo[j].style.display = "none";
        }
      }
      //S'IL N'Y A PAS de disponibilités d'intervenant en recherche complémentaire
      //On affiche/cache les lignes <td> du tableau
      if(nbCellsRechCompl==0){
        if(subTitle.textContent == ""){
          if (tableName.style.display === "none") {
          tableName.style.display = "table";
          } 
          else { 
          tableName.style.display = "none";
          }
          if (titleName.style.display === "none"){
            titleName.style.display = "initial";
          }
          else {
            titleName.style.display = "none";
          }
          if(sautLigneName.style.display === "none"){
            sautLigneName.style.display = "initial";
          }
          else {
            sautLigneName.style.display = "none";
          }
        }
        else{
          tableName.style.display = "none";
          sautLigneName.style.display = "none";
        }

          
      }
    }
  }


  /**
   * Affiche / cahche les lignes du tableau de dispo d'intervenants qui SONT en recherche complémentaire
   */
  function toggleTableRechCompl() {
    //On calcul le nb de tables (y compris les tables cachées)
    var x = document.getElementsByClassName("tableInterv");
    var nbTable = x.length;
    
    for(let i=0 ; i < nbTable ; i++){
      //Récupère toute les tables
      var tableName = document.getElementById("tableInterv" + i);
      if (tableName.hidden == true){
        continue;
      }
      //Récupère tous les titres
      var titleName = document.getElementById("title" + i);
      //Récupère toutes les balises <br>
      var sautLigneName = document.getElementById("sautLigne" + i);
      //Récupère les sous-titres des tables contenant les avrtissement
      var subTitle = document.getElementById('subTitle' + i);

      //On regarde s'il y a des éléments dispo
      var cellsDispo = tableName.getElementsByClassName("dispo");
      
      //Si il y en a, on compte leur nb
      var nbCellsDispo = cellsDispo.length;
        
      //On récupère tous les disponibilités des intervenants qui SONT en recherche complémentaire
      var cellsRechCompl = tableName.getElementsByClassName("rchCompl");
      //On parcourt les lignes <td> du tableau correspondantes
      for (let j = 0; j< cellsRechCompl.length; j++) {
        if (cellsRechCompl[j].style.display === "none") {
          cellsRechCompl[j].style.display = "table-cell";
        } 
        else {
          cellsRechCompl[j].style.display = "none";
        }
      }
      //S'IL Y A de disponibilités d'intervenant en recherche complémentaire
      //On affiche/cache les lignes <td> du tableau
      if(nbCellsDispo == 0){
        if(subTitle.textContent == ""){
          if (tableName.style.display === "none") {
          tableName.style.display = "table";
          } 
          else { 
          tableName.style.display = "none";
          }

          if (titleName.style.display === "none"){
            titleName.style.display = "initial";
          }
          else {
            titleName.style.display = "none";
          }

          if(sautLigneName.style.display === "none"){
            sautLigneName.style.display = "initial";
          }
          else {
            sautLigneName.style.display = "none";
          }
        }
        else{
          tableName.style.display = "none";
          sautLigneName.style.display = "none";
        }
      }
    }
  }

  function togglePrecisionUneDispo(){
    //On commence par reset les checkboxes pour eviter des problèmes d'entrecroisement lors de la manipulation de l'affichage
    var choixTabloInterv = document.getElementById('choixTabloInterv');
    var choixTabloIntervRchCompl = document.getElementById('choixTabloIntervRchCompl');
    if(choixTabloInterv.checked == false){
      choixTabloInterv.checked = true;
      toggleTableDispo();
    }
    if(choixTabloIntervRchCompl.checked == false){
      choixTabloIntervRchCompl.checked = true;
      toggleTableRechCompl();
    }
    //On calcul le nb de tables (y compris les tables cachées)
    var x = document.getElementsByClassName("tableInterv");
    var nbTable = x.length;
  
    for(let i=0 ; i < nbTable ; i++){
      //Récupère toute les tables
      var tableName = document.getElementById("tableInterv" + i);
      if (tableName.hidden == true){
        continue;
      }
      tableName.style.display = "table";
        
      //On récupère tout les besoins familles (un par ligne du tableau)
      var cellsBesoinsFamille = tableName.getElementsByClassName('besoinsFamille');
      //On récupère tout les noms des intervenants (un par ligne du tableau)
      var cellsNomIntervenant = tableName.getElementsByClassName('nomCandidat');
      //On récupère toutes les lignes <tr> du tableau
      var ligneInterv = tableName.getElementsByClassName('ligneInterv');
      //On intialise/reinitalise le nb de besoins à chaque table
      var nbCellsBesoinsFamille = 0;
      //Couleur du fond du tableau 
      var bgColor = '#ffffff';

      //On calcul le nb de besoins des familles
      for (let j = 0; j < cellsBesoinsFamille.length; j++){
        nbCellsBesoinsFamille+=1;
        
      }

      //On calcul le nb de lignes que prend un intervenant dans un tableau (il est similaire à tout les intervenants)
      var firstNomInterv = cellsNomIntervenant[0].textContent;
      var nbLigneInterv = 0;
      for (let j2 = 0; j2 < cellsNomIntervenant.length; j2++){
        if(cellsNomIntervenant[j2].textContent===firstNomInterv){
          //Nb de lignes ocuppées par un intervenant
          nbLigneInterv +=1;
        }
      }
      //On calcul le nb d'intervenants qu'il y a dans le tableau
      //             nombre de besoins / nb de lignes que prend un intervenant = nb d'intervenants
      var nbInterv = nbCellsBesoinsFamille / nbLigneInterv;

      //On parcourt toutes les lignes <tr> du tableau 
      for (let j3 = 0; j3 < ligneInterv.length ; j3++){
        //On récupère la dispos de la ligne à la position j3
        var dispoInterv = ligneInterv[j3].getElementsByClassName('dispoIntervenant');

        /* 
          Cette variable sert à vérifer quand on change d'intervenant dans le tableau
          Si le nb est un entier, cela signifie que l'on à parcourus le nb de lignes que prend un intervenant
          dans le tableau.
          On divise la position j3 par le nb de ligne que prend un intervenant, si le résultat est un entier
          c'est que l'on à passé le nb de ligne que prend un intervenant dans la position j3
        */
        var isIntJ3 = j3 / nbLigneInterv ;
        //On ne prend pas 0 car il sera toujours un entier et qu'il fausse le moment ou l'on change d'intervenant
        if (j3 != 0){
          /*
            Si le nb est un entier : toutes les lignes précedentes sur un intervalle égal au nb de ligne que prend un
            un intervenant jusqu'a la position j3 sont celles d'un intervenant
            On ne prend pas en compte le dernier j3 de la boucle car celle ci commence à 0, or, le calcul
            des lignes d'intervenant commence à 1. Le cas du dernier j3 sera pris en compte après
          */
          if(Number.isInteger(isIntJ3) && j3 != (ligneInterv.length)){ 
            //On alterne la couleur du fond
            if(bgColor == '#ffffff'){
              bgColor = '#e3e3e3';
            }
            else {
              bgColor = '#ffffff';
            }
            //On affiche les lignes
            for(let j4 = j3 - (nbCellsBesoinsFamille / nbInterv) ; j4 < j3 ; j4++){
              ligneInterv[j4].style.display = "table-row";
              ligneInterv[j4].style.backgroundColor = bgColor;
            }
          }
        }
        //Quand on arrive à la dernière itération, ajoute un cas qui vérifie la position j3+1
        //C'est à dire que cela reviens à avoir commencé la boucle à j3 = 1 et non 0
        if(j3 == (ligneInterv.length)-1){
          if(bgColor == '#ffffff'){
            bgColor = '#e3e3e3';
          }
          else {
            bgColor = '#ffffff';
          }
          for(let j4 = j3+1 - (nbCellsBesoinsFamille / nbInterv) ; j4 < j3+1 ; j4++){
            ligneInterv[j4].style.display = "table-row";
            ligneInterv[j4].style.backgroundColor = bgColor;
          } 
        }
      }
      var subTitle = document.getElementById('subTitle' + i);
      subTitle.hidden = true;
      subTitle.textContent = '';
    }
  }




  
  function togglePrecisionMoitieDispo(){
    //On commence par reset les checkboxes pour eviter des problèmes d'entrecroisement lors de la manipulation de l'affichage
    var choixTabloInterv = document.getElementById('choixTabloInterv');
    var choixTabloIntervRchCompl = document.getElementById('choixTabloIntervRchCompl');
    if(choixTabloInterv.checked == false){
      choixTabloInterv.checked = true;
      toggleTableDispo();
    }
    if(choixTabloIntervRchCompl.checked == false){
      choixTabloIntervRchCompl.checked = true;
      toggleTableRechCompl();
    }

     //On calcul le nb de tables (y compris les tables cachées)
    var x = document.getElementsByClassName("tableInterv");
    var nbTable = x.length;
    for(let i=0 ; i < nbTable ; i++){
      //Récupère toute les tables
      var tableName = document.getElementById("tableInterv" + i);
      
      if (tableName.hidden == true){
        continue;
      }
      
      tableName.style.display = "table";
      
      //Récupère tous les titres
      var titleName = document.getElementById("title" + i);
        
      //On récupère tout les besoins familles (un par ligne du tableau)
      var cellsBesoinsFamille = tableName.getElementsByClassName('besoinsFamille');
      //On récupère tout les noms des intervenants (un par ligne du tableau)
      var cellsNomIntervenant = tableName.getElementsByClassName('nomCandidat');
      //On récupère toutes les lignes <tr> du tableau
      var ligneInterv = tableName.getElementsByClassName('ligneInterv');
      //On intialise/reinitalise le nb de besoins à chaque table
      var nbCellsBesoinsFamille = 0;
      //Couleur du fond du tableau 
      var bgColor = '#ffffff';

      //On calcul le nb de besoins des familles
      for (let j = 0; j < cellsBesoinsFamille.length; j++){
        nbCellsBesoinsFamille+=1;
        
      }

      //On calcul le nb de lignes que prend un intervenant dans un tableau (il est similaire à tout les intervenants)
      var firstNomInterv = cellsNomIntervenant[0].textContent;
      var nbLigneInterv = 0;
      for (let j2 = 0; j2 < cellsNomIntervenant.length; j2++){
        if(cellsNomIntervenant[j2].textContent===firstNomInterv){
          //Nb de lignes ocuppées par un intervenant
          nbLigneInterv +=1;
        }
      }
      //On calcul le nb d'intervenants qu'il y a dans le tableau
      //             nombre de besoins / nb de lignes que prend un intervenant = nb d'intervenants
      var nbInterv = nbCellsBesoinsFamille / nbLigneInterv;

      //On initialise le nb de dispo qui match avec les besoins (différent pour chaque intervenant)
      var nbDispo = 0;
      var nbMatch = 0;

      //On parcourt toutes les lignes <tr> du tableau 
      for (let j3 = 0; j3 < ligneInterv.length ; j3++){
        //On récupère la dispos de la ligne à la position j3
        var dispoInterv = ligneInterv[j3].getElementsByClassName('dispoIntervenant');

        /* 
          Cette variable sert à vérifer quand on change d'intervenant dans le tableau
          Si le nb est un entier, cela signifie que l'on à parcourus le nb de lignes que prend un intervenant
          dans le tableau.
          On divise la position j3 par le nb de ligne que prend un intervenant, si le résultat est un entier
          c'est que l'on à passé le nb de ligne que prend un intervenant dans la position j3
        */
        var isIntJ3 = j3 / nbLigneInterv ;
        //On ne prend pas 0 car il sera toujours un entier et qu'il fausse le moment ou l'on change d'intervenant
        if (j3 != 0){
          /*
            Si le nb est un entier : toutes les lignes précedentes sur un intervalle égal au nb de ligne que prend un
            un intervenant jusqu'a la position j3 sont celles d'un intervenant
            On ne prend pas en compte le dernier j3 de la boucle car celle ci commence à 0, or, le calcul
            des lignes d'intervenant commence à 1. Le cas du dernier j3 sera pris en compte après
          */
         
          if(Number.isInteger(isIntJ3) && j3 != (ligneInterv.length)){ 
            //Si le nb de dispo est inférieur à la moitié du nb de besoins
            if(nbDispo < ((nbCellsBesoinsFamille / nbInterv)/2)){
              //On parcourt les lignes du tableau sur l'interval pour les cachées
              for(let j4 = j3 - (nbCellsBesoinsFamille / nbInterv) ; j4 < j3 ; j4++){
                ligneInterv[j4].style.display = "none";
              }
            }
            else{
              //On alterne la couleur du fond
              if(bgColor == '#ffffff'){
                bgColor = '#e3e3e3';
              }
              else {  
                bgColor = '#ffffff';
              }
              //On affiche les lignes
              for(let j4 = j3 - (nbCellsBesoinsFamille / nbInterv) ; j4 < j3 ; j4++){
                ligneInterv[j4].style.display = "table-row";
                ligneInterv[j4].style.backgroundColor = bgColor;
                nbMatch += 1;
              }
            }
            //On réinitialise le nbDispo pour le prochain intervenant
            nbDispo = 0 ;
          }
        }

        //On incrémente le nb de dispo tant que isIntJ3 n'est pas un entier
        //On né recupère que les dispo, les châines vides ne sont pas des dispos
        if (dispoInterv[0].textContent != ""){
            nbDispo+=1;
          }

        //Quand on arrive à la dernière itération, ajoute un cas qui vérifie la position j3+1
        //C'est à dire que cela reviens à avoir commencé la boucle à j3 = 1 et non 0
          
        if(j3 == (ligneInterv.length)-1){
          if(nbDispo < ((nbCellsBesoinsFamille / nbInterv)/2)){
              for(let j4 = j3+1 - (nbCellsBesoinsFamille / nbInterv) ; j4 < j3+1 ; j4++){
                ligneInterv[j4].style.display = "none";
              }
            }
            else{
              if(bgColor == '#ffffff'){
                bgColor = '#e3e3e3';
              }
              else {
                bgColor = '#ffffff';
              }
              for(let j4 = j3+1 - (nbCellsBesoinsFamille / nbInterv) ; j4 < j3+1 ; j4++){
                ligneInterv[j4].style.display = "table-row";
                ligneInterv[j4].style.backgroundColor = bgColor;
                nbMatch += 1;
              }
            }
          }
          /* */
      }
      var subTitle = document.getElementById('subTitle' + i);
      if(nbMatch == 0){
        subTitle.hidden = false;
        subTitle.textContent = "Aucun intervenant ne répond à au moins la moitié des besoins";
        tableName.style.display = "none";
      }
      else{
        subTitle.hidden = true;
        subTitle.textContent = '';
      }
    }

  }


  function togglePrecsionToutDispo(){
    //On commence par reset les checkboxes pour eviter des problèmes d'entrecroisement lors de la manipulation de l'affichage
    var choixTabloInterv = document.getElementById('choixTabloInterv');
    var choixTabloIntervRchCompl = document.getElementById('choixTabloIntervRchCompl');
    if(choixTabloInterv.checked == false){
      choixTabloInterv.checked = true;
      toggleTableDispo();
    }
    if(choixTabloIntervRchCompl.checked == false){
      choixTabloIntervRchCompl.checked = true;
      toggleTableRechCompl();
    }

    //On calcul le nb de tables (y compris les tables cachées)
    var x = document.getElementsByClassName("tableInterv");
    var nbTable = x.length;
  
    for(let i=0 ; i < nbTable ; i++){
      //Récupère toute les tables
      var tableName = document.getElementById("tableInterv" + i);
      if (tableName.hidden == true){
        continue;
      }
      tableName.style.display = "table";
        
      //On récupère tout les besoins familles (un par ligne du tableau)
      var cellsBesoinsFamille = tableName.getElementsByClassName('besoinsFamille');
      //On récupère tout les noms des intervenants (un par ligne du tableau)
      var cellsNomIntervenant = tableName.getElementsByClassName('nomCandidat');
      //On récupère toutes les lignes <tr> du tableau
      var ligneInterv = tableName.getElementsByClassName('ligneInterv');
      //On intialise/reinitalise le nb de besoins à chaque table
      var nbCellsBesoinsFamille = 0;
      //Couleur du fond du tableau 
      var bgColor = '#ffffff';

      //On calcul le nb de besoins des familles
      for (let j = 0; j < cellsBesoinsFamille.length; j++){
        nbCellsBesoinsFamille+=1;
        
      }

      //On calcul le nb de lignes que prend un intervenant dans un tableau (il est similaire à tout les intervenants)
      var firstNomInterv = cellsNomIntervenant[0].textContent;
      var nbLigneInterv = 0;
      for (let j2 = 0; j2 < cellsNomIntervenant.length; j2++){
        if(cellsNomIntervenant[j2].textContent===firstNomInterv){
          //Nb de lignes ocuppées par un intervenant
          nbLigneInterv +=1;
        }
      }
      //On calcul le nb d'intervenants qu'il y a dans le tableau
      //             nombre de besoins / nb de lignes que prend un intervenant = nb d'intervenants
      var nbInterv = nbCellsBesoinsFamille / nbLigneInterv;

      //On initialise le nb de dispo qui match avec les besoins (différent pour chaque intervenant)
      var nbDispo = 0;
      var nbMatch = 0;

      //On parcourt toutes les lignes <tr> du tableau 
      for (let j3 = 0; j3 < ligneInterv.length ; j3++){
        //On récupère la dispos de la ligne à la position j3
        var dispoInterv = ligneInterv[j3].getElementsByClassName('dispoIntervenant');

        /* 
          Cette variable sert à vérifer quand on change d'intervenant dans le tableau
          Si le nb est un entier, cela signifie que l'on à parcourus le nb de lignes que prend un intervenant
          dans le tableau.
          On divise la position j3 par le nb de ligne que prend un intervenant, si le résultat est un entier
          c'est que l'on à passé le nb de ligne que prend un intervenant dans la position j3
        */
        var isIntJ3 = j3 / nbLigneInterv ;
        //On ne prend pas 0 car il sera toujours un entier et qu'il fausse le moment ou l'on change d'intervenant
        if (j3 != 0){
          /*
            Si le nb est un entier : toutes les lignes précedentes sur un intervalle égal au nb de ligne que prend un
            un intervenant jusqu'a la position j3 sont celles d'un intervenant
            On ne prend pas en compte le dernier j3 de la boucle car celle ci commence à 0, or, le calcul
            des lignes d'intervenant commence à 1. Le cas du dernier j3 sera pris en compte après
          */
          if(Number.isInteger(isIntJ3) && j3 != (ligneInterv.length)){ 
            //Si le nb de dispo est inférieur au nb de besoins
            if(nbDispo < ((nbCellsBesoinsFamille / nbInterv))){
              //On parcourt les lignes du tableau sur l'interval pour les cachées
              for(let j4 = j3 - (nbCellsBesoinsFamille / nbInterv) ; j4 < j3 ; j4++){
                ligneInterv[j4].style.display = "none";
              }
            }
            else{
              //On alterne la couleur du fond
              if(bgColor == '#ffffff'){
                bgColor = '#e3e3e3';
              }
              else {
                bgColor = '#ffffff';
              }
              //On affiche les lignes
              for(let j4 = j3 - (nbCellsBesoinsFamille / nbInterv) ; j4 < j3 ; j4++){
                ligneInterv[j4].style.display = "table-row";
                ligneInterv[j4].style.backgroundColor = bgColor;
                nbMatch += 1;
              }
            }
            //On réinitialise le nbDispo pour le prochain intervenant
            nbDispo = 0 ;
          }
        }

        //On incrémente le nb de dispo tant que isIntJ3 n'est pas un entier
        //On né recupère que les dispo, les châines vides ne sont pas des dispos
        if (dispoInterv[0].textContent != ""){
            nbDispo+=1;
          }

        //Quand on arrive à la dernière itération, ajoute un cas qui vérifie la position j3+1
        //C'est à dire que cela reviens à avoir commencé la boucle à j3 = 1 et non 0
        if(j3 == (ligneInterv.length)-1){
          if(nbDispo < ((nbCellsBesoinsFamille / nbInterv))){
              for(let j4 = j3+1 - (nbCellsBesoinsFamille / nbInterv) ; j4 < j3+1 ; j4++){
                ligneInterv[j4].style.display = "none";
              }
            }
            else{
              if(bgColor == '#ffffff'){
                bgColor = '#e3e3e3';
              }
              else {
                bgColor = '#ffffff';
              }
              for(let j4 = j3+1 - (nbCellsBesoinsFamille / nbInterv) ; j4 < j3+1 ; j4++){
                ligneInterv[j4].style.display = "table-row";
                ligneInterv[j4].style.backgroundColor = bgColor;
                nbMatch += 1;
              }
            }
          }
      }
      var subTitle = document.getElementById('subTitle' + i);
      if(nbMatch == 0){
        subTitle.hidden = false;
        subTitle.textContent = "Aucun intervenant ne répond à l'intégralité des besoins";
        tableName.style.display = "none";
      }
      else{
        subTitle.hidden = true;
        subTitle.textContent = '';
      }
    }
  }
  
  </script>
  <?php
}