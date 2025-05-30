<div id="contenu">


    <h2 style="color:red;font-size:25px;">Toutes les disponibilités de l'intervenant vont être <strong>définitivement supprimées : </strong><h2>
    <?php 
    //Saut de ligne
    echo str_repeat('<br/>', 1);
    $numInterv = lireDonneeUrl('num');
    //On récupère le nom et prénom de l'intervenant dont on veux supprimer les disponibilités
    foreach($infoSS as $uneInfo){
        $nom = $uneInfo['nom_Candidats'];
        $prenom = $uneInfo['prenom_Candidats'];
    }
    //$saut sert à créer des espaces dans une ligne
    $saut = str_repeat('&nbsp', 10);

    //On affiche les informations de l'intervenant
    echo("Nom : ".$nom.$saut." Prénom : ".$prenom.$saut." Activite : ".$activite);
    echo ("<h4> Souhaitez vous continuer ? <h4>");
    echo str_repeat('<br/>', 3);

    //Si l'activite de l'intervenant est GE
    if($activite == 'garde d\'enfants'){
        //Bouton de validation
        echo "<td> <a href='index.php?uc=annuSalarie&action=validsupprimerAllDispoIntervGE&num=$numInterv'>OUI, TOUT SUPPRIMER</a> </p>";
    }
    
    elseif($activite == 'menage'){
        //Bouton de validation
        echo "<td> <a href='index.php?uc=annuSalarie&action=validsupprimerAllDispoIntervMenage&num=$numInterv'>OUI, TOUT SUPPRIMER</a> </p>";
    }

    //Bouton retour
    echo '<button style="position:fixed;bottom:0px;right:0px" class="retour btn" onclick="history.go(-1);">RETOUR</button>';

?>
</div>