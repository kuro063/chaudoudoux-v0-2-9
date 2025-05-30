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

			//liste salariés
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
				array_push($lesSalaries[$i], $chezMAND);
				array_push($lesSalaries[$i], $chezPREST);                 
      }
			include("vues/v_exportContact.php");
			break;

        default :
		include("vues/v_accueil.php");
		break;	
}
?>