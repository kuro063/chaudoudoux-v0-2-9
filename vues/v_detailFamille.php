<?php
/* La directive @var permet de déclarer une variable créée dans un script séparé 
 * du présent script, et ainsi de bénéficier de l'auto-complétion sur cette variable
 */
/* @var $etudiant array
 */


?>
<!-- Division pour le contenu principal -->
<div id="contenu">
         
                <div style="display: flex; flex-direction: row"> <br> 

          <h2>  <a style="float:left" class="btn btn-md btn-secondary display-4" href="index.php?uc=interventions&amp;action=voirDetailIntervFam&amp;num=<?php echo $num;?>">Voir le détail des prestations dans cette famille</a>   
                <a style="float:left" class="btn btn-md btn-secondary display-4" href="index.php?uc=annuFamille&amp;action=demanderModifFamille&amp;num=<?php echo $num; ?>">Modifier</a>
                <a style="float:left" class="btn btn-md btn-secondary display-4" href="index.php?uc=annuFamille&amp;action=ficheMail&amp;type=famille&amp;num=<?php echo $num; ?>">Fiche mail</a>
                <a style="float:left" class="btn btn-md btn-secondary display-4" href="index.php?uc=annuFamille&amp;action=voirIntervenantsDispo&amp;numFamille=<?php echo $num; ?>">Matching <br/> Intervenants</a>
                
                <a style="float:left" class="btn btn-md btn-secondary display-4" href="index.php?uc=annuFamille&amp;action=voirEmailPrefabF&amp;num=<?php echo $num; ?>">Mail présentation <br/> intervenant</a>

                <!--- Le bouton SUPPRIMER est opérationnel mais pas affiché pour des raisons de sécurité car seul admin devrait pouvoir l'utiliser --->
                <!--- <a class="btn btn-md btn-danger display-4"  href="index.php?uc=annuFamille&amp;action=demanderSupprimerFamille&amp;num=<?php /* echo $num; */ ?>">SUPPRIMER</a> --->
         
         <?php if($action !='validerAjoutFamille' && $action != 'validerModifFamille'){?> 
          
         <?php }
         $compt = 1;?>

                </div>
          <section class="mbr-section article content10 cid-qXoYD03tlf" style="background-color: #333333" id="content10-a">
          <div class="container" style="background-color:#333333">
        <div class="inner-container" style="width: 100%; background-color: #333333">
            <hr class="line" style="width: 25%;">
            <div class="section-text align-center mbr-white mbr-fonts-style display-7"><h1>
Fiche de la famille <?php 
          $noms = "";
          foreach ($parents as $parent){
            if($noms != $parent['nom_Parents']."-")
            $noms.=$parent['nom_Parents']."-";
          }
          $noms=substr($noms, 0, strlen($noms)-1);
          echo $noms; 
          $codePresta = "";
   /*       foreach($presta as $prest) {
            $codePresta.=$prest['codeCli_Proposer']."/";
          }*/
  
          ?> (<?php echo $num;?>)</h1><h6>Modifié le : <?php echo $dateModif;?></h6> <h6><?php if ($prestm==1) {echo 'PRESTATAIRE MENAGE';} if ($prestge==1) {echo ' PRESTATAIRE GARDE D\'ENFANTS';} if ($mand==1) {echo ' MANDATAIRE';} if ($gardePart==1) {echo ' GARDE PARTAGEE AVEC LA FAMILLE ';if($garde['famille1']!=$num) {echo $pdoChaudoudoux->obtenirNomFamille($garde['famille1']);} else echo $pdoChaudoudoux->obtenirNomFamille($garde['famille2']);}?>
            <h6>A POURVOIR : <?php  if ($aPourvoir==1) {
                                      if ($MPourvoir == 1) {
                                        if($GEPourvoir == 1) {
                                          echo "Ménage / Garde d'enfants Prestataire";
                                        }
                                        elseif ($GEPourvoir == 2) {
                                          echo "Ménage / Garde d'enfants Mandataire";
                                        }
                                        else {
                                          echo "Ménage";
                                        }
                                      }
                                      elseif ($GEPourvoir == 1) {
                                        echo "Garde d'enfants Prestataire";
                                      }
                                      elseif ($GEPourvoir == 2) {
                                        echo "Garde d'enfants Mandataire";
                                      }
                                      else{
                                        echo 'OUI';
                                      }
                                    }
                                      else echo 'NON'; ?></h6>
                                      <h6>ARCHIVÉ : <?php if($archive==1){echo('OUI');}else{echo('NON');} ?></h6>
      </div>
            <hr class="line" style="width: 25%;">
        </div>
    </div>
</section>
          <div style="display: flex;flex-direction: column"><div style="display:flex; flex-direction: column"><div style="flex-direction:row; display: flex;"><?php
	foreach($parents as $parent){
            ?>            <div style="flex-direction: column; width : 40%; margin: 40px;"><h5>Informations <?php if ($compt==2) echo 'papa'; elseif($compt==1) echo 'maman'; ?></h5>

          <table class="tabNonQuadrille" style="width:100%;">

            <tr>
                <td class="libelle">Nom :</td>
                <td><?php echo $parent['nom_Parents']; ?></td>
            </tr>
            <tr>
                <td class="libelle">Prenom :</td>
                <td><?php echo $parent['prenom_Parents']; ?></td>
            </tr>
            <tr>
              <td class="libelle">Téléphone portable :</td>
              <td><?php echo $parent['telPortable_Parents']; ?></td>
            </tr>
            <tr>
              <td class="libelle">Téléphone travail :</td>
              <td><?php echo $parent['telTravail_Parents']; ?></td>
            </tr>
            <tr>
              <td class="libelle">Email :</td>     
              <td><a href="mailto:<?php echo $parent['email_Parents'] ;?>"><?php echo $parent['email_Parents'] ; ?></a></td>
            </tr>
            <tr>
              <td class="libelle">Profession :</td>     
              <td><?php echo $parent['profession_Parents'] ; ?></td>
            </tr>
          </table></div>
<?php 
		$compt++;
	}
        ?></div><?php

	$compt = 1;?><div style="display: flex; flex-direction: row; width: 100%"><?php 
	foreach ($enfants as $enfant) {
            ?><div style="display:flex; flex-direction: column">
                <h5>Informations enfant <?php echo $compt; ?></h5>
		<table class="tabNonQuadrille">
            
			<tr>
                <td class="libelle">Nom :</td>
                <td><?php echo $enfant['nom_Enfants']; ?></td>
            </tr>
            <tr>
                <td class="libelle">Prenom :</td>
                <td><?php echo $enfant['prenom_Enfants']; ?></td>
            </tr>
            <tr>
                <td class="libelle">Date de naissance :</td>
                <td><?php if ($enfant['dateNaiss_Enfants'] != NULL) echo date('d/m/Y', strtotime($enfant['dateNaiss_Enfants'])); ?></td>
            </tr>
            <tr>
                <td class="libelle">Concerné par la garde :</td>
                <td><?php if ($enfant["concernGarde_Enfants"]==1) echo "Oui"; elseif ($enfant["concernGarde_Enfants"]==0) echo "Non"; else echo "Non renseigné"; ?></td>
            </tr>
            <tr>
                <td class="libelle">Age :</td>
                <td><?php echo (int)($enfant['age']/365);?></td>
            </tr>
                </table></div>
          
<?php     	$compt++;
}?></div><div style=" display: flex; flex-direction: column"><div style=" display: flex; flex-direction: row "><div style="display: flex; flex-direction: column; width: 60%"><table class="tabNonQuadrille" style="float:left; width : 100%">
              <h5>Informations de la famille <?php echo $num ; ?></h5>
               <tr>
              <td class="libelle">PGE :</td>
              <td><?php echo filtreChainePourNavig($pge) ; ?></td>
            </tr>
               <tr>
              <td class="libelle">REG :</td>
              <td><?php echo filtreChainePourNavig($reg) ; ?></td>
            </tr>
               <tr>
              <td class="libelle">PM :</td>
              <td><?php echo filtreChainePourNavig($pm) ; ?></td>
            </tr>
            <tr>
              <td class="libelle">N° CAF :</td>
              <td><?php echo filtreChainePourNavig($numAlloc) ; ?></td>
            </tr>
            <tr>
              <td class="libelle">N° URSSAF :</td>
              <td><?php echo filtreChainePourNavig($numURSSAF) ; ?></td>
            </tr>
            <tr>
              <td class="libelle">Adresse :</td>
              <td><?php echo filtreChainePourNavig($adresse) ; ?></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><?php echo filtreChainePourNavig($cp); ?>&nbsp;<?php echo filtreChainePourNavig($ville." ".$quart) ; ?></td>
            </tr>
             

    


               

            <tr>
              <td class="libelle">Téléphone domicile :</td>
              <td><?php echo filtreChainePourNavig($tel) ; ?></td>
            </tr>
            <tr>
              <td class="libelle">Véhicule nécessaire :</td>
              <td><?php if($vehicule == 1){
                echo "Oui";
                } else {
                  echo "Non";
                  } ?></td>
            </tr>
            <tr>
        <td class="libelle">Ligne de bus : </td>
        <td><?php echo $ligneBus;?></td>
    </tr>
    <tr>
        <td class="libelle">Arrêt de bus : </td>
        <td><?php echo $arretBus;?></td>
    </tr>
            <tr>
                <td class="libelle">Date d'entrée :</td>
                <td><?php if ($dateEntree != '0000-00-00 00:00:00') { if (dateToString($dateEntree)!='//'){echo dateToString($dateEntree);}} ?></td>
            </tr>
            <tr>
                <td class="libelle">Date de sortie :</td>
                <td><?php if ($dateSortie != '0000-00-00 00:00:00') { if (dateToString($dateSortie)!='//'){echo dateToString($dateSortie);}} ?></td>
            </tr>
            <tr>
                <td class="libelle">Date de fin Mandataire :</td>
                <td><?php if ($sortieMand != '0000-00-00') { if (dateToString($sortieMand)!='//'){echo dateToString($sortieMand);}} ?></td>
            </tr>
            <tr>
                <td class="libelle">Date de fin Prestataire Ménage :</td>
                <td><?php if ($sortiePM != '0000-00-00') { if (dateToString($sortiePM)!='//'){echo dateToString($sortiePM);}} ?></td>
            </tr>
            <tr>
                <td class="libelle">Date de fin Prestataire GE :</td>
                <td><?php if ($sortiePGE != '0000-00-00') { if (dateToString($sortiePGE)!='//'){echo dateToString($sortiePGE);}} ?></td>
            </tr>
            <tr><td class="libelle">Mode de paiement :</td>
                <td><?php echo $modePaiement;?></td>
            </tr>
            <tr>
</td>
            </tr>
            <tr>
              <td class="libelle">Participe à l'assemblée générale :</td>
              <td><?php if($ag == 1){
                echo "Oui";
                } else {
                  echo "Non";
                  } ?></td>
            </tr>
              <tr>
              <td class="libelle">Remarques :</td>
              <td><?php echo $remarque;?></td>
            </tr>
            <tr>
                <td class="libelle">Enfant handicapé dans la famille :</td>
                <td><?php if ($enfHand==1) {echo 'Oui';} else echo 'Non'; ?></td>
            </tr>
            <!--<tr>
                <td class="libelle">A pourvoir :</td>
                <td>/* if ($aPourvoir==1) {echo 'Oui';} else echo 'Non'; */?></td>
            </tr>-->
              <tr>
              <td class="libelle">Observations :</td>
              <td><?php echo $observ; ?>
              </td>
            </tr>
             <tr>
              <td class="libelle">Suivi :</td>
              <td><?php echo $suivi; ?>
              </td>
            </tr>
<?php
 /* foreach ($presta as $prest) {
?>
            <tr>
            <td></td>
              <td><a href="index.php?uc=annuSalarie&amp;action=voirDetailSalarie&amp;num=<?php echo $prest['numSalarie_Intervenants']; ?>"><?php echo filtreChainePourNavig(strtoupper($prest['nom'])) ; ?>&nbsp;<?php echo filtreChainePourNavig($prest['prenom']) ; ?></a></td>
            </tr>
            <tr>
              <td class="libelle">Type de prestation :</td>
              <td><?php echo $prest['type_Prestations']; ?></td>
            </tr>
            <tr><td class="libelle">En tant que :</td>
              <td><?php echo $prest['intitule_TypeADH']; ?></td>
            </tr>
            <tr>
              <td class="libelle">Réguiler ou occasionnel :</td>
              <td><?php if($prest['regu_Proposer'] == "OCC"){
                echo "Occasionnel";
                } else if($prest['regu_Proposer'] == "REG") {
                  echo "Régulier";
                  } ?></td>
            </tr>
<?php
  }*/
?>
            
              
            </table></div><?php
/*  $nb_fichier = 0;
                echo '<ul>';
          if ($dossier = opendir('Documents/Familles/'.$num))
          {
              
            while(false !== ($fichier = readdir($dossier)))
            {
                if( $fichier != '..' && $fichier != '.' && $fichier != 'index.php')
                {
                    $nb_fichier++; // On incrémente le compteur de 1
                    echo '<li><a href="Documents/Familles/'.$num.'/'.$fichier.'">'.$fichier.'</a></li>';
                }// On ferme le if (qui permet de ne pas afficher index.php, etc.)
 
            } // On termine la boucle
              echo '</ul><br />';
        echo 'Il y a <strong>' . $nb_fichier .'</strong> fichier(s) dans le dossier';
 
        closedir($dossier);
         }
      
 

 
        else {
        echo 'Le dossier n\' a pas pu être ouvert';}
        
*/?><div style="display: flex; flex-direction : column; margin-left: 5%; width: 35%">
    <h5>Informations sur le domicile</h5>
    <table class="tabNonQuadrille" style="width:100%">
    
    <tr>
        <td class="libelle">Type de logement : </td>
        <td><?php echo $typeLogement;?></td>
    </tr>
    <tr>
        <td class="libelle">Superficie du logement (en m²) : </td>
        <td><?php echo $superficie;?></td>
    </tr>
    <tr>
        <td class="libelle">Nombre d'étages : </td>
        <td><?php echo $nbEtages;?></td>
    </tr>
    <tr>
        <td class="libelle">Nombre de chambres : </td>
        <td><?php echo $nbChambres;?></td>
    </tr>
    <tr>
        <td class="libelle">Nombre de salles de bain : </td>
        <td><?php echo $nbSDB;?></td>
    </tr>
    <tr>
        <td class="libelle">Nombre de sanitaires : </td>
        <td><?php echo $nbSani;?></td>
    </tr><tr>
        <td class="libelle">Repassage : </td>
        <td><?php if ($repassage ==1){echo 'OUI';} else {echo 'NON';};?></td>
    </tr></table>
    
</div> 
<?php $adresse = str_replace(' ', '%20', $adresse).'%20'.$cp.'%20'.str_replace(' ', '%20', $ville) ?>

<iframe frameborder="0" style="border:0; width: 40%;" src="https://www.google.com/maps/embed/v1/place?key=AIzaSyA0Dx_boXQiwvdz8sJHoYeZNVTdoWONYkU&amp;q=<?php echo $adresse;?>" allowfullscreen=""></iframe>
             
</div>
             
</div></div>

<p style="text-align:center;margin-right:169.58px">
             <button style="position:fixed;bottom:0px;" class="retour btn" onclick="history.go(-1);">RETOUR</button>
</p>
 

       <section class="engine"><a href="https://mobirise.me/g">build a website</a></section><script src="assets/web/assets/jquery/jquery.min.js"></script>
  <script src="assets/popper/popper.min.js"></script>
  <script src="assets/tether/tether.min.js"></script>
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/smoothscroll/smooth-scroll.js"></script>
  <script src="assets/theme/js/script.js"></script>
  