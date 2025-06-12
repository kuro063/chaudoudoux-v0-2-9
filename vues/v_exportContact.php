<html>
  <head>
    <meta charset="utf-8">
    <title>Exporter les contacts</title>
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.3.1/css/dataTables.dataTables.css" />
    <script type="text/javascript" src="https://cdn.datatables.net/2.3.1/js/dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/buttons/3.2.3/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.3/js/buttons.html5.min.js"></script>

    <script src="https://cdn.datatables.net/buttons/3.2.3/js/buttons.dataTables.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.3/css/buttons.dataTables.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.1/css/dataTables.dataTables.css"/>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script type="text/javascript"> 
      $(document).ready(function() {
        $('#contactFamille').DataTable({
          'scrollY':475,
          layout: {
            topStart: {
              pageLength: {
                menu: [10, 25, 50, -1]
              }, 
              buttons:[{
                extend: 'csvHtml5',
                text: 'Exporter en csv',
                title: <?php if (lireDonneeUrl('registre') == 'nonArchive'){?>'Contact_Famille'<?php } else{?>'Contact_Famille_Archive'<?php }?>,
                fieldSeparator: ',',
                bom: true,
                exportOptions: {
                  modifier: {
                    page: 'current'
                  }
                }
              }]
            }
          }
        });
        $('#contactIntervenant').DataTable({
          'scrollY':420,
          layout: {
            topStart: {
              pageLength: {
                menu: [10, 25, 50, -1]
              }, 
              buttons:[{
                extend: 'csvHtml5',
                text: 'Exporter en csv',
                title: <?php if (lireDonneeUrl('registre') == 'nonArchive'){?>'Contact_Intervenant'<?php } else{?>'Contact_Intervenant_Archive'<?php }?>,
                fieldSeparator: ',',
                bom: true,
                exportOptions: {
                  modifier: {
                    page: 'current'
                  }
                }
              }]
            }
           }
        });
        $('#contactFamilleEtranger').DataTable({
          'scrollY':475,
          layout: {
            topStart: {
              pageLength: {
                menu: [10, 25, 50, -1]
              }, 
              buttons:[{
                extend: 'csvHtml5',
                text: 'Exporter en csv',
                title: 'Contact_Famille_Etranger',
                fieldSeparator: ',',
                bom: true,
                exportOptions: {
                  modifier: {
                    page: 'current'
                  }
                }
              }]
            }
          }
        });
        $('#contactIntervenantEtranger').DataTable({
          'scrollY':420,
          layout: {
            topStart: {
              pageLength: {
                menu: [10, 25, 50, -1]
              }, 
              buttons:[{
                extend: 'csvHtml5',
                text: 'Exporter en csv',
                title: 'Contact_Intervenant_Etranger',
                fieldSeparator: ',',
                bom: true,
                exportOptions: {
                  modifier: {
                    page: 'current'
                  }
                }
              }]
            }
           }
        });
      })
    </script>
  </head>
  <body>
    <div id="contenu">
      <?php if(lireDonneeUrl('uc') == 'information'){?>
        <?php if(lireDonneeUrl('type') == 'famille'&& lireDonneeUrl('region') != 'autre'){?>
          <h3 style="text-align: center"><?php if (lireDonneeUrl('registre') == 'nonArchive'){?>Exporter les contacts familles<?php } else{?>Exporter les contacts familles archivées<?php }?></h3>
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
                <td class="nom_col"><a href="index.php?uc=annuFamille&amp;action=voirDetailFamille&amp;num=<?php echo $num; ?>"> <?php echo 'CDX FAM ', $noms;?></a></td>
                <td class="nom_col"><?php echo $mailMaman;?></td>
                <td class="nom_col"><?php echo $mailPapa;?></td>
                <td class="nom_col"><?php echo $telMaman;?></td>
                <td class="nom_col"><?php echo $telPapa;?></td>
                <td class="nom_col"><?php echo $coord['adresse_Famille'];?></td>
                <td class="nom_col"><?php echo $coord['ville_Famille'];?></td>
                <td class="nom_col"><?php echo $coord['cp_Famille'];?></td>
                <td class="nom_col"><?php echo 'CDX INT '; ?><?php $enPostePrestMenage = $pdoChaudoudoux->obtenirSalariePrestMenagePresent($num);
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
        
          <?php } elseif(lireDonneeUrl('type') == 'intervenant' && lireDonneeUrl('region') != 'autre') { ?>
          <h3 style="text-align: center"><?php if (lireDonneeUrl('registre') == 'nonArchive'){?>Exporter les contacts intervenants<?php } else{?>Exporter les contacts intervenants archivées<?php }?></h3>
          <div style="margin-right:100px; margin-left:100px">
          <table class="zebre" id="contactIntervenant">
            <thead> 
              <tr class="btn-secondary">
              <th>First Name</th>
                <th>E-mail</th>
                <th>Phone</th>
                <th>Street</th>
                <th>City</th>
                <th>Postal Code</th>
                <th>Organization</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($lesSalaries as $unSalarie){ 
                      $nomSal = $unSalarie[3].' '.$unSalarie[4];
                      $mailSal = $unSalarie[21];
                      $telSal = $unSalarie[18];
                      $rueSal = $unSalarie[13];
                      $codePostalSal = $unSalarie[14];
                      $villeSal = $unSalarie[15];
                      $prestMandSal = $unSalarie[56].' '.$unSalarie[57];
              ?>
              <tr>
                <td class="nom_col"><?php echo 'CDX INT ', $nomSal;?></td>
                <td class="nom_col"><?php echo $mailSal;?></td>
                <td class="nom_col"><?php echo $telSal;?></td>
                <td class="nom_col"><?php echo $rueSal;?></td>
                <td class="nom_col"><?php echo $villeSal;?></td>
                <td class="nom_col"><?php echo $codePostalSal;?></td>
                <td class="nom_col"><?php echo 'CDX FAM ', $prestMandSal;?></td>
              </tr>
              <?php }?>
            </tbody>
            </div>

          <?php }elseif(lireDonneeUrl('type') == 'famille'&& lireDonneeUrl('region') == 'autre'){?>
          <h3 style="text-align: center">Exporter les contacts familles depuis l'étranger</h3>
          <div style="margin-right:32px; margin-left:16px">
          <table class="zebre" id="contactFamilleEtranger">
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
                      // 1. Supprimer les points avec str_replace
                      $telMaman = str_replace('.', '', $telMaman);
                      // 2. Supprimer le premier zéro avec substr
                      if (substr($telMaman, 0, 1) === '0') {
                          $telMamanFr = '+33' . substr($telMaman, 1);
                      }
                      /*
                      Toujours initialiser $telMamanFr et $telPapaFr à chaque tour de boucle.
                      Sinon, ils gardent la valeur précédente, ce qui donne des numéros incohérents.
                       */
                      else{
                        $telMamanFr = $telMaman;
                      }

                      $telPapa=$pdoChaudoudoux->obtenirTelPapa($num);
                        $telPapa = str_replace('.', '', $telPapa);
                        if (substr($telPapa, 0, 1) === '0') {
                            $telPapaFr = '+33' . substr($telPapa, 1);
                        }
                        else{
                          $telPapaFr = $telPapa;
                        }
                      

                      $mailMaman=$pdoChaudoudoux->obtenirMailMaman($num);
                      $mailPapa=$pdoChaudoudoux->obtenirMailPapa($num);

                      $enPostePrestMenage = $pdoChaudoudoux->obtenirSalariePrestMenagePresent($num);
                      $enPostePrestGE = $pdoChaudoudoux->obtenirSalariePrestGEPresent($num);
              ?>
              <tr>
                <td class="nom_col"><a href="index.php?uc=annuFamille&amp;action=voirDetailFamille&amp;num=<?php echo $num; ?>"> <?php echo 'CDX FAM ', $noms;?></a></td>
                <td class="nom_col"><?php echo $mailMaman;?></td>
                <td class="nom_col"><?php echo $mailPapa;?></td>
                <td class="nom_col"><?php echo $telMamanFr;?></td>
                <td class="nom_col"><?php echo $telPapaFr;?></td>
                <td class="nom_col"><?php echo $coord['adresse_Famille'];?></td>
                <td class="nom_col"><?php echo $coord['ville_Famille'];?></td>
                <td class="nom_col"><?php echo $coord['cp_Famille'];?></td>
                <td class="nom_col"><?php echo 'CDX INT '; ?><?php $enPostePrestMenage = $pdoChaudoudoux->obtenirSalariePrestMenagePresent($num);
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
            
          <?php } else{ ?>
          <h3 style="text-align: center">Exporter les contacts intervenants depuis l'étranger</h3>
          <div style="margin-right:100px; margin-left:100px">
          <table class="zebre" id="contactIntervenantEtranger">
            <thead> 
              <tr class="btn-secondary">
              <th>First Name</th>
                <th>E-mail</th>
                <th>Phone</th>
                <th>Street</th>
                <th>City</th>
                <th>Postal Code</th>
                <th>Organization</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($lesSalaries as $unSalarie){ 
                      $nomSal = $unSalarie[3].' '.$unSalarie[4];
                      $mailSal = $unSalarie[21];
                      $telSal = $unSalarie[18];
                      $telSal = str_replace('.', '', $telSal);
                      if (substr($telSal, 0, 1) === '0') {
                          $telSalFr = '+33' . substr($telSal, 1);
                      }
                      else{
                        $telSalFr = $telSal;
                      }
                      $rueSal = $unSalarie[13];
                      $codePostalSal = $unSalarie[14];
                      $villeSal = $unSalarie[15];
                      $prestMandSal = $unSalarie[56].' '.$unSalarie[57];
              ?>
              <tr>
                <td class="nom_col"><?php echo 'CDX INT ', $nomSal;?></td>
                <td class="nom_col"><?php echo $mailSal;?></td>
                <td class="nom_col"><?php echo $telSalFr;?></td>
                <td class="nom_col"><?php echo $rueSal;?></td>
                <td class="nom_col"><?php echo $villeSal;?></td>
                <td class="nom_col"><?php echo $codePostalSal;?></td>
                <td class="nom_col"><?php echo 'CDX FAM ', $prestMandSal;?></td>
              </tr>
              <?php }?>
            </tbody>
            </div>
        <?php }?>
      <?php }?>
    </div>
