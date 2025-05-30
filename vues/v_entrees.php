<?php
/* La directive @var permet de déclarer une variable créée dans un script séparé 
 * du présent script, et ainsi de bénéficier de l'auto-complétion sur cette variable
 */
/* @var $lesFactures array */
?>
<!-- Division pour le contenu principal -->
<div id="contenu">
    <h2>Liste des familles susceptibles d'être facturées pour le mois à venir<!-- - --><?php /*echo $pdoChaudoudoux->obtenirTotalListeEntrees()*/?><!-- résultats--></h2>
    <table class='sortable zebre'>
        <thead>
        <th>M</th><th>Nom</th><th>Date d'entrée</th><th>Date de première intervention</th><th>Ajouter</th>
        </thead>
        <?php foreach ($lesEntrees as $uneEntree){
            $dateDeb=$uneEntree['dateDeb_Proposer'];
            if ($dateDeb=='0000-00-00'||$dateDeb==''){
                $dateDeb='';
            }
            else $dateDeb= dateToString ($dateDeb);
            echo '<tr><td>'.$uneEntree['numero_Famille'].'</td><td><a href="index.php?uc=annuFamille&amp;action=voirDetailFamille&amp;num='.$uneEntree['numero_Famille'].'">'.$pdoChaudoudoux->obtenirNomFamille($uneEntree['numero_Famille']).'</a></td><td>'.dateToString($uneEntree['dateEntree_Famille']).'</td><td>'.$dateDeb.'</td><td><a href="index.php?uc=annuFact&amp;action=ajoutEntree&amp;ordre=alpha&amp;num='.$uneEntree['numero_Famille'].'">Ajouter</a></td></tr>';
        }?>
    </table>
</div>

