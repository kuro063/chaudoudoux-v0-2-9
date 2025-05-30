<?php
/* La directive @var permet de déclarer une variable créée dans un script séparé 
 * du présent script, et ainsi de bénéficier de l'auto-complétion sur cette variable
 */
/* @var $pdoExetud PdoExetud */
/* @var $tabErreurs array */
include("vues/v_sommaire.php");
$action = lireDonneeUrl('action', 'voirAccueil');
switch($action) {
	case 'voirAccueil':
		include("vues/v_accueil.php");
		break;

		case 'exportIntro':
			include("vues/v_exportIntro.php");
			break;

		case 'exportContact':
			$lesFamilles=$pdoChaudoudoux->obtenirListeFamille();
			include("vues/v_exportContact.php");
			break;

        default :
		include("vues/v_accueil.php");
		break;	
}
?>