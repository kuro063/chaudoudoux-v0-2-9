<html>
  <head>
    <meta charset="utf-8">
    <title>Exporter les contacts</title>
  </head>
  <body>
    <div id="contenu">
      <?php if(lireDonneeUrl('uc') == 'information'){?>
        <?php if(lireDonneeUrl('type') == 'famille'){?>
          <h3 style="text-align: center">Exporter les contacts familles</h3>
          <div style="margin-right:32px; margin-left:16px">
          <table class="zebre" id="contactFamille">
            <thead> 
              <tr class="btn-secondary">
                <th>First name</th>
                <th>E-mail</th>
                <th>E-mail</th>
                <th>Phone</th>
                <th>Phone</th>
                <th>Street</th>
                <th>City</th>
                <th>Postal Code</th>
                <th>Organization</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($lesFamilles as $uneFamille) {
                      $num = $uneFamille["numero_Famille"];
                      $noms=$pdoChaudoudoux->obtenirNomFamille($num);
                      $coord=$pdoChaudoudoux->obtenirCoordonneesFam($num);

                      $telMaman=$pdoChaudoudoux->obtenirTelMaman($num);
                      $telPapa=$pdoChaudoudoux->obtenirTelPapa($num);
                      $mailMaman=$pdoChaudoudoux->obtenirMailMaman($num);
                      $mailPapa=$pdoChaudoudoux->obtenirMailPapa($num);

                      $enPostePrestMenage = $pdoChaudoudoux->obtenirSalariePrestMenagePresent($num);
                      $enPostePrestGE = $pdoChaudoudoux->obtenirSalariePrestGEPresent($num);
              ?>
              <tr>
                <td class="nom_col"><a href="index.php?uc=annuFamille&amp;action=voirDetailFamille&amp;num=<?php echo $num; ?>"> <?php echo 'Famille ', $noms;?></a></td>
                <td class="nom_col"><?php echo $mailMaman;?></td>
                <td class="nom_col"><?php echo $mailPapa;?></td>
                <td class="nom_col"><?php echo $telMaman;?></td>
                <td class="nom_col"><?php echo $telPapa;?></td>
                <td class="nom_col"><?php echo $coord['adresse_Famille'];?></td>
                <td class="nom_col"><?php echo $coord['ville_Famille'];?></td>
                <td class="nom_col"><?php echo $coord['cp_Famille'];?></td>
                <td class="nom_col"><?php echo 'Intervenante(s): '; ?><?php $enPostePrestMenage = $pdoChaudoudoux->obtenirSalariePrestMenagePresent($num);
                foreach ($enPostePrestMenage as $unIntervPrestMenage){
                  echo $unIntervPrestMenage['nom_Candidats'].' '.$unIntervPrestMenage['prenom_Candidats'].' ';}?>
                <?php  $enPostePrestGE = $pdoChaudoudoux->obtenirSalariePrestGEPresent($num);
                foreach ($enPostePrestGE as $unIntervPrestGE){
                  echo $unIntervPrestGE['nom_Candidats'].' '.$unIntervPrestGE['prenom_Candidats'].' ';}?>
                <?php $enPosteMandGE = $pdoChaudoudoux->obtenirSalarieMandGEPresent($num);
                foreach ($enPosteMandGE as $unIntervMandGE){
                  echo $unIntervMandGE['nom_Candidats'].' '.$unIntervMandGE['prenom_Candidats'].' ';}?></td>
              </tr>
              <?php }?>
            </tbody>
            </div>  
        <?php }?>
      <?php }?>
    </div>