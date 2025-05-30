<body> <!--class="staticPages"-->
<div class="formPages">
	<form id="decision" action="index.php?uc=annuCandid&amp;action=validerDecisionCandid&amp;num=<?php echo $num; ?>" method="post">
                <label for="btnDecision" style='font-size: 2em;'>INTÉGRER CE CANDIDAT ?</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                

                <!--<label for="btnDecision"style='font-size: 2em;'>Oui</label>&nbsp;
                <input type="radio" name="btnDecision" value="oui" checked onchange="changeForm1()"/>
                
                <label for="btnDecision"style='font-size: 2em;'>Non</label>
                <input type="radio" name="btnDecision" value="non" onchange="changeForm1()"/>-->
                
                <label class="container1" for="1" style="font-size:2em"><strong>OUI</strong>
                <input type="radio" id="1" name="btnDecision" value="oui" onchange="changeForm1()" checked>
                <span class="checkmark1" style="margin-top:13px"></span>
                </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                <label class="container1" for="2" style="font-size:2em"><strong>NON</strong>
                <input type="radio" id="2" name="btnDecision" value="non" onchange="changeForm1()">
                <span class="checkmark1" style="margin-top:13px"></span>
                </label>

		<div id="raison" style="display:none;font-size:1.3em">
			<br/>
			<label for="txtRaison"><strong>Pourquoi ? : </strong></label><br>
			<textarea id="txtRaison" name="txtRaison" cols="50" style="height:100px"></textarea>
		</div>
                <div id="ok1" style="display:block;font-size:1.3em">
                    <br/><fieldset>
                        <label for="dateSortie"><strong>Date de sortie : </strong></label>
                        <input type="date" name= "dateSortie"/><br>
                        
                        <!--1 -->
                        <label class="container" for="chkArchive"><strong>Archiver</strong>
                        <input type="checkbox" name="chkArchive" id="chkArchive" value="1">
                        <span class="checkmark"></span>
                        </label><br><br>

                        <label for="tauxH"><strong>Taux horaire : </strong></label>
                        <input type="text" name= "tauxH"/><br>

                        <label for="nbH"><strong>Nombre d'heures par semaine : </strong></label>
                        <input type="text" name= "tauxH"/><br>

                        <!--1 -->
                        <label class="container"for="chkComplH"><strong>Recherche heures complémentaires</strong>
                        <input type="checkbox" name="chkComplH" id="chkComplH" value="1" checked>
                        <span class="checkmark"></span>
                        </label><br>

                        <!--1 -->
                        <label class="container" for="chkPSC1"><strong>PSC1 à proposer ?</strong>
                        <input type="checkbox" name="chkPSC1" id="chkPSC1" value="1">
                        <span class="checkmark"></span>
                        </label><br><br>

                        <label for="travailVoulu"><strong>Enfant / Ménage / Tout</strong>
                          <select name="travailVoulu">
                          <option value="ENFANT">Garde d'enfants</option>
                          <option value="MENAGE">Ménage</option>
                          <option value="TOUT">Tout</option>
                        </select><br>

                        <!--1 -->
                        <label class="container" for="BBmoins3a"><strong>Enfants de moins de 3 ans</strong>
                        <input value="1" type="checkbox" name="BBmoins3a" id="BBmoins3a">
                        <span class="checkmark"></span>
                        </label><br>

                        <!--1 -->
                        <label class="container" for="enfHand"><strong>Enfants handicapés</strong>
                        <input value="1" type="checkbox" name="enfHand" id="enfHand">
                        <span class="checkmark"></span>
                        </label><br>

                        <label class="container" for="repassage"><strong>Repassage</strong>
                        <input value="0" type="hidden" name="repassage">
                        <input value="1" type="checkbox" name="repassage" id="repassage">
                        <span class="checkmark"></span>
                        </label><br>

                        <label for="dispo"><strong>Disponibilités : </strong></label><br>
                        <textarea name="dispo" cols="50" style="height:100px"><?php echo($dispo) ;?></textarea>
                    </fieldset>
                   <?php /*     <label for="justif">Justificatifs</label><br/>
                        <textarea id="justif" cols="50" maxlength="50" rows="2"></textarea>*/?>
                </div>
		<br/>
             <?php /*   <label for="chkemail">Envoyer un email pour donner la réponse</label>
                <input type="checkbox" value="true" name="btnmail" " id="chkemail"/><br/><br/>
                
               
<label for ="txtmail" class="mail" >Corps du message (inutile de signer) :</label><br/><?php
?><textarea id= "txtmail" type="text" class="mail" cols="70" rows ="10" >Madame, Monsieur,
        Suite à votre candidature à la maison des chaudoudoux,

En vous remerciant de votre confiance.</textarea>
 <br/>*/?>
                
	<input class="btn valider btn-secondary" style="position:fixed; bottom:0px;left:0px" type="submit" name="btnValider" value="VALIDER">
        </form>
        
        <button style="position:fixed;bottom:0px;right:0px" class="retour btn" onclick="history.go(-1);">RETOUR</button>
</div>
</body>