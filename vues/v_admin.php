<?php
if (estConnecte()){
?>
<div id="contenu">
<form id="formModifTar" action="index.php?uc=admin&amp;action=modifTar" method="post">
    <fieldset>
        <legend>Tarifs exercés</legend>
        <label> Voici les tarifs actuels :<br/> <?php foreach ($lesTarifs as $unTarif){
            $libelleTar=$unTarif["libelle_Tarifs"];
            $montantTar=$unTarif["montant_Tarifs"];
            $idTarif=$unTarif["id_Tarifs"];
            echo $libelleTar." : ".$montantTar." €<br/>";
            }?></label><br/>
    </fieldset>
</form>
<form id="formAjoutTar" action="index.php?uc=admin&amp;action=ajoutTar" method="post" style="background: red">
    <fieldset>
        <legend>Ajout d'un nouveau tarif</legend>
        <label for="libelleAjoutTar">Libellé du nouveau tarif :</label>
        <input type="text" id="libelleAjoutTar" name="libelleAjoutTar"/>
        <label for="montantAjoutTar">Montant du nouveau tarif :</label>
        <input type="text" id="montantAjoutTar" name="montantAjoutTar"/><br/>
        <input type="reset"/>
        <input type="submit"/>
    </fieldset>
</form>
<form id="formAjoutUtil" action="index.php?uc=admin&amp;action=ajoutUtil" method="post" style="background: red">
    <fieldset>
        <legend>Ajout d'un utilisateur</legend>
        <label for="nomUtil">Nom :</label>
        <input type="text" required name="nomUtil" id="nomUtil"/>
        <label for="prenomUtil">Prenom :</label>
        <input type="text" required name="prenomUtil"/><br/>
        <input type="reset"/>
        <input type="submit"/><br/>
        <label>NB : L'identifiant de l'utilisateur sera la première lettre de son prénom suivie de son nom. Son mot de passe sera identique à l'identifiant 
            et sera à changer à la première connexion pour plus de sécurité.</label>
    </fieldset>
    
</form>
      <!-- <a href="general_log.php">Cliquez pour voir toutes les modifications faites sur la base</a>-->
</div>
<?php } 
