<body class="staticPages">
<?php
$num = lireDonneeUrl('num');
if (lireDonneeUrl('type')=='salarie'){
    ?>

    <h2 style="font-size:1.6em"><u>Fiche de <b><?php echo $nom.' '.$prenom;?></u></b></h2>

    <p style="font-size:1.3em;line-height:2em">Habite au <?php echo $adresse.' '.$cp.' '.$ville; ?><br/>

    <?php echo 'Téléphone : <b>' . $telPort . '</b>'; /*if (isset ($telFixe) && $telFixe!='') {echo '</br>Domicile : <b>'.$telFixe. '</b>'; } if (isset($telUrg)&& $telUrg!=""){echo ' ou '.$telUrg;}*/?><br/>

    E-mail : <?php echo '<b>' . $email . '</b>';?><br/>
    Né le <?php echo dateToString($dateNaiss).' à '.$lieuNaiss; if (isset($paysNaiss)){echo '('.$paysNaiss.')';}?><br/>
    N° de sécurité sociale: <b><?php echo $numSS.'</b></p>';
}  
else {
?>

    <h2 style="font-size:1.3em"><u>Fiche de la famille <b><?php echo $pdoChaudoudoux->obtenirNomFamille(lireDonneeUrl('num')).'</u></b> ('; /*if($reg=='NON'){ echo 'PREST'.')';} else {echo $reg.*/ 
    if ($prestm==1 && $prestge==1){echo 'PRESTATAIRE MÉNAGE | PRESTATAIRE GARDE D&#146ENFANTS)<b>*</b>';}elseif ($prestm==1 && $mand==1){echo 'PRESTATAIRE MÉNAGE | MANDATAIRE)<b>*</b>';}elseif ($prestge==1 && $mand==1){echo 'PRESTATAIRE GARDE D&#146ENFANTS | MANDATAIRE)<b>*</b>';}
    elseif ($prestm==1){echo 'PRESTATAIRE MÉNAGE)<b>*</b>';}elseif ($prestge==1){echo 'PRESTATAIRE GARDE D&#146ENFANTS)<b>*</b>';}elseif ($mand==1){echo 'MANDATAIRE)<b>*</b>';}?></h2><br/>

    <p style="font-size:1em">
        La famille habite au <b><?php echo $adresse.' '.$cp.' '.$ville; ?></b><?php /*if($tel!=''){echo '<br/>Domicile : <b>' . $tel . '</b>';} */?></br>
        Quartier : <b><?php echo $quart;?></b></br>
        N° Bus : <b><?php echo $ligneBus;?></b></br>
        Arrêt de bus : <b><?php echo $arretBus;?></b></br></br>

        <b>Parents :</b><br/>
        <?php foreach ($parents as $parent){
            echo $parent['nom_Parents'].' '.$parent['prenom_Parents'].'. Téléphone :<b> '.$parent['telPortable_Parents'].'</b><br/>';
        }?><br/><?php ?>

        <b>Enfants :</b><br/> 
        <?php foreach ($enfants as $enfant){
            echo $enfant['nom_Enfants'].' '.$enfant['prenom_Enfants'].' né le '.dateToString($enfant['dateNaiss_Enfants']).'<br/>';
        }?><br/>

        <?php 
        if ($prestm==1) {echo '<b style="font-size:1.5em">*</b>La famille ' . $pdoChaudoudoux->obtenirNomFamille(lireDonneeUrl('num')) . ' est <b>PRESTATAIRE EN MÉNAGE</b>, Chaudoudoux est votre EMPLOYEUR.</br>' ;} 

        if ($prestge==1) {echo '<b style="font-size:1.5em">*</b>La famille ' . $pdoChaudoudoux->obtenirNomFamille(lireDonneeUrl('num')) . ' est <b>PRESTATAIRE EN GARDE D&#146ENFANTS</b>, Chaudoudoux est votre EMPLOYEUR.</br>' ;} 

        if ($mand==1) {echo '<b style="font-size:1.5em">*</b>La famille ' . $pdoChaudoudoux->obtenirNomFamille(lireDonneeUrl('num')) . ' est <b>MANDATAIRE EN GARDE D&#146ENFANTS</b>, c&#146est votre EMPLOYEUR.</br>
        &nbsp;&nbsp;&nbsp;Elle vous rémunère.' ;} 
        ?>

    </p>
        
    
	
<?php 
}
?>
<button style="position:fixed;bottom:0px;left:0px" class="btn btn-md btn-secondary display-4" onclick="history.go(-1);">RETOUR</button>
</body>
<?php
/*

FAMILLE "NOM" | TYPE PRESTATION / ADHÉSION

COORDONNÉES : 
adresse
numéros téléphone ENLEVER SON NUMERO DE TELEPHONE
parents
enfants


La famille "NOM" est MANDATAIRE EN GARDE D'ENFANTS, elle est votre EMPLOYEUR.
La famille "NOM" vous rémunère.

La famille "NOM" est PRESTATAIRE EN MÉNAGE, CHAUDOUDOUX est votre EMPLOYEUR.

La famille "NOM" est PRESTATAIRE EN GARDE D'ENFANTS, CHAUDOUDOUX est votre EMPLOYEUR.

*/


/*BROUILLON*/

/*La famille <?php echo $pdoChaudoudoux->obtenirNomFamille(lireDonneeUrl('num'))?> est <b>MANDATAIRE EN GARDE D'ENFANTS </b>, c'est votre EMPLOYEUR.
Elle vous rémunère.<br/>

La famille <?php echo $pdoChaudoudoux->obtenirNomFamille(lireDonneeUrl('num'))?> est <b>PRESTATAIRE EN MÉNAGE </b>, Chaudoudoux est votre EMPLOYEUR.<br/>

La famille <?php echo $pdoChaudoudoux->obtenirNomFamille(lireDonneeUrl('num'))?> est  <b>PRESTATAIRE EN GARDE D'ENFANTS </b>, Chaudoudoux est votre EMPLOYEUR.<br/>*/