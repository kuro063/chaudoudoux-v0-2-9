<div id="contenu">
<?php 
    echo toHtmlErreurs($tabErreurs);
    echo '<button style="position:fixed;bottom:0px;right:0px" class="retour btn" onclick="history.go(-1);">RETOUR</button>';

    if(lireDonneeUrl('action')=='validerAjoutCandid'){
        echo "<br/>";
        echo ("<h4> Ajouter des disponibilités au candidat ? <h4>");
        //var_dump($numCand);
        echo("<a href=index.php?uc=annuCandid&action=demanderModifCandid&num=".$numCand.">OUI</a> </p>");
    }
?>
</div>
