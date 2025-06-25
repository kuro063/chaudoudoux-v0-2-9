<?php
include("vues/v_sommaire.php");
// vérification du droit d'accès au cas d'utilisation
if ( !estConnecte() ) {
    ajouterErreur("L'accès à cette page requiert une authentification !", $tabErreurs);
    include('vues/v_erreurs.php');
}
else {
    $action = lireDonneeUrl('action', 'voirTousFamille');
    switch($action){
        case 'voirTousFamille':
            $lesFamilles=$pdoChaudoudoux->obtenirListeFamille();
            $archive=0;
            include("vues/v_listeFamilles.php");
        break;
        case 'voirTousFamilleBesoinGE':
            $num = lireDonneeUrl('num');
            //$lesBesoinsFamillesGE=$pdoChaudoudoux->obtenirBesoinsGEFamille();
            $lesBesoinsFamillesGE=$pdoChaudoudoux->ObtenirFamilleApourvoirGE();
            //var_dump($lesBesoinsFamillesGE);
            $archive=0;
            include("vues/v_listeBesoinsGEFamilles.php");
        break;
        case 'voirTousFamilleBesoinGEFutur':
            $num = lireDonneeUrl('num');
            //$lesBesoinsFamillesGE=$pdoChaudoudoux->obtenirBesoinsGEFamille();
            $lesBesoinsFamillesGE=$pdoChaudoudoux->ObtenirFamilleApourvoirGEFutur();
            //var_dump($lesBesoinsFamillesGE);
            $archive=0;
            include("vues/v_listeBesoinsGEFamillesFutur.php");
        break; 
        case 'voirTousFamilleBesoinM':
            $num = lireDonneeUrl('num');
            //$lesBesoinsFamillesM=$pdoChaudoudoux->obtenirBesoinsMFamille();
            $lesBesoinsFamillesM=$pdoChaudoudoux->ObtenirFamilleApourvoirM();
            //var_dump($lesBesoinsFamillesM);
            $archive=0;
            include("vues/v_listeBesoinsMFamilles.php");
        break;
        case 'voirTousFamilleBesoinMFutur':
            $num = lireDonneeUrl('num');
            //$lesBesoinsFamillesM=$pdoChaudoudoux->obtenirBesoinsMFamille();
            $lesBesoinsFamillesM=$pdoChaudoudoux->ObtenirFamilleApourvoirMFutur();
            //var_dump($lesBesoinsFamillesM);
            $archive=0;
            include("vues/v_listeBesoinsMFamillesFutur.php");
        break;
        case 'demanderSupprimerFamille':
            $num = lireDonneeUrl('num');
            $parents=$pdoChaudoudoux->obtenirDetailParents($num);

            include("vues/v_suppressionFamille.php");
        break;
        case 'suppressionConfirmee':
            $num = lireDonneeUrl('num');

            $parents=$pdoChaudoudoux->obtenirDetailParents($num);

            $FamilleAsupprimer=$pdoChaudoudoux->suppFamille($num);

            include("vues/v_suppressionConfirmee.php");
        break;
        case 'vueMand':
            $lesFamilles=$pdoChaudoudoux->obtenirListeFamilleMand();
            $archive=0;
            include("vues/v_listeFamilles.php");
        break;
        case 'vuePrestM':
             $lesFamilles=$pdoChaudoudoux->obtenirListeFamillePrestaM();
            $archive=0;
            include("vues/v_listeFamilles.php");
        break;
        case 'vuePrestGE':
            $lesFamilles=$pdoChaudoudoux->obtenirListeFamillePrestaGE();
            $archive=0;
            include("vues/v_listeFamilles.php");
        break;
        case 'vuePrestMKM':
            $lesFamilles=$pdoChaudoudoux->obtenirListeFamillePrestaM();
            $archive=0;
            include("vues/v_listeFamilles.php");
        break;
        case 'vuePrestGEKM':
            $lesFamilles=$pdoChaudoudoux->obtenirListeFamillePrestaGE();
            $archive=0;
            include("vues/v_listeFamilles.php");
        break;
        case 'voirTousFamilleArchive':
            $lesFamilles=$pdoChaudoudoux->obtenirListeFamilleArchive();
            $archive=1;
            include("vues/v_listeFamilles.php");
        break;

        // intervenants dispo

        case 'voirIntervenantsDispo':
             $numFamille = lireDonneeUrl('num');
             include("vues/v_intervenantsDispo.php");
             $archive=0;
                
        break;

        case 'voirMatchingFamilleGE' :
            if(isset($_POST['ignoreSecteur'])){ $ignoreSecteur = $_POST['ignoreSecteur']; }
            else{ $ignoreSecteur = ""; }

            include("vues/v_intervenantsDispo.php");
            break;

        case 'voirMatchingFamilleMenage':
            if(isset($_POST['ignoreSecteur'])){ $ignoreSecteur = $_POST['ignoreSecteur']; }
            else{ $ignoreSecteur = ""; }
            
            include("vues/v_intervenantsDispo.php");
            break;
        
        case 'voirMatchingFamilleGEMasque':
            include("vues/v_intervenantsDispoMasque.php");
            break;

        case 'voirMatchingFamilleMenageMasque':
            include("vues/v_intervenantsDispoMasque.php");
            break;

        case 'masquerIntervGE':
            $numFamille = lireDonneeUrl('numFamille');
            $numInterv = lireDonneeUrl('numInterv');
            $verifIntervMasque = $pdoChaudoudoux->verifIntervMasque($numFamille, $numInterv);
            if($verifIntervMasque != null){
                $pdoChaudoudoux->updateIntervMasqueGE($numFamille, $numInterv, 1);
            }
            else{
                $pdoChaudoudoux->masquerIntervMatchingGE($numFamille, $numInterv);
            }
            break;
        
        case 'masquerIntervMenage':
            $numFamille = lireDonneeUrl('numFamille');
            $numInterv = lireDonneeUrl('numInterv');
            $verifIntervMasque = $pdoChaudoudoux->verifIntervMasque($numFamille, $numInterv);
            if($verifIntervMasque != null){
                $pdoChaudoudoux->updateIntervMasqueMenage($numFamille, $numInterv, 1);
            }
            else{
                $pdoChaudoudoux->masquerIntervMatchingMenage($numFamille, $numInterv);
            }
            break;

        case 'demasquerIntervGE':
            $numFamille = lireDonneeUrl('numFamille');
            $numInterv = lireDonneeUrl('numInterv');
            $verifIntervMasque = $pdoChaudoudoux->verifIntervMasque($numFamille, $numInterv);
            if($verifIntervMasque != null){
                $pdoChaudoudoux->updateIntervMasqueGE($numFamille, $numInterv, 0);
            }
            break;
        
        case 'demasquerIntervMenage':
            $numFamille = lireDonneeUrl('numFamille');
            $numInterv = lireDonneeUrl('numInterv');
            $verifIntervMasque = $pdoChaudoudoux->verifIntervMasque($numFamille, $numInterv);
            if($verifIntervMasque != null){
                $pdoChaudoudoux->updateIntervMasqueMenage($numFamille, $numInterv, 0);
            }
            break;
    
        

        case 'suppBesoinsMenageFamille':
            $numFamille = lireDonneeUrl('num');
            $pdoChaudoudoux->suppLigneMPourvoir($numFamille);
            include("vues/v_modifFicheFamille.php");
            $archive=0;
               
        break;

       

        // intervenants dispo 

        case 'voirEmailPrefabF' :
            $numFamille = lireDonneeUrl("num");
            $lesSalaries = $pdoChaudoudoux->obtenirTousIntervenant();
            include("vues/v_emailPrefab.php");
            break;

        case 'voirEmailPrefabMenage':
            $numFamille = lireDonneeUrl("num");
            $lesSalaries = $pdoChaudoudoux->obtenirTousIntervenant();
            include("vues/v_emailPrefab.php");
            break;

        case 'voirEmailPrefabGE':
            $numFamille = lireDonneeUrl("num");
            $lesSalaries = $pdoChaudoudoux->obtenirTousIntervenant();
            include("vues/v_emailPrefab.php");
            break;
		
		case 'voirEmailPrefabI':
            $numInterv = lireDonneeUrl("num");
            $lesFamilles = $pdoChaudoudoux->obtenirListeFamille();
            include("vues/v_emailPrefab.php");
            break;

        case 'creationEmailPrefabMenage':
            $numFamille = lireDonneeUrl("num");
            $parents = $pdoChaudoudoux->obtenirDetailParents($numFamille);
            $famille = $pdoChaudoudoux->obtenirDetailFamille($numFamille);

            $numSalarie = lireDonneePost("intervenant");
            $salarie = $pdoChaudoudoux->obtenirIntervByNumInterv($numSalarie);

            include("vues/v_emailPrefab.php");
            break;

        case 'creationEmailPrefabGE':
            $numFamille = lireDonneeUrl("num");
            $parents = $pdoChaudoudoux->obtenirDetailParents($numFamille);
            $famille = $pdoChaudoudoux->obtenirDetailFamille($numFamille);

            $numSalarie = lireDonneePost("intervenant");
            $salarie = $pdoChaudoudoux->obtenirIntervByNumInterv($numSalarie);

            include("vues/v_emailPrefab.php");
            break;
		
		case 'creationEmailPrefabIGE':
            $numSalarie = lireDonneeUrl("num");
			$salarie = $pdoChaudoudoux->obtenirIntervByNumInterv($numSalarie);

            $numFamille = lireDonneePost("famille");
            $parents = $pdoChaudoudoux->obtenirDetailParents($numFamille);
            $famille = $pdoChaudoudoux->obtenirDetailFamille($numFamille);
			$enfants=$pdoChaudoudoux->obtenirDetailEnfants($numFamille); 

            include("vues/v_emailPrefab.php");
            break;
			
		case 'creationEmailPrefabIMenage':
            $numSalarie = lireDonneeUrl("num");
			$salarie = $pdoChaudoudoux->obtenirIntervByNumInterv($numSalarie);

            $numFamille = lireDonneePost("famille");
            $parents = $pdoChaudoudoux->obtenirDetailParents($numFamille);
            $famille = $pdoChaudoudoux->obtenirDetailFamille($numFamille);
			$enfants=$pdoChaudoudoux->obtenirDetailEnfants($numFamille);

            include("vues/v_emailPrefab.php");
            break;



        case 'voirTousFamillePrestaGE':
            $lesFamilles=$pdoChaudoudoux->obtenirListeFamillePrestaGE();
            $archive=0;
            include("vues/v_listeFamilles.php");
        break;
        case 'voirTousFamillePrestaM':
            $lesFamilles=$pdoChaudoudoux->obtenirListeFamillePrestaM();
            $archive=0;
            include("vues/v_listeFamilles.php");
        break;
        case 'voirTousFamilleMand':
            $lesFamilles=$pdoChaudoudoux->obtenirListeFamilleMand();
            $archive=0;
            include("vues/v_listeFamilles.php");
        break;
        case 'voirTousFamilleGardePart':
            $lesFamilles=$pdoChaudoudoux->obtenirListeFamilleGardePart();
            $archive=0;
            include("vues/v_listeFamilles.php");
        break;
        case 'voirTousFamilleAPourvoir':
            $lesFamilles=$pdoChaudoudoux->obtenirListeFamilleAPourvoir();
            $archive=0;
            include("vues/v_listeFamilles.php");
        break;
        case 'voirTousFamilleAssembGen':
            $lesFamilles=$pdoChaudoudoux->obtenirListeFamilleAssembGen();
            $archive=0;
            include("vues/v_listeFamilles.php");
            break;
        case 'aPourvoir':
            $num= lireDonneeUrl('num');
            $pdoChaudoudoux->aPourvoir($num);
            $lesFamilles=$pdoChaudoudoux->obtenirListeFamilleAPourvoir();
            $archive=0;
            include("vues/v_listeFamilles.php");
            break;
        case 'Pourvu':
            $num= lireDonneeUrl('num');
            $pdoChaudoudoux->Pourvu($num);
            $lesFamilles=$pdoChaudoudoux->obtenirListeFamilleAPourvoir();
            $archive=0;
            include("vues/v_listeFamilles.php");
            break;
        case 'voirTousFamilleAPourvoirM':
                $lesFamilles=$pdoChaudoudoux->obtenirListeFamilleAPourvoirM();
                $archive=0;
                include("vues/v_listeFamilles.php");
            break;
        case 'voirTousFamilleAPourvoirGE':
                $lesFamilles=$pdoChaudoudoux->obtenirListeFamilleAPourvoirGE();
                $archive=0;
                include("vues/v_listeFamilles.php");
            break;
        case 'voirDetailFamille':
                    $num = lireDonneeUrl('num');   
                    //infos famille 
                    $famille=$pdoChaudoudoux->obtenirDetailFamille($num);
                  //  $presta=$pdoChaudoudoux->obtenirPrestaFamille($num);
                    $adresse = $famille['adresse_Famille'];
                    $enfHand=$famille['enfantHand_Famille'];
                    $prestm=$famille['prestM_Famille'];
                    $garde=$pdoChaudoudoux->obtenirFamilleGardePart($num);
                    $mand=$famille['mand_Famille'];
                    $prestge=$famille['prestGE_Famille'];
                    $pge=$famille['PGE_Famille'];
                    $pm=$famille['PM_Famille'];
                    $option=$famille['option_Famille'];
                    $ligneBus=$famille['numBus_Famille'];
                    $sortieMand=$famille['sortieMand_Famille'];
                    $arretBus=$famille['arretBus_Famille'];
                    $typeLogement=$famille['typeLogement_Famille'];
                    $superficie=$famille['superficie_Famille'];
                    $nbEtages=$famille['nbEtage_Famille'];
                    $nbChambres=$famille['nbChambres_Famille'];
                    $nbSDB=$famille['nbSDB_Famille'];
                    $nbSani=$famille['nbSanitaire_Famille'];
                    $gardePart=$famille['gardePart_Famille'];
                    $repassage=$famille['repassage_Famille'];
                    $reg=$famille['REG_Famille'];
                    $cp = $famille['cp_Famille'];
                    $modePaiement=$famille['modePaiement_Famille'];
                    $ville = $famille['ville_Famille'];
                    $remarque= $famille['Remarques_Famille'];
                    $observ= $famille['observations_Famille'];
                    $dateModif=$famille['dateModif_Famille'];
                    $quart = $famille['quartier_Famille'];
                    $tel = $famille['telDom_Famille'];
                    $sortiePGE=$famille['sortiePGE_Famille'];
                    $sortiePM=$famille['sortiePM_Famille'];
                    $aPourvoir = $famille['aPourvoir_Famille'];
                    $MPourvoir = $famille['aPourvoir_PM'];
                    $GEPourvoir = $famille['aPourvoir_PGE'];
                    $numAlloc = $famille['numAlloc_Famille'];
                    $numURSSAF = $famille['numURSSAF_Famille'];
                    $vehicule = $famille['vehicule_Famille'];
                    $dateEntree = $famille['dateEntree_Famille'];
                    $dateSortie = $famille['dateSortie_Famille'];
                    $suivi= $famille['suivi_Famille'];
                    $ag = $famille['AG_Famille'];
                    $archive = $famille['archive_Famille'];
                    
                    //infos sur la demande

                    
                    //infos parents
                    $parents=$pdoChaudoudoux->obtenirDetailParents($num);
                    //infos enfants
                    $enfants=$pdoChaudoudoux->obtenirDetailEnfants($num);  
                   
                    

                    include("vues/v_detailFamille.php");
                    break;
            

            
        case 'ficheMail':
            $num = lireDonneeUrl('num');   
                    //infos famille 
                    $famille=$pdoChaudoudoux->obtenirDetailFamille($num);
                  //  $presta=$pdoChaudoudoux->obtenirPrestaFamille($num);
                    $adresse = $famille['adresse_Famille'];
                    $enfHand=$famille['enfantHand_Famille'];
                    $pge=$famille['PGE_Famille'];
                    $pm=$famille['PM_Famille'];
                    $option=$famille['option_Famille'];
                    $reg=$famille['REG_Famille'];
                    $cp = $famille['cp_Famille'];
                    $ville = $famille['ville_Famille'];
                    $remarque= $famille['Remarques_Famille'];
                    $observ= $famille['observations_Famille'];
                    $dateModif=$famille['dateModif_Famille'];
                    $quart = $famille['quartier_Famille'];
                    $arretBus=$famille['arretBus_Famille'];
                    $ligneBus=$famille['numBus_Famille'];
                    $tel = $famille['telDom_Famille'];
                    $numAlloc = $famille['numAlloc_Famille'];
                    $numURSSAF = $famille['numURSSAF_Famille'];
                    $vehicule = $famille['vehicule_Famille'];
                    $dateEntree = $famille['dateEntree_Famille'];
                    $dateSortie = $famille['dateSortie_Famille'];
                    $modePaiement=$famille['modePaiement_Famille'];
                    $suivi= $famille['suivi_Famille'];
                    $ag = $famille['AG_Famille'];
                    
                    //infos parents
                    $parents=$pdoChaudoudoux->obtenirDetailParents($num);
                    //infos enfants
                    $enfants=$pdoChaudoudoux->obtenirDetailEnfants($num);  
                    
                    $garde=$pdoChaudoudoux->obtenirFamilleGardePart($num);
                    $prestge=$famille['prestGE_Famille'];
                    $mand=$famille['mand_Famille'];
                    $prestm=$famille['prestM_Famille'];

                    include("vues/v_ficheMail.php");
                    break;
        case 'voirDetailFamille':
                    $num = lireDonneeUrl('num');   
                    //infos famille 
                    $famille=$pdoChaudoudoux->obtenirDetailFamille($num);
                  //  $presta=$pdoChaudoudoux->obtenirPrestaFamille($num);
                    $adresse = $famille['adresse_Famille'];
                    $modePaiement=$famille['modePaiement_Famille'];
                    $enfHand=$famille['enfantHand_Famille'];
                    $pge=$famille['PGE_Famille'];
                    $pm=$famille['PM_Famille'];
                    $option=$famille['option_Famille'];
                    $ligneBus=$famille['numBus_Famille'];
                    $arretBus=$famille['arretBus_Famille'];
                    $typeLogement=$famille['typeLogement_Famille'];
                    $superficie=$famille['superficie_Famille'];
                    $sortieMand=$famille['sortieMand_Famille'];
                    $nbEtages=$famille['nbEtage_Famille'];
                    $nbChambres=$famille['nbChambres_Famille'];
                    $nbSDB=$famille['nbSDB_Famille'];
                    $nbSani=$famille['nbSanitaire_Famille'];
                    $gardePart=$famille['gardePart_Famille'];
                    $repassage=$famille['repassage_Famille'];
                    $garde=$pdoChaudoudoux->obtenirFamilleGardePart($num);
                    $reg=$famille['REG_Famille'];
                    $cp = $famille['cp_Famille'];
                    $sortiePGE=$famille['sortiePGE_Famille'];
                    $sortiePM=$famille['sortiePM_Famille'];
                    $ville = $famille['ville_Famille'];
                    $remarque= $famille['Remarques_Famille'];
                    $observ= $famille['observations_Famille'];
                    $dateModif=$famille['dateModif_Famille'];
                    $quart = $famille['quartier_Famille'];
                    $tel = $famille['telDom_Famille'];
                    $numAlloc = $famille['numAlloc_Famille'];
                    $numURSSAF = $famille['numURSSAF_Famille'];
                    $vehicule = $famille['vehicule_Famille'];
                    $dateEntree = $famille['dateEntree_Famille'];
                    $dateSortie = $famille['dateSortie_Famille'];
                    $suivi= $famille['suivi_Famille'];
                    $ag = $famille['AG_Famille'];
                    //infos parents
                    $parents=$pdoChaudoudoux->obtenirDetailParents($num);
                    //infos enfants
                    $enfants=$pdoChaudoudoux->obtenirDetailEnfants($num);                
                    include("vues/v_detailFamille.php");
                    break;



                    case 'supprimerDemandeFamille':
                        $numDemande=lireDonneeUrl('numDemande');
                        $pdoChaudoudoux->suppLigneDemande($numDemande);
                        ajouterErreur("Demande supprimée !", $tabErreurs);
                        include('vues/v_erreurs.php');

                        break;
                        
        case 'demanderModifFamille':
            // var_dump($_POST);
                    $num = lireDonneeUrl('num');
                    $famille=$pdoChaudoudoux->obtenirDetailFamille($num);
                  //  $presta=$pdoChaudoudoux->obtenirPrestaFamille($num);
                    $typePresta = "";
                    $lesFamilles=$pdoChaudoudoux->obtenirNomsFamille();
                    $prestMand = "";
                    $archive=$famille['archive_Famille'];
                    $regularite = "";
                    $pge=$famille['PGE_Famille'];
                    $mand=$famille['mand_Famille'];
                    $sortieMand=$famille['sortieMand_Famille'];
                    $sortiePGE=$famille['sortiePGE_Famille'];
                    $sortiePM=$famille['sortiePM_Famille'];
                    $mena=$famille['prestM_Famille'];
                    $garde=$pdoChaudoudoux->obtenirFamilleGardePart($num);
                    $aPourvoir=$famille['aPourvoir_Famille'];
                    $MPourvoir=$famille['aPourvoir_PM'];
                    $GEPourvoir=$famille['aPourvoir_PGE'];
                    $dateMPourvoir=$famille['Date_aPourvoir_PM'];
                    $dateGEPourvoir=$famille['Date_aPourvoir_PGE'];
                    $ge=$famille['prestGE_Famille'];
                    $enfHand=$famille['enfantHand_Famille'];
                    $pm=$famille['PM_Famille'];
                    $reg=$famille['REG_Famille'];
                    $remarque= $famille['Remarques_Famille'];
                    $ligneBus=$famille['numBus_Famille'];
                    $arretBus=$famille['arretBus_Famille'];
                    $typeLogement=$famille['typeLogement_Famille'];
                    $superficie=$famille['superficie_Famille'];
                    $nbEtages=$famille['nbEtage_Famille'];
                    $nbChambres=$famille['nbChambres_Famille'];
                    $nbSDB=$famille['nbSDB_Famille'];
                    $nbSani=$famille['nbSanitaire_Famille'];
                    $gardePart=$famille['gardePart_Famille'];
                    $repassage=$famille['repassage_Famille'];
                    $observ= $famille['observations_Famille'];
                    $adresse = $famille['adresse_Famille'];
                    $modePaiement=$famille['modePaiement_Famille'];
                    $cp = $famille['cp_Famille'];
                    $ville = $famille['ville_Famille'];
                    $quart = $famille['quartier_Famille'];
                    $tel = $famille['telDom_Famille'];
                    $numAlloc = $famille['numAlloc_Famille'];
                    $numURSSAF = $famille['numURSSAF_Famille'];
                    $option= $famille['option_Famille'];
                    $vehicule = $famille['vehicule_Famille'];
                    $suivi=$famille['suivi_Famille'];
                    $dateEntree = new DateTime($famille['dateEntree_Famille']);
                    $dateSortie = $famille['dateSortie_Famille'];
                    $secteurFamille = $famille['secteur_Famille'];


                    error_reporting(0);
                    ini_set('display_errors', 0);
                    $dateTempAPourvoir_MEN = "";
                    $dateTempAPourvoir_GE = "";//date possible de prestation à pourvoir
                    $dateSortieInt = $pdoChaudoudoux->obtenirDateSortieInt($num,"MENA")[0]["dateSortie_intervenants"];
                    $dateSortiePlan = $pdoChaudoudoux->obtenirDateFinPlanning($num,"MENA")[0]["dateFin_Proposer"];
                    if($dateSortieInt<$dateSortiePlan) {
                        if(isset($dateSortieInt)) {$dateTempAPourvoir_MEN = $dateSortieInt;}//si il n'est pas null
                        else{$dateTempAPourvoir_MEN = $dateSortiePlan;}
                      }else {
                        if(isset($dateSortiePlan)) {$dateTempAPourvoir_MEN = $dateSortiePlan;}//si il n'est pas null
                        else {if(isset($dateSortieInt)) {$dateTempAPourvoir_MEN = $dateSortieInt;}}//si il n'est pas null
                      }
                    
                    $dateSortieInt = $pdoChaudoudoux->obtenirDateSortieInt($num,"ENFA")[0]["dateSortie_intervenants"];
                    $dateSortiePlan = $pdoChaudoudoux->obtenirDateFinPlanning($num,"ENFA")[0]["dateFin_Proposer"];
                    if($dateSortieInt<$dateSortiePlan) {
                        if(isset($dateSortieInt)) {$dateTempAPourvoir_GE = $dateSortieInt;}
                        else{$dateTempAPourvoir_GE = $dateSortiePlan;}
                      }else {
                        if(isset($dateSortiePlan)){$dateTempAPourvoir_GE = $dateSortiePlan; }
                        else {if(isset($dateSortieInt)) {$dateTempAPourvoir_GE = $dateSortieInt;}}
                      }
                      
                    error_reporting(E_ALL);
                    ini_set('display_errors', 1);
                    
                    $ag = $famille['AG_Famille'];
                    //infos parents
                    $parents=$pdoChaudoudoux->obtenirDetailParents($num);
                    //infos enfants
                    $enfants=$pdoChaudoudoux->obtenirDetailEnfants($num);
                    // $interv = $pdoChaudoudoux->obtenirListeSalarie();


                    include("vues/v_modifFicheFamille.php");
                    break;

                    case'modifierDemandeFamille' :
                            $numDemande = lireDonneeUrl('numDemande');
                            $laDemande = $pdoChaudoudoux->ObtenirLigneDemande($numDemande);
                            include("vues/v_modifDemandeFamille.php");
                            break;

                    case'validerDemandeFamille' :
                        $numDemande = lireDonneeUrl('numDemande');

                        if($_POST['slctJour']!="jour"){
                            $jour=$_POST['slctJour'];
                            $jourException=$_POST[""];
                            $frequence=$_POST['frequence']; 
                            $hDeb=$_POST['Hdeb'];
                            $minDeb=$_POST['minDeb'];
                            $minFin=$_POST['minFin'];
                            $hFin=$_POST['Hfin'];
                            $heureDeb=$hDeb.":".$minDeb.":00";
                            $heureFin=$hFin.":".$minFin.":00";
                            $pdoChaudoudoux->modifierLigneDemande($numDemande, $jour, $heureDeb, $heureFin, $frequence);
                        }
                        ajouterErreur("Demande modifiée !", $tabErreurs);
                        include('vues/v_erreurs.php');
                        break;





        case 'validerModifFamille' :
            //var_dump($_POST);

            
            $num = lireDonneeUrl('num');

            
                if(isset($_POST["MPourvoir"])){

                    $activite="menage";

                    if($_POST['slctJourM']!="jour"){
                        $jour=$_POST['slctJourM'];
                        $frequence=$_POST['frequenceM']; 
                        $hDeb=$_POST['HdebM'];
                        $minDeb=$_POST['minDebM'];
                        $minFin=$_POST['minFinM'];
                        $hFin=$_POST['HfinM'];
                        $heureDeb=$hDeb.":".$minDeb.":00";
                        $heureFin=$hFin.":".$minFin.":00";
                        $pdoChaudoudoux->ajoutBesoins($num, $jour, $heureDeb,$heureFin, $activite,$frequence);

                    }
                    
                        for ($id=1; $id < count($_POST); $id++) { 
                        if(!isset($_POST['slctJourM'.$id.''])){
                          continue;
                        }elseif($_POST["slctJourM".$id.""]!="jour"){
                        $jour=$_POST["slctJourM".$id.""];
                        $frequence=$_POST["frequenceM".$id.""]; 
                        $hDeb=$_POST["HDebM".$id.""];
                        $minDeb=$_POST["minDebM".$id.""];
                        $minFin=$_POST["minFinM".$id.""];
                        $hFin=$_POST["HfinM".$id.""];
                        $heureDeb=$hDeb.":".$minDeb.":00";
                        $heureFin=$hFin.":".$minFin.":00";
                        
                        $pdoChaudoudoux->ajoutBesoins($num, $jour, $heureDeb,$heureFin, $activite,$frequence);

                       }}}

                       if(isset($_POST["GEPourvoir"])){

                        $activite="garde d'enfants";
   
                       if($_POST['slctJourGE']!="jour"){
                           $jour=$_POST['slctJourGE'];
                           $frequence=$_POST['frequenceGE']; 
                           $hDeb=$_POST['HdebGE'];
                           $minDeb=$_POST['minDebGE'];
                           $minFin=$_POST['minFinGE'];
                           $hFin=$_POST['HfinGE'];
                           $heureDeb=$hDeb.":".$minDeb.":00";
                           $heureFin=$hFin.":".$minFin.":00";
                           $pdoChaudoudoux->ajoutBesoins($num, $jour, $heureDeb,$heureFin, $activite,$frequence);
   
                       }
                       
                           for ($id=1; $id < count($_POST); $id++) { 
                           if(!isset($_POST['slctJourGE'.$id.''])){
                             continue;
                           }elseif($_POST["slctJourGE".$id.""]!="jour"){
                           $jour=$_POST["slctJourGE".$id.""];
                           $frequence=$_POST["frequenceGE".$id.""]; 
                           $hDeb=$_POST["HDebGE".$id.""];
                           $minDeb=$_POST["minDebGE".$id.""];
                           $minFin=$_POST["minFinGE".$id.""];
                           $hFin=$_POST["HfinGE".$id.""];
                           $heureDeb=$hDeb.":".$minDeb.":00";
                           $heureFin=$hFin.":".$minFin.":00";                           
                           $pdoChaudoudoux->ajoutBesoins($num, $jour, $heureDeb,$heureFin, $activite,$frequence);
                        }
                    }
                }
                
              
                    $num = lireDonneeUrl('num');
                    $remarque= lireDonneePost('txtRemarques');
                    $chkarchive = lireDonneePost('archive', 0);
                    $aPourvoir= lireDonneePost('aPourvoir');
                    $MPourvoir= lireDonneePost('MPourvoir');
                    $dateMPourvoir= lireDonneePost('dateMPourvoir');
                    $GEPourvoir= lireDonneePost('GEPourvoir');
                   //echo $MPourvoir;
                   //echo $GEPourvoir;
            
                   if($aPourvoir==0){
                    $pdoChaudoudoux->suppToutAPourvoir($num);
                    // echo "MPourvoir null";
                    }
                    if($MPourvoir==0){
                        $pdoChaudoudoux->suppToutMPourvoir($num);
                        // echo "MPourvoir null";
                    }
                    if($GEPourvoir==0){
                        $pdoChaudoudoux->suppToutGEPourvoir($num);
                        // echo "GEPourvoir null";

                    }
                    $type_prestation= lireDonneePost('type_prestation');
                    if ($GEPourvoir == '1' && $type_prestation == 'Mandataire') {
                        $GEPourvoir = '2';
                    }
                    $dateGEPourvoir= lireDonneePost('dateGEPourvoir');
                    $observ= lireDonneePost('txtObs');
                    $sortiePM= lireDonneePost('dateSortiePM');
                    $sortiePGE= lireDonneePost('dateSortiePGE');
                    $mena= lireDonneePost('chkMen');
                    $dateModif=date('r');
                    $ge= lireDonneePost('chkGE');
                    switch(lireDonneePost('chkMand')) {
                        case 0: // non Mandataire 
                            $mand = 0;
                            $reg = "";
                            break;
                        case 1: // Mandataire Régulier
                            $mand = 1;
                            $reg = "REG";
                            break;
                        case 2: // Mandataire Occasionnel
                            $mand = 1;
                            $reg = "OCC";
                            break;
                    }
                    $concernGarde= lireDonneePost("concernGarde");
                    $ligneBus= lireDonneePost('txtBus');
                    $arretBus= lireDonneePost('arretBus');
                    $superficie= lireDonneePost('superficie');
                    $num1= lireDonneePost('num1');
                    $num2= lireDonneePost('avecPart');
                    if ($num2!=""){
                    $pdoChaudoudoux->majFamilleGardePart($num1, $num2);}
                    $nbEtages= lireDonneePost('nbEtages');
                    $sortieMand= lireDonneePost('sortieMand');
                    $typeLogement= lireDonneePost('typeLogement');
                    $nbChambres= lireDonneePost('nbChambres');
                    $nbSDB= lireDonneePost('nbSDB');
                    $nbSani= lireDonneePost('nbSani');
                    $repassage=lireDonneePost('repassage');
                    $gardePart= lireDonneePost('gardePart');
                    $codeCli= lireDonneePost('codeCli');
                    $pm= lireDonneePost('txtPm');
                    $option= lireDonneePost('option');
                    $enfHand= lireDonneePost('enfHand');
                    $pge= lireDonneePost('txtPge');
                    $suivi= lireDonneePost('suivi');
                    $adresse = lireDonneePost('txtAdr');
                    $modePaiement= lireDonneePost('modePaiement');
                    $cp = lireDonneePost('txtCp');
                    $ville = lireDonneePost('txtVille');
                    $quart = lireDonneePost('txtQuart');
                    $tel = lireDonneePost('txtFixe');
                    $prestge=$ge;
                    $prestm=$mena;
                    $numAlloc = lireDonneePost('txtNumAlloc');
                    $numURSSAF = lireDonneePost('txtNumURSSAF');
                    $vehicule = lireDonneePost('chkVehicule', 0);
                    $dateEntree = lireDonneePost('dateEntree');
                    $dateSortie = lireDonneePost('dateSortie');
             //$reg = lireDonneePost('txtPge');
                    $ag = lireDonneePost('chkAG', 0);
                    $secteurFamille = lireDonneePost('slctSecteur');

                    for ($i=1; $i < 9; $i++) { 
                        $nom = lireDonneePost('nomEnf'.$i, '');
                        $prenom = lireDonneePost('prenomEnf'.$i, '');
                        $dateNaiss = lireDonneePost('dateNaisEnf'.$i);
                        $suppr = lireDonneePost('chkSupprEnf'.$i, 0);
                        $concernGarde= lireDonneePost("concernGarde".$i,0);
                        if (isset($nom)&& isset($prenom)){
                        $pdoChaudoudoux->modifierDetailEnfant($num, $nom, $prenom, $dateNaiss, $i, $concernGarde);}
                    }                                   
                    $pdoChaudoudoux->modifierDetailFamille($num, $pm, $pge, $chkarchive, $remarque, $observ, $adresse, $cp, $ville, $quart, $tel, $numAlloc, $numURSSAF, $vehicule, $dateEntree, $dateSortie, $reg, $ag, $suivi, $option,$enfHand,$modePaiement, $mena, $ge,$mand, $aPourvoir, $MPourvoir, $dateMPourvoir, $GEPourvoir, $dateGEPourvoir, $ligneBus, $arretBus, $superficie, $repassage, $gardePart, $nbChambres, $nbEtages, $nbSDB, $nbSani,$typeLogement,$sortieMand, $sortiePM,$sortiePGE, $secteurFamille);
                    for($i=1;$i<=2;$i++) {
                        $prestMand = lireDonneePost('slctPrestMand'.$i, "NONE");
                        $presta = lireDonneePost('slctPresta'.$i, "NONE");
                        $regularite = lireDonneePost('slctRegularite'.$i, "NONE");
                        //$idInterv = lireDonneePost('interv'.$i, '');
                        $codePresta = lireDonneePost('txtCodPresta'.$i, '');
                        $codeCli = lireDonneePost('txtCodCli'.$i, '');
                        $session = lireDonneePost('txtSession', '2017-2018');
                        //$tabIdInterv = decouperNomPrenom($idInterv);
                        //$idInterv = $pdoChaudoudoux->recupererNumInterv($tabIdInterv[1], $tabIdInterv[2]);
                        //$pdoChaudoudoux->modifierPrestaFamille($num, $prestMand, $idInterv, $presta, $codeCli, $codePresta, $regularite, $session, $i);
                    }
                    $nbParents = $pdoChaudoudoux->obtenirNbParents($num);
                        for($i=1;$i<=2;$i++){
                            $titre = lireDonneePost('slctTitreParents'.$i);
                            $nom = lireDonneePost('nomParent'.$i, '');
                            $prenom = lireDonneePost('prenomParent'.$i, '');
                            $telPort = lireDonneePost('telPort'.$i, '');
                            $telPro = lireDonneePost('telPro'.$i, '');
                            $email = lireDonneePost('email'.$i, '');
                            $prof = lireDonneePost('prof'.$i, '');
                            $suppr = lireDonneePost('chkSupprPar'.$i, 0);
                            $pdoChaudoudoux->modifierDetailParents($num, $titre, $nom, $prenom, $telPro, $telPort, $email, $prof, $i);
                        }
                    
                    
                   /* foreach ($_FILES as $unfichier)
                        {
                            
                            $resultat = move_uploaded_file($unfichier['tmp_name'], 'Documents/Familles/'.$num.'/Autres_Documents');}
                        
                        
/*{ 
     $dossier = 'upload/';
     $fichier = basename($_FILES['avatar']['name']);
     if(move_uploaded_file($_FILES['avatar']['tmp_name'], $dossier . $fichier)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
     {
          echo 'Upload effectué avec succès !';
     }
     else //Sinon (la fonction renvoie FALSE).
     {
          echo 'Echec de l\'upload !';
     }
}*/
                    $demandesM=$pdoChaudoudoux->obtenirDemandesM($num);
                    $parents=$pdoChaudoudoux->obtenirDetailParents($num);
                    //infos enfants
                    $enfants=$pdoChaudoudoux->obtenirDetailEnfants($num);        
                    $lesFamilles=$pdoChaudoudoux->obtenirListeFamille();
                    $garde=$pdoChaudoudoux->obtenirFamilleGardePart($num);
                    
                    $archive = $chkarchive;
                    
                    include("vues/v_detailFamille.php");
                    break;
                    
        case 'ajoutFamille' :
            $lesFamilles=$pdoChaudoudoux->obtenirNomsFamille();
            $res=-1;
            include("vues/v_ajoutFamille.php");
            break;
        case 'mailFamPrestGE':
            $adressesPrest = $pdoChaudoudoux->mailPrestFamGE();
            $nbAdresse = count($pdoChaudoudoux->mailPrestFamGE());
            $adressesVides = $pdoChaudoudoux->mailVidePrestFamGE();
            include 'vues/v_adresses.php';
            break;
        case 'mailFamPrestMen':
            $adressesPrest = $pdoChaudoudoux->mailPrestFamMen();
            $nbAdresse = count($pdoChaudoudoux->mailPrestFamMen());
            $adressesVides = $pdoChaudoudoux->mailVidePrestFamMen();
            include 'vues/v_adresses.php';
            break;
        case 'mailFamMand':
            $adressesMand = $pdoChaudoudoux->mailMandFam();
            $nbAdresse = count($pdoChaudoudoux->mailMandFam());
            $adressesVides = $pdoChaudoudoux->mailVideMandFam();
            include 'vues/v_adresses.php';
            break;
        /*case 'mailPrest':
            $adresses= $pdoChaudoudoux->mailPrestFam();
            include 'vues/v_adresses.php';
            break;*/
        case 'validerAjoutFamille' :

                    $codeCli= lireDonneePost('txtCodCli');
                    //$res= $pdoChaudoudoux->VerifM($codeCli);
                    $nbSani= lireDonneePost('nbSani');
                    $remarque= lireDonneePost('txtRemarques');
                    $observ= lireDonneePost('txtObs');
                    $ligneBus= lireDonneePost('txtBus');
                    $arretBus= lireDonneePost('arretBus');
                    $superficie= lireDonneePost('superficie');
                    $sortiePM= lireDonneePost('dateSortiePM');
                    $sortiePGE= lireDonneePost('dateSortiePGE');
                    $num2= lireDonneePost('avecPart');
                    $nbEtages= lireDonneePost('nbEtages');
                    $typeLogement= lireDonneePost('typeLogement');
                    $nbChambres= lireDonneePost('nbChambres');
                    $nbSDB= lireDonneePost('nbSDB');
                    $repassage=lireDonneePost('repassage');
                    $gardePart= lireDonneePost('gardePart');
                    $adresse = lireDonneePost('txtAdr');
                    $mena= lireDonneePost('chkMen');
                    $ge= lireDonneePost('chkGE');
                    //var_dump($_POST);
                    switch(lireDonneePost('chkMand')) {
                        case 0: // non Mandataire 
                            $mand = 0;
                            $reg = "";
                            break;
                        case 1: // Mandataire Régulier
                            $mand = 1;
                            $reg = "REG";
                            break;
                        case 2: // Mandataire Occasionnel
                            $mand = 1;
                            $reg = "OCC";
                            break;
                    }

                    $aPourvoir= lireDonneePost('aPourvoir');
                    $MPourvoir= lireDonneePost('MPourvoir');
                    $dateMPourvoir= lireDonneePost('dateMPourvoir');
                    $GEPourvoir= lireDonneePost('GEPourvoir');
                    $type_prestation= lireDonneePost('type_prestation');
                    if ($GEPourvoir == 1 && $type_prestation == 'Mandataire') {
                        $GePourvoir = 2;
                    }
                    $dateGEPourvoir= lireDonneePost('dateGEPourvoir');
                    $concernGarde= lireDonneePost("concernGarde");
                    $cp = lireDonneePost('txtCp');
                    $ville = lireDonneePost('txtVille');
                    $sortieMand= lireDonneePost('sortieMand');
                    $modePaiement= lireDonneePost('modePaiement');
                    $quart = lireDonneePost('txtQuart');
                    $tel = lireDonneePost('txtFixe');
                    $numAlloc = lireDonneePost('txtNumAlloc');
                    $numURSSAF = lireDonneePost('txtNumURSSAF');
                    $vehicule = lireDonneePost('chkVehicule', 0);
                    $dateEntree = lireDonneePost('dateEntree');
                    $num = $codeCli;
                    $prestm=$mena;$prestge=$ge; $dateModif=date('r');$suivi="";
                    $dateSortie = lireDonneePost('dateSortie');
                    $option= lireDonneePost('option');
                    $pm = lireDonneePost('txtPm');
                    $enfHand= lireDonneePost('enfHand');
                    $pge = lireDonneePost('txtPge');
                    $archive= lireDonneePost('chkArchive',0);
                    $ag = lireDonneePost('chkAG', 0);
                    $secteurFamille = lireDonneePost('slctSecteur');

                    $pdoChaudoudoux->ajoutFamille($codeCli, $pm, $pge, $archive,$remarque, $observ,$adresse, $cp, $ville, $quart, $tel, $numAlloc, $numURSSAF, $vehicule, $dateEntree, $dateSortie, $reg, $ag, $option, $enfHand, $modePaiement, $mand, $mena, $ge, $aPourvoir, $MPourvoir, $dateMPourvoir, $GEPourvoir, $dateGEPourvoir, $ligneBus, $arretBus, $repassage, $superficie, $typeLogement, $nbEtages, $nbSani, $nbSDB, $nbChambres, $gardePart, $sortieMand,$sortiePM,$sortiePGE, $secteurFamille);
                    if ($num2 !=''){
                    $pdoChaudoudoux->majFamilleGardePart($codeCli, $num2);}
                    for($i=1;$i<=2;$i++){ 
                        $titre = lireDonneePost('newSlctTitreParents'.$i);                      
                        $nom = lireDonneePost('newNomP'.$i, '');
                        $prenom = lireDonneePost('newPrenomP'.$i, '');
                        $telPort = lireDonneePost('newTelPort'.$i, '');
                        $telPro = lireDonneePost('newTelPro'.$i, '');
                        $email = lireDonneePost('newEmail'.$i, '');
                        $prof = lireDonneePost('newProf'.$i, '');

                        if ($nom != ''){ $pdoChaudoudoux->ajoutParents($codeCli, $titre, $nom, $prenom, $telPro, $telPort, $email, $prof, 0);}   }
                    for ($i=1; $i <7; $i++) { 
                        $nom = lireDonneePost('nomEnf'.$i, '');
                        $prenom = lireDonneePost('prenomEnf'.$i, '');
                        $dateNaiss = lireDonneePost('dateNaisEnf'.$i, NULL);
                        $suppr = lireDonneePost('chkSupprEnf'.$i, 0);
                        $concernGarde= lireDonneePost("concernGarde".$i,0);
                        if ((isset($nom)&& isset($prenom))||isset($suppr)){
                        $pdoChaudoudoux->ajoutEnfant($codeCli, $nom, $prenom, $dateNaiss, $concernGarde);
                    } }
                                        $parents=$pdoChaudoudoux->obtenirDetailParents($codeCli);
                    //infos enfants
                    $enfants=$pdoChaudoudoux->obtenirDetailEnfants($codeCli);        
                /*    mkdir('Documents/Familles/'.$codeCli, 0777, true);
                    mkdir('Documents/Familles/'.$codeCli.'/Fiche_Famille', 0777, true);
                    mkdir('Documents/Familles/'.$codeCli.'/Autres_Documents', 0777, true);
                    $dossier = 'Documents/Familles/'.$codeCli.'/Autres_Documents';
                    foreach ($_FILES as $unfichier)
                        {
                            $fichier= $dossier . basename($unfichier['name']);
                            $resultat = move_uploaded_file($unfichier['tmp_name'], $fichier);}
                    ajouterErreur("Famille ajoutée !", $tabErreurs);//}*/
                    ///*else {*/ ajouterErreur ("Numéro déjà existant !", $tabErreurs); //}
                    $garde =$pdoChaudoudoux->obtenirFamilleGardePart($num);
                    include('vues/v_detailFamille.php');
                    break;

                    case 'assembGen':
                        /*$lesFamilles=$pdoChaudoudoux->obtenirListeFamilleAssembGenOui();
                        $lesFamilles=$pdoChaudoudoux->obtenirListeFamilleAssembGenNon();*/
                        $lesFamilles=$pdoChaudoudoux->obtenirListeFamille();
                        $lesAssembGen=$pdoChaudoudoux->obtenirListeAssembGen();
                        
                        $archive=0;
                        include 'vues/v_listeAssembGen.php';
                        break;
        case 'voirCarteAPourvoir':
                    $lesFamilles=$pdoChaudoudoux->obtenirListeFamilleAPourvoir();
                    include('vues/v_carteFamille.php');
                    break;

        case 'incoherence':
                    $lesFamilles=$pdoChaudoudoux->trouverIncoherence();
                    $archive=0;
                    include("vues/v_listeFamilles.php");
                    break;
        case 'familleaarchiver':
                    $lesFamilles=$pdoChaudoudoux->obtenirFamillesAArchiver();
                    $archive=0;
                    include("vues/v_listeFamilles.php");
                    break;
                    
        default:
                    $lesFamilles=$pdoChaudoudoux->obtenirListeFamille();
                    include("vues/v_listeFamilles.php");
                    break;
    }
}
?>