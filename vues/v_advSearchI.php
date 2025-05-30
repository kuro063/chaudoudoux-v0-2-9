<?php
if (estConnecte()){
?>

<!--<div id="contenu">

<div id="search">-->


<!--<div id="filtreFam">	
	<form id="formFam" action="index.php?uc=search&amp;action=resAdvSearch&amp;categ=Famille" method="post">	
		
			Nom :<input type="text" name="txtName">
			Code client :<input type="radio" id="btnCodeCli" name="btnCodeCli" value="oui" onchange="codeCli()"><label>Oui</label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id="btnCodeCli" name="btnCodeCli" value="non" onchange="codeCli()"><label>Non</label>&nbsp;&nbsp;&nbsp;&nbsp;<br/><input style="display: none" id="txtCodCli" name="txtCodCli" maxlength="20" />
			Ville :<input type="text" name="txtVille">
			Prestataire / Mandataire :
				<select name="slctPrestMand">
						<option value="">-----</option>
						<option value="PREST">Prestataire</option>
						<option value="MAND">Mandataire</option>
					</select>
			Prestation :
				<select name="slctPresta">
						<option value="">-----</option>
						<option value="ENFA">Garde d'enfants</option>
						<option value="MENA">Ménage</option>
					</select>
			Régularité :
				<select name="slctRegul">
						<option value="">-----</option>
						<option value="OCC">Occasionnel</option>
						<option value="REG">Régulier</option>
					</select>
			Vehicule : <input type="radio" name="btnVeh" value="1"><label>Oui</label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="btnVeh" value="0"><label>Non</label>&nbsp;&nbsp;&nbsp;&nbsp;
			
		
		<input type="submit" value="Rechercher"/>
	</form>
</div>-->
<!--<div id="filtreInterv" >-->
<body>
<h1 style="text-align:center">Recherche Avancée - Intervenants</h1>
<div style="text-align:center; margin-top:5%">	
	<form id="fromInterv" action="index.php?uc=search&amp;action=resAdvSearchI&amp;categ=Interv" method="post">
        <fieldset><strong>


		<p>
				<label class="container1" for="SPETD">INTERVENANT PRESTATAIRE
					<input type="radio" name="DB" id="SPETD" value="1">
					<span class="checkmark1"></span>
				</label>&nbsp;&nbsp;
					
				<label class="container1" for="SPPRO">INTERVENANT MANDATAIRE
					<input type="radio" name="DB" id="SPPRO" value="0">
					<span class="checkmark1"></span>
				</label>&nbsp;&nbsp;

				<label class="container1" for="SPPI">INDIFFÉRENT
					<input type="radio" name="DB" id="SPPI" value="" checked>
					<span class="checkmark1"></span>
				</label> <br/><br/>
			</p>   
				<!-- modifier le 24/05/2021 -->

		<p>TRAVAIL SELON LA FICHE INTERVENANT :<br/>

		        <label class="container1" for="EMTEU">ENFANTS (uniquement)
					<input type="radio" name="EMT" id="EMTEU" value="ENFANTuni">
					<span class="checkmark1"></span>
				</label>&nbsp;&nbsp;

				<label class="container1" for="EMTET">ENFANTS (et tout)
					<input type="radio" name="EMT" id="EMTET" value="ENFANTtout">
					<span class="checkmark1"></span>
				</label>&nbsp;&nbsp;

				<label class="container1" for="EMTMU">MÉNAGE (uniquement)
					<input type="radio" name="EMT" id="EMTMU" value="MENAGEuni">
					<span class="checkmark1"></span>
				</label>&nbsp;&nbsp;

				<label class="container1" for="EMTMT">MÉNAGE (et tout)
					<input type="radio" name="EMT" id="EMTMT" value="MENAGEtout">
					<span class="checkmark1"></span>
				</label>&nbsp;&nbsp;

				<label class="container1" for="EMTT">TOUT (enfants et ménage)
					<input type="radio" name="EMT" id="EMTT" value="TOUT">
					<span class="checkmark1"></span>
				</label>&nbsp;&nbsp;

				<label class="container1" for="EMTPI">INDIFFÉRENT
					<input type="radio" name="EMT" id="EMTPI" value="" checked>
					<span class="checkmark1"></span>
				</label>
				<!--
				<input type="radio" id="EMTE" name="EMT" value="ENFANT"/><label for="EMTE">Enfants</label>&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="radio" name="EMT" value="MENAGE" id="EMTM"/><label for="EMTM">Ménage</label>&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="radio" name="EMT" id="EMTT" checked value="TOUT"><label for="EMTT">Tout</label>&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="radio" name="EMT" id="EMTPI" checked value=""><label for="EMTPI">Indifférent</label>&nbsp;&nbsp;&nbsp;&nbsp;
				-->
			</p>

			<p> PLANNING ACTUEL :<br/>
				<label class="container1" for="TCenfa"> ENFANT (et tout)
					<input type="radio" name="TC" id="TCenfa" value="ENFA">
					<span class="checkmark1"></span>
				</label>&nbsp;&nbsp;
					
				<label class="container1" for="TCmena"> MENAGE (et tout)
					<input type="radio" name="TC" id="TCmena" value="MENA">
					<span class="checkmark1"></span>
				</label>&nbsp;&nbsp;

				<label class="container1" for="TCindi">INDIFFÉRENT
					<input type="radio" name="TC" id="TCindi" value="" checked>
					<span class="checkmark1"></span>
				</label>
			</p>

            <p>A DE L'EXPÉRIENCE AVEC LES ENFANTS DE MOINS DE 3 ANS :<br/>
				<label class="container1" for="expoui">OUI
					<input type="radio" name="btnExp" id="expoui" value="1">
					<span class="checkmark1"></span>
				</label>&nbsp;&nbsp;
					
				<label class="container1" for="expnon">NON
					<input type="radio" name="btnExp" id="expnon" value="0">
					<span class="checkmark1"></span>
				</label>&nbsp;&nbsp;

				<label class="container1" for="expPI">INDIFFÉRENT
					<input type="radio" name="btnExp" id="expPI" value="" checked>
					<span class="checkmark1"></span>
				</label>

				<!--
				<input type="radio" name="btnExp" id="expoui" value="1"/><label for="expoui">Oui</label>&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="radio" name="btnExp" id="expnon" value="0"/><label for="expnon">Non</label>&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="radio" name="btnExp" id="expPI" value="" checked/><label for="expPI">Indifférent</label>&nbsp;&nbsp;&nbsp;&nbsp;
				-->
			</p>

            <p>S'OCCUPE D'ENFANTS HANDICAPÉS :<br/>
				<label class="container1" for="handoui">OUI
					<input type="radio" name="btnEnfHand" id="handoui" value="1">
					<span class="checkmark1"></span>
				</label>&nbsp;&nbsp;
					
				<label class="container1" for="handnon">NON
					<input type="radio" name="btnEnfHand" id="handnon" value="0">
					<span class="checkmark1"></span>
				</label>&nbsp;&nbsp;
					
				<label class="container1" for="handpi">INDIFFÉRENT
					<input type="radio" name="btnEnfHand" id="handpi" value="" checked>
					<span class="checkmark1"></span>
				</label>

				<!--
				<input type="radio" name="btnEnfHand" id="handoui" value="1"/><label for="handoui">Oui</label>&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="radio" name="btnEnfHand" id="handnon" value="0"/><label for="handnon">Non</label>&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="radio" name="btnEnfHand" id="handpi" value="" checked/><label for="handpi">Indifférent</label>&nbsp;&nbsp;&nbsp;&nbsp;
				-->
			</p>

				<!--
				<input type="radio" name="btnRennes" id="rennesoui" value="1"/><label for="rennesoui">Oui</label>&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="radio" name="btnRennes" id="rennesnon" value="0"/><label for="rennesnon">Non</label>&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="radio" name="btnRennes" id="rennespi" value="" checked /><label for="rennespi">Indifférent</label>&nbsp;&nbsp;&nbsp;&nbsp;
				-->
			</p>

			<p>POSSÈDE UN VÉHICULE :<br/>
				<label class="container1" for="vehoui">OUI
					<input type="radio" name="btnVeh" id="vehoui" value="1">
					<span class="checkmark1"></span>
				</label>&nbsp;&nbsp;

				<label class="container1" for="vehnon">NON
					<input type="radio" name="btnVeh" id="vehnon" value="0">
					<span class="checkmark1"></span>
				</label>&nbsp;&nbsp;

				<label class="container1" for="vehPI">INDIFFÉRENT
					<input type="radio" name="btnVeh" id="vehPI" value="" checked>
					<span class="checkmark1"></span>
				</label>

			<!--
			<input type="radio" name="btnVeh" id="vehoui" value="1"/><label for="vehoui">Oui</label>&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="radio" name="btnVeh" id="vehnon" value="0"/><label for="vehnon">Non</label>&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="radio" name="btnVeh" id="vehPI" checked value=""><label for="vehPI">Indifférent</label>&nbsp;&nbsp;&nbsp;&nbsp;
			-->
			</p>

			<p>EST EN RECHERCHE DE COMPLÉMENT :<br/>
				<label class="container1" for="rechoui">OUI
					<input type="radio" name="rechCompl" id="rechoui" value="1">
					<span class="checkmark1"></span>
				</label>&nbsp;&nbsp;
			
				<label class="container1" for="rechnon">NON
					<input type="radio" name="rechCompl" id="rechnon" value="0">
					<span class="checkmark1"></span>
				</label>&nbsp;&nbsp;

				<label class="container1" for="rechPI">INDIFFÉRENT
					<input type="radio" name="rechCompl" id="rechPI" value="" checked>
					<span class="checkmark1"></span>
				</label>

				<!--
				<input type="radio" id="rechoui" name="btnRech" value="1"/><label for="rechoui">Oui</label>&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="radio" name="btnRech" value="0" id="rechnon"/><label for="rechnon">Non</label>&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="radio" name="btnRech" id="rechPI" checked value=""><label for="rechPI">Indifférent</label>&nbsp;&nbsp;&nbsp;&nbsp;
				-->
			</p>

			<p>STATUT PROFESSIONNELLE :<br/>
				<label class="container1" for="SPET">ETUDIANT
					<input type="radio" name="SP" id="SPET" value="1">
					<span class="checkmark1"></span>
				</label>&nbsp;&nbsp;
					
				<label class="container1" for="SPPO">PROFESSIONNELLE
					<input type="radio" name="SP" id="SPPO" value="0">
					<span class="checkmark1"></span>
				</label>&nbsp;&nbsp;

				<label class="container1" for="SPI">INDIFFÉRENT
					<input type="radio" name="SP" id="SPI" value="" checked>
					<span class="checkmark1"></span>
				</label> 
			</p>   
				<!-- modifier le 24/05/2021 -->

				<p>SITUATION FAMILIALE :<br/>
				<label class="container1" for="CELI">CELIBATAIRE
					<input type="radio" name="SF" id="CELI" value="CELIBATAIRE">
					<span class="checkmark1"></span>
				</label>&nbsp;&nbsp;
					
				<label class="container1" for="MARIE">MARIE
					<input type="radio" name="SF" id="MARIE" value="MARIE">
					<span class="checkmark1"></span>
				</label>&nbsp;&nbsp;

				<label class="container1" for="COUP">EN COUPLE
					<input type="radio" name="SF" id="COUP" value="EN COUPLE">
					<span class="checkmark1"></span>
				</label>&nbsp;&nbsp;
				
				<label class="container1" for="VEU">VEUF
					<input type="radio" name="SF" id="VEU" value="VEUF">
					<span class="checkmark1"></span>
				</label>&nbsp;&nbsp;
				
				<label class="container1" for="PACSE">PACSE
					<input type="radio" name="SF" id="PACSE" value="PACSE">
					<span class="checkmark1"></span>
				</label>&nbsp;&nbsp;

				<label class="container1" for="SFPI">INDIFFÉRENT
					<input type="radio" name="SF" id="SFPI" value="" checked>
					<span class="checkmark1"></span>
				</label> 
			</p>   
				<!-- modifier le 24/05/2021 -->




			<p>PERMIS :<br/>
				<label class="container1" for="PSoui">OUI
					<input type="radio" name="PS" id="PSoui" value="1">
					<span class="checkmark1"></span>
				</label>&nbsp;&nbsp;
					
				<label class="container1" for="PSnon">NON
					<input type="radio" name="PS" id="PSnon" value="0">
					<span class="checkmark1"></span>
				</label>&nbsp;&nbsp;

				<label class="container1" for="PSPI">INDIFFÉRENT
					<input type="radio" name="PS" id="PSPI" value="" checked>
					<span class="checkmark1"></span>
				</label> 
			</p>   
				<!-- modifier le 24/05/2021 -->


			<p>MUTUELLE :<br/>
				<label class="container1" for="Mutoui">OUI
					<input type="radio" name="Mut" id="Mutoui" value="1">
					<span class="checkmark1"></span>
				</label>&nbsp;&nbsp;
					
				<label class="container1" for="Mutnon">NON
					<input type="radio" name="Mut" id="Mutnon" value="0">
					<span class="checkmark1"></span>
				</label>&nbsp;&nbsp;

				<label class="container1" for="MutCMU">CMU
					<input type="radio" name="Mut" id="MutCMU" value="CMU">
					<span class="checkmark1"></span>
				</label>

				<label class="container1" for="MUTPI">INDIFFÉRENT
					<input type="radio" name="Mut" id="MUTPI" value="" checked>
					<span class="checkmark1"></span>
				</label>
			</p>
				<!-- modifier le 20/05/2021 -->


			<p>INTERVENANTS ARCHIVÉ :<br/>
				<label class="container1" for="IAoui">OUI
					<input type="radio" name="IA" id="IAoui" value="1">
					<span class="checkmark1"></span>
				</label>&nbsp;&nbsp;
					
				<label class="container1" for="IAnon">NON
					<input type="radio" name="IA" id="IAnon" value="0" checked>
					<span class="checkmark1"></span>
				</label>&nbsp;&nbsp;

				<label class="container1" for="IAPI">INDIFFÉRENT
					<input type="radio" name="IA" id="IAPI" value="">
					<span class="checkmark1"></span>
				</label> 
			</p>   
				<!-- modifier le 20/05/2021 -->

				<form name="name_du_form">
    				
				<p>HABITE À RENNES : <br/> <br/> 
						<label class="container1" for="HARoui">OUI
       						<input type="radio" name="btnRennes" id="HARoui" value="1" onclick="debloquer()">
							<span class="checkmark1"></span>
      					</label>&nbsp;&nbsp;
  
						<label class="container1" for="HARnon">NON
        					<input type="radio" name="btnRennes" id="HARnon" value="0" onclick="bloquer()">
							<span class="checkmark1"></span>
        				</label>&nbsp;&nbsp;
    				
						<label class="container1" for="HARINDI">INDIFFÉRENT
        					<input autocomplete='off' type="radio" name="btnRennes" id="HARINDI" value="" checked="checked" onclick="bloquer()">
							<span class="checkmark1"></span>
        				</label>
					</p>


					<div  id="codepostal" hidden>
					
    				<p>CODE POSTAL :  <br/>
						<label class="container1" for="CP35000">35000
        					<input type="radio" name="CP" id="CP35000" value="1">
							<span class="checkmark1"></span>
        				</label>&nbsp;&nbsp;
    				
						<label class="container1" for="CP35200">35200
        					<input type="radio" name="CP" id="CP35200" value="2">
							<span class="checkmark1"></span>
        				</label>&nbsp;&nbsp;
    				
						<label class="container1" for="CP35700">35700
        					<input type="radio" name="CP" id="CP35700" value="3">
							<span class="checkmark1"></span>
						</label>&nbsp;&nbsp;
    				
						<label class="container1" for="CPINDI">INDIFFÉRENT
        					<input type="radio" name="CP" id="CPINDI" value="" checked="checked">
							<span class="checkmark1"></span>
        				</label>
    				
					</p>
					</div>
					<input type="checkbox" id="checkRP" onclick="afficher2()" style="width:30px;height:30px">
					<label for="checkRP" style="text-transform: uppercase;"> recherche sur l'état civil de l'intervenant </label> <br>

					<div id="RP" hidden>

					<p>TITRE :<br/>
					<label class="container1" for="TitreMr">MR
						<input type="radio" name="titre" id="TitreMr" value="MR">
						<span class="checkmark1"></span>
					</label>&nbsp;&nbsp;
					
					<label class="container1" for="TitreMme">MME
						<input type="radio" name="titre" id="TitreMme" value="MME" >
						<span class="checkmark1"></span>
					</label>&nbsp;&nbsp;

					<label class="container1" for="TitreI">INDIFFÉRENT
						<input type="radio" name="titre" id="TitreI" value="" checked>
						<span class="checkmark1"></span>
					</label> 
					</p> 

					<p>NOM :<br/>
					<label class="container1" for="NonContient">Contient : 
						<input type="radio" name="nom" id="NonContient" value="1" onclick="document.getElementById('NomRecherche').hidden=false">
						<span class="checkmark1"></span>
					</label>
					<input id="NomRecherche" name="NomRecherche" hidden>
					&nbsp;&nbsp;

					<label class="container1" for="nomI">INDIFFÉRENT
						<input type="radio" name="nom" id="nomI" value="" checked onclick="document.getElementById('NomRecherche').hidden=true">
						<span class="checkmark1"></span>
					</label> 
					</p> 

					<p>PRENOM :<br/>
					<label class="container1" for="PrenonContient">Contient : 
						<input type="radio" name="prenom" id="PrenonContient" value="1" onclick="document.getElementById('PrenomRecherche').hidden=false">
						<span class="checkmark1"></span>
					</label>
					<input id="PrenomRecherche" name="PrenomRecherche" hidden>
					&nbsp;&nbsp;

					<label class="container1" for="prenomI">INDIFFÉRENT
						<input type="radio" name="prenom" id="prenomI" value="" checked onclick="document.getElementById('PrenomRecherche').hidden=true">
						<span class="checkmark1"></span>
					</label> 
					</p> 

					<p>AGE :<br/>
					<label class="container1" for="Age-20">moin de 22 ans
						<input type="radio" name="age" id="Age-20" value="1">
						<span class="checkmark1"></span>
					</label>&nbsp;&nbsp;
					
					<label class="container1" for="Age+22-50"> de 22 ans à 50 ans
						<input type="radio" name="age" id="Age+22-50" value="2" >
						<span class="checkmark1"></span>
					</label>&nbsp;&nbsp;

					<label class="container1" for="Age+50"> plus de 50 ans
						<input type="radio" name="age" id="Age+50" value="3" >
						<span class="checkmark1"></span>
					</label>&nbsp;&nbsp;

					<label class="container1" for="AgeI">INDIFFÉRENT
						<input type="radio" name="age" id="AgeI" value="" checked>
						<span class="checkmark1"></span>
					</label> 
					</p> 
					
					<p>LIEU DE NAISSANCE :<br/>
					<label class="container1" for="lieuNaissContient">Contient : 
						<input type="radio" name="lieuNaiss" id="lieuNaissContient" value="1" onclick="document.getElementById('lieuNaissRecherche').hidden=false;document.getElementById('lieuNaissNERecherche').hidden=true;">
						<span class="checkmark1"></span>
					</label>
					<input id="lieuNaissRecherche" name="lieuNaissRecherche" hidden>
					&nbsp;&nbsp;
					<label class="container1" for="lieuNaissNEContient">NE Contient PAS : 
						<input type="radio" name="lieuNaiss" id="lieuNaissNEContient" value="0" onclick="document.getElementById('lieuNaissNERecherche').hidden=false;document.getElementById('lieuNaissRecherche').hidden=true;">
						<span class="checkmark1"></span>
					</label>
					<input id="lieuNaissNERecherche" name="lieuNaissNERecherche" hidden>
					&nbsp;&nbsp;

					<label class="container1" for="lieuNaissI">INDIFFÉRENT
						<input type="radio" name="lieuNaiss" id="lieuNaissI" value="" checked onclick="document.getElementById('lieuNaissRecherche').hidden=true;document.getElementById('lieuNaissNERecherche').hidden=true;">
						<span class="checkmark1"></span>
					</label> <br>
					Fournie? &nbsp;&nbsp;
					<label class="container1" for="lieuNaissFOui">oui : 
						<input type="radio" name="lieuNaissF" id="lieuNaissFOui" value="1">
						<span class="checkmark1"></span>
					</label>
					&nbsp;&nbsp;
					<label class="container1" for="lieuNaissFNon">non : 
						<input type="radio" name="lieuNaissF" id="lieuNaissFNon" value="0">
						<span class="checkmark1"></span>
					</label>
					&nbsp;&nbsp;
					<label class="container1" for="lieuNaissFI">INDIFFÉRENT
						<input type="radio" name="lieuNaissF" id="lieuNaissFI" value="" checked>
						<span class="checkmark1"></span>
					</label> 
					</p> 
				
					<p>PAYS DE NAISSANCE :<br/>
					<label class="container1" for="paysNaissContient">Contient : 
						<input type="radio" name="paysNaiss" id="paysNaissContient" value="1" onclick="document.getElementById('paysNaissRecherche').hidden=false">
						<span class="checkmark1"></span>
					</label>
					<input id="paysNaissRecherche" name="paysNaissRecherche" hidden>
					&nbsp;&nbsp;

					<label class="container1" for="paysNaissNEContient">NE Contient PAS : 
						<input type="radio" name="paysNaiss" id="paysNaissNEContient" value="0" onclick="document.getElementById('paysNaissNERecherche').hidden=false;document.getElementById('lieuNaissRecherche').hidden=true;">
						<span class="checkmark1"></span>
					</label>
					<input id="paysNaissNERecherche" name="paysNaissNERecherche" hidden>
					&nbsp;&nbsp;

					<label class="container1" for="paysNaissI">INDIFFÉRENT
						<input type="radio" name="paysNaiss" id="paysNaissI" value="" checked onclick="document.getElementById('paysNaissRecherche').hidden=true">
						<span class="checkmark1"></span>
					</label> 
					<br>
					Fournie? &nbsp;&nbsp;
					<label class="container1" for="paysNaissFOui">oui : 
						<input type="radio" name="paysNaissF" id="paysNaissFOui" value="1">
						<span class="checkmark1"></span>
					</label>
					&nbsp;&nbsp;
					<label class="container1" for="paysNaissFNon">non : 
						<input type="radio" name="paysNaissF" id="paysNaissFNon" value="0">
						<span class="checkmark1"></span>
					</label>
					&nbsp;&nbsp;
					<label class="container1" for="paysNaissFI">INDIFFÉRENT
						<input type="radio" name="paysNaissF" id="paysNaissFI" value="" checked>
						<span class="checkmark1"></span>
					</label> 
					</p> 
					</div>
					<input type="checkbox" id="checkRA" onclick="afficher()" style="width:30px;height:30px"> <label for="checkRA" style="text-transform: uppercase;"> recherche approfondie </label> <br>
                    <div id="RA" hidden>
                        <select id="listChampI" name="listChampI" onchange="afficherOption()">
                        <?php 
                            foreach($lesChamps as $unChamp) { ?>
                                <option value="<?php echo $unChamp["COLUMN_NAME"]; ?>-<?php echo $unChamp["COLUMN_TYPE"]; ?>">
                                    <?php echo $unChamp["COLUMN_NAME"]; ?>
								</option>
							<?php } ?>
						</select>
						<input id="cherchetxt" name="cherchetxt">
						<input type="date" id="cherchedate" name="cherchedate" hidden>
						<select id="cherchebin" name="cherchebin" hidden>
							<option value="1">
								oui
							</option>
                            <option value="0">
                                non
                            </option>
                        </select>
						<br>
						<br>
						MOIS DE MODIFICATION DU PLANNING
						<select id="modifplanning" name="modifplanning">
						<option value="">
							INDIFFÉRENT
                        </option>
						<?php
						$moisactuel = date('Y-m');
						for ($i = 0; $i <= 12; $i++){
							$mois = date('Y-m', strtotime($moisactuel.' -'.$i.' month')); ?> 
							<option value="<?php echo $mois ?>"> 
								<?php echo $mois; ?> 
							</option> 
						<?php } ?>
						</select>
						<br>
						MOIS DE MODIFICATION DE LA FICHE INTERVENANT
						<select id="modiffiche" name="modiffiche">
						<option value="">
							INDIFFÉRENT
                        </option>
						<?php
						$moisactuel = date('Y-m');
						for ($i = 0; $i <= 12; $i++){ ?> 
							<option value="<?php echo date('M Y', strtotime($moisactuel.' -'.$i.' month')) ?>"> 
								<?php echo date('Y-m', strtotime($moisactuel.' -'.$i.' month')); ?> 
							</option> 
						<?php } ?>
						</select>
						<br>
                    </div>
				</form>
        	<input class="btn valider btn-secondary" type="submit" value="RECHERCHER"/>
		</fieldset></strong>
	</form>

	<!--<p>
 		<a class="btn retour" href="index.php?uc=annuSalarie&action=tousIntervenants">RETOUR</a>
	</p>-->

	<button style="position:fixed;bottom:0px;right:0px" class="retour btn" onclick="history.go(-1);">RETOUR</button>

</div>
<script type="text/javascript">
	function debloquer(){
		document.getElementById("codepostal").hidden = false;
	}

    function bloquer(){
		document.getElementById("codepostal").hidden = true;
		document.getElementById("CPINDI").checked = true;
	}
	function afficher(){
        valeur = document.getElementById('checkRA').checked;
        if (valeur == true) {
            document.getElementById('RA').hidden = false;
        } else {
            document.getElementById('RA').hidden = true;
        }
    }
	function afficher2(){
        valeur = document.getElementById('checkRP').checked;
        if (valeur == true) {
            document.getElementById('RP').hidden = false;
        } else {
            document.getElementById('RP').hidden = true;
        }
    }
    function afficherOption() {
        var valeur = document.getElementById('listChampI').value.split("-");
        if (valeur[1] == "date" || valeur[1] == "datetime"){
            document.getElementById('cherchedate').hidden = false;
            document.getElementById('cherchetxt').hidden = true;
            document.getElementById('cherchebin').hidden = true;
        } else if (valeur[1] == "tinyint(1)"){
            document.getElementById('cherchebin').hidden = false;
            document.getElementById('cherchetxt').hidden = true;
            document.getElementById('cherchedate').hidden = true;
        } else {
            document.getElementById('cherchetxt').hidden = false;
            document.getElementById('cherchedate').hidden = true;
            document.getElementById('cherchebin').hidden = true;
        }
	}
</script>
</body>


    <!--<div id="filtreCandid" style="display:none;">
	<form id="formCandid" action="index.php?uc=search&amp;action=resAdvSearch&amp;categ=Candid" method="post">
		
		Nom :<input type="text" name="txtName">
		Prénom :<input type="text" name="txtPrenom">
		Nationalité :<input type="text" name="txtNatio"/>
		N° de Sécurité Sociale :<input type="text" name="txtNumSS" cols="25"/>
		Ville :<input type="text" name="txtVille">
		Quartier :<input type="text" name="txtQuart">
		Diplôme :<input type="text" name="txtDip">
		Qualifications :<input type="text" name="txtQualif">
		Expériences avec les bébés de moins d'un an : <input type="radio" name="btnExp" value="1"><label>Oui</label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="btnExp" value="0"><label>Non</label>&nbsp;&nbsp;&nbsp;&nbsp;
		Enfants handicapés : <input type="radio" name="btnEnfHand" value="1"><label>Oui</label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="btnEnfHand" value="0"><label>Non</label>&nbsp;&nbsp;&nbsp;&nbsp;
		Disponibilité : <input type="text" name="txtDispo">
		Permis : <input type="radio" name="btnPerm" value="1"><label>Oui</label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="btnPerm" value="0"><label>Non</label>&nbsp;&nbsp;&nbsp;&nbsp;
		Vehicule : <input type="radio" name="btnVeh" value="1"><label>Oui</label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="btnVeh" value="0"><label>Non</label>&nbsp;&nbsp;&nbsp;&nbsp;
		
		<input type="submit" value="Rechercher"/>
	</form>
</div>-->

<?php	
}
?>