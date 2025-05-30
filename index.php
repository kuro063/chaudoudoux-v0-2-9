<?php

session_start();
require_once("include/fct.inc.php");
require_once ("include/class.pdoBdChaudoudoux.inc.php");
require_once ("include/matching.php");
require_once ("include/search.php");

include("vues/v_entete.php");
$tabErreurs = array();
//$user=obtenirNumConnecte();
$user='root';
if($user==null) {$user='root';}
$pdoChaudoudoux = new PdoBdChaudoudoux("localhost", "bdchaudoudoux", $user,"");
$matching = new Matching("localhost", "bdchaudoudoux", $user,"");
$searching = new Search("localhost", "bdchaudoudoux", $user,"");

$uc = lireDonneeUrl('uc', 'informations');


switch($uc) {
	case 'connexion':
		include("controleurs/c_connexion.php");break;
	
	case 'informations' :
		include("controleurs/c_informations.php");break; 

	case 'fichePerso' :
		include("controleurs/c_fichePerso.php");break;

    case 'formations' :
		include("controleurs/c_formations.php");break;
		
    case 'interventions' :
		include("controleurs/c_interventions.php");break;
		
    case 'admin' :
		include("controleurs/c_admin.php");break;
		
	case 'annuFamille' :
		include("controleurs/c_annuFamille.php");break;	
            
    case 'annuFact' :
		include("controleurs/c_annuFact.php");break;

	case 'annuSalarie' :
		include("controleurs/c_annuSalarie.php");break;

	case 'annuCandid' :
		include("controleurs/c_annuCandid.php");break;

	case 'search' :
		include("controleurs/c_search.php");break;

	case 'attribution' :
		include("controleurs/c_attribution.php");break;	
    
  	default :	
		include("controleurs/c_informations.php");break; 
}
include("vues/v_pied.php");


?>