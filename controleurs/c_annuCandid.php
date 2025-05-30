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
    $action = lireDonneeUrl('action', 'voirTousCandid');
    switch($action){
        case 'voirTousCandid':
                    $lesCandidats=$pdoChaudoudoux->obtenirListeCandidat();
                    $archive = 0;
                    include("vues/v_listeCandid.php");
                    break;         
               case 'voirTousCandidRefuse':
                    $archive=1;
                    $lesCandidats=$pdoChaudoudoux->obtenirListeCandidatRef();
                    include("vues/v_listeCandid.php");
                    break;         
       
        case 'voirDetailCandid':
                    $issalarie=false;
                    $num = lireDonneeUrl('num'); 
                    if ( empty($num) || !estEntierPositif($num) ) {
                        ajouterErreur("La personne est inexistante.", $tabErreurs);
                        include('vues/v_erreurs.php');                       
                    }
                    else {
                        $candidat=$pdoChaudoudoux->obtenirDetailCandidat($num);
                        $titre = $candidat['titre_Candidats'];
                        $nom = $candidat['nom_Candidats'];
                        $prenom = $candidat['prenom_Candidats'];
                        $dateNaiss = $candidat['dateNaiss_Candidats'];
                        $lieuNaiss = $candidat['lieuNaiss_Candidats'];
                        $paysNaiss = $candidat['paysNaiss_Candidats'];
                        $dateEnt=$candidat['dateEntretien_Candidats'];
                        $natio = $candidat['nationalite_Candidats'];                        
                        $numTS = $candidat['numTitreSejour'];
                        $mutuelle=$candidat['Mutuelle_Candidats'];
                        $nomJF=$candidat['nomJF_Candidats'];
                        $cmu= $candidat['CMU_Candidats'];
                        $quartier=$candidat['Quartier_Candidats'];
                        $trav= $candidat['travailVoulu_Candidats'];
                        $observ=$candidat['observations_Candidats'];
                        $adresse = $candidat['adresse_Candidats'];
                        $cp = $candidat['cp_Candidats'];
                        $ville = $candidat['ville_Candidats'];
                        $telPort = $candidat['telPortable_Candidats'];
                        $telFixe = $candidat['telFixe_Candidats'];
                        $telUrg = $candidat['TelUrg_Candidats'];
                        $email = $candidat['email_Candidats'];
                        $numSS = $candidat['numSS_Candidats'];
                        $permis = $candidat['permis_Candidats'];
                        $vehicule = $candidat['vehicule_Candidats'];
                        $statutPro = $candidat['statutPro_Candidats'];
                        $sitFam = $candidat['situationFamiliale_Candidats'];
                        $diplomes = $candidat['diplomes_Candidats'];
                        $qualifs = $candidat['qualifications_Candidats'];
                        $expBBmoins1a = $candidat['expBBmoins1a_Candidats'];
                        $enfantHand = $candidat['enfantHand_Candidats'];
                        $dispo = $candidat['disponibilites_Candidats'];
                        include("vues/v_detailCandidat.php");                       
                    }
                    break;
        case 'ajouterCandid' :
                    include("vues/v_ajouterCandid.php");
                    break;
        case 'validerAjoutCandid' :
                        $titre = lireDonneePost('slctTitre');
                        $nom = lireDonneePost('txtNom');
                        $prenom = lireDonneePost('txtPrenom');
                        $trav = lireDonneePost('travailVoulu');
                        $dateNaiss = lireDonneePost('dateNaiss');
                        $lieuNaiss = lireDonneePost('txtLieuNaiss');
                        $paysNaiss = lireDonneePost('txtPaysNaiss');
                        $natio = lireDonneePost('txtNatio');
                        $numTS = lireDonneePost('txtTS');
                        $adresse = lireDonneePost('txtAdr');
                        $cp = lireDonneePost('txtCp');
                        $cmu= lireDonneePost('chkCMU',0);
                        $mutuelle= lireDonneePost('txtMutuelle');
                        $observ = lireDonneePost('txtObs');
                        $nomJF= lireDonneePost('nomJF');
                        $ville = lireDonneePost('txtVille');
                        $quartier = lireDonneePost('txtQuart');
                        $telPort = lireDonneePost('txtPort');
                        $telFixe = lireDonneePost('txtFixe');
                        $telUrg = lireDonneePost('txtUrg');
                        $email = lireDonneePost('txtEmail');
                        $numSS = lireDonneePost('txtNumSS');
                        $permis = lireDonneePost('chkPermis',0);
                        $vehicule = lireDonneePost('chkVehicule',0);
                        $statutPro = lireDonneePost('slctStatPro');
                        $sitFam = lireDonneePost('slctSitFam');
                        $diplomes = lireDonneePost('txtDip');
                        $qualifs = lireDonneePost('txtQualifs');
                        $expBBmoins1a = lireDonneePost('chkExp1a',0);
                        $enfantHand = lireDonneePost('chkEnfHand',0);
                        $dispo = lireDonneePost('txtDispo');
                        $secteurCandidat = lireDonneePost('slctSecteur');
                        
                        //On vérifie si l'utilisateur n'existe pas déjà 
                        $isDublicated = $pdoChaudoudoux-> VerifDubli($nom, $dateNaiss);
                        $notDublicated = false;
                        if ($isDublicated==null || $isDublicated==""){
                            $notDublicated=true;
                        }
                        
                        //On créer d'abord le candidat pour qu'il est un numero d'intervenant
                        $pdoChaudoudoux->ajouterCandid($cmu, $mutuelle, $observ,$titre, $nom, $prenom, $dateNaiss, $lieuNaiss, $paysNaiss, $natio, $numTS, $adresse, $cp,   $ville, $quartier, $telPort, $telFixe, $telUrg, $email, $numSS, $permis, $vehicule, $statutPro, $sitFam, $diplomes, $qualifs, $expBBmoins1a, $enfantHand, $dispo,$trav, $nomJF, $secteurCandidat);    
                        $numCand = $pdoChaudoudoux->obtenirNumCandidat($nom, $prenom);

                        //SI pas dubliqué
                        if($notDublicated){
                            //Message d'ajout normal
                            ajouterErreur("Candidat ajouté !", $tabErreurs);
                        }
                        //SI dubliqué
                        else{
                            //Message d'avertissement de dublication
                            ajouterErreur("Candidat ajouté ! <br/> Un candidat similaire à été trouvé !", $tabErreurs);    
                        }
                       
                        include('vues/v_erreurs.php');
                        break;
        case 'demanderModifCandid' :
                    $num = lireDonneeUrl('num'); 
                    $candidat=$pdoChaudoudoux->obtenirDetailCandidat($num);
                        $titre = $candidat['titre_Candidats'];
                        $nom = $candidat['nom_Candidats'];
                        $prenom = $candidat['prenom_Candidats'];
                        $dateNaiss = $candidat['dateNaiss_Candidats'];
                        $mutuelle=$candidat['Mutuelle_Candidats'];
                        $observ=$candidat['observations_Candidats'];
                        $lieuNaiss = $candidat['lieuNaiss_Candidats'];
                        $paysNaiss = $candidat['paysNaiss_Candidats'];
                        $natio = $candidat['nationalite_Candidats'];
                        $numTS = $candidat['numTitreSejour'];
                        $nomJF=$candidat['nomJF_Candidats'];
                        $adresse = $candidat['adresse_Candidats'];
                        $cmu=$candidat['CMU_Candidats'];
                        $cp = $candidat['cp_Candidats'];
                        $ville = $candidat['ville_Candidats'];
                        $quartier = $candidat['Quartier_Candidats'];
                        $telPort = $candidat['telPortable_Candidats'];
                        $telFixe = $candidat['telFixe_Candidats'];
                        $telUrg = $candidat['TelUrg_Candidats'];
                        $email = $candidat['email_Candidats'];
                        $numSS = $candidat['numSS_Candidats'];
                        $permis = $candidat['permis_Candidats'];
                        $vehicule = $candidat['vehicule_Candidats'];
                        $statutPro = $candidat['statutPro_Candidats'];
                        $sitFam = $candidat['situationFamiliale_Candidats'];
                        $diplomes = $candidat['diplomes_Candidats'];
                        $qualifs = $candidat['qualifications_Candidats'];
                        $expBBmoins1a = $candidat['expBBmoins1a_Candidats'];
                        $enfantHand = $candidat['enfantHand_Candidats'];
                        $dispo = $candidat['disponibilites_Candidats'];
                        $trav= $candidat['travailVoulu_Candidats'];
                        $dateTS = $candidat['dateTitreSejour'];
                        $statutHandicap = $candidat['statutHandicap_Candidats'];
                        $secteurCandidat = $candidat['secteur_Candidats'];
                        $issalarie=false;

                        
                    include("vues/v_modifFicheCandid.php");
                    break;
        case 'validerModifCandid' :
            //var_dump($_POST);
            $issalarie=false;
            $num = lireDonneeUrl('num'); 
            $candidatAncien=$pdoChaudoudoux->obtenirDetailCandidat($num);
            $nomAncien= $candidatAncien['nom_Candidats'];
            $prenomAncien = $candidatAncien['prenom_Candidats'];
            $telPortAncien = $candidatAncien['telPortable_Candidats'];
            $titre = lireDonneePost('slctTitre');
            $nom = lireDonneePost('txtNom');
            $prenom = lireDonneePost('txtPrenom');
            $nomJF= lireDonneePost('nomJF');
            $dateNaiss = lireDonneePost('dateNaiss');
            $lieuNaiss = lireDonneePost('txtLieuNaiss');


            //L'activité est vide pâr défaut, elle sera définie après
            $activite="";
            //Variable qui définit si une disponibilité est à la fois en GE et en Ménage
            $doubleType = false;
            
            $dispoInconnue = lireDonneePost('chkDispoInconnue', 0);
            $dispoM=$pdoChaudoudoux->ObtenirDispoCandidMenage($num);
            $dispoGE=$pdoChaudoudoux->ObtenirDispoCandidGE($num);
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
                    $pdoChaudoudoux->ajoutDispoCandidat($num, $jour, $heureDeb,$heureFin, $activite,$frequence);
                    $activite="menage";
                    $pdoChaudoudoux->ajoutDispoCandidat($num, $jour, $heureDeb,$heureFin, $activite,$frequence);
                }
            }

            //On vérifie si un type de disponibilité est saisie (GE, ménage ou les 2)
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
                    $pdoChaudoudoux->ajoutDispoCandidat($num, $jour, $heureDeb,$heureFin, $activite,$frequence);
                    if($doubleType){
                        //Etant donné que la condition du double type est true, on avais renseigné que l'activité était ménage
                        //De ce fait, pour la 2eme requête, on met de la GE
                        $activite2 = "garde d'enfants";
                        $pdoChaudoudoux->ajoutDispoCandidat($num, $jour, $heureDeb,$heureFin, $activite2,$frequence);
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
                    $pdoChaudoudoux->ajoutDispoCandidat($num, $jour, $heureDeb,$heureFin, $activite,$frequence);
                    if($doubleType){
                        $activite2 = "garde d'enfants";
                        $pdoChaudoudoux->ajoutDispoCandidat($num, $jour, $heureDeb,$heureFin, $activite2,$frequence);
                    }
                    }
                }
            }
                        $chkArchive= lireDonneePost('chkArchive');
                        
                        $paysNaiss = lireDonneePost('txtPaysNaiss');
                        $natio = lireDonneePost('txtNatio');
                        $numTS = lireDonneePost('txtTS');
                        $adresse = lireDonneePost('txtAdr');
                        $mutuelle = lireDonneePost('txtMutuelle');
                        $observ = lireDonneePost('txtObs');
                        $cmu= lireDonneePost('chkCMU',0);
                        $cp = lireDonneePost('txtCp');
                        $ville = lireDonneePost('txtVille');
                        $quartier = lireDonneePost('txtQuart');
                        $telPort = lireDonneePost('txtPort');
                        $telFixe = lireDonneePost('txtFixe');
                        $telUrg = lireDonneePost('txtUrg');
                        $email = lireDonneePost('txtEmail');
                        $numSS = lireDonneePost('txtNumSS');
                        $permis = lireDonneePost('chkPermis',0);
                        $vehicule = lireDonneePost('chkVehicule',0);
                        $statutPro = lireDonneePost('slctStatPro');
                        $sitFam = lireDonneePost('slctSitFam');
                        $diplomes = lireDonneePost('txtDip');
                        $qualifs = lireDonneePost('txtQualifs');
                        $expBBmoins1a = lireDonneePost('chkExp1a',0);
                        $enfantHand = lireDonneePost('chkEnfHand',0);
                        $dispo = lireDonneePost('txtDispo');
                        $trav = lireDonneePost('travailVoulu');
                        $dateTS = lireDonneePost('dateTS');
                        $secteurCandidat = lireDonneePost('slctSecteur');
                        
                        $categorie = "famille";
                        $num = lireDonneeUrl('num');
                        //$dispoInconnue = $_POST['dispoInconnue'];
                        
                      /*  if ($nom!=$nomAncien||$prenom!=$prenomAncien||$telPort!=$telPortAncien){
                        rename('Documents/Candidats_intervenants/'.$nomAncien.' '.$prenomAncien.' '.$telPortAncien, 'Documents/Candidats_intervenants/'.$nom.' '.$prenom.' '.$telPort);}
                        foreach ($_FILES as $unfichier)
                        {
                            $resultat = move_uploaded_file($unfichier['tmp_name'], 'Documents/Candidats_intervenants/'.$nom.' '.$prenom.' '.$telPort.'/Autres_Documents');}*/
                        
                        $pdoChaudoudoux->modifierCandid($num, $titre, $nom, $prenom, $dateNaiss, $lieuNaiss, $paysNaiss, $natio, $numTS, $adresse, $cp, $ville, $quartier, $telPort, $telFixe, $telUrg, $email, $numSS, $permis, $vehicule, $statutPro, $sitFam, $diplomes, $qualifs, $expBBmoins1a, $enfantHand, $dispo, $cmu, $observ, $mutuelle, $nomJF, $dateTS, $secteurCandidat);
                        $pdoChaudoudoux->updateEchecCandidat($num, $cmu, $mutuelle, $observ,$trav);
                        
                        
                        include("vues/v_detailCandidat.php");   
                        break;
        case 'decisionCandid' :

                    $num = lireDonneeUrl('num');
                    $candidat=$pdoChaudoudoux->obtenirDetailCandidat($num);
                    $dispo = $candidat['disponibilites_Candidats'];
                    include("vues/v_decisionCandid.php");
                    break;
        case 'validerDecisionCandid' :
            //var_dump($_POST);
                    $num = lireDonneeUrl('num');
                    $decision = lireDonneePost('btnDecision');
                    $idSalarie = lireDonneePost('idSalarie');
                    $dateSortie= lireDonneePost('dateSortie');
                    $archive= lireDonneePost('chkArchive',0);
                    $certif= lireDonneePost('txtCertif');
                    $rechCompl= lireDonneePost('chkComplH');
                    $psc1= lireDonneePost('chkPSC1');
                    $justifs= lireDonneePost('justif');
                    $tauxH= lireDonneePost('tauxH');
                    $nbH= lireDonneePost('nbH');
                    $trav= lireDonneePost('travailVoulu');
                    $enfHand= lireDonneePost('enfHand');
                    $BB= lireDonneePost("BBmoins3a");
                    $dispo= lireDonneePost('dispo');
                    $raison = lireDonneePost('txtRaison', "");
                    $presta = lireDonneePost('slctPresta', NULL);
                    $dateEntree = date('Y-m-d H:i:s');
                    $repassage=lireDonneePost('repassage');

                    $VerifNumInterv = $pdoChaudoudoux->existeCandidat($num);
                    $numExiste = false;
                    if(!$VerifNumInterv==null || !$VerifNumInterv==""){
                        $numExiste = true;
                    }
                    
                    if ($decision=='non')
                    {
                        $pdoChaudoudoux->candidatRefuse($num, $raison);
                        $pdoChaudoudoux->supprimerToutDispoCandidat($num);
                    }
                    else
                    {
                        if (!$numExiste){
                            $pdoChaudoudoux->nouveauSalarie($num, $idSalarie, $dateEntree, $dateSortie, $archive, $rechCompl, $certif, $tauxH, $psc1, $justifs,$repassage);
                            $raison="Accepté";
                            $pdoChaudoudoux->updateNvSal($num, $nbH, $trav, $enfHand, $dispo, $BB);
                            $pdoChaudoudoux->UpdateDispoIntervenantCandidat($num);
                        }
                        
                    }
                    if (lireDonneePost('chkemail')==true)
                    {
                     $message_txt= lireDonneePost('txtemail');

                     

                    // $mail=$pdoChaudoudoux->trouverMail($num);
                     /*if (isset($mail))
                     {
                     $mail="edouard.peyrot1@gmail.com";    
//=========
if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui présentent des bogues.
{
	$passage_ligne = "\r\n";
}
else
{
	$passage_ligne = "\n";
}
//==========
//=====Création de la boundary.
$boundary = "-----=".md5(rand());
$boundary_alt = "-----=".md5(rand());
//==========
 
//=====Définition du sujet.
$sujet = "Suite à votre candidature à la maison des chaudoudoux";
//=========
 
   //=====Création du header de l'e-mail
$header = "From: \"La maison des chaudoudoux\"<edouard.peyrot@orange.fr>".$passage_ligne;
$header = "Reply-to: \"La maison des chaudoudoux\" <edouard.peyrot@orange.fr>".$passage_ligne;
$header .= "MIME-Version: 1.0".$passage_ligne;
$header .= "X-Priority: 5".$passage_ligne;
$header .= "Content-Type: text/plain;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
 
//=====Création du message.
$message = $passage_ligne."--".$boundary.$passage_ligne;
$message.= "Content-Type: text/plain;".$passage_ligne." boundary=\"$boundary_alt\"".$passage_ligne;
$message.= $passage_ligne."--".$boundary_alt.$passage_ligne;
//=====Ajout du message au format texte.
$message.= "Content-Type: text/plain; charset=\"ISO-8859-1\"".$passage_ligne;
$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
$message.= $passage_ligne.$message_txt.$passage_ligne.$sign.$passage_ligne;
//==========
 
//=====On ferme la boundary alternative.
$message.= $passage_ligne."--".$boundary_alt."--".$passage_ligne;
//==========
 
 
 
$message.= $passage_ligne."--".$boundary.$passage_ligne;
 
//=====Envoi de l'e-mail.
mail($mail,$sujet,$message,$header);
 
//==========
                     }*/
                    }
                
                    //("index.php?uc=annuCandid&action=voirTousCandid");
                    if($numExiste){
                        ajouterErreur("Le candidat existe déjà", $tabErreurs);
                        include('vues/v_erreurs.php');
                    }
                    else{
                        ajouterErreur("Les modifications ont bien été prises en compte", $tabErreurs);
                        include('vues/v_erreurs.php');
                    }
                
                    break;          
        default:
                    $lesCandidats=$pdoChaudoudoux->obtenirListeCandidat();
                    include("vues/v_listeCandid.php");
                    break;
    }
    
}

