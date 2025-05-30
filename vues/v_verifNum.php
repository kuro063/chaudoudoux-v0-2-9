<?php
/* La directive @var permet de déclarer une variable créée dans un script séparé 
 * du présent script, et ainsi de bénéficier de l'auto-complétion sur cette variable
 */
/* @var $lesFactures array */
?>
<!-- Division pour le contenu principal -->
    <div id="contenu">
      <h2>Vérification homonymie</h2>
      <p> Afin d'éviter les erreurs dûes à l'homonymie, voici les résultats de la base de données pour ce que vous avez entré.
          Si il y a plusieurs résultats pour une seule et même personne, merci de vérifier laquelle vous souhaitez.</p>
     <br/>
     <p>Résultats trouvés pour la famille : <?php
     foreach ($NumFam as $unNumFam) 
     {
         echo $unNumFam['numero_Famille'];?><br/><?php
     }?>
     Résultats trouvés pour l'intervenant : <?php
     foreach ($numInterv as $unNumInterv) 
     {
         echo $unNumInterv['numSalarie_Intervenants'];?><br/><?php
     }?>

     <form method="post" action="index.php?uc=attribution&amp;action=verifNum">
         <fieldset>
             <legend>Votre choix de famille :</legend>
         <select id="numFam">
<?php
     foreach ($NumFam as $unNumFam) 
     {
         echo '<option value='.$unNumFam['numero_Famille'].'>'.$unNumFam['numero_Famille'].'</option>';
     }?>
         </select>
         </fieldset>
         <fieldset>
             <legend>Votre choix d'intervenant :</legend>
         <select id="numInterv">
<?php
     foreach ($numInterv as $unNumInterv) 
     {
         echo '<option value='.$unNumInterv['numSalarie_Intervenants'].'>'.$unNumInterv['numSalarie_Intervenants'].'</option>';
     }?>
         </select>
         </fieldset>
         <fieldset>
             <input type="submit"/>
         </fieldset>
     </form>