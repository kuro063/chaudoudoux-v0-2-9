<?php
/* La directive @var permet de déclarer une variable créée dans un script séparé 
 * du présent script, et ainsi de bénéficier de l'auto-complétion sur cette variable
 */
/* @var $etudiant array
 */
                 

?>
<!-- Division pour le contenu principal -->
      <div id="contenu">
    
          <h2>Fiche de <?php echo filtreChainePourNavig(strtoupper($nom)) ; ?>&nbsp;<?php echo filtreChainePourNavig($prenom) ; ?>(<?php echo filtreChainePourNavig($idSalarie) ; ?>)</h2>
          <table class="tabNonQuadrille">
           <caption>Informations personnelles</caption>
           <tr>
                <td class="libelle">Date de naissance : </td>
                <td><?php echo filtreChainePourNavig($dateNaiss->format('d/m/Y')); ?></td>
            </tr>
            <tr>
                <td class="libelle">Lieu de naissance : </td>
                <td><?php echo filtreChainePourNavig($lieuNaiss)." (".filtreChainePourNavig($paysNaiss).")"; ?></td>
            </tr>
            <tr>
                <td class="libelle">Nationalité : </td>
                <td><?php echo filtreChainePourNavig($natio); ?></td>
            </tr>
            <tr>
              <td class="libelle">Numéro de Sécurité Sociale : </td>
              <td><?php echo filtreChainePourNavig($numSS) ; ?></td>
            </tr>
            <tr>
              <td class="libelle">Situation familiale : </td>
              <td><?php if ($sitFam == "CELIB"){
                echo "Célibataire";
              } else if ($sitFam == "COUPL"){
                echo "En couple";
              } else if ($sitFam == "MAR"){
                echo "Marié(e)";
              } else if ($sitFam == "PACS"){
                echo "Pacsé(e)";
              } else if ($sitFam == "VEUF"){
                echo "Veuf(ve)";
              }?>
              </td>
            </tr>
            </table>
           <table class="tabNonQuadrille">
            <caption>Coordonnées</caption>
            <tr>
              <td class="libelle">Adresse : </td>
              <td><?php echo filtreChainePourNavig($adresse) ; ?></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><?php echo filtreChainePourNavig($cp); ?>&nbsp;<?php echo filtreChainePourNavig($ville); ?></td>
            </tr>

            <tr>
              <td class="libelle">Tél. : </td>
              <td><?php echo filtreChainePourNavig($telPort) ; ?>&nbsp;<?php echo filtreChainePourNavig($telFixe);?></td>
            </tr>
            <tr>
              <td class="libelle">Tél. en cas d'urgences : </td>
              <td><?php echo filtreChainePourNavig($telUrg) ; ?></td>
            </tr>
            <tr>
              <td class="libelle">Email : </td>     
              <td><a href="mailto:<?php echo filtreChainePourNavig($email) ;?>"><?php echo filtreChainePourNavig($email) ; ?></a></td>
            </tr>
           </table>
            
           <table class="tabNonQuadrille">
            <caption>Informations professionnelles</caption>
            <tr>
              <td class="libelle">Prestation(s) : </td>
              <td><?php foreach ($prestations as $presta) {
				  //print_r($presta);
				  echo $presta['type_Prestations']."<br/>";
			  }?></td>
            </tr>
            <tr>
              <td class="libelle">Statut professionnel : </td>
              <td><?php echo strtoupper($statutPro);
                    ?></td>
            </tr>
            <tr>
              <td class="libelle">Diplômes : </td>
              <td><?php echo filtreChainePourNavig($diplomes) ; ?></td>
            </tr>
            <tr>
              <td class="libelle">Qualifications : </td>
              <td><?php echo filtreChainePourNavig($qualifs) ; ?></td>
            </tr>
            <tr>
              <td class="libelle">Certifications : </td>
              <td><?php echo filtreChainePourNavig($certifs) ; ?></td>
            </tr>
            <tr>
              <td class="libelle">Expérience avec les bébés de moins de trois ans : </td>
              <td><?php if($expBBmoins1a == 1){
                echo "Oui";
                } else {
                  echo "Non";
                  } ?></td>
            </tr>
            <tr>
              <td class="libelle">Enfants handicapés ?</td>
              <td><?php if($enfantHand == 1){
                echo "Oui";
                } else {
                  echo "Non";
                  } ?></td>
            </tr>
            <tr>
                <td class="libelle">Disponibilités : </td>
                <td><?php echo filtreChainePourNavig($dispo); ?></td>
            </tr>
            <tr>
                <td class="libelle">Date d'entrée : </td>
                <td><?php echo filtreChainePourNavig($dateEntree->format('d/m/Y')); ?></td>
            </tr>
            <tr>
                <td class="libelle">Date de sortie : </td>
                <td><?php  if ($dateSortie != '0000-00-00 00:00:00' && isset($dateSortie)) echo dateToString($dateSortie); ?></td>
            </tr>
            <tr>
                <td class="libelle">Taux horaire demandé : </td>
                <td><?php echo filtreChainePourNavig($tauxH); ?></td>
            </tr>
            <tr>
                <td class="libelle">Nombre d'heures par semaine souhaitées : </td>
                <td><?php echo filtreChainePourNavig($nbHeureSem); ?></td>
            </tr>
            <tr>
                <td class="libelle">Nombre d'heures par mois souhaitées : </td>
                <td><?php echo filtreChainePourNavig($nbHeureMois); ?></td>
            </tr>
            <tr>
              <td class="libelle">Recherche complément d'heures : </td>
              <td><?php if($rechCompl == 1){
                echo "Oui";
                } else {
                  echo "Non";
                  } ?></td>
            </tr>
            <tr>
              <td class="libelle">PSC1 : </td>
              <td><?php if($psc1 == 1){
                echo "Oui";
                } else {
                  echo "Non";
                  } ?></td>
            </tr>
           </table>
           <table class="tabNonQuadrille">
           <caption>Autres informations</caption>
           <tr>
              <td class="libelle">Permis : </td>
              <td><?php if($permis == 1){
                echo "Oui";
                } else {
                  echo "Non";
                  } ?></td>
            </tr>
            <tr>
              <td class="libelle">Véhicule : </td>
              <td><?php if($vehicule == 1){
                echo "Oui";
                } else {
                  echo "Non";
                  } ?></td>
            </tr>
            <tr>
                <td class="libelle">Justificatifs : </td>
                <td><?php echo filtreChainePourNavig($justifs); ?></td>
            </tr>
            <tr>
                <td class="libelle">Observations : </td>
                <td><?php echo filtreChainePourNavig($observ); ?></td>
            </tr>
            <tr>
                <td class="libelle">CV / Lettre de motivation : </td>
                <td><?php echo filtreChainePourNavig($observ); ?></td>
            </tr>
          </table>
          
          
          
      <p>
        <a href="index.php?uc=annuSalarie&amp;action=demanderModifSalarie&amp;num=<?php echo $num; ?>">Modifier</a>
      </p>
      
      <p>
        <!--<a href="index.php?uc=annuSalarie&amp;action=voirTousSalarie">Retour</a>-->
        <a class="btn btn-md btn-secondary display-4" href="index.php?uc=annuSalarie&amp;action=tousIntervenants">Retour</a>
        
      </p>
    </div>
<?php

?>