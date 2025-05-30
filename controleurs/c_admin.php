<?php

include("vues/v_sommaire.php");
// vérification du droit d'accès au cas d'utilisation
if ( ! estConnecte()) {
    ajouterErreur("L'accès à cette page requiert une authentification et seul le directeur a les droits pour accéder à cette page !", $tabErreurs);
    include('vues/v_erreurs.php');
}
else {
    $action = lireDonneeUrl('action', 'admin');
    switch ($action){
        case 'admin':
            $lesTarifs=$pdoChaudoudoux->obtenirTarifs();
            include ('vues/v_admin.php');
            break;
        case 'adresse':
            include ('vues/v_introAdresses.php');
            break;
        case 'ajoutUtil':
            $nom = lireDonneePost('nomUtil');
            $prenom= lireDonneePost('prenomUtil');
            $id= substr(strtolower($prenom), 0,1).strtolower($nom);
            $pdoChaudoudoux->ajoutUtil( $nom, $prenom, $id, $id, sha1($id));
            ajouterErreur("Utilisateur ajouté ! ", $tabErreurs);
                         $lesTarifs=$pdoChaudoudoux->obtenirTarifs();

            include ('vues/v_admin.php');
            include('vues/v_erreurs.php');

            break;
        case 'modifTar':
            $tarAModif= lireDonneePost('modifTar');
            $libelleTar= lireDonneePost('libelleTar');
            $montantTar= lireDonneePost('montantTar');
            $pdoChaudoudoux->modifTar($tarAModif, $libelleTar, $montantTar);
            $lesTarifs=$pdoChaudoudoux->obtenirTarifs();
                        include ('vues/v_admin.php');

            break;
        case 'ajoutTar':
            $libelleTar= lireDonneePost('libelleAjoutTar');
            $montantTar= lireDonneePost('montantAjoutTar');
            $pdoChaudoudoux->ajoutTar($libelleTar, $montantTar);   
            $lesTarifs=$pdoChaudoudoux->obtenirTarifs();
                        include ('vues/v_admin.php');

            break;
        case 'suppTar':
            $tarASupp= lireDonneeUrl('num');
            $pdoChaudoudoux->suppTar($tarASupp);
            $lesTarifs=$pdoChaudoudoux->obtenirTarifs();
                        include ('vues/v_admin.php');

            break;
        default : include ('vues/v_admin.php');
    }
}