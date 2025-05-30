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
else  { // accès autorisé
      // est-on au 1er appel du programme ou non ?
      $action=lireDonneeUrl('action','demanderModif');
      $messageinfo = "";
      // on récupère le numéro de la personne connectée 
      $login = obtenirNumConnecte();
      // on récupère de la base certaines données qui ne peuvent être changées par l'étudiant
      $user = $pdoChaudoudoux->obtenirMdpUser($login);
      $mdpActu = $user['mdp_sha1'];
      
      switch ($action) {
          case 'demanderModif' : // on est au 1er appel, les données sont initialisées
                                 // à "chaîne vide"
                  $newMdp = "";
                  $confNewMdp = "";
                  break;
      
          case 'validerModif' : // l'utilisateur valide ses nouvelles données,
                                    // les données sont renseignées à partir du formulaire
                  $mdpSaisi = lireDonneePost("txtMdp");
                  $newMdp = lireDonneePost("txtNMdp");
                  $confNewMdp = lireDonneePost("confNMdp");
                  // elles doivent être vérifiées, puis enregistrées si ok
                  if ($mdpActu == sha1($mdpSaisi) ) {
                    if($newMdp == $confNewMdp){
                      $res = $pdoChaudoudoux->modifierMDP($newMdp, $login);
                      $messageInfo = ($res) ? "Votre mot de passe a bien été modifié" : "Une erreur est survenue. Veuillez recommencer";
                    }
                  }
                  break;                                  
      }
      include('vues/v_modifFichePerso.php');
  }
?>
