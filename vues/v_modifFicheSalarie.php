<?php
/* @var $nom string */
/* @var $prenom string */
/* @var $libOption string */
/* @var $adr string */
/* @var $codePostal string */
/* @var $ville string */
/* @var $tel string */
/* @var $email string */

?>
<!-- Division pour le contenu principal -->
    <div id="contenu">
      
      <h2>Fiche de <?php echo filtreChainePourNavig(strtoupper($nom)) ; ?>&nbsp;<?php echo filtreChainePourNavig($prenom) ; ?></h2>
      <form id="frmPerso" action="index.php?uc=annuSalarie&amp;action=validerModifSalarie&amp;num=<?php echo $num; ?>" method="post">
<?php
        if ( nbErreurs($tabErreurs) != 0 ) {
          echo toHtmlErreurs($tabErreurs);
        } 
 ?>
<?php
        if ( !empty($messageInfo) ) {?>
            <p class="info"><?php echo $messageInfo; ?></p>
<?php   } 

$dateEntree = new DateTime($dateEntree);
$dateSortie = new DateTime($dateSortie);
 ?>
  <div id="corpsForm">
  <fieldset>
    <legend>Coordonées personnelles</legend>
  <p>
    <label for="txtAdr">Adresse : </label>
    <input id="txtAdr" name="txtAdr" maxlength="255" size="70" value="<?php echo filtreChainePourNavig($adresse) ; ?>" />
  </p>

  <p>
    <label for="txtCp">Code postal : </label>
    <input id="txtCp" name="txtCp" maxlength="5" size="5" value="<?php echo filtreChainePourNavig($cp) ; ?>" />
  </p>
  <p>
    <label for="txtVille">Ville : </label>
    <input id="txtVille" name="txtVille" maxlength="100" size="60" value="<?php echo filtreChainePourNavig($ville) ; ?>" />
  </p>
  <p>
    <label for="txtQuart">Quartier : </label>
    <input id="txtQuart" name="txtQuart" maxlength="100" size="60" value="<?php echo filtreChainePourNavig($quartier) ; ?>" />
  </p>
  <p>
    <label for="txtPort">Téléphone portable : </label>
    <input id="txtPort" name="txtPort" maxlength="15" size="15" value="<?php echo filtreChainePourNavig($telPort) ; ?>" pattern="^([0-9]{2}.){4}[0-9]{2}$"/>
  </p>
  <p>
    <label for="txtFixe">Téléphone fixe : </label>
    <input id="txtFixe" name="txtFixe" maxlength="15" size="15" value="<?php echo filtreChainePourNavig($telFixe) ; ?>" pattern="^([0-9]{2}.){4}[0-9]{2}$"/>
  </p>
  <p>
    <label for="txtUrg">Téléphone en cas d'urgences : </label>
    <input id="txtUrg" name="txtUrg" maxlength="15" size="15" value="<?php echo filtreChainePourNavig($telUrg) ; ?>" pattern="^([0-9]{2}.){4}[0-9]{2}$" />
  </p>
  <p>
    <label for="txtEmail" accesskey="t">E-mail : </label>
    <input id="txtEmail" name="txtEmail" size="30" value="<?php echo filtreChainePourNavig($email) ; ?>" />
  </p>
  </fieldset>
  <br/> </div></div>
  

  <fieldset>
    <legend>Informations professionnelles</legend>
    <p>
      <label for="txtID">Numéro salarié : </label>
      <input type="text" id="txtID" name="txtID"  cols="10" value="<?php echo filtreChainePourNavig($idSalarie) ; ?>"/>
    </p>
    <p>
    <p>
      <label for="slctStatPro">Statut professionnel : </label>
      <select id="slctStatPro" name="slctStatPro">
        <option value="ETUDIANT" <?php if($statutPro == "ETUDIANT") echo "selected";?> >Etudiant</option>
        <option value="PROFESSIONNEL" <?php if($statutPro == "PROFESSIONNEL") echo "selected";?> >Professionnel</option>
        <option value="PRO <26ans" <?php if($statutPro == "PRO <26ans") echo "selected";?> >Pro <26ans</option>
      </select>
    </p>
    <p>
      <label for="txtDip">Diplômes : </label>
      <textarea id="txtDip" name="txtDip"  cols="70" ><?php echo filtreChainePourNavig($diplomes) ; ?></textarea>
    </p>
    <p>
      <label for="txtQualifs">Qualifications : </label>
      <textarea id="txtQualifs" name="txtQualifs"  cols="70" ><?php echo filtreChainePourNavig($qualifs) ; ?></textarea>
    </p>
    <p>
      <label for="txtCertifs">Certifications : </label>
      <textarea id="txtCertifs" name="txtCertifs"  cols="70" ><?php echo filtreChainePourNavig($certifs) ; ?></textarea>
    </p>
    <p>
      <label for="chkExp1a">Expérience avec les bébés de moins de trois ans :</label>
      <input type="checkbox" id="chkExp1a" name="chkExp1a" value="1" 
      <?php if ( $expBBmoins1a == 1 ) echo 'checked="checked"'; ?> />
    </p>
    <br/>
    <p>
      <label for="chkEnfHand">Garde d'enfants handicapés :</label>
      <input type="checkbox" id="chkEnfHand" name="chkEnfHand" value="1" 
      <?php if ( $enfantHand == 1 ) echo 'checked="checked"'; ?> />
    </p>
    <p>
      <label for="txtDispo">Disponibilités : </label>
      <textarea id="txtDispo" name="txtDispo"  cols="70" ><?php echo filtreChainePourNavig($dispo) ; ?></textarea>
    </p>
    <p>
      <label for="dateEntree">Date d'entrée : </label>
      <input type="date" id="dateEntree" name="dateEntree" value="<?php echo filtreChainePourNavig($dateEntree->format('Y-m-d')) ; ?>" />
    </p>
    <p>
      <label for="dateSortie">Date de sortie : </label>
      <input type="date" id="dateSortie" name="dateSortie" value="<?php echo filtreChainePourNavig($dateSortie->format('Y-m-d')) ; ?>" />
    </p>
    <p>
      <label for="txtTauxH">Taux Horaire demandé : </label>
      <input id="txtTauxH" name="txtTauxH" maxlength="5" size="5" value="<?php echo filtreChainePourNavig($tauxH) ; ?>" />
    </p>
    <p>
      <label for="nbHsem">Nombre d'heures par semaines : </label>
      <input id="nbHsem" name="nbHsem" maxlength="5" size="5" value="<?php echo filtreChainePourNavig($nbHeureSem) ; ?>" />
    </p>
    <p>
      <label for="nbHmois">Nombre d'heures par mois : </label>
      <input id="nbHmois" name="nbHmois" maxlength="5" size="5" value="<?php echo filtreChainePourNavig($nbHeureMois) ; ?>" />
    </p>
    <p>
      <label for="chkComplH">Recherche compléments d'heures :</label>
      <input type="checkbox" id="chkComplH" name="chkComplH" value="1" 
      <?php if ( $rechCompl == 1 ) echo 'checked="checked"'; ?> />
    </p>
    <p>
      <label for="chkPSC1">PSC1 à proposer :</label>
      <input type="checkbox" id="chkPSC1" name="chkPSC1" value="1" 
      <?php if ( $psc1 == 1 ) echo 'checked="checked"'; ?> />
    </p>
  </fieldset>
  <br/>
  <fieldset>
    <legend>Autres informations</legend>
    <p>
      <label for="slctSitFam">Situation familiale : </label>
      <select id="slctSitFam" name="slctSiteFam">
        <option value="CELIB" <?php if($sitFam == "CELIB") echo "selected";?> >Célibataire</option>
        <option value="COUPL" <?php if($sitFam == "COUPL") echo "selected";?> >En couple</option>
        <option value="MAR" <?php if($sitFam == "MAR") echo "selected";?> >Marié(e)</option>
        <option value="PACS" <?php if($sitFam == "PACS") echo "selected";?> >Pacsé(e)</option>
        <option value="VEUF" <?php if($sitFam == "VEUF") echo "selected";?> >Veuf(ve)</option>
      </select>
    </p>
    <p>
      <label for="chkPermis">Permis :</label>
      <input type="checkbox" id="chkPermis" name="chkPermis" value="1" 
      <?php if ( $permis == 1 ) echo 'checked="checked"'; ?> />
    </p>
    <p>
      <label for="chkVehicule">Vehicule :</label>
      <input type="checkbox" id="chkVehicule" name="chkVehicule" value="1" 
      <?php if ( $vehicule == 1 ) echo 'checked="checked"'; ?> />
    </p>
    <p>
      <label for="txtJustifs">Justificatifs : </label>
      <textarea id="txtJustifs" name="txtJustifs" rows="2" cols="70"><?php echo filtreChainePourNavig($justifs) ; ?></textarea>
    </p>
    <p>
      <label for="txtObs">Observations : </label>
      <textarea id="txtObs" name="txtObs" rows="2" cols="70"><?php echo filtreChainePourNavig($observ) ; ?></textarea>
    </p>
  </fieldset>
  </div><fieldset id="disponibiliteGE" style="display: flex; flex-direction: column; margin-left: 10%; width: 45%">
       
        
                    <legend><strong>DISPONIBILITES :</legend></p>
                    
                      <div id='divGE'>
                        
                      
                      <label>Le : &nbsp; </label>
                      <select name="slctJourGE" id="slctJourGE">
                        <option value="jour" selected>Jour</option>
                        <option value="lundi">Lundi</option>
                        <option value="mardi">Mardi</option>
                        <option value="mercredi">Mercredi</option>
                        <option value="jeudi">Jeudi</option>
                        <option value="vendredi">Vendredi</option>
                        <option value="samedi">Samedi</option>
                        <option value="dimanche">Dimanche</option>
                      </select>
                      <label>de : &nbsp; </label>
                        <select name="HdebGE">
                        <?php for ($i=0; $i<24;++$i){?>
                        <option value="<?php if($i<10){echo '0'.$i;} else {echo $i;}?>"><?php echo $i;?></option>
                        <?php }?>
                        </select>
                        
                        <select name="minDebGE">
                            <option value='00'>00</option>
                            <option value='15'>15</option>
                            <option value='30'>30</option>
                            <option value='45'>45</option>
                        </select>
                        
                        <label>à : &nbsp; </label>
                      <select name="HfinGE">
                      <?php for ($i=0; $i<24;++$i){?>
                          <option value="<?php if($i<10){echo '0'.$i;} else {echo $i;}?>"><?php echo $i;?></option>
                      <?php }?>
                      </select>
                      
                      <select name="minFinGE">
                          <option value='00'>00</option>
                          <option value='15'>15</option>
                          <option value='30'>30</option>
                          <option value='45'>45</option>
                      </select>
                      
                      <label for="frequenceGE">Une semaine sur :</label>
                      <input name="frequenceGE" value="1" size='1' required/>
                      
                      <label for='modalitesGE'>Modalités :</label>         
                      <textarea maxlength="200" name="modalitesGE"></textarea>
                      <input type="button" onclick='resetGE()' value="Réinitialiser"/>
                      
                      
                      
                    </div>
                    
                    <input type="button" id='ajoutC' onclick='ajoutCreneauxGE()' value='+'/>
                    <input type="button" id='suppC' onclick='suppCreneauxGE()' value='-'/>
                      </fieldset>
              </div>  
  <div id="piedForm">
  <p>
      <input id="cmdOk" type="submit" value="OK" />
  </p> 
  </div>
  </form>
</div>      