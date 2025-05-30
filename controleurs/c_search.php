<?php

include("vues/v_sommaire.php");
// vérification du droit d'accès au cas d'utilisation
if ( ! estConnecte() ) {
    ajouterErreur("L'accès à cette page requiert une authentification !", $tabErreurs);
    include('vues/v_erreurs.php');
}
else  {
    $action = lireDonneeUrl("action", "search");
    switch($action){
        case 'search':/*barre de recherche globale*/
                    $categ = lireDonneePost("categ", "Famille");
                    $name = lireDonneePost("search", "");
                    
                    $res = $searching->rechSimple($categ, $name, "");
                    if ($categ=='Famille'){
                        $lesFamilles=$res;
                    $archive=0;
                        
                        include ("vues/v_listeFamilles.php");
                        $categ = 'Interv';
                    }
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
                    $res = $searching->rechSimple($categ, $name, $quoi);
                    
                    
                    if($categ=='Interv'){
                        $lesSalaries=$res;
                        for ($i = 0; $i != count($lesSalaries); $i++) {
                            $chezMAND = "";
                            $famillesMAND = $pdoChaudoudoux->obtenirFamilleActuelleMAND($lesSalaries[$i][0]);
                            for ($o = 0; $o != count($famillesMAND); $o++) {
                                $chezMAND = $chezMAND . $pdoChaudoudoux->obtenirNomFamille($famillesMAND[$o]['numero_Famille']) . " / ";
                            }
                            $chezPREST = "";
                            $famillesPREST = $pdoChaudoudoux->obtenirFamilleActuellePREST($lesSalaries[$i][0]);
                            for ($o = 0; $o != count($famillesPREST); $o++) {
                                $chezPREST = $chezPREST . $pdoChaudoudoux->obtenirNomFamille($famillesPREST[$o]['numero_Famille']) . " / ";
                            }
                            $place = $pdoChaudoudoux->PlaceOuNon($lesSalaries[$i][0]);
                            array_push($lesSalaries[$i], $chezMAND);
                            array_push($lesSalaries[$i], $chezPREST);
                            array_push($lesSalaries[$i], $place);
                            
                        }                 
                        array_push($lesChamps, ['COLUMN_NAME' => 'chezMAND', 'COLUMN_TYPE' => 'table']);
                        array_push($lesChamps, ['COLUMN_NAME' => 'chezPREST', 'COLUMN_TYPE' => 'table']);
                        array_push($lesChamps, ['COLUMN_NAME' => 'place', 'COLUMN_TYPE' => 'tinyint(1)']);
                        $archive=0;
                        include("vues/v_listeSalaries.php");
                        $categ='Candid';
                    }
                    $res = $searching->rechSimple($categ, $name, "");
                    if ($categ=='Candid'){
                        $lesCandidats=$res;
                    $archive = 1;
                        include 'vues/v_listeCandid.php';
                    }
                    //include("vues/v_resultSearch.php");
                    break;
            
        case 'advSearchI' :/*recherche avancée dans INTERVENANTS*/
                    $lesChamps = $pdoChaudoudoux->obtenirListeChampI();
                    include("vues/v_advSearchI.php");
                    break;

        case 'advSearchF' :/*recherche avancée dans Famille*/
            $lesChamps = $pdoChaudoudoux->obtenirListeChampF();
            $lesVilles = $pdoChaudoudoux->obtenirListeVilleF();
            include("vues/v_advSearchF.php");
            break;



            /*modifier le 27/05/2021*/
        case 'resAdvSearchI':/*résultat de recherche avancée dans INTERVENANTS*/
                        $DB=lireDonneePost('DB');
                        $EMT=lireDonneePost('EMT');
                        $TC=lireDonneePost('TC');
                        $exp=lireDonneePost('btnExp');
                        $enfHand=lireDonneePost('btnEnfHand');
                        $rennes= lireDonneePost('btnRennes');
                        $vehicule=lireDonneePost("btnVeh");
                        $rechCompl=lireDonneePost('rechCompl');
                        $statutPro=lireDonneePost('SP');
                        $sitFam=lireDonneePost('SF');
                        $permis=lireDonneePost('PS');
                        $mutuelle=lireDonneePost('Mut');
                        $archive=lireDonneePost('IA');
                        $cp=lireDonneePost('CP');
                        $titre=lireDonneePost('titre');

                        if (lireDonneePost('nom') == 1){
                            $nom = lireDonneePost('NomRecherche');
                        } else {
                            $nom = "";
                        }
                        if (lireDonneePost('prenom') == 1){
                            $prenom = lireDonneePost('PrenomRecherche');
                        } else {
                            $prenom = "";
                        }

                        $age=lireDonneePost('age');
                        $lieuNaissC = lireDonneePost('lieuNaiss'); 
                        if (lireDonneePost('lieuNaiss') == 1){
                            $lieuNaiss = lireDonneePost('lieuNaissRecherche');
                        } else {
                            $lieuNaiss = "";
                        }
                        $lieuNaissF = lireDonneePost('lieuNaissF');

                        $paysNaissC = lireDonneePost('paysNaiss');
                        if (lireDonneePost('paysNaiss') == 1){
                            $paysNaiss = lireDonneePost('paysNaissRecherche');
                        } else if (lireDonneePost('paysNaiss') == 0){
                            $paysNaiss = lireDonneePost('paysNaissNERecherche');
                        } else {
                            $paysNaiss = "";
                        }
                        $paysNaissF = lireDonneePost('paysNaissF');

                        $champ= explode("-", lireDonneePost('listChampI'));
                        if ($champ[1] == "date" || $champ[1] == "datetime"){
                            $rech=lireDonneePost('cherchedate');
                        } else if ($champ[1] == "tinyint(1)") {
                            $rech=lireDonneePost('cherchebin');
                        } else {
                            $rech=lireDonneePost('cherchetxt');
                        }
                        $champ = $champ[0];
                        $modifplanning = lireDonneePost('modifplanning');
                        $modiffiche = lireDonneePost('modiffiche');
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
                        $res=$searching->rechAdvInterv($DB, $EMT, $TC, $exp, $enfHand, $rennes, $vehicule, $rechCompl, $statutPro, $sitFam, $permis, $mutuelle, $archive, $cp, $titre, $nom, $prenom, $age, $lieuNaiss, $lieuNaissF, $paysNaiss, $paysNaissF, $lieuNaissC, $paysNaissC, $champ, $rech, $modifplanning, $modiffiche, $quoi);
                        $lesSalaries=$res;
                        for ($i = 0; $i != count($lesSalaries); $i++) {
                            $chezMAND = "";
                            $famillesMAND = $pdoChaudoudoux->obtenirFamilleActuelleMAND($lesSalaries[$i][0]);
                            for ($o = 0; $o != count($famillesMAND); $o++) {
                                $chezMAND = $chezMAND . $pdoChaudoudoux->obtenirNomFamille($famillesMAND[$o]['numero_Famille']) . " / ";
                            }
                            $chezPREST = "";
                            $famillesPREST = $pdoChaudoudoux->obtenirFamilleActuellePREST($lesSalaries[$i][0]);
                            for ($o = 0; $o != count($famillesPREST); $o++) {
                                $chezPREST = $chezPREST . $pdoChaudoudoux->obtenirNomFamille($famillesPREST[$o]['numero_Famille']) . " / ";
                            }
                            $place = $pdoChaudoudoux->PlaceOuNon($lesSalaries[$i][0]);
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
            
                   /*modifier le 27/05/2021*/ 
        case 'resAdvSearchF':/*résultat de recherche avancée dans FAMILLE*/
                    $type=lireDonneePost("typeFamille");
                    $besoin=lireDonneePost("besoinFamille");
                    $age=lireDonneePost("ageEnfant");
                    $date=lireDonneePost("date");
                    $partage=lireDonneePost("partageFamille");
                    $logement=lireDonneePost("logementFamille");
                    $superficie=lireDonneePost("superficieFamille");
                    $vehicule=lireDonneePost("vehiculeFamille");
                    $archive=lireDonneePost("archiveFamille");
                    $champ= explode("-", lireDonneePost('listChampF'));
                    if ($champ[1] == "date" || $champ[1] == "datetime"){
                        $rech=lireDonneePost('cherchedate');
                    } else if ($champ[1] == "tinyint(1)") {
                        $rech=lireDonneePost('cherchebin');
                    } else {
                        $rech=lireDonneePost('cherchetxt');
                    }
                    $champ = $champ[0];
                    $villeETcp=explode("-",lireDonneePost("listVilleF"));
                    $res=$searching->rechAdvFamille($type, $besoin, $age, $partage, $logement, $superficie, $vehicule, $archive, $villeETcp, $champ, $rech, $date);
                    $lesFamilles=$res;
                    $archive=0;
                    include 'vues/v_listeFamilles.php';
                break;

        default:
                    
                    include("vues/v_advSearchI.php");
                    break;
    }
}
?>