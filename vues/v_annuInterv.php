
<?php 
/* La directive @var permet de déclarer une variable créée dans un script séparé 
 * du présent script, et ainsi de bénéficier de l'auto-complétion sur cette variable
 */
/* @var $lesFamilles array */
?>

<script type="module">
    import { getDistance } from "./styles/geo-api.js";
    (async () => {
      const tab = document.querySelectorAll("#listeIntervMenage")[0];
      if (!tab) {
        return;
      }
      console.log(tab)
      for (const line of tab.rows) {
        if (!line.querySelector("th")) {
          console.log(line.querySelectorAll("td"))
          const addr_can = line.querySelectorAll("td")[0].textContent.trim();
          const addr_fam = line.querySelectorAll("td")[1].textContent.trim();
          const addr_chau = "22 rue jean Guéhenno, 35700, Rennes";
          const dist_can_fam = line.querySelectorAll("td")[11];
          const dist_chau_fam = line.querySelectorAll("td")[12];
          if (dist_can_fam && dist_chau_fam) {

            dist_can_fam.textContent = await getDistance(addr_can, addr_fam) + " Km";

            dist_chau_fam.textContent = await getDistance(addr_chau, addr_fam) + " Km";


          }
        }
      }
    })();
    (async () => {
      const tab = document.querySelectorAll("#listeIntervGardeEnfant")[0];
      if (!tab) {
        return;
      }
      console.log(tab)
      for (const line of tab.rows) {
        if (!line.querySelector("th")) {
          console.log(line.querySelectorAll("td"))
          const addr_can = line.querySelectorAll("td")[0].textContent.trim();
          const addr_fam = line.querySelectorAll("td")[1].textContent.trim();
          const addr_chau = "22 rue jean Guéhenno, 35700, Rennes";
          const dist_can_fam = line.querySelectorAll("td")[11];
          const dist_chau_fam = line.querySelectorAll("td")[12];
          if (dist_can_fam && dist_chau_fam) {

            dist_can_fam.textContent = await getDistance(addr_can, addr_fam) + " Km";

            dist_chau_fam.textContent = await getDistance(addr_chau, addr_fam) + " Km";


          }
        }
      }
    })();
  </script>

<!-- Division pour le contenu principal -->
    <div id="contenu">
        <?php if ($action=='voirDetailIntervSalarie')
            {?> <a class="btn btn-md btn-secondary display-4"  href="planning.php?num=<?php echo $num;?>" target="_blank"> PLANNING </a><br/><br/><?php }?>
            
    <h2>Interventions actuelles <?php  if ($action=='voirTousInterv'){echo date('Y');} elseif ($action=='voirAncienInterv') {echo $an;} elseif($action=='invalid') {echo' en attente de validation';} elseif($action=='voirDetailIntervFam') {echo ' pour la famille '.$num;} elseif ($action=='voirDetailIntervSalarie'){echo 'pour '.$pdoChaudoudoux->trouverNomSal($num);}?></h2>
       <?php if($action != 'voirDetailIntervSalarie'&& $action!='voirDetailIntervFam') {for ($i=date('Y')-1; $i>2017;--$i)
       { echo '<a href="index.php?uc=interventions&amp;action=voirAncienInterv&amp;an='.$i.'">Voir les Interventions '.$i.'</a><br/>';}}?>
    <table class="sortable zebre" id="listeInterv">
        <thead>   <tr class="btn-secondary">
            <?php if (lireDonneeUrl('num')!=99999){?><th>Numéro du salarié</th><th>Nom du Salarié</th><th>Nom de jeune fille</th><?php }?><th>Nom de la famille</th><th>Type de prestation</th><th>Date de début</th><th>Date de fin</th><th>Jour / horaires / modalités</th><th>HRES/SEM</th><th>Modifier</th><th>Terminé?</th>
            </tr></thead><tbody><?php $i=0;$nbhTot=0;
         foreach ($lesInterv as $key => $uneInterv)
        {$numFam= $uneInterv['numero_Famille'];
            if ($numFam!=9999){
            $numSal= $uneInterv['numSalarie_Intervenants'];
            $idSal= $uneInterv['idSalarie_Intervenants'];
            $nomSal=$uneInterv['nom_Candidats'];
            $nomJF=$uneInterv['nomJF_Candidats'];
            $nomFam=$pdoChaudoudoux->obtenirNomFamille($numFam);
            $options=$uneInterv['options_Proposer'];

            /*HERE*/$presta=$uneInterv['type_Prestations'];

            $dateDeb=$uneInterv['dateDeb_Proposer'];
            $freq=$uneInterv['frequence_Proposer'];
            $dateFin=$uneInterv['dateFin_Proposer'];
            $idADH=$uneInterv['idADH_TypeADH'];
            $idPresta=$uneInterv['idPresta_Prestations'];
            $hDeb=$uneInterv['hDeb_Proposer'];
            $hFin= $uneInterv['hFin_Proposer'];
            $jour= $uneInterv['jour_Proposer'];
            $modalites=$uneInterv['modalites_Proposer'];
            if ($dateFin=='0000-00-00'){$dateFin="";}
            $dateDebstring="";
            $dateFinstring="";
            if($dateDeb!=""){
            $dateDebstring= dateToString($uneInterv['dateDeb_Proposer']);}
            if ($dateFin!=""){
            $dateFinstring=dateToString($uneInterv['dateFin_Proposer']);}
            if ($dateFinstring=='00/00/0000'){$dateFinstring="Indeterminé";}
            $statut=$uneInterv['Statut_Proposer'];
            $validInterv=$uneInterv['validInterv_Proposer'];
            if ($validInterv==1) {$validInterv='OUI';} elseif ($validInterv==0){$validInterv='NON';} else {$validInterv='NC';}
            $validFam=$uneInterv['validFamille_Proposer'];
            if ($validFam==1) {$validFam='OUI';} elseif ($validFam==0){$validFam='NON';} else {$validFam='NC';}

            /*HERE*/$libelleADH=$uneInterv['intitule_TypeADH'];

            if ($idADH!='PREST'){
            echo '<tr>';
            if (lireDonneeUrl('num')!=99999){ echo '<td>'.$idSal.'</td><td><a href="index.php?uc=annuSalarie&amp;action=voirDetailSalarie&amp;num='.$numSal.'">'.$nomSal.'</a></td><td>'.$nomJF.'</td>';} echo '<td><a href="index.php?uc=annuFamille&amp;action=voirDetailFamille&num='.$numFam.'">'.$nomFam.'</td><td>';
            
            /*HERE*/echo $presta." ".$libelleADH;
            
            echo'</td><td>'.$dateDebstring.'</td><td>'.$dateFinstring.'</td><td sorttable_customkey="'.ckJour($jour).$hDeb.$hFin.'">';
            echo $jour.' '.$hDeb.'-'.$hFin.'<br/>'.$modalites.'<td>';
            $nbminFin=((int) substr($hFin,3,2));$nbminDeb=((int) substr($hDeb, 3,2));
            if ($nbminFin==45){$nbminFin=0.75;}elseif($nbminFin==30){$nbminFin=0.5;}elseif($nbminFin==15){$nbminFin=0.25;}else{$nbminFin=0;}
            if ($nbminDeb==45){$nbminDeb=0.75;}elseif($nbminDeb==30){$nbminDeb=0.5;}elseif($nbminDeb==15){$nbminDeb=0.25;}else{$nbminDeb=0;}
            
            $nbh=(((int) substr($hFin, 0,2))+$nbminFin-(((int)substr($hDeb,0,2))+$nbminDeb))/$freq;
            echo $nbh.' heures';
            $nbhTot+=$nbh;
             $dateDeburl= substr($dateDeb, 0,4).substr($dateDeb,5,2).substr($dateDeb,8,2);
            $hDeburl= substr($hDeb,0,2).substr($hDeb,3,2).substr($hDeb,6,2);
            $hFinurl= substr($hFin,0,2).substr($hFin,3,2).substr($hFin,6,2);
            echo'</td><td><a href="index.php?uc=interventions&amp;action=modifInterv&amp;num='.$numSal.'&amp;numFam='.$numFam.'&amp;idADH='.$idADH.'&amp;idPresta='.$idPresta.'&amp;hDeb='.$hDeburl.'&amp;dateDeb='.$dateDeburl.'&amp;jour='.$jour.'&amp;hFin='.$hFinurl.'&amp;freq='.$freq.'">Modifier</a>';
            echo'</td><td><a href="index.php?uc=interventions&amp;action=archiverIntervention&amp;num='.$numSal.'&amp;numFam='.$numFam.'&amp;idADH='.$idADH.'&amp;idPresta='.$idPresta.'&amp;hDeb='.$hDeburl.'&amp;dateDeb='.$dateDeburl.'&amp;jour='.$jour.'&amp;hFin='.$hFinurl.'">Terminé</a></td></tr>';
           
            $i++;
        }}}
        ?></tbody><tfoot><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><strong style="float:right"><?php echo 'Total Mandataire : '.round($nbhTot, 2);?></strong></td></tr></tfoot></table><br/><br/>
        <table class="sortable zebre" id="listeIntervMenage">
        <thead>   <tr class="btn-secondary">
            <?php if (lireDonneeUrl('num')!=99999){?><th style="display: none;">addr_fam</th><th style="display: none;">addr_can</th><th>Numéro du salarié</th><th>Nom du Salarié</th><th>Nom de jeune fille</th><?php }?><th>Nom de la famille</th><th>Type de prestation</th><th>Date de début</th><th>Date de fin</th><th>Jour / horaires / modalités</th><th>HRES/SEM</th><th>distance Interv-Famille</th><th>distance Chaudoudoux-Famille</th><th>Modifier</th><th>Terminé?</th>
            </tr></thead><tbody><?php $i=0;$nbhTot=0;
         foreach ($lesInterv as $uneInterv)
        {$numFam= $uneInterv['numero_Famille'];
            if ($numFam!=9999 && $uneInterv['type_Prestations'] == 'Ménage'){
            $numSal= $uneInterv['numSalarie_Intervenants'];
            $nomSal=$uneInterv['nom_Candidats'];
            $nomJF=$uneInterv['nomJF_Candidats'];
            $infoCan=$pdoChaudoudoux->obtenirDetailsSalarie($numSal);
            $addrCan = 
            (!isset($infoCan[0]['adresse_Candidats']) || is_bool($infoCan[0]['adresse_Candidats']) ? '' : $infoCan[0]['adresse_Candidats']) . ' ' . 
            (!isset($infoCan[0]['cp_Candidats']) || is_bool($infoCan[0]['cp_Candidats']) ? '' : $infoCan[0]['cp_Candidats']) . ' ' . 
            (!isset($infoCan[0]['ville_Candidats']) || is_bool($infoCan[0]['ville_Candidats']) ? '' : $infoCan[0]['ville_Candidats']);
            
            
            $infoFam=$pdoChaudoudoux->obtenirDetailFamille($numFam);
            
            $addrFam = 
            (!isset($infoFam['adresse_Famille']) || is_bool($infoFam['adresse_Famille']) ? '' : $infoFam['adresse_Famille']) . ' ' . 
            (!isset($infoFam['cp_Famille']) || is_bool($infoFam['cp_Famille']) ? '' : $infoFam['cp_Famille']) . ' ' . 
            (!isset($infoFam['ville_Famille']) || is_bool($infoFam['ville_Famille']) ? '' : $infoFam['ville_Famille']);



            $nomFam=$pdoChaudoudoux->obtenirNomFamille($numFam);
            $idSal= $uneInterv['idSalarie_Intervenants'];
            $options=$uneInterv['options_Proposer'];
            $presta=$uneInterv['type_Prestations'];
            $dateDeb=$uneInterv['dateDeb_Proposer'];
            $freq=$uneInterv['frequence_Proposer'];
            $dateFin=$uneInterv['dateFin_Proposer'];
            $idADH=$uneInterv['idADH_TypeADH'];
            $idPresta=$uneInterv['idPresta_Prestations'];
            $hDeb=$uneInterv['hDeb_Proposer'];
            $hFin= $uneInterv['hFin_Proposer'];
            $jour= $uneInterv['jour_Proposer'];
            $modalites=$uneInterv['modalites_Proposer'];
            if ($dateFin=='0000-00-00'){$dateFin="";}
            $dateDebstring="";
            $dateFinstring="";
            if($dateDeb!=""){
            $dateDebstring= dateToString($uneInterv['dateDeb_Proposer']);}
            if ($dateFin!=""){
            $dateFinstring=dateToString($uneInterv['dateFin_Proposer']);}
            if ($dateFinstring=='00/00/0000'){$dateFinstring="Indeterminé";}
            $statut=$uneInterv['Statut_Proposer'];
            $validInterv=$uneInterv['validInterv_Proposer'];
            if ($validInterv==1) {$validInterv='OUI';} elseif ($validInterv==0){$validInterv='NON';} else {$validInterv='NC';}
            $validFam=$uneInterv['validFamille_Proposer'];
            if ($validFam==1) {$validFam='OUI';} elseif ($validFam==0){$validFam='NON';} else {$validFam='NC';}
            $libelleADH=$uneInterv['intitule_TypeADH'];
            if ($idADH!='MAND'){
            echo '<tr>';
            echo '<td style="display: none;">'.$addrCan.'</td><td style="display: none;">'.$addrFam.'</td>';
            if (lireDonneeUrl('num')!=99999){ echo '<td>'.$idSal.'</td><td><a href="index.php?uc=annuSalarie&action=voirDetailSalarie&num='.$numSal.'">'.$nomSal.'</a></td><td>'.$nomJF.'</td>';} echo '<td><a href="index.php?uc=annuFamille&action=voirDetailFamille&num='.$numFam.'">'.$nomFam.'</td><td>';
            echo $presta." ".$libelleADH;
            echo'</td><td>'.$dateDebstring.'</td><td>'.$dateFinstring.'</td><td sorttable_customkey="'.ckJour($jour).$hDeb.$hFin.'">';
            echo $jour.' '.$hDeb.'-'.$hFin.'<br/>'.$modalites.'<td>';
            $nbminFin=((int) substr($hFin,3,2));$nbminDeb=((int) substr($hDeb, 3,2));
            if ($nbminFin==45){$nbminFin=0.75;}elseif($nbminFin==30){$nbminFin=0.5;}elseif($nbminFin==15){$nbminFin=0.25;}else{$nbminFin=0;}
            if ($nbminDeb==45){$nbminDeb=0.75;}elseif($nbminDeb==30){$nbminDeb=0.5;}elseif($nbminDeb==15){$nbminDeb=0.25;}else{$nbminDeb=0;}

            $nbh=(((int) substr($hFin, 0,2))+$nbminFin-(((int)substr($hDeb,0,2))+$nbminDeb))/$freq;
            echo $nbh.' heures';
            $nbhTot+=$nbh; 
            
            $hDeburl= substr($hDeb,0,2).substr($hDeb,3,2).substr($hDeb,6,2);
            $hFinurl= substr($hFin,0,2).substr($hFin,3,2).substr($hFin,6,2);
            $dateDeburl= substr($dateDeb, 0,4).substr($dateDeb,5,2).substr($dateDeb, 8,2);
            $dateFinurl=  substr($dateFin, 0,4).substr($dateFin,5,2).substr($dateFin, 8,2);

            echo '</td><td style="border-left: solid black 1px;border-right: solid black 1px; border-collapse : collapse"><img style="max-width:30px;" src="./styles/img/loading.gif"></img></td>';
            echo '</td><td style="border-left: solid black 1px;border-right: solid black 1px; border-collapse : collapse"><img style="max-width:30px;" src="./styles/img/loading.gif"></img></td>';

            echo '</td><td><a href="index.php?uc=interventions&amp;action=modifInterv&amp;num='.$numSal.'&amp;numFam='.$numFam.'&amp;idADH='.$idADH.'&amp;idPresta='.$idPresta.'&amp;hDeb='.$hDeburl.'&amp;dateDeb='.$dateDeburl.'&amp;dateFin='.$dateFinurl.'&amp;jour='.$jour.'&amp;hFin='.$hFinurl.'&amp;freq='.$freq.'">Modifier</a>';
            echo '</td><td><a href="index.php?uc=interventions&amp;action=archiverIntervention&amp;num='.$numSal.'&amp;numFam='.$numFam.'&amp;idADH='.$idADH.'&amp;idPresta='.$idPresta.'&amp;hDeb='.$hDeburl.'&amp;dateDeb='.$dateDeburl.'&amp;jour='.$jour.'&amp;hFin='.$hFinurl.'">Terminé</a></td></tr>';
            $i++;
        }}}
       echo '<span style="font-size: 25px;"><strong>- PRESTATION MÉNAGE</strong> - Nombre d\'heures par semaine : '.round($nbhTot,2).' h<br><span style="font-size: 20px; font-weight: bold;">Les interventions Ménage PEUVENT ÊTRE DEPROGRAMMÉES à la demande des familles 7 jours avant la date d’intervention prévue initialement.</span></span>';
        ?><tfoot><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><strong style="float:right"><?php echo 'Total Prestataire : '.round($nbhTot,2); ?></tfoot></strong></td></tr></tfoot></table><br/><br/>
                <table class="sortable zebre" id="listeIntervGardeEnfant">
        <thead>   <tr class="btn-secondary">
            <?php if (lireDonneeUrl('num')!=99999){?><th style="display: none;">addr_fam</th><th style="display: none;">addr_can</th><th>Numéro du salarié</th><th>Nom du Salarié</th><th>Nom de jeune fille</th><?php }?><th>Nom de la famille</th><th>Type de prestation</th><th>Date de début</th><th>Date de fin</th><th>Jour / horaires / modalités</th><th>HRES/SEM</th><th>distance Interv-Famille</th><th>distance Chaudoudoux-Famille</th><th>Modifier</th><th>Terminé?</th>
            </tr></thead><tbody><?php $i=0;$nbhTot=0;
         foreach ($lesInterv as $uneInterv)
        {$numFam= $uneInterv['numero_Famille'];
            if ($numFam!=9999 && $uneInterv['type_Prestations'] == 'Garde d\'enfants'){
            $numSal= $uneInterv['numSalarie_Intervenants'];
            $nomSal=$uneInterv['nom_Candidats'];
            $nomJF=$uneInterv['nomJF_Candidats'];
            $infoCan=$pdoChaudoudoux->obtenirDetailsSalarie($numSal);
            $addrCan = 
            (!isset($infoCan[0]['adresse_Candidats']) || is_bool($infoCan[0]['adresse_Candidats']) ? '' : $infoCan[0]['adresse_Candidats']) . ' ' . 
            (!isset($infoCan[0]['cp_Candidats']) || is_bool($infoCan[0]['cp_Candidats']) ? '' : $infoCan[0]['cp_Candidats']) . ' ' . 
            (!isset($infoCan[0]['ville_Candidats']) || is_bool($infoCan[0]['ville_Candidats']) ? '' : $infoCan[0]['ville_Candidats']);
            
            
            
            $infoFam=$pdoChaudoudoux->obtenirDetailFamille($numFam);
            
            $addrFam = 
            (!isset($infoFam['adresse_Famille']) || is_bool($infoFam['adresse_Famille']) ? '' : $infoFam['adresse_Famille']) . ' ' . 
            (!isset($infoFam['cp_Famille']) || is_bool($infoFam['cp_Famille']) ? '' : $infoFam['cp_Famille']) . ' ' . 
            (!isset($infoFam['ville_Famille']) || is_bool($infoFam['ville_Famille']) ? '' : $infoFam['ville_Famille']);




            $nomFam=$pdoChaudoudoux->obtenirNomFamille($numFam);
            $idSal= $uneInterv['idSalarie_Intervenants'];
            $options=$uneInterv['options_Proposer'];
            $presta=$uneInterv['type_Prestations'];
            $dateDeb=$uneInterv['dateDeb_Proposer'];
            $freq=$uneInterv['frequence_Proposer'];
            $dateFin=$uneInterv['dateFin_Proposer'];
            $idADH=$uneInterv['idADH_TypeADH'];
            $idPresta=$uneInterv['idPresta_Prestations'];
            $hDeb=$uneInterv['hDeb_Proposer'];
            $hFin= $uneInterv['hFin_Proposer'];
            $jour= $uneInterv['jour_Proposer'];
            $modalites=$uneInterv['modalites_Proposer'];
            if ($dateFin=='0000-00-00'){$dateFin="";}
            $dateDebstring="";
            $dateFinstring="";
            if($dateDeb!=""){
            $dateDebstring= dateToString($uneInterv['dateDeb_Proposer']);}
            if ($dateFin!=""){
            $dateFinstring=dateToString($uneInterv['dateFin_Proposer']);}
            if ($dateFinstring=='00/00/0000'){$dateFinstring="Indeterminé";}
            $statut=$uneInterv['Statut_Proposer'];
            $validInterv=$uneInterv['validInterv_Proposer'];
            if ($validInterv==1) {$validInterv='OUI';} elseif ($validInterv==0){$validInterv='NON';} else {$validInterv='NC';}
            $validFam=$uneInterv['validFamille_Proposer'];
            if ($validFam==1) {$validFam='OUI';} elseif ($validFam==0){$validFam='NON';} else {$validFam='NC';}
            $libelleADH=$uneInterv['intitule_TypeADH'];
            if ($idADH!='MAND'){
            echo '<tr>';
            echo '<td style="display: none;">'.$addrCan.'</td><td style="display: none;">'.$addrFam.'</td>';
            if (lireDonneeUrl('num')!=99999){ echo '<td>'.$idSal.'</td><td><a href="index.php?uc=annuSalarie&action=voirDetailSalarie&num='.$numSal.'">'.$nomSal.'</a></td><td>'.$nomJF.'</td>';} echo '<td><a href="index.php?uc=annuFamille&action=voirDetailFamille&num='.$numFam.'">'.$nomFam.'</td><td>';
            echo $presta." ".$libelleADH;
            echo'</td><td>'.$dateDebstring.'</td><td>'.$dateFinstring.'</td><td sorttable_customkey="'.ckJour($jour).$hDeb.$hFin.'">';
            echo $jour.' '.$hDeb.'-'.$hFin.'<br/>'.$modalites.'<td>';
            $nbminFin=((int) substr($hFin,3,2));$nbminDeb=((int) substr($hDeb, 3,2));
            if ($nbminFin==45){$nbminFin=0.75;}elseif($nbminFin==30){$nbminFin=0.5;}elseif($nbminFin==15){$nbminFin=0.25;}else{$nbminFin=0;}
            if ($nbminDeb==45){$nbminDeb=0.75;}elseif($nbminDeb==30){$nbminDeb=0.5;}elseif($nbminDeb==15){$nbminDeb=0.25;}else{$nbminDeb=0;}

            $nbh=(((int) substr($hFin, 0,2))+$nbminFin-(((int)substr($hDeb,0,2))+$nbminDeb))/$freq;
            echo $nbh.' heures';
            $nbhTot+=$nbh; 
            
            $hDeburl= substr($hDeb,0,2).substr($hDeb,3,2).substr($hDeb,6,2);
            $hFinurl= substr($hFin,0,2).substr($hFin,3,2).substr($hFin,6,2);
            $dateDeburl= substr($dateDeb, 0,4).substr($dateDeb,5,2).substr($dateDeb, 8,2);
            $dateFinurl=  substr($dateFin, 0,4).substr($dateFin,5,2).substr($dateFin, 8,2);

            echo '</td><td style="border-left: solid black 1px;border-right: solid black 1px; border-collapse : collapse"><img style="max-width:30px;" src="./styles/img/loading.gif"></img></td>';
            echo '</td><td style="border-left: solid black 1px;border-right: solid black 1px; border-collapse : collapse"><img style="max-width:30px;" src="./styles/img/loading.gif"></img></td>';

            echo '</td><td><a href="index.php?uc=interventions&amp;action=modifInterv&amp;num='.$numSal.'&amp;numFam='.$numFam.'&amp;idADH='.$idADH.'&amp;idPresta='.$idPresta.'&amp;hDeb='.$hDeburl.'&amp;dateDeb='.$dateDeburl.'&amp;dateFin='.$dateFinurl.'&amp;jour='.$jour.'&amp;hFin='.$hFinurl.'&amp;freq='.$freq.'">Modifier</a>';
            echo '</td><td><a href="index.php?uc=interventions&amp;action=archiverIntervention&amp;num='.$numSal.'&amp;numFam='.$numFam.'&amp;idADH='.$idADH.'&amp;idPresta='.$idPresta.'&amp;hDeb='.$hDeburl.'&amp;dateDeb='.$dateDeburl.'&amp;jour='.$jour.'&amp;hFin='.$hFinurl.'">Terminé</a></td></tr>';
            $i++;
        }}}
        echo '<span style="font-size: 25px" ><strong>- PRESTATION GARDE D\'ENFANTS UNIQUEMENT EN PERIODE SCOLAIRE</strong> - Nombre d\'heures par semaine : '.round($nbhTot,2).' h<br><span style="font-size: 20px; font-weight: bold;">Les interventions de Garde d\'enfants PEUVENT ÊTRE DEPROGRAMMÉES à la demande des familles 7 jours avant la date d’intervention prévue initialement.</span></span>';
        ?><tfoot><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><strong style="float:right"><?php echo 'Total Prestataire : '.round($nbhTot,2); ?></tfoot></strong></td></tr></tfoot></table><br/><br/>
                <table class="sortable zebre" id="listeInterv">
        <thead>   <tr class="btn-secondary">
            <?php if (lireDonneeUrl('num')!=99999){?><th>Numéro du salarié</th><th>Nom du Salarié</th><th>Nom de jeune fille</th><?php }?><th>Nom de la famille</th><th>Type de prestation</th><th>Date de début</th><th>Date de fin</th><th>Jour / horaires / modalités</th><th>HRES/SEM</th><th>Modifier</th><th>Terminé?</th>
            </tr></thead><tbody><?php $i=0;$nbhTot=0;
         foreach ($lesInterv as $uneInterv)
        {$numFam= $uneInterv['numero_Famille'];
            if ($numFam==9999){
            $numSal= $uneInterv['numSalarie_Intervenants'];
            $nomSal=$uneInterv['nom_Candidats'];
            $nomJF=$uneInterv['nomJF_Candidats'];
            $idSal= $uneInterv['idSalarie_Intervenants'];
            $nomFam=$pdoChaudoudoux->obtenirNomFamille($numFam);
            $options=$uneInterv['options_Proposer'];
            $presta=$uneInterv['type_Prestations'];
            $dateDeb=$uneInterv['dateDeb_Proposer'];
            $dateFin=$uneInterv['dateFin_Proposer'];
            $idADH=$uneInterv['idADH_TypeADH'];
            $idPresta=$uneInterv['idPresta_Prestations'];
            $hDeb=$uneInterv['hDeb_Proposer'];
            $hFin= $uneInterv['hFin_Proposer'];
            $freq=$uneInterv['frequence_Proposer'];
            $jour= $uneInterv['jour_Proposer'];
            $modalites=$uneInterv['modalites_Proposer'];
            if ($dateFin=='0000-00-00'){$dateFin="";}
            $dateDebstring="";
            $dateFinstring="";
            if($dateDeb!=""){
            $dateDebstring= dateToString($uneInterv['dateDeb_Proposer']);}
            if ($dateFin!=""){
            $dateFinstring=dateToString($uneInterv['dateFin_Proposer']);}
            if ($dateFinstring=='00/00/0000'){$dateFinstring="Indeterminé";}
            $statut=$uneInterv['Statut_Proposer'];
            $validInterv=$uneInterv['validInterv_Proposer'];
            if ($validInterv==1) {$validInterv='OUI';} elseif ($validInterv==0){$validInterv='NON';} else {$validInterv='NC';}
            $validFam=$uneInterv['validFamille_Proposer'];
            if ($validFam==1) {$validFam='OUI';} elseif ($validFam==0){$validFam='NON';} else {$validFam='NC';}
            $libelleADH=$uneInterv['intitule_TypeADH'];
            if ($idADH!='PREST'){
            echo '<tr>';
            if (lireDonneeUrl('num')!=99999){ echo '<td>'.$idSal.'</td><td><a href="index.php?uc=annuSalarie&amp;action=voirDetailSalarie&num='.$numSal.'">'.$nomSal.'</a></td><td>'.$nomJF.'</td>';} echo '<td><a href="index.php?uc=annuFamille&amp;action=voirDetailFamille&num='.$numFam.'">'.$nomFam.'</td><td>';
            echo $presta." ".$libelleADH;
            echo'</td><td>'.$dateDebstring.'</td><td>'.$dateFinstring.'</td><td sorttable_customkey="'.ckJour($jour).$hDeb.$hFin.'">';
            echo $jour.' '.$hDeb.'-'.$hFin.'<br/>'.$modalites.'<td>';
            $nbminFin=((int) substr($hFin,3,2));$nbminDeb=((int) substr($hDeb, 3,2));
            if ($nbminFin==45){$nbminFin=0.75;}elseif($nbminFin==30){$nbminFin=0.5;}elseif($nbminFin==15){$nbminFin=0.25;}else{$nbminFin=0;}
            if ($nbminDeb==45){$nbminDeb=0.75;}elseif($nbminDeb==30){$nbminDeb=0.5;}elseif($nbminDeb==15){$nbminDeb=0.25;}else{$nbminDeb=0;}
            
            $nbh=(((int) substr($hFin, 0,2))+$nbminFin-(((int)substr($hDeb,0,2))+$nbminDeb))/$freq;
            echo $nbh.' heures';
            $nbhTot+=$nbh;
            echo'</td><td><a href=index.php?uc=interventions&amp;action=modifInterv&amp;num='.$numSal.'&amp;numFam='.$numFam.'&amp;idADH='.$idADH.'&amp;idPresta='.$idPresta.'&amp;';
            $hDeburl= substr($hDeb,0,2).substr($hDeb,3,2).substr($hDeb,6,2);
            $hFinurl= substr($hFin,0,2).substr($hFin,3,2).substr($hFin,6,2);
            $dateDeburl= substr($dateDeb, 0,4).substr($dateDeb,5,2).substr($dateDeb,8,2);
            echo 'hDeb='.$hDeburl.'&amp;dateDeb='.$dateDeburl.'&amp;jour='.$jour.'&amp;hFin='.$hFinurl.'&amp;freq='.$freq.'>Modifier</a>';
            echo'</td><td><a href=index.php?uc=interventions&amp;action=archiverIntervention&amp;num='.$numSal.'&amp;numFam='.$numFam.'&amp;idADH='.$idADH.'&amp;idPresta='.$idPresta.'&amp;hDeb='.$hDeburl.'&amp;dateDeb='.$dateDeburl.'&amp;jour='.$jour.'&amp;hFin='.$hFinurl.'>Terminé</a></td></tr>';
           
            $i++;
        }}}
        ?></tbody><tfoot><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><strong style="float:right"><?php echo 'Total Indisponibilité : '.round($nbhTot,2);?></strong></td></tr></tfoot></table><br/><br/><?php /*
   /*      if ($action=='invalid')
         {f
             ?><form id="formValidInterv" method="post" action="index.php?uc=interventions&amp;action=validInterv">
        <fieldset>
            <legend>Valider une intervention</legend>
            <label for="slctInterv">Sélectionner une intervention :</label>
            <select name="slctInterv" id="slctInterv">
                <?php $i=0;
                 foreach ($lesInterv as $uneInterv)
                {$numFam= $uneInterv['numero_Famille'];
            if ($numFam!=9999){
                    $idPresta=$uneInterv['idPresta_Prestations'];
                    $numSal= $uneInterv['numSalarie_Intervenants'];
                    $idADH=$uneInterv['idADH_TypeADH'];
                    $dateDeb=$uneInterv['dateDeb_Proposer'];
                    $dateFin=$uneInterv['dateFin_Proposer'];
                    $nomFam=$pdoChaudoudoux->obtenirNomFamille($numFam);
                    $nomSal=$uneInterv['nom_Candidats'];
                    $jour=$uneInterv['jour_Proposer'];
                    $hDeb=$uneInterv['hDeb_Proposer'];
                    $hFin=$uneInterv['hFin_Proposer'];
                    $idpresta=$uneInterv['idPresta_Prestations'];
                    $i++;
                    ?> <option value="<?php echo $idpresta.'/'.$numSal.';'.$numFam.'^'.$idADH.'$'.$jour.'+'.$hDeb;?>"><?php echo 'M./Mme '.$nomSal.' Chez la famille '.$nomFam.' le '.$jour.' de '.$hDeb.' à '.$hFin;?></option>
            <?php }}?>
            </select><br/>
            <label for="validFam">Validé par la famille ?</label>
            <input type="checkbox" value="1" name="validFam"/>
            <label for="validInterv">Validé par l'intervenant ?</label>
            <input type="checkbox" value="1" name="validInterv"/><br/>
            <label for="statut">Fin de contrat ?</label>
            <input type="checkbox" value="Effectué" name="statut"/>
        </fieldset>
                 <fieldset>
                     <input type="reset"/>
                     <input type="submit"/>
                 </fieldset>
         </form><?php */
                
        if (($action == 'voirDetailIntervFam' || $action== 'voirDetailIntervSalarie'||$action=='archiverIntervention'|| $action='validerModifInterv') )
       {?>
        <h2>Historique des interventions</h2>
               
      <table class="sortable zebre" id="listeInterv">
          <thead> <tr class="btn-secondary">
            <?php if (lireDonneeUrl('num')!=99999){?><th>Numéro du salarié</th><th>Nom du Salarié</th><th>Nom de jeune fille</th><?php }?><th>Nom de la famille</th><th>Type de prestation</th><th>Date de début</th><th>Date de fin</th><th>Jour / horaires / modalités</th><th>Modifier</th>
              </tr></thead><tbody><?php $i=0;
        foreach ($lesIntervPasse as $uneIntervPasse)
        { $numFam= $uneIntervPasse['numero_Famille'];
            if ($numFam!=9999){
            $numSal= $uneIntervPasse['numSalarie_Intervenants'];
            
            $nomSal=$uneIntervPasse['nom_Candidats'];
            $nomJF=$uneIntervPasse['nomJF_Candidats'];
            $idSal=$uneIntervPasse['idSalarie_Intervenants'];
            $nomFam=$pdoChaudoudoux->obtenirNomFamille($numFam);
            $options=$uneIntervPasse['options_Proposer'];
            $presta=$uneIntervPasse['type_Prestations'];
            $dateDeb=$uneIntervPasse['dateDeb_Proposer'];
            $dateFin=$uneIntervPasse['dateFin_Proposer'];
            $idADH=$uneIntervPasse['idADH_TypeADH'];
            $idPresta=$uneIntervPasse['idPresta_Prestations'];
            $hDeb=$uneIntervPasse['hDeb_Proposer'];
            $hFin= $uneIntervPasse['hFin_Proposer'];
            $jour= $uneIntervPasse['jour_Proposer'];
            $freq=$uneIntervPasse['frequence_Proposer'];
            $modalites=$uneIntervPasse['modalites_Proposer'];
            if ($dateDeb=='0000-00-00'){$dateDeb="";}
            if ($dateFin=='0000-00-00'){$dateFin="";}
            $dateDebstring="";
            $dateFinstring="";
            if($dateDeb!=""){
                $dateDebstring= dateToString($uneIntervPasse['dateDeb_Proposer']);}
            if ($dateFin!=""){
            $dateFinstring=dateToString($uneIntervPasse['dateFin_Proposer']);}
            $validInterv=$uneIntervPasse['validInterv_Proposer'];
            if ($validInterv==1) {$validInterv='OUI';} elseif ($validInterv==0){$validInterv='NON';} else {$validInterv='NC';}
            $validFam=$uneIntervPasse['validFamille_Proposer'];
            if ($validFam==1) {$validFam='OUI';} elseif ($validFam==0){$validFam='NON';} else {$validFam='NC';}
            $libelleADH=$uneIntervPasse['intitule_TypeADH'];
            $statut = $uneIntervPasse['Statut_Proposer'];
            $i++;
            $hDeburl= substr($hDeb,0,2).substr($hDeb,3,2).substr($hDeb,6,2);
            $hFinurl= substr($hFin,0,2).substr($hFin,3,2).substr($hFin,6,2);
             $dateDeburl= substr($dateDeb, 0,4).substr($dateDeb,5,2).substr(8,2);
            echo '<td>'.$idSal.'</td><td><a href="index.php?uc=annuSalarie&action=voirDetailSalarie&num='.$numSal.'">'.$nomSal.'</a></td><td>'.$nomJF.'</td><td><a href="index.php?uc=annuFamille&action=voirDetailFamille&num='.$numFam.'">'.$nomFam.'</a></td><td>';
            
            echo $presta." ".$libelleADH;
            echo '</td><td>'.$dateDebstring.'</td><td>'.$dateFinstring.'</td><td>';
            echo $jour.' '.$hDeb.'-'.$hFin.'<br/>'.$modalites; 
            echo '</td></tr>';
            }
        }  ?>
        
        <button style="position:fixed;bottom:0px;right:0px;font-size:1.2em;font-weight:bold" class="retour btn" onclick="history.go(-1);">RETOUR</button>
          </tbody></table><br/><br/><?php
       }
         if ($action !='voirDetailIntervFam'){ 
         include 'v_attribution.php';}