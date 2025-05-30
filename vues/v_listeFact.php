<?php
/* La directive @var permet de déclarer une variable créée dans un script séparé 
 * du présent script, et ainsi de bénéficier de l'auto-complétion sur cette variable
 */
/* @var $lesFactures array */
?>
<!-- Division pour le contenu principal -->
    <div id="contenu">
        <?php if($action=='voirTousFact'){?>

        <!--<h1 style="display: flex; flex-direction: row-reverse;margin-right:40px"><?php /*if (lireDonneeUrl('ordre')!='alpha') {*/?> Liste des prélèvements <?php /*}*/?></h1>-->
        <div style="display: flex; flex-direction: row;">
        <div style="width:100%">
        <a href="#" class="btn btn-md btn-secondary display-4" style="float:right;margin-right:40px" onclick="javascript:window.print()">Imprimer</a> <!-- <a href="index.php?uc=annuFact&amp;action=moisSuivant" class="btn btn-md btn-secondary display-4" onclick="traiteFormSubmit()">Mois suivant : Ajoute tous les mandataires abonnés ce mois-ci à la liste</a>-->
        <a style="float:right" href="index.php?uc=annuFact&amp;action=ajoutFact" class="btn btn-md btn-secondary display-4">Ajouter une facturation</a>
        </div>
        </div>


        <div style="display: flex; flex-direction: row-reverse;">
        <div style="display: flex; flex-direction: column;margin-right:40px">
        <h3><?php if (lireDonneeUrl('ordre')!='alpha') {?> LISTE DES PRÉLEVEMENTS - <?php echo $pdoChaudoudoux->obtenirTotalListeNonEncaisse();?> RÉSULTATS <?php }else{ ?> LISTE DES FACTURATIONS DU MOIS - <?php echo $pdoChaudoudoux->obtenirTotalListeNonEncaisse1();?> RÉSULTATS <?php }?></h3>
        <table class="sortable zebre" id="listeFact">

        <thead>
            <tr class="btn-secondary">
            <th>M</th>
            <th>Nom Parents</th>
            <th>Montant</th>
            <th>Date de sortie</th>
            <th>Date de fin Mandataire</th>
            <th>Mode Paiement</th>
            <th><?php echo 'Modifier'?></th>
            <th><?php echo 'Suppression';?></th>
            </tr>
        </thead>

        <tbody>

        <?php      
        foreach($lesFactures as $uneFacture) {
            $numFam=$uneFacture["numero_Famille"];
            $num=$uneFacture["idFact_Factures"];
            $noms=$pdoChaudoudoux->obtenirNomFamille($numFam);
            $montant=$pdoChaudoudoux->trouverTarifs($uneFacture['montantFact_Factures']);
            $dateSortie=dateToString($pdoChaudoudoux->obtenirDateSortieFam($numFam));
            if ($dateSortie=='00/00/0000'){ $dateSortie='';}
            $montantEnc=$uneFacture["montantEnc_Factures"];
            $modePaiement=$uneFacture["modePaiement_Facture"];
            if (empty($modePaiement))
            {
                $modePaiement="Pas payé";
            }
        ?>
        
        <tr>
        <td><?php echo $numFam;?></td>
        <td><a href="index.php?uc=annuFamille&amp;action=voirDetailFamille&amp;num=<?php echo $numFam;?>"><strong><?php echo $noms; ?></strong></a></td>
        <td><?php echo $montant;?></td>
        <td><?php if ($dateSortie!='//'){echo $dateSortie;}?></td>
        <td><?php if ($pdoChaudoudoux->obtenirFinMand($numFam)!="" && $pdoChaudoudoux->obtenirFinMand($numFam)!='0000-00-00'){echo dateToString($pdoChaudoudoux->obtenirFinMand($numFam));}?></td>
        <td> <?php echo $modePaiement=$pdoChaudoudoux->modePaiement($numFam);?></td>
        <td><a href="index.php?uc=annuFact&amp;action=modifFact&amp;num=<?php echo $num;?>&amp;numFam=<?php echo $numFam?>&amp;montant=<?php echo $montant; ?>&amp;modePaiement=<?php echo $modePaiement;?>">Modifier</a></td>
        <td><a href="index.php?uc=annuFact&amp;action=suppFact&amp;ordre=<?php lireDonneeUrl('ordre')?>&amp;num=<?php echo $num;?>" onclick="sur()">Suppression</a></td>
        </tr><?php }?>
        
        </tbody>
        </table>
            



        <?php if (lireDonneeUrl('ordre')!='prelevement'){?> 

        <h2>Nouvelles entrées ce mois-ci</h2>
        <table class='sortable zebre'>

        <thead>
            <th>M</th>
            <th>Nom Parents</th>
            <th>Montant</th>
            <th>Date de sortie</th>
            <th>Mode Paiement</th>
            <th><?php echo 'Modifier'?></th>
            <th><?php echo 'Suppression';?></th>
        </thead>

        <tbody>

        <?php      
        foreach($lesEntrees as $uneEntree) {
            $numFam=$uneEntree["numero_Famille"];
            $num = $uneEntree["idFact_Factures"];
            $noms=$pdoChaudoudoux->obtenirNomFamille($numFam);
            $montant=$pdoChaudoudoux->trouverTarifs($uneEntree['montantFact_Factures']);
            $dateSortie= dateToString($pdoChaudoudoux->obtenirDateSortieFam($numFam));
            if ($dateSortie=='00/00/0000'){ $dateSortie='';}
            $montantEnc=$uneEntree["montantEnc_Factures"];
            $modePaiement=$uneEntree["modePaiement_Facture"];
            if (empty($modePaiement))
            {
                $modePaiement="Pas payé";
            }
        ?>
        
        <tr>
        <td><?php echo $numFam;?></td>
        <td><a href="index.php?uc=annuFamille&amp;action=voirDetailFamille&amp;num=<?php echo $numFam;?>"><?php echo $noms; ?></a></td>
        <td><?php echo $montant;?></td>
        <td><?php if ($dateSortie!='//'){echo $dateSortie;}?></td>
        <td><?php echo $modePaiement=$pdoChaudoudoux->modePaiement($numFam);?></td>
        <td><a href="index.php?uc=annuFact&amp;action=modifFact&amp;num=<?php echo $num;?>&amp;numFam=<?php echo $numFam?>&amp;montant=<?php echo $montant; ?>&amp;modePaiement=<?php echo $modePaiement;?>">Modifier</a></td>
        <td><a href="index.php?uc=annuFact&amp;action=suppFact&amp;ordre=<?php lireDonneeUrl('ordre')?>&amp;num=<?php echo $num;?>" onclick="sur()">Suppression</a></td>
        </tr><?php }?>

        </tbody>
        </table> 


        
        
    <?php }?>
    </div>


        <?php if (lireDonneeUrl('ordre')!='prelevement'){?>

        <div style="display: flex; flex-direction: column; margin-right :100px">
        <?php include 'v_listeFamilles.php';?>
        </div>
        
    </div>
        

        <a href='index.php?uc=annuFact&amp;action=validerMoisFact' style="position:fixed;width:500px;right:200px;bottom:20px" class='btn btn-md btn-secondary display-4'>Valider le mois de facturation</a>
        
        <?php }}?>
          
        
        
        <?php if($action=="modifFact"){?>

        <form method="post" action="index.php?uc=annuFact&amp;action=validFact&amp;num=<?php echo $numAModif;?>">

        <fieldset>
            <legend>Modification de la facturation n°<?php echo $numAModif?></legend>
            <label for="montantFact">Montant :</label>
            <select name='montantFact'>
                <?php foreach ($lesTarifs as $unTarif)
                    {
                        $idTarif=$unTarif['id_Tarifs'];
                        $montantTar=$unTarif['montant_Tarifs'];
                        $libelleTar=$unTarif['libelle_Tarifs'];
                        echo '<option value="'.$idTarif.'"'; 
                        if (lireDonneeUrl('montant')==$montantTar){echo ' selected';} echo '>'.$libelleTar.'</option>';
                    }
                ?>
                
            </select><br/>
            <?php 
            /* <label for="montantEncFact">Montant encaissé</label>
            <input type='text' name='montantEncFact' value='<?php echo $montantEnc; ?>'/>*/?>
            <?php /* <label for="encFact">Encaissé ? </label>
            <input type='checkbox' name='encFact' value='1'<?php if($encFact==1){echo 'checked';}?>/><br/>*/?>
            <input type="submit"/>
        </fieldset>
        </form><?php  } ;                 
        if ($action=='ajoutFact'){?>
        <form method="post" action="index.php?uc=annuFact&amp;action=validAjoutFact">
        <fieldset>
            <legend>Ajout de facturation</legend>
            <label for="slctNomFam">Nom de la famille:</label>
            <select id="slctNomFam" name="slctNomFam"><?php
                foreach ($lesFam as $uneFam)
                    { 
                    $unNumFam=$uneFam["numero_Famille"];
                    $unNomFam=$pdoChaudoudoux->obtenirNomFamille($unNumFam);
                    if ($unNumFam!=9999){ echo '<option value="'.$unNumFam.'" >'.$unNomFam.' '.$unNumFam.'</option>';}
                    }
                    ?>
            </select>
           <label for="montantFact">Tarif :</label>
           <select id='montantFact' name="montantFact">
               <?php foreach ($lesTarifs as $unTarif)
               {
                   $idTarif=$unTarif['id_Tarifs'];
                   $montantTar=$unTarif['montant_Tarifs'];
                   $libelleTar=$unTarif['libelle_Tarifs'];
                   echo '<option value="'.$idTarif.'">'.$libelleTar.'</option>';
               }?>
           </select><br/>
         <?php /*  <label for="encFact">Encaissé ? </label>
           <input type='checkbox' id='encFact' value='1' name="encFact"/><br/>
           <label for="montantEnc">Montant encaissé</label>
           <input type='text' id='montantEncFact' name="montantEncFact" />*/?>
           
           <input type="submit"/>
           </fieldset>
                         </form><?php } ?>
          
           

  <?php if($action=='voirTousEncaisse'|| $action=='voirAncienEncaisse'){?>
<!-- Division pour le contenu principal -->
      <h2>Liste des facturations encaissées </h2>
      <table class="sortable zebre" id="listeFact">
        <tr>
            <th>Nom Parents</th><th>Montant</th><th>Date</th><th>Mode Paiement</th><th>Modifier</th><th>Suppression</th>
        </tr>
<?php      
    foreach($lesFacturesEnc as $uneFactureEnc) {
        $numFam=$uneFactureEnc["numFam"];
        $num = $uneFactureEnc["idFact_Factures"];
        $noms=$pdoChaudoudoux->obtenirNomFamille($numFam);
        $montant=$uneFactureEnc["montantFact_Factures"];
        $montantEnc=$uneFactureEnc["montantEnc_Factures"];
        $date = $uneFactureEnc["dateFact_Factures"];     
        $modePaiement=$uneFactureEnc["modePaiement_Facture"];
               ?><tr>
           <td><a href="index.php?uc=annuFamille&amp;action=voirDetailFamille&amp;num=<?php echo $numFam;?>"><?php echo $num; ?></a></td>
           <td>     <?php echo $noms; ?>
           </td>
           <td><?php echo $montant;?></td>
           <td><?php if (dateToString($date)!='//'){echo dateToString($date);}?></td>
           <td> <?php echo $modePaiement;?></td>

           <td><a href="index.php?uc=annuFact&amp;action=modifDetailFact&amp;num='<?php echo $num;?>'">Modifier</a></td>
           <td><a href="index.php?uc=annuFact&amp;action=suppFact&amp;ordre=<?php lireDonneeUrl('ordre')?>&amp;num=<?php echo $num;?>" onclick="sur()">Suppression</a></td></tr>
<?php } ?></table>      
 <a href="index.php?uc=annuFact&amp;action=ajoutFact">Ajouter une facturation</a><?php }?>


 
<!--<a class="btn btn-md btn-secondary display-4" href="index.php?uc=annuFact&amp;action=voirTousFact&ordre=alpha">RETOUR</a>-->


<!--<a class="btn btn-md btn-secondary display-4" style="position:fixed;right:200px;bottom:100px" href="index.php?uc=annuFact&action&amp;action=voirTousFact&ordre=alpha">RETOUR</a>-->
<!--<button style="position:fixed;bottom:0px;left:0px" class="btn btn-md btn-secondary display-4" onclick="history.go(-1);">RETOUR</button>-->
 

