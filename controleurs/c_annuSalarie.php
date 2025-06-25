<?php
/* La directive @var permet de déclarer une variable créée dans un script séparé
 * du présent script, et ainsi de bénéficier de l'auto-complétion sur cette variable
 */
/* @var $pdoChaudoudoux pdoChaudoudoux */
/* @var $tabErreurs array */
include("vues/v_sommaire.php");
// vérification du droit d'accès au cas d'utilisation
if ( ! estConnecte() ) {
    ajouterErreur("L'accès à cette page requiert une authentification !", $tabErreurs);
    include('vues/v_erreurs.php');
}
else  {
    $action = lireDonneeUrl('action', 'voirTousSalarie');
    switch($action){
                case 'voirTousSalarie':
                    $lesChamps=$pdoChaudoudoux->obtenirListeChampI();
                    $quoi = " ";
                    foreach ($lesChamps as $unChamp) {
                        if (strpos($unChamp['COLUMN_NAME'], 'Candidats')){
                            $quoi .= "C.".$unChamp['COLUMN_NAME'];
                        } else if (strpos($unChamp['COLUMN_NAME'], 'Intervenants')){
                            $quoi .= "I.".$unChamp['COLUMN_NAME'];
                        } else {
                            $quoi .= $unChamp['COLUMN_NAME'];
                        }
                        $quoi .= " , ";

                    }
                    $quoi = substr($quoi, 0, -2);
                    $lesSalaries=$pdoChaudoudoux->obtenirListeSalarie($quoi);
                    for ($i = 0; $i != count($lesSalaries); $i++) {
                        $chezMAND = "";
                        $famillesMAND = $pdoChaudoudoux->obtenirFamilleActuelleMAND($lesSalaries[$i][37]);
                        for ($o = 0; $o != count($famillesMAND); $o++) {
                            $chezMAND = $chezMAND . $pdoChaudoudoux->obtenirNomFamille($famillesMAND[$o]['numero_Famille']) . " / ";
                        }
                        $chezPREST = "";
                        $famillesPREST = $pdoChaudoudoux->obtenirFamilleActuellePREST($lesSalaries[$i][37]);
                        for ($o = 0; $o != count($famillesPREST); $o++) {
                            $chezPREST = $chezPREST . $pdoChaudoudoux->obtenirNomFamille($famillesPREST[$o]['numero_Famille']) . " / ";
                        }
                        $place = $pdoChaudoudoux->PlaceOuNon($lesSalaries[$i][37]);
                        array_push($lesSalaries[$i], $chezMAND);
                        array_push($lesSalaries[$i], $chezPREST);
                        array_push($lesSalaries[$i], $place);

                    }
                    array_push($lesChamps, ['COLUMN_NAME' => 'chezMAND', 'COLUMN_TYPE' => 'table']);
                    array_push($lesChamps, ['COLUMN_NAME' => 'chezPREST', 'COLUMN_TYPE' => 'table']);
                    array_push($lesChamps, ['COLUMN_NAME' => 'place', 'COLUMN_TYPE' => 'tinyint(1)']);
                    $archive=0;
                    include("vues/v_listeSalaries.php");
                    break;
                case 'demanderSupprimerSalarie':
                    $num = lireDonneeUrl('num');
                    $salarie=$pdoChaudoudoux->obtenirDetailsSalarie($num);
                    foreach ($salarie as $sal) {
                        $nom = $sal['nom_Candidats'];
                        $idSalarie = $sal['idSalarie_Intervenants'];
                    }
                    include("vues/v_suppressionSalarie.php");
                break;
                case 'suppressionConfirmee':
                    $num = lireDonneeUrl('num');

                    $salarie=$pdoChaudoudoux->obtenirDetailsSalarie($num);

                    foreach ($salarie as $sal)
                    {
                        $nom = $sal['nom_Candidats'];
                        $idSalarie = $sal['idSalarie_Intervenants'];
                        $salarieAsupprimer=$pdoChaudoudoux->suppSalarie($num);
                    }

                    include("vues/v_suppressionConfirmee.php");
                break;
                case 'demanderSupprimerFormation':
                    $num = lireDonneeUrl('num');
                    $numForm = lireDonneeUrl('numForm');

                    $salarie=$pdoChaudoudoux->obtenirDetailsSalarie($num);

                    foreach ($salarie as $sal) {
                        $nom = $sal['nom_Candidats'];
                    }

                    $nomForm = $pdoChaudoudoux->obtenirNomFormation($numForm);
                    include("vues/v_suppressionFormationSalarie.php");
                break;

                case 'supprimerDemandeFamille':
                    $numBesoin=lireDonneeUrl('numBesoin');
                    $pdoChaudoudoux->suppLigneDemande($numBesoin);
                    ajouterErreur("Besoin supprimé !", $tabErreurs);
                    include('vues/v_erreurs.php');

                    break;
                    case 'supprimerDispoInterv':
                        $numBesoin=lireDonneeUrl('numDispo');
                        $pdoChaudoudoux->suppDispoInterv($numBesoin);
                        ajouterErreur("Disponibilité supprimée !", $tabErreurs);
                        include('vues/v_erreurs.php');

                        break;
                    case 'supprimerDispoInterv':
                        $numInterv=lireDonneeUrl('numDispo');
                        $pdoChaudoudoux->suppDispoInterv($numInterv);
                        ajouterErreur("Disponibilité supprimée !", $tabErreurs);
                        include('vues/v_erreurs.php');

                        break;
                    
                    //Suppression de TOUTES les disponibilités en GE d'un intervenant
                    case'supprimerAllDispoIntervGE':
                        $numInterv=lireDonneeUrl('num');
                        $activite = 'garde d\'enfants';
                        $infoSS = $pdoChaudoudoux->obtenirDetailsSalarie($numInterv);
                        include('vues/v_demandeValidation.php');
                        break;
                    //Suppression de TOUTES les disponibilités en menage d'un intervenant
                    case'supprimerAllDispoIntervMenage':
                        $numInterv=lireDonneeUrl('num');
                        $activite = 'menage';
                        $infoSS = $pdoChaudoudoux->obtenirDetailsSalarie($numInterv);
                        include('vues/v_demandeValidation.php');
                        break;


                    
                    //Validation suppression disponibilités GE
                    case'validsupprimerAllDispoIntervGE':
                        $numInterv=lireDonneeUrl('num');
                        
                        $pdoChaudoudoux->suppAllDispoIntervGE($numInterv);
                        ajouterErreur("TOUTES les disponibilité garde d'enfants ont été supprimées !", $tabErreurs);
                        include('vues/v_erreurs.php');
                        break;
                    //Validation suppression disponibilités menage
                    case'validsupprimerAllDispoIntervMenage':
                        $numInterv=lireDonneeUrl('num');
                        
                        $pdoChaudoudoux->suppAllDispoIntervMenage($numInterv);
                        ajouterErreur("TOUTES les disponibilité ménages ont été supprimées !", $tabErreurs);
                        include('vues/v_erreurs.php');
                        break;
                        
                case 'voirFamillesBesoins':
                    $numInterv=lireDonneeUrl('num');
                    $lesBesoinsDesFamilles=$matching->obtenirBesoinsFamillesI($numInterv);
                    include("vues/v_famillesBesoins.php");
                    break;

                    case 'voirTousDispoIntervM':

                        $lesDispoIntervsM=$pdoChaudoudoux->obtenirtousDispoIntervM();
                        include("vues/v_tousIntervenantsDispoM.php");

                    break;
                    case 'voirTousDispoIntervGE':

                        $lesDispoIntervsGE=$pdoChaudoudoux->obtenirtousDispoIntervGE();
                        include("vues/v_tousIntervenantsDispoGE.php");

                    break;

                case 'suppressionConfirmeeFormation':
                    $numSal = lireDonneeUrl('num');
                    $numForm = lireDonneeUrl('numForm');

                    $pdoChaudoudoux->suppFormationSuivie($numForm, $numSal);

                    include("vues/v_suppressionConfirmee.php");
                    break;
                case 'tousIntervenants':
                    $lesChamps=$pdoChaudoudoux->obtenirListeChampI();
                    $quoi = " ";
                    foreach ($lesChamps as $unChamp) {
                        if (strpos($unChamp['COLUMN_NAME'], 'Candidats')){
                            $quoi .= "C.".$unChamp['COLUMN_NAME'];
                        } else if (strpos($unChamp['COLUMN_NAME'], 'Intervenants')){
                            $quoi .= "I.".$unChamp['COLUMN_NAME'];
                        } else {
                            $quoi .= $unChamp['COLUMN_NAME'];
                        }
                        $quoi .= " , ";

                    }
                    $quoi = substr($quoi, 0, -2);

                    $lesSalaries=$pdoChaudoudoux->obtenirListeSalarieSelect($quoi);
                    for ($i = 0; $i != count($lesSalaries); $i++) {
                        $chezMAND = "";
                        $famillesMAND = $pdoChaudoudoux->obtenirFamilleActuelleMAND($lesSalaries[$i][37]);
                        for ($o = 0; $o != count($famillesMAND); $o++) {
                            $chezMAND = $chezMAND . $pdoChaudoudoux->obtenirNomFamille($famillesMAND[$o]['numero_Famille']) . " / ";
                        }
                        $chezPREST = "";
                        $famillesPREST = $pdoChaudoudoux->obtenirFamilleActuellePREST($lesSalaries[$i][37]);
                        for ($o = 0; $o != count($famillesPREST); $o++) {
                            $chezPREST = $chezPREST . $pdoChaudoudoux->obtenirNomFamille($famillesPREST[$o]['numero_Famille']) . " / ";
                        }
                        $place = $pdoChaudoudoux->PlaceOuNon($lesSalaries[$i][37]);
                        array_push($lesSalaries[$i], $chezMAND);
                        array_push($lesSalaries[$i], $chezPREST);
                        array_push($lesSalaries[$i], $place);

                    }
                    array_push($lesChamps, ['COLUMN_NAME' => 'chezMAND', 'COLUMN_TYPE' => 'table']);
                    array_push($lesChamps, ['COLUMN_NAME' => 'chezPREST', 'COLUMN_TYPE' => 'table']);
                    array_push($lesChamps, ['COLUMN_NAME' => 'place', 'COLUMN_TYPE' => 'tinyint(1)']);
                    $archive=0;
                    include("vues/v_listeSalaries.php");
                    break;

                    
                case 'complH':
                    $lesChamps=$pdoChaudoudoux->obtenirListeChampI();
                    $quoi = " ";
                    foreach ($lesChamps as $unChamp) {
                        if (strpos($unChamp['COLUMN_NAME'], 'Candidats')){
                            $quoi .= "C.".$unChamp['COLUMN_NAME'];
                        } else if (strpos($unChamp['COLUMN_NAME'], 'Intervenants')){
                            $quoi .= "I.".$unChamp['COLUMN_NAME'];
                        } else {
                            $quoi .= $unChamp['COLUMN_NAME'];
                        }
                        $quoi .= " , ";

                    }
                    $quoi = substr($quoi, 0, -2);

                    $lesSalaries=$pdoChaudoudoux->obtenirListeSalariecomplH($quoi);
                    for ($i = 0; $i != count($lesSalaries); $i++) {
                        $chezMAND = "";
                        $famillesMAND = $pdoChaudoudoux->obtenirFamilleActuelleMAND($lesSalaries[$i][37]);
                        for ($o = 0; $o != count($famillesMAND); $o++) {
                            $chezMAND = $chezMAND . $pdoChaudoudoux->obtenirNomFamille($famillesMAND[$o]['numero_Famille']) . " / ";
                        }
                        $chezPREST = "";
                        $famillesPREST = $pdoChaudoudoux->obtenirFamilleActuellePREST($lesSalaries[$i][37]);
                        for ($o = 0; $o != count($famillesPREST); $o++) {
                            $chezPREST = $chezPREST . $pdoChaudoudoux->obtenirNomFamille($famillesPREST[$o]['numero_Famille']) . " / ";
                        }
                        $place = $pdoChaudoudoux->PlaceOuNon($lesSalaries[$i][37]);
                        array_push($lesSalaries[$i], $chezMAND);
                        array_push($lesSalaries[$i], $chezPREST);
                        array_push($lesSalaries[$i], $place);

                    }
                    array_push($lesChamps, ['COLUMN_NAME' => 'chezMAND', 'COLUMN_TYPE' => 'table']);
                    array_push($lesChamps, ['COLUMN_NAME' => 'chezPREST', 'COLUMN_TYPE' => 'table']);
                    array_push($lesChamps, ['COLUMN_NAME' => 'place', 'COLUMN_TYPE' => 'tinyint(1)']);
                    $archive=0;
                    include("vues/v_listeSalaries.php");
                    break;
                case 'voirTousSalarieArret':
                    $lesChamps=$pdoChaudoudoux->obtenirListeChampI();
                    $quoi = " ";
                    foreach ($lesChamps as $unChamp) {
                        if (strpos($unChamp['COLUMN_NAME'], 'Candidats')){
                            $quoi .= "C.".$unChamp['COLUMN_NAME'];
                        } else if (strpos($unChamp['COLUMN_NAME'], 'Intervenants')){
                            $quoi .= "I.".$unChamp['COLUMN_NAME'];
                        } else {
                            $quoi .= $unChamp['COLUMN_NAME'];
                        }
                        $quoi .= " , ";

                    }
                    $quoi = substr($quoi, 0, -2);
                    $lesSalaries=$pdoChaudoudoux->obtenirListeSalarieArret($quoi);
                    for ($i = 0; $i != count($lesSalaries); $i++) {
                        $chezMAND = "";
                        $famillesMAND = $pdoChaudoudoux->obtenirFamilleActuelleMAND($lesSalaries[$i][37]);
                        for ($o = 0; $o != count($famillesMAND); $o++) {
                            $chezMAND = $chezMAND . $pdoChaudoudoux->obtenirNomFamille($famillesMAND[$o]['numero_Famille']) . " / ";
                        }
                        $chezPREST = "";
                        $famillesPREST = $pdoChaudoudoux->obtenirFamilleActuellePREST($lesSalaries[$i][37]);
                        for ($o = 0; $o != count($famillesPREST); $o++) {
                            $chezPREST = $chezPREST . $pdoChaudoudoux->obtenirNomFamille($famillesPREST[$o]['numero_Famille']) . " / ";
                        }
                        $place = $pdoChaudoudoux->PlaceOuNon($lesSalaries[$i][37]);
                        array_push($lesSalaries[$i], $chezMAND);
                        array_push($lesSalaries[$i], $chezPREST);
                        array_push($lesSalaries[$i], $place);

                    }
                    array_push($lesChamps, ['COLUMN_NAME' => 'chezMAND', 'COLUMN_TYPE' => 'table']);
                    array_push($lesChamps, ['COLUMN_NAME' => 'chezPREST', 'COLUMN_TYPE' => 'table']);
                    array_push($lesChamps, ['COLUMN_NAME' => 'place', 'COLUMN_TYPE' => 'tinyint(1)']);
                    $archive=0;
                    include("vues/v_listeSalaries.php");
                    break;
                case 'voirTousSalarieArchive':
                    $lesChamps=$pdoChaudoudoux->obtenirListeChampI();
                    $quoi = " ";
                    foreach ($lesChamps as $unChamp) {
                        if (strpos($unChamp['COLUMN_NAME'], 'Candidats')){
                            $quoi .= "C.".$unChamp['COLUMN_NAME'];
                        } else if (strpos($unChamp['COLUMN_NAME'], 'Intervenants')){
                            $quoi .= "I.".$unChamp['COLUMN_NAME'];
                        } else {
                            $quoi .= $unChamp['COLUMN_NAME'];
                        }
                        $quoi .= " , ";

                    }
                    $quoi = substr($quoi, 0, -2);
                    $lesSalaries=$pdoChaudoudoux->obtenirListeSalarieArchive($quoi);
                    for ($i = 0; $i != count($lesSalaries); $i++) {
                        $chezMAND = "";
                        $famillesMAND = $pdoChaudoudoux->obtenirFamilleActuelleMAND($lesSalaries[$i][37]);
                        for ($o = 0; $o != count($famillesMAND); $o++) {
                            $chezMAND = $chezMAND . $pdoChaudoudoux->obtenirNomFamille($famillesMAND[$o]['numero_Famille']) . " / ";
                        }
                        $chezPREST = "";
                        $famillesPREST = $pdoChaudoudoux->obtenirFamilleActuellePREST($lesSalaries[$i][37]);
                        for ($o = 0; $o != count($famillesPREST); $o++) {
                            $chezPREST = $chezPREST . $pdoChaudoudoux->obtenirNomFamille($famillesPREST[$o]['numero_Famille']) . " / ";
                        }
                        $place = $pdoChaudoudoux->PlaceOuNon($lesSalaries[$i][37]);
                        array_push($lesSalaries[$i], $chezMAND);
                        array_push($lesSalaries[$i], $chezPREST);
                        array_push($lesSalaries[$i], $place);

                    }
                    array_push($lesChamps, ['COLUMN_NAME' => 'chezMAND', 'COLUMN_TYPE' => 'table']);
                    array_push($lesChamps, ['COLUMN_NAME' => 'chezPREST', 'COLUMN_TYPE' => 'table']);
                    array_push($lesChamps, ['COLUMN_NAME' => 'place', 'COLUMN_TYPE' => 'tinyint(1)']);
                    $archive=1;
                    include("vues/v_listeSalaries.php");
                    break;
                case 'voirTousSalarieArchiveNonPlace':
                    $lesChamps=$pdoChaudoudoux->obtenirListeChampI();
                    $quoi = " ";
                    foreach ($lesChamps as $unChamp) {
                        if (strpos($unChamp['COLUMN_NAME'], 'Candidats')){
                            $quoi .= "C.".$unChamp['COLUMN_NAME'];
                        } else if (strpos($unChamp['COLUMN_NAME'], 'Intervenants')){
                            $quoi .= "I.".$unChamp['COLUMN_NAME'];
                        } else {
                            $quoi .= $unChamp['COLUMN_NAME'];
                        }
                        $quoi .= " , ";

                    }
                    $quoi = substr($quoi, 0, -2);
                    $lesSalaries=$pdoChaudoudoux->obtenirListeSalarieArchiveNonPlace($quoi);
                    for ($i = 0; $i != count($lesSalaries); $i++) {
                        $chezMAND = "";
                        $famillesMAND = $pdoChaudoudoux->obtenirFamilleActuelleMAND($lesSalaries[$i][37]);
                        for ($o = 0; $o != count($famillesMAND); $o++) {
                            $chezMAND = $chezMAND . $pdoChaudoudoux->obtenirNomFamille($famillesMAND[$o]['numero_Famille']) . " / ";
                        }
                        $chezPREST = "";
                        $famillesPREST = $pdoChaudoudoux->obtenirFamilleActuellePREST($lesSalaries[$i][37]);
                        for ($o = 0; $o != count($famillesPREST); $o++) {
                            $chezPREST = $chezPREST . $pdoChaudoudoux->obtenirNomFamille($famillesPREST[$o]['numero_Famille']) . " / ";
                        }
                        $place = $pdoChaudoudoux->PlaceOuNon($lesSalaries[$i][37]);
                        array_push($lesSalaries[$i], $chezMAND);
                        array_push($lesSalaries[$i], $chezPREST);
                        array_push($lesSalaries[$i], $place);

                    }
                    array_push($lesChamps, ['COLUMN_NAME' => 'chezMAND', 'COLUMN_TYPE' => 'table']);
                    array_push($lesChamps, ['COLUMN_NAME' => 'chezPREST', 'COLUMN_TYPE' => 'table']);
                    array_push($lesChamps, ['COLUMN_NAME' => 'place', 'COLUMN_TYPE' => 'tinyint(1)']);
                    $archive=1;
                    include("vues/v_listeSalaries.php");
                    break;
                case 'voirSalPlace':
                    $lesChamps=$pdoChaudoudoux->obtenirListeChampI();
                    $quoi = " ";
                    foreach ($lesChamps as $unChamp) {
                        if (strpos($unChamp['COLUMN_NAME'], 'Candidats')){
                            $quoi .= "C.".$unChamp['COLUMN_NAME'];
                        } else if (strpos($unChamp['COLUMN_NAME'], 'Intervenants')){
                            $quoi .= "I.".$unChamp['COLUMN_NAME'];
                        } else {
                            $quoi .= $unChamp['COLUMN_NAME'];
                        }
                        $quoi .= " , ";

                    }
                    $quoi = substr($quoi, 0, -2);
                    $lesSalaries=$pdoChaudoudoux->obtenirListeSalariePlace($quoi);
                    for ($i = 0; $i != count($lesSalaries); $i++) {
                        $chezMAND = "";
                        $famillesMAND = $pdoChaudoudoux->obtenirFamilleActuelleMAND($lesSalaries[$i][37]);
                        for ($o = 0; $o != count($famillesMAND); $o++) {
                            $chezMAND = $chezMAND . $pdoChaudoudoux->obtenirNomFamille($famillesMAND[$o]['numero_Famille']) . " / ";
                        }
                        $chezPREST = "";
                        $famillesPREST = $pdoChaudoudoux->obtenirFamilleActuellePREST($lesSalaries[$i][37]);
                        for ($o = 0; $o != count($famillesPREST); $o++) {
                            $chezPREST = $chezPREST . $pdoChaudoudoux->obtenirNomFamille($famillesPREST[$o]['numero_Famille']) . " / ";
                        }
                        $place = $pdoChaudoudoux->PlaceOuNon($lesSalaries[$i][37]);
                        array_push($lesSalaries[$i], $chezMAND);
                        array_push($lesSalaries[$i], $chezPREST);
                        array_push($lesSalaries[$i], $place);

                    }
                    array_push($lesChamps, ['COLUMN_NAME' => 'chezMAND', 'COLUMN_TYPE' => 'table']);
                    array_push($lesChamps, ['COLUMN_NAME' => 'chezPREST', 'COLUMN_TYPE' => 'table']);
                    array_push($lesChamps, ['COLUMN_NAME' => 'place', 'COLUMN_TYPE' => 'tinyint(1)']);
                    $archive=0;
                    include("vues/v_listeSalaries.php");
                    break;
                case 'voirSalRennes':
                    $lesChamps=$pdoChaudoudoux->obtenirListeChampI();
                    $quoi = " ";
                    foreach ($lesChamps as $unChamp) {
                        if (strpos($unChamp['COLUMN_NAME'], 'Candidats')){
                            $quoi .= "C.".$unChamp['COLUMN_NAME'];
                        } else if (strpos($unChamp['COLUMN_NAME'], 'Intervenants')){
                            $quoi .= "I.".$unChamp['COLUMN_NAME'];
                        } else {
                            $quoi .= $unChamp['COLUMN_NAME'];
                        }
                        $quoi .= " , ";

                    }
                    $quoi = substr($quoi, 0, -2);
                    $lesSalaries=$pdoChaudoudoux->obtenirListeSalarieRennes($quoi);
                    for ($i = 0; $i != count($lesSalaries); $i++) {
                        $chezMAND = "";
                        $famillesMAND = $pdoChaudoudoux->obtenirFamilleActuelleMAND($lesSalaries[$i][37]);
                        for ($o = 0; $o != count($famillesMAND); $o++) {
                            $chezMAND = $chezMAND . $pdoChaudoudoux->obtenirNomFamille($famillesMAND[$o]['numero_Famille']) . " / ";
                        }
                        $chezPREST = "";
                        $famillesPREST = $pdoChaudoudoux->obtenirFamilleActuellePREST($lesSalaries[$i][37]);
                        for ($o = 0; $o != count($famillesPREST); $o++) {
                            $chezPREST = $chezPREST . $pdoChaudoudoux->obtenirNomFamille($famillesPREST[$o]['numero_Famille']) . " / ";
                        }
                        $place = $pdoChaudoudoux->PlaceOuNon($lesSalaries[$i][37]);
                        array_push($lesSalaries[$i], $chezMAND);
                        array_push($lesSalaries[$i], $chezPREST);
                        array_push($lesSalaries[$i], $place);

                    }
                    array_push($lesChamps, ['COLUMN_NAME' => 'chezMAND', 'COLUMN_TYPE' => 'table']);
                    array_push($lesChamps, ['COLUMN_NAME' => 'chezPREST', 'COLUMN_TYPE' => 'table']);
                    array_push($lesChamps, ['COLUMN_NAME' => 'place', 'COLUMN_TYPE' => 'tinyint(1)']);
                    $archive=0;
                    include("vues/v_listeSalaries.php");
                    break;
                case 'voirSalHorsRennes':
                    $lesChamps=$pdoChaudoudoux->obtenirListeChampI();
                    $quoi = " ";
                    foreach ($lesChamps as $unChamp) {
                        if (strpos($unChamp['COLUMN_NAME'], 'Candidats')){
                            $quoi .= "C.".$unChamp['COLUMN_NAME'];
                        } else if (strpos($unChamp['COLUMN_NAME'], 'Intervenants')){
                            $quoi .= "I.".$unChamp['COLUMN_NAME'];
                        } else {
                            $quoi .= $unChamp['COLUMN_NAME'];
                        }
                        $quoi .= " , ";

                    }
                    $quoi = substr($quoi, 0, -2);
                    $lesSalaries=$pdoChaudoudoux->obtenirListeSalarieHorsRennes($quoi);
                    for ($i = 0; $i != count($lesSalaries); $i++) {
                        $chezMAND = "";
                        $famillesMAND = $pdoChaudoudoux->obtenirFamilleActuelleMAND($lesSalaries[$i][37]);
                        for ($o = 0; $o != count($famillesMAND); $o++) {
                            $chezMAND = $chezMAND . $pdoChaudoudoux->obtenirNomFamille($famillesMAND[$o]['numero_Famille']) . " / ";
                        }
                        $chezPREST = "";
                        $famillesPREST = $pdoChaudoudoux->obtenirFamilleActuellePREST($lesSalaries[$i][37]);
                        for ($o = 0; $o != count($famillesPREST); $o++) {
                            $chezPREST = $chezPREST . $pdoChaudoudoux->obtenirNomFamille($famillesPREST[$o]['numero_Famille']) . " / ";
                        }
                        $place = $pdoChaudoudoux->PlaceOuNon($lesSalaries[$i][37]);
                        array_push($lesSalaries[$i], $chezMAND);
                        array_push($lesSalaries[$i], $chezPREST);
                        array_push($lesSalaries[$i], $place);

                    }
                    array_push($lesChamps, ['COLUMN_NAME' => 'chezMAND', 'COLUMN_TYPE' => 'table']);
                    array_push($lesChamps, ['COLUMN_NAME' => 'chezPREST', 'COLUMN_TYPE' => 'table']);
                    array_push($lesChamps, ['COLUMN_NAME' => 'place', 'COLUMN_TYPE' => 'tinyint(1)']);
                    $archive=0;
                    include("vues/v_listeSalaries.php");
                    break;
                case 'voirSalmoins3a':
                    $lesChamps=$pdoChaudoudoux->obtenirListeChampI();
                    $quoi = " ";
                    foreach ($lesChamps as $unChamp) {
                        if (strpos($unChamp['COLUMN_NAME'], 'Candidats')){
                            $quoi .= "C.".$unChamp['COLUMN_NAME'];
                        } else if (strpos($unChamp['COLUMN_NAME'], 'Intervenants')){
                            $quoi .= "I.".$unChamp['COLUMN_NAME'];
                        } else {
                            $quoi .= $unChamp['COLUMN_NAME'];
                        }
                        $quoi .= " , ";

                    }
                    $quoi = substr($quoi, 0, -2);
                    $lesSalaries=$pdoChaudoudoux->obtenirListeSalarieMoins3a($quoi);
                    for ($i = 0; $i != count($lesSalaries); $i++) {
                        $chezMAND = "";
                        $famillesMAND = $pdoChaudoudoux->obtenirFamilleActuelleMAND($lesSalaries[$i][37]);
                        for ($o = 0; $o != count($famillesMAND); $o++) {
                            $chezMAND = $chezMAND . $pdoChaudoudoux->obtenirNomFamille($famillesMAND[$o]['numero_Famille']) . " / ";
                        }
                        $chezPREST = "";
                        $famillesPREST = $pdoChaudoudoux->obtenirFamilleActuellePREST($lesSalaries[$i][37]);
                        for ($o = 0; $o != count($famillesPREST); $o++) {
                            $chezPREST = $chezPREST . $pdoChaudoudoux->obtenirNomFamille($famillesPREST[$o]['numero_Famille']) . " / ";
                        }
                        $place = $pdoChaudoudoux->PlaceOuNon($lesSalaries[$i][37]);
                        array_push($lesSalaries[$i], $chezMAND);
                        array_push($lesSalaries[$i], $chezPREST);
                        array_push($lesSalaries[$i], $place);

                    }
                    array_push($lesChamps, ['COLUMN_NAME' => 'chezMAND', 'COLUMN_TYPE' => 'table']);
                    array_push($lesChamps, ['COLUMN_NAME' => 'chezPREST', 'COLUMN_TYPE' => 'table']);
                    array_push($lesChamps, ['COLUMN_NAME' => 'place', 'COLUMN_TYPE' => 'tinyint(1)']);
                    $archive=0;
                    include("vues/v_listeSalaries.php");
                    break;


                case 'voirSalenfHand':
                    $lesChamps=$pdoChaudoudoux->obtenirListeChampI();
                    $quoi = " ";
                    foreach ($lesChamps as $unChamp) {
                        if (strpos($unChamp['COLUMN_NAME'], 'Candidats')){
                            $quoi .= "C.".$unChamp['COLUMN_NAME'];
                        } else if (strpos($unChamp['COLUMN_NAME'], 'Intervenants')){
                            $quoi .= "I.".$unChamp['COLUMN_NAME'];
                        } else {
                            $quoi .= $unChamp['COLUMN_NAME'];
                        }
                        $quoi .= " , ";

                    }
                    $quoi = substr($quoi, 0, -2);
                    $lesSalaries=$pdoChaudoudoux->obtenirListeSalarieEnfHand($quoi);
                    for ($i = 0; $i != count($lesSalaries); $i++) {
                        $chezMAND = "";
                        $famillesMAND = $pdoChaudoudoux->obtenirFamilleActuelleMAND($lesSalaries[$i][37]);
                        for ($o = 0; $o != count($famillesMAND); $o++) {
                            $chezMAND = $chezMAND . $pdoChaudoudoux->obtenirNomFamille($famillesMAND[$o]['numero_Famille']) . " / ";
                        }
                        $chezPREST = "";
                        $famillesPREST = $pdoChaudoudoux->obtenirFamilleActuellePREST($lesSalaries[$i][37]);
                        for ($o = 0; $o != count($famillesPREST); $o++) {
                            $chezPREST = $chezPREST . $pdoChaudoudoux->obtenirNomFamille($famillesPREST[$o]['numero_Famille']) . " / ";
                        }
                        $place = $pdoChaudoudoux->PlaceOuNon($lesSalaries[$i][37]);
                        array_push($lesSalaries[$i], $chezMAND);
                        array_push($lesSalaries[$i], $chezPREST);
                        array_push($lesSalaries[$i], $place);

                    }
                    array_push($lesChamps, ['COLUMN_NAME' => 'chezMAND', 'COLUMN_TYPE' => 'table']);
                    array_push($lesChamps, ['COLUMN_NAME' => 'chezPREST', 'COLUMN_TYPE' => 'table']);
                    array_push($lesChamps, ['COLUMN_NAME' => 'place', 'COLUMN_TYPE' => 'tinyint(1)']);
                    $archive=0;
                    include("vues/v_listeSalaries.php");
                    break;


                case 'voirSalGEP':
                    $lesChamps=$pdoChaudoudoux->obtenirListeChampI();
                    $quoi = " ";
                    foreach ($lesChamps as $unChamp) {
                        if (strpos($unChamp['COLUMN_NAME'], 'Candidats')){
                            $quoi .= "C.".$unChamp['COLUMN_NAME'];
                        } else if (strpos($unChamp['COLUMN_NAME'], 'Intervenants')){
                            $quoi .= "I.".$unChamp['COLUMN_NAME'];
                        } else {
                            $quoi .= $unChamp['COLUMN_NAME'];
                        }
                        $quoi .= " , ";

                    }
                    $quoi = substr($quoi, 0, -2);
                    $lesSalaries=$pdoChaudoudoux->obtenirListeSalarieGEP($quoi);
                    for ($i = 0; $i != count($lesSalaries); $i++) {
                        $chezMAND = "";
                        $famillesMAND = $pdoChaudoudoux->obtenirFamilleActuelleMAND($lesSalaries[$i][37]);
                        for ($o = 0; $o != count($famillesMAND); $o++) {
                            $chezMAND = $chezMAND . $pdoChaudoudoux->obtenirNomFamille($famillesMAND[$o]['numero_Famille']) . " / ";
                        }
                        $chezPREST = "";
                        $famillesPREST = $pdoChaudoudoux->obtenirFamilleActuellePREST($lesSalaries[$i][37]);
                        for ($o = 0; $o != count($famillesPREST); $o++) {
                            $chezPREST = $chezPREST . $pdoChaudoudoux->obtenirNomFamille($famillesPREST[$o]['numero_Famille']) . " / ";
                        }
                        $place = $pdoChaudoudoux->PlaceOuNon($lesSalaries[$i][37]);
                        array_push($lesSalaries[$i], $chezMAND);
                        array_push($lesSalaries[$i], $chezPREST);
                        array_push($lesSalaries[$i], $place);

                    }
                    array_push($lesChamps, ['COLUMN_NAME' => 'chezMAND', 'COLUMN_TYPE' => 'table']);
                    array_push($lesChamps, ['COLUMN_NAME' => 'chezPREST', 'COLUMN_TYPE' => 'table']);
                    array_push($lesChamps, ['COLUMN_NAME' => 'place', 'COLUMN_TYPE' => 'tinyint(1)']);
                    $archive=0;
                    include("vues/v_listeSalaries.php");
                    break;


                case 'voirSalGEM':
                    $lesChamps=$pdoChaudoudoux->obtenirListeChampI();
                    $quoi = " ";
                    foreach ($lesChamps as $unChamp) {
                        if (strpos($unChamp['COLUMN_NAME'], 'Candidats')){
                            $quoi .= "C.".$unChamp['COLUMN_NAME'];
                        } else if (strpos($unChamp['COLUMN_NAME'], 'Intervenants')){
                            $quoi .= "I.".$unChamp['COLUMN_NAME'];
                        } else {
                            $quoi .= $unChamp['COLUMN_NAME'];
                        }
                        $quoi .= " , ";

                    }
                    $quoi = substr($quoi, 0, -2);
                    $lesSalaries=$pdoChaudoudoux->obtenirListeSalarieGEM($quoi);
                    for ($i = 0; $i != count($lesSalaries); $i++) {
                        $chezMAND = "";
                        $famillesMAND = $pdoChaudoudoux->obtenirFamilleActuelleMAND($lesSalaries[$i][37]);
                        for ($o = 0; $o != count($famillesMAND); $o++) {
                            $chezMAND = $chezMAND . $pdoChaudoudoux->obtenirNomFamille($famillesMAND[$o]['numero_Famille']) . " / ";
                        }
                        $chezPREST = "";
                        $famillesPREST = $pdoChaudoudoux->obtenirFamilleActuellePREST($lesSalaries[$i][37]);
                        for ($o = 0; $o != count($famillesPREST); $o++) {
                            $chezPREST = $chezPREST . $pdoChaudoudoux->obtenirNomFamille($famillesPREST[$o]['numero_Famille']) . " / ";
                        }
                        $place = $pdoChaudoudoux->PlaceOuNon($lesSalaries[$i][37]);
                        array_push($lesSalaries[$i], $chezMAND);
                        array_push($lesSalaries[$i], $chezPREST);
                        array_push($lesSalaries[$i], $place);

                    }
                    array_push($lesChamps, ['COLUMN_NAME' => 'chezMAND', 'COLUMN_TYPE' => 'table']);
                    array_push($lesChamps, ['COLUMN_NAME' => 'chezPREST', 'COLUMN_TYPE' => 'table']);
                    array_push($lesChamps, ['COLUMN_NAME' => 'place', 'COLUMN_TYPE' => 'tinyint(1)']);
                    $archive=0;
                    include("vues/v_listeSalaries.php");
                    break;


                case 'voirSalMenage':
                    $lesChamps=$pdoChaudoudoux->obtenirListeChampI();
                    $quoi = " ";
                    foreach ($lesChamps as $unChamp) {
                        if (strpos($unChamp['COLUMN_NAME'], 'Candidats')){
                            $quoi .= "C.".$unChamp['COLUMN_NAME'];
                        } else if (strpos($unChamp['COLUMN_NAME'], 'Intervenants')){
                            $quoi .= "I.".$unChamp['COLUMN_NAME'];
                        } else {
                            $quoi .= $unChamp['COLUMN_NAME'];
                        }
                        $quoi .= " , ";

                    }
                    $quoi = substr($quoi, 0, -2);
                    $lesSalaries=$pdoChaudoudoux->obtenirListeSalarieMenage($quoi);
                    for ($i = 0; $i != count($lesSalaries); $i++) {
                        $chezMAND = "";
                        $famillesMAND = $pdoChaudoudoux->obtenirFamilleActuelleMAND($lesSalaries[$i][37]);
                        for ($o = 0; $o != count($famillesMAND); $o++) {
                            $chezMAND = $chezMAND . $pdoChaudoudoux->obtenirNomFamille($famillesMAND[$o]['numero_Famille']) . " / ";
                        }
                        $chezPREST = "";
                        $famillesPREST = $pdoChaudoudoux->obtenirFamilleActuellePREST($lesSalaries[$i][37]);
                        for ($o = 0; $o != count($famillesPREST); $o++) {
                            $chezPREST = $chezPREST . $pdoChaudoudoux->obtenirNomFamille($famillesPREST[$o]['numero_Famille']) . " / ";
                        }
                        $place = $pdoChaudoudoux->PlaceOuNon($lesSalaries[$i][37]);
                        array_push($lesSalaries[$i], $chezMAND);
                        array_push($lesSalaries[$i], $chezPREST);
                        array_push($lesSalaries[$i], $place);

                    }
                    array_push($lesChamps, ['COLUMN_NAME' => 'chezMAND', 'COLUMN_TYPE' => 'table']);
                    array_push($lesChamps, ['COLUMN_NAME' => 'chezPREST', 'COLUMN_TYPE' => 'table']);
                    array_push($lesChamps, ['COLUMN_NAME' => 'place', 'COLUMN_TYPE' => 'tinyint(1)']);
                    $archive=0;
                    include("vues/v_listeSalaries.php");
                    break;


                case 'voirSalGE':
                    $lesChamps=$pdoChaudoudoux->obtenirListeChampI();
                    $quoi = " ";
                    foreach ($lesChamps as $unChamp) {
                        if (strpos($unChamp['COLUMN_NAME'], 'Candidats')){
                            $quoi .= "C.".$unChamp['COLUMN_NAME'];
                        } else if (strpos($unChamp['COLUMN_NAME'], 'Intervenants')){
                            $quoi .= "I.".$unChamp['COLUMN_NAME'];
                        } else {
                            $quoi .= $unChamp['COLUMN_NAME'];
                        }
                        $quoi .= " , ";

                    }
                    $quoi = substr($quoi, 0, -2);
                    $lesSalaries=$pdoChaudoudoux->obtenirListeSalarieGE($quoi);
                    for ($i = 0; $i != count($lesSalaries); $i++) {
                        $chezMAND = "";
                        $famillesMAND = $pdoChaudoudoux->obtenirFamilleActuelleMAND($lesSalaries[$i][37]);
                        for ($o = 0; $o != count($famillesMAND); $o++) {
                            $chezMAND = $chezMAND . $pdoChaudoudoux->obtenirNomFamille($famillesMAND[$o]['numero_Famille']) . " / ";
                        }
                        $chezPREST = "";
                        $famillesPREST = $pdoChaudoudoux->obtenirFamilleActuellePREST($lesSalaries[$i][37]);
                        for ($o = 0; $o != count($famillesPREST); $o++) {
                            $chezPREST = $chezPREST . $pdoChaudoudoux->obtenirNomFamille($famillesPREST[$o]['numero_Famille']) . " / ";
                        }
                        $place = $pdoChaudoudoux->PlaceOuNon($lesSalaries[$i][37]);
                        array_push($lesSalaries[$i], $chezMAND);
                        array_push($lesSalaries[$i], $chezPREST);
                        array_push($lesSalaries[$i], $place);

                    }
                    array_push($lesChamps, ['COLUMN_NAME' => 'chezMAND', 'COLUMN_TYPE' => 'table']);
                    array_push($lesChamps, ['COLUMN_NAME' => 'chezPREST', 'COLUMN_TYPE' => 'table']);
                    array_push($lesChamps, ['COLUMN_NAME' => 'place', 'COLUMN_TYPE' => 'tinyint(1)']);
                    $archive=0;
                    include("vues/v_listeSalaries.php");
                    break;


                case 'voirSalMenageNP':
                    $lesChamps=$pdoChaudoudoux->obtenirListeChampI();
                    $quoi = " ";
                    foreach ($lesChamps as $unChamp) {
                        if (strpos($unChamp['COLUMN_NAME'], 'Candidats')){
                            $quoi .= "C.".$unChamp['COLUMN_NAME'];
                        } else if (strpos($unChamp['COLUMN_NAME'], 'Intervenants')){
                            $quoi .= "I.".$unChamp['COLUMN_NAME'];
                        } else {
                            $quoi .= $unChamp['COLUMN_NAME'];
                        }
                        $quoi .= " , ";

                    }
                    $quoi = substr($quoi, 0, -2);
                    $lesSalaries=$pdoChaudoudoux->obtenirListeSalarieMenageNP($quoi);
                    for ($i = 0; $i != count($lesSalaries); $i++) {
                        $chezMAND = "";
                        $famillesMAND = $pdoChaudoudoux->obtenirFamilleActuelleMAND($lesSalaries[$i][37]);
                        for ($o = 0; $o != count($famillesMAND); $o++) {
                            $chezMAND = $chezMAND . $pdoChaudoudoux->obtenirNomFamille($famillesMAND[$o]['numero_Famille']) . " / ";
                        }
                        $chezPREST = "";
                        $famillesPREST = $pdoChaudoudoux->obtenirFamilleActuellePREST($lesSalaries[$i][37]);
                        for ($o = 0; $o != count($famillesPREST); $o++) {
                            $chezPREST = $chezPREST . $pdoChaudoudoux->obtenirNomFamille($famillesPREST[$o]['numero_Famille']) . " / ";
                        }
                        $place = $pdoChaudoudoux->PlaceOuNon($lesSalaries[$i][37]);
                        array_push($lesSalaries[$i], $chezMAND);
                        array_push($lesSalaries[$i], $chezPREST);
                        array_push($lesSalaries[$i], $place);

                    }
                    array_push($lesChamps, ['COLUMN_NAME' => 'chezMAND', 'COLUMN_TYPE' => 'table']);
                    array_push($lesChamps, ['COLUMN_NAME' => 'chezPREST', 'COLUMN_TYPE' => 'table']);
                    array_push($lesChamps, ['COLUMN_NAME' => 'place', 'COLUMN_TYPE' => 'tinyint(1)']);
                    $archive=0;
                    include("vues/v_listeSalaries.php");
                    break;


                case 'voirSalGENP':
                    $lesChamps=$pdoChaudoudoux->obtenirListeChampI();
                    $quoi = " ";
                    foreach ($lesChamps as $unChamp) {
                        if (strpos($unChamp['COLUMN_NAME'], 'Candidats')){
                            $quoi .= "C.".$unChamp['COLUMN_NAME'];
                        } else if (strpos($unChamp['COLUMN_NAME'], 'Intervenants')){
                            $quoi .= "I.".$unChamp['COLUMN_NAME'];
                        } else {
                            $quoi .= $unChamp['COLUMN_NAME'];
                        }
                        $quoi .= " , ";

                    }
                    $quoi = substr($quoi, 0, -2);
                    $lesSalaries=$pdoChaudoudoux->obtenirListeSalarieGENP($quoi);
                    for ($i = 0; $i != count($lesSalaries); $i++) {
                        $chezMAND = "";
                        $famillesMAND = $pdoChaudoudoux->obtenirFamilleActuelleMAND($lesSalaries[$i][37]);
                        for ($o = 0; $o != count($famillesMAND); $o++) {
                            $chezMAND = $chezMAND . $pdoChaudoudoux->obtenirNomFamille($famillesMAND[$o]['numero_Famille']) . " / ";
                        }
                        $chezPREST = "";
                        $famillesPREST = $pdoChaudoudoux->obtenirFamilleActuellePREST($lesSalaries[$i][37]);
                        for ($o = 0; $o != count($famillesPREST); $o++) {
                            $chezPREST = $chezPREST . $pdoChaudoudoux->obtenirNomFamille($famillesPREST[$o]['numero_Famille']) . " / ";
                        }
                        $place = $pdoChaudoudoux->PlaceOuNon($lesSalaries[$i][37]);
                        array_push($lesSalaries[$i], $chezMAND);
                        array_push($lesSalaries[$i], $chezPREST);
                        array_push($lesSalaries[$i], $place);

                    }
                    array_push($lesChamps, ['COLUMN_NAME' => 'chezMAND', 'COLUMN_TYPE' => 'table']);
                    array_push($lesChamps, ['COLUMN_NAME' => 'chezPREST', 'COLUMN_TYPE' => 'table']);
                    array_push($lesChamps, ['COLUMN_NAME' => 'place', 'COLUMN_TYPE' => 'tinyint(1)']);
                    $archive=0;
                    include("vues/v_listeSalaries.php");
                    break;


                case 'voirSalVehicule':
                    $lesChamps=$pdoChaudoudoux->obtenirListeChampI();
                    $quoi = " ";
                    foreach ($lesChamps as $unChamp) {
                        if (strpos($unChamp['COLUMN_NAME'], 'Candidats')){
                            $quoi .= "C.".$unChamp['COLUMN_NAME'];
                        } else if (strpos($unChamp['COLUMN_NAME'], 'Intervenants')){
                            $quoi .= "I.".$unChamp['COLUMN_NAME'];
                        } else {
                            $quoi .= $unChamp['COLUMN_NAME'];
                        }
                        $quoi .= " , ";

                    }
                    $quoi = substr($quoi, 0, -2);
                    $lesSalaries=$pdoChaudoudoux->obtenirListeSalarieVehicule($quoi);
                    for ($i = 0; $i != count($lesSalaries); $i++) {
                        $chezMAND = "";
                        $famillesMAND = $pdoChaudoudoux->obtenirFamilleActuelleMAND($lesSalaries[$i][37]);
                        for ($o = 0; $o != count($famillesMAND); $o++) {
                            $chezMAND = $chezMAND . $pdoChaudoudoux->obtenirNomFamille($famillesMAND[$o]['numero_Famille']) . " / ";
                        }
                        $chezPREST = "";
                        $famillesPREST = $pdoChaudoudoux->obtenirFamilleActuellePREST($lesSalaries[$i][37]);
                        for ($o = 0; $o != count($famillesPREST); $o++) {
                            $chezPREST = $chezPREST . $pdoChaudoudoux->obtenirNomFamille($famillesPREST[$o]['numero_Famille']) . " / ";
                        }
                        $place = $pdoChaudoudoux->PlaceOuNon($lesSalaries[$i][37]);
                        array_push($lesSalaries[$i], $chezMAND);
                        array_push($lesSalaries[$i], $chezPREST);
                        array_push($lesSalaries[$i], $place);

                    }
                    array_push($lesChamps, ['COLUMN_NAME' => 'chezMAND', 'COLUMN_TYPE' => 'table']);
                    array_push($lesChamps, ['COLUMN_NAME' => 'chezPREST', 'COLUMN_TYPE' => 'table']);
                    array_push($lesChamps, ['COLUMN_NAME' => 'place', 'COLUMN_TYPE' => 'tinyint(1)']);
                    $archive=0;
                    include("vues/v_listeSalaries.php");
                    break;


        case 'validEntretien':
            $numSal = lireDonneePost('numSal');

            if (isset($datePremierEntretien)) {

                $datePremierEntretien = lireDonneePost('premierEntretien');

                $pdoChaudoudoux->validEntretien($numSal, $datePremierEntretien);
            }

            $twoYearEntretien = '';
            $sixYearEntretien = '';

            ajouterErreur("Mise à jour de la date du premier d'entretien validée", $tabErreurs);
            include('vues/v_erreurs.php');
            break;
        case 'validForm':
                    $numForm = lireDonneePost('numForm');
                    $numSal = lireDonneePost('numSal');
                    $fform = lireDonneePost('familleForm');
                    if (empty($fform) == FALSE) {
                        $familleForm = $fform; }
                    else {
                        $familleForm = 'M000';
                    }
                    $pdoChaudoudoux->validForm($numForm, $numSal, $familleForm);
                    ajouterErreur("La formation a été ajoutée", $tabErreurs);
                    include('vues/v_erreurs.php');
                    break;
        case 'ajoutEntretien':
                    $dateEntretien = lireDonneePost('dateEntretien');
                    $numSal = lireDonneePost('numSal');

                    $typeEntretien = lireDonneePost('typeEntretien');

                    $numEntretien = $pdoChaudoudoux->EntretienNUM($numSal);
                    $pdoChaudoudoux->ajoutEntretien($numEntretien, $numSal, $dateEntretien, $typeEntretien);
                    ajouterErreur("La date de l'entretien a été ajoutée", $tabErreurs);
                    include('vues/v_erreurs.php');
                    break;
        case 'ajoutSelection':
                    $filename = 'config/selections.txt';
                    $fp=fopen($filename, 'a');
                    $text = "['" . lireDonneeUrl("nom") . "'," . lireDonneeUrl("selection")."],";
                    fwrite($fp, $text);

                    fclose($fp);
                    ajouterErreur("La selection a été ajoutée", $tabErreurs);
                    include('vues/v_erreurs.php');
                    break;
        case 'supEntretien':
                    $numSal = lireDonneePost('numSal');
                    $pdoChaudoudoux->supEntretien($numSal);
                    ajouterErreur("Le dernier entretien a été suprimé", $tabErreurs);
                    include('vues/v_erreurs.php');
                    break;
        case 'delSelection':
                    $filename = 'config/selections.txt';
                    $fp=fopen($filename, 'w');
                    $text = '[["-nouvelle selection-", 1],';
                    fwrite($fp, $text);

                    fclose($fp);
                    ajouterErreur("Les selections on été suprimier", $tabErreurs);
                    include('vues/v_erreurs.php');
                    break;
        case 'ajoutCommentaire':
                    $table2 = explode('-', lireDonneePost('listEntretien'));
                    $num = $table2[0];
                    $com = lireDonneePost('com');
                    $numSal = lireDonneePost('numSal');

                    $pdoChaudoudoux->ajoutCommentaire($num, $com, $numSal);
                    ajouterErreur("Le commentaire de l'entretien est enregistrer", $tabErreurs);
                    include('vues/v_erreurs.php');
                    break;
        case 'voirDetailSalarie':
                    $issalarie=true;
                    $num = lireDonneeUrl('num');
                    if ( empty($num) || !estEntierPositif($num) ) {
                        ajouterErreur("Une erreur est survenue. Cette personne n'est pas enregistrée comme salarié", $tabErreurs);
                        include('vues/v_erreurs.php');
                    }
                    else {

                        $lesEntretiens=$pdoChaudoudoux->obtenirListeEntretiens($num);
                        $lesFormations=$pdoChaudoudoux->obtenirListeFormSelect($num);
                        $lesF=$pdoChaudoudoux->ListeFormSal($num);
                        $salarie=$pdoChaudoudoux->obtenirDetailsSalarie($num);
                        $prestMand = "";
                        $prestations = $pdoChaudoudoux->obtenirPrestaSalarie($num);
                        foreach ($salarie as $sal) {
                            $idSalarie = $sal['idSalarie_Intervenants'];
                            $titre= $sal['titre_Candidats'];
                            $dateEnt= $sal['dateEntretien_Candidats'];
                            $nom = $sal['nom_Candidats'];
                            $prenom = $sal['prenom_Candidats'];
                            $dateNaiss = new DateTime($sal['dateNaiss_Candidats']);
                            $lieuNaiss = $sal['lieuNaiss_Candidats'];
                            $nomJF= $sal['nomJF_Candidats'];
                            $arret=$sal['arretTravail_Intervenants'];
                            $dateFinArret=$sal['dateFinArret_Intervenants'];
                            $paysNaiss = $sal['paysNaiss_Candidats'];
                            $trav= $sal['travailVoulu_Candidats'];
                            $dateModif=$sal['dateModif_Intervenants'];
                            $natio = $sal['nationalite_Candidats'];
                            $adresse = $sal['adresse_Candidats'];
                            $cp = $sal['cp_Candidats'];
                            $ville = $sal['ville_Candidats'];
                            $quartier = $sal['Quartier_Candidats'];
                            $telPort = $sal['telPortable_Candidats'];
                            $telFixe = $sal['telFixe_Candidats'];
                            $telUrg = $sal['TelUrg_Candidats'];
                            $email = $sal['email_Candidats'];
                            $numSS = $sal['numSS_Candidats'];
                            $permis = $sal['permis_Candidats'];
                            $vehicule = $sal['vehicule_Candidats'];
                            $statutPro = $sal['statutPro_Candidats'];
                            $statutHandicap = $sal['statutHandicap_Candidats'];
                            $sitFam = $sal['situationFamiliale_Candidats'];
                            $diplomes = $sal['diplomes_Candidats'];
                            $qualifs = $sal['qualifications_Candidats'];
                            $certifs = $sal['Certification_Intervenants'];
                            $suivi=$sal['suivi_Intervenants'];
                            $expBBmoins1a = $sal['expBBmoins1a_Candidats'];
                            $enfantHand = $sal['enfantHand_Candidats'];
                            $dispo = $sal['disponibilites_Candidats'];
                            $dateEntree = new DateTime($sal['dateEntree_Intervenants']);
                            $archive = $sal['archive_Intervenants'];
                            $dateSortie = $sal['dateSortie_Intervenants'];
                            $tauxH = $sal['tauxH_Intervenants'];
                            $nbHeureSem = $sal['nbHeureSem_Intervenants'];
                            $nbHeureMois = $sal['nbHeureMois_Intervenants'];
                            $numTS=$sal['numTitreSejour'];
                            $dateTS= $sal['dateTitreSejour'];
                            $mutuelle= $sal['Mutuelle_Candidats'];
                            $cmu= $sal['CMU_Candidats'];
                            $rechCompl = $sal['rechCompl_Intervenants'];
                            $psc1 = $sal['ProposerPSC1_Intervenants'];
                            $justifs = $sal['justificatifs_Intervenants'];
                            $observ = $sal['observations_Candidats'];
                            $salarie=true;

                        }
                        include("vues/v_detailCandidat.php");
                    }
                    break;

        case 'introEntretien':
            include('vues/v_entretienIntro.php');
            break;

        case 'voirEntretien':
            if(lireDonneeUrl('statut') == 'pro'){
                $entretien = $pdoChaudoudoux->listeEntretiensGlobal(1);
            }
            else if(lireDonneeUrl('statut') == 'indiv'){
                $entretien = $pdoChaudoudoux->listeEntretiensGlobal(0);
            }
            else{
                $entretien = $pdoChaudoudoux->listeEntretiensTousFusion();
                /*$entretienPro = $pdoChaudoudoux->listeEntretiensGlobal(1);
                $entretienIndiv = $pdoChaudoudoux->listeEntretiensGlobal(0);*/
            }
            include('vues/v_entretiens.php');
            break;

        case 'mailIntervPrest':
            $adressesPrest = $pdoChaudoudoux->mailPrestInterv();
            $nbAdresse = count($pdoChaudoudoux->mailPrestInterv());
            $adressesVides = $pdoChaudoudoux->mailVidePrestInterv();
            include 'vues/v_adresses.php';
            break;
        case 'mailIntervPrestGE':
            $adressesPrest = $pdoChaudoudoux->mailPrestIntervGE();
            $nbAdresse = count($pdoChaudoudoux->mailPrestIntervGE());
            $adressesVides = $pdoChaudoudoux->mailVidePrestIntervGE();
            include 'vues/v_adresses.php';
            break;
        case 'mailIntervPrestMen':
            $adressesPrest = $pdoChaudoudoux->mailPrestIntervMen();
            $nbAdresse = count($pdoChaudoudoux->mailPrestIntervMen());
            $adressesVides = $pdoChaudoudoux->mailVidePrestIntervMen();
            include 'vues/v_adresses.php';
            break;
        case 'mailIntervMand':
            $adressesMand = $pdoChaudoudoux->mailMandInterv();
            $nbAdresse = count($pdoChaudoudoux->mailMandInterv());
            $adressesVides = $pdoChaudoudoux->mailVideMandInterv();
            include 'vues/v_adresses.php';
            break;

        case 'mailIntervSansDispo':
            $adressesIntervSansDispo = $pdoChaudoudoux->mailIntervSansDispo();
            $nbAdresse = count($pdoChaudoudoux->mailIntervSansDispo());
            $adressesVides = $pdoChaudoudoux->mailVideIntervSansDispo();
            include 'vues/v_adresses.php';
            break;



case 'mailIntervPrestAct':
    $adressesPrest = $pdoChaudoudoux->mailPrestIntervAct();
    $nbAdresse = count($pdoChaudoudoux->mailPrestIntervAct());
    $adressesVides = $pdoChaudoudoux->mailVidePrestIntervAct();
    include 'vues/v_adresses.php';
    break;

case 'mailIntervPrestGEAct':
    $adressesPrest = $pdoChaudoudoux->mailPrestIntervGEAct();
    $nbAdresse = count($pdoChaudoudoux->mailPrestIntervGEAct());
    $adressesVides = $pdoChaudoudoux->mailVidePrestIntervGEAct();
    include 'vues/v_adresses.php';
    break;

case 'mailIntervPrestMenAct':
    $adressesPrest = $pdoChaudoudoux->mailPrestIntervMenAct();
    $nbAdresse = count($pdoChaudoudoux->mailPrestIntervMenAct());
    $adressesVides = $pdoChaudoudoux->mailVidePrestIntervMenAct();
    include 'vues/v_adresses.php';
    break;

case 'mailIntervMandAct':
    $adressesMand = $pdoChaudoudoux->mailMandIntervAct();
    $nbAdresse = count($pdoChaudoudoux->mailMandIntervAct());
    $adressesVides = $pdoChaudoudoux->mailVideMandIntervAct();
    include 'vues/v_adresses.php';
    break;



        case 'mailIntervDisp':
            $adressesDisp = $pdoChaudoudoux->mailDispInterv();
            $nbAdresse = count($pdoChaudoudoux->mailDispInterv());
            $adressesVides = $pdoChaudoudoux->mailVideDispInterv();
            include 'vues/v_adresses.php';
            break;
        case 'mailIntervArchiv':
            $adressesArchi = $pdoChaudoudoux->mailArchiInterv();
            $nbAdresse = count($pdoChaudoudoux->mailArchiInterv());
            $adressesVides = $pdoChaudoudoux->mailVideArchiInterv();
            include 'vues/v_adresses.php';
            break;
        case 'vueModif':
            $lesChamps=$pdoChaudoudoux->obtenirListeChampI();
                    $quoi = " ";
                    foreach ($lesChamps as $unChamp) {
                        if (strpos($unChamp['COLUMN_NAME'], 'Candidats')){
                            $quoi .= "C.".$unChamp['COLUMN_NAME'];
                        } else if (strpos($unChamp['COLUMN_NAME'], 'Intervenants')){
                            $quoi .= "I.".$unChamp['COLUMN_NAME'];
                        } else {
                            $quoi .= $unChamp['COLUMN_NAME'];
                        }
                        $quoi .= " , ";

                    }
                    $quoi = substr($quoi, 0, -2);
            $lesSalaries=$pdoChaudoudoux->obtenirModifPrest($quoi);
            for ($i = 0; $i != count($lesSalaries); $i++) {
                $chezMAND = "";
                $famillesMAND = $pdoChaudoudoux->obtenirFamilleActuelleMAND($lesSalaries[$i][36]);
                for ($o = 0; $o != count($famillesMAND); $o++) {
                    $chezMAND = $chezMAND . $pdoChaudoudoux->obtenirNomFamille($famillesMAND[$o]['numero_Famille']) . " / ";
                }
                $chezPREST = "";
                $famillesPREST = $pdoChaudoudoux->obtenirFamilleActuellePREST($lesSalaries[$i][36]);
                for ($o = 0; $o != count($famillesPREST); $o++) {
                    $chezPREST = $chezPREST . $pdoChaudoudoux->obtenirNomFamille($famillesPREST[$o]['numero_Famille']) . " / ";
                }
                $place = $pdoChaudoudoux->PlaceOuNon($lesSalaries[$i][36]);
                array_push($lesSalaries[$i], $chezMAND);
                array_push($lesSalaries[$i], $chezPREST);
                array_push($lesSalaries[$i], $place);

            }
            array_push($lesChamps, ['COLUMN_NAME' => 'chezMAND', 'COLUMN_TYPE' => 'table']);
            array_push($lesChamps, ['COLUMN_NAME' => 'chezPREST', 'COLUMN_TYPE' => 'table']);
            array_push($lesChamps, ['COLUMN_NAME' => 'place', 'COLUMN_TYPE' => 'tinyint(1)']);
            $archive=0;
            include("vues/v_listeSalaries.php");
            break;
        /*case 'mailPrest':
            $adresses= $pdoChaudoudoux->mailPrestSal();
            include 'vues/v_adresses.php';
            break;*/
        case 'ficheMail':
            $issalarie=true;
                    $num = lireDonneeUrl('num');
                    if ( empty($num) || !estEntierPositif($num) ) {
                        ajouterErreur("Une erreur est survenue. Cette personne n'est pas enregistrée comme salarié", $tabErreurs);
                        include('vues/v_erreurs.php');
                    }
                    else {

                        $lesFormations=$pdoChaudoudoux->obtenirListeFormSelect($num);
                        $lesF=$pdoChaudoudoux->ListeFormSal($num);
                        $salarie=$pdoChaudoudoux->obtenirDetailsSalarie($num);
                        $prestMand = "";
                        $prestations = $pdoChaudoudoux->obtenirPrestaSalarie($num);
                        foreach ($salarie as $sal) {
                            $idSalarie = $sal['idSalarie_Intervenants'];
                            $titre= $sal['titre_Candidats'];
                            $dateEnt= $sal['dateEntretien_Candidats'];
                            $nom = $sal['nom_Candidats'];
                            $prenom = $sal['prenom_Candidats'];
                            $dateNaiss = $sal['dateNaiss_Candidats'];
                            $lieuNaiss = $sal['lieuNaiss_Candidats'];
                            $paysNaiss = $sal['paysNaiss_Candidats'];
                            $trav= $sal['travailVoulu_Candidats'];
                            $dateModif=$sal['dateModif_Intervenants'];
                            $natio = $sal['nationalite_Candidats'];
                            $adresse = $sal['adresse_Candidats'];
                            $cp = $sal['cp_Candidats'];
                            $ville = $sal['ville_Candidats'];
                            $quartier = $sal['Quartier_Candidats'];
                            $telPort = $sal['telPortable_Candidats'];
                            $telFixe = $sal['telFixe_Candidats'];
                            $telUrg = $sal['TelUrg_Candidats'];
                            $email = $sal['email_Candidats'];
                            $numSS = $sal['numSS_Candidats'];
                            $permis = $sal['permis_Candidats'];
                            $vehicule = $sal['vehicule_Candidats'];
                            $statutPro = $sal['statutPro_Candidats'];
                            $statutHandicap = $sal['statutHandicap_Candidats'];
                            $sitFam = $sal['situationFamiliale_Candidats'];
                            $diplomes = $sal['diplomes_Candidats'];
                            $qualifs = $sal['qualifications_Candidats'];
                            $certifs = $sal['Certification_Intervenants'];
                            $suivi=$sal['suivi_Intervenants'];
                            $expBBmoins1a = $sal['expBBmoins1a_Candidats'];
                            $enfantHand = $sal['enfantHand_Candidats'];
                            $dispo = $sal['disponibilites_Candidats'];
                            $dateEntree = $sal['dateEntree_Intervenants'];
                            $dateSortie = $sal['dateSortie_Intervenants'];
                            $tauxH = $sal['tauxH_Intervenants'];
                            $nbHeureSem = $sal['nbHeureSem_Intervenants'];
                            $nbHeureMois = $sal['nbHeureMois_Intervenants'];
                            $numTS=$sal['numTitreSejour'];
                            $dateTS=$sal['dateTitreSejour'];
                            $mutuelle= $sal['Mutuelle_Candidats'];
                            $cmu= $sal['CMU_Candidats'];
                            $rechCompl = $sal['rechCompl_Intervenants'];
                            $psc1 = $sal['ProposerPSC1_Intervenants'];
                            $justifs = $sal['justificatifs_Intervenants'];
                            $observ = $sal['observations_Candidats'];
                            $salarie=true;

                        }
                        include("vues/v_ficheMail.php");
                    }
                    break;
        case 'demanderModifSalarie': // on est au 1er appel, les données sont initialisées
                                     // à partir de celles renseignées dans la base
                    $num = lireDonneeUrl('num');
                    $salarie=$pdoChaudoudoux->obtenirDetailsSalarie($num);
                    $prestMand = "";
                    $presta = "";
                    foreach ($salarie as $sal) {
                        $idSalarie = $sal['idSalarie_Intervenants'];
                        $titre=$sal['titre_Candidats'];
                        $nom = $sal['nom_Candidats'];
                        $prenom = $sal['prenom_Candidats'];
                        $dateNaiss = new DateTime($sal['dateNaiss_Candidats']);
                        $lieuNaiss = $sal['lieuNaiss_Candidats'];
                        $paysNaiss = $sal['paysNaiss_Candidats'];
                        $natio = $sal['nationalite_Candidats'];
                        $adresse = $sal['adresse_Candidats'];
                        $nomJF= $sal['nomJF_Candidats'];
                        $cp = $sal['cp_Candidats'];
                        $dateFinArret=$sal['dateFinArret_Intervenants'];
                        $ville = $sal['ville_Candidats'];
                        $arret = $sal['arretTravail_Intervenants'];
                        $quartier = $sal['Quartier_Candidats'];
                        $telPort = $sal['telPortable_Candidats'];
                        $telFixe = $sal['telFixe_Candidats'];
                        $telUrg = $sal['TelUrg_Candidats'];
                        $email = $sal['email_Candidats'];
                        $numSS = $sal['numSS_Candidats'];
                        $permis = $sal['permis_Candidats'];
                        $vehicule = $sal['vehicule_Candidats'];
                        $statutPro = $sal['statutPro_Candidats'];
                        $statutHandicap = $sal['statutHandicap_Candidats'];
                        $sitFam = $sal['situationFamiliale_Candidats'];
                        $diplomes = $sal['diplomes_Candidats'];
                        $qualifs = $sal['qualifications_Candidats'];
                        $trav= $sal['travailVoulu_Candidats'];
                        $certifs = $sal['Certification_Intervenants'];
                        $suivi =$sal['suivi_Intervenants'];
                        $expBBmoins1a = $sal['expBBmoins1a_Candidats'];
                        $enfHand = $sal['enfantHand_Candidats'];
                        $dispo = $sal['disponibilites_Candidats'];
                        $dateEntree = $sal['dateEntree_Intervenants'];
                        $dateSortie = $sal['dateSortie_Intervenants'];
                        $tauxH = $sal['tauxH_Intervenants'];
                        $numTS= $sal['numTitreSejour'];
                        $dateTS= $sal['dateTitreSejour'];
                        $cmu= $sal['CMU_Candidats'];
                        $mutuelle= $sal['Mutuelle_Candidats'];
                        $nbHeureSem = $sal['nbHeureSem_Intervenants'];
                        $nbHeureMois = $sal['nbHeureMois_Intervenants'];
                        $rechCompl = $sal['rechCompl_Intervenants'];
                        $psc1 = $sal['ProposerPSC1_Intervenants'];
                        $justifs = $sal['justificatifs_Intervenants'];
                        $observ = $sal['observations_Candidats'];
                        $presta .= $sal['idPresta_Prestations'];
                        $archive=$sal['archive_Intervenants'];
                        $archiveTemporaire=$sal['archiveTemporaire'];
                        $dateFinArchiveTemporaire=$sal['dateFinArchiveTemporaire'];
                        $issalarie=true;
                        $secteurCandidat = $sal['secteur_Candidats'];
                        $repassage=$sal['repassage_Intervenants'];
                    }
                    include("vues/v_modifFicheCandid.php");
                    break;

                    case 'modifierDispoInterv' :
                        $numDispo = lireDonneeUrl('numDispo');
                        $laDispo = $pdoChaudoudoux->obtenirLigneDispo($numDispo);
                        include("vues/v_modifDispo.php");
                        break;

                    case 'validerDispoInterv' :
                        $numDispo=lireDonneeUrl('numDispo');
                        if($_POST['slctJour']!="jour"){
                            $jour=$_POST['slctJour'];
                            $frequence=$_POST['frequence']; 
                            $hDeb=$_POST['Hdeb'];
                            $minDeb=$_POST['minDeb'];
                            $minFin=$_POST['minFin'];
                            $hFin=$_POST['Hfin'];
                            $heureDeb=$hDeb.":".$minDeb.":00";
                            $heureFin=$hFin.":".$minFin.":00";
                            $pdoChaudoudoux->modifierLigneDispo($numDispo, $jour, $heureDeb, $heureFin, $frequence);
                        }
                        ajouterErreur("Disponibilité modifiée !", $tabErreurs);
                        include('vues/v_erreurs.php');
                        break;


        case 'ValiderModifSalarie':
            //L'activité est vide pâr défaut, elle sera définie après
            $activite="";
            //Variable qui définit si une disponibilité est à la fois en GE et en Ménage
            $doubleType = false;
            $num = lireDonneeUrl('num');
            //On vérifie si un type de disponibilité est saisie (GE, ménage ou les 2)

            $dispoInconnue = lireDonneePost('chkDispoInconnue', 0);
            $dispoM=$pdoChaudoudoux->ObtenirDispoMenage($num);
            $dispoGE=$pdoChaudoudoux->ObtenirDispoGE($num);
            $ajoutDispoDimanche = true;
            foreach ($dispoM as $key => $uneDispoM){
                $jourM=$uneDispoM['jour'];
                $hDebM=$uneDispoM['heureDebut'];
                $hFinM=$uneDispoM['heureFin'];
                $frequenceM=$uneDispoM['frequence'];
                $activite=$uneDispoM['activite'];
                $idM=$uneDispoM['id'];
                if($jourM=="dimanche" && $hFinM=="01:01:00" && $hDebM=="01:01:00"){
                    $ajoutDispoDimanche = false;
                    if($dispoInconnue == 0){
                        $pdoChaudoudoux->suppDispoInterv($idM);
                    }
                }
            }
            foreach ($dispoGE as $key => $uneDispoGE){
                $jourGE=$uneDispoGE['jour'];
                $hDebGE=$uneDispoGE['heureDebut'];
                $hFinGE=$uneDispoGE['heureFin'];
                $frequenceGE=$uneDispoGE['frequence'];
                $activitGE=$uneDispoGE['activite'];
                $idGE=$uneDispoGE['id'];
                if($jourGE=="dimanche" && $hFinGE=="01:01:00" && $hDebGE=="01:01:00"){
                    $ajoutDispoDimanche = false;
                    if($dispoInconnue == 0){
                        $pdoChaudoudoux->suppDispoInterv($idGE);
                    }
                }
            }

            if($ajoutDispoDimanche){
                if($dispoInconnue == 1){
                    $activite="garde d'enfants";
                    $jour="dimanche";
                    $frequence=1;
                    $heureDeb="01:01:00";
                    $heureFin="01:01:00";
                    $pdoChaudoudoux->ajoutDispo($num, $jour, $heureDeb,$heureFin, $activite,$frequence);
                    $activite="menage";
                    $pdoChaudoudoux->ajoutDispo($num, $jour, $heureDeb,$heureFin, $activite,$frequence);
                }
            }


            if($_POST['slctType']!="typeDefault"){
                //On vérifie qu'un jour est bien été saisie
                if($_POST['slctJourIM']!="jour"){
                    if($_POST['slctType']=="typeGE"){
                        $activite="garde d'enfants";
                    }
                    elseif($_POST['slctType']=="typeMenage"){
                        $activite="menage";
                    }
                    elseif($_POST['slctType']=="doubleType"){
                        //on définit activité à ménage (GE aurait marcher aussi) pour effectuer 2 requête séparées
                        $activite="menage";
                        //On passe la variable à 2 pour indiquer que la disponibilité est en GE et en ménage
                        $doubleType=true;
                    }
                    else{
                        //On reset les informations dans le cas de bug pour éviter qu'une requête passe
                        $activite="";
                        $doubleType=false;
                    }
                    $jour=$_POST['slctJourIM'];
                    $frequence=$_POST['frequenceIM'];
                    $hDeb=$_POST['HdebIM'];
                    $minDeb=$_POST['minDebIM'];
                    $minFin=$_POST['minFinIM'];
                    $hFin=$_POST['HfinIM'];
                    $heureDeb=$hDeb.":".$minDeb.":00";
                    $heureFin=$hFin.":".$minFin.":00";
                    //Requête 1 : prend en compte l'activité renseignée
                    //Si le double type est true, on fait 2 fois la reqiête avec chaque activité
                    $pdoChaudoudoux->ajoutDispo($num, $jour, $heureDeb,$heureFin, $activite,$frequence);
                    if($doubleType){
                        //Etant donné que la condition du double type est true, on avais renseigné que l'activité était ménage
                        //De ce fait, pour la 2eme requête, on met de la GE
                        $activite2 = "garde d'enfants";
                        $pdoChaudoudoux->ajoutDispo($num, $jour, $heureDeb,$heureFin, $activite2,$frequence);
                    }

                }

                    for ($id=1; $id < count($_POST); $id++) {
                        if($_POST['slctType'.$id.'']=="typeGE"){
                            $activite="garde d'enfants";
                        }
                        elseif($_POST['slctType'.$id.'']=="typeMenage"){
                            $activite="menage";
                        }
                        elseif($_POST['slctType'.$id.'']=="doubleType"){
                            $activite="menage";
                            $doubleType=true;
                        }
                        else{
                            $activite="";
                            $doubleType=false;
                        }

                        if(!isset($_POST['slctJourIM'.$id.''])){
                        continue;
                        //équivalent de pass en python
                        }elseif($_POST["slctJourIM".$id.""]!="jour"){
                            
                        $jour=$_POST["slctJourIM".$id.""];
                        $frequence=$_POST["frequenceIM".$id.""];
                        $hDeb=$_POST["HDebIM".$id.""];
                        $minDeb=$_POST["minDebIM".$id.""];
                        $minFin=$_POST["minFinIM".$id.""];
                        $hFin=$_POST["HfinIM".$id.""];
                        $heureDeb=$hDeb.":".$minDeb.":00";
                        $heureFin=$hFin.":".$minFin.":00";
                        $pdoChaudoudoux->ajoutDispo($num, $jour, $heureDeb,$heureFin, $activite,$frequence);
                        if($doubleType){
                            $activite2 = "garde d'enfants";
                            $pdoChaudoudoux->ajoutDispo($num, $jour, $heureDeb,$heureFin, $activite2,$frequence);
                        }

                }}
            }

                    $num = lireDonneeUrl('num');
                    $salarie=$pdoChaudoudoux->obtenirDetailsSalarie($num);
                    foreach ($salarie as $sal)
                    {
                        $ancienNom=$sal['nom_Candidats'];
                        $ancienPrenom=$sal['prenom_Candidats'];
                        $ancienNum=$sal['telPortable_Candidats'];
                    }
                    // on est au 2e appel, les données sont récupérées à partir de ce qui a été saisi dans le formulaire
                    $adresse = lireDonneePost('txtAdr');
                    $titre= lireDonneePost('slctTitre');
                    $prenom= lireDonneePost('txtPrenom');
                    $nom= lireDonneePost('txtNom');
                    $nomJF= lireDonneePost('nomJF');
                    $cp = lireDonneePost('txtCp');
                    $suivi= lireDonneePost('suivi');
                    $ville = lireDonneePost('txtVille');
                    $quartier = lireDonneePost('txtQuart');
                    $telPort = lireDonneePost('txtPort');
                    $telFixe = lireDonneePost('txtFixe');
                    $telUrg = lireDonneePost('txtUrg');
                    $email = lireDonneePost('txtEmail');
                    $permis = lireDonneePost('chkPermis', 0);
                    $vehicule = lireDonneePost('chkVehicule', 0);
                    $idSalarie = lireDonneePost('txtID');
                    $statutPro = lireDonneePost('slctStatPro');
                    $statutHandicap = lireDonneePost('chkStatutHandicap');
                    $sitFam = lireDonneePost('slctSitFam');
                    $diplomes = lireDonneePost('txtDip');
                    $chkarchive= lireDonneePost('chkArchive');
                    $repassage= lireDonneePost('repassage');
                     //var_dump($_POST['repassage']);
                    
                    if($chkarchive==1){
                        $pdoChaudoudoux->suppIntervDispo($num);
                    }
                    $qualifs = lireDonneePost('txtQualifs');
                    $certifs = lireDonneePost('txtCertifs');
                    $dateFinArret= lireDonneePost('finArret');
                    $expBBmoins1a = lireDonneePost('chkExp1a', 0);
                    $enfHand = lireDonneePost('chkEnfHand', 0);
                    $dispo = lireDonneePost('txtDispo');
                    $dateEntree = lireDonneePost('dateEntree');
                    $dateSortie = lireDonneePost('dateSortie',NULL);
                    $tauxH = lireDonneePost('txtTauxH');
                    $dateNaiss= lireDonneePost('dateNaiss');
                    $nbHeureSem = lireDonneePost('nbHsem');
                    $nbHeureMois = lireDonneePost('nbHmois');
                    $TS= lireDonneePost('txtTS');
                    $dateTS = lireDonneePost('dateTS');
                    $NumSS = lireDonneePost('txtNumSS');
                    $mutuelle= lireDonneePost('txtMutuelle');
                    $cmu= lireDonneePost('chkCMU');
                    $rechCompl = lireDonneePost('chkComplH', 0);
                    $trav= lireDonneePost('travailVoulu');
                    $psc1 = lireDonneePost('chkPSC1', 0);
                    $justifs = lireDonneePost('txtJustifs');
                    $observ = lireDonneePost('txtObs');
                    $arret=lireDonneePost('chkArret');
                    $LieuNaiss=lireDonneePost('txtLieuNaiss');
                    $PaysNaiss=lireDonneePost('txtPaysNaiss');
                    $Natio=lireDonneePost('txtNatio');
                    $issalarie=true;
                    $certif= lireDonneePost('txtCertifs');
                    $secteurCandidat = lireDonneePost('slctSecteur');

                    $archiveTemporaire = lireDonneePost('chkTemporaire');
                    if ($chkarchive != 0){
                        if ($archiveTemporaire == 1){
                            $dateFinArchiveTemporaire = lireDonneePost('dateFinArchive')."-01";
                            if ($dateFinArchiveTemporaire == "-01") {
                                $dateFinArchiveTemporaire = Null;
                            }
                            $dateDebutArchiveTemporaire = date('Y-m-d');
                        } else {
                            $archiveTemporaire = 0;
                            $dateFinArchiveTemporaire = Null;
                            $dateDebutArchiveTemporaire = Null;
                        }
                    } else {
                        $archiveTemporaire = 0;
                        $dateFinArchiveTemporaire = Null;
                        $dateDebutArchiveTemporaire = Null;
                    }



                    $pdoChaudoudoux->modifierDetailsSalarie($num, $chkarchive,$titre, $nom, $prenom, $idSalarie, $adresse, $cp, $ville,
                            $quartier, $telPort, $telFixe, $telUrg, $email, $statutPro, $diplomes,
                            $qualifs, $expBBmoins1a, $enfHand, $permis, $vehicule, $dispo, $observ,
                            $dateEntree, $dateSortie, $certifs, $tauxH, $rechCompl, $nbHeureSem, $nbHeureMois,
                            $psc1, $justifs, $sitFam, $certif,$suivi,$statutHandicap,$dateTS, $NumSS, $LieuNaiss ,$PaysNaiss, $Natio,$repassage, $secteurCandidat);
                    $numCand=$pdoChaudoudoux->getNumCand($num);
                    $pdoChaudoudoux->updateEchecInterv($num,$numCand, $dateFinArret, $dateNaiss, $TS, $mutuelle, $cmu, $psc1, $nbHeureMois, $nbHeureSem,
                            $rechCompl, $tauxH, $certifs, $chkarchive, $dateSortie, $idSalarie, $suivi,$trav,$nomJF,$dateEntree, $arret, $archiveTemporaire, $dateFinArchiveTemporaire , $dateDebutArchiveTemporaire,$repassage);
                    //header('Location:index.php?uc=annuSalarie&action=voirDetailSalarie&num='.$num);
                    // $lesSalaries=$pdoChaudoudoux->obtenirListeSalarie();
                    $archive=$chkarchive;
                /*    foreach ($_FILES as $unfichier)
                        {

                            $resultat = move_uploaded_file($unfichier['tmp_name'], 'Documents/Candidats_intervenants/'.$nom.' '.$prenom.' '.$telPort.'/Autres_Documents');}
                    if ($nom!=$ancienNom||$prenom!=$ancienPrenom||$telPort!=$ancienNum){
                    rename('Documents/Candidats_intervenants/'.$ancienNom.' '.$ancienPrenom.' '.$ancienNum, 'Documents/Candidats_intervenants/'.$nom.' '.$prenom.' '.$telPort);}*/
                    $issalarie=true;
                    $num = lireDonneeUrl('num');
                    if ( empty($num) || !estEntierPositif($num) ) {
                        ajouterErreur("Une erreur est survenue. Cette personne n'est pas enregistrée comme salarié", $tabErreurs);
                        include('vues/v_erreurs.php');
                              }
                    else {

                        $lesFormations=$pdoChaudoudoux->obtenirListeFormSelect($num);
                        $lesF=$pdoChaudoudoux->ListeFormSal($num);
                        $salarie=$pdoChaudoudoux->obtenirDetailsSalarie($num);
                        $prestMand = "";
                        $prestations = $pdoChaudoudoux->obtenirPrestaSalarie($num);
                        foreach ($salarie as $sal) {
                            $idSalarie = $sal['idSalarie_Intervenants'];
                            $titre= $sal['titre_Candidats'];
                            $dateEnt= $sal['dateEntretien_Candidats'];
                            $nom = $sal['nom_Candidats'];
                            $prenom = $sal['prenom_Candidats'];
                            $dateNaiss = new DateTime($sal['dateNaiss_Candidats']);
                            $lieuNaiss = $sal['lieuNaiss_Candidats'];
                            $nomJF= $sal['nomJF_Candidats'];
                            $paysNaiss = $sal['paysNaiss_Candidats'];
                            $trav= $sal['travailVoulu_Candidats'];
                            $dateModif=$sal['dateModif_Intervenants'];
                            $natio = $sal['nationalite_Candidats'];
                            $adresse = $sal['adresse_Candidats'];
                            $cp = $sal['cp_Candidats'];
                            $ville = $sal['ville_Candidats'];
                            $quartier = $sal['Quartier_Candidats'];
                            $telPort = $sal['telPortable_Candidats'];
                            $telFixe = $sal['telFixe_Candidats'];
                            $telUrg = $sal['TelUrg_Candidats'];
                            $email = $sal['email_Candidats'];
                            $numSS = $sal['numSS_Candidats'];
                            $permis = $sal['permis_Candidats'];
                            $vehicule = $sal['vehicule_Candidats'];
                            $statutPro = $sal['statutPro_Candidats'];
                            $statutHandicap = $sal['statutHandicap_Candidats'];
                            $sitFam = $sal['situationFamiliale_Candidats'];
                            $diplomes = $sal['diplomes_Candidats'];
                            $qualifs = $sal['qualifications_Candidats'];
                            $certifs = $sal['Certification_Intervenants'];
                            $suivi=$sal['suivi_Intervenants'];
                            $expBBmoins1a = $sal['expBBmoins1a_Candidats'];
                            $enfantHand = $sal['enfantHand_Candidats'];
                            $dispo = $sal['disponibilites_Candidats'];
                            $dateEntree = new DateTime($sal['dateEntree_Intervenants']);
                            $dateSortie = $sal['dateSortie_Intervenants'];
                            $tauxH = $sal['tauxH_Intervenants'];
                            $nbHeureSem = $sal['nbHeureSem_Intervenants'];
                            $nbHeureMois = $sal['nbHeureMois_Intervenants'];
                            $numTS=$sal['numTitreSejour'];
                            $dateTS= $sal['dateTitreSejour'];
                            $mutuelle= $sal['Mutuelle_Candidats'];
                            $cmu= $sal['CMU_Candidats'];
                            $rechCompl = $sal['rechCompl_Intervenants'];
                            $psc1 = $sal['ProposerPSC1_Intervenants'];
                            $justifs = $sal['justificatifs_Intervenants'];
                            $observ = $sal['observations_Candidats'];
                            $salarie=true;

                        }
                        include("vues/v_detailCandidat.php");
                    }
                    break;
                    case "IncoherenceInt":
                    $lesChamps=$pdoChaudoudoux->obtenirListeChampI();
                            $quoi = " ";
                            foreach ($lesChamps as $unChamp) {
                                if (strpos($unChamp['COLUMN_NAME'], 'Candidats')){
                                    $quoi .= "C.".$unChamp['COLUMN_NAME'];
                                } else if (strpos($unChamp['COLUMN_NAME'], 'Intervenants')){
                                    $quoi .= "I.".$unChamp['COLUMN_NAME'];
                                } else {
                                    $quoi .= $unChamp['COLUMN_NAME'];
                                }
                                $quoi .= " , ";

                            }
                            $quoi = substr($quoi, 0, -2);
                            $lesSalaries=$pdoChaudoudoux->obtenirListeSalarieIncoherence($quoi);
                            for ($i = 0; $i != count($lesSalaries); $i++) {
                                $chezMAND = "";
                                $famillesMAND = $pdoChaudoudoux->obtenirFamilleActuelleMAND($lesSalaries[$i][36]);
                                for ($o = 0; $o != count($famillesMAND); $o++) {
                                    $chezMAND = $chezMAND . $pdoChaudoudoux->obtenirNomFamille($famillesMAND[$o]['numero_Famille']) . " / ";
                                }
                                $chezPREST = "";
                                $famillesPREST = $pdoChaudoudoux->obtenirFamilleActuellePREST($lesSalaries[$i][36]);
                                for ($o = 0; $o != count($famillesPREST); $o++) {
                                    $chezPREST = $chezPREST . $pdoChaudoudoux->obtenirNomFamille($famillesPREST[$o]['numero_Famille']) . " / ";
                                }
                                $place = $pdoChaudoudoux->PlaceOuNon($lesSalaries[$i][36]);
                                array_push($lesSalaries[$i], $chezMAND);
                                array_push($lesSalaries[$i], $chezPREST);
                                array_push($lesSalaries[$i], $place);

                            }
                            array_push($lesChamps, ['COLUMN_NAME' => 'chezMAND', 'COLUMN_TYPE' => 'table']);
                            array_push($lesChamps, ['COLUMN_NAME' => 'chezPREST', 'COLUMN_TYPE' => 'table']);
                            array_push($lesChamps, ['COLUMN_NAME' => 'place', 'COLUMN_TYPE' => 'tinyint(1)']);
                            $archive=0;
                            include("vues/v_listeSalaries.php");
                            break;
                    case 'Formation':
                            $lesChamps=$pdoChaudoudoux->obtenirListeChampI();
                            $quoi = " ";
                            foreach ($lesChamps as $unChamp) {
                                if (strpos($unChamp['COLUMN_NAME'], 'Candidats')){
                                    $quoi .= "C.".$unChamp['COLUMN_NAME'];
                                } else if (strpos($unChamp['COLUMN_NAME'], 'Intervenants')){
                                    $quoi .= "I.".$unChamp['COLUMN_NAME'];
                                } else {
                                    $quoi .= $unChamp['COLUMN_NAME'];
                                }
                                $quoi .= " , ";

                            }
                            $quoi = substr($quoi, 0, -2);

                            $lesSalaries=$pdoChaudoudoux->obtenirListeSalarieSelect($quoi);
                            for ($i = 0; $i != count($lesSalaries); $i++) {
                                $chezMAND = "";
                                $famillesMAND = $pdoChaudoudoux->obtenirFamilleActuelleMAND($lesSalaries[$i][36]);
                                for ($o = 0; $o != count($famillesMAND); $o++) {
                                    $chezMAND = $chezMAND . $pdoChaudoudoux->obtenirNomFamille($famillesMAND[$o]['numero_Famille']) . " / ";
                                }
                                $chezPREST = "";
                                $famillesPREST = $pdoChaudoudoux->obtenirFamilleActuellePREST($lesSalaries[$i][36]);
                                for ($o = 0; $o != count($famillesPREST); $o++) {
                                    $chezPREST = $chezPREST . $pdoChaudoudoux->obtenirNomFamille($famillesPREST[$o]['numero_Famille']) . " / ";
                                }
                                $place = $pdoChaudoudoux->PlaceOuNon($lesSalaries[$i][36]);
                                array_push($lesSalaries[$i], $chezMAND);
                                array_push($lesSalaries[$i], $chezPREST);
                                array_push($lesSalaries[$i], $place);

                                $formation = "";
                                $lesFormations=$pdoChaudoudoux->ListeFormSal($lesSalaries[$i][36]);
                                for ($o = 0; $o != count($lesFormations); $o++){
                                    $nomForm = $lesFormations[$o]['intitule_Formations'];
                                    $typeForm = $lesFormations[$o]['type_Formations'];
                                    $nomFamille = $lesFormations[$o]['numFamille'];
                                    $affichageFamille = $pdoChaudoudoux->obtenirNomFamille($nomFamille);

                                      if  ($affichageFamille == 'MAISON DES CHAUDOUDO') {
                                        $affichageFamille = 'LA MAISON DES CHAUDOUDOUX';
                                    }
                                    $formation = $formation . $nomForm . ' (' . $typeForm . ') ' . '- ' . $affichageFamille . ' (' . $lesFormations[$o]['duree_Formations'] . ') / ';
                                }
                                array_push($lesSalaries[$i], $formation);

                            }
                            array_push($lesChamps, ['COLUMN_NAME' => 'chezMAND', 'COLUMN_TYPE' => 'table']);
                            array_push($lesChamps, ['COLUMN_NAME' => 'chezPREST', 'COLUMN_TYPE' => 'table']);
                            array_push($lesChamps, ['COLUMN_NAME' => 'place', 'COLUMN_TYPE' => 'tinyint(1)']);
                            array_push($lesChamps, ['COLUMN_NAME' => 'Formation', 'COLUMN_TYPE' => 'table']);
                            $archive=0;
                            include("vues/v_listeSalaries.php");
                            break;

                        case 'voirTousSalarieplaces':
                            $lesChamps=$pdoChaudoudoux->obtenirListeChampI();
                            $quoi = " ";
                            foreach ($lesChamps as $unChamp) {
                                if (strpos($unChamp['COLUMN_NAME'], 'Candidats')){
                                    $quoi .= "C.".$unChamp['COLUMN_NAME'];
                                } else if (strpos($unChamp['COLUMN_NAME'], 'Intervenants')){
                                    $quoi .= "I.".$unChamp['COLUMN_NAME'];
                                } else {
                                    $quoi .= $unChamp['COLUMN_NAME'];
                                }
                                $quoi .= " , ";

                            }
                            $quoi = substr($quoi, 0, -2);
                            $lesSalaries=$pdoChaudoudoux->obtenirListeSalariePlaces($quoi);
                            for ($i = 0; $i != count($lesSalaries); $i++) {
                                $chezMAND = "";
                                $famillesMAND = $pdoChaudoudoux->obtenirFamilleActuelleMAND($lesSalaries[$i][36]);
                                for ($o = 0; $o != count($famillesMAND); $o++) {
                                    $chezMAND = $chezMAND . $pdoChaudoudoux->obtenirNomFamille($famillesMAND[$o]['numero_Famille']) . " / ";
                                }
                                $chezPREST = "";
                                $famillesPREST = $pdoChaudoudoux->obtenirFamilleActuellePREST($lesSalaries[$i][36]);
                                for ($o = 0; $o != count($famillesPREST); $o++) {
                                    $chezPREST = $chezPREST . $pdoChaudoudoux->obtenirNomFamille($famillesPREST[$o]['numero_Famille']) . " / ";
                                }
                                $place = $pdoChaudoudoux->PlaceOuNon($lesSalaries[$i][36]);
                                array_push($lesSalaries[$i], $chezMAND);
                                array_push($lesSalaries[$i], $chezPREST);
                                array_push($lesSalaries[$i], $place);

                            }
                            array_push($lesChamps, ['COLUMN_NAME' => 'chezMAND', 'COLUMN_TYPE' => 'table']);
                            array_push($lesChamps, ['COLUMN_NAME' => 'chezPREST', 'COLUMN_TYPE' => 'table']);
                            array_push($lesChamps, ['COLUMN_NAME' => 'place', 'COLUMN_TYPE' => 'tinyint(1)']);
                            $archive=0;
                            include("vues/v_listeSalaries.php");
                            break;

                        case 'voirTousSalariejamaisplaces':
                            $lesChamps=$pdoChaudoudoux->obtenirListeChampI();
                            $quoi = " ";
                            foreach ($lesChamps as $unChamp) {
                                if (strpos($unChamp['COLUMN_NAME'], 'Candidats')){
                                    $quoi .= "C.".$unChamp['COLUMN_NAME'];
                                } else if (strpos($unChamp['COLUMN_NAME'], 'Intervenants')){
                                    $quoi .= "I.".$unChamp['COLUMN_NAME'];
                                } else {
                                    $quoi .= $unChamp['COLUMN_NAME'];
                                }
                                $quoi .= " , ";

                            }
                            $quoi = substr($quoi, 0, -2);
                            $lesSalaries=$pdoChaudoudoux->obtenirListeSalarieJamaisPlaces($quoi);
                            for ($i = 0; $i != count($lesSalaries); $i++) {
                                $chezMAND = "";
                                $famillesMAND = $pdoChaudoudoux->obtenirFamilleActuelleMAND($lesSalaries[$i][36]);
                                for ($o = 0; $o != count($famillesMAND); $o++) {
                                    $chezMAND = $chezMAND . $pdoChaudoudoux->obtenirNomFamille($famillesMAND[$o]['numero_Famille']) . " / ";
                                }
                                $chezPREST = "";
                                $famillesPREST = $pdoChaudoudoux->obtenirFamilleActuellePREST($lesSalaries[$i][36]);
                                for ($o = 0; $o != count($famillesPREST); $o++) {
                                    $chezPREST = $chezPREST . $pdoChaudoudoux->obtenirNomFamille($famillesPREST[$o]['numero_Famille']) . " / ";
                                }
                                $place = $pdoChaudoudoux->PlaceOuNon($lesSalaries[$i][36]);
                                array_push($lesSalaries[$i], $chezMAND);
                                array_push($lesSalaries[$i], $chezPREST);
                                array_push($lesSalaries[$i], $place);

                            }
                            array_push($lesChamps, ['COLUMN_NAME' => 'chezMAND', 'COLUMN_TYPE' => 'table']);
                            array_push($lesChamps, ['COLUMN_NAME' => 'chezPREST', 'COLUMN_TYPE' => 'table']);
                            array_push($lesChamps, ['COLUMN_NAME' => 'place', 'COLUMN_TYPE' => 'tinyint(1)']);
                            $archive=0;
                            include("vues/v_listeSalaries.php");
                            break;
						
						case 'voirCarteIntervenants':
							// $count = 0;
							
							$lesChamps=$pdoChaudoudoux->obtenirListeChampI();
							$quoi = " ";
							foreach ($lesChamps as $unChamp) {
								if (strpos($unChamp['COLUMN_NAME'], 'Candidats')){
									$quoi .= "C.".$unChamp['COLUMN_NAME'];
								} else if (strpos($unChamp['COLUMN_NAME'], 'Intervenants')){
									$quoi .= "I.".$unChamp['COLUMN_NAME'];
								} else {
									$quoi .= $unChamp['COLUMN_NAME'];
								}
								$quoi .= " , ";

							}
							$quoi = substr($quoi, 0, -2);

							$lesSalaries=$pdoChaudoudoux->obtenirListeSalarieSelect($quoi);
							$counter = 0;
							for ($i = 0; $i != count($lesSalaries); $i++) {
								$counter += 1;
								$place = $pdoChaudoudoux->PlaceOuNon($lesSalaries[$i][37]);
								array_push($lesSalaries[$i], $place);

							}
							$archive=0;

							// foreach($lesSalaries as $unSalarie){
								// $place = $pdoChaudoudoux->PlaceOuNon($unSalarie["numSalarie_Intervenants"]);
								// $lesSalaries[$count] += ["Place" => $place];
								// $count++;
							// }
							include('vues/v_carteIntervenant.php');
							break;
        default:
            $lesChamps=$pdoChaudoudoux->obtenirListeChampI();
                    $quoi = " ";
                    foreach ($lesChamps as $unChamp) {
                        if (strpos($unChamp['COLUMN_NAME'], 'Candidats')){
                            $quoi .= "C.".$unChamp['COLUMN_NAME'];
                        } else if (strpos($unChamp['COLUMN_NAME'], 'Intervenants')){
                            $quoi .= "I.".$unChamp['COLUMN_NAME'];
                        } else {
                            $quoi .= $unChamp['COLUMN_NAME'];
                        }
                        $quoi .= " , ";

                    }
                    $quoi = substr($quoi, 0, -2);
                    $lesSalaries=$pdoChaudoudoux->obtenirListeSalarie($quoi);
                    for ($i = 0; $i != count($lesSalaries); $i++) {
                        $chezMAND = "";
                        $famillesMAND = $pdoChaudoudoux->obtenirFamilleActuelleMAND($lesSalaries[$i][36]);
                        for ($o = 0; $o != count($famillesMAND); $o++) {
                            $chezMAND = $chezMAND . $pdoChaudoudoux->obtenirNomFamille($famillesMAND[$o]['numero_Famille']) . " / ";
                        }
                        $chezPREST = "";
                        $famillesPREST = $pdoChaudoudoux->obtenirFamilleActuellePREST($lesSalaries[$i][36]);
                        for ($o = 0; $o != count($famillesPREST); $o++) {
                            $chezPREST = $chezPREST . $pdoChaudoudoux->obtenirNomFamille($famillesPREST[$o]['numero_Famille']) . " / ";
                        }
                        $place = $pdoChaudoudoux->PlaceOuNon($lesSalaries[$i][36]);
                        array_push($lesSalaries[$i], $chezMAND);
                        array_push($lesSalaries[$i], $chezPREST);
                        array_push($lesSalaries[$i], $place);

                    }
                    array_push($lesChamps, ['COLUMN_NAME' => 'chezMAND', 'COLUMN_TYPE' => 'table']);
                    array_push($lesChamps, ['COLUMN_NAME' => 'chezPREST', 'COLUMN_TYPE' => 'table']);
                    array_push($lesChamps, ['COLUMN_NAME' => 'place', 'COLUMN_TYPE' => 'tinyint(1)']);
                    $archive=0;
                    include("vues/v_listeSalaries.php");
                    break;
    }
}
?>