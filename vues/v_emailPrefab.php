<?php 
//Accès à l'email depuis la fiche de la famille
if(lireDonneeUrl("action")=="voirEmailPrefabF"){
    ?>
    <h2> Création d'un email pour la famille </h2> <br/>
    <?php 
    ?>
    <h4> En ménage :</h4>
    <form method='post' action='index.php?uc=annuFamille&action=creationEmailPrefabMenage&num=<?php echo $numFamille ?>'>
        <label for="intervenant"><strong>Choix de l'intervenant : </strong></label>
        <input name="intervenant" list="intervenant">
        <datalist id="intervenant">
            <option value="" selected>Intervenant</option>
            <?php foreach($lesSalaries as $unSalarie){
                $numSalarie = $unSalarie["numSalarie_Intervenants"];
                $titreSalarie = $unSalarie["titre_Candidats"];
                $nomSalarie = $unSalarie["nom_Candidats"];
                $prenomSalarie = $unSalarie["prenom_Candidats"];

                echo("<option value='$numSalarie'> $nomSalarie $prenomSalarie </option>");
            }
        ?>
        </datalist>
        <input class="btn btn-secondary display-4" type="submit" style="left:0px;width:13%;font-size:1em"/>
    </form>
    <?php

    ?>
    <h4> En garde d'enfants :</h4>
    <form method='post' action='index.php?uc=annuFamille&action=creationEmailPrefabGE&num=<?php echo $numFamille ?>'>
        <label for="intervenant"><strong>Choix de l'intervenant : </strong></label>
        <input name="intervenant" list="intervenant">
        <datalist id="intervenant">
            <option value="" selected>Intervenant</option>
            <?php foreach($lesSalaries as $unSalarie){
                $numSalarie = $unSalarie["numSalarie_Intervenants"];
                $titreSalarie = $unSalarie["titre_Candidats"];
                $nomSalarie = $unSalarie["nom_Candidats"];
                $prenomSalarie = $unSalarie["prenom_Candidats"];

                echo("<option value='$numSalarie'> $nomSalarie $prenomSalarie </option>");
            }
        ?>
        </datalist>
        <input class="btn btn-secondary display-4" type="submit" style="left:0px;width:13%;font-size:1em"/>
    </form>
    <?php



}



//Accès à l'email depuis la page des besoins ménage/GE des famille
if(lireDonneeUrl("action")=="voirEmailPrefabMenage" || lireDonneeUrl("action")=="voirEmailPrefabGE"){ ?>
    <h2> Création d'un email  </h2>
    <?php if(lireDonneeUrl("action")=="voirEmailPrefabMenage"){
            echo "<form method='post' action='index.php?uc=annuFamille&action=creationEmailPrefabMenage&num=$numFamille'>";
        }
        else{
            echo "<form method='post' action='index.php?uc=annuFamille&action=creationEmailPrefabGE&num=$numFamille'>";
        }
    ?>
        <label for="intervenant"><strong>Choix de l'intervenant : </strong></label>
        <input name="intervenant" list="intervenant">
        <datalist id="intervenant">
            <option value="" selected>Intervenant</option>
            <?php foreach($lesSalaries as $unSalarie){
                $numSalarie = $unSalarie["numSalarie_Intervenants"];
                $titreSalarie = $unSalarie["titre_Candidats"];
                $nomSalarie = $unSalarie["nom_Candidats"];
                $prenomSalarie = $unSalarie["prenom_Candidats"];

                echo("<option value='$numSalarie'> $nomSalarie $prenomSalarie </option>");
            }
        ?>
        </datalist>
        <input class="btn btn-secondary display-4" type="submit" style="position:fixed; bottom:0px; left:0px;width:13%;font-size:2em"/>
    </form>
<?php }




// Création de l'email
if(lireDonneeUrl("action")=="creationEmailPrefabMenage" || lireDonneeUrl("action")=="creationEmailPrefabGE"){
    if(!isset($salarie[0])){
        echo ("<h2> L'intervenant saisie n'as pas été trouvé <h2>");
    }
    else{
        /* Informations sur l'intervenant */
        $nomSalarie = $salarie[0]["nom_Candidats"];             //Nom de famille de l'intervenant
        $prenomSalarie = $salarie[0]["prenom_Candidats"];       //Prenom de l'intervenant
        $titreSalarie = $salarie[0]["titre_Candidats"];         //Titre (Mr ou Mme) de l'intervenant
        $numTelSalarie = $salarie[0]["telPortable_Candidats"];  //Numéro de portable de l'intervenant

        /* Informations sur la famille */
        $nomFamille = $parents[0]["nom_Parents"];          //Nom de famille de la famille

            /* Informations sur la mère */
            $prenomMere = $parents[0]["prenom_Parents"];           //Prenom de la mère
            $emailMere = $parents[0]["email_Parents"];             //Email de la mère
            $numTelMere = $parents[0]["telPortable_Parents"];      //Numéro de portable persos de la mère
           
            /* Informations sur le père */
            if(isset($parents[1])){
                $prenomPere = $parents[1]["prenom_Parents"];       //Prenom du père
                $emailPere = $parents[1]["email_Parents"];         //Email du père
                $numTelPere = $parents[1]["telPortable_Parents"];  //Numéro de portable persos du père
            }
            else{
                $prenomPere = "";       
                $emailPere = "";         
                $numTelPere = "";
            }

            $dateApourvoirPM = explode("-", $famille["Date_aPourvoir_PM"]);        //Date à pourvoir menage
            $dateApourvoirPGE = explode("-", $famille["Date_aPourvoir_PGE"]);      //Date à pourvoir garde d'enfants

            $dateActuelle = explode("-", date('Y-m-d'));         //Date actuelle (celle de l'ordinateur)

            $datePmEstPasse = false;
            if($dateActuelle[0] >= $dateApourvoirPM[0]){
                if($dateActuelle[0] > $dateApourvoirPM[0]){
                    $datePmEstPasse = true;
                }
                else{
                    if($dateActuelle[1] >= $dateApourvoirPM[1]){
                        if($dateActuelle[1] > $dateApourvoirPM[1]){
                            $datePmEstPasse = true;
                        }
                        else{
                            if($dateActuelle[2] >= $dateApourvoirPM[2]){
                                $datePmEstPasse = true;
                            }
                        }
                    }
                }
            }


            $datePGEEstPasse = false;
            if($dateActuelle[0] >= $dateApourvoirPGE[0]){
                if($dateActuelle[0] > $dateApourvoirPGE[0]){
                    $datePGEEstPasse = true;
                }
                else{
                    if($dateActuelle[1] >= $dateApourvoirPGE[1]){
                        if($dateActuelle[1] > $dateApourvoirPGE[1]){
                            $datePGEEstPasse = true;
                        }
                        else{
                            if($dateActuelle[2] >= $dateApourvoirPGE[2]){
                                $datePGEEstPasse = true;  
                            }
                        }
                    }
                }
            }
            
            $arrayMois = array('janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre');
            if($dateApourvoirPM[0] != "0000"){
                $moisPM = $arrayMois[intval($dateApourvoirPM[1]) -1];
            }
            if($dateApourvoirPGE[0] != "0000"){
                $moisPGE = $arrayMois[intval($dateApourvoirPGE[1]) -1];
            }

            if($datePmEstPasse){
                $texteCompareDatePM = "dès à présent.";
            }
            else{
                $texteCompareDatePM = "à partir du ".$dateApourvoirPM[2]." ".$moisPM." ".$dateApourvoirPM[0].".";
            }

            if($datePGEEstPasse){
                $texteCompareDatePGE = "dès à présent.";
            }
            else{
                $texteCompareDatePGE = "à partir du ".$dateApourvoirPGE[2]." ".$moisPGE." ".$dateApourvoirPGE[0].".";
            }

            //Si les 2 parents on email, on envoie au 2 parents : Mr et Mme
            if($emailMere != "" && $emailPere != ""){
                $texteTitreParents = "Mme, Mr" ;
            }
            //Si seul la mère à un email, on envoie à la mère : Mme
            elseif($emailMere != "" && $emailPere == ""){
                $texteTitreParents = "Mme" ;
            }
            //Si seul le père à un email, on envoie au père : Mr
            elseif($emailMere == "" && $emailPere != ""){
                $texteTitreParents = "Mr" ;
            }
            //Si aucun des parents n'as d'email, on met Mme par défaut pour éviter une erreur php
            else{
                $texteTitreParents = "Mme" ;
            }
            
			if($titreSalarie == "MME"){
				$texteTitreSalarie = "Mme";
                $SujetMail = 'E ';
                $term ='e ';
                $deter='la ';
                $Sujet = 'Elle ';
			}
			elseif($titreSalarie == "MR"){
				$texteTitreSalarie = "Mr";
                $SujetMail = ' ';
                $term = ' ';
                $deter = 'le ';
                $Sujet ='Il ';
			}

            

        if(lireDonneeUrl("action")=="creationEmailPrefabMenage"){
            ?>
            <fieldset style="margin-left: 10px;">
                <h3><strong> Informations : </strong></h3> <br/>
                <p> 
                    Email de la mère : <strong><?php echo $emailMere ?> </strong> <br/>
                    Téléphone de la mère : <strong><?php echo $numTelMere ?></strong> <br/>
                    <br/>
                    Email du père : <strong><?php echo $emailPere ?></strong> <br/>
                    Téléphone du père : <strong><?php echo $numTelPere?></strong> </br>

                </p> </br>


                <h3><strong> Sujet du mail : </strong></h3> <br/>
            
                <p>CHAUDOUDOUX : <?php echo $texteTitreParents; ?> <?php  echo $nomFamille ?> : INTERVENANT<?php echo $SujetMail; echo $texteTitreSalarie?> <?php echo $nomSalarie ?> <?php echo mb_strtoupper($prenomSalarie); ?> POUR VOTRE DEMANDE DE PRESTATION MENAGE </p> <br/>

                <h3><strong>Corps du mail : </strong></h3>
                <br/>

                <p> 
                    Bonjour <?php echo $texteTitreParents; ?> <?php echo $nomFamille ?>, <br/><br/>
                    
                    Nous vous proposons <?php echo $texteTitreSalarie?> <?php echo $nomSalarie ?> <?php echo $prenomSalarie ?>, comme intervenant<?php echo$term ?> intéressé<?php echo $term?> par votre demande de prestation ménage <?php echo $texteCompareDatePM ?> <br/><br/>
                    
                    <?php echo $texteTitreSalarie?> <?php echo $nomSalarie ?> peut intervenir dès  .................. <br/><br/>
                    
                    Vous trouverez ci-dessous ses coordonnées : <br/><br/>
                    
                    <u><?php echo $texteTitreSalarie?> <strong><?php echo $nomSalarie ?> <?php echo $prenomSalarie ?></strong></u> <br/>
                    Téléphone : <strong><?php  echo $numTelSalarie ?></strong> <br/><br/>
                    <?php echo $texteTitreSalarie?> <?php echo $nomSalarie ?> vous contacte et vous pouvez également <?php echo $deter ?> contacter, afin de confirmer le début de la prestation Ménage au sein de votre domicile. <br/><br/>
                    En vous souhaitant bonne réception. </br><br/>
                    Bien cordialement, <br/><br/>

                </p>
            </fieldset>

            <?php
        }

        if(lireDonneeUrl("action")=="creationEmailPrefabGE"){
            ?>
            <fieldset style="margin-left: 10px;">
                <h3><strong> Informations : </strong></h3> <br/>
                <p> 
                    Email de la mère : <strong><?php echo $emailMere ?> </strong> <br/>
                    Téléphone de la mère : <strong><?php echo $numTelMere ?></strong> <br/>
                    <br/>
                    Email du père : <strong><?php echo $emailPere ?></strong> <br/>
                    Téléphone du père : <strong><?php echo $numTelPere?></strong> </br>

                </p> </br>

                <h3><strong> Sujet du mail : </strong></h3> <br/>

                <p>CHAUDOUDOUX : <?php echo $texteTitreParents; ?> <?php  echo $nomFamille ?> : INTERVENANT<?php echo $SujetMail?> <?php echo $texteTitreSalarie?> <?php echo $nomSalarie ?> <?php echo mb_strtoupper($prenomSalarie); ?> POUR VOTRE DEMANDE DE GARDE D'ENFANTS </p> <br/>

                <h3><strong>Corps du mail : </strong></h3>
                <br/>

                <p> 
                    Bonjour <?php echo $texteTitreParents; ?> <?php echo $nomFamille ?>, <br/><br/>

                    Nous vous proposons <?php echo $texteTitreSalarie?> <?php echo $nomSalarie ?> <?php echo $prenomSalarie ?>, comme intervenant<?php echo$term ?> intéressé<?php echo $term?> par votre demande de garde d'enfants <?php echo $texteCompareDatePGE ?> <br/><br/>

                    <?php echo $texteTitreSalarie?> <?php echo $nomSalarie ?> a de l'expérience en garde à domicile. <br/><br/>

                    <?php echo $Sujet ?> est disponible pour votre demande le .......... <br/><br/>

                    <strong> <?php echo $Sujet ?> est disponible pour vous rencontrer dès cette semaine. </strong> <br/><br/>

                    Vous trouverez ci-joint ses coordonnées : <br/><br/>

                    <u><?php echo $texteTitreSalarie?> <strong><?php echo $nomSalarie ?> <?php echo $prenomSalarie ?></strong></u> <br/>
                    Téléphone : <strong><?php  echo $numTelSalarie ?></strong> <br/><br/>
                    <?php echo $texteTitreSalarie?> <?php echo $nomSalarie ?> vous contacte et vous pouvez également <?php echo $deter ?> contacter, afin de planifier une rencontre. <br/><br/>
                    En vous souhaitant bonne réception. </br><br/>
                    Bien cordialement, <br/><br/>
                </p>
            </fieldset>




            <?php
        }
    }
}


//Accès à l'email depuis la fiche de l'intervenant
if(lireDonneeUrl("action")=="voirEmailPrefabI"){
    ?>
	<h2> Création d'un email pour l'intervenant </h2> <br/>
		<h4> En ménage :</h4>
		<form method='post' action='index.php?uc=annuFamille&action=creationEmailPrefabIMenage&num=<?php echo $numInterv ?>'>
        <label for="famille"><strong>Choix de la famille : </strong></label>
        <input name="famille" list="famille">
        <datalist id="famille">
            <option value="" selected>Intervenant</option>
        <?php echo json_encode($lesFamilles[0]);
			foreach($lesFamilles as $uneFamille) {
				$numFamille = $uneFamille["numero_Famille"];
				$nom1 = $uneFamille["nom1"];
				$nom2 = $uneFamille["nom2"];
				// Regarde si les noms récupéré sont les même
				if($nom1 != $nom2){
					$noms = $nom1 + $nom2;
				}
				else{
					$noms = $nom1;
				}
				
                echo("<option value='$numFamille'> $noms </option>");
            }
        ?>
        </datalist>
        <input class="btn btn-secondary display-4" type="submit" style="left:0px;width:13%;font-size:1em"/>
    </form>
	
		<h4> En garde d'enfants :</h4>
		<form method='post' action='index.php?uc=annuFamille&action=creationEmailPrefabIGE&num=<?php echo $numInterv ?>'>
        <label for="famille"><strong>Choix de la famille : </strong></label>
        <input name="famille" list="famille">
        <datalist id="famille">
            <option value="" selected>Intervenant</option>
        <?php foreach($lesFamilles as $uneFamille) {
				$numFamille = $uneFamille["numero_Famille"];
				$nomFamille = $uneFamille["nom_Parents"];
				$prenomParents = $uneFamille["prenom_Parents"];

                echo("<option value='$numFamille'> $nomFamille $prenomParents </option>");
            }
        ?>
        </datalist>
        <input class="btn btn-secondary display-4" type="submit" style="left:0px;width:13%;font-size:1em"/>
    </form>
	
	
	
<?php
}

//Accès à l'email depuis la fiche de la famille
if(lireDonneeUrl("action")=="creationEmailPrefabIMenage" || lireDonneeUrl("action")=="creationEmailPrefabIGE"){
	if(!isset($famille)){
        echo ("<h2> La famille saisie n'as pas été trouvé <h2>");
    }
    else{
        /* Informations sur l'intervenant */
        $nomSalarie = $salarie[0]["nom_Candidats"];             //Nom de famille de l'intervenant
        $prenomSalarie = $salarie[0]["prenom_Candidats"];       //Prenom de l'intervenant
        $titreSalarie = $salarie[0]["titre_Candidats"];         //Titre (Mr ou Mme) de l'intervenant
        $numTelSalarie = $salarie[0]["telPortable_Candidats"];  //Numéro de portable de l'intervenant
		$emailSalarie = $salarie[0]["email_Candidats"];

        /* Informations sur la famille */
        $nomFamille = $parents[0]["nom_Parents"];         //Nom de famille de la famille
		$addrFamille = $famille["adresse_Famille"];		  //Adresse
		$cpFamille = $famille['cp_Famille'];			  //Code postal
		$ville = $famille['ville_Famille'];
            
			
		if($titreSalarie == "MME"){
			$texteTitreSalarie = "Mme";
		}
		elseif($titreSalarie == "MR"){
			$texteTitreSalarie = "Mr";
		}
			if(lireDonneeUrl("action")=="creationEmailPrefabIGE"){
            ?>
            <fieldset style="margin-left: 10px;">
                <h3><strong> Informations : </strong></h3> <br/>
                <p> 
                    Email de l'intervenant : <strong><?php echo $emailSalarie ?> </strong> <br/>
                    Téléphone de l'intervenant : <strong><?php echo $numTelSalarie ?></strong> <br/>
                    
                </p> </br>


                <h3><strong> Sujet du mail : </strong></h3> <br/>
            
                <p>CHAUDOUDOUX : <?php echo $texteTitreSalarie; ?> <?php  echo $nomSalarie ?> : GARDE D'ENFANTS FAMILLE <?php echo $nomFamille?></p> <br/>

                <h3><strong>Corps du mail : </strong></h3>
                <br/>

                <p> 
                    Bonjour <?php echo $texteTitreSalarie; ?> <?php echo $nomSalarie ?>, <br/><br/>
                    
                    Comme convenu, vous trouverez ci-joint la fiche de la famille <?php echo $nomFamille ?> concernant la garde de leurs enfants. <br/><br/>
                    
                    <u><strong>Vous pouvez dès à présent contacter la famille pour planifier votre rencontre.</strong></u> <br/><br/>
                    
                    Vous trouverez ci-dessous leurs coordonnées : <br/>
                    
                        <h2 style="font-size:1.3em"><u>Fiche de la famille <b><?php echo $nomFamille.'</u></b> (PRESTATAIRE GARDE D\'ENFANTS)*';?></h2></br>
						
                    La famille habite au <b><?php echo $addrFamille.' '.$cpFamille.' '.$ville; ?></b><br/>
					
                    <b>Parents :</b><br/>
					<?php foreach ($parents as $parent){
						echo $parent['nom_Parents'].' '.$parent['prenom_Parents'].'. Téléphone :<b> '.$parent['telPortable_Parents'].'</b><br/>';
					}?><?php ?>
					
					<b>Enfants :</b><br/> 
					<?php foreach ($enfants as $enfant){
						echo $enfant['nom_Enfants'].' '.$enfant['prenom_Enfants'].' né le '.dateToString($enfant['dateNaiss_Enfants']).'<br/>';
					}?><br/>
					
					La famille <?php echo $nomFamille ?> est <b>PRESTATAIRE EN GARDE D&#146ENFANTS</b>, Chaudoudoux est votre EMPLOYEUR.</br></br>
					
					Dans l'attente des suites de votre rencontre (Jour) et de la date du début de la prestation.</br></br>
					
					Bien cordialement,
                </p>
            </fieldset>

            <?php
			}
			
			if(lireDonneeUrl("action")=="creationEmailPrefabIMenage"){
            ?>
            <fieldset style="margin-left: 10px;">
                <h3><strong> Informations : </strong></h3> <br/>
                <p> 
                    Email de l'intervenant : <strong><?php echo $emailSalarie ?> </strong> <br/>
                    Téléphone de l'intervenant : <strong><?php echo $numTelSalarie ?></strong> <br/>
                    
                </p> </br>

                <h3><strong> Sujet du mail : </strong></h3> <br/>
            
                <p>CHAUDOUDOUX : <?php echo $texteTitreSalarie; ?> <?php  echo $nomSalarie ?> : PRESTATION MÉNAGE FAMILLE <?php echo $nomFamille?></p> <br/>

                <h3><strong>Corps du mail : </strong></h3>
                <br/>

                <p> 
                    Bonjour <?php echo $texteTitreSalarie; ?> <?php echo $nomSalarie ?>, <br/><br/>
                    
                    Comme convenu, vous trouverez ci-joint la fiche de la famille <?php echo $nomFamille ?> concernant leur demande de Prestation Ménage. <br/><br/>
                    
                    <u><strong>Vous pouvez dès à présent contacter la famille pour planifier votre rencontre.</strong></u> <br/><br/>
                    
                    Vous trouverez ci-dessous leurs coordonnées : <br/>
                    
                        <h2 style="font-size:1.3em"><u>Fiche de la famille <b><?php echo $nomFamille.'</u></b> (PRESTATAIRE MÉNAGE)*';?></h2></br>
						
                    La famille habite au <b><?php echo $addrFamille.' '.$cpFamille.' '.$ville; ?></b><br/>
					
                    <b>Parents :</b><br/>
					<?php foreach ($parents as $parent){
						echo $parent['nom_Parents'].' '.$parent['prenom_Parents'].'. Téléphone :<b> '.$parent['telPortable_Parents'].'</b><br/>';
					}?><?php ?>
					
					<b>Enfants :</b><br/> 
					<?php foreach ($enfants as $enfant){
						echo $enfant['nom_Enfants'].' '.$enfant['prenom_Enfants'].' né le '.dateToString($enfant['dateNaiss_Enfants']).'<br/>';
					}?><br/>
					
					La famille <?php echo $nomFamille ?> est <b>PRESTATAIRE EN MÉNAGE</b>, Chaudoudoux est votre EMPLOYEUR.</br></br>
					
					Dans l'attente des suites de votre rencontre (Jour) et de la date du début de la prestation.</br></br>
					
					Bien cordialement,
                </p>
            </fieldset>

            <?php
			}
    }
}
?>