<div id="contenu">
  <?php if(lireDonneeUrl('uc')=='annuSalarie'){ ?> 
    <h3 style="text-align: center"><?php if (lireDonneeUrl('statut') == 'pro'){?> Entretiens professionnelles :
    <?php } elseif(lireDonneeUrl('statut') == 'indiv'){ ?> Entretiens individuelles :
    <?php } else {?>Tous Les entretiens <?php } ?></h3>
      <table class="sortable zebre" id="listeEntretient">
        <thead> 
          <tr class="btn-secondary">
            <th>ID Salarie</th>
            <th>Titre</th>
            <th>Nom</th>
            <th>Prenom</th>
            <th>Date entretien</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($entretien as $dataEntretien){ ?>
          <tr>
            <td class="nom_col"><?php echo $dataEntretien['numSalarie_Intervenants'];?></td>
            <td class="nom_col"><?php echo $dataEntretien['titre_Candidats'];?></td>
            <td class="nom_col" ><a href="index.php?uc=annuSalarie&amp;action=voirDetailSalarie&amp;num=<?php echo $dataEntretien['numSalarie_Intervenants']; ?>">
              <?php echo $dataEntretien['nom_Candidats'];?></a></td>
            <td class="nom_col"><?php echo $dataEntretien['prenom_Candidats'];?></td>
            <td class="nom_col"><?php echo $dataEntretien['dates'];?></td>
          </tr>
        <?php }?>
        </tbody>  
      </table>
  <?php ;}?>
</div>