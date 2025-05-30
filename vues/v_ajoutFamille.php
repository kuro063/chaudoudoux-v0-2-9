
<?php
// vérification du droit d'accès au cas d'utilisation
if ( ! estConnecte() ) {
    ajouterErreur("L'accès à cette page requiert une authentification !", $tabErreurs);
    include('vues/v_erreurs.php');

    
}
?>
<script type="text/javascript">
  function ajoutEnf() {
    var tableau = document.getElementById("tableEnfant");
    var nblignes = tableau.rows.length;
    var ligne = tableau.insertRow(-1);
    cell = ligne.insertCell(0);
    cell.innerHTML = "<input type=\"text\" class=\"donnees\" name=\"nomEnf"+(nblignes)+"\" size=\"15\">";
    cell = ligne.insertCell(1);
    cell.innerHTML = "<input type=\"text\" class=\"donnees\" name=\"prenomEnf"+(nblignes)+"\" size=\"15\">";
    cell = ligne.insertCell(2);
    cell.innerHTML = "<input type=\"date\" class=\"donnees\" name=\"dateNaiss"+(nblignes)+"\" value=\"\" />";
    cell = ligne.insertCell(3);
    cell.innerHTML = "";
    document.getElementById("nbLigneEnfant").setAttribute("value", tableau.rows.length-1);
  }
</script>



<div id="contenu" style="overflow-x:hidden;padding: 0px 10px 0px 10px;margin-bottom:60px">
    <h1 style="text-align:center">Nouvelle famille</h1>
    <form id="formModifFamille" enctype="multipart/form-data" action="index.php?uc=annuFamille&amp;action=validerAjoutFamille" method="post">
    <div id="corpsForm" style="border:none">
        <fieldset>
        <legend class="alignText">INFORMATIONS ADMINISTRATIVES</legend>
        
            <label for="txtCodCli" style="font-size:1.1em"><strong>Code client (M)*:</strong></label>
  			<input id="txtCodCli" name="txtCodCli" maxlength="20" required value='M'/>
        

    <!-- Mandataire -->
    <div style="border-color: black; display: flex; flex-direction: row; width: 100%">
    <div style="border-color: black; display: flex; flex-direction: column; width: 45%; border: solid black 1px; margin-right: 10%">
         
        <label class="container1" for="chkMand1" style="margin-left:20px;margin-top:20px;font-size:1.1em">Mandataire Régulier
        <input type="radio" name="chkMand" id="chkMand1" value="1"/>
        <span class="checkmark1"></span>
        </label>
        <label class="container1" for="chkMand2" style="margin-left:20px;margin-top:20px;font-size:1.1em">Mandataire Occasionnel
        <input type="radio" name="chkMand" id="chkMand2" value="2"/>
        <span class="checkmark1"></span>
        </label>
        <label class="container1" for="chkMand0" style="margin-left:20px;margin-top:20px;font-size:1.1em">N'EST PAS MANTADAIRE (coché par défaut)
        <input type="radio" name="chkMand" id="chkMand0" value="0" checked/>
        <span class="checkmark1">
        </label></span>
        
                                    

        <p><br>
            <label for="option" style="margin-left:20px;font-size:1.1em">Option : </label>
            <select name="option">
                <option value="" selected>Aucune</option>
                <option value="ADM">ADM</option>
                <option value="FS">Paie</option>
                </select>
        </p>

        <p>
            <label for="sortieMand" style="margin-left:20px;font-size:1.1em"><strong>Date de fin Mandataire :</strong></label>
            <input type="date" name="sortieMand"/>
        </p>
        
    </div> 


    <!-- PRESTATAIRE -->
    <div style="border-color: black;  display: flex; flex-direction: column;width:45%; border: solid black 1px">
    <div style="border-color: black;  display: flex; flex-direction: row;width:100%;">  
                                
        <label class="container" for="chkMen" style="margin-left:20px;margin-top:20px;font-size:1.1em">PRESTATAIRE MENAGE
        <input type="checkbox" name="chkMen" id="chkMen" value="1" />
        <span class="checkmark"></span>
        </label>
                            
        <label class="container" for="chkGE" style="margin-left:20px;margin-top:20px;font-size:1.1em">PRESTATAIRE GARDE D'ENFANTS
        <input type="checkbox" name="chkGE" id="chkGE" value="1"/>
        <span class="checkmark"></span>
        </label>
                                
    </div>

<br>

    <div style=" display: flex; flex-direction: row-reverse;width:100%;margin-left:20px"><div style="width:50%;">
        <p>
            <label for="dateSortiePGE" style="font-size:1.1em"><strong>Date de fin Prestataire GE : </strong></label>
  			<input type='date' id="dateSortiePGE" name="dateSortiePGE" maxlength="20"  />
        </p>
                                
        <div style="display: flex; flex-direction: row;width:100%;">
        <p>
            <label for="txtPge" style="font-size:1.1em">Code :</label>
  			<input id="txtPge" name="txtPge" maxlength="20" size='5' placeholder="PGE" />
        </p>
        </div>
        </div>
                                
        <div style="width:50%;">
        <p>
            <label for="dateSortiePM" style="font-size:1.1em"><strong>Date de fin Prestataire M :</strong></label>
  			<input type='date' id="dateSortiePM" name="dateSortiePM" maxlength="20"  />
        </p>
                                
        <div style="display: flex; flex-direction: row;width:100%;">
        <p>
            <label for="txtPm" style="font-size:1.1em">Code :</label>
            <input id="txtPm" name="txtPm" maxlength="20" size='5' placeholder="PM"  />
        </p>
    </div>
    </div>
    </div>
    </div>
    </div>

        <br>
        <label class="container" for="gardePart">Garde partagée ?
        <input type="checkbox" value="1" name="gardePart" id="gardePart" onclick="afficher1()"/>
        <span class="checkmark"></span>
        </label><br><br>
                                
        <label for="avecPart" id="labgardePartListe">Avec la famille :</label>
        <input name="avecPart" list="avecPart" id="gardePartListe" class="form-control input-sm" style="height:10px; width: 18%"/><!-- CSS Vincent-->

            <datalist id ="avecPart">
                                    
                <option value="" selected>Famille</option>
                <?php foreach ($lesFamilles as $uneFam)
                {
                    $numFam=$uneFam['numero_Famille'];
                    $nomFam=$pdoChaudoudoux->obtenirNomFamille($numFam);
                    echo '<option value="'.$numFam.'">';  echo $nomFam; if($numFam!=9999){echo ' '.$numFam.' ';} echo '</option>';
                }?>
                </datalist>

                <br>

  				<label class="container">ARCHIVE (TOUS TYPES DE PRESTATION)
                <input type="checkbox" name="chkArchive" id="chkArchive" onclick="afficher2()" value="1"/>
                <span class="checkmark"></span>
                </label><br><br>
  				                

                <label for="dateSortie" id="labDateSortie" >Date de sortie : </label>
      			<input class="form-control input-sm" style="height:10px; width: 18%;" type="date" id="dateSortie" min="0000-00-00" name="dateSortie"/>
                <br>

                                
                <p>
  				<label style="font-size: 1.5em;">A pourvoir ? </label>
                <input type="checkbox" id="aPourvoir" style="width: 30px; height: 30px;" name="aPourvoir" value="1" onclick="afficher3()"/>
                </p>
                <div >
                      <p >
                      <label for="MPourvoir" id="labMPourvoir" style="font-size: 1em;">MÉNAGE </label><!--case à cocher pour le ménage -->
                      <input type="checkbox" id="MPourvoir" style="width: 30px; height: 30px;" name="MPourvoir" value="1" onclick="afficher3()"/>
                      <br>
                      <label for="dateMPourvoir" id="labDateMPourvoir" style ="font-size: 1em;">Date à Pourvoir : </label><!--date pour le ménage -->
                      <input type="date" id="dateMPourvoir" class="form-control input-sm" style="height:10px;width: 18%" name="dateMPourvoir" />
                      </p>

                                        <fieldset id="disponibiliteM" class="center" style="width: 55%; margin: 0 auto;">
                <p><strong>DEMANDES DE LA FAMILLE POUR LE MENAGE :</strong></p> 
        

        

                 
        
                <div id='divGlobal'>


<label>Le :&nbsp;</label>
<select id="slctJour" name="slctJourM">
    <option value="jour" selected>Jour</option>
    <option value="sans importance">Sans importance</option>
    <option value="lundi">Lundi</option>
    <option value="mardi">Mardi</option>
    <option value="mercredi">Mercredi</option>
    <option value="jeudi">Jeudi</option>
    <option value="vendredi">Vendredi</option>
    <option value="samedi">Samedi</option>
    <option value="dimanche">Dimanche</option>
</select>
    
de : 
<select name="HdebM">
<?php for ($i=0; $i<24;++$i){?>
        <option value="<?php if($i<10){echo '0'.$i;} else {echo $i;}?>"><?php echo $i;?></option>
        <?php }?>
</select>
<select name="minDebM">
    <option value='00'>00</option>
    <option value='15'>15</option>
    <option value='30'>30</option>
    <option value='45'>45</option>
</select>

à :
<select name="HfinM">
<?php for ($i=0; $i<24;++$i){?>
        <option value="<?php if($i<10){echo '0'.$i;} else {echo $i;}?>"><?php echo $i;?></option>
        <?php }?>
</select>

<select name="minFinM">
    <option value='00'>00</option>
    <option value='15'>15</option>
    <option value='30'>30</option>
    <option value='45'>45</option>
</select>

<label for="frequence">Une semaine sur :</label>
<input name="frequenceM" value="1" size='1' required/>

</div>



<!-- https://code-boxx.com/add-html-code-in-javascript/ -->

<input type="button" id='ajoutC' onclick='ajoutCreneauxM()' value='+'/>
<input type="button" id='suppC' onclick='suppCreneauxM()' value='-'/>


    </fieldset>
                      <p >
                      <label for="GEPourvoir" id="labGEPourvoir" style="font-size: 1em;">GARDE D'ENFANTS </label>
                      <input type="checkbox" id="GEPourvoir" style="width: 30px; height: 30px;" name="GEPourvoir" value="1" onclick="afficher3()"/>
                      <select name="type_prestation" id="type_prestation">
                        <option>Prestataire</option>
                        <option>Mandataire</option>
                      </select>
                      <br>
                      <label for="dateGEPourvoir" id="labDateGEPourvoir" style ="font-size: 1em;">Date à Pourvoir : </label>
                      <input type="date" id="dateGEPourvoir" class="form-control input-sm" style="height:10px;width: 18%" name="dateGEPourvoir" />
                      </p>

                      <style>
                                        /* table, th, td,tr {
                                          border: 1px solid black;
                                        } */
                                        p{
                                          font-size:x-large;
                                        }
                                        .center {
                                         
                                         
                                         clear: left;

                                       }
                                        
                                        </style>
                                        <fieldset id="disponibiliteGE" class="center"  style="width: 55%; margin: 0 auto;">
                                        <p><strong>DEMANDES DE LA FAMILLE POUR LA GARDE D'ENFANTS :</strong></p>
                                        
                                          <div id='divGE'>
                                            
                                          
                                          <label>Le :&nbsp;</label>
                                          <select name="slctJourGE" id="slctJourGE">
                                            <option value="jour" selected>Jour</option>
                                            <option value="sans importance">Sans importance</option>
                                            <option value="lundi">Lundi</option>
                                            <option value="mardi">Mardi</option>
                                            <option value="mercredi">Mercredi</option>
                                            <option value="jeudi">Jeudi</option>
                                            <option value="vendredi">Vendredi</option>
                                            <option value="samedi">Samedi</option>
                                            <option value="dimanche">Dimanche</option>
            

                                          </select>
            
                                            de : 
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
                                            
                                          à :
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
                                          
                                          
                                          
                                          
                                        </div>
                                       
                                        <input type="button" id='ajoutC' onclick='ajoutCreneauxGE()' value='+'/>
                                        <input type="button" id='suppC' onclick='suppCreneauxGE()' value='-'/>
                                      </fieldset>
                    <script>

                      
let idM = 0;
function generateIdM() {
    return ++idM;
}

var ajoutCreneauxM = () => {
  let idM = generateIdM();
  
  var html="<div id='M"+idM+"'>";
  html += "<label>Le :&nbsp;&nbsp;</label>";
  html +="<select name='slctJourM"+idM+"'>";
  html +="<option value='jour' selected>Jour</option>";
  html +="<option value='sans importance'>Sans importance</option>";
  html +="<option value='lundi'>Lundi</option>";
  html +="<option value='mardi'>Mardi</option>";
  html +="<option value='mercredi'>Mercredi</option>";
  html +="<option value='jeudi'>Jeudi</option>";
  html +="<option value='vendredi'>Vendredi</option>";
  html +="<option value='samedi'>Samedi</option>";
  html +="<option value='dimanche'>Dimanche</option>";
  html +="</select> "; 
  html +="de : ";
  let optionsDeb = "";
for (let i = 0; i < 24; i++) {
    optionsDeb += "<option value='" + i + "'>" + i + "</option>";
}
html +=parent.innerHTML = "<select name='HDebM"+idM+"'>" + optionsDeb + "</select> ";
  html +="<select name='minDebM"+idM+"'>";
  html +="<option value='00'>00</option>";
  html +="<option value='15'>15</option>";
  html +="<option value='30'>30</option>";
  html +="<option value='45'>45</option>";
  html +="</select>";
  html +=" à : ";
  let options = "";
for (let i = 0; i < 24; i++) {
    options += "<option value='" + i + "'>" + i + "</option>";
}
html +=parent.innerHTML = "<select name='HfinM"+idM+"'>" + options + "</select> ";

  html +="<select name='minFinM"+idM+"'>";
  html +="<option value='00'>00</option>";
  html +="<option value='15'>15</option>";
  html +="<option value='30'>30</option>";
  html +="<option value='45'>45</option>";
  html +="</select> ";
  html +="<label for='frequence'>Une semaine sur : </label> ";
  html +="<input name='frequenceM"+idM+"' value='1' size='1' required/>";
  html +="</div>";
  
  var divGlobal =document.getElementById('divGlobal');
  divGlobal.innerHTML += html;
  
  
}


    var suppCreneauxM = () =>{

var divId = document.getElementById("M"+idM+"");
console.log(divId);
idM-- ;
console.log(idM);
if (idM===0){
  alert('Vous ne pouvez plus rien effacer');
}
divId.remove();


}

var suppCreneauxGE = () =>{

var divGE = document.getElementById("GE"+idGE+"");
console.log(divGE);
idGE-- ;
console.log(idGE);
if (idGE===0){
  alert('Vous ne pouvez plus rien effacer');
}
divGE.remove();


}

var ajoutCreneauxGE = () => {
  let idGE = generateIdGE();
  
  var html="<div id='GE"+idGE+"'>";
  html += "<label>Le :&nbsp; </label> ";
  html +="<select name='slctJourGE"+idGE+"' name='slctJour"+idGE+"'>";
  html +="<option value='jour' selected>Jour</option>";
  html +="<option value='sans importance'>Sans importance</option>";
  html +="<option value='lundi'>Lundi</option>";
  html +="<option value='mardi'>Mardi</option>";
  html +="<option value='mercredi'>Mercredi</option>";
  html +="<option value='jeudi'>Jeudi</option>";
  html +="<option value='vendredi'>Vendredi</option>";
  html +="<option value='samedi'>Samedi</option>";
  html +="<option value='dimanche'>Dimanche</option>";
  html +="</select> "; 
  html +="de : ";
  let optionsDeb = "";
for (let i = 0; i <= 24; i++) {
    optionsDeb += "<option value='" + i + "'>" + i + "</option>";
}
html +=parent.innerHTML = "<select name='HDebGE"+idGE+"'>" + optionsDeb + "</select> ";
  html +="<select name='minDebGE"+idGE+"'>";
  html +="<option value='00'>00</option>";
  html +="<option value='15'>15</option>";
  html +="<option value='30'>30</option>";
  html +="<option value='45'>45</option>";
  html +="</select> " ;
  html +=" à : ";
  let options = "";
for (let i = 0; i <= 24; i++) {
    options += "<option value='" + i + "'>" + i + "</option>";
}
html +=parent.innerHTML = "<select name='HfinGE"+idGE+"'>" + options + "</select> ";

  html +="<select name='minFinGE"+idGE+"'>";
  html +="<option value='00'>00</option>";
  html +="<option value='15'>15</option>";
  html +="<option value='30'>30</option>";
  html +="<option value='45'>45</option>";
  html +="</select> ";
  html +="<label for='frequence'>Une semaine sur : </label> ";
  html +="<input name='frequenceGE"+idGE+"' value='1' size='1' required/>";
  html +="</div>";
  
  var divGlobal =document.getElementById('divGE');
  divGlobal.innerHTML += html;
  
  
}

let idGE = 0;

function generateIdGE() {
    return ++idGE;
}
      </script>   


                </div>  
            <br>
            <br>

        </fieldset>         
            
            
  		   
            






<!-- DONE -->
        <fieldset>
  			<legend class="alignText">INFORMATIONS DES PARENTS</legend>
  			<br/>
  			<table id="tableParent" class="donnees" style='width :100%'>
            <tr style="width:100%"><th style="width:12.5%">Papa/Maman</th><th style="width:12.5%">Titre</th><th style="width:35%">Nom</th><th style="width:12.5%">Prenom</th><th style="width:12.5%">Tel. portable</th><th style="width:12.5%">Tel. pro</th><th style="width:12.5%">Email</th><th style="width:12.5%">Profession</th></tr>
            <?php
	        $compt = 1;  
	        while ($compt <= 2) {
            ?>
            <tr style="height:50px">
            <td><?php if ($compt==2) echo 'Papa'; elseif ($compt==1) echo 'Maman';?></td><td>
            <select class="donnees" name="newSlctTitreParents<?php echo $compt?>">
              <option value="NONE">-----</option>
              <option value="MR" <?php if ($compt==2) echo 'selected'?>>MR.</option>
              <option value="MME"<?php if ($compt==1) echo 'selected'?>>MME</option>     
            </select>
                    <td class="alignText"><input style="width:100%" type="text" size="25" class="donnees" name="newNomP<?php echo $compt; ?>"></td>
  					<td class="alignText"><input type="text" size="25" class="donnees" name="newPrenomP<?php echo $compt; ?>"></td>
                    <td class="alignText"><input type="text" size="25" class="donnees" name="newTelPort<?php echo $compt; ?>"maxlength="15" onfocusout="VerifNumTel"></td><!-- numero portable pour un parent-->
                    <td class="alignText"><input type="text" size="25" class="donnees" name="newTelPro<?php echo $compt; ?>"maxlength="15" onfocusout="VerifNumTel"></td>
  					<td class="alignText"><input type="text" size="25" class="donnees" name="newEmail<?php echo $compt; ?>"></td>
  					<td class="alignText"><input type="text" size="25" class="donnees" name="newProf<?php echo $compt; ?>"></td>
            </tr>
            <?php
            $compt++;
	        }
            ?>
  			</table>
  				
            <br/>

  		</fieldset>

  			<br/>

  		<fieldset>
  			<legend class="alignText">INFORMATIONS DES ENFANTS</legend>
  			<br/>
  			<table id="tableEnfant" class="donnees"style='width :70%'>
            <tr style="height:50px">
            <th>Nom</th><th>Prenom</th><th>Date de naissance</th><th>Concerné par la garde</th></tr>
                <?php
                $compt = 1; 
                ?>
                <?php for ($i=1; $i<7;++$i){?>
                <tr style="height:50px">
                <td class="alignText"><input  size="25" type="text" class="donnees" name="nomEnf<?php echo $i; ?>"></td>
                <td class="alignText"><input  size="25" type="text" class="donnees" name="prenomEnf<?php echo $i; ?>"></td>
  				<td class="alignText"><input  size="25" type="date" class="donnees" name="dateNaisEnf<?php echo $i; ?>"/></td>
                <td><label class="container">Oui<input type="checkbox" class="donnees" name="concernGarde<?php echo $i;?>" value="1"/><span class="checkmark"></span></label></td>
            </tr>
            <?php }?>
  			</table>

          	<br/>
                        
  		</fieldset>






    	<fieldset>
    		<legend class="alignText">INFORMATIONS DE LA FAMILLE</legend>
                     
                <div style ='display: flex; flex-direction: row'><div style ='display: flex; flex-direction: column; margin-right: 10%; width: 45%'>
                        
  				<p>
  				  	<label for="txtAdr">Adresse : </label>
  				  	<input id="txtAdr" name="txtAdr" maxlength="255" size="40"  />
  				</p>

  				<p>
  				  	<label for="txtVille">Ville : </label>
                    <input list="my-select" type="text" name="txtVille" id="txtVille">

                    <datalist id="my-select"></datalist>
          </p>

                <script>
                    var array =  <?php echo(file_get_contents("./assets/apicommunes/communes.json"));?>;
                    var mySelect = document.getElementById('my-select');
                    
                    for (i = 0; i < array.length; i++){
                        var opt = document.createElement('option');
                        opt.value = (array[i].nom);
                        opt.innerHTML = (array[i].nom);
                    mySelect.appendChild(opt);
                    }
                </script>
                    

  				<p>
  				  	<label for="txtCp">Code postal : </label>
  				  	<input  id="txtCp" list="my--select" name="txtCp" size="5" maxlength="5" pattern="^[0-9]{5}$" />

                    <datalist id="my--select"></datalist>
  				</p>
                  <script>
                    var array =  <?php echo(file_get_contents("./assets/apicommunes/communes.json"));?>;
                    var menuVilles = document.getElementById("txtVille");
                    menuVilles.addEventListener("blur", function() {
                        removeCp();
                        obtCp();
                    });

                        var mySelect = document.getElementById('my--select');

                    function removeCp(){
                        var options = mySelect.querySelectorAll("option");
                        for (o = options.length-1 ; o>=0 ; o--) {
                            mySelect.removeChild(options[o]);
                        } 
                        document.getElementById('txtCp').value = "";
                   }

                    function obtCp(){
                        var ville = document.getElementById("txtVille").value;
                        for (i = 0; i < array.length; i++){
                            if (array[i].nom == ville){
                                if( array[i].codesPostaux.length == 1){
                                    document.getElementById("txtCp").value = array[i].codesPostaux[0];
                                } else {
                                    for (u = 0; u < array[i].codesPostaux.length ; u++) {
                                        var opt = document.createElement('option');
                                        opt.value = (array[i].codesPostaux[u]);
                                        opt.innerHTML = (array[i].codesPostaux[u]);
                                        mySelect.appendChild(opt);
                                    }
                                }
                                
                            }   
                        }
                    }
                  </script>


          <p>
            <label for='secteurFamille'> Secteur de Rennes (centre) : </label>
            <select name="slctSecteur">
              <option value="Aucun" selected>AUCUN</option>
              <option value="Nord">NORD</option>
              <!-- <option value="Nord-Est">Nord Est</option> -->
              <option value="Est">EST</option>
              <!-- <option value="Sud-Est">Sud Est</option> -->
              <option value="Sud">SUD</option>
              <!--<option value="Sud-Ouest">Sud Ouest</option> -->
              <option value="Ouest">OUEST</option>
              <!--<option value="Nord-Ouest">Nord Ouest</option> -->
            </select>
          </p>

  				<p>
  				  	<label for="txtQuart">Quartier : </label>
  				  	<input id="txtQuart" name="txtQuart"  size="20"  />
  				</p>
  
  				<p>
  				  	<label for="txtFixe">Téléphone domicile : </label>
  				  	<input id="txtFixe" name="txtFixe" maxlength="15" size="10" onfocusout="VerifNumTel()"  />
  				</p>
  				<p>
                    <label class="container" for="chkVehicule">Véhicule nécessaire
      				<input type="checkbox" name="chkVehicule" id="chkVehicule" value="1"/>
                    <span class="checkmark"></span>
                    </label>
    			</p>
                <p>
                    <label class="container" for="enfHand">Enfant handicapé dans la famille 
                    <input type="checkbox" name="enfHand" id="enfHand" value='1'/>
                    <span class="checkmark"></span>
                    </label>
                </p>
                <p>
                    <label for="txtQuart">Observations / demandes :</label><br>
                    <textarea id="txtObs" name="txtObs"  cols="70" ></textarea>
                    </p> </div><div style ='display: flex; flex-direction: column; width:45%'>
    			<p>
      				<label for="txtBus">Ligne de bus : </label>
      				<input type="text" id="txtBus" name="txtBus"/>
    			</p>
                <p>
      				<label for="arretBus">Arrêt de bus : </label>
      				<input type="text" id="arretBus" name="arretBus"/>
    			</p>
                <p>
      				<label for="dateEntree">Date d'entrée : </label>
      				<input type="date" id="dateEntree" name="dateEntree"  />
    			</p>
    			<p>
                    <label for="modePaiement">Mode de paiement : </label>
                    <select name="modePaiement">
                        <option value="CHEQUE">CHEQUE</option>
                        <option value="PRELEVEMENT">PRELEVEMENT</option>
                        <option value="CESU">CESU</option>
                    </select>
                </p>
                <p>
  				  	<label for="txtNumAlloc">N° CAF : </label>
  				  	<input id="txtNumAlloc" name="txtNumAlloc" maxlength="20">
  				</p>
  				<p>
  				  	<label for="txtNumURSSAF">N° URSSAF : </label>
  				  	<input id="txtNumURSSAF" name="txtNumURSSAF" maxlength="20">
  				</p>
    			<p>
      				<label class="container" for="chkAG">Participe à l'assemblée générale
      				<input type="checkbox" name="chkAG" id="chkAG" value="1">
                    <span class="checkmark"></span>
                    </label>
                </p>
                <p>
                    <label for="txtQuart">Remarques :</label><br>
                    <textarea id="txtRemarques" name="txtRemarques" cols="70"></textarea>
                </p>
                </div>
  			                          <?php /*<fieldset>
                            <legend>Ajout de documents</legend>
                            <?php for($i=0;$i<10;$i++){
                                if ($i%2==0){echo '<br/>';}?>                                
                            <input type="file" name="<?php echo $i;?>"/><?php }?><br/>
                            <label for="Fiche_Famille">Fiche famille</label>
                            <input type="file" name="Fiche_Famille"/>
                            </fieldset>*/?>
    </div>
            </fieldset>












<!-- DONE -->
<fieldset>
    <legend class="alignText">DESCRIPTION DU DOMICILE</legend>
    <!--<div style ='display: flex; flex-direction: column'>
    <div style ='display: flex; flex-direction: row; width: 100%'>-->
    <div class="align-text">
    <strong>
    
    <label class="container1" for="maison">MAISON
    <input type="radio" id="maison" name="typeLogement" value="MAISON" checked>
    <span class="checkmark1"></span>
    </label>
    
    <br>
   
    <label class="container1" for="appart">APPARTEMENT
    <input type="radio" id="appart" name="typeLogement" value="APPARTEMENT">
    <span class="checkmark1"></span>
    </label>
    </strong>
    <br>

    
    <label for="superficie">Superficie du logement (en m²):</label>
    <input size="1" name="superficie"/>

    <br>
          

    
    <label for="nbEtages">Nombre d'étages :</label>
    <input size="1" name="nbEtages"/>
    

    <br>
                                
    
    <label for="nbChambres">Nombre de chambres :</label>
    <input size="1" name="nbChambres"/>
    
    <br>
        

    <!--</div><div style ='display: flex; flex-direction: row; width: 100%'>-->
        
    
    <label for="nbSDB">Nombre de salles de bain </label>
    <input size="1" name="nbSDB"/>
    
    <br>

    
    <label for="nbSani">Nombre de sanitaires :</label>
    <input size="1" name="nbSani"/>
    

    <br>

                       
    <label class="container" for="repassage">Repassage
    <input type="checkbox" name="repassage" id="repassage" value="1"/>
    <span class="checkmark"></span>
    </label>
    

    <br>

    
    <!--</div>
    </div>-->
    </div>
    </fieldset>   	

    <p>
    	<input class="btn valider btn-secondary"  type="submit" name="btnValider" style="left:0px;bottom:0px;position:fixed" value="AJOUTER"/>
    </p>	

    <p>
        <button style="position:fixed;bottom:0px;right:0%" class="retour btn" onclick="history.go(-1);">RETOUR</button>
    </p>

</form>
</div>

<script>
afficher1();
afficher2();
afficher3();

function afficher1() {
  valeur = document.getElementById("gardePart").checked;

  if (valeur == true) {        
    document.getElementById("gardePartListe").hidden = false;
    document.getElementById("labgardePartListe").hidden = false;
    document.getElementById("txtavec").value = "";
  } else {
    document.getElementById("gardePartListe").hidden = true;
    document.getElementById("labgardePartListe").hidden = true;
  }
}
function afficher2() {
  valeur = document.getElementById("chkArchive").checked;

  if (valeur == true) {        
    document.getElementById("dateSortie").hidden = false;
    document.getElementById("labDateSortie").hidden = false;
    document.getElementById("dateSortie").value = "";
  } else {
    document.getElementById("dateSortie").hidden = true;
    document.getElementById("labDateSortie").hidden = true;
  }
}
function afficher3() {//fonction pour l'affichage des options de à pourvoir
  valeur = document.getElementById("aPourvoir").checked;
  valeurM = document.getElementById("MPourvoir").checked;
  valeurGE = document.getElementById("GEPourvoir").checked;
  document.getElementById("disponibiliteM").hidden = true;
  document.getElementById("disponibiliteGE").hidden = true;

  if (valeur == true) {        
    document.getElementById("MPourvoir").hidden = false;
    document.getElementById("labMPourvoir").hidden = false;
    document.getElementById("GEPourvoir").hidden = false;
    document.getElementById("labGEPourvoir").hidden = false;
    if (valeurM == true) {
      document.getElementById("labDateMPourvoir").hidden = false;
      document.getElementById("dateMPourvoir").hidden = false;
      document.getElementById("disponibiliteM").hidden = false; //tableau pour le menage

    }
    else {
      document.getElementById("dateMPourvoir").hidden = true;
      document.getElementById("labDateMPourvoir").hidden = true;
      document.getElementById("disponibiliteM").hidden = true;

    }
    if (valeurGE == true) {
      document.getElementById("labDateGEPourvoir").hidden = false;
      document.getElementById("dateGEPourvoir").hidden = false;
      document.getElementById("type_prestation").hidden = false;
      document.getElementById("disponibiliteGE").hidden = false;
    }
    else {
      document.getElementById("dateGEPourvoir").hidden = true;
      document.getElementById("labDateGEPourvoir").hidden = true;
      document.getElementById("type_prestation").hidden = true;
      document.getElementById("disponibiliteGE").hidden = true;

    }
    
    
  } else {
    document.getElementById("MPourvoir").hidden = true;
    document.getElementById("MPourvoir").checked = false;
    document.getElementById("labMPourvoir").hidden = true;
    document.getElementById("GEPourvoir").hidden = true;
    document.getElementById("GEPourvoir").checked = false;
    document.getElementById("labGEPourvoir").hidden = true;
    document.getElementById("dateMPourvoir").hidden = true;
    document.getElementById("dateMPourvoir").value = "";
    document.getElementById("labDateMPourvoir").hidden = true;
    document.getElementById("dateGEPourvoir").hidden = true;
    document.getElementById("dateGEPourvoir").value = "";
    document.getElementById("labDateGEPourvoir").hidden = true;
    document.getElementById("type_prestation").hidden = true;
    document.getElementById("disponibiliteGE").hidden = true;

  }
}
function checkboxJour(){
  //Boutons checkbox 
  document.getElementById("lundiMatinGE");
  document.getElementById("lundiMidiGE");
  document.getElementById("lundiSoirGE");

  document.getElementById("mardiMatinGE");
  document.getElementById("mardiMidiGE");
  document.getElementById("mardiSoirGE");

  document.getElementById("mercrediMatinGE");
  document.getElementById("mercrediMidiGE");
  document.getElementById("mercrediSoirGE");

  document.getElementById("jeudiMatinGE");
  document.getElementById("jeudiMidiGE");
  document.getElementById("jeudiSoirGE");

  document.getElementById("mercrediMatinGE").checked;
  document.getElementById("mercrediMidiGE");
  document.getElementById("mercrediSoirGE");

  document.getElementById("jeudiMatinGE");
  document.getElementById("jeudiMidiGE");
  document.getElementById("jeudiSoirGE");

  document.getElementById("vendrediMatinGE");
  document.getElementById("vendrediMidiGE");
  document.getElementById("vendrediSoirGE");

  document.getElementById("samediMatinGE");
  document.getElementById("samediMidiGE");
  document.getElementById("samediSoirGE");

  // Garde d'enfants
  document.getElementById("lundiMatinGE");
  document.getElementById("lundiMidiGE");
  document.getElementById("lundiSoirGE");

  document.getElementById("mardiMatinGE");
  document.getElementById("mardiMidiGE");
  document.getElementById("mardiSoirGE");

  document.getElementById("mercrediMatinGE");
  document.getElementById("mercrediMidiGE");
  document.getElementById("mercrediSoirGE");

  document.getElementById("jeudiMatinGE");
  document.getElementById("jeudiMidiGE");
  document.getElementById("jeudiSoirGE");

  document.getElementById("mercrediMatinGE").checked;
  document.getElementById("mercrediMidiGE");
  document.getElementById("mercrediSoirGE");

  document.getElementById("jeudiMatinGE");
  document.getElementById("jeudiMidiGE");
  document.getElementById("jeudiSoirGE");

  document.getElementById("vendrediMatinGE");
  document.getElementById("vendrediMidiGE");
  document.getElementById("vendrediSoirGE");

  document.getElementById("samediMatinGE");
  document.getElementById("samediMidiGE");
  document.getElementById("samediSoirGE");

  

}
</script>