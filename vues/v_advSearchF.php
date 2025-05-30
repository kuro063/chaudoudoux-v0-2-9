<?php
if (estConnecte()){
?>

<body>
<h1 style="text-align:center">Recherche Avancée - FAMILLES <br/> </h1>
<div style="text-align:center; margin-top:5%">
    <form id ="fromFamille" action="index.php?uc=search&amp;action=resAdvSearchF&amp;categ=Interv" method="post">
    <fieldset><strong>





		<p>
				<label class="container1" for="famiPREST">FAMILLE PRESTATAIRE
					<input type="radio" name="typeFamille" id="famiPREST" value="0">
					<span class="checkmark1"></span>
				</label>&nbsp;&nbsp;
				<label class="container1" for="famiMAND">FAMILLE MANDATAIRE
					<input type="radio" name="typeFamille" id="famiMAND" value="1">
					<span class="checkmark1"></span>
				</label>&nbsp;&nbsp;
				<label class="container1" for="famiINDIF">INDIFFÉRENT
					<input type="radio" name="typeFamille" id="famiINDIF" value="" checked>
					<span class="checkmark1"></span>
				</label> <br/><br/>
			</p>

			<p>	INTERVENTION ACTUELLE :<br/>
				<label class="container1" for="besoinGE"> GARDE D'ENFANTS
					<input type="radio" name="besoinFamille" id="besoinGE" value="0">
					<span class="checkmark1"></span>
				</label>&nbsp;&nbsp;
				<label class="container1" for="besoinM"> MENAGE
					<input type="radio" name="besoinFamille" id="besoinM" value="1">
					<span class="checkmark1"></span>
				</label>&nbsp;&nbsp;
				<label class="container1" for="besoinINDIF">INDIFFÉRENT
					<input type="radio" name="besoinFamille" id="besoinINDIF" value="" checked>
					<span class="checkmark1"></span>
				</label>
			</p>


		<p>AGE DE L'ENFANT :<br/>
				<label class="container1" for="ageMOIN1">MOIN DE 1 ANS
					<input type="radio" name="ageEnfant" id="ageMOIN1" value="0">
					<span class="checkmark1"></span>
				</label>&nbsp;&nbsp;
				<label class="container1" for="ageMOIN3">MOIN DE 3 ANS
					<input type="radio" name="ageEnfant" id="ageMOIN3" value="1">
					<span class="checkmark1"></span>
				</label>&nbsp;&nbsp;
				<label class="container1" for="agePLUS3">PLUS DE 3 ANS
					<input type="radio" name="ageEnfant" id="agePLUS3" value="2">
					<span class="checkmark1"></span>
				</label>&nbsp;&nbsp;
				<label class="container1" for="ageINDIF">INDIFFÉRENT
					<input type="radio" name="ageEnfant" id="ageINDIF" value="" checked>
					<span class="checkmark1"></span>
				</label>
			<br>
			date
		<select id="date" name="date">
			<option value="">
				AUJOURD'HUI
            </option>
			<?php
			$anneeactuel = date('Y');
			for ($i = 0; $i <= 10; $i++){
				$annee = date('Y', strtotime($anneeactuel.' -'.$i.' year')); ?> 
				<option value="<?php echo $annee ?>"> 
					<?php echo $annee; ?> 
				</option> 
			<?php } ?>
		</select>
		</p>


		<p>GARDE PARTAGÉE :<br/>
				<label class="container1" for="partagOUI">OUI
					<input type="radio" name="partageFamille" id="partagOUI" value="1">
					<span class="checkmark1"></span>
				</label>&nbsp;&nbsp;
				<label class="container1" for="partagNON">NON
					<input type="radio" name="partageFamille" id="partagNON" value="0">
					<span class="checkmark1"></span>
				</label>&nbsp;&nbsp;
				<label class="container1" for="partagINDIF">INDIFFÉRENT
					<input type="radio" name="partageFamille" id="partagINDIF" value="" checked>
					<span class="checkmark1"></span>
				</label>
			</p>


		<p>TYPE DE LOGEMENT :<br>
	    		<label class="container1" for="logementMAISON">MAISON
	    			<input type="radio" name="logementFamille" id="logementMAISON" value="0">
	    			<span class="checkmark1"></span>
	    		</label>&nbsp;&nbsp;
	    		<label class="container1" for="logementAPPART">APPARTEMENT
	    			<input type="radio" name="logementFamille" id="logementAPPART" value="1">
	    			<span class="checkmark1"></span>
	    		</label>&nbsp;&nbsp;
                <label class="container1" for="logementINDIF">INDIFFÉRENT
	    			<input type="radio" name="logementFamille" id="logementINDIF" value="" checked>
	    			<span class="checkmark1"></span>
                </label> <br/>
	    	</p>   

				<p> SUPERFICIE :<br/>
				<label class="container1" for="moin50Famille">MOIN DE 50M²
					<input type="radio" name="superficieFamille" id="moin50Famille" value="0">
					<span class="checkmark1"></span>
				</label>&nbsp;&nbsp;
				<label class="container1" for="entre50et100Famille">ENTRE 50M² ET 100M²
					<input type="radio" name="superficieFamille" id="entre50et100Famille" value="1">
					<span class="checkmark1"></span>
				</label>&nbsp;&nbsp;
				<label class="container1" for="entre100et150Famille">ENTRE 100M² ET 150M²
					<input type="radio" name="superficieFamille" id="entre100et150Famille" value="2">
					<span class="checkmark1"></span>
				</label>&nbsp;&nbsp;
				<label class="container1" for="plus150Famille">PLUS DE 150M²
					<input type="radio" name="superficieFamille" id="plus150Famille" value="3">
					<span class="checkmark1"></span>
				</label>&nbsp;&nbsp;
				<label class="container1" for="rennesINDIF">INDIFFÉRENT
					<input type="radio" name="superficieFamille" id="rennesINDIF" value="" checked>
					<span class="checkmark1"></span>
				</label>&nbsp;&nbsp;
			</p>



			<p>DEMANDE UN VÉHICULE :<br>
	    		<label class="container1" for="vehiculeOUI">OUI
	    			<input type="radio" name="vehiculeFamille" id="vehiculeOUI" value="0">
	    			<span class="checkmark1"></span>
	    		</label>&nbsp;&nbsp;
	    		<label class="container1" for="vehiculeNON">NON
	    			<input type="radio" name="vehiculeFamille" id="vehiculeNON" value="1">
	    			<span class="checkmark1"></span>
	    		</label>&nbsp;&nbsp;
                <label class="container1" for="vehiculeINDIF">INDIFFÉRENT
	    			<input type="radio" name="vehiculeFamille" id="vehiculeINDIF" value="" checked>
	    			<span class="checkmark1"></span>
                </label> <br/>
	    	</p>

			<p>FAMILLE ARCHIVER :<br>
	    		<label class="container1" for="archiveOUI">OUI
	    			<input type="radio" name="archiveFamille" id="archiveOUI" value="0">
	    			<span class="checkmark1"></span>
	    		</label>&nbsp;&nbsp;
	    		<label class="container1" for="archiveNON">NON
	    			<input type="radio" name="archiveFamille" id="archiveNON" value="1" checked>
	    			<span class="checkmark1"></span>
	    		</label>&nbsp;&nbsp;
                <label class="container1" for="archiveINDIF">INDIFFÉRENT
	    			<input type="radio" name="archiveFamille" id="archiveINDIF" value="">
	    			<span class="checkmark1"></span>
                </label> <br/>
	    	</p>


			<p>VILLE ET CODE POSTAL :<br>
				<select id="listVilleF" name="listVilleF">
				<option value="0-0">
                    AUCUN CHOIX
				</option>
                	<?php 
                    foreach($lesVilles as $uneVille) { ?>
                        <option value="<?php echo $uneVille["ville_Famille"]; ?>-<?php echo $uneVille["cp_Famille"]; ?>">
                            <?php echo $uneVille["ville_Famille"] ; echo " "; echo $uneVille["cp_Famille"]; ?>
						</option>
					<?php } ?>
				</select>
	    	</p>

			<input type="checkbox" id="checkRA" onclick="afficher()"> recherche approfondie <br>
                    <div id="RA" hidden>
                        <select id="listChampF" name="listChampF" onchange="afficherOption()">
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
                    </div>

            <input class="btn valider btn-secondary" type="submit" value="RECHERCHER"/>
		</fieldset></strong>
	</form>

    <button style="position:fixed;bottom:0px;right:0px" class="retour btn" onclick="history.go(-1);">RETOUR</button>

</div>
<script type="text/javascript">
	function afficher(){
        valeur = document.getElementById('checkRA').checked;
        if (valeur == true) {
            document.getElementById('RA').hidden = false;
        } else {
            document.getElementById('RA').hidden = true;
        }
    }
    function afficherOption() {
        var valeur = document.getElementById('listChampF').value.split("-");
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

<?php
}
?>
