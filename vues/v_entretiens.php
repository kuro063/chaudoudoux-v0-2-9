<!DOCTYPE html>
<head>
  <meta charset="utf-8">
  <title>Voir les Entretiens</title>
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
        $('#listeEntretien').DataTable({
          'scrollY':475,
          layout: {
            topStart: {
              pageLength: {
                menu: [10, 25, 50, -1]
              }, 
              buttons:[{
                extend: 'csvHtml5',
                text: 'Exporter en csv',
                title: <?php if (lireDonneeUrl('statut') == 'pro'){?>'Liste_Entretien_Pro'<?php } elseif(lireDonneeUrl('statut') == 'indiv'){?>'Liste_Entretien_indiv'<?php }else{?>'Liste_Tous_Entretiens'<?php } ?>,
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
        $('#listeEntretienTous').DataTable({
          'scrollY':475,
          layout: {
            topStart: {
              pageLength: {
                menu: [10, 25, 50, -1]
              }, 
              buttons:[{
                extend: 'csvHtml5',
                text: 'Exporter en csv',
                title: 'Liste_Tous_Entretiens',
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
  <?php if(lireDonneeUrl('uc')=='annuSalarie'){ ?> 
    <h3 style="text-align: center"><?php if (lireDonneeUrl('statut') == 'pro'){?> Entretiens professionnelles :
    <?php } elseif(lireDonneeUrl('statut') == 'indiv'){ ?> Entretiens individuelles :
    <?php } else {?>Tous Les entretiens <?php } ?></h3>
    <div style="margin-right:52px; margin-left:36px">
      <?php if (lireDonneeUrl('status') == 'pro' || lireDonneeUrl('status') == 'indiv'){ ?>
      <table class="zebre" id="listeEntretien">
        <thead> 
          <tr class="btn-secondary">
            <th>ID Salarie</th>
            <th>Titre</th>
            <th>Nom</th>
            <th>Prenom</th>
            <th>Dates entretiens</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($entretien as $dataEntretien){ ?>
          <tr>
            <td class="nom_col"><?php echo $dataEntretien['idSalarie_Intervenants'];?></td>
            <td class="nom_col"><?php echo $dataEntretien['titre_Candidats'];?></td>
            <td class="nom_col" ><a href="index.php?uc=annuSalarie&amp;action=voirDetailSalarie&amp;num=<?php echo $dataEntretien['numSalarie_Intervenants']; ?>">
              <?php echo $dataEntretien['nom_Candidats'];?></a></td>
            <td class="nom_col"><?php echo $dataEntretien['prenom_Candidats'];?></td>
            <td class="nom_col"><?php echo $dataEntretien['dates'];?></td>
          </tr>
        <?php }?>
        </tbody>
      </table>
      <?php } else{ 
        /*$entretien = array_merge($entretienPro, $entretienIndiv);*/?>

      <table class="zebre" id="listeEntretienTous">
        <thead> 
          <tr class="btn-secondary">
            <th>ID Salarié</th>
            <th>Titre</th>
            <th>Nom</th>
            <th>Prenom</th>
            <th>Entretien Pro</th>
            <th>Entretiens individuel</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($entretien as $dataRDV){?>
          <tr>
            <td class="nom_col"><?php echo $dataRDV['idSalarie_Intervenants'];?></td>
            <td class="nom_col"><?php echo $dataRDV['titre_Candidats'];?></td>
            <td class="nom_col" ><a href="index.php?uc=annuSalarie&amp;action=voirDetailSalarie&amp;num=<?php echo $dataEntretien['numSalarie_Intervenants']; ?>">
              <?php echo $dataRDV['nom_Candidats'];?></a></td>
            <td class="nom_col"><?php echo $dataRDV['prenom_Candidats'];?></td>
            <td class="nom_col"><?php echo $dataRDV['dates_pro'];?></td>
            <td class="nom_col"><?php echo $dataRDV['dates_indiv'];?></td>
          </tr>
        <?php }?>
        </tbody> 
      <?php }?> 
    </table>
    </div>
  <?php ;}?>
</div>
</body>
</html>