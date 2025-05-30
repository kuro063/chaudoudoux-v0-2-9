<?php error_reporting(0);
$nomFormation = $nomFormationListe['intitule_Formations']; ?>

    <!-- 
    <div class="text-center">  
        <h2> LISTE DES PERSONNES AYANT SUIVI LA FORMATION : </h2> 
    </div>

    <div class="text-center text-primary">
        <h2> <?php echo $nomFormation ?> </h2>
    </div> -->

    <div id="<?php echo $num?>" class="mt-3 mb-3 row justify-content-center">
        <table class="table-striped">
            <tr class="btn-secondary">
            <th style="column-width:12rem"> Numéro du salarié </th><th style="column-width:12rem"> Nom du formé(e) </th> <th style="column-width:12rem"> Prénom du formé(e) </th>
            <th style="column-width:12rem"> Famille </th>
            </tr>

        <?php      
        foreach($ListeIndividuFormee as $unIndividu) {
            $nomForm=$unIndividu['idForm_Formations'];
            $numSal=$unIndividu['idSalarie_Intervenants'];
            $numInt=$unIndividu['numSalarie_Intervenants'];
            $nom=$unIndividu['nom_Candidats'];
            $prenom=$unIndividu['prenom_Candidats'];
            // $numSal=$unIndividu['prenom_Candidats'];
            $nomFamille = $pdoChaudoudoux->obtenirFormSuivi(lireDonneeUrl('num'), $numInt);

            $affichageFamille = $pdoChaudoudoux->obtenirNomFamille($nomFamille['numFamille']);

            if ($affichageFamille == 'MAISON DES CHAUDOUDO') 
            {
            $affichageFamille = 'CHAUDOUDOUX';
            }
        ?>

        <tr>
            <td> <?php echo $numSal; ?> </td>
            <td> <a href="index.php?uc=annuSalarie&amp;action=voirDetailSalarie&amp;num=<?php echo $numInt; ?>"> <?php echo $nom;?> </a> </td>
            <td> <?php echo $prenom;?> </td>
            <td style="text-align: center;"> <?php if (isset($nomFamille['numFamille'])==FALSE) {echo' NON RENSEIGNÉE';} else{ ?> <span style="font-weight:bold;"> <?php echo $affichageFamille;} ?> </span> </td>
        </tr>
            
      <?php } ?>
        </table>
    </div>

    