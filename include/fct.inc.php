<?php
/** 
 * Fonctions pour l'application exetud
 * @package default
 * @author Cheri Bibi
 * @version    1.0
 */
 /**
 * Teste si un quelconque visiteur est connecté
 * @return vrai ou faux 
*/

function dateToString($date)
{
            $an= substr($date, 0,4);
            $mois= substr($date, 5,2);
            $jourdate= substr($date, 8,2);
            $date=$jourdate.'/'.$mois.'/'.$an;
            
            return $date;
}
function estConnecte(){
  return isset($_SESSION['num']);
}
/**
 * Retourne le nom de la personnes connectée, false si pas de connexion.
 * @return mixed string or boolean
 */
function obtenirNomConnecte(){
  $data = false;
  if ( estConnecte() ) {
    $data = $_SESSION['nom'];
  }
  return $data;
}
/**
 * Retourne le prénom de la personnes connectée, false si pas de connexion.
 * @return mixed string or boolean
 */
function obtenirPrenomConnecte(){
  $data = false;
  if ( estConnecte() ) {
    $data = $_SESSION['prenom'];
  }
  return $data;
}
/**
 * Retourne le numéro de la personne connectée, false si pas de connexion.
 * @return mixed string or boolean
 */
function obtenirNumConnecte(){
  $data = false;
  if ( estConnecte() ) {
    $data = $_SESSION['id'];
  }
  return $data;
}
/**
 * Enregistre dans une variable session les infos d'un visiteur
 * @param $num
 * @param $nom
 * @param $prenom
 */
function connecter($num,$nom,$prenom){
  if(isset($nom) && isset($num) && isset($prenom)){
	$_SESSION['num']= $num; 
	$_SESSION['nom']= $nom;
	$_SESSION['prenom']= $prenom;}
  
}
/**
 * Détruit la session active
 */
 function deconnecter(){
	unset($_SESSION['num']); 
	unset($_SESSION['nom']);
	unset($_SESSION['prenom']);
	session_destroy();
}
/* gestion des erreurs*/
/**
 * Indique si une valeur est un entier positif ou nul
 * @param $valeur
 * @return vrai ou faux
*/
function estEntierPositif($valeur) {
	return preg_match("/[^0-9]/", $valeur) == 0;	
}
/** 
 *  Renvoie la chaîne $str avec les caractères considérés spéciaux en HTML
 *  transformés en entités HTML, ceci pour éviter que des données fournies 
 *  par les utilisateurs ne contiennent des balises HTML
*/    
function filtreChainePourNavig($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
/** 
 * Retourne le nombre de données reçues par l'url                    
 * 
 * @return integer nombre de données reçues par l'url
 */ 
  function donnerNbDonneesUrl() {
    return count($_GET);
  }
/** 
 * Fournit la valeur d'une donnée transmise par la méthode get (url).                    
 * 
 * Retourne la valeur de la donnée portant le nom $nomDonnee reçue dans l'url, 
 * $valDefaut si aucune donnée de nom $nomDonnee dans l'url 
 * @param string nom de la donnée
 * @param string valeur par défaut 
 * @return string valeur de la donnée
 */ 
// retrait de $valDefaut="" car n'est pas utile car on redefini $val dans le else
function lireDonneeUrl($nomDonnee) {
    if ( isset($_GET[$nomDonnee]) ) {
        $val = $_GET[$nomDonnee];
    }
    else {
        $val = "";
    }
    return $val;
}
/** 
 * Retourne le nombre de données reçues par la méthode post              
 * (dans le corps de la requête http)      
 * @return integer nombre de données reçues
 */ 
  function donnerNbDonneesPost() {
    return count($_POST);
  }
/** 
 * Fournit la valeur d'une donnée transmise par la méthode post 
 *  (corps de la requête HTTP).                    
 * 
 * Retourne la valeur de la donnée portant le nom $nomDonnee reçue dans le corps de la requête http, 
 * $valDefaut si aucune donnée de nom $nomDonnee dans le corps de requête
 * @param string nom de la donnée
 * @param string valeur par défaut 
 * @return string valeur de la donnée
 * 
 */ 
// A NE PAS REFACTORISER
function lireDonneePost($nomDonnee, $valDefaut="") {
  if ( isset($_POST[$nomDonnee]) ) {
      $val = $_POST[$nomDonnee];
  }
  else {
      $val = $valDefaut;
  }
  return $val;
}
/**
 * Retourne true si $valeur respecte le format d'un code postal, 5 chiffres.
 * @param string $valeur
 * @return boolean 
 */
function estCodePostal($valeur) {
   return strlen($valeur) == 5 && estEntierPositif($valeur);
}
/*
 * Contrôle la validité du numéro de téléphone
 * @param type $valeur
 * return boolean
 */
function estNumTel($valeur) {
    return strlen($valeur) == 10 && estEntierPositif($valeur);
}
/**
 * Contrôle les données de l'étudiant
 * @param type $numEtud
 * @param type $adr
 * @param type $cp
 * @param type $ville
 * @param type $tel
 * @param type $etudSup
 * @param type $confid
 * @param type $tabErr
 * @return boolean contrôle réussi ou non
 */
function verifierDonneesPersoEtudiant($numEtud, $adr, $cp, $ville, $tel, $etudSup, $comm, $confid, &$tabErr) {
    $ok = true;
    if ( $cp != "" && !estCodePostal($cp) ) {
        ajouterErreur("Code postal invalide", $tabErr);
        $ok = false;
    }  
    if ( $tel != "" && !estNumTel($tel) ) {
        ajouterErreur("Téléphone invalide", $tabErr);
        $ok = false;
    } 
    return $ok;
}
/**
 * Ajoute le libellé d'une erreur au tableau des erreurs $tabErr
 * @param string $msg : le libellé de l'erreur 
 * @param array $tabErr tableau des messages d'erreur passé par référence
 */
function ajouterErreur($msg, &$tabErr){
   $tabErr[]=$msg;
}
function ckJour($jour){
    switch ($jour){
        case 'lundi': return 1; break;
        case 'mardi': return 2; break;
        case 'mercredi': return 3; break;
        case 'jeudi': return 4; break;
        case 'vendredi': return 5; break;
        case 'samedi': return 6; break;
        case 'dimanche': return 7; break;
    }
}
/**
 * Retoune le nombre de lignes du tableau des erreurs $tabErr
 * @param string $msg : le libellé de l'erreur 
 * @return le nombre d'erreurs
 */
function nbErreurs($tabErr){
   return count($tabErr);
}
/**
 * Retourne les messages d'erreurs sous forme de liste à puces html
 * @param array $tabErr tableau des messages d'erreur
 * @return string texte html
 */
function toHtmlErreurs($tabErr){
    $res='<ul class="msgErreur">';
    foreach($tabErr as $erreur) {
        $res.="<li>".$erreur."</li>";
    }
    $res .="</ul>";
    return $res;
}
function decouperCodes($codeCliFamille) {
  $codeCli = substr($codeCliFamille, 0, strpos($codeCliFamille, "/"));
  return $codeCli;
}
function decouperNomPrenom($value) {
  $identite = array ("", "");
  $identite[1] = substr($value, 0, strpos($value, " "));
  $identite[2] = substr($value, strpos($value, " ")+1);
  return $identite;
}
?>