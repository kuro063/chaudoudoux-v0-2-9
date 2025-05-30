<?php

include("vues/v_sommaire.php");
// vérification du droit d'accès au cas d'utilisation
if ( ! estConnecte() ) {
    ajouterErreur("L'accès à cette page requiert une authentification !", $tabErreurs);
    include('vues/v_erreurs.php');
}
else {
    $action = lireDonneeUrl('action', 'voirTousFact');
    switch($action){
        case 'voirTousFact':
                    $encaisse=false;
                    if (lireDonneeUrl('ordre')=='prelevement'){
                    $lesFactures=$pdoChaudoudoux->obtenirListeNonEncaisse();
                    }
                    else{
                    $lesFactures=$pdoChaudoudoux->obtenirListeNonEncaisse1();
                    $lesFacturesV=$pdoChaudoudoux->obtenirListeFactValid();
                    $lesFamilles=$pdoChaudoudoux->obtenirListeFamilleMand();
                    $archive=0;
                    $lesEntrees=$pdoChaudoudoux->FactEntree();
                    }
                    include("vues/v_listeFact.php");
                    break;
        case 'ajoutEntree':
                $num= lireDonneeUrl('num');
                $pdoChaudoudoux->ajoutEntree($num);
                $lesFactures=$pdoChaudoudoux->obtenirListeNonEncaisse1();
                    $lesFacturesV=$pdoChaudoudoux->obtenirListeFactValid();
                    $lesEntrees=$pdoChaudoudoux->FactEntree();
                include ("vues/v_listeFact.php");
                break;
        case 'validerMoisFact':
            $pdoChaudoudoux->validMoisFact();
            $lesFactures=$pdoChaudoudoux->obtenirListeNonEncaisse1();
                    $lesFacturesV=$pdoChaudoudoux->obtenirListeFactValid();
                    $lesEntrees=$pdoChaudoudoux->FactEntree();
                    include 'vues/v_listeFact.php';
                break;
        case 'voirTousEntree':
                    $lesEntrees=$pdoChaudoudoux->obtenirListeEntree();
                    include 'vues/v_entrees.php';
        case 'voirTousEncaisse':
                    $encaisse=true;
                    $lesFacturesEnc=$pdoChaudoudoux->obtenirListeEncaisse(date('Y'));
                    include("vues/v_listeFact.php");

                    break;
        case 'moisSuivant':
                    $pdoChaudoudoux->obtenirMoisSuivant();
                    $lesFactures=$pdoChaudoudoux->obtenirListeNonEncaisse();
                    include ('vues/v_listeFact.php');
                    break;
       case 'modifFact':
                    $encaisse=false;
                    $numAModif= lireDonneeUrl('num');
                    $lesFacturesEnc=$pdoChaudoudoux->obtenirListeEncaisse(date('Y'));
                    $lesFactures=$pdoChaudoudoux->obtenirListeNonEncaisse();
                    $lesTarifs=$pdoChaudoudoux->obtenirTarifs();
                    foreach ($lesFactures as $uneFacture)
                    {
                        if($numAModif==$uneFacture["idFact_Factures"])
                        {
                            $encFact=0;
                        }
                    
                    }
                    $num= lireDonneePost('num');
                    $laFacture=$pdoChaudoudoux->obtenirDetailFact($num);
                    $montant= $laFacture['montantFact_Factures'];
                    $montantEnc= $laFacture['montantEnc_Factures'];
                    $encFact=$laFacture['encaisse_Factures'];
                    $date=$laFacture['dateFact_Factures'];
                    $numFam=$laFacture['numero_Famille'];
                    $modePaiement=$laFacture['modePaiement_Factures'];
                    include('vues/v_listeFact.php');
                    break;
          
                    /*$lesFactures=$pdoChaudoudoux->obtenirListeNonEncaisse();
                    $lesFacturesEnc=$pdoChaudoudoux->obtenirListeEncaisse();
                    include("vues/v_listeFact.php"); 
                    break;*/
        case 'validFact':
                        $encaisse=false;
            $lesFactures=$pdoChaudoudoux->obtenirListeNonEncaisse();
            $lesFacturesEnc=$pdoChaudoudoux->obtenirListeEncaisse(date('Y'));
            $numAModif= lireDonneeUrl('num');
            $montantEnc = lireDonneePost('montantEncFact');
            $montant= lireDonneePost('montantFact');
            $num= lireDonneePost('numFam');
            $dateFact= lireDonneePost('dateFact');
            $encFact= lireDonneePost('encFact',0);
            $modePaiement= lireDonneePost('modePaiement');
            $pdoChaudoudoux->modifFact($numAModif,  $montant);
            $lesFactures=$pdoChaudoudoux->obtenirListeNonEncaisse();
            include ('vues/v_listeFact.php');
            break;
        case 'ajoutFact' :
                    $encaisse=false;
                    $lesFactures=$pdoChaudoudoux->obtenirListeNonEncaisse();
                    $lesFacturesEnc=$pdoChaudoudoux->obtenirListeEncaisse(date('Y'));
                    $lesTarifs=$pdoChaudoudoux->obtenirTarifs();

                    $lesFam=$pdoChaudoudoux->obtenirNomsFamille();
                    include("vues/v_listeFact.php");
                    break;
        case 'validAjoutFact' :
                    $encaisse=false;
                    $num= lireDonneePost('numFact');
                    $montant= lireDonneePost('montantFact');
                    $montantEnc= lireDonneePost('montantEncFact');
                    $encFact= lireDonneePost('encFact',0);
                    $date= lireDonneePost('dateFact');
                    $numFam= lireDonneePost('slctNomFam');
                    $modePaiement= lireDonneePost('modePaiement');
                    $pdoChaudoudoux->ajoutFact($num, $montant, $encFact,$montantEnc,$date,$numFam,$modePaiement);
                    ajouterErreur("Ajout effectué!", $tabErreurs);
                      include('vues/v_erreurs.php');
                    break;
        case 'suppFact' :
            $encaisse=false;
            $num= lireDonneeUrl('num');
            $pdoChaudoudoux->suppFact($num);
            ajouterErreur("Suppression effectuée", $tabErreurs);
            include('vues/v_erreurs.php');
            break;
        default :
            $encaisse=false;
            $lesFactures=$pdoChaudoudoux->obtenirListeNonEncaisse();
            $lesFacturesEnc=$pdoChaudoudoux->obtenirListeEncaisse(date('Y'));
            include("vues/v_listeFact.php");
            break;
}}