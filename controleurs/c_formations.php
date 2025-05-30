<?php
/* La directive @var permet de déclarer une variable créée dans un script séparé 
 * du présent script, et ainsi de bénéficier de l'auto-complétion sur cette variable
 */
/* @var $pdoExetud PdoExetud */
/* @var $tabErreurs array */
include("vues/v_sommaire.php");
// vérification du droit d'accès au cas d'utilisation
if ( ! estConnecte() ) {
    ajouterErreur("L'accès à cette page requiert une authentification !", $tabErreurs);
    include('vues/v_erreurs.php');
}
else  {
    $action = lireDonneeUrl('action', 'voirTousForm');
    switch($action){
        case 'voirTousForm':
                    $lesFormations=$pdoChaudoudoux->obtenirListeForm();
                    $lesFormationsM=$pdoChaudoudoux->obtenirListeFormM();
                    include("vues/v_listeForm.php");
                    break;
        case 'voirListFormIndividu':
                    $num= lireDonneeUrl('num');
                    $lesFormations=$pdoChaudoudoux->obtenirListeForm();
                    $lesFormationsM=$pdoChaudoudoux->obtenirListeFormM();
                    $ListeIndividuFormee=$pdoChaudoudoux->obtenirListeFormIndividuV3($num);
                    $nomFormationListe = $pdoChaudoudoux->obtenirNomFormation($num);
                    include("vues/v_listeForm.php");
                    break;
        case 'ajoutForm':
                    $nomForm= lireDonneePost('nomForm');
                    $duree= lireDonneePost('dureeForm');
                    $desc= lireDonneePost('descForm');
                    $orga= lireDonneePost('orgaForm');
                    $rem= lireDonneePost('remForm',0);
                    $type= lireDonneePost('typeForm');
                    $pdoChaudoudoux->ajoutForm($nomForm,$duree,$desc,$orga,$rem,$type);
                    $lesFormations=$pdoChaudoudoux->obtenirListeForm();
                    ajouterErreur("Formation ajoutée !", $tabErreurs);
                    include('vues/v_erreurs.php');
                    break;
        case 'modifForm':
                    $num= lireDonneeUrl('num');
                    $formation=$pdoChaudoudoux->uneForm($num);
                    $nom= $formation['intitule_Formations'];
                    $duree= $formation['duree_Formations'];
                    $desc= $formation['description_Formations'];
                    $orga= $formation['organisme_Formations'];
                    $rem= $formation['remuneration_formation'];
                    $type= $formation['type_Formations'];
                    include('vues/v_modifForm.php');
                    break;
                    
        case 'validerModifForm':
                    $num= lireDonneePost('num');
                    $nom= lireDonneePost('nomForm');
                    $duree= lireDonneePost('dureeForm');
                    $desc= lireDonneePost('descForm');
                    $orga= lireDonneePost('orgaForm');
                    $rem= lireDonneePost('remForm',0);
                    $type= lireDonneePost('typeForm');
                    $pdoChaudoudoux->modifForm($nom,$duree,$desc,$orga,$rem,$type,$num);
                    ajouterErreur("Formation modifiée !", $tabErreurs);
                    include('vues/v_erreurs.php');
                    break;
        case 'supForm':
                    $num= lireDonneePost('num');
                    $pdoChaudoudoux->supForm($num);
                    $lesFormations=$pdoChaudoudoux->obtenirListeForm();
                    break;
    
        /*default: 
            $lesFormations=$pdoChaudoudoux->obtenirListeForm();
            include("vues/v_listeForm.php");
                    break;*/
                    
                     
    }
}