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


        case 'voirTousInterv':
            $lesFam=$pdoChaudoudoux->obtenirNomsFamille();
            // $lesSal=$pdoChaudoudoux->obtenirListeSalarieSelect();
            $lesInterv=$pdoChaudoudoux->obtenirListeInterv(date('Y'));
            $i=0;
            foreach ($lesInterv as $uneInterv)
            {
            $lesnoms[]= array($i=>$pdoChaudoudoux->obtenirNomFamille($uneInterv['numero_Famille'])); 
            ++$i;
            }
            include ('vues/v_annuInterv.php');
            break;
        /*Modification des interventions d'un intervenant*/
        case 'modifInterv':
            $numSal=lireDonneeUrl('num');
            $numFam=lireDonneeUrl('numFam');
            $idADH=lireDonneeUrl('idADH');
            $idPresta=lireDonneeUrl('idPresta');
            $hDeb=lireDonneeUrl('hDeb');
            $freq=lireDonneeUrl('freq');
            $dateDeb=substr(lireDonneeUrl('dateDeb'),0,4).'-'. substr(lireDonneeUrl('dateDeb'),4,2).'-'. substr(lireDonneeUrl('dateDeb'), 6);
            $dateFin=substr(lireDonneeUrl('dateFin'),0,4).'-'. substr(lireDonneeUrl('dateFin'),4,2).'-'. substr(lireDonneeUrl('dateFin'), 6);
            $jour=lireDonneeUrl('jour');
            $hFin=lireDonneeUrl('hFin');
            $minDeb=substr($hDeb, 2,2);
            $hDeb=substr($hDeb, 0,2);
            $minFin=substr($hFin, 2,2);
            $hFin=substr($hFin, 0,2);
            // $lesSal=$pdoChaudoudoux->obtenirListeSalarieSelect();

            $lesFamilles=$pdoChaudoudoux->obtenirNomsFamille();
            /*$lesSal=$pdoChaudoudoux->obtenirListeSalarieSelect();
            $num= lireDonneeUrl('num');
            $lesInterv=$pdoChaudoudoux->obtenirListeIntervSal($num);
            $lesIntervPasse=$pdoChaudoudoux->obtenirListeIntervSalPasse($num);
            $i=0;
            foreach ($lesIntervPasse as $uneIntervPasse)
            {
            $lesnoms[]= array($i=>$pdoChaudoudoux->obtenirNomFamille($uneIntervPasse['numero_Famille'])); 
            ++$i;
            }
            $lesCreneaux=$pdoChaudoudoux->obtenirCreneaux($num);
            $lesFam=$pdoChaudoudoux->obtenirNbHeures($num);
                        $i=0;
            foreach ($lesInterv as $uneInterv)
            {
            $lesnoms[]= array($i=>$pdoChaudoudoux->obtenirNomFamille($uneInterv['numero_Famille'])); 
            ++$i;
            }*/

            $modalites = $pdoChaudoudoux->obtenirModalites($numFam, $numSal, $idADH, $idPresta, $hDeb.':'.$minDeb.':00',$dateDeb, $jour);

            if (isset($modalites)==FALSE) {
                $modalites = '';
            }

            include 'vues/v_modifInterv.php';
            break;

        case 'validerModifInterv':
            $numSalAncien=lireDonneePost('numSalAncien');/*ANCIEN num salarié*/ /*OK*/
            $idADHAncien=lireDonneePost('idADHAncien');/*ANCIEN adhésion*/ /*OK*/
            $hDebAncien=lireDonneePost('hDebAncien');/*ANCIEN heure de début*/ /*OK*/
            $dateDebAncien=lireDonneePost('dateDebAncien');/*ANCIEN date de début*/ /*OK*/
            $jourAncien=lireDonneePost('jourAncien');/*ANCIEN jour*/ /*OK*/

            $hFinAncien= lireDonneePost('hFinAncien');/*ANCIEN heure de fin*/ /*NO NEED*/
            $numFamAncien= lireDonneePost('numFamAncien');/*num famille*/ /*NO NEED*/

            $numSal= lireDonneePost('numSal');/*num salarié*/
            $numFam= lireDonneePost('famille');/*num famille*/
            $idADH= lireDonneePost('idADH');/*adhésion*/
            $modalites= lireDonneePost('modalites');/*modalités*/
            
            if ($numFam==9999){ 
                $idADH='DISP';
                $idPresta='DISP';}
            $hDeb=lireDonneePost('hDeb');/*heure de début*/
            $minDeb=lireDonneePost('minDeb');/*minute de début*/
            
            $hDeb=$hDeb.":".$minDeb.":00";/*prestation*/
            $jour=lireDonneePost('jour');/*prestation*/
            $hFin=lireDonneePost('hFin');/*prestation*/
            $minFin=lireDonneePost('minFin');/*prestation*/
            $hFin=$hFin.":".$minFin.":00";/*prestation*/

            $idPresta= lireDonneePost('idPresta');/*prestation*/
            $dateDeb=lireDonneePost('dateDeb');/*date de début*/
            $dateFin=lireDonneePost('dateFin');
            $freq=lireDonneePost('freq');  /* voir commentaire dans ModifIntervention()*/
            
            
            $pdoChaudoudoux->ModifIntervention($idPresta,$dateDeb,$numSalAncien,$idADHAncien,$dateDebAncien,$jourAncien,$hDebAncien,$numSal,$numFam,$idADH,$hDeb,$hFin,$jour,$dateFin,$modalites,$freq);

            $lesFamilles=$pdoChaudoudoux->obtenirNomsFamille();
            // $lesSal=$pdoChaudoudoux->obtenirListeSalarieSelect();
            $num=$numSal;
            $lesInterv=$pdoChaudoudoux->obtenirListeIntervSal($num);
            $lesIntervPasse=$pdoChaudoudoux->obtenirListeIntervSalPasse($num);
            $i=0;
            foreach ($lesIntervPasse as $uneIntervPasse)
            {
            $lesnoms[]= array($i=>$pdoChaudoudoux->obtenirNomFamille($uneIntervPasse['numero_Famille'])); 
            ++$i;
            }
            $lesCreneaux=$pdoChaudoudoux->obtenirCreneaux($num);
            $lesFam=$pdoChaudoudoux->obtenirNbHeures($num);
            $i=0;
            foreach ($lesInterv as $uneInterv)
            {
            $lesnoms[]= array($i=>$pdoChaudoudoux->obtenirNomFamille($uneInterv['numero_Famille'])); 
            ++$i;
            }
            include 'vues/v_annuInterv.php';
            break;
        case 'archiverIntervention':
            $lesFam=$pdoChaudoudoux->obtenirNomsFamille();
            // $lesSal=$pdoChaudoudoux->obtenirListeSalarieSelect();
            $numSal= lireDonneeUrl('num');
            $numFam= lireDonneeUrl('numFam');
            $hDeb= lireDonneeUrl('hDeb');
            $jour= lireDonneeUrl('jour');
            $hFin= lireDonneeUrl('hFin');
            $dateDeb= lireDonneeUrl('dateDeb');
            $idPresta= lireDonneeUrl('idPresta');
            $idADH= lireDonneeUrl('idADH');
            $pdoChaudoudoux->archiverIntervention($numSal, $numFam, $hDeb, $dateDeb, $idPresta,$idADH,$jour, $hFin);
            $lesFamilles=$pdoChaudoudoux->obtenirNomsFamille();
            // $lesSal=$pdoChaudoudoux->obtenirListeSalarieSelect();
            $num= lireDonneeUrl('num');
            $lesInterv=$pdoChaudoudoux->obtenirListeIntervSal($num);
            $lesIntervPasse=$pdoChaudoudoux->obtenirListeIntervSalPasse($num);
                        $i=0;
            foreach ($lesIntervPasse as $uneIntervPasse)
            {
            $lesnoms[]= array($i=>$pdoChaudoudoux->obtenirNomFamille($uneIntervPasse['numero_Famille'])); 
            ++$i;
            }
            $lesCreneaux=$pdoChaudoudoux->obtenirCreneaux($numSal);
            $lesFam=$pdoChaudoudoux->obtenirNbHeures($num);
                        $i=0;
            foreach ($lesInterv as $uneInterv)
            {
            $lesnoms[]= array($i=>$pdoChaudoudoux->obtenirNomFamille($uneInterv['numero_Famille'])); 
            ++$i;
            }
            include 'vues/v_annuInterv.php';
               break;
         case 'voirAncienInterv':
              $encaisse=true;
              $an= lireDonneePost('an');
              $lesInterv=$pdoChaudoudoux->uneIntervPasse($an);
              
            $i=0;
            foreach ($lesInterv as $uneInterv)
            {
            $lesnoms[]= array($i=>$pdoChaudoudoux->obtenirNomFamille($uneInterv['numero_Famille'])); 
            ++$i;
            }
            include ('vues/v_annuInterv.php');

              break;
              case 'supprimerDispoInterv':
                $numDispo=lireDonneeUrl('numDispo');
                $pdoChaudoudoux->suppDispoInterv($numDispo);
                ajouterErreur("Disponibilité supprimée !", $tabErreurs);
                include('vues/v_erreurs.php');

                break;
        case 'voirDetailIntervSalarie':
            $lesFamilles=$pdoChaudoudoux->obtenirNomsFamille();
            // $lesSal=$pdoChaudoudoux->obtenirListeSalarieSelect();
            $num=lireDonneeUrl('num');
            $lesInterv=$pdoChaudoudoux->obtenirListeIntervSal($num);
            $lesIntervPasse=$pdoChaudoudoux->obtenirListeIntervSalPasse($num);
            $i=0;
            foreach ($lesIntervPasse as $uneIntervPasse)
            {
            $lesnoms[]= array($i=>$pdoChaudoudoux->obtenirNomFamille($uneIntervPasse['numero_Famille'])); 
            ++$i;
            }
            $lesCreneaux=$pdoChaudoudoux->obtenirCreneaux($num);
            $lesFam=$pdoChaudoudoux->obtenirNbHeures($num);
                        $i=0;
            foreach ($lesInterv as $uneInterv)
            {
            $lesnoms[]= array($i=>$pdoChaudoudoux->obtenirNomFamille($uneInterv['numero_Famille'])); 
            ++$i;
            }
            include 'vues/v_annuInterv.php';
            break;
        case 'voirDetailIntervFam':
            $num= lireDonneeUrl('num');
            $lesInterv=$pdoChaudoudoux->obtenirListeIntervFam($num);
            $lesIntervPasse=$pdoChaudoudoux->obtenirListeIntervFamPasse($num);
            include 'vues/v_annuInterv.php';
            break;
        case 'invalid':
            $lesInterv=$pdoChaudoudoux->obtenirListeIntervInvalid();
            $i=0;
            foreach ($lesInterv as $uneInterv)
            {
            $lesnoms[]= array($i=>$pdoChaudoudoux->obtenirNomFamille($uneInterv['numero_Famille'])); 
            ++$i;
            }
            include 'vues/v_annuInterv.php';
            break;
        case 'validInterv':
            $validFam= lireDonneePost('validFam',0);
            $validInterv= lireDonneePost('validInterv',0);
            $statut= lireDonneePost('statut','Non effectué');
            $res= lireDonneePost('slctInterv');
            $idPresta= substr($res, 0, strpos($res,"/"));
            $numSal= substr($res, strpos($res,"/")+1, strpos($res,";")-strpos($res,"/")-1);
            $numFam= substr($res,strpos($res,";")+1, strpos($res,"^")-strpos($res,";")-1);
            $idADH=substr($res,strpos($res,"^")+1, strpos($res, "$")-strpos($res,"^")-1);
            $jour= substr($res,strpos($res, "$")+1, strpos($res,"+")-strpos($res,"$")-1);
            $hDeb= substr($res, strpos($res, "+")+1);
            $pdoChaudoudoux->validInterv($validFam,$validInterv, $statut, $idPresta, $numSal, $numFam, $idADH, $jour, $hDeb);
            $lesInterv=$pdoChaudoudoux->obtenirListeInterv(date('Y'));
                        $i=0;
            foreach ($lesInterv as $uneInterv)
            {
            $lesnoms[]= array($i=>$pdoChaudoudoux->obtenirNomFamille($uneInterv['numero_Famille'])); 
            ++$i;
            }
            include 'vues/v_annuInterv.php';
            break;
        default : 
                  include 'vues/v_annuInterv.php';
    }
}