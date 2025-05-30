<?php
if (estConnecte()){
?> 
<div id="contenu">
    <h2>Résultats</h2>
<?php
//echo $vehicule;
	if ($categ == "Famille"){
?>
	<table class="tabQuadrille" id="listeFamilles">
        <tr>
            <th>Nom(s)</th><th>Nombre d'enfants</th><th>Type d'adhésion</th><th>Prestations</th>
        </tr>
<?php      
    foreach($res as $uneFamille) {
        
        $num = $uneFamille["numero_Famille"];
        $noms=$pdoChaudoudoux->obtenirNomFamille($num);
        $tabNbEnfants = $pdoChaudoudoux->obtenirNbEnfants($num);
        $nbEnfants = $tabNbEnfants['nbEnfants'];       
   
      if ($num!=9999){ ?><tr>
           <td><a href="index.php?uc=annuFamille&amp;action=voirDetailFamille&amp;num=<?php echo $num; ?>">
                <?php echo $noms; ?></a>
           </td>
           <td><?php echo $nbEnfants ; ?></td>
           
       
      <?php 
    $prestations=$pdoChaudoudoux->obtenirPrestaFamille($num);
    $nomPresta = "";
    $prestMand = "";
    foreach ($prestations as $presta) {
      $nomPresta .= $presta['type_Prestations']."/";
      $prestMand .= $presta['intitule_TypeADH']."/";
    }
?>
      <td><?php echo substr($prestMand, 0, strlen($prestMand)-1) ;?></td>
      <td><?php echo substr($nomPresta, 0, strlen($nomPresta)-1) ;?></td>
      </tr>
<?php }
    }
?>
      </table>
<?php 
	} elseif ($categ == "Interv") {
?>
	<table class="tabQuadrille" id="listeSalaries">
        <tr>
            <th>Nom</th><th>Prénom</th><th>Date de naissance</th><th>Statut Prof.</th><th>Vehicule</th>
        </tr>
<?php      
    foreach ($res as $unSalarie) {
        // traitement de l'étudiant (enregistrement) courant
        $num = $unSalarie["numSalarie"];
        $nom = $unSalarie["nom"];
        $prenom = $unSalarie["prenom"];
        $dateNaiss = new DateTime ($unSalarie["dateNaiss"]);
        $statutPro = $unSalarie["statutPro"];
        $vehicule = $unSalarie["vehicule"];
?>      
         
       <tr>
           <td><a href="index.php?uc=annuSalarie&amp;action=voirDetailSalarie&amp;num=<?php echo $num; ?>">
                <?php echo $nom; ?></a>
           </td>
           <td><?php echo $prenom ; ?></td>
           <td><?php echo $dateNaiss->format('d/m/Y'); ?></td>
           <td><?php 
                echo $statutPro; ?>
           </td>
           <td><?php if($vehicule == 1){
                echo "Oui";
                } else {
                  echo "Non";
                  } ?>
           </td>
       </tr>
<?php
    }
?>
      </table>
<?php
	} elseif ($categ == "Candid") {
?>
<table class="tabQuadrille" id="listeCandid">
      
        <tr>
            <th>Nom</th><th>Prénom</th><th>Date de naissance</th><th>Nationalité</th><th>Statut Pro</th><th>Décision</th>
        </tr>
<?php      
    foreach ($res as $unCandidat) {
        $num = $unCandidat["numCandidat_Candidats"];
        $nom = $unCandidat["nom_Candidats"];
        $prenom = $unCandidat["prenom_Candidats"];
        $dateNaiss = new DateTime($unCandidat["dateNaiss_Candidats"]);
        $natio = $unCandidat["nationalite_Candidats"];
        $statutPro = $unCandidat["statutPro_Candidats"];
?>        
       <tr>
           <td>
                <a href="index.php?uc=annuCandid&amp;action=voirDetailCandid&amp;num=<?php echo $num; ?>"><?php echo $nom; ?></a>
           </td>
           <td><?php echo $prenom ; ?></td>
           <td><?php echo $dateNaiss->format('d/m/Y'); ?></td>
           <td><?php echo $natio; ?></td>
           <td><?php if($statutPro == 'ETUD'){
            echo "Etudiant";
            } else if ($statutPro == 'PRO'){
              echo "Professionnel";
            } ?></td>
            <td>
                <a href="index.php?uc=annuCandid&amp;action=decisionCandid&amp;num=<?php echo $num; ?>">Accepter/Refuser</a>
           </td>
       </tr>
<?php
    }
?>
      </table>
<?php
	}
        elseif ($categ="Fact"){?>
                 <table class="tabQuadrille" id="listeFact">
        <tr>
            <th>Numéro</th><th>Nom Parents</th><th>Montant</th><th>Date</th>
        </tr>
<?php      
    foreach($res as $uneFacture) {
        $numFam=$uneFacture["numFam"];
        $num = $uneFacture["idFact_Factures"];
        $noms = $uneFacture["nom1"];
        $montant=$uneFacture["montantFact_Factures"];
        $date = $uneFacture["dateFact_Factures"];       
?>     
       <tr>
           <td><a href="index.php?uc=annuFamille&amp;action=voirDetailFamille&amp;num=<?php echo $numFam;?>"><?php echo $num; ?></a></td>
           <td>     <?php echo $noms; ?>
           </td>
           <td><?php echo $montant ; ?></td>
           <td><?php echo $date;?></td>
    </tr><?php }?>
           </table>
    <?php           print_r($res);
        }
}
