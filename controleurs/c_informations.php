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
			if(lireDonneeUrl('type') == 'famille'){
				if(lireDonneeUrl(('registre') == 'nonArchive')){
					$lesFamilles=$pdoChaudoudoux->obtenirListeFamille();
				}
				else {
					$lesFamilles=$pdoChaudoudoux->obtenirListeFamilleArchive();
				}
			}

			//Récupérer les noms des colonnes constituant les tables intervenants et salarié
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
			 /* contient nom des colonnes formater avec C. pour les colonnes contenant le mot Candidats 
			 et I. pour les colonnes contenant Intervenants.*/
			$quoi = substr($quoi, 0, -2);

			
			/*Récupère la liste des intervenants placés et leurs informations correspondants 
			aux colonnes récupérer dans $quoi.*/
			$lesSalaries = array();
			
			if(lireDonneeUrl('type') == 'intervenant'){
				if(lireDonneeUrl('registre') == 'nonArchive'){
					$lesSalaries=$pdoChaudoudoux->obtenirListeSalariePlace($quoi);
				}
				else{
					$lesSalaries=$pdoChaudoudoux->obtenirListeSalarieArchiveTous($quoi);
				}
			}

			for ($i = 0; $i != count($lesSalaries); $i++) {
				$chezMAND = "";
				//récupère le numéro des familles associé aux intervenants mandataires
				$famillesMAND = $pdoChaudoudoux->obtenirFamilleActuelleMAND($lesSalaries[$i][37]);

				for ($o = 0; $o != count($famillesMAND); $o++) {
					//récupère le nom des familles associé aux intervenants mandataires
					$chezMAND = $chezMAND . $pdoChaudoudoux->obtenirNomFamille($famillesMAND[$o]['numero_Famille']) . " / ";
				}
				$chezPREST = "";
				//récupère le numéro des familles associé aux int prestataires
				$famillesPREST = $pdoChaudoudoux->obtenirFamilleActuellePREST($lesSalaries[$i][37]);

				for ($o = 0; $o != count($famillesPREST); $o++) {
					//récupère le nom des familles associé aux int prestataires 
					$chezPREST = $chezPREST . $pdoChaudoudoux->obtenirNomFamille($famillesPREST[$o]['numero_Famille']) . " / ";
				}
				/* ajoute dans les noms de colonnes de chaque Intervenants le nom des familles 
				dans lesquelles ils sont mandataire ou prestataire*/
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